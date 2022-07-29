<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillType extends Model
{
    protected $fillable = [
        'type_name', 'type_isp','type_where'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    public function billcases(){
        return $this->hasMany('App\Models\BillCase', 'bill_type_id', 'id');
    }
}
