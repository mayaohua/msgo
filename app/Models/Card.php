<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'card_name', 'card_icon','card_item_img','card_product_id','card_product_type',
        'first_month_fee','is_hot','text_short_desc','img_short_desc','card_case_id',
        'stop_sale','stop_sale_tips','user_can_sale','card_other_datas','sell_price'
    ];

    public function cardcase(){
        return $this->belongsTo('App\Models\Card');
    }
    
}