<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillData extends Model
{
    protected $fillable = [
        'facePrice', 'itemSalePrice','AppFreePrice','ProfixFreePrice','UserFreePrice',
        'UserAppFreePrice','AppSalePrice','UserSalePrice','bill_id','itemFreePrice'
    ];

    public function bill(){
        return $this->belongsTo('App\Models\Bill', 'bill_id', 'id');
    }
    
}