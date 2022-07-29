<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTixian extends Model
{
    protected $fillable = [
        'tixian_money', 'tixian_status', 'tixian_info','user_id','fail_msg','tixian_img'
    ];
}
