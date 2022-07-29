<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggest;

class IndexController extends Controller
{
    public function index(){
        return view('home.index');
    }
    public function store(){
        return view('home.store');
    }
    public function abuotUs(){
        return view('home.about_us');
    }

    public function putQuestion(Request $request){
        $data = [];
        $data['kui_file']  = $request->get('imgs_url');
        $data['kui_content'] = $request->get('content');
        $data['kui_contact'] = $request->get('phone');
        $data['kui_openid'] =  '';
        $data['kui_user'] =  '';
        $data['kui_from'] =  $request->get('from');
        if(Suggest::create($data)){
            return $this->success();
        }
    }
}