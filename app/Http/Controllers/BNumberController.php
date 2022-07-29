<?php

namespace App\Http\Controllers;


use App\Events\JobWork;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Services\Zop\ZopService;
class BNumberController extends Controller
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
        $inp = $request->only(['mobile','mobile_from','rule','loca','card','sell','status','page']);
        foreach(['mobile','mobile_from','rule','loca','card','sell','status','page'] as $value){
            if(!isset($inp[$value])){
                $inp[$value] = '';
            }
        }
        $inp['loca'] = explode(',',$inp['loca']);
        $inp['card'] = explode(',',$inp['card']);
        $inp = $this->_unsetNull($inp);
        $data = Bmobile::when($inp['mobile_from'],function($query) use($inp){
            return  $query -> where('mobile_from',$inp['mobile_from']);
         })->when($inp['loca'][0] !== '',function($query) use($inp){
             if($inp['loca'][0]){
                return  $query -> where('loca_p_c',$inp['loca'][0])->where('loca_c_c',$inp['loca'][1]);
             }else{
                return  $query -> where('loca_p_c',$inp['loca'][0]);
             }
          })->when($inp['card'][0] !== '',function($query) use($inp){
            $gid = $this->get_gcid($inp['card'][1]);
            
            if(!$gid){
              $gid = $inp['card'][1];  
            }
            return  $query -> where('card_gid',$gid);
         })->when($inp['rule'] !== '',function($query) use($inp){
            return  $query -> where('rule_id',$inp['rule']);
        })->when($inp['sell'] !== '',function($query) use($inp){
            return  $query -> where('sell',$inp['sell']);
        })->when($inp['status'] !== '',function($query) use($inp){
            return  $query -> where('status',$inp['status']);
        })->when($inp['mobile'],function($query) use($inp){
            return  $query -> where('mobile','like','%'.$inp['mobile'].'%');
        })->paginate(15);
        $data = json_encode($data);
        
        $job_num = DB::table('jobs')->count();
        $inp['loca'][0] = $inp['loca'][0] === "0" ? 0 : $inp['loca'][0];
        $settingObj = Setting::where('key','jobForm')->first();
        $val = json_decode($settingObj->value);
        $ruleArr = Rule::whereIn('id',$val->find_rules)->get(['ze_name','ze_rule','id'])->toArray();
        array_unshift($ruleArr,[
            'ze_name' => '无规则',
            'ze_rule' => '',
            'id' => 0
        ]);
        $inp['rule'] =$inp['rule'] === '' ? '' : (int) $inp['rule'];
        $ruleArr = json_encode($ruleArr);
        $locaArr = json_encode($this->getLoca());
        $cardArr = json_encode($this->getCard());
        $inp = json_encode($inp);
        return view('bnumber.index',compact('data','job_num','ruleArr','locaArr','cardArr','inp'));
    }

    private function get_gcid($cid){
        $zop = config('card');
        foreach($zop as $value){
            foreach($value['card'] as $v){
                if($v['card_goodsid'] == $cid){
                    return $v['word_id'];
                }
            }
        }
        return null;
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

    public function add(Request $request)
    {
        return view('bnumber.add');
    }

    public function addAction(Request $request)
    {
        
    }

    public function edit(Request $request)
    {
        
    }

    public function editAction(Request $request)
    {
        
    }



    public function delAction(Request $request)
    {
        
    }

    public function resetAction(){
        $res = Bmobile::withTrashed()->where('id','>',0)->forceDelete();
        if($res){
            return $this->success(null,'清空成功');
        }
        return $this->fail();
    }
    public function resetJobsAction(){
        $res = DB::table('jobs')->where('id','>',0)->delete();
        if($res){
            return $this->success(null,'清空成功');
        }
        return $this->fail();
    }

    public function JobWorkAction(){
        $job_num = DB::table('jobs')->count();
        if($job_num){
            return $this->fail('任务正在执行中');
        }
        event(new JobWork('10010'));
        return $this->success();
    }
}
