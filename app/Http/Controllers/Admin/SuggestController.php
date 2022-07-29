<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Suggest;

class SuggestController extends Controller
{
    public function list(){
        $sug_list = json_encode(Suggest::orderBy('created_at')->get());
        return view('admin.suggest.index',compact(['sug_list']));
    }
    public function put(Request $request){
        $data = [];
        $file = $request->file('kui_files');
        if($file && $file->isValid()){
            $path = Storage::disk('uploads')->putFile(date('Ymd') , $file);
            $data['kui_file'] = Storage::disk('uploads')->url($path);
        }
        $data['kui_content'] = $request->get('kui_content');
        $data['kui_contact'] = $request->get('kui_contact');
        $data['openid'] = $request->get('openid');
        if(Suggest::create($data)){
            return $this->success();
        }
        return $this->fail();
    }
}