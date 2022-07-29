<?php
namespace App\Services;
use Illuminate\Support\Facades\Log;

class BaseService{

    protected static function curl_request($url, $post = '',$header = [],$proxy = false){
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
        if($post){$headers[] = 'Content-Type: application/x-www-form-urlencoded;';}
        if(count($header)){
            foreach($header as $key => $value){
                $headers[] = $value;
            }
        }
        // dd($headers);
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

    protected static function curl_request_json($url, $post = '',$header = [],$proxy = false){
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if(!$post){
            return 'data is null';
        }
       
        if(is_array($post))
        {
            $post1 = json_encode($post,JSON_UNESCAPED_UNICODE);
        }
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER,array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length:' . strlen($post1),
                'Cache-Control: no-cache',
                'Pragma: no-cache'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        $errorno = curl_errno($curl);
        if ($errorno) {
            return $errorno;
        }
        // Log::info($url);
        // Log::info($post);
        // Log::info($res);
        // Log::info('-----------------------------');
        curl_close($curl);
        return json_decode($res,1);
    }
    protected static function request_by_curl($remote_server, $post_string) { 
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