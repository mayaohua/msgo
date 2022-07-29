<?php

namespace App\Http\Controllers\Admin;

use App\Rule;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\UserTixian;
use App\Models\WebUser;
use Illuminate\Support\Facades\DB;

class UserTiXianController extends Controller
{
    public function list(Request $request){
        $inp = $this->getInp();
        $data = UserTixian::when($inp['status'] !== '',function($query) use($inp){
            return  $query -> where('tixian_status',$inp['status']);
        })->when($inp['keyword'],function($query) use($inp){
            return  $query -> where('tixian_money','like','%'.$inp['keyword'].'%')
                           ->orWhere('fail_msg','like','%'.$inp['keyword'].'%')
                           ->orWhere('tixian_info','like','%'.$inp['keyword'].'%');
        })->when($inp['time'][0] !== '',function($query) use($inp){
            $inp['time'][0].=' 00:00:00';
            $inp['time'][1].=' 23:59:59';
            return  $query -> whereBetween('created_at',$inp['time']);
        })->orderBy('updated_at','desc')->paginate(15);
        foreach($data->items() as $value){
            $value->user = WebUser::find($value->user_id);
        }
        $data = json_encode($data);
        $inp = json_encode($inp);
        return view('admin.webuser.tixian',compact('data','inp'));
    }

    public function edit(Request $request,$id){
        $data = $request->all();
        try {
            DB::beginTransaction();
            $orderDb = UserTixian::find($id);
            if($orderDb->tixian_status != 1){
                DB::rollBack();
                return $this->fail('修改失败');
            }
            $orderDb -> update($data);
            $userDb = WebUser::find($orderDb->user_id)->first();
            if($data['tixian_status'] == 2){//申请通过
                $userDb->user_dongjie_money = bcsub($userDb->user_dongjie_money,$orderDb->tixian_money,2);
                $userDb->user_tixian_money = bcadd($userDb->user_tixian_money,$orderDb->tixian_money,2);
                $userDb -> save();
            }
            if($data['tixian_status'] == 3){//申请拒绝
                $userDb -> user_money = bcadd($userDb->user_money,$orderDb->tixian_money,2);
                $userDb -> user_dongjie_money = bcsub($userDb->user_dongjie_money,$orderDb->tixian_money,2);
                $userDb -> save();
            }
            DB::commit();
        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();
            return $this->fail('修改失败');
        }
        return $this->success();
    }
}