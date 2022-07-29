<?php

namespace App\Listeners;


use App\Events\JobWork;
use App\Jobs\sysBestMobile;
use App\Jobs\sysThreeMobile;
use App\Jobs\sysGuanMobile;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Services\Zop\ZopService;

class JobWorkListener implements ShouldQueue
{
    protected $zop = null;
    

    public function __construct()
    {
        $this->zop = new ZopService();
    }

    /**
     * Handle the event.
     *
     * @param  JobWork  $event
     * @return void
     */
    public function handle(JobWork $event)
    {
        $rules = [];
        $settingObj = Setting::where('key','jobForm')->first();
        $val = json_decode($settingObj->value);
        $rules = Rule::whereIn('id',$val->find_rules)->get(['ze_name','ze_rule','id'])->toArray();
        if(!count($rules)){
            $monolog = Log::getMonolog();
            $monolog->popHandler();
            Log::useFiles(storage_path('logs/job/info.log'));
            Log::error('未设置精品规则，请在设置中设置');
        }
        
        if($event->who == '10010'){
            Bmobile::withTrashed()->where('mobile_from','10010')->forceDelete();
            $this->getGoodMobileSh($val->find_number,$rules,config('provice'),$this->zop->getCards());
        }else if($event->who == 'three'){
            Bmobile::withTrashed()->where('mobile_from','!=','10010')->forceDelete();
            // Log::info(123);
            sysThreeMobile::dispatch($rules);
        }else{
            Bmobile::withTrashed()->where('id','>','0')->forceDelete();
            sysThreeMobile::dispatch($rules);
            $this->getGoodMobileSh($val->find_number,$rules,config('provice'),$this->zop->getCards());
        }
        

        
    }

    private function getGoodMobileSh($number, $rules, $locations, $cards){
        $zuheArr = [];
        $index = 0;
        //套餐列表
        Log::info($cards);
        foreach ($cards as $keys => $values) {
            foreach ($values['card'] as $ks => $vs) {
                foreach ($locations as $keyl => $valuel) {
                    foreach ($valuel['city'] as $kl => $vl) {
                        $arr = [];
                        $cityCode = $arr['cityCode'] = $vl['ess_code'];
                        $provinceCode = $arr['provinceCode'] = $valuel['ess_code'];
                        $goodsId =  $arr['card_goodsid'] = $vs['word_id'];
                        // $data = $this->curl_request($url);
                        for ($i=1; $i <= $number; $i++) {
                            //  if($index == 1){
                            //      goto end;
                            //  }
                            $provinceName = $valuel['region_name'];
                            $provinceName = str_replace($this->zop->proviArr ,'',$provinceName);
                            $locaData = [
                                'name' => $valuel['region_name'] . $vl['region_name'],
                                'provinceName' => $provinceName,
                                'cityName' => $vl['region_name'],
                                'cityCode'=>$cityCode,
                                'provinceCode'=>$provinceCode
                            ];
                            $cardData = [
                                'name' =>  $values['cards_name'].' - '.$vs['card_name'],
                                'p_card_name' => $values['cards_name'],
                                'c_card_name' => $vs['card_name'],
                                'card_goodsid' => $vs['word_id']
                            ];
                            sysGuanMobile::dispatch($locaData,$cardData,$i,$rules);
                            $index += 1;
                        }
                    }
                }
            }
        }
    //   end:;
    }

    //$number 查询的页数   $rule 定义的规则   $locations 归属地列表  $cards 套餐列表
    private function getGoodMobile($number, $rules, $locations, $cards)
    {
        $zuheArr = [];
        $index = 0;
        //套餐列表
        foreach ($cards as $keys => $values) {
            foreach ($values['card'] as $ks => $vs) {
                foreach ($locations as $keyl => $valuel) {
                    foreach ($valuel['city'] as $kl => $vl) {
                        $arr = [];
                        $cityCode = $arr['cityCode'] = $vl['ess_code'];
                        $provinceCode = $arr['provinceCode'] = $valuel['ess_code'];
                        $goodsId =  $arr['card_goodsid'] = $vs['card_goodsid'];
                        // $data = $this->curl_request($url);
                        for ($i=1; $i <= $number; $i++) {
                            //  if($index == 1){
                            //      goto end;
                            //  }
                            $provinceName = $valuel['region_name'];
                            $locaData = [
                                'name' => $provinceName . $vl['region_name'],
                                'provinceName' => $provinceName,
                                'cityName' => $vl['region_name'],
                                'cityCode'=>$cityCode,
                                'provinceCode'=>$provinceCode
                            ];
                            $cardData = [
                                'name' =>  $values['cards_name'].' - '.$vs['card_name'],
                                'p_card_name' => $values['cards_name'],
                                'c_card_name' => $vs['card_name'],
                                'card_goodsid' => $vs['card_goodsid']
                            ];
                            sysBestMobile::dispatch($locaData,$cardData,$i,$rules);
                            $index += 1;
                        }
                    }
                }
            }
        }
    //   end:;
    }
}
