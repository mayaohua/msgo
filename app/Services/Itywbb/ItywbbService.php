<?php
namespace App\Services\Itywbb;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class ItywbbService extends BaseService{
    
    protected static $_URL = 'http://lt1588.com/api';
    protected static $_sourceType = '2020102809610';

    //生成正式单
    public function putOrder($info){
        $url = self::$_URL.'/book/';
        $data = [
            "mob"=>$info['mobile'],
            "name" => $info['user_name'],
            "idcard"=> $info['user_code'],
            "phone"=> $info['user_phone'],
            "addr"=> $info['address'],
            "ref"=>self::$_sourceType
        ];
        $result = parent::curl_request($url.'?'.http_build_query($data));
        $result = json_decode($result);
        if(!$result){
            return [
                'rspCode'=>'0001',
                'rspDesc'=>'系统错误'
            ];
        }
        if($result->code == '0025'){
            return [
                'rspCode'=>'0000',
                'rspDesc'=>'下单成功'
            ];
        }else{
            return [
                'rspCode'=>'0001',
                'rspDesc'=>$result->msg
            ];
        }
    }
    //查询号码
    public function getAllMobile(){
        $url = self::$_URL.'/seach/';
        $data = [
            "all"=>'y'
        ];
        $result = parent::curl_request($url.'?'.http_build_query($data));
        $result = json_decode($result);
        return $result;
    }
}