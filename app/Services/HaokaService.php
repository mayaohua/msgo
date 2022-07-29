<?php
namespace App\Services;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use App\Models\Card;
class HaokaService extends BaseService{
    
    protected static $_sourceType = '2021052235688';

    //生成正式单
    public function putOrder($numberData,$userData){
        $url = 'http://lt.haokazhushou.com/api/book/';
        $data = [
            "mob"=>$numberData['mobile'],
            "name" => $userData['username'],
            "idcard"=> $userData['usercode'],
            "phone"=> $userData['userphone'],
            "addr"=> $userData['address'],
            "ref"=>self::$_sourceType
        ];
        $result = parent::curl_request($url.'?'.http_build_query($data));
        $result = str_replace('﻿','',$result);
        $result = json_decode($result);
        if(!$result){
            return ['msg' => '系统异常','data' => [] ,'code' => -1];
        }
        if($result->code == '0025'){
            return ['msg' => '申请成功','data' => ['from'=>'dsf'] ,'code' => 0];
        }else{
            return ['msg' => $result->msg,'data' => [] ,'code' => -1];
        }
    }
    //查询号码
    public function getMobile($info){
        $url = 'https://www.10010lh.com.cn/api/search_mobiles_page';
        $data = [
            'provice' => $info['provice'],
            'city' => $info['city'],
            'search' => $info['search'],
            'page' => $info['page'],
            'ze_id' => $info['ze_id'],
            'randon' => $info['randon']?$info['randon']:0
        ];
        $result = parent::curl_request($url.'?'.http_build_query($data));
        $result= json_decode($result,1);
        return $result;
    }

    public function getBestNumForIndex($p ='',$c=''){
        $data = [
            'provice' => $p ? $p : '0',
            'city' => $c ? $c : '0',
            'search' => '',
            'page' => 1,
            'ze_id' => 0,
            'randon' => 1
        ];
        $result = $this->getMobile($data);
        $resultReu = [];
        foreach($result['data'] as $index => $value){
            $aaa = isset($value['other']['card']['product_id']) ? $value['other']['card']['product_id'] : $value['card_gid'];
            $cardDb = Card::where('card_product_id',$aaa)->first();
            if($cardDb){
                $result['data'][$index]['cardinfo'] = $cardDb;
                $resultReu[] = $result['data'][$index];
            }
        }
        return $resultReu;
    }

    public function getRules(){
        $url = 'https://www.10010lh.com.cn/api/rule?jinpin=1';
        $result = parent::curl_request($url);
        $result= json_decode($result,1);
        return $result;
    }

    public function getBestNum($p ='',$c='' ,$lx = '',$search='' ,$page=''){
        $data = [
            'provice' => $p ? $p : '0',
            'city' => $c ? $c : '0',
            'search' => $search ? $search : '',
            'page' => $page?$page:1,
            'ze_id' => $lx ? $lx : 0,
            'randon' => 1
        ];
        $result = $this->getMobile($data);
        $resultReu = [];
        foreach($result['data'] as $index => $value){
            $aaa = isset($value['other']['card']['product_id']) ? $value['other']['card']['product_id'] : $value['card_gid'];
            $cardDb = Card::where('card_product_id',$aaa)->first();
            if($cardDb){
                $result['data'][$index]['cardinfo'] = $cardDb;
                $resultReu[] = $result['data'][$index];
            }
            
        }
        return $resultReu;
    }
}