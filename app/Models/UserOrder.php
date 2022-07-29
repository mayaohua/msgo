<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $dates = ['finished_at'];
    protected $fillable = [
        'order_type', 'order_status', 'order_name','order_uuid',
        'order_status_text','order_info','order_money','finished_at',
        'user_id','order_id','order_status','fail_msg'
    ];
    
}
