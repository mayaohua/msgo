<?php

namespace App\Http\Controllers\Admin;

use App\Rule;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\WebUser;
use Illuminate\Support\Facades\DB;

class WebUserController extends Controller
{
    public function list(Request $request){
        $inp = $this->getInp();
        $data = WebUser::when($inp['status'] !== '',function($query) use($inp){
            return  $query -> where('user_status',$inp['status']);
        })->when($inp['keyword'],function($query) use($inp){
            return  $query -> where('user_name','like','%'.$inp['keyword'].'%')
                           ->orWhere('user_code','like','%'.$inp['keyword'].'%')
                           ->orWhere('user_phone','like','%'.$inp['keyword'].'%')
                           ->orWhere('user_info','like','%'.$inp['keyword'].'%')
                           ->orWhere('user_key','like','%'.$inp['keyword'].'%')
                           ->orWhere('user_wx_id','like','%'.$inp['keyword'].'%');
        })->when($inp['time'][0] !== '',function($query) use($inp){
            $inp['time'][0].=' 00:00:00';
            $inp['time'][1].=' 23:59:59';
            return  $query -> whereBetween('created_at',$inp['time']);
        })->orderBy('created_at','desc')->paginate(15);
        foreach($data->items() as $value){
            $value->user_info = json_decode($value->user_info);
        }
        $data = json_encode($data);
        $inp = json_encode($inp);
        return view('admin.webuser.index',compact('data','inp'));
    }

    public function edit(Request $request,$id){
        $data = $request->all();
        try {
            DB::beginTransaction();
            $userDb = WebUser::find($id);
            if(!$userDb){
                DB::rollBack();
                return $this->fail('修改失败');
            }
            $data['user_tixian_money'] = number_format($data['user_tixian_money'], 2);
            $data['user_money'] = number_format($data['user_money'], 2);
            if($data['user_key'] != $userDb->user_key && WebUser::where('user_key',$data['user_key'])->where('id','!=',$userDb->id)->count()){
                DB::rollBack();
                return $this->fail('key已存在');
            }
            $userDb -> update($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail('修改失败');
        }
        return $this->success();
    }
}