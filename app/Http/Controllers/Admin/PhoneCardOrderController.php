<?php

namespace App\Http\Controllers\Admin;


use App\Jobs\sysBestMobile;
use App\Models\PhoneCardOrder;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use QL\QueryList;

class PhoneCardOrderController extends Controller
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
        $inp = $request->only(['keyword','loca','card','status','page','time']);
        foreach(['keyword','loca','card','status','page','time'] as $value){
            if(!isset($inp[$value])){
                $inp[$value] = '';
            }
        }
        $inp['loca'] = explode(',',$inp['loca']);
        $inp['card'] = explode(',',$inp['card']);
        $inp['time'] = explode(',',$inp['time']);
        $inp = $this->_unsetNull($inp);
        // $data = Order::leftJoin('bmobiles','bmobiles.id','orders.bm_id')->orderBy('created_at','desc')->select('bmobiles.mobile_from','orders.*')->paginate(15);
        $data = PhoneCardOrder::when($inp['loca'][0] !== '',function($query) use($inp){
             if($inp['loca'][0]){
                return  $query -> where('loca_p_c',$inp['loca'][0])->where('loca_c_c',$inp['loca'][1]);
             }else{
                return  $query -> where('loca_p_c',$inp['loca'][0]);
             }
          })->when($inp['card'][0] !== '',function($query) use($inp){
            return  $query -> where('card_gid',$inp['card'][1]);
         })->when($inp['status'] !== '',function($query) use($inp){
             if($inp['status'] == 0){
                return  $query -> where('card_status',1);
             }else{
                return  $query -> where('card_status',0);
             }
        })->when($inp['keyword'],function($query) use($inp){
            return  $query -> where('mobile','like','%'.$inp['keyword'].'%')
            ->orWhere('user_name','like','%'.$inp['keyword'].'%')
            ->orWhere('user_code','like','%'.$inp['keyword'].'%')
            ->orWhere('user_phone','like','%'.$inp['keyword'].'%')
            ->orWhere('user_address','like','%'.$inp['keyword'].'%');
        })->when($inp['time'][0] !== '',function($query) use($inp){
            return  $query -> whereBetween('created_at',$inp['time']);
         })->orderBy('created_at','desc')->select('*')->paginate(15);
         
        foreach($data->items() as $value){
            $value -> user_data = json_decode($value -> user_data);
        }
        $data = json_encode($data);
        $inp['loca'][0] = $inp['loca'][0] === "0" ? 0 : $inp['loca'][0];
        $locaArr = json_encode($this->getLoca());
        $cardArr = json_encode($this->getCard());
        $inp = json_encode($inp);

        return view('admin.order.card',compact('data','locaArr','cardArr','inp'));
    }

    private function _unsetNull($arr){
        if($arr !== null){
            if(is_array($arr)){
                if(!empty($arr)){
                    foreach($arr as $key => $value){
                        if($value === null){
                            $arr[$key] = '';
                        }else{
                            $arr[$key] = $this->_unsetNull($value);      //递归再去执行
                        }
                    }
                }else{ $arr = ''; }
            }else{
                if($arr === null){ $arr = ''; }         //注意三个等号
            }
        }else{ $arr = ''; }
        return $arr;
    }

    private function getLoca(){
        $arr[] = [
            'value' => '',
            'label' => '不限',
        ];
        $arr[] = [
            'value' => 0,
            'label' => '未知',
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
            'label' => '不限',
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
        if(PhoneCardOrder::where('id','>',0)->delete()){
            return $this->success();
        }
        return $this->fail();
    }
}