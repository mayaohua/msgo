<?php

namespace App\Http\Controllers\Admin;


use App\Events\JobWork;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\CardCase;
use App\Models\Card;

class CardController extends Controller
{
    public function index(){
        $cardCaseList = CardCase::all();
        $cardList = Card::all();
        $cardCaseList = json_encode($cardCaseList);
        $cardList = json_encode($cardList);
        return view('admin.card.index',compact('cardCaseList','cardList'));
    }

    public function action(Request $request,$action){
        $data = $request->all();
        $isAdd = false;
        $nid = 0;
        DB::beginTransaction();
        switch ($action) {
            case 'case':
                if($data['case_name'] == ''){
                    return $this->fail('卡种名称不能为空');
                }
                if($data['case_icon'] == ''){
                    return $this->fail('卡种图标不能为空');
                }
                
                
                $json = $data['case_other_datas'];
                if($json) {
                    if(!(!is_numeric($json) && null !== json_decode($json))) return $this->fail('json格式不正确');
                }
                
                if(!isset($data['id'])){
                    $isAdd = true;
                    if(!isset($data['card_case_id'])){
                        return abort(500);
                    }
                    $res = CardCase::create($data);
                }else{
                    $id = $data['id'];
                    unset($data['card_case_id']);
                    unset($data['id']);
                    $res = CardCase::find($id)->update($data);
                }
                break;
            case 'card':
                if($data['card_name'] == ''){
                    return $this->fail('套餐名称不能为空');
                }
                if($data['card_icon'] == ''){
                    return $this->fail('套餐图标不能为空');
                }
                $json = $data['card_other_datas'];
                if($json) {
                    if(!(!is_numeric($json) && null !== json_decode($json))) return $this->fail('json格式不正确');
                }
                $json = $data['first_month_fee'];
                if($json) {
                    if(!(!is_numeric($json) && null !== json_decode($json))) return $this->fail('json格式不正确');
                }
                if(!isset($data['id'])){
                    $isAdd = true;
                    if(!isset($data['card_case_id'])){
                        return abort(500);
                    }
                    $res = Card::create($data);
                }else{
                    $id = $data['id'];
                    unset($data['card_case_id']);
                    unset($data['id']);
                    
                    $res = Card::find($id)->update($data);
                    // dd($res);
                }
                break;
            default:
                return abort(404);
                break;
            
        }
        if($res){
            if($isAdd){
                $nid = $res->id;
            }
            DB::commit();
            return $this->success(['is_add' => $isAdd,'nid' => $nid]);
        }
        return $this->fail('操作失败');
    }

    public function delAction(Request $request,$action){
        switch ($action) {
            case 'case':
                $res = CardCase::find($request->id)->delete();
                break;
            case 'card':
                $res = Card::find($request->id)->delete();
                break;
            default:
                return abort(404);
                break;
            
        }
        if($res){
            return $this->success();
        }
        return $this->fail('删除失败');
    }
    
}