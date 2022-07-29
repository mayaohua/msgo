<?php

namespace App\Http\Controllers\WeChat\Card;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Card;
use App\Models\CardCase;
use App\Services\HaokaService;

class IndexController extends Controller
{
    
    public function __construct()
    {
        
    }
    public function index(Request $request,HaokaService $haokaService){
        $cards = Card::where('is_hot',1)->groupBy('card_case_id')->limit(4)->get();
        $cace_ids = $cards->map(function ($c) {
            return $c->card_case_id;
        });
        $hot_cards = CardCase::whereIn('id',$cace_ids)->where('stop_sale',0)->with(['cards'=>function($query){
            $query->where('stop_sale',0);
            $query->where('is_hot',1);
        }])->get();
        $hot_cards = json_encode($hot_cards);
        $user = Session::get('wechat_user');
        $active = 0;
        // $best_nums = $haokaService->getBestNumForIndex();
        $best_nums = json_encode([]);
        return view('wx.card.index',compact('active','hot_cards','best_nums'));
    }
    public function kind(Request $request){
        $user = Session::get('wechat_user');
        $tab = $request->get('xcx', 0);
        $active = $tab ? -1 : 2;
        $cards = CardCase::where('stop_sale',0)->with(['cards'=>function($query){
            $query->where('stop_sale',0);
        }])->get();
        return view('wx.card.kind',compact('active','cards'));
    }
    
    public function details(Request $request,$cid){
        
        $caseDb = CardCase::with(['cards'=>function($query){
            $query->where('stop_sale',0);
        }])->find($cid);
        if(!$caseDb ||$caseDb->stop_sale){return abort(404);}
        $caseDb->case_other_datas = json_decode($caseDb->case_other_datas);
        $caseDb->desc_top_imgs = self::img_to_arr($caseDb->desc_top_imgs);
        $caseDb->desc_bottom_imgs = self::img_to_arr($caseDb->desc_bottom_imgs);
        $card_id = Input::get('card_id',$caseDb->cards[0]->id);
        $card_ids = $caseDb->cards->map(function($q){
            return $q->id;
        })->toArray();
        if(!in_array($card_id,$card_ids)){
            $card_id = $card_ids[0];
        }
        $details = json_encode($caseDb);
        $active = -1;
        return view('wx.card.details',compact('active','details','card_id'));
    }

    public function applyCard(Request $request,$id){
        $cardDb = Card::find($id);
        if(!$cardDb){return abort(404);}
        $caseDb = CardCase::find($cardDb->card_case_id);
        if(!$caseDb){return abort(404);}
        if($cardDb->stop_sale || $caseDb->stop_sale){return abort(404);}
        $active = -1;
        $cardDb->show_name = $cardDb->card_name;
        if($cardDb->show_name != $caseDb->case_name){
            $cardDb->show_name = $caseDb->case_name.'-'.$cardDb->show_name;
        }
        $cardDb->card_other_datas = json_decode($cardDb->card_other_datas);
        $cardinfo = json_encode($cardDb);
        return view('wx.card.apply_card',compact('active','cardinfo'));
    }

    public function bestNum(Request $request,HaokaService $haokaService){
        $tab = $request->get('xcx', 0);
        $active = $tab ? -1 : 1;
        $best_nums = json_encode([]);
        $rules = config('rule_new');
        $rules = json_encode($rules);
        return view('wx.card.bestnum',compact('active','best_nums','rules'));
    }
    public function applyBest(Request $request,HaokaService $haokaService){
        $active = -1;
        if($request->get('card_id')){
            $cardDb = Card::find($request->get('card_id'));
        }
        if($request->get('product_id')){
            $cardDb = Card::where('card_product_id',$request->get('product_id'))->first();
        }
        if($cardDb){
            $cardDb->card_other_datas = json_decode($cardDb->card_other_datas);
        }else{
            return abort(404);
        }
        $otherinfo = [
            'number' => $request->get('number'),
            'card_name' => $request->get('card_name'),
            'mobile_from' => $request->get('mobile_from'),
            'provinceCode' => $request->get('provinceCode'),
            'provinceName' => $request->get('provinceName'),
            'cityCode' => $request->get('cityCode'),
            'cityName' => $request->get('cityName'),
            'mobile_from' => $request->get('mobile_from'),
        ];
        $otherinfo = json_encode($otherinfo);
        $cardinfo = json_encode($cardDb);
        return view('wx.card.apply_best',compact('active','cardinfo','otherinfo'));
    }

    public function contactUs(Request $request){
        $active = 3; 
        return view('wx.card.us',compact('active'));
    }
    public function qq(Request $request){
        $active = 3; 
        return view('wx.card.qq',compact('active'));
    }
    public function question(Request $request){
        $active = -1;
        $user = Session::get('wechat_user');
        return view('wx.card.question',compact('active'));
    }
    public function wxapp(Request $request){
        $active = -1;
        return view('wx.card.wxapp',compact('active'));
    }
    public function tests(Request $request){
        $active = -1;
        return view('wx.card.test',compact('active'));
    }
    
    

    private static function img_to_arr($value){
        return explode(',',trim($value,','));
    }
    
}