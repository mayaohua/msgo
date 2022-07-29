<?php
namespace App\Services;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use App\Models\Card;
class HaokaService extends BaseService{
    
    protected static $_sourceType = '';

    //生成正式单
    public function putOrder($numberData,$userData){
        $url = 'http://lt.haokazhushou.com/api/book/';
        $data = [
            "mob"=>'15592516234',
            "name" => $userData['username'],
            "idcard"=> $userData['usercode'],
            "phone"=> $userData['userphone'],
            "addr"=> $userData['address'],
            "ref"=>self::$_sourceType
        ];
        // dd($data);
        $result = parent::curl_request($url.'?'.http_build_query($data));
        dd($result);
        $result = json_decode($result);
        
        if(!$result){
            return ['msg' => '系统异常','data' => [] ,'code' => -1];
        }
        if($result->code == '0025'){
            return ['msg' => '','data' => [] ,'code' => 0];
        }else{
            return ['msg' => $result->msg,'data' => [] ,'code' => -1];
        }
    }
    //查询号码
    public function getMobile($info){
        $url = 'https://www.haokazhushou.com/selectnum/';
        $data = [
            "p"=>$info['p'] ? $info['p'] : 'undefined',
            "c"=> $info['c'] ? $info['c'] : 'undefined',
            'seach' => $info['seach'] ? $info['seach'] : '',
            'type' =>  0,
            'page' =>  $info['page'] ? $info['page'] : 1,
            'lx' =>    $info['lx'] ? $info['lx']:'',
            'free' => 1,
        ];
        $result = parent::curl_request($url.'?'.http_build_query($data));
        $result= json_decode($result,1);
        return $result;
    }

    public function getBestNumForIndex($p ='',$c=''){
        $data = [
            'p' => $p ? $p : 'undefined',
            'c' => $c ? $c : 'undefined',
            'seach' => '',
            'page' => $c?1:mt_rand(1,10),
            'lx' => '',
            'free' => 1,
        ];
        $result = $this->getMobile($data);
        if(!is_array($result)){
            $this->getBestNumForIndex();
        }
        if(isset($result['code']) && $result['code'] == '9901'){
            return [];
        }
        $returnRes = [];
        foreach($result as $value){
            if(count($returnRes) >= 10){break;}
            try {
                // $value['menu'] = str_replace(['-邀约','-优享'],'',$value['menu']);
                $cardDb = $this->getCardDb($value['menu']);
                if($cardDb && $value['price'] == 0 && $value['xf'] == '0' && $value['xy'] == 0){
                    $value['cardinfo'] = $cardDb;
                    array_push($returnRes,$value);
                }
            } catch (\Throwable $th) {
               return [];
            }
            
        }
        return $returnRes;
    }

    public function getBestNum($p ='',$c='' ,$lx = '',$seach='' ,$page=''){
        $data = [
            'p' => $p ? $p : 'undefined',
            'c' => $c ? $c : 'undefined',
            'seach' => $seach,
            'page' => $page?$page:1,
            'lx' => $lx,
            'free' => 1,
        ];
        $result = $this->getMobile($data);
        if(!is_array($result)){
            return [];
        }
        if(isset($result['code']) && $result['code'] == '9901'){
            return [];
        }
        $returnRes = [];
        foreach($result as $value){
            // if(count($returnRes) >= 10){break;}
            try {
                //$value['menu'] = str_replace(['-邀约','-优享'],'',$value['menu']);
                $cardDb = $this->getCardDb($value['menu']);
                if($cardDb && $value['price'] == 0 && $value['xf'] == '0' && $value['xy'] == 0){
                    $value['cardinfo'] = $cardDb;
                    array_push($returnRes,$value);
                }
            } catch (\Throwable $th) {
               return [];
            }
            
        }
        return $returnRes;
    }
    public function getCardDb($name){
        $card_product_id = 0;
        if ($name === '腾讯大王卡') {
            $card_product_id = '981610241535';
        }elseif ($name === '腾讯地王卡') {
            $card_product_id = '981802085690';
        }elseif ($name === '腾讯天王卡') {
            $card_product_id = '981702278573';
        }elseif ($name === '阿里小宝卡') {
            $card_product_id = '981711282733';
        }elseif ($name === '阿里大宝卡') {
            $card_product_id = '981711282734';
        }elseif ($name === '流邦卡19元套餐') {
            $card_product_id = '981810176520';
        }elseif ($name === '福享卡19元套餐') {
            $card_product_id = '981805100235';
        }elseif ($name === '梦想e卡') {
            $card_product_id = '981707135634';
        }elseif ($name === '蚂蚁大宝卡') {
            $card_product_id = '981611177210';
        }elseif ($name === '蚂蚁国宝卡') {
            $card_product_id = '981801174882';
        }elseif ($name === '米粉王卡Pro') {
            $card_product_id = '981909126136';
        }elseif ($name === '米粉王卡') {
            $card_product_id = '981909126135';
        }elseif ($name === '小歪卡') {
            $card_product_id = '981907243296';
        }elseif ($name === '滴滴司机小王卡') {
            $card_product_id = '981712203627';
        }elseif ($name === '哔哩哔哩33卡') {
            $card_product_id = '981703239395';
        }elseif ($name === '哔哩哔哩22卡') {
            $card_product_id = '981703239394';
        }elseif ($name === '哔哩哔哩小电视卡') {
            $card_product_id = '981703239396';
        }elseif ($name === '星芒卡19元套餐') {
            $card_product_id = '981807263272';
        }elseif ($name === '星芒卡Puls39元套餐') {
            $card_product_id = '981911199621';
        }elseif ($name === '王卡5G套餐129') {
            $card_product_id = '981910298240';
        }elseif ($name === '天神卡') {
            $card_product_id = '981909126138';
        }elseif ($name === '懂我卡畅享版') {
            $card_product_id = '981909045640';
        }elseif ($name === '芝士卡') {
            $card_product_id = '982007212822';
        }
        if($card_product_id == 0){return null;}
        $res = Card::where('card_product_id',$card_product_id)->first();
        return $res;
    }
}