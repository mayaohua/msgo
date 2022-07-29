<?php

namespace App\Http\Controllers\WeChat\Bill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use App\Models\BillType;
use App\Models\Bill;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\PhoneBillOrder;
use Illuminate\Support\Facades\Storage;
use App\Models\Suggest;

class ApiController extends Controller
{
    
    public function __construct()
    {
        
    }

    
    public function index()
    {
        // dd();
    }

    public function getJSSDKConfig(Request $request){
        // debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        // appId: '', // 必填，公众号的唯一标识
        // timestamp: result.timestamp, // 必填，生成签名的时间戳
        // nonceStr: result.nonceStr, // 必填，生成签名的随机串
        // signature: result.signature,// 必填，签名
        // jsApiList: ['chooseImage', 'previewImage'], // 必填，需要使用的JS接口列表
        // openTagList: ['wx-open-launch-weapp'] // 可选，需要使用的开放标签列表
        $arr = ['chooseImage','previewImage'];
        $openTag = ['wx-open-launch-weapp','wx-open-subscribe'];
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $app->jssdk->setUrl($request->server('HTTP_REFERER'));
        $config = $app->jssdk->buildConfig($arr,false,false,false,$openTag);
        return $this->success($config);
    }
    
    public function vipList(Request $request){
        $input = $request->get('mobile');
        if($input){
            $isp = $this->get_mobile_info($input);
            if(!$isp){return $this->fail('您输入的号码不正确',-1,['list'=> false,'ips'=> null]);}
        }
        
        $res = BillType::where('type_where','card_vip')->with(['billcases'=>function($query){
            $query->where('stop_sale',0)->with(['bills'=>function($query){
                $query->where('stop_sale',0);
                $query->with('sell_data');
            }]);
        }])->get();
        return $this->success(['list'=>$res,'ips'=> (isset($isp) ? $isp : null)]);
    }

    public function callList(Request $request){
        $input = $request->get('mobile');
        if($input){
            $isp = $this->get_mobile_info($input);
            if(!$isp){return $this->fail('您输入的号码不正确',-1,['list'=> false,'ips'=> null]);}
            $res = BillType::where('type_where','huafei')->where('type_name',$isp['sp'])->with(['billcases'=>function($query){
                $query->where('stop_sale',0)->with(['bills'=>function($query){
                    $query->where('stop_sale',0);
                    $query->with('sell_data');
                }]);
            }])->get();
        }else{
            $res = BillType::where('type_where','huafei')->with(['billcases'=>function($query){
                $query->where('stop_sale',0)->with(['bills'=>function($query){
                    $query->where('stop_sale',0);
                    $query->with('sell_data');
                }]);
            }])->get();
        }
        return $this->success(['list'=>$res,'ips'=> (isset($isp) ? $isp : null)]);
    }

    public function flowList(Request $request){
        $input = $request->get('mobile');
        if($input){
            $isp = $this->get_mobile_info($input);
            if(!$isp){return $this->fail('您输入的号码不正确',-1,['list'=> false,'ips'=> null]);}
            $res = BillType::where('type_where','flow')->where('type_name',$isp['sp'])->with(['billcases'=>function($query){
                $query->where('stop_sale',0)->with(['bills'=>function($query){
                    $query->where('stop_sale',0);
                    $query->with('sell_data');
                }]);
            }])->get();
        }else{
            $res = BillType::where('type_where','flow')->with(['billcases'=>function($query){
                $query->where('stop_sale',0)->with(['bills'=>function($query){
                    $query->where('stop_sale',0);
                    $query->with('sell_data');
                }]);
            }])->get();
        }
        return $this->success(['list'=>$res,'ips'=> (isset($isp) ? $isp : null)]);
    }
    

    public function recordList(Request $request){
        $user = Session::get('wechat_user');
        $open_id = $user['original']['openid'];
        $result = PhoneBillOrder::where('bill_user_openid',$open_id)
        ->whereNotIn('bill_status',[2,9])
        ->select('id','bill_app_order_id','bill_mobile','bill_msg','bill_status'
        ,'bill_type_name','bill_type_text','created_at','finished_at','updated_at')
        ->orderBy('updated_at','desc')->paginate(10);
        return $this->success($result);
    }

    public function putQuestion(Request $request){
        $user = Session::get('wechat_user');
        $open_id = $user['original']['openid'];
        $data = [];
        $data['kui_file']  = $request->get('imgs_url');
        $data['kui_content'] = $request->get('content');
        $data['kui_contact'] = $request->get('phone');
        $data['kui_openid'] =  $open_id;
        $data['kui_user'] =  json_encode($user['original'],JSON_UNESCAPED_UNICODE);
        $data['kui_from'] =  $request->get('from');
        // dd($data);
        if(Suggest::create($data)){
            return $this->success();
        }
    }
    public function uploadImg(Request $request){
        if($request->hasFile('fileUpload')&&$request->file('fileUpload')->isValid()){
            $file=$request->file('fileUpload');
            $allowed_extensions = ["png", "jpg", "gif",'jpeg'];
            if (!in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return $this->fail('只能上传png,jpg和gif格式的图片.');
            }else{
                $ext = $file->getClientOriginalExtension();//后缀
                $path = $file->getRealPath();//路径
                $filename = date('Y-m-d-H-i-s').'.'.$ext;//重命名
                $disk = \Storage::disk('uploads');
                $disk->put($filename, file_get_contents($path));//上传
                return $this->success(['path'=>$disk->url($filename)]);
            }
        }else{
            return $this->fail('上传失败');
        }
    }

    
    private function get_mobile_info($input){
        $url = 'http://cx.shouji.360.cn/phonearea.php?number='.$input;
        $res = $this->curl_request($url);
        $res = json_decode($res,1);
        if($res['code'] == 0 && (isset($res['data']['province']) && $res['data']['province'] !== '')){
            return $res['data'];
        }else{
            return false;
        }
    }
    
}
