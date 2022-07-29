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
use App\Services\MarketService;
use App\Models\WebUser;
use App\Models\UserOrder;
use App\Models\WebSellUser;
use Illuminate\Support\Facades\Session;
use QL\QueryList;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Client;

class BillService extends BaseService{
    protected static $_URL = 'http://aa.cz500.top/unicomAync';
    protected static $_userId = '543';
    protected static $_privatekey = 'c8a42e87bb05364c7fd205c4d1bbeb6ffb4e2282e30018177cc295c3e9c8420d';
    protected static $_header = ['Accept: application/json;charset=UTF-8;'];
    

    
    /**
     * 转接到平台充值
     */
    public function mobileBill($order_id){
        $marketService = new MarketService;
        $orderDb = PhoneBillOrder::find($order_id);
        if(!$orderDb){
            return ;
        }
        $bill_data = json_decode($orderDb->bill_data);
        $res = $this->buy($bill_data);
        Log::info('充值返回结果：');
        Log::info($res);
        $phone = substr_replace($bill_data->bill_mobile, '****', 3, 4);

        if(!$res['success']){

            $fail_msg = isset($res['desc'])?$res['desc']:'充值失败,发起退款';
            $this->refund($orderDb,$fail_msg);
            
            try {
                //通知用户下单消息
                if($orderDb->bill_user_openid){
                    $first = '非常抱歉，订单充值失败，将会为您自动退款';
                    $remark = '充值商品 '.$orderDb->bill_type_name;
                    $phone = substr_replace($bill_data->bill_mobile, '****', 3, 4);
                    $marketService->nactive_bill_fail($orderDb->bill_user_openid,$phone,$first,$bill_data->sale_price,$remark);
                    Log::info('success');
                }
            } catch (\Exception $e) {
                Log::info('充值失败消息错误1：');
                Log::info($e);
            }

            // try {
            //     // 通知分销用户下单消息
            //     $user = WebUser::find($bill_data->sell_user_openid);
            //     $first = '非常抱歉，您有客户充值失败，订单佣金失效';
            //     $remark = '充值商品：'.$orderDb->bill_type_name;
            //     $phone = substr_replace($bill_data->bill_mobile, '****', 3, 4);
            //     $marketService->nactive_bill_fail($bill_data->sell_user_openid,$phone,$first,$bill_data->sale_price,$remark,true);
            // } catch (\Exception $e) {
            //     Log::info('充值失败消息错误2：');
            //     Log::info($e);

            // }

        }else{
            $status = 5;
            $msg = false;
            $orderDb->changeStatus($status,$msg);
            $orderDb->bill_biz_order_id = $res['bizOrderId'];
            $orderDb->save();
            
            try {
                //通知用户下单消息
                $marketService->nactive_pay($orderDb->bill_user_openid,$phone,$bill_data->sale_price,$orderDb->bill_type_text);
                WebSellUser::where('user_openid',$orderDb->bill_user_openid)->increment('order_count');
            } catch (\Exception $e) {
                Log::info('充值失败消息错误2：');
                Log::info($e);

            }
            //创建分销订单并发送充值消息给分销用户
            $userDb = WebUser::where('user_key',$bill_data->user_key)->first();

            if($userDb && $orderDb->bill_user_openid == $userDb->user_openid){
                return ;
            }

            try {
                
                if($userDb){
                    $order_info = [
                        'bill_phone' => $phone,
                        'bill_info' => $bill_data,
                    ];
                    $data = [
                        'order_type' => 'bill',
                        'order_uuid' => $orderDb->bill_app_order_id,
                        'order_name' => $bill_data->bill_type_name.'，'.$bill_data->type_text,
                        'order_info' => json_encode($order_info),
                        'order_money' => $bill_data->UserFreePrice,
                        'user_id' =>  $userDb->id,
                        'order_id' => $orderDb->id,
                        'order_status' => 1,
                    ];
                    $userDb->user_order_count = intval($userDb->user_order_count)+1;
                    $userDb->save();
                    UserOrder::create($data);
                    //$marketService->nactive_pay($bill_data->sell_user_openid,$phone,$bill_data->sale_price,$orderDb->bill_type_text,true);
                }
            } catch (\Exception $e) {
                Log::error('用户话费充值中，发送消息通知给合伙人失败');
                Log::info($e);
            }

            try {
                $first = $orderDb->bill_type_name.'（'.$bill_data->bill_mobile.'）';
                $order_type_name = '充值业务';
                $order_id = $orderDb->bill_app_order_id;
                $time = $orderDb->created_at;
                $remark = '用户话费充值中消息通知';
                $marketService->nactive_mayh($first,$order_type_name,$order_id,$time,$remark);
            } catch (\Exception $e) {
                Log::error('用户申请卡号，发送消息通知给合伙人失败');
            }
        }
    }
    
    public function refund($orderDb,$fail_msg){
        
        //首先充值失败了，然后退款
        $status = 4;
        $orderDb->changeStatus($status,$fail_msg);
        $orderDb->save();
        //发起退款
        Log::info('发起退款');
        $out_refund_no = md5(time());
        $total_fee = bcmul($orderDb->bill_money , 100 ,0);
        $app = Factory::payment(config('wechat.payment.default'));
        
        $result = $app->refund->byOutTradeNumber($orderDb->bill_app_order_id, $out_refund_no , $total_fee , $total_fee, [
            'refund_desc' => '充值失败,发起退款',
            'notify_url'  => config('wechat.payment.default.reback_notify_url'),
        ]);
        Log::info($result);
        if($result['return_code'] == 'SUCCESS'){
            if(isset($result['result_code']) && $result['result_code'] == 'SUCCESS'){
                
                $status = 6;
                $msg = '充值异常，发起退款';
                $orderDb->changeStatus($status,$msg);
                $orderDb->save();
                return ;
            }
        }
        $status = 8;
        $msg = '发起退款失败';
        $orderDb->changeStatus($status,$msg);
        $orderDb->save();
    }

    public function sysBillData(){
        try {
            $service_data = $this->getBrData();
            if(!$service_data){
                return '同步失败，登录失败';
            }
            
            DB::beginTransaction();
            Bill::where('id','>',0)->update([
                'stop_sale' => 1
            ]);
            $bill = Bill::with('sell_data')->get();
            foreach($bill as $b){
                foreach($service_data as $v){
                    if($v['bianhao'] != $b->itemId){
                        continue;
                    }
                    $v['zhekou_x'] = bcdiv($v['zhekou'],100,3);
                    $face_price =   bcdiv($v['shoujia'],$v['zhekou_x'],2);
                    $face_price = bcmul($face_price,1000, 2);
                    $b->itemProfit = $v['zhekou'];
                    $b->itemFacePrice = floatval($face_price);
                    $b->stop_sale = ($v['zhuangtai'] == '正常' ? 0 : 1);
                    $sell_data = getSellData($b);
                    $b->sell_data->update($sell_data);
                    $b->save();
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info('同步失败，'.$e->getMessage());
            return '同步失败，'.$e->getMessage();
        }
       
    }
    
    private function getBrData(){
        $dataHtml = $this->getHtmlData();
        if(!strstr($dataHtml,'马耀华')){
            $res = $this->loginAction();
            if(!$res){
                $res = $this->loginAction();
            }
            $dataHtml = $this->getHtmlData();//修改
        }
        if(!strstr($dataHtml,'马耀华')){
            return false;
        }
        $data = QueryList::Query($dataHtml,[
            'table_html' => ['.table-responsive .table-bordered>tbody','html'],
        ])->data;
        // dd($data);
        $rules = [
            'table_html' => ['table','html'],
        ];
        $range = 'table';
        $table_html = $data[0]['table_html'];
        // dd($table_html);
        $tables = QueryList::Query($table_html,$rules)->data;
        $all_arr = [];
        foreach($tables as $key => $value){
            $table_html = $value['table_html'];
            $str_count = substr_count($table_html,'</font>');
            // dd($str_count);
            $rules = [
                'bianhao' => ['tr:eq(0) td:gt(0)','text'],
                'mianzhi' => ['tr:eq(1) td:gt(0)','text'],
                'mingcheng' => ['tr:eq(2) td:gt(0)','text'],
                'shoujia' => ['tr:eq(3) td:gt(0)','text'],
                'zhuangtai' => ['tr:eq(4) td:gt(0)','text'],
                'zhekou' => ['tr:eq(5) td:gt(0)','text'],
            ];
            
                QueryList::Query($table_html,$rules)->getData(function($item) use(&$all_arr){
                    $item['shoujia'] = number_format(str_replace('元','',$item['shoujia']),2);
                    $item['zhekou'] = number_format(str_replace(' 折(%)','',$item['zhekou']),2);
                    //$item['mianzhi'] = number_format(str_replace('元','',$item['mianzhi']),2);
                    // dd($item);
                    $all_arr[] = $item;
                    return $item;
                }); 
            
        }
        return $all_arr;
    }
    
    private function loginAction(){
        
        try {
            
            $client =new Client(['base_uri' => 'http://br.cz500.top']);
            //cookie文件
            $cookie_file = storage_path('app/cookie.txt');
            $jar = new CookieJar();
            //请求一次，存储cookie
            $response = $client->request('GET','/index.do',[
                'cookies' => $jar
            ]);
            
            $cookieArr = $jar->toArray();
            file_put_contents($cookie_file, json_encode($cookieArr));

            $cookieArr2 = file_get_contents($cookie_file);
            $cookieArr2 = json_decode($cookieArr2, true);
            $jar2 = new CookieJar(false, $cookieArr2);
            
            //获取验证码内容
            $response = $client->request('GET','/admin/checkCode.do',[
                'cookies' => $jar2
            ]);
            
            $body = $response->getBody();
            $file_content = (string)$body;

            $filename = 'appp/cap.png';//重命名
            Storage::disk('uploads')->put($filename, $file_content);

            $vcode = verify_code($file_content);
            $vcode = json_decode($vcode,1);
            
            $code = $vcode['VERIFY_CODE_ENTITY']['VERIFY_CODE'];
            if(!$code){
                return false;
            }
            // $code = '1234';
            //获取加密数据
            $headers = [
                "Host"=>" br.cz500.top",
                "Origin"=>" http://br.cz500.top",
                "Referer"=>" http://br.cz500.top/index.do"
            ];
            $response = $client->request('GET','/index/getPublicKey.do',[
                'headers' => $headers,
                'cookies' => $jar2
            ]);
            $result = (string)$response->getBody();
            $result = json_decode($result,1);
            $module = $result['module'];
            $url = 'https://msgo.xyz/br.html';
            $empoent = $module['empoent'];
            $module = $module['module'];
            $command = "/usr/local/bin/phantomjs /www/wwwroot/msgo.xyz/public/br.js {$url} $empoent $module";  //这个地方是真正调用phantomjs这个程序的。使用路径来实现调用
            @exec($command,$output_main);
            if(!isset($output_main[0])){
                return false;
            }
            $pwd = $output_main[0];
            //模拟登陆
            $response = $client->request('POST','/login.do',[
                'form_params' => [
                    "pwd"=> $pwd,
                    "name"=> "myh",
                    "password"=> "",
                    "checkCode"=> $code
                ],
                'headers' => $headers,
                'cookies' => $jar2
            ]);
            $result = (string)$response->getBody();
            if(strstr($result,'马耀华')){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function getHtmlData(){
        $client =new Client(['base_uri' => 'http://br.cz500.top']);
        $cookie_file = storage_path('app/cookie.txt');
        $cookieArr2 = file_get_contents($cookie_file);
        $cookieArr2 = json_decode($cookieArr2, true);
        $jar2 = new CookieJar(false, $cookieArr2);
        $headers = [
            "Host"=>" br.cz500.top",
            "Origin"=>" http://br.cz500.top",
            "Referer"=>" http://br.cz500.top/index.do"
        ];
        $response = $client->request('GET','/sale/userItemExport.do',[
            'headers' => $headers,
            'cookies' => $jar2
        ]);
        return (string)$response->getBody();
    }

    private function getSellData($value){
        //商品面值
        $sell_data  = (object) [];
        $facePrice = floatval(bcdiv($value->itemFacePrice , 1000, 3));
        $sell_data->facePrice = $facePrice;
        //商品折扣率
        $bill_profit = $value->itemProfit;
        if($bill_profit == -1){
            $bill_profit = BillCase::find($value->bill_case_id)->first()->item_profit;
        }
        $bill_profit = floatval(bcdiv($bill_profit , 100, 3));
        //进货价
        $sell_data->itemSalePrice = floatval(bcmul($facePrice,$bill_profit,2));
        //剩余利润 
        $sell_data->itemFreePrice = floatval(bcsub($facePrice , $sell_data->itemSalePrice,2));
        //平台利润率
        $app_profit_later = $value->app_profit;
        if($value->app_profit == -1){
            $app_profit_later = Setting::where('key','app_profit')->first()->app_profit;
        }
        $app_profit_later = floatval(bcdiv($app_profit_later , 100, 3));
        //平台出售利润
        $sell_data->AppFreePrice = floatval(bcmul($sell_data->itemFreePrice , $app_profit_later,2));
        //平台出售价
        $sell_data->AppSalePrice = floatval(bcadd($sell_data->AppFreePrice , $sell_data->itemSalePrice,2));

        //分销者利润率
        $user_profit_later = $value->user_profit;
        if($value->user_profit == -1){
            $user_profit_later = Setting::where('key','user_profit')->first()->user_profit;
        }
        $user_profit_later = floatval(bcdiv($user_profit_later , 100, 3));
        //分销剩余利润
        $ProfixFreePrice = $sell_data->ProfixFreePrice = floatval(bcmul($sell_data->itemFreePrice , $user_profit_later,2));
        // dd($ProfixFreePrice);
        //分销者出售平台利润率
        $user_app_profit_later = $value->user_app_profit;
        if($value->user_app_profit == -1){
            $user_app_profit_later = Setting::where('key','user_app_profit')->first()->user_app_profit;
        }
        $user_app_profit_later = floatval(bcdiv($user_app_profit_later , 100, 3));
        
        //分销者出售平台利润
        $sell_data->UserAppFreePrice = floatval(bcmul($ProfixFreePrice , $user_app_profit_later,2));
        
        //分销者利润
        $sell_data->UserFreePrice = floatval(bcsub($ProfixFreePrice , $sell_data->UserAppFreePrice,2));
        //分销者出售价
        $sell_data->UserSalePrice = floatval(bcadd($sell_data->ProfixFreePrice , $sell_data->itemSalePrice,2));
        return (array) $sell_data;
    }

    public function getBillCase(){
        $arr = [
            [
                'name'=>'联通',
                'type_id' => '3',
                'data' => $this->getCase(['bizId'=>200])
            ],
            [
                'name'=>'电信',
                'type_id' => '2',
                'data' => $this->getCase(['bizId'=>202])
            ],
            [
                'name'=>'移动',
                'type_id' => '1',
                'data' => $this->getCase(['bizId'=>201])
            ],
            [
                'name'=>'会员',
                'type_id' => '4',
                'data' => $this->getCase(['bizId'=>3500])
            ],
            [
                'name'=>'联通',
                'type_id' => '7',
                'data' => $this->getCase(['bizId'=>100])
            ],
            [
                'name'=>'电信',
                'type_id' => '6',
                'data' => $this->getCase(['bizId'=>101])
            ],
            [
                'name'=>'移动',
                'type_id' => '5',
                'data' => $this->getCase(['bizId'=>102])
            ],
        ];
        return $arr;
    }

    public function getAllCase(){
        $arr = array_merge($this->getCase(['bizId'=>200]),$this->getCase(['bizId'=>202]),$this->getCase(['bizId'=>201]));
        foreach($arr as $index => $value){
            $arr[$index]['info'] = '72小时到账';
            $arr[$index]['itemSalesPrice'] = $value['itemFacePrice'];
            
        }
        // dd($arr);
        return $arr;
    }

    public function buy($info){
        $url = self::$_URL.'/buy.do';
        $dtCreate = date('YmdHis');
        $data = [
            'userId' => self::$_userId,
            'itemId' => $info->itemId,//商品ID
            'checkItemFacePrice' => $info->itemFacePrice,//商品面值
            'uid'=>$info->bill_mobile,//充值手机号
            'serialno'=>$info->bill_app_order_id,//合作方商户系统的流水号
            'dtCreate' => $dtCreate,
        ];
        ksort($data);
        foreach($data as $key => $value){
            if(isset($data['sign'])){
                $data['sign'] .= $value;
            }else{
                $data['sign'] = '';
                $data['sign'] = $value;
            }
            
        }
        $data['sign'].= self::$_privatekey;
        $data['sign'] = md5($data['sign']);
        $result = parent::curl_request($url.'?'.http_build_query($data),'',self::$_header);
        $result = json_decode($result,1);
        $success = false;
        if($result['code'] == '00'  || $result['code'] == '23' || $result['code'] == '31'){
            $success = true;
        }
        $result['success'] = $success;
        return $result;
    }

    public function queryOrder($bill_app_order_id){
        $url = self::$_URL.'/queryBizOrder.do';
        $data = [
            'userId' => self::$_userId,
            'serialno' => $bill_app_order_id,
            'sign' => md5($bill_app_order_id.self::$_userId.self::$_privatekey)  
        ];
        $result = parent::curl_request($url.'?'.http_build_query($data),'',self::$_header);
        $result = json_decode($result,1);
        return $result;
    }

    public function surplus(){
        $url = self::$_URL.'/queryBalance.do';
        $data = [
            'userId' => self::$_userId,
            'sign' => md5(self::$_userId.self::$_privatekey)  
        ];
        $result = parent::curl_request($url.'?'.http_build_query($data),'',self::$_header);
        $result = json_decode($result);
        return $result;
    }

    public function getCase($info){
        $url = 'http://aa.cz500.top'.'/common/queryUserItemList.do';
        $data = [
            'userId' => self::$_userId,
            'bizId' => $info['bizId'],
            'sign' => md5($info['bizId'].self::$_userId.self::$_privatekey)  
        ];
        $result = parent::curl_request($url.'?'.http_build_query($data),'',self::$_header);
        $result = json_decode($result,1);
        return $result['data'];
    }

    private function creatOrderId(){
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
}
