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

class sysBestMobile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $locaData;
    protected $index;
    protected $cardData;
    protected $rules;
    protected $max_fail_count = 10;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($locaData,$cardData,$index,$rules)
    {
        $this->locaData = $locaData;
        $this->cardData = $cardData;
        $this->index = $index;
        $this->rules = $rules;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::info(env('PROXY_URL'));die;
        $timestamp = time();
        $proxy = $this->getProxyData();
        Log::info('ip代理 ===>'.json_encode($proxy));
        $url = "https://msgo.10010.com/NumApp/NumberCenter/qryNum?callback=jsonp_queryMoreNums&provinceCode=".$this->locaData['provinceCode']."&cityCode=".$this->locaData['cityCode']."&monthFeeLimit=0&goodsId=".$this->cardData['card_goodsid']."&searchCategory=3&net=01&amounts=200&codeTypeCode=&searchValue=&qryType=02&goodsNet=4&channel=msg-xsg";
        $data_old = $this->curl_request($url."&_=$timestamp",'',$proxy);
        preg_match('/^jsonp_queryMoreNums\((.*)\)/i', $data_old, $match);
        if(count($match)<2){
            $monolog = Log::getMonolog();
            $monolog->popHandler();
            Log::useFiles(storage_path('logs/job/info.log'));
            Log::error('接口解析失败===>'.$data_old);
            $proxy = $this->getProxyData(true);
            return ;
        }
        $data = json_decode($match[1],true);
        if($data['code'] !== 'M0' || !count($data['numArray'])){
            $monolog = Log::getMonolog();
            $monolog->popHandler();
            Log::useFiles(storage_path('logs/job/info.log'));
            Log::error('接口获取数据失败===>'.$data_old);
            if($data['code'] === 'M9'){
                $proxy = $this->getProxyData(true);
                // Log::error('今日已结束=>>>');
                // DB::table()->where('id','>','0')->delete();
            }else if($data['code'] === 'M1'){
                return;
                // Log::error('等待2分钟=>>>');
                // sleep(60*2);
            }else if($data['code'] === 'M8'){
                Log::error('等待2分钟=>>>');
                sleep(60*2);
                // Log::error('今日已结束=>>>');
                // DB::table()->where('id','>','0')->delete();
            }
            return ;
        }
        Redis::del('fail_count');
        $monolog = Log::getMonolog();
        $monolog->popHandler();
        Log::useFiles(storage_path('logs/job/info.log'));
        Log::error('数据获取成功===>');
        foreach($data['numArray'] as $v){
            if($v <= 5){continue;}
            foreach($this->rules as $vl){
                $rule_test = $vl['ze_rule'];
                $reg = '/^'.$rule_test.'/';
                if(!preg_match($reg, $v)){ 
                    // $monolog = Log::getMonolog();
                    // $monolog->popHandler();
                    // Log::useFiles(storage_path('logs/job/info.log'));
                    // Log::info($v.'===>不符合规则'.$reg);
                    continue ; 
                }
                //符号条件写入数据库
                $my_rule = $vl;
                $my_rule_str=$vl['ze_name'];
                $my_rule_id_str=$vl['id'];

                $other = [
                    'local' => $this->locaData,
                    'card' => $this->cardData,
                    'rule' => $my_rule
                ];
                $data = [
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
                    "status" => 1
                ];
                $this->create($data);
            }
            
        }
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
            Log::info($proxyData);
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
