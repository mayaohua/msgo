<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebUser extends Model
{
    protected $fillable = [
        'user_name', 'user_code', 'user_status',
        'user_phone','user_wx_id','user_openid','user_key',
        'user_info','user_money','user_dongjie_money','user_tixian_money',
        'user_order_count'
    ];
}
