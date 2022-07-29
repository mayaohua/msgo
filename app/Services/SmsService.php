<?php
namespace App\Services;
use Carbon\Carbon;
use Overtrue\EasySms\EasySms;

/**
 * Class SmsService 发送短信接口
 * @package App\Services
 */
class SmsService
{

    /**
     * easysms - sdk发送
     * @param $phoneNumbers static 电话号码
     * @param $code string 验证码
     * @return bool true为发送成功
     */
    public function sendCaptchaSms($phoneNumber,$code, $time = 20)
    {
        $config = config('easysms');
        $easySms = new EasySms($config);
        try{
            $result = $easySms->send($phoneNumber, [
                'template' => '984984',
                'content' => '验证码为：{1}（{2}分钟内有效，如非本人操作，请忽略！）',
                'data' => [$code,$time],
            ]);     // 这里会返回一个发送短信的结果

            if( $result['qcloud']['result']['errmsg'] == 'OK' ) {
                return true;
            }
        }catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception){
            $eobj = $exception->getException('qcloud');
            $error = [
                'msg' => $eobj,
                'phone' => $phoneNumber,
                'time' => Carbon::now()
            ];
            //Log::useDailyFiles(storage_path('logs/job/error.log'));
            //Log::useDailyFiles(storage_path('logs/job/error.log'));
            $monolog = \Log::getMonolog();
            $monolog->popHandler();
            \Log::useFiles(storage_path('logs/sms/error.log'));
            \Log::error(json_encode($error));
        }
        return $eobj->getMessage();
    }
}