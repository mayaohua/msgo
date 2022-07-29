<?php

namespace App\Http\Controllers\Admin;


use App\Jobs\sysBestMobile;
use App\Models\Rule;
use App\Models\PhoneCardOrder;
use App\Models\PhoneBillOrder;
use App\Models\Setting;
use Illuminate\Http\Request;
use QL\QueryList;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_order_count = PhoneCardOrder::count();
        $success_order_count = PhoneCardOrder::where('card_msg','')->count();
        $bill_count = PhoneBillOrder::count();
        $is_mobile = $this->ismobile();
        $bill_case_num = count(config('billcase.items'));
        return view('admin.home',compact(['all_order_count','success_order_count','bill_count','is_mobile','bill_case_num']));
    }
    
    
}
