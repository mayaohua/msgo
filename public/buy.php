<?php 
header("Content-type: application/json");
//error_reporting(0);
  //开启session;
  if(!session_id()){
    session_start();
  }
function request_by_curl($remote_server, $post_string) { 
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



$postJson = '{"numInfo":{"essProvince":"'.$_GET['province'].'","essCity":"'.$_GET['city'].'","number":"'.$_GET['mobile'].'"},"goodInfo":{"goodsId":"'.$_GET['goodsid'].'","sceneFlag":"03"},"postInfo":{"webProvince":"'.$_GET['webprovince'].'","webCity":"'.$_GET['webcity'].'","webCounty":"'.$_GET['webcounty'].'","address":"'.$_GET['address'].'"},"certInfo":{"certTypeCode":"02","certName":"'.$_GET['cartname'].'","certId":"'.$_GET['certid'].'","contractPhone":"'.$_GET['contractphone'].'"},"captchaInfo":{"type":"00","captcha":"'.$_GET['captcha'].'"},"u":"aWigimyWNifLw6g7uF3dqw==","channel":"9999","marketingStatus":"0"}';


$orderResult=request_by_curl("http://msgo.10010.com/scene-buy/scene/buy",$postJson);

exit($orderResult);


?>

