<?php

namespace App\Http\Controllers\WeChat\Bill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use App\Models\BillType;
use App\Models\Bill;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\PhoneBillOrder;
use App\Models\WebUser;

class PayController extends Controller
{
    
    public function __construct()
    {
        
    }

    private function getPrePayId($app,$description,$out_trade_no,$total_fee,$openid,$trade_type=false){
        $result = $app->order->unify([
            'body' => $description,
            'out_trade_no' => $out_trade_no,
            'total_fee' => $total_fee,
            'trade_type' => $trade_type?$trade_type:'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $openid,
        ]);
        if( $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            return $result['prepay_id'];
        }
        // Log::error('微信支付签名失败');
        return false;
    }
    private function creatOrderId(){
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
    
    public function billWxpay(Request $request){//充值支付
        // dd(env('APP_URL').'/wx/wechat-notify');
        $user = Session::get('wechat_user');
        $user = $user['original'];
        $openid = $user['openid'];
        $mobile = $request->get('mobile');
        $item_id = $request->get('id');
        $isp = $request->get('isp');
        $type = $request->get('type');
        if(!$mobile || strlen($mobile) != 11){
            return $this->fail('手机号码不正确');
        }
        $item = Bill::find($item_id);
        $sellData =$item->sell_data;
        $caseItem =$item->billcase;
        $typeItem =$caseItem->billtype;

        if($item->stop_sale == 1 || $caseItem->stop_sale == 1){
            return $this->fail('商品已下架，请稍后重试');
        }
        $user_key = $request->get('user_key');
        $sell_user_openid = null;
        $sale_price = $sellData->UserSalePrice;
        if($user_key){
            $userDb = WebUser::where('user_key',$user_key)->first();
            if($userDb){
                $sale_price = $sellData->UserSalePrice;
                $sell_user_openid = $userDb -> user_openid;
            }else{
                $user_key = null;
            }
        }
        
        $face_price = $sellData->facePrice;
        if($type == 'call'){
            $bill_type_name = $caseItem->case_name.$item->package;
            $type_text = '面值：'.($face_price).'元，售价：'.$sale_price.'元';
        }elseif($type == 'vip'){
            $bill_type_name = $caseItem->case_name.'('.$item->package.')';
            $type_text = '原价：'.($face_price).'元，售价：'.$sale_price.'元';
        }else{
            $bill_type_name = $caseItem->case_name.'('.$item->package.')';
            $type_text = '时效：'.($item->yh_tips).'，售价：'.$sale_price.'元';
        }

        //测试后删除
        //$sale_price = config('wechat.payment.default.sandbox') ? 1.01 : 0.01;
        // dd($sale_price);
        $order_id = $this->creatOrderId();
        $bill_data = [
            'itemFacePrice' => $item->itemFacePrice,
            'face_price' => $face_price, //面值   原价   时效
            'itemId'=> $item->itemId,
            'bill_mobile' => $mobile,
            'bill_app_order_id' => $order_id,
            'user_key' => $user_key,
            'sell_data' => $sellData,
            'action_user_openid' => $openid,
            'sell_user_openid' => $sell_user_openid,
            'type_text' => $type_text,
            'bill_type_name' => $bill_type_name,
            'sale_price' => $sale_price,
            'bill_type' => $type,
            'UserFreePrice' => $sellData->UserFreePrice
        ];
        $order_data = [
            'bill_mobile' => $mobile,
            'bill_type_name' => $bill_type_name,
            'bill_money' => $sale_price,
            'bill_type_text' => $type_text,
            'bill_user_openid' => $openid,
            'bill_user_data' => json_encode($user,JSON_UNESCAPED_UNICODE),
            'bill_app_order_id' => $order_id,
            'bill_biz_order_id' => '',
            'bill_wx_order_id' => '',
            'bill_status' => 0,
            'bill_msg' => '',
            'bill_data' => json_encode($bill_data,JSON_UNESCAPED_UNICODE)
        ];
        
        $app = Factory::payment(config('wechat.payment.default'));
        //获得预付单标识
        $total_fee = bcmul($sale_price , 100 ,0); //支付金额
        
        $prePayId = $this->getPrePayId($app,$bill_type_name,$order_data['bill_app_order_id'],$total_fee,$openid);
        if(!$prePayId){return $this->fail('生成订单失败');}
        //生成带签名支付信息
        $jssdk = $app->jssdk;
        $json = $jssdk->sdkConfig($prePayId);
        unset($json['appId']);
        //查询用户未支付进行关闭
        $orderDb = PhoneBillOrder::where('bill_user_openid',$openid)
            ->where('bill_status',0)->get();
        foreach ($orderDb as $key => $value) {
            $status = 2;
            $value->changeStatus($status,'用户产生新订单，关闭此单');
        }

        //生成订单
        $orderDb = PhoneBillOrder::create($order_data);
        // dd($orderDb);
        if(!$orderDb){return $this->fail('生成订单失败');}
        $status = 0;
        $orderDb->changeStatus($status);
        // dd($orderDb->bill_msg);
        //5分钟后检查订单状态，先查询订单，如果支付成功则改变状态，如果状态为0则关闭订单
        //$this->dispatch(new CloseBillOrder($insRes, self::ORDERTTL));
        return $this->success(['json' => $json,'order_id' => $order_id]);
    }

    public function billCancelpay(Request $request){
        $order_id = $request->get('order_id');
        $orderDb = PhoneBillOrder::where('bill_app_order_id',$order_id)->first();
        $status = 2;
        $msg = '用户取消支付';
        $orderDb->changeStatus($status,$msg);
    }
    public function billPayFail(Request $request){
        $order_id = $request->get('order_id');
        $orderDb = PhoneBillOrder::where('bill_app_order_id',$order_id)->first();
        $msg = '用户支付失败';
        $status = 2;
        $orderDb->changeStatus($status,$msg);
    }
}
