<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Models\Rule;
use App\Models\Setting;

use App\Events\JobWork;
use App\Services\BillService;
use App\Models\BillType;
use App\Models\BillCase;
use App\Models\Bill;

class Controller extends BaseController
{

    protected $locaData;
    protected $index;
    protected $cardData;
    protected $rules;
    protected $max_fail_count = 10;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success($data=[], $msg= '请求成功' ,$code = 0){
        return ['code'=> $code,'msg'=>$msg,'data'=>$data];
    }

    protected function fail($msg= '请求失败',$code = -1, $data = null){
        return ['code'=> $code,'msg'=>$msg,'data'=>$data];
    }


    

    public function test()
    {

    }

    

    protected function curl_request($url, $post = '',$header= [],$proxy = false){
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
        if($post){$headers[] = 'Content-Type: application/x-www-form-urlencoded';}
        if(count($header)){
            foreach($header as $key => $value){
                $headers[] = $value;
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if($post){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }

        //自定义cookie
        curl_setopt($ch, CURLOPT_COOKIE,''); 

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //使用gzip压缩传输数据让访问更快

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        // dd($info);
        curl_close($ch);
        return $result;
    }
    
}
