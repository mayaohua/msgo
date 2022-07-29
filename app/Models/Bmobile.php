<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bmobile extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'mobile', 'loca_name', 'loca_p_c','loca_c_c','card_name','card_gid','rule_name','rule_id','other','sell','status','mobile_from'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
