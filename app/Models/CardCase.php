<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardCase extends Model
{
    
    protected $fillable = [
        'case_name', 'case_icon','text_short_desc','desc_top_imgs','desc_bottom_imgs',
        'is_show_cards','stop_sale','stop_sale_tips','user_can_sale',
        'best_show','scan_show','case_other_datas','sell_factor','sell_info','sell_price','sell_banner_img','sell_item_img'
    ];

    public function cards(){
        return $this->hasMany('App\Models\Card');
    }
    
}