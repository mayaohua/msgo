<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuleController extends Controller
{

    private static $rule_list;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        self::$rule_list = config('rule');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rule_list = json_encode(Rule::orderBy('ze_order')->get());
        return view('role.list',compact(['rule_list']));
    }

    public function add(Request $request)
    {
        return view('role.add');
    }

    public function addAction(Request $request)
    {
        $data = $request->only(['ze_name','ze_rule','ze_order','ze_status']);
        if(Rule::create($data)){
            return $this->success(null,'添加成功');
        }
        return $this->fail();
    }

    public function edit(Request $request)
    {
        $id = $request->route('id');
        $info = Rule::find($id);
        if(!$info){
            return abort(404);
        }
        $info->ze_status = $info->ze_status ? true:false;
        return view('role.edit',compact(['info']));
    }

    public function editAction(Request $request)
    {
        $id = $request->route('id');
        $data = $request->only(['ze_name','ze_rule','ze_order','ze_status']);
        $data['ze_status'] = $data['ze_status'] ? 1:0;
        if(Rule::find($id)->update($data)){
            return $this->success(null,'修改成功');
        }
        return $this->fail();
    }



    public function delAction(Request $request)
    {
        $id = $request->route('id');
        if(Rule::find($id)->delete()){
            return $this->success(null,'删除成功');
        }
        return $this->fail();
    }

    public function resetAction(){
        DB::beginTransaction();
        try{ 
            Rule::where('id','>',0)->delete();
            
            $all_data = config('rule');
            // foreach($all_data as $key => $value){
            //     $all_data[$key]['ze_rule'] = json_encode($value['ze_rule']);
            // }
            DB::table('rules')->insert($all_data);
            $res = Setting::where('key','jobForm')->first();
            $res->value = json_decode($res->value);
            $res->value->find_rules = [];
            $res->value->find_rules[] = Rule::first()->id;
            $res->value = json_encode($res->value);
            $res->save();
            DB::commit();
            return $this->success(null,'重置成功'); 
        }catch (\Exception $e) {
            dd($e);
            //接收异常处理并回滚
            DB::rollBack(); 
            return $this->fail();
        }
        

        
    }
}
