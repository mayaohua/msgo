<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillCase extends Model
{
    protected $fillable = [
        'case_name', 'short_desc', 'desc_content','isp','bill_type_id','stop_sale_tips','stop_sale',
        'item_profit','user_can_sale'
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
    public function bills(){
        return $this->hasMany('App\Models\Bill', 'bill_case_id', 'id');
    }
    public function billtype(){
        return $this->belongsTo('App\Models\BillType', 'bill_type_id', 'id');
    }
}