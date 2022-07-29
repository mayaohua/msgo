<?php

namespace App\Jobs;


use App\Models\Rule;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Services\Itywbb\ItywbbService;

class sysThreeMobile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $locaData;
    protected $index;
    protected $cardData;
    protected $rules;
    protected $max_fail_count = 10;
    protected $ityw = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rules)
    {
        $this->rules = $rules;
        $this->ityw = new ItywbbService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $data_old = $this->ityw->getAllMobile();
        if(!count($data_old)){  return ; }
        $monolog = Log::getMonolog();
        $monolog->popHandler();
        Log::useDailyFiles(storage_path('logs/job/info.log'));
        Log::info('数据获取成功===>');
        foreach($data_old as $i => $v){
            if($i == 0){continue;}
            $hasRule = false;
            foreach($this->rules as $vl){
                $rule_test = $vl['ze_rule'];
                $reg = '/^'.$rule_test.'/';
                if(!preg_match($reg, $v->phone)){
                    continue ;
                }
                $hasRule = true;
                //符号条件写入数据库
                $data = $this->getAllData($vl,$v->city,$i, $v->phone);
                $this->create($data);
            }
            if(!$hasRule){
                $vl = [
                    "id" => '0',
                    "ze_order" => "0",
                    "ze_name" => "无规则",
                    "ze_rule" => "",
                    "ze_status" => "1",	
                ];
                $data = $this->getAllData($vl,$v->city,$i, $v->phone);
                $this->create($data);
            }
        }
    }

    private function getAllData($vl,$city,$i,$v){
        $my_rule = $vl;
        $my_rule_str=$vl['ze_name'];
        $my_rule_id_str=$vl['id'];

        $old_local = $city;
        $this->setLocal($old_local);
        $this->setCard();
        $other = [
            'local' => $this->locaData,
            'card' => $this->cardData,
            'rule' => $my_rule
        ];
        return [
            "mobile" => $v,
            "loca_name" => $this->locaData['name'],
            "loca_p_c" => $this->locaData['provinceCode'],
            "loca_c_c" => $this->locaData['cityCode'],
            "card_name" => $this->cardData['name'],
            "card_gid" => $this->cardData['card_goodsid'],
            "rule_name" => $my_rule_str,
            "rule_id" => $my_rule_id_str,
            "other" => json_encode($other),
            "sell" => 0,
            "status" => 1,
            "mobile_from" => 'hhdaili'
        ];
    }

    private function setLocal($local){
        $local = explode('-',$local);
        $locaData = [
            'name' => '未知',
            'provinceName' => '未知',
            'cityName' => '未知',
            'cityCode'=>0,
            'provinceCode'=>0
        ];
        foreach(config('provice') as $index => $value){
            if(preg_match('#^'.$local[0].'#u',$value['region_name'])){
                foreach($value['city'] as $i => $v){
                    if(preg_match('#^'.$local[1].'#u',$v['region_name'])){
                        $locaData = [
                            'name' => $value['region_name'] . $v['region_name'],
                            'provinceName' => $value['region_name'],
                            'cityName' => $v['region_name'],
                            'cityCode'=>$v['ess_code'],
                            'provinceCode'=>$value['ess_code']
                        ];
                    }
                }
            }
        }
        $this->locaData = $locaData;
    }

    private function setCard(){
        $this->cardData = [
            'name' =>  '腾讯王卡 - 大王卡',
            'p_card_name' => '腾讯王卡',
            'c_card_name' => '大王卡',
            'card_goodsid' => '981610241535'
        ];
    }

    private function create($data){
        $monolog = Log::getMonolog();
        $monolog->popHandler();
        Log::useFiles(storage_path('logs/job/info.log'));
        if(Bmobile::create($data)){
            Log::info($data['mobile'].'===>成功');
        }else{
            Log::error($data['mobile'].'===>失败');
        }
    }
    
    private function getProxyData($del = false){
        if($del){
            if(Redis::get('fail_count') > $this->max_fail_count){
                Redis::del('proxy_data');
                Redis::del('fail_count');
                $monolog = Log::getMonolog();
                $monolog->popHandler();
                Log::useFiles(storage_path('logs/job/info.log'));
                Log::info('删除iP成功');
            }else{
                Redis::incr('fail_count');
            }
            return;
        }
        if(Redis::exists('proxy_data')){
            return json_decode(Redis::get('proxy_data'),true);
        }else{
            if(!env('PROXY_URL')){return false;}
            $proxyData = $this->curl_request(env('PROXY_URL'));
            $proxyData = json_decode($proxyData,true);
            if($proxyData['code'] != 200){
                return false;
            }else{
                $data = $proxyData['data'][0];
                Redis::setex('proxy_data',strtotime($data['expire'])-time(),json_encode($data));
                Redis::del('fail_count');
                return $data;
            }
        }
    }

    private function curl_request($url, $post = '',$proxy = false){
        if($proxy){
            $monolog = Log::getMonolog();
            $monolog->popHandler();
            Log::useFiles(storage_path('logs/job/info.log'));
            Log::info('调用接口 ===>'.json_encode($proxy));
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        if($proxy){
            //设置代理
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'].':'.$proxy['port']);
        }
        //自定义header
        $headers = array();
        $headers[] = 'User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0);';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //自定义cookie
        curl_setopt($ch, CURLOPT_COOKIE,''); 

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //使用gzip压缩传输数据让访问更快

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        // $info = curl_getinfo($ch);
        curl_close($ch);
        return $result;
    }
}
