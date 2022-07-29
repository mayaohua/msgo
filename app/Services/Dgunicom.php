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

class Dgunicom extends BaseService{
    protected static $_URL = 'https://kingcard.dgunicom.com/dgZop';
    protected static $_referrerName = '张家川县星耀科技工作室电子渠道';
    protected static $_referrerCode = '5112688005';
    protected static $_referrerDepartId = '51baqlc';
    protected static $_channel = '08-2278-a50e-9999';
    protected static $_serviceKey = 'c8a42e87bb05364c7fd205c4d1bbeb6ffb4e2282e30018177cc295c3e9c8420d';
    protected static $_header = ['Accept: application/json;charset=UTF-8;'];

    public function sendCaptcha($data){
        $url = self::$_URL.'/api/kcMessageSend';
        $data = [
            'certId' => $data['usercode'],
            'contactNum' => $data['userphone'],
            'channel' => self::$_channel
        ];
        $this->addSign($data);
        dd($data);
    }

    private function addSign(&$params){
        ksort($params);
        $json = $params;
        $json = json_encode($json);
        $json = urldecode($json);
        $sign = strtoupper(md5($params));
        $params.push(['sign',$sign]);
        return  $params;
    }
}