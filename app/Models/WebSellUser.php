<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSellUser extends Model
{
    protected $fillable = [
        'user_openid', 'user_info', 'sale_user_id',
        'order_count'
    ];
}
