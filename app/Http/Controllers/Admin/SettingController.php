<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
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


    public function index(){
        $settingObj = Setting::where('key','sellForm')->first();
        $sellForm = $settingObj ? $settingObj->value : '{}';
        return view('admin.setting.index',compact(['sellForm']));
    }

    public function indexAction(Request $request){
        //任务设置
        $type = $request->route('type');
        switch ($type) {
            case 'sellForm':
                    $data = $request->all();
                    $res = Setting::where('key','sellForm')->update(['value'=>json_encode($data)]);
                    if($res){
                        return $this->success();
                    }
                    return $this->fail();
                    break;
            
            default:
                # code...
                break;
        }
        return $this->success(["type" => $type]);
    }
    public function uploadAction(Request $request){
        $file = $request->file('fileUpload');
        if($file->isValid())
        {
            $ext = $file->getClientOriginalExtension();//后缀
            $path = $file->getRealPath();//路径
            $filename = date('Y-m-d-H-i-s').'.'.$ext;//重命名
            Storage::disk('uploads')->put($filename, file_get_contents($path));//上传
        }
        return $this->success(['path'=>Storage::disk('uploads')->url($filename)]);
    }
}