<?php

namespace App\Http\Controllers\Admin;

use App\Rule;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use App\Models\PhoneBillOrder;
use App\Models\PhoneCardOrder;
use Carbon\Carbon;
use App\Models\UserOrder;
use App\Models\WebUser;
use App\UserProfit;
use Illuminate\Support\Facades\DB;
use App\Services\MarketService;

class UserSellOrderController extends Controller
{
    public function list(Request $request){
        $inp = $this->getInp();
        $data = UserOrder::when($inp['status'] !== '',function($query) use($inp){
            return  $query -> where('order_status',$inp['status']);
        })->when($inp['keyword'],function($query) use($inp){
            return  $query -> where('order_type','like','%'.$inp['keyword'].'%')
                           ->orWhere('order_name','like','%'.$inp['keyword'].'%')
                           ->orWhere('order_uuid','like','%'.$inp['keyword'].'%')
                           ->orWhere('order_info','like','%'.$inp['keyword'].'%')
                           ->orWhere('order_money','like','%'.$inp['keyword'].'%')
                           ->orWhere('fail_msg','like','%'.$inp['keyword'].'%');
        })->when($inp['time'][0] !== '',function($query) use($inp){
            $inp['time'][0].=' 00:00:00';
            $inp['time'][1].=' 23:59:59';
            return  $query -> whereBetween('created_at',$inp['time']);
        })->orderBy('created_at','desc')->paginate(15);
        foreach($data->items() as $value){
            $value->user = WebUser::find($value->user_id);
        }
        $data = json_encode($data);
        $inp = json_encode($inp);
        return view('admin.webuser.order',compact('data','inp'));
    }

    public function edit(Request $request,$id,MarketService $marketService){
        $data = $request->all();
        DB::beginTransaction();
        try {
            $orderDb = UserOrder::find($id);
            if($orderDb->order_status == 3 || $data['order_status'] == $orderDb->order_status){
                DB::rollBack();
                return $this->fail('修改失败');
            }
            $orderDb -> update($data);
            $userDb = WebUser::find($orderDb->user_id);
            if($data['order_status'] == 3){//发放佣金
                //用户账户增加金额
                $userDb -> user_money = bcadd($userDb->user_money,$orderDb->order_money,2);
                $userDb -> save();
                if($orderDb->order_type=='bill'){
                    $orderInfo = json_decode($orderDb->order_info);
                    $remark = '审核通过，奖励佣金'.$orderDb->order_money.'元';
                    $marketService->nactive_bill_success($userDb->user_openid,$orderInfo->bill_phone,$orderInfo->bill_info->face_price,$orderInfo->bill_info->sale_price,$orderDb->created_at,$remark,true);
                }else{
                    $first = '用户卡号已完成交接';
                    $orderInfo = json_decode($orderDb->order_info);
                    $phoneCardOrder = PhoneCardOrder::find($orderDb->order_id);
                    $user_name = $phoneCardOrder->user_name;
                    $product_name = $orderDb->order_name;
                    $time = $orderDb->created_at;
                    $remark = '审核通过，奖励佣金'.$orderDb->order_money.'元';
                    $marketService->nactive_card_success($userDb->user_openid,$first,$user_name,$product_name,$time,$remark);
                }
            }
            if($data['order_status'] == 4){
                if($orderDb->order_type=='bill'){
                    $orderInfo = json_decode($orderDb->order_info);
                    $remark = '充值商品：'.$orderDb->order_name;
                    $first = '您的客户订单充值失败，佣金已失效';
                    $marketService->nactive_bill_fail($userDb->user_openid,$orderInfo->bill_phone,$first,$orderInfo->bill_info->UserFreePrice,$remark);
                }else{
                    $orderInfo = json_decode($orderDb->order_info);
                    $remark = $orderDb->fail_msg;
                    $first = '你的客户卡号申请未成功，佣金已失效';
                    $marketService->nactive_card_fail($userDb->user_openid,$orderInfo->card_phone,$first,$orderDb->order_name,$remark);

                    $orderInfo = json_decode($orderDb->order_info);
                    $action_user_openid = $orderInfo->card_info->action_user_openid;
                    if($action_user_openid){
                        $remark = $orderDb->fail_msg;
                        $first = '你的申请的号码未能成功';
                        $marketService->nactive_card_fail($action_user_openid,$orderInfo->card_phone,$first,$orderDb->order_name,$remark);
                    }
                    
                }
                
            }
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return $this->fail('修改失败');
        }
        return $this->success();
    }

    public function del(Request $request,$id){
        $res = UserOrder::find($id);
        if($res){
            $res->delete(); 
        }
        return $this->success();
    }

    
}