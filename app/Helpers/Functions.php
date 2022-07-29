<?php

function curl_get($url,$param = null,$options = null){
    if(empty($options)){
     $options = array(
      'timeout'        => 30,// 请求超时
      'header'         => array(),
      'cookie'         => '',// cookie字符串，浏览器直接复制即可
      'cookie_file' => '',// 文件路径,并要有读写权限的
      'ssl'            => 0,// 是否检查https协议
      'referer'        => null
     );
    }else{
     empty($options['timeout']) && $options['timeout'] = 30;
     empty($options['ssl']) && $options['ssl'] = 0;
    }
    $result = array(
     'code'  => 0,
     'msg'  => 'success',
     'body'  => ''
    );
    if(is_array($param)){
     $param = http_build_query($param);
    }
    $url = strstr($url,'?')?trim($url,'&').'&'.$param:$url.'?'.$param;
    $ch = curl_init();
    
    curl_setopt($ch,CURLOPT_URL, $url);// 设置url
    !empty($options['header']) && curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']); // 设置请求头
    if(!empty($options['cookie_file']) && file_exists($options['cookie_file'])){
     curl_setopt($ch, CURLOPT_COOKIEFILE, $options['cookie_file']);
     curl_setopt($ch, CURLOPT_COOKIEJAR, $options['cookie_file']);
    }else if(!empty($options['cookie'])){
     curl_setopt($ch, CURLOPT_COOKIE, $options['cookie']);
    }
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //curl解压gzip页面内容
    curl_setopt($ch, CURLOPT_HEADER, 0);// 不获取请求头
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 输出转移，不输出页面
    !$options['ssl'] && curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $options['ssl']); // 禁止服务器端的验证ssl
    !empty($options['referer']) && curl_setopt($ch, CURLOPT_REFERER, $options['referer']);//伪装请求来源，绕过防盗
    curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout']);
    //执行并获取内容
    $output = curl_exec($ch);
    //对获取到的内容进行操作
    if($output === FALSE ){
     $result['code'] = 1; // 错误
     $result['msg'] = "CURL Error:".curl_error($ch);
    }
    $result['body'] = $output;
    //释放curl句柄
    curl_close($ch);
    return $result;
}

/**
 * curl_post
 * @param $url    请求地址
 * @param null $param  get参数
 * @param array $options 配置参数
 * @return array
 */
function curl_post($url,$param = null,$options = array()){
    if(empty($options)){
     $options = array(
      'timeout'        => 30,
      'header'         => array(),
      'cookie'         => '',
      'cookie_file' => '',
      'ssl'            => 0,
      'referer'        => null
     );
    }else{
     empty($options['timeout']) && $options['timeout'] = 30;
     empty($options['ssl']) && $options['ssl'] = 0;
    }
    
    $result = array(
     'code'  => 0,
     'msg'  => 'success',
     'body'  => ''
    );
    if(is_array($param)){
     $param = http_build_query($param);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);// 设置url
    !empty($options['header']) && curl_setopt($ch, CURLOPT_HTTPHEADER, $options['header']); // 设置请求头
    if(!empty($options['cookie_file']) && file_exists($options['cookie_file'])){
     curl_setopt($ch, CURLOPT_COOKIEFILE, $options['cookie_file']);
     curl_setopt($ch, CURLOPT_COOKIEJAR, $options['cookie_file']);
    }else if(!empty($options['cookie'])){
     curl_setopt($ch, CURLOPT_COOKIE, $options['cookie']);
    }
    
    
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //curl解压gzip页面内容
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    curl_setopt($ch, CURLOPT_HEADER, 0);// 不获取请求头
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 输出转移，不输出页面
    !$options['ssl'] && curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $options['ssl']); // 禁止服务器端的验证ssl
    !empty($options['referer']) && curl_setopt($ch, CURLOPT_REFERER, $options['referer']);//伪装请求来源，绕过防盗
    curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout']);
    //执行并获取内容
    $output = curl_exec($ch);
    //对获取到的内容进行操作
    if($output === FALSE ){
     $result['code'] = 1; // 错误
     $result['msg'] = "CURL Error:".curl_error($ch);
    }
    $result['body'] = $output;
    //释放curl句柄
    curl_close($ch);
    return $result;
}

function curl_request($url, $post = '',$header = [],$cookie_file = null, $cookie_get =false){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //自定义header
    $headers = array();
    $headers[] = 'User-Agent: Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0);';
    if($post){$headers[] = 'Content-Type: application/x-www-form-urlencoded;';}
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
    if($cookie_file && $cookie_get){
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    }
    if($cookie_file && !$cookie_get){
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    }

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); //使用gzip压缩传输数据让访问更快

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    curl_setopt($ch, CURLOPT_HEADER, false); //设置CURLOPT_HEADER 为true，返回内容中就会包含头内容的输出
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    $info = curl_getinfo($ch);
    // dd($info);
    curl_close($ch);
    return $result;
}

function my_encrypt($string, $key){
    // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
    // $data = openssl_encrypt($string, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
    // return base64_encode($data);
}

function verify_code($file_content){
    $host = "https://codevirify.market.alicloudapi.com";
    $path = "/icredit_ai_image/verify_code/v1";
    $method = "POST";
    //阿里云APPCODE
    $appcode = "5ab302b5b1a9449cb675989852274c4a";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    //根据API的要求，定义相对应的Content-Type
    array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");
    
    $querys = "";
    $bodys = "";
    $url = $host . $path;
    
    //参数配置
    if (true){
        //启用BASE64编码方式进行识别
        //内容数据类型是BASE64编码
        $IMAGE = base64_encode($file_content);
        $IMAGE = urlencode($IMAGE);
        $IMAGE_TYPE = "0";
    }
    else {
        //启用URL方式进行识别
        //内容数据类型是图像文件URL链接
        $IMAGE = "https://icredit-api-market.oss-cn-hangzhou.aliyuncs.com/%E9%AA%8C%E8%AF%81%E7%A0%81.jpg";
        $IMAGE = urlencode($IMAGE);
        $IMAGE_TYPE = "1";   
    }    
    
    $bodys = "IMAGE=".$IMAGE."&IMAGE_TYPE=".$IMAGE_TYPE;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($curl, CURLOPT_HEADER, true);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
    $T = curl_exec($curl);
    return $T;
}

function getSellData($value){
    //商品面值
    $sell_data  = (object) [];
    $facePrice = floatval(bcdiv($value->itemFacePrice , 1000, 3));
    $sell_data->facePrice = $facePrice;
    //商品折扣率
    $bill_profit = $value->itemProfit;
    if($bill_profit == -1){
        $bill_profit = BillCase::find($value->bill_case_id)->first()->item_profit;
    }
    $bill_profit = floatval(bcdiv($bill_profit , 100, 3));
    //进货价
    $sell_data->itemSalePrice = floatval(bcmul($facePrice,$bill_profit,2));
    //剩余利润 
    $sell_data->itemFreePrice = floatval(bcsub($facePrice , $sell_data->itemSalePrice,2));
    //平台利润率
    $app_profit_later = $value->app_profit;
    if($value->app_profit == -1){
        $app_profit_later = Setting::where('key','app_profit')->first()->app_profit;
    }
    $app_profit_later = floatval(bcdiv($app_profit_later , 100, 3));
    //平台出售利润
    $sell_data->AppFreePrice = floatval(bcmul($sell_data->itemFreePrice , $app_profit_later,2));
    //平台出售价
    $sell_data->AppSalePrice = floatval(bcadd($sell_data->AppFreePrice , $sell_data->itemSalePrice,2));

    //分销者利润率
    $user_profit_later = $value->user_profit;
    if($value->user_profit == -1){
        $user_profit_later = Setting::where('key','user_profit')->first()->user_profit;
    }
    $user_profit_later = floatval(bcdiv($user_profit_later , 100, 3));
    //分销剩余利润
    $ProfixFreePrice = $sell_data->ProfixFreePrice = floatval(bcmul($sell_data->itemFreePrice , $user_profit_later,2));
    // dd($ProfixFreePrice);
    //分销者出售平台利润率
    $user_app_profit_later = $value->user_app_profit;
    if($value->user_app_profit == -1){
        $user_app_profit_later = Setting::where('key','user_app_profit')->first()->user_app_profit;
    }
    $user_app_profit_later = floatval(bcdiv($user_app_profit_later , 100, 3));
    
    //分销者出售平台利润
    $sell_data->UserAppFreePrice = floatval(bcmul($ProfixFreePrice , $user_app_profit_later,2));
    
    //分销者利润
    $sell_data->UserFreePrice = floatval(bcsub($ProfixFreePrice , $sell_data->UserAppFreePrice,2));
    //分销者出售价
    $sell_data->UserSalePrice = floatval(bcadd($sell_data->ProfixFreePrice , $sell_data->itemSalePrice,2));
    return (array) $sell_data;
}