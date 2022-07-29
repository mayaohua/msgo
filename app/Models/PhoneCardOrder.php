<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PhoneCardOrder extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at','finished_at'];
    protected $fillable = [
        'mobile', 'mobile_location', 'card_name','card_product_id',
        'user_name','user_code','user_phone','user_address','apply_data',
        'apply_from','order_to','user_data','number_data','card_data',
        'card_status','card_msg'
    ];
    protected $hidden = [
         'updated_at',
    ];

    public function changeStatus($status,$msg = false){
        $status_name = '';
        $finish_at = Carbon::now();
        $finish = false;
        //0 申请成功
        //1 申请失败
        if($status == 0){
            $status_name = '申请成功';
            $msg = $msg ? $msg : '申请成功';
            $finish = true;
        }else if($status == 1){
            $status_name = '申请失败';
            $msg = $msg ? $msg : '申请失败';
            $finish = true;
        }else{
            $status = 9;
            $status_name = '异常订单';
            $msg = $msg ? $msg : '异常订单';
            $finish = true;
        }
        $this->card_status = $status;
        if(in_array($status,[1])){
            $this->card_msg = $msg;
        }
        $this->updated_at = $finish_at;
        if($finish){
            $this->finished_at = $finish_at;
        }
        
        $ins_data = [
            'status_name' => $status_name,
            'status_desc' => $msg,
            'status_id' => $status,
            'phone_card_order_id' => $this->id,
            'created_at' => $finish_at,
            'updated_at' => $finish_at,
        ];
        $has = DB::table('phone_card_status')
        ->where('phone_card_order_id',$this->id)
        ->where('status_id',$status)
        ->count();
        if($has){
            return false;
        }
        DB::table('phone_card_status')->insert($ins_data);
        $this->save();
        return true;
    }

}