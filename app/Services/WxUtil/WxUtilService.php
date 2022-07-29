<?php
namespace App\Services\Bill;
use App\Services\BaseService;
use App\Events\JobWork;
use Illuminate\Support\Facades\Log;

class WxUtilService extends BaseService{
    const KEY = '微信支付后台获取';
	/**  
	* 获取签名 
	* @param array $arr
	* @return string
	*/  
    public function getSign($arr){
        //去除空值
        $arr = array_filter($arr);
        if(isset($arr['sign'])){
            unset($arr['sign']);
        }
        //按照键名字典排序
        ksort($arr);
        //生成url格式的字符串
       $str = $this->arrToUrl($arr) . '&key=' . self::KEY;
       return strtoupper(md5($str));
    }
    /**  
	* 获取带签名的数组 
	* @param array $arr
	* @return array
	*/  
    public function setSign($arr){
        $arr['sign'] = $this->getSign($arr);;
        return $arr;
    }
	/**  
	* 数组转URL格式的字符串
	* @param array $arr
	* @return string
	*/
    public function arrToUrl($arr){
        return urldecode(http_build_query($arr));
    }

    public function checkSign($arr){
        $sign = $this->getSign($arr);
        return $sign == $arr['sign'];
    }

    public function arrayToXml($arr) {
        $xml = "<xml>";
        foreach ($arr as $key => $val){
            if (is_numeric($val)){
                $xml.="<$key>$val</$key>";
            }
            else
                $xml.="<$key><![CDATA[$val]]></$key>";
        }
        $xml.="</xml>";
        return $xml;
    }

    public function xmlToArray($xml) {
        if($xml == '') return '';
        libxml_disable_entity_loader(true);
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
        return $arr;
    }

    public function postXml($url,$postfields){
        $url = $url;
        $postfields = $postfields;
        $ch = curl_init();
        $headers = [
        //"Content-Type:text/html;charset=UTF-8", "Connection: Keep-Alive"
        ];
        $params[CURLOPT_HTTPHEADER] = $headers; //自定义header
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $postfields;
        $params[CURLOPT_SSL_VERIFYPEER] = false;
	    $params[CURLOPT_SSL_VERIFYHOST] = false;
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;
        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        
        curl_close($ch); //关闭连接
        return $content; //输出登录结果
    }
}