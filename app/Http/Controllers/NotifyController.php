<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use App\Models\BillType;
use App\Models\Bill;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\PhoneBillOrder;
use App\Services\BillService;
use App\Services\UserOrder;
use App\Services\MarketService;

class NotifyController extends Controller

{
    /**
     * 微信支付回调
     */
    public function wechatNotify(Request $request,BillService $billService){
        Log::info('支付回调===>');
        $app = Factory::payment(config('wechat.payment.default'));
        $response =  $app->handlePaidNotify(function($message, $fail) use($billService){
            // 查到订单
            // Log::info($message);
            $order = PhoneBillOrder::where('bill_app_order_id',$message['out_trade_no'])->first();
            if (!$order || $order->bill_status == 1) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // if($order && $order->bill_status  != 0){
            //     //此处表示订单状态已经改变过了，不清楚原因设为异常订单
            //     $status = 9;
            //     $msg = '非法调用回调方法，订单状态为：'.$order->bill_status;
            //     $order->changeStatus($status,$msg);
            //     return true;
            // }

            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            // Log::info($message);
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    $status = 1;
                    $msg = false;
                // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    $status = 3;
                    $msg = '支付回调失败';
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }
            $is_success = $order->changeStatus($status,$msg);
            if($order->bill_status == 1 && $is_success){
                $order->bill_wx_order_id = $message['transaction_id'];
                $order->save();
                //用户已付款，进行平台订单对接
                $billService->mobileBill($order->id);
            }
            return true; // 返回处理完成
        });
        
        return $response;
    }

    /**
     * 微信退款回调
     */
    public function wechatRebackNotify(Request $request){
        Log::info('退款回调===>');
        $app = Factory::payment(config('wechat.payment.default'));
        $response = $app->handleRefundedNotify(function ($message, $reqInfo, $fail) {
            // 其中 $message['req_info'] 获取到的是加密信息
            // $reqInfo 为 message['req_info'] 解密后的信息
            // Log::info($message);
            // Log::info($reqInfo);
            $order = PhoneBillOrder::where('bill_app_order_id',$reqInfo['out_trade_no'])->first();
            if (!$order || $order->bill_status == 7) { // 如果订单不存在 或者 订单已经退过款了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // if($order && $order->bill_status  != 6){
            //     $status = 9;
            //     $msg = '非法调用退款回调方法，请检查订单状态：'.$order->bill_status;
            //     $order->changeStatus($status,$msg);
            //     return true;
            // }

            if($message['return_code']=='SUCCESS'){
                $update_data = [];
                if(array_get($reqInfo, 'refund_status') === 'SUCCESS'){
                    $status = 7;
                    $msg = '';
                }elseif((array_get($reqInfo, 'refund_status') === 'FAIL')){
                    $status = 8;
                    $msg = '退款回调失败';
                }
            }else{
                return $fail('通信失败，请稍后再通知我');
            }
            $order->changeStatus($status,$msg);
            return true;
        });

        return $response;
    }

    /**
     * 话费充值回调
     */
    public function billNotify(Request $request,BillService $billService,MarketService $marketService){
        Log::info('充值回调===>');
        $data = $request->all();
        if($request->get('downstreamSerialno') && $request->get('status')){
            $order = PhoneBillOrder::where('bill_app_order_id',$data['downstreamSerialno'])->first();
            if (!$order || $order->bill_status == 3) { // 如果订单不存在 或者 已经充值完成
                return 'SUCCESS'; 
            }
            if($order && $order->bill_status  != 5){
                $status = 9;
                $msg = '非法调用充值回调，请检查订单状态：'.$order->bill_status;
                $order->changeStatus($status,$msg);
                return 'SUCCESS'; 
            }
            $orderDb = UserOrder::where('order_type','bill')->where('order_status',1)->where('order_id',$order->id)->first();
            $status = 0;
            if($data['status'] == 2){
                $status = 3;
                $msg = false;
                $order->changeStatus($status,$msg);
                if($orderDb){
                    $orderDb->order_status = 2;
                    $orderDb->save();
                }
            }else if($data['status'] == 3){
                $status = 4;
                $msg = '回调充值失败';
                $order->changeStatus($status,$msg);
                //进行退款处理
                $fail_msg = '充值失败,发起退款';
                $billService->refund($order,$fail_msg);
                if($orderDb){
                    $orderDb->order_status = 4;
                    $orderDb->fail_msg = '订单充值失败，订单佣金失效';
                    $orderDb->save();
                }
            }
            $marketService->nactive_bill_action($orderDb,$status);
            return 'SUCCESS';
            
        }
    }
}
