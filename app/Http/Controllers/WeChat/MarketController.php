<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use EasyWeChat\Factory;
use App\Models\WebUser;
use App\Services\SmsService;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfit;
use App\Models\UserOrder;
use App\Models\UserTixian;
use App\Models\Setting;
use App\Models\CardCase;
use App\Http\Controllers\WxController;
use App\Models\PhoneBillOrder;
use App\Models\WebSellUser;
use App\Http\Controllers\Controller;
use App\Models\BillType;

class MarketController extends Controller

{

    public function welcome(){
        // $user = Session::get('wechat_user');
        // $openid = $user['original']['openid'];
        // dd($openid);
        $settingObj = Setting::where('key','sellForm')->first();
        $page_content = '';
        if($settingObj){
            $sellForm = json_decode($settingObj->value,1);
            $page_content = $sellForm['jieshao_page'];
        }
        return view('market.welcome',compact('page_content'));
    }

    public function index(){
        $user = Session::get('wechat_user');
        $openid = $user['original']['openid'];
        $userInfo = json_encode($user['original']);
        $key = '';
        $user_tixian_money = '0.00';//已提现
        $user_money = '0.00';//可提现
        $user_dongjie_money = '0.00';//提现冻结
        $yugu_money = '0.00';
        $order_count = 0;
        $cardCaseDb = CardCase::where('user_can_sale',1)->where('stop_sale',0)->get();
        $card_items = $cardCaseDb;
        $bill_items = BillType::with(['billcases'=>function($query){
            $query->where('stop_sale',0)->where('user_can_sale',1)->with(['bills'=>function($query){
                $query->where('stop_sale',0);
                $query->where('user_can_sale',1);
                $query->with('sell_data');
            }]);
        }])->get();
        $bill_items = json_encode($bill_items->toArray());
        // dd($bill_items->toArray());
        $settingObj = Setting::where('key','sellForm')->first();
        $sellForm = $settingObj->value;
        if($userdb = WebUser::where('user_openid',$openid)->first()){
            $key = $userdb->user_key;
            $user_money = $userdb->user_money;
            $user_status = $userdb->user_status;
            $user_tixian_money = $userdb->user_tixian_money;
            $user_dongjie_money = $userdb->user_dongjie_money;
            $order_count = UserOrder::where('user_id',$userdb->id)->count();
            $orderItems = [];
            $orderItems[] = UserOrder::where('user_id',$userdb->id)->where('order_status',1)->get();
            $orderItems[] = UserOrder::where('user_id',$userdb->id)->where('order_status',2)->get();
            foreach($orderItems as $value){
                foreach($value as $v){
                    if($v->order_status == 1 || $v->order_status == 2){
                        $yugu_money = bcadd($yugu_money,$v->order_money,2);
                    }
                }
            }
        }
        return view('market.index',compact('sellForm','userInfo','key','user_dongjie_money','user_tixian_money','user_money','order_count','yugu_money','card_items','bill_items','user_status'));
    }
    public function apply(Request $request){
        $user = Session::get('wechat_user');
        $userInfo = $user['original'];
        $openid = $userInfo['openid'];
        // dd($openid);
        if(WebUser::where('user_openid',$openid)->first()){
            return redirect('/market');
        }
        $user_nike = $userInfo['nickname'];
        return view('market.apply',compact('user_nike'));
    }

    public function tixian(){
        $user = Session::get('wechat_user');
        $openid = $user['original']['openid'];
        $user_pic = $user['original']['headimgurl'];
        $user_name = '';
        $user_phone = '';
        $user_money = '0.00';
        if($userdb = WebUser::where('user_openid',$openid)->first()){
            $user_name = $userdb->user_name;
            $user_phone = $userdb->user_phone;
            $user_money = $userdb->user_money;
        }
        return view('market.tixian',compact('user_name','user_pic','user_phone','user_money'));
    }
    public function shouyi(){
        $user = Session::get('wechat_user');
        $openid = $user['original']['openid'];
        $user_tixian_money = '0.00';//已提现
        $user_money = '0.00';//可提现
        $user_dongjie_money = '0.00';//提现冻结
        $profitItems = [];
        if($userdb = WebUser::where('user_openid',$openid)->first()){
            $user_money = $userdb->user_money;
            $user_tixian_money = $userdb->user_tixian_money;
            $user_dongjie_money = $userdb->user_dongjie_money;
            $profitItems = UserOrder::where('user_id',$userdb->id)->where('order_status',3)->orderBy('created_at','desc')->get();
            $profitItems = json_encode($profitItems);
        }
        return view('market.shouyi',compact('user_tixian_money','user_money','user_dongjie_money','profitItems'));
    }
    public function tixian_list(){
        $user = Session::get('wechat_user');
        $openid = $user['original']['openid'];
        $user_tixian_money = '0.00';//已提现
        $user_money = '0.00';//可提现
        $user_dongjie_money = '0.00';//提现冻结
        $tixianItems = [];
        if($userdb = WebUser::where('user_openid',$openid)->first()){
            $user_money = $userdb->user_money;
            $user_tixian_money = $userdb->user_tixian_money;
            $user_dongjie_money = $userdb->user_dongjie_money;
            $tixianItems = UserTixian::where('user_id',$userdb->id)->orderBy('created_at','desc')->get();
            $tixianItems = json_encode($tixianItems);
        }
        return view('market.tixian_list',compact('user_tixian_money','user_money','user_dongjie_money','tixianItems'));
    }
    public function dingdan(){
        $user = Session::get('wechat_user');
        $openid = $user['original']['openid'];
        $user_tixian_money = '0.00';//已提现
        $user_money = '0.00';//可提现
        $user_dongjie_money = '0.00';//提现冻结
        $yugu_money = '0.00';
        $profitItems = [];
        if($userdb = WebUser::where('user_openid',$openid)->first()){
            $user_money = $userdb->user_money;
            $user_tixian_money = $userdb->user_tixian_money;
            $user_dongjie_money = $userdb->user_dongjie_money;
            $orderItems = [];
            $orderItems[] = UserOrder::where('user_id',$userdb->id)->where('order_status',1)->orderBy('created_at','desc')->get();
            $orderItems[] = UserOrder::where('user_id',$userdb->id)->where('order_status',2)->orderBy('created_at','desc')->get();
            $orderItems[] = UserOrder::where('user_id',$userdb->id)->where('order_status',3)->orderBy('created_at','desc')->get();
            $orderItems[] = UserOrder::where('user_id',$userdb->id)->where('order_status',4)->orderBy('created_at','desc')->get();
            foreach($orderItems as $value){
                foreach($value as $v){
                    if($v->order_status == 1 || $v->order_status == 2){
                        $yugu_money = bcadd($yugu_money,$v->order_money,2);
                    }
                    $v->order_info = json_decode($v->order_info);
                }
            }
            $orderItems = json_encode($orderItems);
        }
        return view('market.dingdan',compact('user_tixian_money','user_money','user_dongjie_money','orderItems','yugu_money'));
    }

    public function zixun(){
        $settingObj = Setting::where('key','sellForm')->first();
        $page_content = '';
        if($settingObj){
            $sellForm = json_decode($settingObj->value,1);
            $page_content = $sellForm['zixun_page'];
        }
        return view('market.zixun',compact('page_content'));
    }
    public function wenti(){
        $settingObj = Setting::where('key','sellForm')->first();
        $page_content = '';
        if($settingObj){
            $sellForm = json_decode($settingObj->value,1);
            $page_content = $sellForm['wenti_page'];
        }
        return view('market.wenti',compact('page_content'));
    }

    public  function client(){
        $user = Session::get('wechat_user');
        $openid = $user['original']['openid'];
        $user_id = WebUser::where('user_openid',$openid)->first()->id;
        $users = WebSellUser::where('sale_user_id',$user_id)->get();
        foreach($users as $user){
            $user->user_info = json_decode($user->user_info);
            // $action_user_id = $user->order_type == 'card' ? $user->user_info->card_info->action_user_openid : $user->user_info->bill_info->action_user_openid;
            $user->for_sell_orders  = UserOrder::where('user_id',$user_id)->where('order_info','like','%'.$user->user_openid.'%')->count();
        }
        $users = json_encode($users);
        return view('market.client',compact('users'));
    }

    /**
     *    API
     */

    public function getJSSDKConfig(Request $request){
        $arr = ['chooseWXPay'];
        $openTag = [ 'wx-open-launch-weapp', 'wx-open-subscribe',];
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $app->jssdk->setUrl($request->server('HTTP_REFERER'));
        $config = $app->jssdk->buildConfig($arr,false,false,false,$openTag);
        return $this->success($config);
    }
    public function send_captcha(Request $request,SmsService $smsService){
        $phone = $request->get('phone');
        // 验证码
        $code = mt_rand(1000, 9999);
        // 将验证码 存入session中
        $request->session()->put('verify_code', $code);
        // 设置验证码有效时间
        $result = $smsService->sendCaptchaSms($phone,$code);
        if($result === true){
            return $this->success();
        }else{
            //删除验证码
            $request->session()->forget('verify_code');
            return $this->fail($result);
        }
    }

    public function applyAction(Request $request){
        $data = $request->all();
        $user = Session::get('wechat_user');
        $userInfo = $user['original'];
        $openid = $userInfo['openid'];

        if(WebUser::where('user_openid',$openid)->first()){
            return fail('申请成功，无需再次申请');
        }

        $data['user_openid'] = $openid;
        $data['user_info'] = json_encode($userInfo,JSON_UNESCAPED_UNICODE);
        $data['user_money'] = '0.00';
        $data['user_tixian_money'] = '0.00';
        $data['user_dongjie_money'] = '0.00';
        $data['user_order_count'] = '0';
        $captcha = $request->session()->get('verify_code');
        $request->session()->forget('verify_code');
        if($captcha  != $request->get('captcha')){
            return $this->fail('验证码错误，请重新获取');
        }

        DB::beginTransaction();
        $dbres = WebUser::create($data);
        if(!$dbres){
            DB::rollBack();
            return $this->fail('申请失败，请稍后重试');
        }
        $hashids = new Hashids(env('APP_NAME'),6);
        $newid = $hashids->encode($dbres->id);
        $dbres->user_key = $newid;
        $dbres->save();
        DB::commit();
        return $this->success();
    }

    public function uploadBase64Img(Request $request){
        $base64 = preg_replace("/\s/",'+',$request->input('img'));
        $img = base64_decode(str_replace('data:image/png;base64,', '', $base64));
        $disk = \Storage::disk('uploads'); //使用七牛云上传
        $img_name = date('Y/m/d-H:i:s-') . uniqid() . '.png';
        $filename = $disk->put($img_name,$img);//上传
        if(!$filename) {
            return $this->fail('上传失败');
        }
        $img_url = $disk->url($img_name); //获取下载链接
        return $this->success($img_url);
    }

    public function tixianAction(Request $request){
        $user = Session::get('wechat_user');
        $userInfo = $user['original'];
        $openid = $userInfo['openid'];
        $captcha = $request->session()->get('verify_code');
        $request->session()->forget('verify_code');
        if($captcha  != $request->get('captcha')){
            return $this->fail('验证码错误，请重新获取');
        }
        $tixian_money  = floatval($request->get('tixian_price'));
        $tixian_money = number_format($tixian_money, 2);
        $tixian_info  = $request->get('tixian_info');
        $tixian_img  = $request->get('tixian_img');
        if($userdb = WebUser::where('user_openid',$openid)->first()){
            if($userdb->user_status != 1){
                return $this->fail('账号异常，无法提现');
            }
            $userdb->user_money = floatval($userdb->user_money);
            if($userdb->user_money < $tixian_money){
                return $this->fail('可提现金额不足');
            }
            DB::beginTransaction();
            UserTixian::create([
                'tixian_money' => $tixian_money,
                'tixian_status' => 1,
                'tixian_info' => $tixian_info,
                'tixian_img' => $tixian_img,
                'user_id' => $userdb->id
            ]);
            $userdb->user_money = bcsub($userdb->user_money,$tixian_money,2);
            $userdb->user_dongjie_money = bcadd($userdb->user_dongjie_money,$tixian_money,2);
            $userdb->save();
            DB::commit();
            return $this->success();
        }else{
            return $this->fail();
        }
    }

}