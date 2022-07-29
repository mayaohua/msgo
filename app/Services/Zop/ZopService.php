<?php
namespace App\Services\Zop;
use App\Services\BaseService;
use App\Events\JobWork;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

class ZopService extends BaseService{
    
    protected static $_URL = 'https://smarthome.17wo.cn/wonetplan';
    protected static $_sourceType = 'ZB_ZJWCXJ972';
    protected static $_channel = '';
    protected static $_groupCode = "DIRECT_ORDER_GDZJ_GROUP";
    protected static $_channelId = "51bacrq";
    protected static $_channelKey = "kiG9w01$";
    
    protected $_provices = null;
    public $proviArr = ['市','壮族','回族','维吾尔族','自治','区','县','省'];
    public $cards= [];


    public function __construct()
    {
        $this->_provices = file_get_contents(public_path('app/proviceList.json'));
        $this->_provices = json_decode($this->_provices,1);
    }

    public function getCards(){
        foreach(config('card') as $value){
            foreach($value['card'] as $v){
                if($v['word_id']){
                    $this->cards[] = $value;
                }
            }
        }
        return $this->cards;
    }

    public function sysMobile($location,$card,$page = 1){
        $data = [
            'productCode' => $card['card_goodsid'],
            'groupCode' => self::$_groupCode,
            'province'=> $location['provinceName'],
            'city'=> $location['cityName'],
            'search'=> 'no',
            'page'=> $page,
            'num'=> 100,
            'searchNumber'=> '',
        ];
        // Log::info($data);
        $result = $this->searchMobile($data);
        // if($result->status == '5550' || $result->status == '5188'){
        //     Log::info($location['provinceName']);
        //     Log::info($location['cityName']);
        //     Log::info($card['card_goodsid']);
        // }
        // Log::info(json_encode($result));
        return $result;
    }
    public function test(){
        $phone = Input::get('phone');
        if(!$phone){
            dd('请输入参数phone');
        }
        $result = $this->getActiveMsg($phone);
        // $result = $this->do_mencrypt(123,self::$_channelKey);
        dd($result);
    }

    public function userPutOrder($info){
        // event(new JobWork('10010'));
        //身份验证
        $result = $this->verUserInfo($info);
        if($result->status != '2000'){
            return [
                'rspCode'=>'0001',
                'rspDesc'=>$result->msg
            ];
        }
        //用户选号
        // $data = [
        //     'productCode' => $info['card_gid'],
        //     'groupCode' => self::$_groupCode,
        //     'province'=> $info['loca_p_c'],
        //     'city'=> $info['loca_c_c'],
        //     'search'=> 'yes', //no  yes
        //     'page'=> 1,
        //     'num'=> 10,   //100 10
        //     'searchNumber'=> $info['mobile'],
        // ];
        // $info = array_merge($data,$info);
        // $result = $this->searchMobile($info);
        // dd($result);
        //用户占号
        $data = [
            'productCode' => $info['card_gid'],
            'groupCode' => self::$_groupCode,
            'numberProvince'=>$info['card_province'],
            'numberCity' => $info['card_city'],
            'newNumber'=>$info['mobile'],
            'contact'=>$info['user_phone'],
            'identity'=>$info['user_code'],
            'sourceType' => self::$_sourceType,
        ];
        $result = $this->chooseMobile($data);
        if($result->status!='2000'){
            return [
                'rspCode'=>'0002',
                'rspDesc'=>$result->msg
            ];
        }
        $info['proKey'] = $result->flexData->prokey;
        // //生成意向单
        $info['user_province'] = str_replace($this->proviArr ,'',$info['user_province']);

        $data = [
            "name"=>$info['user_name'],
            "identity"=>$info['user_code'],
            "contact"=>$info['user_phone'],
            'numberProvince'=>$info['card_province'],
            'numberCity' => $info['card_city'],
            "consignee"=>$info['user_name'],
            "province"=>$info['user_province'],
            "city"=>$info['user_city'],
            "area"=>$info['user_area'],
            "address"=>$info['user_info'],
            "productCode"=>$info['card_gid'],
            "groupCode"=>self::$_groupCode,
            "newNumber"=>$info['mobile'],
            "proKey"=>$info['proKey']
        ];
        
        
        $result = $this->createOrder($data);
        if($result->status!='2000'){
            return [
                'rspCode'=>'0003',
                'rspDesc'=>$result->msg
            ];
        }
        $info['orderId'] = $result->flexData;
        //正式下单
        $data = [
            "orderId"=>$info['orderId']
        ];
        $result = $this->putOrder($info);
        if($result->status!='2000') return [
            'rspCode'=>'0004',
            'rspDesc'=>$result->msg
        ];
        return [
            'rspCode'=>'0000',
            'rspDesc'=>'下单成功'
        ];

        //
    }

    public function verUserInfo($info){
        
        $url = self::$_URL.'/thirdPartyOrder/postpositionCheckNameIdentityAsset';
        $data = [
            'name' => $info['user_name'],
            'identity' => $info['user_code'],
            'contact' => $info['user_phone'],
            'sourceType' => self::$_sourceType,
        ];
        $result = parent::curl_request($url,$data);
        $result = json_decode($result);
        return $result;
    }


    //号码搜索
    public function searchMobile($info){
        
        $url = self::$_URL.'/thirdPartyOrder/selectPhone';
        // if(!$info->name || !$info->identity || !$info->contact){
        //     return false;
        // }
        $data = [
            'productCode' => $info['productCode'],
            'groupCode' => $info['groupCode'],
            'province'=> $info['province'],
            'city'=> $info['city'],
            'search'=>$info['search'], //no  yes
            'page'=>$info['page'],
            'num'=>$info['num'],   //100 10
            'searchNumber'=>$info['searchNumber'],
            'sourceType' => self::$_sourceType,
        ];
        $result = parent::curl_request($url,$data);
        $result = json_decode($result);
        return $result;
    }

    //号码占选   占用用户选择的号码，该接口只可占用30分钟,提交订单后延时占用
    public function chooseMobile($info){
        
        $url = self::$_URL.'/thirdPartyOrder/changeStateDirect';
        $data = [
            'productCode' => $info['productCode'],
            'groupCode' => $info['groupCode'],
            'numberProvince'=>$info['numberProvince'],
            'numberCity' => $info['numberCity'],
            'newNumber'=>$info['newNumber'],
            'contact'=>$info['contact'],
            'identity'=>$info['identity'],
            'sourceType' => self::$_sourceType,
        ];
        
        $result = parent::curl_request($url,$data);
        $result = json_decode($result);
        return $result;
    }

    //提交用户信息，生成意向单并同步
    public function createOrder($info){
        
        $url = self::$_URL.'/thirdPartyOrder/postpositionAddPreOrderByPhone';
        $data = [
            "name"=>$info['name'],
            "identity"=>$info['identity'],
            "contact"=>$info['contact'],
            "numberProvince"=>$info['numberProvince'],
            "numbercity"=>$info['numberCity'],
            "consignee"=>$info['consignee'],
            "province"=>$info['province'],
            "city"=>$info['city'],
            "area"=>$info['area'],
            "address"=>$info['address'],
            "productCode"=>$info['productCode'],
            "groupCode"=>$info['groupCode'],
            "sourceType"=>self::$_sourceType,
            "channel"=>self::$_channel,
            "newNumber"=>$info['newNumber'],
            "proKey"=>$info['proKey'],
        ];
        $result = parent::curl_request($url,$data);
        $result = json_decode($result);
        return $result;
    }

    //生成正式单
    public function putOrder($info){
        $url = self::$_URL.'/thirdPartyOrder/postpositionOrderSyc';
        $data = [
            "orderId"=>$info['orderId'],
            "sourceType"=>self::$_sourceType
        ];
        // Log::info($data);
        $result = parent::curl_request($url,$data);
        // Log::info($result);
        $result = json_decode($result);
        return $result;
    }

    //后置选号--验证码发送（走K计划必调）
    public function sendCaptcha($info){
        
        $url = self::$_URL.'/thirdPartyOrder/messageSend';
        $data = [
            "identity"=>$info['identity'],
            'contact' => $info['contact'],
            'channel' => self::$_channel,
            "sourceType"=>self::$_sourceType
        ];
        $result = parent::curl_request($url,$data);
        $result = json_decode($result);
        return $result;
    }

    //后置选号--验证码校验（走K计划必调）
    public function verCaptcha($info){
        
        $url = self::$_URL.'/thirdPartyOrder/messageCheck';
        $data = [
            "identity"=>$info['identity'],
            'contact' => $info['contact'],
            'channel' => self::$_channel,
            'captcha' => $info['captcha'],
            "sourceType"=>self::$_sourceType
        ];
        $result = parent::curl_request($url,$data);
        $result = json_decode($result);
        return $result;
    }
    //查询号码状态
    public function getActiveMsg($phone){
        $url = self::$_URL.'/activeData/activeMsg';
        $round = $this->randstrpay();
        $data = [
            "channelId"=> self::$_channelId,
            "channelKey"=> self::$_channelKey,
            "data"=>[
                'phone'=>$phone
            ],
            'randomCode' => $round,
            'time' =>   date('Y-m-d h:i:s'),
            'key' => self::$_channelKey,
        ];
        $data['data'] = json_encode($data['data']);
        $data['sign'] = urldecode(http_build_query($data));
        $data['data'] = json_decode($data['data'],1);
        $data['sign'] = strtoupper(MD5($data['sign']));
        unset($data['key']);
        $result = parent::curl_request_json($url,$data);
        $result = json_decode($result);
        return $result;
    }
    //32位随机字符串
    private function randstrpay($length=32) {
        $rand='';
        $randstr= '0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($randstr)-1;
        mt_srand((double)microtime()*1000000);
        for($i=0;$i<$length;$i++) {
            $rand.=$randstr[mt_rand(0,$max)];
        }
        return $rand;
    }
    //加密
    private function do_mencrypt($input, $key)
    {
        // dd($input, $key);
        $vi   = mb_convert_encoding($key, 'UTF-8');
        $input = mb_convert_encoding($input, 'UTF-8');
        return base64_encode(openssl_encrypt($input, 'DES-CBC', $key, OPENSSL_RAW_DATA ,$vi));
        //return trim(chop(base64_encode($encrypted_data)));
    }


}