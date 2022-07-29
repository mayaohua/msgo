<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Models\Rule;
use App\Models\Setting;

use App\Events\JobWork;
use App\Services\Zop\ZopService;
use Illuminate\Http\Request;
use EasyWeChat\Factory;

class ZopController extends Controller
{
    
    protected static $_header = ['Content-Type: application/json;charset=UTF-8;'];
    const APPID = "wx8a1c60703631b1b4";
    const LOGINWAY = "snsapi_base";
    const APPSECRET = '4d813a6b05229c54848ed555639d2ac2';
    const MCHID = '1604061293';
    const MCHSECRET = 'Aa123413QWERTYUIOlkjhgfdsa123413';
    const PREPAY_URL = 'https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi';
    const reback_notify_url = 'https://wx.1001020.cn/m/wechatreback-notify';
    const ORDERTTL = 5 * 60;

    protected $payApp = null;

    public function __construct(){
        $this->payApp = Factory::payment(config('wechat.payment.default'));
    }

    public function get_openid(Request $request){
        $code = $request->get('code');
        if(!$code){
            return $this->fail();
        }
        $appid = self::APPID;
        $secret = self::APPSECRET;
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
        
        $res = $this->curl_request($url);
        $res = json_decode($res,1);
        if(isset($res['errmsg'])){
            return $this->fail();
        }
        return $this->success($res);
    }

    // public function test(Request $request){
    //     dd($this->zopService->test());
    // }
    public function wxpay(Request $request){
        $data = [
            'mobile' => '15101210016',
            'itemName' => '话费测试'
        ];
        //验证充值套餐
        //生成平台订单
        $ins = [
            'bill_mobile' => $data['mobile'],
        ];
        //请求下单接口，创建订单
        //获得预付单标识
        $prePayId = $this->getPrePayId($data['itemName'],$ins);
        if(!$prePayId){return $this->fail();}
        //生成带签名支付信息
        $jssdk = $this->payApp->jssdk;
        $json = $jssdk->bridgeConfig($prePayId);
        $json = json_decode($json);
        
        $json->order_id = time();
        //5分钟后检查订单状态，先查询订单，如果支付成功则改变状态，如果状态为0则关闭订单
        //$this->dispatch(new CloseBillOrder($insRes, self::ORDERTTL));
        return $this->success($json);
    }
    public function getPrePayId($description,$ins){
        $result = $this->payApp->order->unify([
            'body' => $description,
            'out_trade_no' => time(),
            'total_fee' => 1,
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $ins['openid'],
        ]);
        // Log::info($result);
        if( $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            return $result['prepay_id'];
        }
        Log::error('微信支付签名失败');
        return false;
        
        
    }
}