<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Models\Rule;
use App\Models\Setting;

use App\Events\JobWork;
use App\Models\BillType;
use App\Models\BillCase;
use App\Models\Bill;
use Illuminate\Http\Request;
use App\Models\BillData;
use App\Services\BillService;

class BillController extends Controller
{
    
    protected $bill;
    
    public function __construct()
    {
        
    }
    
    public function index(Request $request){
        $billTypeList = BillType::all();
        $billCaseList = BillCase::all();
        $billList = Bill::with(['sell_data'])->get();
        $billTypeList = json_encode($billTypeList);
        $billCaseList = json_encode($billCaseList);
        $billList = json_encode($billList);
        return view('admin.bill.index',compact('billTypeList','billCaseList','billList'));
    }

    public function checkPrice(Request $request){
        $data = $request->all();
        if($data['package'] == ''){
            return $this->fail('商品名称不能为空');
        }
        $data['itemProfit'] = floatval($data['itemProfit']);
        if($data['itemProfit'] < -1 || $data['itemProfit']>100){
            return $this->fail('商品折扣在 -1~100');
        }
        $data['app_profit'] = floatval($data['app_profit']);
        if($data['app_profit'] < -1 || $data['app_profit']>100){
            return $this->fail('平台销售利润比在 0~100');
        }
        $data['user_profit'] = floatval($data['user_profit']);
        if($data['user_profit'] < -1 || $data['user_profit']>100){
            return $this->fail('分销利润比在 0~100');
        }
        $data['user_app_profit'] = floatval($data['user_app_profit']);
        if($data['user_app_profit'] < -1 || $data['user_app_profit']>100){
            return $this->fail('分销平台利润比在  0~100');
        }
        if($data['itemId'] == ''){
            return $this->fail('商品编号不能为空');
        }
        $data = $this->getOtherData($data);
        return $this->success($data);
    }

    public function action(Request $request,$action){
        $data = $request->all();
        $isAdd = false;
        $nid = 0;
        DB::beginTransaction();
        switch ($action) {
            case 'case':
                if($data['case_name'] == ''){
                    return $this->fail('分类名称不能为空');
                }
                $data['item_profit'] = floatval($data['item_profit']);
                if($data['item_profit'] <= 0 || $data['item_profit']>100){
                    return $this->fail('商品折扣在1-100');
                }
                if(!isset($data['id'])){
                    $isAdd = true;
                    if(!isset($data['bill_type_id']) || !isset($data['isp'])){
                        return abort(500);
                    }
                    $res = BillCase::create($data);
                }else{
                    $id = $data['id'];
                    unset($data['bill_type_id']);
                    unset($data['id']);
                    $res = BillCase::find($id)->update($data);
                }
                break;
            case 'bill':
                if($data['package'] == ''){
                    return $this->fail('商品名称不能为空');
                }
                $data['itemProfit'] = floatval($data['itemProfit']);
                if($data['itemProfit'] < -1 || $data['itemProfit']>100){
                    return $this->fail('商品折扣在 -1~100');
                }
                $data['app_profit'] = floatval($data['app_profit']);
                if($data['app_profit'] < -1 || $data['app_profit']>100){
                    return $this->fail('平台销售利润比在 0~100');
                }
                $data['user_profit'] = floatval($data['user_profit']);
                if($data['user_profit'] < -1 || $data['user_profit']>100){
                    return $this->fail('分销利润比在 0~100');
                }
                $data['user_app_profit'] = floatval($data['user_app_profit']);
                if($data['user_app_profit'] < -1 || $data['user_app_profit']>100){
                    return $this->fail('分销平台利润比在  0~100');
                }
                if($data['itemId'] == ''){
                    return $this->fail('商品编号不能为空');
                }

                $data = $this->getOtherData($data);
                $data['sell_data'] = (array) $data['sell_data'];
                if(!isset($data['id'])){
                    $isAdd = true;
                    if(!isset($data['bill_case_id'])){
                        return abort(500);
                    }
                    $sell_data = $data['sell_data'];
                    unset($data['sell_data']);
                    $res = Bill::create($data);
                    if($res){
                        $sell_data['bill_id'] = $res->id;
                        $res = BillData::create($sell_data);
                    }else{
                        return $this->fail('操作失败');
                    }
                    
                }else{
                    $id = $data['id'];
                    unset($data['bill_type_id']);
                    unset($data['id']);
                    $sell_data = $data['sell_data'];
                    unset($data['sell_data']);
                    $res = Bill::find($id)->update($data);
                    // dd($sell_data);
                    // itemFreePrice
                    // itemFreePrice
                    if($res){
                        $sellDb = BillData::where('bill_id',$id)->first();
                        if($sellDb){
                            $sellDb->update($sell_data);
                        }else{
                            $sell_data['bill_id'] = $id;
                            // dd($sell_data);
                            $res = BillData::create($sell_data);
                        }
                    }else{
                        return $this->fail('操作失败');
                    }
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

    public function sysBillData(Request $request,BillService $service){
        $res = $service->sysBillData();
        if($res === true){
            return $this->success();
        }else{
            return $this->fail($res);
        }
    }

    private function getOtherData($value){
            $value = (object) $value;
            $sell_data = $value->sell_data = (object) [];
            //商品面值
            $sell_data = $value->sell_data = (object) [];
            $facePrice = floatval(bcdiv($value->itemFacePrice , 1000, 3));
            $sell_data->facePrice = $facePrice;
            //商品折扣率
            
            $bill_profit = $value->itemProfit;
            
            if($bill_profit == -1){
                $bill_profit = BillCase::find($value->bill_case_id)->first()->item_profit;
            }
            // dd($bill_profit);
            $bill_profit = bcdiv($bill_profit , 100, 3);
            //进货价
            $sell_data->itemSalePrice = floatval(bcmul($facePrice,$bill_profit,2));
            //剩余利润 
            $sell_data->itemFreePrice = floatval(bcsub($facePrice , $sell_data->itemSalePrice,2));
            //平台利润率
            $app_profit_later = $value->app_profit;
            if($value->app_profit == -1){
                $app_profit_later = Setting::where('key','app_profit')->first()->app_profit;
            }
            $app_profit_later = floatval(bcdiv($app_profit_later , 100, 3));
            //平台出售利润
            $sell_data->AppFreePrice = floatval(bcmul($sell_data->itemFreePrice , $app_profit_later,2));
            //平台出售价
            $sell_data->AppSalePrice = floatval(bcadd($sell_data->AppFreePrice , $sell_data->itemSalePrice,2));

            //分销者利润率
            $user_profit_later = $value->user_profit;
            if($value->user_profit == -1){
                $user_profit_later = Setting::where('key','user_profit')->first()->user_profit;
            }
            $user_profit_later = floatval(bcdiv($user_profit_later , 100, 3));
            //分销剩余利润
            $ProfixFreePrice = $sell_data->ProfixFreePrice = floatval(bcmul($sell_data->itemFreePrice , $user_profit_later,2));
            // dd($ProfixFreePrice);
            //分销者出售平台利润率
            $user_app_profit_later = $value->user_app_profit;
            if($value->user_app_profit == -1){
                $user_app_profit_later = Setting::where('key','user_app_profit')->first()->user_app_profit;
            }
            $user_app_profit_later = floatval(bcdiv($user_app_profit_later , 100, 3));
            
            //分销者出售平台利润
            $sell_data->UserAppFreePrice = floatval(bcmul($ProfixFreePrice , $user_app_profit_later,2));
            
            //分销者利润
            $sell_data->UserFreePrice = floatval(bcsub($ProfixFreePrice , $sell_data->UserAppFreePrice,2));
            //分销者出售价
            $sell_data->UserSalePrice = floatval(bcadd($sell_data->ProfixFreePrice , $sell_data->itemSalePrice,2));
        return (array) $value;
    }

    public function delAction(Request $request,$action){
        switch ($action) {
            case 'case':
                $res = BillCase::find($request->id)->delete();
                break;
            case 'bill':
                $res = Bill::find($request->id)->delete();
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