<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PhoneBillOrder extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at','finished_at'];
    protected $fillable = [
        'bill_mobile', 'bill_type_name', 
        'bill_money','bill_type_text','bill_status','bill_user_openid',
        'bill_user_data',
        'bill_msg','bill_wx_order_id','bill_data','bill_app_order_id',
        'bill_biz_order_id','finished_at','apply_from'
    ];
    protected $hidden = [
         'updated_at',
    ];

    public function changeStatus($status,$msg = false){
        $status_name = '';
        $finish_at = Carbon::now();
        $finish = false;
        //0 微信端未支付
        //1 微信端支付成功
        //2 微信端支付失败   //订单完成
        //3 平台方充值成功   //订单完成
        //4 平台方充值失败   //退款中
        //5 平台方充值中     
        //6 退款中      
        //7 退款完成        //订单完成
        //8 退款失败        //订单完成
        //9 异常订单        //订单完成
        if($status == 0){
            $status_name = '生成订单';
            $msg = $msg ? $msg : '生成订单，等待用户支付';
        }else if($status == 1){
            $status_name = '支付成功';
            $msg = $msg ? $msg : '支付成功，等待发起充值';
        }else if($status == 2){
            $status_name = '支付失败';
            $msg = $msg ? $msg : '支付失败了？？？';
            $finish = true;
        }else if($status == 5){
            $status_name = '充值中';
            $msg = $msg ? $msg : '话费充值中';
        }else if($status == 3){
            $status_name = '充值成功';
            $msg = $msg ? $msg : '话费充值成功';
            $finish = true;
        }else if($status == 4){
            $status_name = '充值失败';
            $msg = $msg ? $msg : '话费充值失败';
        }else if($status == 6){
            $status_name = '发起退款';
            $msg = $msg ? $msg : '发起退款';
        }else if($status == 7){
            $status_name = '退款完成';
            $msg = $msg ? $msg : '退款完成';
            $finish = true;
        }else if($status == 8){
            $status_name = '退款失败';
            $msg = $msg ? $msg : '退款失败';
            $finish = true;
        }else if($status == 9){
            $status_name = '异常订单';
            $msg = $msg ? $msg : '异常订单';
            $finish = true;
        }else{
            $status = 9;
            $status_name = '异常订单';
            $msg = $msg ? $msg : '异常订单';
            $finish = true;
        }
        $this->bill_status = $status;
        if(in_array($status,[2,4,8,9])){
            $this->bill_msg = $msg;
        }
        $this->updated_at = $finish_at;
        if($finish){
            $this->finished_at = $finish_at;
        }
        
        $ins_data = [
            'status_name' => $status_name,
            'status_desc' => $msg,
            'status_id' => $status,
            'phone_bill_order_id' => $this->id,
            'created_at' => $finish_at,
            'updated_at' => $finish_at,
        ];
        $has = DB::table('phone_bill_status')
        ->where('phone_bill_order_id',$this->id)
        ->where('status_id',$status)
        ->count();
        if($has){
            //Log::info('BUG？？你已被修复了，嘿嘿');
            return false;
        }
        DB::table('phone_bill_status')->insert($ins_data);
        $this->save();
        return true;
    }

    // public function status_items()
    // {
    //     //dd($this);
    //     $status_items = DB::table('phone_bill_status')->where('phone_bill_order_id',$this->id)->get();
    //     return $status_items;
    // }
}
