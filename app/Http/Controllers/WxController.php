<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use App\Models\PhoneBillOrder;
use Carbon\Carbon;
use App\Jobs\CloseBillOrder;
use App\Models\BillType;
use App\Models\BillCase;
use App\Models\Bill;
use Illuminate\Support\Facades\Session;

class WxController extends Controller
{
    protected static $_header = ['Content-Type: application/json;charset=UTF-8;'];
    const APPID = "wx397218daf538dc63";
    const LOGINWAY = "snsapi_base";
    const APPSECRET = 'b9b82d96c09516fae800e6305b0b1243';
    const MCHID = '1609178328';
    const MCHSECRET = 'Aa123413QWERTYUIOlkjhgfdsa123413';
    const PREPAY_URL = 'https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi';
    const reback_notify_url = 'https://wx.1001020.cn/m/wechatreback-notify';
    const ORDERTTL = 5 * 60;

    protected $payApp = null;
    protected $offApp = null;

    public function __construct(){
        $this->payApp = Factory::payment(config('wechat.payment.default'));
        $this->offApp = Factory::officialAccount(config('wechat.official_account.default'));
        $this->bill = new BillService();
    }

    public function getJSSDKConfig(Request $request){
        $arr = explode(',',$request->get('apis'));
        $debug = $request->get('debug') ==='true' ? true : false;
        $json = $request->get('json') ==='true' ? true : false;
        $url =$request->get('url');
//        dump($request->get('url'));
        // check
        // if(!$url){
        //     return $this->fail('params error');
        // }
        // dd($url);
        $this->offApp->jssdk->setUrl($url);
        // return 1;
        // dd($arr,$debug,$json,$url);
        $config = $this->offApp->jssdk->buildConfig($arr,$debug,$json,false);
        return $this->success($config);
    }

    
    public function vipList(Request $request){
        $input = $request->get('mobile');
        if($input){
            $isp = $this->get_mobile_info($input);
            if(!$isp){return $this->fail('???????????????????????????',-1,['list'=> false,'ips'=> null]);}
        }
        
        $res = BillType::where('type_isp','vip')->with(['billcases'=>function($query){
            $query->where('stop_sale',0)->with(['bills'=>function($query){
                $query->where('stop_sale',0);
            }]);
        }])->get();
        foreach($res as $a){
            foreach($a->billcases as $b){
                foreach($b->bills as $c){
                    $num = bcadd($c->itemSalesPrice/1000 , $c->app_sale_profit , 2);
                    $c->sale_price = $num.'???';
                }
                foreach($b->bills as $c){
                    $num = sprintf("%.2f",$c->itemFacePrice/1000);
                    $c->vip_price = $num.'???';
                }
            }
        }
        return $this->success(['list'=>$res,'ips'=> (isset($isp) ? $isp : null)]);
    }

    public function billAllList(Request $request){
        $input = $request->get('mobile');
        if($input){
            $isp = $this->get_mobile_info($input);
            if(!$isp){return $this->fail('???????????????????????????',-1,['list'=> false,'ips'=> null]);}
            $res = BillType::where('type_name',$isp['sp'])->with(['billcases'=>function($query){
                $query->where('stop_sale',0)->with(['bills'=>function($query){
                    $query->where('stop_sale',0);
                }]);
            }])->get();
        }else{
            $res = BillType::whereIn('type_isp',[10000,10010,10086])->with(['billcases'=>function($query){
                $query->where('stop_sale',0)->with(['bills'=>function($query){
                    $query->where('stop_sale',0);
                }]);
            }])->get();
        }
        
        foreach($res as $a){
            foreach($a->billcases as $b){
                foreach($b->bills as $c){
                    $num = bcadd($c->itemSalesPrice/1000 , $c->app_sale_profit , 2);
                    $c->sale_price = $num.'???';
                }
            }
        }
        return $this->success(['list'=>$res,'ips'=> (isset($isp) ? $isp : null)]);
    }

    public function test(){
        Log::info(1);
        // $order = PhoneBillOrder::find(152);
        // $this->createThreeOrder($order->toArray());
    }

    public function index(Request $request){
        // ?????????
        $user = Session::get('wechat_user');
        if(!$user) {
            Session::put('target_url',$request->url());
            Session::save();
            // $_SESSION['target_url'] = $request->url();
            $redirectUrl = $this->offApp->oauth->scopes(['snsapi_userinfo'])->redirect();
            return $redirectUrl;
        }
        // ???????????????
        \View::addExtension('html', 'php');
        return  view()->file(public_path().'/wx/index.html');
    }

    public function oauth_callback(Request $request){
        $code = $request->get('code');
        // $user = $this->offApp->oauth->userFromCode($code);
        $user = $this->offApp->oauth->user()->toArray();
        Session::put('wechat_user', $user);
        Session::save();
        $targetUrl = empty(Session::get('target_url')) ? '/pay/' : Session::get('target_url');
        return redirect($targetUrl);
    }

    public function token_ver(){
        return $this->offApp->server->serve();
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

    public function vmobile(Request $request){
        $input = $request->get('mobile');
        $url = 'http://cx.shouji.360.cn/phonearea.php?number='.$input;
        $res = $this->curl_request($url);
        $res = json_decode($res,1);
        if($res['code'] == 0 && (isset($res['data']['province']) && $res['data']['province'] !== '')){
            return $this->success($res['data']);
        }else{
            return $this->fail('?????????????????????');
        }
        
    }

    public function billCaseList(){
        $arr = [
            [
                'name'=>'??????',
                'is_show' => true,
                'bizId' => 200,
                'data' => [],
                'ndata' => []
            ],
            [
                'name'=>'??????',
                'is_show' => true,
                'bizId' => 202,
                'data' => [],
                'ndata' => []
            ],
            [
                'name'=>'??????',
                'is_show' => true,
                'bizId' => 201,
                'data' => [],
                'ndata' => []
            ],
        ];
        $datat = config('billcase.items');
        foreach($datat as $k => $v){
            $inn = 2;
            if($v['bizId'] == 200){
                $inn = 0;
            }else if($v['bizId'] == 202){
                $inn = 1;
            }
            $arr[$inn]['data'][] = $v;
            $ndata = [
                'name'=>$v['areaCodeDesc'].'??????????????????????????????',
                'as_name'=>$v['areaCodeDesc'],
                'is_show' => true,
                'data'=>[$v]
            ];
            if(!isset($arr[$inn]['ndata'][$v['areaCode']])){
                
                $arr[$inn]['ndata'][$v['areaCode']] = $ndata;
            }else{
                $arr[$inn]['ndata'][$v['areaCode']]['data'][] = $v;
            }
        }
        // dd($arr);
        return $this->success($arr);
    }
    public function billCaseLists(){
        $arr = [
            [
                'name'=>'??????',
                'is_show' => true,
                'bizId' => 200,
                'data' => []
            ],
            [
                'name'=>'??????',
                'is_show' => true,
                'bizId' => 201,
                'data' => []
            ],
            [
                'name'=>'??????',
                'is_show' => true,
                'bizId' => 202,
                'data' => []
            ],
            
        ];
        $settingObj = Setting::where('key','wxForm')->first()->value;
        $settingObj = json_decode($settingObj,1);
        $dbData = $settingObj['caseList'];
        $datat = config('billcase.items');
        foreach($arr as $index => $value){
            $arrt = [200,201,202];
            $iii = array_search($value['bizId'],$arrt);
            $vvv = $dbData[$iii]['items'];
            foreach($vvv as $i=>$v){
                $vvv[$i]['data'] = $this->getCaseAllValue($v['value'],$datat);
                unset($vvv[$i]['value']);
            }
            $arr[$index]['data'] = $vvv;
        }
        // dd($arr);
        return $this->success($arr);
    }

    private function getCaseAllValue($a,$b){
        $arr = [];
        foreach($a as $value){
            foreach($b as $v){
                if($value['id'] === $v['id']){
                    $v['is_show'] = true;
                    $arr[]=$v;
                }
            }
        }
        return $arr;
    }

    public function refundBack(){
        //????????????
        Log::info('????????????===>');
        $response = $this->payApp->handleRefundedNotify(function ($message, $reqInfo, $fail) {
            // ?????? $message['req_info'] ???????????????????????????
            // $reqInfo ??? message['req_info'] ??????????????????
          
            $order = PhoneBillOrder::where('bill_seria_ino',$message['out_trade_no'])->first();
            if (!$order || $order->bill_status == 1) { // ????????????????????? ?????? ????????????????????????
                return true; // ???????????????????????????????????????????????????????????????????????????
            }

            if($order && $order->bill_status  != 6){
                $order->bill_fail_msg = '??????????????????????????????????????????????????????';
                $order->save();
                return true;
            }
            if($message['return_code']=='SUCCESS'){
                $update_data = [];
                if($reqInfo['refund_status']=='SUCCESS'){
                    $order->bill_status = 7;
                    $order->bill_fail_msg = '';
                    $order->finished_at = Carbon::now();
                }else{
                    $order->bill_status = 8;
                    $order->bill_fail_msg = '??????????????????';
                    $order->finished_at = Carbon::now();
                }
                
            }else{
                return $fail('????????????????????????????????????');
            }
            $order->save();
            return true; // ?????? true ????????????????????????????????????
            // ????????????????????? $fail('????????????????????????');
        });

        return $response;
    }

    public function notify(){
        Log::info('????????????===>');
        $response = $this->payApp->handlePaidNotify(function($message, $fail){
            // ?????????????????? "?????????????????????" ?????? "???????????????" ?????????????????????????????????
            $order = PhoneBillOrder::where('bill_seria_ino',$message['out_trade_no'])->first();
            if (!$order || $order->bill_status == 1) { // ????????????????????? ?????? ????????????????????????
                return true; // ???????????????????????????????????????????????????????????????????????????
            }

            if($order && $order->bill_status  != 0){
                $order->bill_fail_msg = '????????????????????????????????????????????????';
                $order->save();
                return true;
            }
            ///////////// <- ???????????????????????????????????????????????????????????????????????????????????????????????????????????? /////////////
        
            if ($message['return_code'] === 'SUCCESS') { // return_code ??????????????????????????????????????????
                // ????????????????????????
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    $order->bill_wx_order = $message['transaction_id'];
                    $order->bill_status = 1;
                // ??????????????????
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    $order->bill_status = 3;
                    $order->bill_fail_msg = '??????????????????';
                    $order->finished_at = Carbon::now();
                }
            } else {
                return $fail('????????????????????????????????????');
            }
        
            $order->save(); // ????????????
            if($order->bill_status == 1){
                //??????????????????????????????????????????
                $this->createThreeOrder($order->toArray());
            }
            return true; // ??????????????????
        });
        
        return $response;
    }

    public function createThreeOrder($order){
        $res = $this->bill->buy($order);
        // $res = false;
        $orderDb = PhoneBillOrder::find($order['id']);
        if(!$orderDb){
            return ;
        }
        if(!$res){
            //????????????
            Log::info('????????????');
            $out_refund_no = md5(time());
            $result = $this->payApp->refund->byOutTradeNumber($order['bill_seria_ino'], $out_refund_no , $order['bill_money']/10 , $order['bill_money']/10, [
                // ??????????????????????????????????????????????????????????????????
                'refund_desc' => '????????????',
                'notify_url'  => self::reback_notify_url,
            ]);
            if($result['return_code'] == 'SUCCESS'){
                if(isset($result['result_code']) && $result['result_code'] == 'SUCCESS'){
                    $orderDb->bill_status = 6;
                    $orderDb->save();
                    Log::info('?????????');
                    return ;
                }
            }
            $orderDb->bill_status = 8;
            $orderDb->bill_fail_msg = '????????????';
            $orderDb->finished_at = Carbon::now();
            Log::info('????????????');
            $orderDb->save();
        }else{
            Log::info('???????????????');
            $orderDb->bill_status = 5;
            $orderDb->bill_fail_msg = '';
            $orderDb->bill_biz_order = $res['bizOrderId'];
            $orderDb->save();
            //?????????????????????????????????????????????????????? listenThreeOrder
        }
    }

    public function listenThreeOrder(Request $request){
        Log::info('????????????===>');
        $data = $request->all();
        if($request->get('downstreamSerialno') && $request->get('status')){
            $order = PhoneBillOrder::where('bill_seria_ino',$data['downstreamSerialno'])->first();
            if($order && $order->bill_status == 5){
                if($data['status'] == 2){
                    $order->bill_status = 3;
                    $order->bill_fail_msg = '';
                    $order->finished_at = Carbon::now();
                    $order->save();
                }else if($data['status'] == 3){
                    $order->bill_status = 4;
                    $order->bill_fail_msg = '??????????????????';
                    $order->finished_at = Carbon::now();
                    $order->save();
                }
            }
            return 'SUCCESS';
        }
    }

    public function wxpay(Request $request){
        $user = Session::get('wechat_user');
        $openid = $user['id'];
        $data = [
            'mobile' => '15101210016',
            'itemName' => '????????????'
        ];
        //??????????????????
        //??????????????????
        $ins = [
            'bill_mobile' => $data['mobile'],
        ];
        //?????????????????????????????????
        //?????????????????????
        $prePayId = $this->getPrePayId($data['itemName'],$openid);
        if(!$prePayId){return $this->fail();}
        //???????????????????????????
        $jssdk = $this->payApp->jssdk;
        $json = $jssdk->bridgeConfig($prePayId);
        $json = json_decode($json);
        
        $json->order_id = time();
        //5???????????????????????????????????????????????????????????????????????????????????????????????????0???????????????
        //$this->dispatch(new CloseBillOrder($insRes, self::ORDERTTL));
        return $this->success($json);
    }

    public function cancelOrder(Request $request){
        $oid = $request->get('oid');
        // if(!$oid){
        //     return $this->fail();
        // }
        // $order = PhoneBillOrder::find($oid);
        // if($order->bill_status == 0){
        //     $order->bill_status = 2;
        //     $order->bill_fail_msg = '??????????????????';
        //     $order->finished_at = Carbon::now();
        //     $order->save();
        // }
        
        return $this->success();
    }

    public function userBills(Request $request){
        $openid = $request->get('openid');
        if(!$openid){
            return $this->fail();
        }
        $res = PhoneBillOrder::where('bill_user_openid',$openid)->orderBy('created_at','desc')->get();
        foreach($res as $value){
            $value -> bill_data = json_decode($value -> bill_data);
        }
        return $this->success($res);
    }

    public function queryOrder(Request $request){
        $oid = $request->get('oid');
        if(!$oid){
            return 'fail';
        }
        $result = $this->payApp->order->queryByOutTradeNumber($oid);
        return $result;
    }

    public function getPrePayId($description,$openid){
        $result = $this->payApp->order->unify([
            'body' => $description,
            'out_trade_no' => time(),
            'total_fee' => 1,
            'trade_type' => 'JSAPI', // ???????????????????????????????????????????????????
            'openid' => $openid,
        ]);
        // Log::info($result);
        if( $result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            return $result['prepay_id'];
        }
        Log::error('????????????????????????');
        return false;
        
        
    }

    public function gonggao(){
        $settingObj = Setting::where('key','mobileForm')->first();
        $mobileForm = json_decode($settingObj->value);
        $res = $mobileForm->zixunList;
        return $this->success($res);
    }

    private function creatOrderId(){
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    private function get_mobile_info($input){
        $url = 'http://cx.shouji.360.cn/phonearea.php?number='.$input;
        $res = $this->curl_request($url);
        $res = json_decode($res,1);
        if($res['code'] == 0 && (isset($res['data']['province']) && $res['data']['province'] !== '')){
            return $res['data'];
        }else{
            return false;
        }
        
    }
}