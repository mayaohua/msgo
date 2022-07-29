<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestMobile extends Model
{
    protected $fillable = [
        'mobile_number', 'provice_code','city_code','provice_name','city_name',
        'card_name','card_id','is_sell','data','mobile_from'
    ];
    
}