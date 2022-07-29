<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'package', 'is_hot','order_tips','yh_tips','bill_case_id',
        'app_profit','user_can_sale','user_profit','user_app_profit',
        'itemId','itemProfit','itemFacePrice','stop_sale','stop_sale_tips'
    ];

    public function billcase(){
        return $this->belongsTo('App\Models\BillCase', 'bill_case_id', 'id');
    }
    public function sell_data(){
        return $this->hasOne('App\Models\BillData', 'bill_id', 'id');
    }
    
}