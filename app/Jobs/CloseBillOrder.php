<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use EasyWeChat\Factory;
use App\Http\Controllers\WxController;
use App\Models\PhoneBillOrder;
use Illuminate\Support\Facades\Log;

class CloseBillOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
 
    public function __construct(PhoneBillOrder $order, $delay)
    {
        $this->order = $order;
        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($delay);
    }
 
    // 定义这个任务类具体的执行逻辑
    // 当队列处理器从队列中取出任务时，会调用 handle() 方法
    public function handle()
    {
        // 判断对应的订单是否已经被支付
        // 如果已经支付则不需要关闭订单，直接退出
        if ($this->order->bill_status != 0) {
            return;
        }
        $payApp = Factory::payment(config('wechat.payment.default'));
        $result = $payApp->order->queryByOutTradeNumber($this->order->bill_seria_ino);
        // Log::info($result);
        // 通过事务执行 sql
        \DB::transaction(function() use($result){
            // 将订单的 closed 字段标记为 true，即关闭订单
            
            if($result['result_code'] == 'SUCCESS' && $result['total_fee'] == $this->order->bill_money/1000){
                if(isset($result['trade_state']) && $result['trade_state'] == 'SUCCESS'){
                    $data = [
                        'bill_status' => 1
                    ];
                }else{
                    $data = [
                        'bill_status' => 2,
                        'bill_fail_msg' => '订单支付超时',
                        'finished_at' => Carbon::now()
                    ];
                }   
            }else{
                $data = [
                    'bill_status' => 2,
                    'bill_fail_msg' => '订单支付超时',
                    'finished_at' => Carbon::now()
                ];
            }
            $this->order->update($data);
            if($this->order->bill_status == 1){
                Log::info(1);
                (new WxController())->createThreeOrder($this->order->toArray());
            }
        });
    }
}
