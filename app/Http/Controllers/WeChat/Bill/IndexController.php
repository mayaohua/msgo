<?php

namespace App\Http\Controllers\WeChat\Bill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    
    public function __construct()
    {
        
    }

    public function index(Request $request){
        $user = Session::get('wechat_user');
        $active = 0;
        return view('wx.bill.index',compact('active'));
    }

    public function vip(Request $request){
        $active = 2;
        $user = Session::get('wechat_user');
        return view('wx.bill.vip',compact('active'));
    }
    public function flow(Request $request){
        $user = Session::get('wechat_user');
        $active = 1;
        return view('wx.bill.flow',compact('active'));
    }
    
    public function record(Request $request){
        $active = 3;
        $user = Session::get('wechat_user');
        return view('wx.bill.center.record',compact('active'));
    }
    public function center(Request $request){
        $user = Session::get('wechat_user')['original'];
        // dd($user);
        $active = 3;
        $user = json_encode($user);
        return view('wx.bill.center',compact('active','user'));
    }

    public function question(Request $request){
        $active = 3;
        $user = Session::get('wechat_user');
        return view('wx.bill.center.question',compact('active'));
    }
    public function agent(Request $request){
        $active = -1; //-1则不显示底部菜单 
        $user = Session::get('wechat_user');
        return view('wx.bill.center.agent',compact('active'));
    }
    public function apply(Request $request){
        $active = -1; //-1则不显示底部菜单 
        $user = Session::get('wechat_user');
        return view('wx.bill.center.apply',compact('active'));
    }
    public function contactUs(Request $request){
        $active = -1; 
        $user = Session::get('wechat_user');
        return view('wx.bill.center.us',compact('active'));
    }
    
    

    
    /**
     * 发送模板消息
     */
    // public function templateMessage($open_id){
    //     $app = Factory::officialAccount(config('wechat.official_account.default'));
    //     $res = $app->template_message->sendSubscription([
    //         'touser' => 'ooOia6RUjLGuaewRlPVt74U5yhYw',
    //         'template_id' => 'o3OHE7ul-IU385FA3RyL9jpEn2Gqd3Kaljrazs_iHxg',
    //         'url' => 'https://easywechat.org',
    //         'scene' => 1000,
    //         'data' => [
    //             'thing3.DATA' => 'VALUE',
    //             'phone_number2.DATA' => 'VALUE2',
    //             'amount1.DATA' => 'VALUE2',
    //             'thing4.DATA' => 'VALUE2',
    //         ],
    //     ]);
    //     dd($res);
    // }
    
    
}
