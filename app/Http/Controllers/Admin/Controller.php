<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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


    public function uploadAction(Request $request){
        $files = $request->file('fileUpload');
        $filemore = $request->get('filemore');
        $domain = $request->get('domain',1);
        $pathArr = [];
        foreach ($files as $index=>$file){
            if($file->isValid())
            {
                $ext = $file->getClientOriginalExtension();//后缀
                $path = $file->getRealPath();//路径
                $filename = date('Y-m-d-H-i-s-').$index.'.'.$ext;//重命名
                Storage::disk('uploads')->put($filename, file_get_contents($path));//上传
                $path = '/storage/uploads/'.$filename;
                if($domain){$path = Storage::disk('uploads')->url($filename);}
                $pathArr[] = $path;
            }else{
                return $this->fail('文件验证失败');
            }
        }
        return $this->success(['path'=>join($pathArr,',')]);
        
    }

    public function getInp($arr = ['keyword','status','page','time']){
        $inp = request()->only($arr);
        foreach($arr as $value){
            if(!isset($inp[$value])){
                $inp[$value] = '';
            }
        }
        if(isset($inp['time'])){
            $inp['time'] = explode(',',$inp['time']);
        }
        $inp = $this->_unsetNull($inp);
        return $inp;
    }

    private function _unsetNull($arr){
        if($arr !== null){
            if(is_array($arr)){
                if(!empty($arr)){
                    foreach($arr as $key => $value){
                        if($value === null){
                            $arr[$key] = '';
                        }else{
                            $arr[$key] = $this->_unsetNull($value);      //递归再去执行
                        }
                    }
                }else{ $arr = ''; }
            }else{
                if($arr === null){ $arr = ''; }         //注意三个等号
            }
        }else{ $arr = ''; }
        return $arr;
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
    
    protected function ismobile()

    {

        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备

        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {

            return true;

        }

 

        //此条摘自TPM智能切换模板引擎，适合TPM开发

        if (isset($_SERVER['HTTP_CLIENT']) && 'PhoneClient' == $_SERVER['HTTP_CLIENT']) {

            return true;

        }

 

        //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息

        if (isset($_SERVER['HTTP_VIA']))

        //找不到为flase,否则为true

        {

            return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;

        }

 

        //判断手机发送的客户端标志,兼容性有待提高

        if (isset($_SERVER['HTTP_USER_AGENT'])) {

            $clientkeywords = array(

                'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile',

            );

            //从HTTP_USER_AGENT中查找手机浏览器的关键字

            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {

                return true;

            }

        }

        //协议法，因为有可能不准确，放到最后判断

        if (isset($_SERVER['HTTP_ACCEPT'])) {

            // 如果只支持wml并且不支持html那一定是移动设备

            // 如果支持wml和html但是wml在html之前则是移动设备

            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {

                return true;

            }

        }

        return false;

    }
}
