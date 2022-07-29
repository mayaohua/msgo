<?php

namespace App\Http\Controllers\WeChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Session;
use App\Services\BillService;
use App\Models\WebUser;
use App\Models\WebSellUser;

class OfficialController extends Controller
{
    
    protected $app = null;

    public function __construct(){
        $this->payApp = Factory::payment(config('wechat.payment.default'));
        $this->offApp = Factory::officialAccount(config('wechat.official_account.default'));
    }

    
    public function templateMessage(BillService $billService){
        // dd($billService->mobileBill(1));
        // $app = Factory::officialAccount(config('wechat.official_account.default'));
        // $res = $app->template_message->sendSubscription([
        //     'touser' => 'ooOia6RUjLGuaewRlPVt74U5yhYw',
        //     'template_id' => 'o3OHE7ul-IU385FA3RyL9jpEn2Gqd3Kaljrazs_iHxg',
        //     'url' => 'https://easywechat.org',
        //     'scene' => 1000,
        //     'data' => [
        //         'thing3.DATA' => '手机话费100元',
        //         'phone_number2.DATA' => '18000000000',
        //         'amount1.DATA' => '99.98元',
        //         'thing4.DATA' => '您的订单已成功退款，金额将原路返回到您的微信支付账户，请注意查收。',
        //     ],
        // ]);
        // dd($res);
        //dd($this->offApp->template_message->getPrivateTemplates());
    }
    
    

    public function setMenu()
    {
        // $list = $this->offApp->material->list('image', 0, 10);
        // dd($list);
        $this->offApp->menu->delete();
        $buttons = [
            [
                "name"       => "卡号商城",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "精品靓号",
                        "url"  =>  env('APP_WX_URL').'/card/bestnum/'
                    ],
                    [
                        "type" => "view",
                        "name" => "自选卡种",
                        "url"  =>  env('APP_WX_URL').'/card/kind/'
                    ],
                    [
                        "type" => "view",
                        "name" => "扫描靓号",
                        "url"  =>  env('APP_WX_URL').'/card/wxapp'
                    ],
                    [
                        "type" => "view",
                        "name" => "订单查询",
                        "url"  =>  'https://m.10010.com/mfront/views/my-order/main.html#/orderlist?oneKey=t'
                    ],
                    [
                        "type" => "view",
                        "name" => "开卡激活",
                        "url"  =>  'http://10010.club/activation'
                    ],
                ],
            ],
            [
                "name" => "充值中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "话费充值",
                        "url"  =>  env('APP_WX_URL').'/bill/'
                    ],
                    [
                        "type" => "view",
                        "name" => "会员充值",
                        "url"  =>  env('APP_WX_URL').'/bill/vip/'
                    ],
                    [
                        "type" => "view",
                        "name" => "流量充值",
                        "url"  =>  env('APP_WX_URL').'/bill/flow/'
                    ],
                    [
                        "type" => "view",
                        "name" => "充值订单",
                        "url"  =>  env('APP_WX_URL').'/bill/record/'
                    ]
                ],
            ],
            [
                "name" => "了解更多",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "星耀合伙人",
                        "url"  =>  env('APP_WX_URL').'/market/'
                    ],
                    [
                        "type" => "media_id",
                        "name" => "商务合作",
                        //iALYv0j6GSYaFMktJnUMFZCSKWr0EC94Nc_qXIQsjzs
                        "media_id"  =>  'iALYv0j6GSYaFMktJnUMFQB91oL2Y86oI4T1zIbrmIQ'
                    ]
                ],
            ]
        ];
        $res = $this->offApp->menu->create($buttons);
        dd($res);


    }

    public function token_ver(){
        return $this->offApp->server->serve();
    }

    
    public function oauth_callback(Request $request){
        $user = $this->offApp->oauth->user()->toArray();
        Session::put('wechat_user', $user);
        Session::save();
        $targetUrl = Session::get('target_url');
        return redirect($targetUrl);
    }

    public function oauth_callback_guanzhu(){
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $user = $app->oauth->user()->toArray();
        
        $openid = $user['original']['openid'];
        $subscribe = $app->user->get($openid)['subscribe'];
        if(!$subscribe){
            return redirect('/official/guanzhu');
        }
        Session::put('wechat_user', $user);
        Session::save();
        $targetUrl = Session::get('target_url');
        return redirect($targetUrl);
    }

    public function guanzhu(){
        return view('market.guanzhu');
    }

    public function has_sell_user(Request $request){
        $user_key = $request->get('user_key');
        $us = Session::get('wechat_user');
        $openid = '';
        if($us){
            $openid = $us['original']['openid'];
        }
        $user = WebUser::where('user_key',$user_key)->first();
        $this->sysnUser($user);
        if($user && $openid != $user->user_openid) {
            return 1;
        }
        
        return 0;
    }

    public function sysnUser($webuser){
        $user = Session::get('wechat_user');
        
        if(!$user){return;}
        $userInfo = $user['original'];
        $openid = $userInfo['openid'];
        $userDb  = WebSellUser::where('user_openid',$openid)->first();
        if($openid == $webuser->user_openid){return;}
        if($webuser){
            if(!$userDb){
                WebSellUser::create([
                    'user_openid' => $openid,
                    'user_info' => json_encode($userInfo),
                    'sale_user_id' => $webuser->id,
                ]);
            }else{
                $userDb->sale_user_id = $webuser->id;
                $userDb->save();
            }
        }else{
            if(!$userDb){
                WebSellUser::create([
                    'user_openid' => $openid,
                    'user_info' => json_encode($userInfo)
                ]);
            }
        }
    }
    
}
