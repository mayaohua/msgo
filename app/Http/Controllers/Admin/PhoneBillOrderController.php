<?php

namespace App\Http\Controllers\Admin;


use App\Jobs\sysBestMobile;
use App\Order;
use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use QL\QueryList;
use App\Models\PhoneBillOrder;
use Illuminate\Support\Facades\DB;
use App\Services\BillService;

class PhoneBillOrderController extends Controller
{

    protected $bill = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BillService $service)
    {
        $this->bill = $service;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inp = $request->only(['keyword','bill_status','page','time']);
        foreach(['keyword','bill_status','page','time'] as $value){
            if(!isset($inp[$value])){
                $inp[$value] = '';
            }
        }
        $inp['time'] = explode(',',$inp['time']);
        $inp = $this->_unsetNull($inp);
        $data = PhoneBillOrder::when($inp['bill_status'] !== '',function($query) use($inp){
            return  $query -> where('bill_status',$inp['bill_status']);
        })->when($inp['keyword'],function($query) use($inp){
            return  $query -> where('bill_data','like','%'.$inp['keyword'].'%')
            ->orWhere('bill_mobile','like','%'.$inp['keyword'].'%');
        })->when($inp['time'][0] !== '',function($query) use($inp){
            $inp['time'][0].=' 00:00:00';
            $inp['time'][1].=' 23:59:59';
            return  $query -> whereBetween('created_at',$inp['time']);
         })->orderBy('created_at','desc')->paginate(15);
        foreach($data->items() as $value){
            $value -> bill_data = json_decode($value -> bill_data);
            $value -> status_items = DB::table('phone_bill_status')->where('phone_bill_order_id',$value->id)->get();
        }
        // dd($data->items());
        $data = json_encode($data);
        $inp = json_encode($inp);
        return view('admin.order.bill',compact('data','inp'));
    }

    public function del(Request $request,$id){
        $res = PhoneBillOrder::find($id);
        if($res){
            $res->delete(); 
        }
        return $this->success();
    }

    public function caseList(Request $request){
        $data = config('billcase.items');
        if(!$data){
            $data =  $this->bill->getAllCase();
            $this->setConfig($data);
        }
        // dd($data);
        $data = json_encode($data);
        return view('admin.order.bill.case',compact('data'));
    }
    public function caseReset(Request $request){
        $data =  $this->bill->getAllCase();
        $this->setConfig($data);
        return $this->success($data);
    }

    public function caseEdit(Request $request,$oid){
        $reqdata = $request->all();
        $reqdata['id'] = $oid;
        if($reqdata['status'] != 2 && $reqdata['status'] != 3){
            return $this->fail('状态只能是2或者3');
        }
        if($reqdata['bizId'] != 200 && $reqdata['bizId'] != 201 && $reqdata['bizId'] != 202){
            return $this->fail('状态只能是200或者201或者202');
        }
        if($reqdata['itemName'] == ''){
            return $this->fail('商品名称不能为空');
        }
        if($reqdata['areaCode'] == '' || $reqdata['areaCodeDesc'] == '' ){
            return $this->fail('商品地区或地区编码不能为空');
        }
        if($reqdata['status'] == 2){
            $reqdata['statusDesc'] = '上架';
        }else{
            $reqdata['statusDesc'] = '下架';
        }
        if($reqdata['itemFacePrice'] == 0 || $reqdata['itemSalesPrice'] == 0){
            return $this->fail('价格不能为0');
        }
        $data = config('billcase.items');
        foreach($data as $index => $value){
            if($value['id'] == $oid){
                $data[$index] = $reqdata;
                break;
            }
        }
        $this->setConfig($data);
        return $this->success();
    }
    public function caseAdd(Request $request){
        $reqdata = $request->all();
        if($reqdata['id'] == ''){
            return $this->fail('商品ID不能为空');
        }
        if($reqdata['status'] != 2 && $reqdata['status'] != 3){
            return $this->fail('状态只能是2或者3');
        }
        if($reqdata['bizId'] != 200 && $reqdata['bizId'] != 201 && $reqdata['bizId'] != 202){
            return $this->fail('状态只能是200或者201或者202');
        }
        if($reqdata['itemName'] == ''){
            return $this->fail('商品名称不能为空');
        }
        if($reqdata['areaCode'] == '' || $reqdata['areaCodeDesc'] == '' ){
            return $this->fail('商品地区或地区编码不能为空');
        }
        if($reqdata['status'] == 2){
            $reqdata['statusDesc'] = '上架';
        }else{
            $reqdata['statusDesc'] = '下架';
        }
        if($reqdata['itemFacePrice'] == 0 || $reqdata['itemSalesPrice'] == 0){
            return $this->fail('价格不能为0');
        }
        $data = config('billcase.items');
        foreach($data as $index => $value){
            if($value['id'] == $reqdata['id']){
                return $this->fail('商品ID已存在');
                break;
            }
        }
        $data[] = $reqdata;
        $this->setConfig($data);
        return $this->success();
    }

    public function caseDel(Request $request,$id){
        $data = config('billcase.items');
        $inde = null;
        foreach($data as $index => $value){
            if($value['id'] == $id){
                $inde = $index;
                break;
            }
        }
        if($inde){
            array_splice($data, $inde, 1);
            $this->setConfig($data);
        }
        return $this->success();
    }

    private function setConfig($caseList){
        $path = base_path().'/config/billcase.php';
        $str = '<?php 
        return ';
        $arr = [
            'items' => $caseList
        ];
        $str.= json_encode($arr,JSON_UNESCAPED_UNICODE).';';
        $str = str_replace('{','[',$str);
        $str = str_replace('}',']',$str);
        $str = str_replace(':',' => ',$str);
        file_put_contents($path,$str);
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

    

    public function resetAction(){
        if(PhoneBillOrder::where('id','>',0)->delete()){
            return $this->success();
        }
        return $this->fail();
    }
}