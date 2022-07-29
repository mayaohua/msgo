<?php

namespace App\Http\Controllers\WeChat\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\PhoneCardOrder;
use Illuminate\Support\Facades\Storage;
use App\Models\Card;
use App\Models\CardCase;
use App\Services\DguniService;
use App\Services\LTService;
use App\Services\HaokaService;
use App\Services\MarketService;
Use Illuminate\Support\Facades\Input;
use App\Models\BestMobile;
use App\Models\Suggest;
use App\Models\WebUser;
use App\Models\UserOrder;
use App\Models\WebSellUser;


class ApiController extends Controller
{
    
    public function __construct()
    {
        
    }

    
    public function index(Request $request,LTService $ltService)
    {
        dd($ltService->userAuth('550814552649633792','51'));
    }

    public function putOrderByNumber(Request $request){
        $apply_from = Input::get('apply_from');
        $card_db = Card::find($request->get('card_id'));
        $numberData = $request->get('numberData');
        $userData = $request->get('userData');
        $user_key = $request->get('user_key');
        $userData['user_key'] = $user_key;
        $card_app_order_id = $this->creatOrderId();
        $card_prokey = '99999'.time();
        $case_db = CardCase::find($card_db->card_case_id);
        $show_name = $card_db->card_name;
        if($card_db->card_name != $case_db->case_name){
            $show_name = $case_db->case_name.'-'.$card_db->card_name;
        }
        $cardData = ['card_product_id'=>$card_db->card_product_id,'card_product_type'=>$card_db->card_product_type,'card_app_order_id' =>$card_app_order_id,'card_prokey'=>$card_prokey,'card_show_name'=>$show_name,'card_id'=>$request->get('card_id')];
        return $this->putOrder($numberData,$userData,$cardData);
    }

    public function numSelect(Request $request,DguniService $dgService){
        $product_type = $request->get('product_type'); 
        $data = [
            'provinceCode' => $request->get('provinceCode'),
            'cityCode' => $request->get('cityCode'),
            'search' => $request->get('search'),
            'product_id' => $request->get('product_id'),
        ];
        if($product_type){//发送验证码到对接平台
            $res = $dgService->numSelect($data);
        }else{
            return $this->fail('非法调用');
        }
        $data = [];
        $msg = '获取号码失败';
        if($res['rspCode'] == 'M0'){
            $msg = '';
            foreach($res['body']['numArray'] as $value){
                $value = (string) $value;
                if(strlen($value) == 11){
                    array_push($data,$value);
                }
            }
            if(!count($data)){
                $msg = '未找到号码';
            }
        }else if($res['rspCode'] == 'M1' || $res['rspCode'] == 'T1'){
            $msg = '没有符合的号码';
        }
        if($msg){
            return $this->fail($msg);
        }
        return $this->success($data);
    }

    public function captcha(Request $request,DguniService $dgService,LTService $ltService){
        $mobile = $request->get('phone');
        $product_type = $request->get('product_type');
        $certId = $request->get('usercode');
        if($product_type && $certId){//发送验证码到对接平台
            $res = $dgService->sendCaptcha(['userphone'=>$mobile,'usercode'=>$certId]);
        }else{
            $res = $ltService->sendCaptcha($mobile);
        }
        if($res['rspCode'] == '0000'){
            return $this->success();
        }else{
            return $this->fail($res['rspDesc']);
        }
        
    }

    public function indexBestNum(Request $request,HaokaService $haokaService){
        $province_ess_code = $request->get('province_ess_code');
        $city_ess_code = $request->get('city_ess_code');
        //$result = $haokaService->getBestNumForIndex($province_ess_code,$city_ess_code);
        // try{
        //     $result = $haokaService->getBestNumForIndex($province_ess_code,$city_ess_code);
        // }catch(\Exception $e){
        //     return $this->fail('获取失败');
        // }
        $result = BestMobile::when($province_ess_code,function($query) use($province_ess_code){
            return  $query -> where('provice_code',$province_ess_code);
         })->when($city_ess_code,function($query) use($city_ess_code){
            return  $query -> where('city_code',$city_ess_code);
         })->where('is_sell',0)->inRandomOrder()->paginate(10);
         foreach($result->items() as $item){
            $item['data'] = json_decode($item['data']);
            $item['card_icon'] = Card::find($item['card_id'])->card_icon;
         }
        return $this->success($result);
    }

    public function bestNumList(Request $request,HaokaService $haokaService){
        $p = $request->get('p');
        $c = $request->get('c');
        $search = $request->get('search');
        $lx = $request->get('lx');
        $page = $request->get('page');
        $result = BestMobile::when($p,function($query) use($p){
            return  $query -> where('provice_code',$p);
         })->when($c,function($query) use($c){
            return  $query -> where('city_code',$c);
         })->when($search,function($query) use($search){
            return  $query -> where('mobile_number','like','%'.$search.'%');
         })->when($lx,function($query) use($lx){
            return  $query -> where('data','like','%'.'"rule_name": "'.$lx.'"%');
         })->where('is_sell',0)->inRandomOrder()->paginate(15);
         foreach($result->items() as $item){
            $item['data'] = json_decode($item['data']);
            $item['card_icon'] = Card::find($item['card_id'])->card_icon;
         }
        return $this->success($result);
    }

    public function bestNumListCopy(Request $request,HaokaService $haokaService){
        $p = $request->get('p');
        $c = $request->get('c');
        $search = $request->get('search');
        $lx = $request->get('lx');
        $page = $request->get('page');
        $result = $haokaService->getBestNum($p,$c,$lx,$search,$page);
        return $this->success($result);
    }
    
    public function putOrderByBest(Request $request){
        $card_db = Card::find($request->get('card_id'));
        $numberData = $request->get('numberData');
        $userData = $request->get('userData');
        $card_app_order_id = $this->creatOrderId();
        $card_prokey = '99999'.time();
        $case_db = CardCase::find($card_db->card_case_id);
        $show_name = $card_db->card_name;
        if($card_db->card_name != $case_db->case_name){
            $show_name = $case_db->case_name.'-'.$card_db->card_name;
        }
        $cardData = ['card_product_id'=>$card_db->card_product_id,'card_product_type'=>$card_db->card_product_type,'card_app_order_id' =>$card_app_order_id,'card_prokey'=>$card_prokey,'card_show_name'=>$show_name];
        return $this->putOrder($numberData,$userData,$cardData);
    }

    private function putOrder($numberData,$userData,$cardData){
        if(isset($numberData['mobileFrom']) && $numberData['mobileFrom'] == 'dsf'){
            $haokaService = new HaokaService;
            $result = $haokaService->putOrder($numberData,$userData);
            $order_to = 'dsf';
        }else{
            if($cardData['card_product_type']){//对接平台
                $order_to = 'dg';
                $dgService = new DguniService; //东莞联通
                $result = $dgService->putOrder($numberData,$userData,$cardData);
            }else{
                $order_to = 'lt';
                $ltService = new LTService; //中国联通
                $result = $ltService->putOrder($numberData,$userData,$cardData);
            }
            if($result['code'] == 0){
                BestMobile::where('mobile_number',$numberData['mobile'])->update([
                    'is_sell' => 1
                ]);
            }
        }
        $apply_from = Input::get('apply_from');
        $order_data = [
            'mobile'            => $numberData['mobile'],
            'mobile_location'   => $numberData['province']['name'].$numberData['city']['name'],
            'card_name'         => $cardData['card_show_name'],
            'card_product_id'   => $cardData['card_product_id'],
            'user_name'         => $userData['username'],
            'user_code'         => $userData['usercode'],
            'user_phone'        => $userData['userphone'],
            'user_address'      => $userData['province']['name'].$userData['city']['name'].$userData['address'],
            'apply_data'        => json_encode(isset($result['data'])?$result['data']:[],JSON_UNESCAPED_UNICODE),
            'apply_from'        => $apply_from,
            'order_to'          => $order_to,
            'user_data'         => json_encode($userData,JSON_UNESCAPED_UNICODE),
            'number_data'       => json_encode($numberData,JSON_UNESCAPED_UNICODE),
            'card_data'         => json_encode($cardData,JSON_UNESCAPED_UNICODE),
        ];
        //将订单写入数据库 
        $orderDb = PhoneCardOrder::create($order_data);
        if(!$orderDb){return $this->fail('生成订单失败');}
        $status = $result['code'] == 0 ? 0 : 1 ;
        $msg = $result['code'] == -1 ? $result['msg'] : '申请成功';
        $orderDb->changeStatus($status,$msg);

        if($result['code'] == -1){
            return $result;
        }

        $marketService = new MarketService;
        //发送消息通知
        try {
            $us = Session::get('wechat_user');
            $openid = $us['original']['openid'];
            if($openid){
                //发送消息通知
                $mobile = $numberData['mobile'];
                $marketService->nactive_apply($openid,$cardData['card_app_order_id'],$mobile
            ,$orderDb->card_name,$userData['username'],$userData['usercode']);
            WebSellUser::where('user_openid',$openid)->increment('order_count');
            }
        } catch (\Exception $e) {
           Log::error('用户申请卡号，发送消息通知给申请人失败');
        }
        $user_key = $userData['user_key'];
        $userDb = WebUser::where('user_key',$user_key)->first();
        if($openid && $openid == $userDb->user_openid){
            return $result;
        }
        try {
            //获取用户的user_key,并且存入user_orders
            $card_db = Card::find($cardData['card_id']);
            $case_db = CardCase::find($card_db->card_case_id);
            if($user_key && $card_db->user_can_sale == 1 && $case_db->user_can_sale == 1 && $card_db->sell_price > 0 && $order_to != 'dsf'){
                $order_info = [
                    'card_phone' => substr_replace($orderDb->mobile, '****', 3, 4),
                    'user_phone' => substr_replace($orderDb->user_phone, '****', 3, 4),
                    'card_info' => ['action_user_openid'=>$openid ? $openid : '']
                ];
                // dd($userDb);
                if($userDb){
                    $data = [
                        'order_type' => 'card',
                        'order_uuid' => $cardData['card_app_order_id'],
                        'order_name' => $orderDb->card_name.'('.substr_replace($orderDb->mobile, '****', 3, 4).')',
                        'order_info' => json_encode($order_info),
                        'order_money' => $card_db->sell_price,
                        'user_id' =>  $userDb->id,
                        'order_id' => $orderDb->id,
                        'order_status' => 1,
                        'action_user_openid' => $openid ? $openid : ''
                    ];
                    $userDb->user_order_count = intval($userDb->user_order_count)+1;
                    $openid = $userDb->user_openid;
                    $userDb->save();
                    UserOrder::create($data);
                    //发送消息通知
                    $mobile = substr_replace($numberData['mobile'], '****', 3, 4);
                    $marketService->nactive_apply($openid,$cardData['card_app_order_id'],$mobile
                ,$orderDb->card_name,$userData['username'],$userData['usercode'],true);
                }
            }
        } catch (\Exception $e) {
            Log::error('用户申请卡号，发送消息通知给合伙人失败');
        }
        try {
            $first = $orderDb->card_name.'（'.$numberData['mobile'].'）';
            $order_type_name = '卡号办理';
            $order_id = $cardData['card_app_order_id'];
            $time = $orderDb->created_at;
            $remark = '卡号申请成功消息通知';
            $marketService->nactive_mayh($first,$order_type_name,$order_id,$time,$remark);
        } catch (\Exception $e) {
            Log::error('用户申请卡号，发送消息通知给合伙人失败');
        }
        return $result;
    }

    public function putQuestion(Request $request){
        $data = [];
        $data['kui_file']  = $request->get('imgs_url');
        $data['kui_content'] = $request->get('content');
        $data['kui_contact'] = $request->get('phone');
        $data['kui_openid'] =  'admin';
        $data['kui_user'] =  json_encode([],JSON_UNESCAPED_UNICODE);
        $data['kui_from'] =  $request->get('from');
        if(Suggest::create($data)){
            return $this->success();
        }
    }

    public function cardList(){
        $cards = CardCase::where('stop_sale',0)->where('scan_show',1)->with(['cards'=>function($query){
            $query->where('stop_sale',0);
        }])->get();
        return $this->success($cards);
    }
    

    private function creatOrderId(){
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        //date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 1, 15), 1))), 0, 8);
    }
    
}