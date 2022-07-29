<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PhoneBillOrder;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\BillService;
use App\Services\MarketService;
use App\Models\UserOrder;
use App\Models\WebUser;

class OrderStatusCommand extends Command
{
    protected $signature = 'order:update';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '定时更新订单状态';
    protected $model;
    protected $billService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new PhoneBillOrder();
        $this->billService = new BillService();
        $this->marketService = new MarketService();
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Throwable
     */
    public function handle()
    {

        // $schedule->command('order:update close')->everyMinute();//关闭支付
        // $schedule->command('order:update pay')->everyMinute();//支付
        // $schedule->command('order:update bill')->everyMinute();//支付成功，未充值
        // $schedule->command('order:update receive')->everyMinute();//退款   延迟20分钟  //30分钟执行一次
        // $schedule->command('order:update threepay')->everyMinute();//充值
        // $schedule->command('order:update billfail')->everyMinute();//充值失败，发起退款
        // $schedule->command('order:update sys_bill')->hourly();//同步价格
        $this->close();
        $this->receive();
        $this->pay();
        $this->threepay();
        $this->bill();
        // $this->sysBillData();
        $this->billfail();
        // $this->test();

    }
    /**
     * 未支付订单自动关闭，未退款订单自动关闭
     * @param $close_days
     * @return $this|bool
     */
    private function close()
    {
        // 取消n天以前的的未付款订单
        $close_days = 1;
        // 截止时间
        $deadlineTime = Carbon::now()->subDays($close_days)->toDateTimeString();
        // 查询截止时间未支付的订单
        $orders = $this->model->where('bill_status',0)->where('created_at', '<', $deadlineTime)->get();
        foreach($orders as $order){
            $order->changeStatus(2,'未支付超过一天自动关闭订单');
        }
        
        return true;
    }

    /**
     * 支付成功未充值订单进行充值
     */
    public function bill(){
        $orders = $this->model->where('bill_status',1)->get();
        foreach($orders as $order){
            $this->billService->mobileBill($order->id);
        }
    }

    public function pay(){
        // Log::info('支付查询');
        $orders = $this->model->where('bill_status',0)->get();
        $payApp = Factory::payment(config('wechat.payment.default'));
        foreach($orders as $order){
            $result = $payApp->order->queryByOutTradeNumber($order->bill_app_order_id);
            \DB::transaction(function() use($result,$order){
                // 将订单的 closed 字段标记为 true，即关闭订单
                if($result && isset($result['result_code']) && $result['result_code'] == 'SUCCESS'){
                    $total_fee = bcmul($order->bill_money , 100 ,0);
                    if(isset($result['total_fee']) && $result['total_fee'] == $total_fee){
                        if(isset($result['trade_state'])){
                            if($result['trade_state'] == 'SUCCESS'){
                                if($order->changeStatus(1)){
                                    $order->bill_wx_order_id = $result['transaction_id'];
                                    $order->save();
                                    $this->billService->mobileBill($order->id);
                                }
                            }elseif($result['trade_state'] == 'PAYERROR'){
                                $order->changeStatus(2,'查询支付状态为PAYERROR，判定为失败');
                            }
                        }
                    }else{
                        $order->changeStatus(2,'查询订单支付失败,支付金额不一致：'.$result['total_fee']);
                    }
                }
                
            });
        }
    }
    /**
     * 已退款订单自动确认退款
     * @param $receive_days
     * @return bool|false|int
     */
    private function receive()
    {
        // Log::info('退款查询');
        $orders = $this->model->where('bill_status',6)->get();
        $payApp = Factory::payment(config('wechat.payment.default'));
        foreach($orders as $order){
            $result = $payApp->refund->queryByOutTradeNumber($order->bill_app_order_id);
            // Log::info($result);
            \DB::transaction(function() use($result,$order){
                // Log::info($result);
                foreach ($result as $key => $value) {
                    if(strstr($key, 'refund_status_') !== false){
                        if($value == 'SUCCESS' || $value == 'REFUNDCLOSE'){
                            $order->changeStatus(7);break;
                        }
                    }
                }
            });
        }
        return true;
    }
    /**
     * 充值查询
     */
    public function threepay(){
        // Log::info('充值查询');
        $orders = $this->model->where('bill_status',5)->get();
        foreach($orders as $order){
            $result = $this->billService->queryOrder($order->bill_app_order_id);
            \DB::transaction(function() use($result,$order){
                if($result['code'] == '00'){
                    $order_status = 0;
                    if($result['data']['status'] == 2){
                        $order->changeStatus(3);
                        $order_status = 3;
                    }else if($result['data']['status'] == 4){
                        $order->changeStatus(4,'查询充值失败');
                        //进行退款处理
                        Log::info('查询话费充值失败，即将进行退款');
                        $fail_msg = '充值失败,发起退款';
                        $this->billService->refund($order,$fail_msg);
                        $order_status = 4;
                    }
                    $this->marketService->nactive_bill_action($order,$order_status);
                }
            });
        }
        return true;
    }


    // public function test(){
    //     Log::info('充值失败测试');
    //     $orders = $this->model->where('bill_status',9)->get();
    //     $result = [];
    //     $result['code'] = '00';
    //     $result['data']= [];
    //     $result['data']['status'] = 4;

    //     foreach($orders as $order){
    //         // $result = $this->billService->queryOrder($order->bill_app_order_id);
    //         // \DB::transaction(function() use($result,$order){
    //             if($result['code'] == '00'){
    //                 $order_status = 0;
    //                 if($result['data']['status'] == 2){
    //                     // $order->changeStatus(3);
    //                     $order_status = 3;
    //                 }else if($result['data']['status'] == 4){
    //                     // $order->changeStatus(4,'查询充值失败');
    //                     // //进行退款处理
    //                     // $fail_msg = '充值失败,发起退款';
    //                     // $this->billService->refund($order,$fail_msg);
    //                     $order_status = 4;
    //                 }
    //                 $this->marketService->nactive_bill_action($order,$order_status);
    //             }
    //         // });
    //     }
    //     return true;
    // }

    /**
     * 充值失败进行退款
     */
    public function billfail(){
        // Log::info('充值失败查询');
        $orders = $this->model->where('bill_status',4)->get();
        foreach($orders as $order){
            // 通过事务执行 sql
            \DB::transaction(function() use($order){
                //进行退款处理
                $fail_msg = '充值失败,发起退款';
                $this->billService->refund($order,$fail_msg);
            });
        }
    }

    //同步充值折扣
    public function sysBillData(){
        $this->billService->sysBillData();
    }

    private function getSellData($value){
        //商品面值
        $sell_data  = (object) [];
        $facePrice = floatval(bcdiv($value->itemFacePrice , 1000, 2));
        $sell_data->facePrice = $facePrice;
        //商品折扣率
        $bill_profit = $value->itemProfit;
        if($bill_profit == -1){
            $bill_profit = BillCase::find($value->bill_case_id)->first()->item_profit;
        }
        $bill_profit = floatval(bcdiv($bill_profit , 100, 2));
        //进货价
        $sell_data->itemSalePrice = floatval(bcmul($facePrice,$bill_profit,2));
        //剩余利润 
        $sell_data->itemFreePrice = floatval(bcsub($facePrice , $sell_data->itemSalePrice,2));
        //平台利润率
        $app_profit_later = $value->app_profit;
        if($value->app_profit == -1){
            $app_profit_later = Setting::where('key','app_profit')->first()->app_profit;
        }
        $app_profit_later = floatval(bcdiv($app_profit_later , 100, 2));
        //平台出售利润
        $sell_data->AppFreePrice = floatval(bcmul($sell_data->itemFreePrice , $app_profit_later,2));
        //平台出售价
        $sell_data->AppSalePrice = floatval(bcadd($sell_data->AppFreePrice , $sell_data->itemSalePrice,2));

        //分销者利润率
        $user_profit_later = $value->user_profit;
        if($value->user_profit == -1){
            $user_profit_later = Setting::where('key','user_profit')->first()->user_profit;
        }
        $user_profit_later = floatval(bcdiv($user_profit_later , 100, 2));
        //分销剩余利润
        $ProfixFreePrice = $sell_data->ProfixFreePrice = floatval(bcmul($sell_data->itemFreePrice , $user_profit_later,2));
        // dd($ProfixFreePrice);
        //分销者出售平台利润率
        $user_app_profit_later = $value->user_app_profit;
        if($value->user_app_profit == -1){
            $user_app_profit_later = Setting::where('key','user_app_profit')->first()->user_app_profit;
        }
        $user_app_profit_later = floatval(bcdiv($user_app_profit_later , 100, 2));
        
        //分销者出售平台利润
        $sell_data->UserAppFreePrice = floatval(bcmul($ProfixFreePrice , $user_app_profit_later,2));
        
        //分销者利润
        $sell_data->UserFreePrice = floatval(bcsub($ProfixFreePrice , $sell_data->UserAppFreePrice,2));
        //分销者出售价
        $sell_data->UserSalePrice = floatval(bcadd($sell_data->ProfixFreePrice , $sell_data->itemSalePrice,2));
        return (array) $sell_data;
    }


}
