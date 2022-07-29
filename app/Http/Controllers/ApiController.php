<?php

namespace App\Http\Controllers;


use App\Jobs\sysBestMobile;
use App\Models\Rule;
use App\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use QL\QueryList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Itywbb\ItywbbService;
use App\Services\Zop\ZopService;

class ApiController extends Controller

{
    protected static $wx = [
        'appID' => 'wx457a524b807f4246',
        'appsecret'=> '445afaeb232c1257cb7002d9e73a3b51'
    ];

    public function search_mobiles(){
        $p = Input::get('provice',0);
        $c = Input::get('city',0);
        $z = Input::get('ze_id',0);
        $s = Input::get('search','');
        $d = Input::get('card_goodsid','');
        $list = Bmobile::when($p,function($query) use($p){
           return  $query -> where('loca_p_c',$p);
        })->when($c,function($query) use($c){
            return  $query -> where('loca_c_c',$c);
         })->when($z,function($query) use($z){
            return  $query -> where('rule_id',$z);
         })->when($s,function($query) use($s){
            return  $query -> where('mobile','like','%'.$s.'%');
         })->when($d,function($query) use($d){
            return  $query -> where('card_gid',$d);
         })->where('sell',0)->inRandomOrder()->limit(10)->get();
         //->where('mobile_from','10010')
         $result = [
             'mobile' => [],
             'data' => [],
         ];
         foreach($list as $key => $value){
             $other = json_decode($value->other);
             $result['mobile'][$key] = [
                 'goods_name' => $value->mobile,
                 'goods_names' => $value->mobile,
                 'id' => $value->id,
                 'ess_province_name' => $other->local->provinceName,
                 'ess_city_name'=>$other->local->cityName,
                 'goodsid'=> $value->card_gid,
                 'card_name'=> $value->card_name,
                 'ess_province'=> $value->loca_p_c,
                 'ess_city'=> $value->loca_c_c,
                 'mobile_from'=>$value->mobile_from
             ];
             $result['data'][$key] = $value->mobile.$other->local->name.$value->rule_name;
        }
        return $result;
    }
    
    public function provice(){
        $a = Input::get('all',0);
        $m = Input::get('bx',0);
        if($a){
            return  config('provices');
        }
         $all = config('provice');
        if($m){
             $p = ["id"=>0,"ess_code"=>0,"region_name"=>"不限","city"=>[["id"=>0,"ess_code"=>0,"region_name"=>"不限"]]];
            array_unshift($all,$p);
        }
       
        return $all;
    }
    public function card(){
        $m = Input::get('bx',0);
        $all = config('card');
        array_pop($all);
        array_pop($all);
        if($m){
            $p = [
                "id" => "0",
                "cards_name" => "不限",
                "card" => [[
                    "id" => "0",
                    "card_name" => "不限",
                    "card_goodsid" => "0",
                    "is_package" => null
                ]]
            ];
           array_unshift($all,$p);
       }
        
        return $all;
    }
    public function rule(){
        $p = Input::get('jinpin',0);
        if($p){
            $rules = ["id"=>0,"ze_name"=>"不限","ze_rule"=>""];
            $settingObj = Setting::where('key','jobForm')->first();
            $val = json_decode($settingObj->value);
            $all = Rule::whereIn('id',$val->find_show_rules)->orderBy('ze_order')->get(['ze_name','ze_rule','id'])->toArray();
            array_unshift($all,$rules);
            return $all;
        }else{
            $all = Rule::where('ze_status','1')->orderBy('ze_order')->get();
            foreach ($all as $key => $value){
                $all[$key]->true_mobile = [];
                $all[$key]->sweep_number = 1;
            }
            return $all;
        }
    }
    
    public function buy(Request $request, ItywbbService $service, ZopService $zopService){
        // dd($server);
        //firstMonthType  attrValCode  package_id   attrCode
        // Log::info($request->all());
        $firstMonthType = $request->get('firstMonthType');
        $settingObj = Setting::where('key','backForm')->first();
        $val = json_decode($settingObj->value);
        $u = $val->channel?$val->channel:'PgQXFjs/sM3ncEmzSrq6bQ==';
	    $postJson = '{
            "numInfo":{
                "essProvince":"'.$request->get('province').'",
                "essCity":"'.$request->get('city').'",
                "number":"'.$request->get('mobile').'"
            }
            ,"goodInfo":{
                "goodsId":"'.$request->get('goodsid').'",
                "sceneFlag":"03"
                ,"firstMonthType":"'.$firstMonthType.'"}
            ,"postInfo":{
                "webProvince":"'.$request->get('webprovince').'",
                "webCity":"'.$request->get('webcity').'",
                "webCounty":"'.$request->get('webcounty').'",
                "address":"'.$request->get('address').'"
            }
            ,"certInfo":{
                "certTypeCode":"02",
                "certName":"'.$request->get('cartname').'",
                "certId":"'.$request->get('certid').'",
                "contractPhone":"'.$request->get('contractphone').'"
            }
            ,"captchaInfo":{
                "type":"00",
                "captcha":"'.$request->get('captcha').'"
            },
            "u":"'.$u.'",
            "channel":"9999",
            "marketingStatus":"0"
            }';
        $local = '';
        foreach(config('provice') as $value){
            if($value['ess_code'] == $request->get('province')){
                foreach($value['city'] as $v){
                    if($v['ess_code'] == $request->get('city')){
                        $local = $value['region_name'].' - '.$v['region_name'];
                    }
                }
            }
        }
        $data = [
            'loca_name' => $local,
            'loca_p_c' => $request->get('province'),
            'loca_c_c' => $request->get('city'),
            'card_name' => $request->get('card_name'),
            'mobile' => $request->get('mobile'),
            'card_gid' => $request->get('goodsid'),
            'user_name' => $request->get('cartname'),
            'user_code' => $request->get('certid'),
            'user_phone' => $request->get('contractphone'),
            'user_address' => $request->get('diqu').$request->get('address'),
        ];
        $bm = Bmobile::where('mobile',$request->get('mobile'))->first();
        if($bm && $bm->sell){
            return [
                'rspCode'=>'0001',
                'rspDesc'=>'号码已被预订'
            ];
        }
        if($bm && $bm->mobile_from == 'hhdaili'){
            if($bm->sell){
                return [
                    'rspCode'=>'0001',
                    'rspDesc'=>'号码已被预订'
                ];
            }
            $da = [
                "mobile"=>$data['mobile'],
                "user_name" => $data['user_name'],
                "user_code"=> $data['user_code'],
                "user_phone"=> $data['user_phone'],
                "address"=> $data['user_address'],
            ];
            $result = $service->putOrder($da);
            $result = (object) $result;
            $orderResult = json_encode($result);
            //Log::info($orderResult);
        }else{
            if($bm){
                $local = json_decode($bm->other);
                $data['card_province'] = $local->local->provinceName;
                $data['card_city'] = $local->local->cityName;
                $data['user_province'] = $this->getLocal($request->get('webprovince'));
                $data['user_city'] = $this->getLocal($request->get('webcity'));
                $data['user_area'] = $this->getLocal($request->get('webcounty'));
                $data['user_info'] = $request->get('address');
                $result = $zopService->userPutOrder($data);
                $result = (object) $result;
                $orderResult = json_encode($result);
            }else{
                $orderResult=$this->request_by_curl("http://msgo.10010.com/scene-buy/scene/buy",$postJson);
                $result = json_decode($orderResult);
            }
            //Log::info($orderResult);
        }
        if($result->rspCode == "0000"){ 
            if($bm){
                $data['bm_id'] = $bm->id;
                $data['apply_from'] = $bm->mobile_from;
            }
            Order::create($data);
            if($bm){
                $bm->sell = 1;
                $bm->save();
            }
        }else{
            Log::info((array) $result);
            $data['fail_msg'] = $result->rspDesc;
            $bm = Bmobile::where('mobile',$request->get('mobile'))->first();
            if($bm){
                $data['bm_id'] = $bm->id;
                $data['apply_from'] = $bm->mobile_from;
            }
            Order::create($data);
        }
        return $orderResult;
        
    }

    private function getLocal($code){
        $all = config('provices');
        foreach($all as $value){
            if($code == $value['id']){
                return $value['region_name'];
            }else{
                foreach($value['city'] as $value){
                    if($code == $value['id']){
                        return $value['region_name'];
                    }else{
                        foreach($value['county_name'] as $value){
                            if($code == $value['id']){
                                return $value['region_name'];
                            } 
                        }
                    }
                }
            }
        }
    }
    
    public function webinfo(){
        $settingObj = Setting::where('key','wxForm')->first();
        $settingObj = json_decode($settingObj->value);
        $settingObj->provice = config('provice');
        $settingObj->card = config('card');
        // $settingObj->rule = Rule::where('ze_status','1')->get();
        // foreach ($settingObj->rule as $key => $value){
        //     $settingObj->rule[$key]->true_mobile = [];
        // }
        
        return json_encode($settingObj);
    }
    
    public function zdy_gonggao(){
        $settingObj = Setting::where('key','wxForm')->first();
        $settingObj = json_decode($settingObj->value);
        return $settingObj->zdy_gonggao;
    }

    
    
    private function request_by_curl($remote_server, $post_string) { 
      $ch = curl_init(); 
      curl_setopt($ch, CURLOPT_URL, $remote_server); 
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36"); 
      $data = curl_exec($ch); 
      curl_close($ch); 
       
      return $data; 
    }
}
