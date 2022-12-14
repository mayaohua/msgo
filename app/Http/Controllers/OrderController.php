<?php

namespace App\Http\Controllers;


use App\Jobs\sysBestMobile;
use App\Order;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use QL\QueryList;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inp = $request->only(['keyword','apply_from','loca','card','status','page','time']);
        foreach(['keyword','apply_from','loca','card','status','page','time'] as $value){
            if(!isset($inp[$value])){
                $inp[$value] = '';
            }
        }
        $inp['loca'] = explode(',',$inp['loca']);
        $inp['card'] = explode(',',$inp['card']);
        $inp['time'] = explode(',',$inp['time']);
        $inp = $this->_unsetNull($inp);
        // $data = Order::leftJoin('bmobiles','bmobiles.id','orders.bm_id')->orderBy('created_at','desc')->select('bmobiles.mobile_from','orders.*')->paginate(15);
        $data = Order::when($inp['apply_from'],function($query) use($inp){
            if($inp['apply_from'] == 'other'){
                return  $query -> where('bm_id','');
            }else{
                return  $query -> where('apply_from',$inp['apply_from']);
            }
            
         })->when($inp['loca'][0] !== '',function($query) use($inp){
             if($inp['loca'][0]){
                return  $query -> where('loca_p_c',$inp['loca'][0])->where('loca_c_c',$inp['loca'][1]);
             }else{
                return  $query -> where('loca_p_c',$inp['loca'][0]);
             }
          })->when($inp['card'][0] !== '',function($query) use($inp){
            return  $query -> where('card_gid',$inp['card'][1]);
         })->when($inp['status'] !== '',function($query) use($inp){
             if(!$inp['status']){
                return  $query -> where('fail_msg','!=','');
             }else{
                return  $query -> where('fail_msg','');
             }
        })->when($inp['keyword'],function($query) use($inp){
            return  $query -> where('mobile','like','%'.$inp['keyword'].'%')
            ->orWhere('user_name','like','%'.$inp['keyword'].'%')
            ->orWhere('user_code','like','%'.$inp['keyword'].'%')
            ->orWhere('user_phone','like','%'.$inp['keyword'].'%')
            ->orWhere('user_address','like','%'.$inp['keyword'].'%');
        })->when($inp['time'][0] !== '',function($query) use($inp){
            return  $query -> whereBetween('created_at',$inp['time']);
         })->orderBy('created_at','desc')->select('orders.*')->paginate(15);
        $data = json_encode($data);

        $inp['loca'][0] = $inp['loca'][0] === "0" ? 0 : $inp['loca'][0];
        $locaArr = json_encode($this->getLoca());
        $cardArr = json_encode($this->getCard());
        $inp = json_encode($inp);

        return view('order.index',compact('data','locaArr','cardArr','inp'));
    }

    private function _unsetNull($arr){
        if($arr !== null){
            if(is_array($arr)){
                if(!empty($arr)){
                    foreach($arr as $key => $value){
                        if($value === null){
                            $arr[$key] = '';
                        }else{
                            $arr[$key] = $this->_unsetNull($value);      //??????????????????
                        }
                    }
                }else{ $arr = ''; }
            }else{
                if($arr === null){ $arr = ''; }         //??????????????????
            }
        }else{ $arr = ''; }
        return $arr;
    }

    private function getLoca(){
        $arr[] = [
            'value' => '',
            'label' => '??????',
        ];
        $arr[] = [
            'value' => 0,
            'label' => '??????',
        ];
        foreach(config('provice') as $index => $value){
            $temp = [
                'value' => $value['ess_code'],
                'label' => $value['region_name'],
                'children' =>[]
            ];
            foreach($value['city'] as $i => $v){
               $c = [
                'value' => $v['ess_code'],
                'label' => $v['region_name']
               ]; 
               $temp['children'][] = $c;
            }
            $arr[] = $temp;
        }
        return $arr;
    }
    private function getCard(){
        $arr[] = [
            'value' => '',
            'label' => '??????',
        ];
        foreach(config('card') as $index => $value){
            $temp = [
                'value' => $value['id'],
                'label' => $value['cards_name'],
                'children' =>[]
            ];
            foreach($value['card'] as $i => $v){
               $c = [
                'value' => $v['card_goodsid'],
                'label' => $v['card_name']
               ]; 
               $temp['children'][] = $c;
            }
            $arr[] = $temp;
        }
        return $arr;
    }

    public function resetAction(){
        if(Order::where('id','>',0)->delete()){
            return $this->success();
        }
        return $this->fail();
    }
}