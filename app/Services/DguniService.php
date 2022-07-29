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

class DguniService extends BaseService{
    protected static $_URL = 'https://kingcard.dgunicom.com/dgZop';

    protected static $_referrerName = '张家川县星耀科技工作室电子渠道';
    protected static $_referrerCode = '5112688005';
    protected static $_referrerDepartId = '51baqlc';
    protected static $_channel = '08-2278-a50e-9999';
    protected static $_serviceKey = 'dg_9309_IQYI4DIKLG29W7J96KXC86YIX';

    // protected static $_referrerName = '日照善赢通信科技有限公司电子渠道';
    // protected static $_referrerCode = '5112366779';
    // protected static $_referrerDepartId = '51bak75';
    // protected static $_channel = '08-2278-a3me-9999';
    // protected static $_serviceKey = 'dg_8456_BWLADBVNB1SDZE4W3QEDU03AB';


    public function numSelect($data){
        $url = self::$_URL.'/api/numSelect';
        $data = [
            'provinceCode' => $data['provinceCode'],
            'cityCode' => $data['cityCode'],
            'searchCategory' => '3',
            'goodsId' => $data['product_id'],
            'searchType' => strlen($data['search'])?'01':'',
            'searchValue' => $data['search'],
            'amounts' => '20',
        ];
        return self::to_request($url,$data);
    }

    public function sendCaptcha($data){
        $url = self::$_URL.'/api/kcMessageSend';
        $data = [
            'certId' => $data['usercode'],
            'contactNum' => $data['userphone'],
            'channel' => self::$_channel
        ];
        return self::to_request($url,$data);
    }

    public function checkCaptcha($data){
        $url = self::$_URL.'/api/kcMessageCheck';
        $data = [
            'certId' => $data['usercode'],
            'contactNum' => $data['userphone'],
            'channel' => self::$_channel,
            'captcha' =>  $data['captcha']
        ];
        return self::to_request($url,$data);
    }

    public function putOrder($numberData,$userData,$cardData){
        $captchaRes = $this->checkCaptcha($userData);
        if($captchaRes['rspCode'] != '0000'){
            return ['msg' => $captchaRes['rspDesc'],'data' => [] ,'code' => -1];
        }
        $captchaRes['body'] = json_decode($captchaRes['body'],1);
        $captchaId = $captchaRes['body']['ID'];
        $url = self::$_URL.'/api/cardOrderOrdersync';
        $data = [
            'orderId'           => $cardData['card_app_order_id'],      //合作方订单号
            'productType'       => $cardData['card_product_type'],      // 	Y	String	V4	产品标识：见说明1.4
            'orderType'         => '0',	                                //Y	String	F1	订单类型:0-物流配送;1-营业厅自提；默认传0
            'phoneNum'          => $numberData['mobile'],               //	Y	String	V20	号码
            'contactNum'        => $userData['userphone'],              //	Y	String	V20	联系电话
            'certName'          => $userData['username'],               //	Y	String	VY0	入网人姓名
            'certNo'            => $userData['usercode'],	            //Y	String	F18	入网人身份证号码 ，（身份证中的X要求大写）
            'provinceCode'      => $numberData['province']['ess_code'], //	Y	string	V2	省份编码，号码归属的省份，注意是2位编码 ，如 广东：51
            'cityCode'          => $numberData['city']['ess_code'],     //	Y	string	V3	地市编码，号码归属的城市，注意是3位编码，如东莞：580，若provinceCode为51，cityCode固定580
            'postProvinceCode'  => $userData['province']['code'],       //	Y	String	F6	收货省份，物流配送订单必传，注意是6位编码
            'postCityCode'      => $userData['city']['code'],           //	Y	String	F6	收货地市，物流配送订单必传，注意是6位编码
            'postDistrictCode'	=> $userData['twon']['code'],           //Y	String	F6	收货区县，物流配送订单必传，注意是6位编码
            'postAddr'          => $userData['address'],                //	Y	String	V200	详细地址，物流配送订单必传
            'postName'          => $userData['username'],               //	Y	String	V20	收货人姓名，物流配送订单必传
            'custId'            => $cardData['card_prokey'],            //	Y	String	V16	下单用户关键字,代表下单唯一用户，随机数，需以“99999”开头，最长16位数字，不同订单尽量不要重复；与号码状态变更接口的号码预占关键字proKey保持传值一致
            'referrerName'      => self::$_referrerName,                //	Y	String	V150	发展人姓名
            'referrerCode'      => self::$_referrerCode,                //	Y	String	V40	发展人编码,51开头，十位数
            'referrerDepartId'  => self::$_referrerDepartId,            //	Y	String	V40	发展人部门ID（即渠道编码）
            'firstMonthFee'	    => $numberData['firstMonthFee'],        //N	String	V20	首月资费方式（5G套餐不能为空）：A000011V000001-全月资费；A000011V000002-半月资费；A000011V000003-标准资费
            'goodsId'           => $cardData['card_product_id'],        //Y	String	V20	商品编号，见说明1.3
            'channel'           => self::$_channel,                     //	Y	String	V20	触点编码
            'captchaId'         => $captchaId
        ];
        $result = self::to_request($url,$data);
        if($result['rspCode'] == '0000'){
            $resultData = json_decode($result['body'],1);
            $resultData['traceId'] = $result['uuid'];
            $resultData['from'] = 'gd';
            return ['msg' => '','data' => $resultData ,'code' => 0];
        }
        return ['msg' => $result['rspDesc'],'data' => [] ,'code' => -1];
    }

    private static function to_request($url,&$data){
        self::addSign($data);
        // dd($data);
        $result = parent::curl_request_json($url,$data);
        return $result;
    }

    private static function addSign(&$params){
        $params = array_filter($params,function($v){
            if( $v === null || $v === '' ){
                return false;
            }
            return true;
        });
        $params['serviceKey'] = self::$_serviceKey;
        ksort($params);
        $json = $params;
        $json = json_encode($json,JSON_UNESCAPED_UNICODE);
        // dd($json);
        // $json = urldecode($json);
        $sign = strtoupper(md5($json));
        $params['sign'] = $sign;
        return  $params;
    }
}