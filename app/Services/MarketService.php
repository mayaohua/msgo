<?php
namespace App\Services;
use App\Services\BaseService;
use App\Events\JobWork;
use Illuminate\Support\Facades\Log;
use App\Models\PhoneBillOrder;
use EasyWeChat\Factory;
use App\Models\BillType;
use App\Models\Bill;
use App\Models\BillData;
use Illuminate\Support\Facades\DB;
use App\Models\UserOrder;
use App\Models\WebUser;

class MarketService extends BaseService{

    public function nactive_pay($user_openid,$phone,$price,$product,$seller=false){
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $res = $app->template_message->send([
            'touser' => $user_openid,
            'template_id' => 'aMxdCxKmT_-IReWt2CzmValKGTAYPPI2BB9LLaj3yNI',
            // 'url' => env('APP_URL').'/m/',
            'data' => [
                'first' => $seller?'你的客户已成功下单，话费正在充值中。':'你的订单已被处理，话费正在充值中。',
                'keyword1' => $phone,
                'keyword2' => $product,
                'keyword3' => $price.'元',
                'remark' => $seller?'用户充值成功即可获得佣金':'充值存在延迟，请耐心等待，如需帮助请点击底部菜单“联系客服”。'
            ],
        ]);
    }

    public function nactive_apply($user_openid,$order_id,$mobile,$taocan,$user_name,$user_code,$seller=false){
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $res = $app->template_message->send([
            'touser' => $user_openid,
            'template_id' => 'atjY8Vl7XbbYjEfnSw5lu-Zc91sheF04oVy4YFUT45s',
            // 'url' => env('APP_URL').'/m/',
            'data' => [
                'first' => $seller?'恭喜！您的客户已成功申请手机号码。':'恭喜！您提交的手机号码申请已受理成功。',
                'keyword1' => $order_id,
                'keyword2' => $mobile,
                'keyword3' => $taocan,
                'keyword4' => $this->formatTrueName($user_name),
                'keyword5' => $this->formatIdCard($user_code),
                'remark' => $seller?'用户收到卡后首充激活即可获得佣金':'如需要实名认证请先进行认证才能配送，注意查收短信。'
            ],
        ]);
    }

    public function nactive_bill_success($user_openid,$mobile,$o_price,$price,$time,$remark,$seller=false){
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $res = $app->template_message->send([
            'touser' => $user_openid,
            'template_id' => 'CAwHIfU29d3qncpmxhDoLwZoaAoibG7CRIoD90_Wl-A',
            // 'url' => env('APP_URL').'/m/',
            'data' => [
                'first' => $seller?'您的客户充值成功':'您好，订单已成功充值。',
                'keyword1' => $mobile,
                'keyword2' => $o_price.'元',
                'keyword3' => $price.'元',
                'keyword4' => $time,
                'remark' => $remark,
            ],
        ]);
    }

    public function nactive_bill_fail($user_openid,$mobile,$first,$price,$remark){
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $temp = [
            'touser' => $user_openid,
            'template_id' => 'caP-5jq9gmj4Y5NtrVDDvMG0LM6KkWCGpvd5nOP5XZ8',
            'data' => [
                'first' => $first,
                'keyword1' => $mobile,
                'keyword2' => $price.'元',
                'remark' => $remark,
            ],
        ];
        $res = $app->template_message->send($temp);
    }

    public function nactive_card_fail($user_openid,$mobile,$first,$product_name,$remark){
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $arr = [
            'touser' => $user_openid,
            'template_id' => 'VWBDAsHyrxJSVn57-YM9O8zhWVKApYfI9FEuqxEZW70',
            'data' => [
                'first' => $first,
                'keyword1' => $this->formatMobile($mobile),
                'keyword2' => $product_name,
                'remark' => $remark,
            ],
        ];
        $res = $app->template_message->send($arr);
    }

    public function nactive_card_success($user_openid,$first,$user_name,$product_name,$time,$remark){
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $arr = [
            'touser' => $user_openid,
            'template_id' => 'ot0cm3RRvlPUxj49OBQShT2_0b7zN1m25P39nIrlVDU',
            'data' => [
                'first' => $first,
                'keyword1' => $this->formatTrueName($user_name),
                'keyword2' => $product_name,
                'keyword3' => $time,
                'keyword4' => '0元',
                'remark' => $remark,
            ],
        ];
        $res = $app->template_message->send($arr);
    }

    public function nactive_bill_action($order,$order_status){
        if($order_status > 0){
            $userOrderDb = UserOrder::where('order_type','bill')->where('order_status',1)->where('order_id',$order->id)->first();

            if(!$userOrderDb){return ;}
            $order_info = json_decode($userOrderDb->order_info);
            
            if($order_status == 3){
                $userOrderDb->order_status = 2;
                $userOrderDb->save();
                try {
                    if($order_info->bill_info->action_user_openid){
                        $remark = $userOrderDb->order_name.'，充值成功';
                        // Log::info($order_info->bill_info->action_user_openid);
                        $this->nactive_bill_success($order_info->bill_info->action_user_openid,$order_info->bill_phone,$order_info->bill_info->face_price,$order_info->bill_info->sale_price,$userOrderDb->created_at,$remark);
                    }
                } catch (\Exception $e) {
                    Log::info('充值成功消息错误1：');
                    Log::info($e);
                }

                try {
                    $user = WebUser::find($userOrderDb->user_id);
                    if($user){
                        $remark = '您的客户充值成功，奖励佣金'.$order_info->bill_info->UserFreePrice.'元，审核后自动到账';
                        $this->nactive_bill_success($user->user_openid,$order_info->bill_phone,$order_info->bill_info->face_price,$order_info->bill_info->sale_price,$userOrderDb->created_at,$remark,true);
                    }
                    
                } catch (\Exception $e) {
                    Log::info('充值成功消息错误2：');
                    Log::info($e);
                }
                try {
                    $first = $userOrderDb->order_name;
                    $order_type_name = '充值业务';
                    $order_id = $userOrderDb->order_uuid;
                    $time = $userOrderDb->created_at;
                    $remark = '用户话费充值成功消息通知';
                    $this->nactive_mayh($first,$order_type_name,$order_id,$time,$remark);
                } catch (\Exception $e) {
                    Log::error('用户申请卡号，发送消息通知给合伙人失败');
                }
            }else if($order_status == 4){
                $userOrderDb->order_status = 4;
                $userOrderDb->fail_msg = '订单充值失败，订单佣金失效';
                $userOrderDb->save();
                try {
                    //通知用户下单消息
                    if($order->bill_user_openid){
                        $first = '非常抱歉，订单充值失败，将会为您自动退款';
                        $remark = '充值商品 '.$order->bill_type_name;
                        $phone = substr_replace($order_info->bill_info->bill_mobile, '****', 3, 4);
                        $this->nactive_bill_fail($order->bill_user_openid,$phone,$first,$order_info->bill_info->sale_price,$remark);
                        // Log::info('success');
                    }
                } catch (\Exception $e) {
                    Log::info('充值失败消息错误1：');
                    Log::info($e);
                }
    
                try {
                    // 通知分销用户下单消息
                    $user = WebUser::find($order_info->bill_info->sell_user_openid);
                    $first = '非常抱歉，您有客户充值失败，订单佣金失效';
                    $remark = '充值商品：'.$order->bill_type_name;
                    $phone = substr_replace($order_info->bill_info->bill_mobile, '****', 3, 4);
                    $this->nactive_bill_fail($order_info->bill_info->sell_user_openid,$phone,$first,$order_info->bill_info->sale_price,$remark,true);
                } catch (\Exception $e) {
                    Log::info('充值失败消息错误2：');
                    Log::info($e);
    
                }

                try {
                    $first = $userOrderDb->order_name;
                    $order_type_name = '充值业务';
                    $order_id = $userOrderDb->order_uuid;
                    $time = $userOrderDb->created_at;
                    $remark = '用户话费充值失败消息通知';
                    $this->nactive_mayh($first,$order_type_name,$order_id,$time,$remark);
                } catch (\Exception $e) {
                    Log::error('用户申请卡号，发送消息通知给合伙人失败');
                }
            }
        }
    }

    public function nactive_mayh($first,$order_type_name,$order_id,$time,$remark){
        
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $arr = [
            'touser' => env('MAYH_OPENID'),
            'template_id' => '9PwFh9VihrMG0pE-irSN_G4273SjX6ZJFPSjiwEeoiA',
            'data' => [
                'first' => $first,
                'keyword1' => $order_type_name,
                'keyword2' => $order_id,
                'keyword3' => $time,
                'remark' => $remark,
            ],
        ];
        $res = $app->template_message->send($arr);
    }

    private function formatTrueName($user_name){
        $strlen  = mb_strlen($user_name, 'utf-8');
        $firstStr  = mb_substr($user_name, 0, 1, 'utf-8');
        $lastStr  = mb_substr($user_name, -1, 1, 'utf-8');
        return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
    }

    private function formatMobile($mobile){
        //颠倒顺序每隔4位分割为数组
        $split = str_split(strrev($mobile),4);    
        //头和尾保留，其他部分替换为星号  
        $split = array_fill(1,count($split) - 2,"****") + $split;
        ksort($split);
        //合并颠倒顺序
        return strrev( implode("",$split));
    }

    private function formatIdCard($id_card){      
        //每隔1位分割为数组
        $split = str_split($id_card,1);    
        //头2位和尾保留，其他部分替换为星号     
        $split = array_fill(0,count($split) - 4,"*") + $split;
        ksort($split);
        //合并
        return implode("",$split);
    }
}
