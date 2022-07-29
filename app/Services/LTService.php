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

class LTService extends BaseService{


    private static $_U = 'PgQXFjs/sM3ncEmzSrq6bQ==';

    public function sendCaptcha($mobile){
        $url = 'https://msgo.10010.com/lsd-message/send/captcha/phone/v1?phoneNumber='.$mobile;
        $res = $this->curl_request($url);
        $res = json_decode($res,1);
        return $res;
    }

    public function putOrder($numberData,$userData,$cardData){
        $u = self::$_U;
        $postJson = '{
            "numInfo":{
                "essProvince":"'.$numberData['province']['ess_code'].'",
                "essCity":"'.$numberData['city']['ess_code'].'",
                "number":"'.$numberData['mobile'].'"
            }
            ,"goodInfo":{
                "goodsId":"'.$cardData['card_product_id'].'",
                "sceneFlag":"03"
                ,"firstMonthType":"'.$numberData['firstMonthFee'].'"}
            ,"postInfo":{
                "webProvince":"'.$userData['province']['code'].'",
                "webCity":"'.$userData['city']['code'].'",
                "webCounty":"'.$userData['twon']['code'].'",
                "address":"'.$userData['address'].'"
            }
            ,"certInfo":{
                "certTypeCode":"02",
                "certName":"'.$userData['username'].'",
                "certId":"'.$userData['usercode'].'",
                "contractPhone":"'.$userData['userphone'].'"
            }
            ,"captchaInfo":{
                "type":"00",
                "captcha":"'.$userData['captcha'].'"
            },
            "u":"'.$u.'",
            "channel":"9999",
            "marketingStatus":"0"
            }';
            $orderResult=self::request_by_curl("http://msgo.10010.com/scene-buy/scene/buy",$postJson);
            $result = json_decode($orderResult,1);
            if($result['rspCode'] === '0000'){
                Log::info($result);
                Log::info($numberData['province']['ess_code']);
                $resultAuth = self::userAuth($result['orderId'],$numberData['province']['ess_code']);
                $resultData = [
                    'orderId' => $result['orderId'],
                    'orderNo' => $result['orderNo'],
                    'traceId' => $result['traceId'],
                    'from' => 'lt',
                ];
                if($resultAuth['rspBody']){
                    $resultData['shortUrl'] = $resultAuth['rspBody'];
                }
                return ['msg' => '','data' => $resultData ,'code' => 0];
            }
            return ['msg' => $result['rspDesc'],'data' => [] ,'code' => -1];
    }

    public function userAuth($orderId,$provinceCode){//人脸认证
        $data = [
            'orderId' => $orderId,
            'provinceCode' =>  $provinceCode,
        ];
        $result=self::curl_request("http://msgo.10010.com/order-server/qry/photoLink",$data);
        $result = json_decode($result,1);
        return $result;
    }
    
}
