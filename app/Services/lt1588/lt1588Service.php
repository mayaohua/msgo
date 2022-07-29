<?php
namespace App\Services\It1588;
use App\Services\BaseService;

class It1588Service extends BaseService{
    
    protected static $_URL = 'http://lt1588.com/api';
    protected static $_sourceType = '';

    //生成正式单
    public function putOrder($info){
        $url = self::$_URL.'/book';
        $data = [
            "mob"=>$info['mobile'],
            "name" => $info['user_name'],
            "idcard"=> $info['user_code'],
            "phone"=> $info['user_phone'],
            "addr"=> $info['address'],
            "ref"=>self::$_sourceType
        ];
        $result = parent::curl_request($url,$data);
        $result = json_decode($result);
        return $result;
    }
}