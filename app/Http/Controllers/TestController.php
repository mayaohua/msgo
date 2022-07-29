<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
use App\Models\PhoneBillOrder;
use Carbon\Carbon;
use App\Jobs\CloseBillOrder;
use App\Models\BillType;
use App\Models\BillCase;
use App\Models\Bill;
use Illuminate\Support\Facades\Session;
use QL\QueryList;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __construct(){
        

    }
    
    public function test(){
        $num = session()->get('test_num');
        if($num){
            $num ++;
            session()->put('test_num',$num);
            return $num;
        }
        $num = 1;
        session()->put('test_num',$num);
        return $num;
    }
    
    private function loginAction(){
        
        try {
            $client =new Client(['base_uri' => 'http://br.cz500.top']);
            //cookie文件
            $cookie_file = storage_path('app/cookie.txt');
            $jar = new CookieJar();
            //请求一次，存储cookie
            $response = $client->request('GET','/index.do',[
                'cookies' => $jar
            ]);
            
            $cookieArr = $jar->toArray();
            file_put_contents($cookie_file, json_encode($cookieArr));

            $cookieArr2 = file_get_contents($cookie_file);
            $cookieArr2 = json_decode($cookieArr2, true);
            $jar2 = new CookieJar(false, $cookieArr2);
            //获取验证码内容
            $response = $client->request('GET','/admin/checkCode.do',[
                'cookies' => $jar2
            ]);
            
            $body = $response->getBody();
            $file_content = (string)$body;

            $filename = 'appp/cap.png';//重命名
            Storage::disk('uploads')->put($filename, $file_content);

            $vcode = verify_code($file_content);
            $vcode = json_decode($vcode,1);
            
            $code = $vcode['VERIFY_CODE_ENTITY']['VERIFY_CODE'];
            if(!$code){
                return false;
            }
            // $code = '1234';
            //获取加密数据
            $headers = [
                "Host"=>" br.cz500.top",
                "Origin"=>" http://br.cz500.top",
                "Referer"=>" http://br.cz500.top/index.do"
            ];
            $response = $client->request('GET','/index/getPublicKey.do',[
                'headers' => $headers,
                'cookies' => $jar2
            ]);
            $result = (string)$response->getBody();
            $result = json_decode($result,1);
            $module = $result['module'];
            $url = 'https://msgo.xyz/br.html';
            $empoent = $module['empoent'];
            $module = $module['module'];
            $command = "/usr/local/bin/phantomjs /www/wwwroot/msgo.xyz/public/br.js {$url} $empoent $module";  //这个地方是真正调用phantomjs这个程序的。使用路径来实现调用
            @exec($command,$output_main);
            if(!isset($output_main[0])){
                return false;
            }
            $pwd = $output_main[0];
            //模拟登陆
            $response = $client->request('POST','/login.do',[
                'form_params' => [
                    "pwd"=> $pwd,
                    "name"=> "myh",
                    "password"=> "",
                    "checkCode"=> $code
                ],
                'headers' => $headers,
                'cookies' => $jar2
            ]);
            $result = (string)$response->getBody();
            if(strstr($result,'马耀华')){
                return true;
            }else{
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function index(){
        $service_data = $this->getBrData();
        if(!$service_data){
            return 'fail';
        }
        // dd($service_data);
        //同步充值数据
        DB::beginTransaction();
        Bill::where('id','>',0)->update([
            'stop_sale' => 1
        ]);
        $bill = Bill::with('sell_data')->get();
        foreach($bill as $b){
            foreach($service_data as $v){
                if($v['bianhao'] != $b->itemId){
                    continue;
                }
                $v['zhekou_x'] = bcdiv($v['zhekou'],100,3);
                $face_price =   bcdiv($v['shoujia'],$v['zhekou_x'],2);
                $face_price = bcmul($face_price,1000, 2);
                $b->itemProfit = $v['zhekou'];
                $b->itemFacePrice = floatval($face_price);
                $b->stop_sale = ($v['zhuangtai'] == '正常' ? 0 : 1);
                $sell_data = getSellData($b);
                $b->sell_data->update($sell_data);
                $b->save();
            }
        }
        
        DB::commit();
    }

    public function getBrData(){
        $dataHtml = $this->getHtmlData();
        if(!strstr($dataHtml,'马耀华')){
            $res = $this->loginAction();
            if(!$res){
                $res = $this->loginAction();
            }
            $dataHtml = $this->getHtmlData();//修改
        }
        if(!strstr($dataHtml,'马耀华')){
            return false;
        }
        $data = QueryList::Query($dataHtml,[
            'table_html' => ['.table-responsive .table-bordered>tbody','html'],
        ])->data;
        // dd($data);
        $rules = [
            'table_html' => ['table','html'],
        ];
        $range = 'table';
        $table_html = $data[0]['table_html'];
        // dd($table_html);
        $tables = QueryList::Query($table_html,$rules)->data;
        $all_arr = [];
        foreach($tables as $key => $value){
            $table_html = $value['table_html'];
            $str_count = substr_count($table_html,'</font>');
            // dd($str_count);
            $rules = [
                'bianhao' => ['tr:eq(0) td:gt(0)','text'],
                'mianzhi' => ['tr:eq(1) td:gt(0)','text'],
                'mingcheng' => ['tr:eq(2) td:gt(0)','text'],
                'shoujia' => ['tr:eq(3) td:gt(0)','text'],
                'zhuangtai' => ['tr:eq(4) td:gt(0)','text'],
                'zhekou' => ['tr:eq(5) td:gt(0)','text'],
            ];
            
                QueryList::Query($table_html,$rules)->getData(function($item) use(&$all_arr){
                    $item['shoujia'] = number_format(str_replace('元','',$item['shoujia']),2);
                    $item['zhekou'] = number_format(str_replace(' 折(%)','',$item['zhekou']),2);
                    //$item['mianzhi'] = number_format(str_replace('元','',$item['mianzhi']),2);
                    // dd($item);
                    $all_arr[] = $item;
                    return $item;
                }); 
            
        }
        return $all_arr;
    }

    public function getHtmlData(){
        $client =new Client(['base_uri' => 'http://br.cz500.top']);
        $cookie_file = storage_path('app/cookie.txt');
        $cookieArr2 = file_get_contents($cookie_file);
        $cookieArr2 = json_decode($cookieArr2, true);
        $jar2 = new CookieJar(false, $cookieArr2);
        $headers = [
            "Host"=>" br.cz500.top",
            "Origin"=>" http://br.cz500.top",
            "Referer"=>" http://br.cz500.top/index.do"
        ];
        
        $response = $client->request('GET','/sale/userItemExport.do',[
            'headers' => $headers,
            'cookies' => $jar2
        ]);
        return (string)$response->getBody();
    }

    private function testHtml(){

        $html =  <<<STR
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>	 充值平台 ,管理系统</title>
    <link href="http://br.cz500.top/assets/css/toast/jquery.toast.css" rel="stylesheet">
    <link href="http://br.cz500.top/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="http://br.cz500.top/assets/lib/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://br.cz500.top/assets/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="http://br.cz500.top/assets/css/custom.css?v=20180927_1" rel="stylesheet">
    <link href="http://br.cz500.top/assets/lib/icheck/css/flat/green.css" rel="stylesheet">


    <!--     <link rel="stylesheet" type="text/css" href="http://br.cz500.top/css/admin-all.css" /> -->
    <script src="http://br.cz500.top/assets/lib/jquery/jquery.min.js"></script>
    <link href="http://br.cz500.top/assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <script src="http://br.cz500.top/assets/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="http://br.cz500.top/assets/lib/bootstrap-plugins/bootbox.min.js"></script>

    <script src="http://br.cz500.top/assets/lib/pace/pace.min.js"></script>
    <link href="http://br.cz500.top/assets/lib/pace/themes/blue/pace-theme-minimal.css" rel="stylesheet">
    <link href="http://br.cz500.top/assets/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="http://br.cz500.top/assets/lib/select2/css/select2-bootstrap.min.css" rel="stylesheet">
    <script src="http://br.cz500.top/assets/lib/select2/js/select2.min.js"></script>
    <script src="http://br.cz500.top/assets/lib/select2/js/i18n/zh-CN.js"></script>
    <script type="text/javascript" src="http://br.cz500.top/assets/lib/jqLoad/Scripts/jquery-ui-jqLoding.js"></script>
    <script type="text/javascript" src="http://br.cz500.top/assets/js/notify/jquery.notify.js"></script>
    <script type="text/javascript" src="http://br.cz500.top/assets/js/toast/jquery.toast.js"></script>
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="../main.do" class="site_title"><i class="fa fa-mobile-phone"></i> <span>
                                充值平台                      </span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <!--                     <div class="profile"> -->
                <!--                         <div class="profile_pic"> -->
                <!--                             .. -->
                <!--                         </div> -->
                <!--                         <div class="profile_info"> -->
                <!--                             <span>您好，</span> -->
                <!--                             <h2>xxx</h2> -->
                <!--                         </div> -->
                <!--                     </div> -->
                <!-- /menu prile quick info -->

                <br/>

                <!-- sidebar menu -->
                <style>

.userRoleShow{
    display: none !important;
}

</style>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">




    <div class="menu_section">
        <h3>业务管理</h3>
        <ul class="nav side-menu">

                                                            <li class="	"><a style="margin: 0px"><i class="fa fa-list-ol"></i>交易管理<span
                    class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu"  style="	 display:none;  margin-top: 5px" >
                    <li class="	 	"><a href="../statistic/queryAllBizOrder.do">订单查询</a></li>
                                    </ul>
            </li>
                                        <li class="	nv active"><a style="margin: 0px"><i class="fa fa-money"></i>销售管理<span
                    class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu"  style="	 display: block; margin-top: 5px" >
                                        <li class="	current-page 	"><a href="../sale/userItemExport.do">代理商品报表</a></li>
                </ul>
            </li>
            
            

            
                                    <li class="	"><a style="margin: 0px"><i class="fa fa-cny"></i>资金管理<span
                    class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu"  style="	 display:none;  margin-top: 5px" >
                    <li class="	 			userRoleShow
    "><a href="../funds/queryChargeOrder.do">账户入账查询</a></li>
                                                            <li class="	 			userRoleShow
    "><a href="../funds/AutoAddFundsDeal.do?type=index">自动加款</a></li>
                                        <li class="	 	"><a href="../funds/queryRefundOrder.do">退款查询</a></li>
                    <li class="	 	"><a href="../funds/queryAcctLog.do">流水查询</a></li>
                    <li class="	 			userRoleShow
    "><a href="../funds/queryDownStreamFundStat.do">下游资金报表</a></li>
                                    </ul>
            </li>
            
            

            
            
        </ul>
    </div>

    

    <div class="menu_section">
        <h3>其他</h3>
        <ul class="nav side-menu">
            <li class="	"><a style="margin: 0px"><i class="fa fa-user"></i>个人管理<span
                    class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu"  style="	 display:none;  margin-top: 5px" >
                    <li class="	 	"><a href="../user/userInfoShow.do?id=543">个人资料</a></li>
                    <li class="	 	"><a href="../user/userModifyPwd.do">密码修改</a></li>
                </ul>
            </li>
        </ul>
    </div>


</div>
<!-- /sidebar menu -->


<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
</div>
<!-- /menu footer buttons -->                <!-- /sidebar menu -->


            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                                马耀华
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                <li>
                                    <a href="../user/userInfoShow.do?id=543"><i
                                            class="fa fa-user pull-right"></i>个人资料</a>
                                </li>
                                <li>
                                    <a href="../user/userModifyPwd.do"><i class="fa fa-key pull-right"></i>修改密码</a>
                                </li>
                                <li><a href="../loginOut.do"><i class="fa fa-sign-out pull-right"></i> 安全退出</a>
                                </li>
                            </ul>
                        </li>


                                                    <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                                    aria-expanded="false" style="font-size: 18px">
                                    余额 : <font color='green'>59.18 </font> 元 &nbsp&nbsp
                                    保证金:<font color='green'>  0.0 </font> 元
                                </a>
                            </li>
                        
                        <!--                             <li role="presentation" class="dropdown"> -->
                        <!--                                 <a href="javascript:;"  id="time" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"> -->
                        <!--                                 </a> -->
                        <!--                             </li> -->
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col panel-body" role="main">
            
            <div class="clearfix"></div>
    <ol class="breadcrumb">
        <li class="active">销售管理</li>
        <li>代理商品报表</li>
                </ol>
<div>
<form class="form-inline" id="userItemExportFrom" action="userItemExport.do" method="post">
    <input type="hidden" name="requesytType" id="requesytType" value="" />
    <div class="clearfix"></div>
        <div class="form-group" style="margin: 10px">
        <label for="bizId">业务类型：</label>
            <select class='form-control  input-sm' style='width: 120px'  id='bizIdList'  name='bizIdList' data-original-title=''>
            <option  selected='selected'  value=''></option>		                     <option  value='4000'>代充</option>
                                <option  value='100'>联通流量包</option>
                                <option  value='101'>电信流量包</option>
                                <option  value='102'>移动流量包</option>
                                <option  value='200'>联通话费</option>
                                <option  value='201'>移动话费</option>
                                <option  value='202'>电信话费</option>
                                <option  value='3500'>视频卡充值</option>
                </select>
    </div>
    <div class="form-group" style="margin: 10px">
        <label for="salesArea">销售区域：</label>
            <select class='form-control  input-sm' style='width: 120px'  id='salesArea'  name='salesArea' data-original-title=''>
            <option  selected='selected'  value=''></option>		                     <option  value='110000'>北京</option>
                                <option  value='120000'>天津</option>
                                <option  value='130000'>河北</option>
                                <option  value='140000'>山西</option>
                                <option  value='150000'>内蒙古</option>
                                <option  value='210000'>辽宁</option>
                                <option  value='220000'>吉林</option>
                                <option  value='230000'>黑龙江</option>
                                <option  value='310000'>上海</option>
                                <option  value='320000'>江苏</option>
                                <option  value='330000'>浙江</option>
                                <option  value='340000'>安徽</option>
                                <option  value='350000'>福建</option>
                                <option  value='360000'>江西</option>
                                <option  value='370000'>山东</option>
                                <option  value='410000'>河南</option>
                                <option  value='420000'>湖北</option>
                                <option  value='430000'>湖南</option>
                                <option  value='440000'>广东</option>
                                <option  value='450000'>广西</option>
                                <option  value='460000'>海南</option>
                                <option  value='500000'>重庆</option>
                                <option  value='510000'>四川</option>
                                <option  value='520000'>贵州</option>
                                <option  value='530000'>云南</option>
                                <option  value='540000'>西藏</option>
                                <option  value='610000'>陕西</option>
                                <option  value='620000'>甘肃</option>
                                <option  value='630000'>青海</option>
                                <option  value='640000'>宁夏</option>
                                <option  value='650000'>新疆</option>
                                <option  value='710000'>台湾</option>
                                <option  value='810000'>香港</option>
                                <option  value='820000'>澳门</option>
                </select>
    </div>

    <div class="form-group">
        <a class="btn btn-sm btn-primary" onclick="javascript:query();">查询</a>
            </div>
</form>
</div>
<div class="table-responsive">
    <table
        class="table table-bordered responsive-utilities statistic_table dataTable"
        style="margin-bottom: 0px; vertical-align: middle;">
        <thead>
            <tr>
                                <td style="width: 100px">业务类型</td> 
                <td style="width: 100px">区域</td> 
                                    <td>产品信息</td>
            </tr>
        </thead>
        <tbody>
                        <tr>
                                <td>
                电信话费
                <br/>
                漫游
                </td>
                <td>
                全国
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20165</td> 							<td style="padding: 3px;">20166</td> 							<td style="padding: 3px;">20249</td> 							<td style="padding: 3px;">20252</td> 							<td style="padding: 3px;">20316</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 							<td style="padding: 3px;">50.0元 </td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">全国电信慢充费100元</td> 							<td style="padding: 3px;">全国电信慢充费200元</td> 							<td style="padding: 3px;">全国电信快充50元</td> 							<td style="padding: 3px;">全国电信快充100元</td> 							<td style="padding: 3px;">全国电信快充200元</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">92.5元</td> 							<td style="padding: 3px;">185.0元</td> 							<td style="padding: 3px;">48.75元</td> 							<td style="padding: 3px;">97.5元</td> 							<td style="padding: 3px;">195.0元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">92.5 折(%)</td> 							<td style="padding: 3px;">92.5 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                联通流量包
                <br/>
                漫游
                </td>
                <td>
                广东
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20297</td> 							<td style="padding: 3px;">20298</td> 							<td style="padding: 3px;">20299</td> 							<td style="padding: 3px;">20300</td> 							<td style="padding: 3px;">20509</td> 							<td style="padding: 3px;">20510</td> 							<td style="padding: 3px;">20511</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">1G
                                </td> 							<td style="padding: 3px;">4G
                                </td> 							<td style="padding: 3px;">10G
                                </td> 							<td style="padding: 3px;">3G
                                </td> 							<td style="padding: 3px;">60G
                                </td> 							<td style="padding: 3px;">200G
                                </td> 							<td style="padding: 3px;">360G
                                </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">广东联通1天1G</td> 							<td style="padding: 3px;">广东联通7天4G</td> 							<td style="padding: 3px;">广东联通7天10G</td> 							<td style="padding: 3px;">广东联通3天3G</td> 							<td style="padding: 3px;">广东联通60G90天</td> 							<td style="padding: 3px;">广东联通200G180天</td> 							<td style="padding: 3px;">广东联通360G365天</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">4.35元</td> 							<td style="padding: 3px;">13.92元</td> 							<td style="padding: 3px;">26.1元</td> 							<td style="padding: 3px;">8.7元</td> 							<td style="padding: 3px;">86.13元</td> 							<td style="padding: 3px;">173.13元</td> 							<td style="padding: 3px;">260.13元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                移动流量包
                <br/>
                漫游
                </td>
                <td>
                全国
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20309</td> 							<td style="padding: 3px;">20403</td> 							<td style="padding: 3px;">20404</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">5G
                                </td> 							<td style="padding: 3px;">1G
                                </td> 							<td style="padding: 3px;">2G
                                </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">全国移动5G7天包</td> 							<td style="padding: 3px;">全国移动1G日包</td> 							<td style="padding: 3px;">全国移动2G日包</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">10.8元</td> 							<td style="padding: 3px;">3.4元</td> 							<td style="padding: 3px;">5.5元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">10.8 折(%)</td> 							<td style="padding: 3px;">3.4 折(%)</td> 							<td style="padding: 3px;">5.5 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                移动话费
                <br/>
                漫游
                </td>
                <td>
                河源
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20264</td> 							<td style="padding: 3px;">20265</td> 							<td style="padding: 3px;">20266</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">200.0元 </td> 							<td style="padding: 3px;">300.0元 </td> 							<td style="padding: 3px;">500.0元 </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">河源慢充话费200元</td> 							<td style="padding: 3px;">河源慢充话费300元</td> 							<td style="padding: 3px;">河源慢充话费500元</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">177.0元</td> 							<td style="padding: 3px;">265.5元</td> 							<td style="padding: 3px;">442.5元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="red">维护</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">88.5 折(%)</td> 							<td style="padding: 3px;">88.5 折(%)</td> 							<td style="padding: 3px;">88.5 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                移动流量包
                <br/>
                漫游
                </td>
                <td>
                广东
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20064</td> 							<td style="padding: 3px;">20067</td> 							<td style="padding: 3px;">20071</td> 							<td style="padding: 3px;">20145</td> 							<td style="padding: 3px;">20146</td> 							<td style="padding: 3px;">20147</td> 							<td style="padding: 3px;">20189</td> 							<td style="padding: 3px;">20280</td> 							<td style="padding: 3px;">20386</td> 							<td style="padding: 3px;">20387</td> 							<td style="padding: 3px;">20420</td> 							<td style="padding: 3px;">20500</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">5G
                                </td> 							<td style="padding: 3px;">1G
                                </td> 							<td style="padding: 3px;">10G
                                </td> 							<td style="padding: 3px;">1024M
                                </td> 							<td style="padding: 3px;">1G
                                </td> 							<td style="padding: 3px;">5G
                                </td> 							<td style="padding: 3px;">2G
                                </td> 							<td style="padding: 3px;">20G
                                </td> 							<td style="padding: 3px;">1G
                                </td> 							<td style="padding: 3px;">2G
                                </td> 							<td style="padding: 3px;">5G
                                </td> 							<td style="padding: 3px;">5G
                                </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">广东移动5G30天</td> 							<td style="padding: 3px;">和教育1G30天</td> 							<td style="padding: 3px;">广东和对讲10G月底清零</td> 							<td style="padding: 3px;">广东1G7天包</td> 							<td style="padding: 3px;">1天1G包</td> 							<td style="padding: 3px;">1天5G包</td> 							<td style="padding: 3px;">广东2G7天包</td> 							<td style="padding: 3px;">广东20G7天包</td> 							<td style="padding: 3px;">广东移动1G月包</td> 							<td style="padding: 3px;">广东移动2G月包</td> 							<td style="padding: 3px;">和教育5G30天</td> 							<td style="padding: 3px;">广东移动5G7天包</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">24.6元</td> 							<td style="padding: 3px;">3.6元</td> 							<td style="padding: 3px;">30.5元</td> 							<td style="padding: 3px;">4.0元</td> 							<td style="padding: 3px;">2.45元</td> 							<td style="padding: 3px;">100.0元</td> 							<td style="padding: 3px;">7.8元</td> 							<td style="padding: 3px;">21.0元</td> 							<td style="padding: 3px;">18.5元</td> 							<td style="padding: 3px;">7.5元</td> 							<td style="padding: 3px;">10.5元</td> 							<td style="padding: 3px;">12.2元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">24.6 折(%)</td> 							<td style="padding: 3px;">3.6 折(%)</td> 							<td style="padding: 3px;">30.5 折(%)</td> 							<td style="padding: 3px;">4.0 折(%)</td> 							<td style="padding: 3px;">2.45 折(%)</td> 							<td style="padding: 3px;">100.0 折(%)</td> 							<td style="padding: 3px;">7.8 折(%)</td> 							<td style="padding: 3px;">21.0 折(%)</td> 							<td style="padding: 3px;">18.5 折(%)</td> 							<td style="padding: 3px;">7.5 折(%)</td> 							<td style="padding: 3px;">10.5 折(%)</td> 							<td style="padding: 3px;">12.2 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                电信流量包
                <br/>
                漫游
                </td>
                <td>
                全国
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20091</td> 							<td style="padding: 3px;">20092</td> 							<td style="padding: 3px;">20125</td> 							<td style="padding: 3px;">20435</td> 							<td style="padding: 3px;">20436</td> 							<td style="padding: 3px;">20437</td> 							<td style="padding: 3px;">20512</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">500M
                                </td> 							<td style="padding: 3px;">2G
                                </td> 							<td style="padding: 3px;">6G
                                </td> 							<td style="padding: 3px;">5G
                                </td> 							<td style="padding: 3px;">2G
                                </td> 							<td style="padding: 3px;">3G
                                </td> 							<td style="padding: 3px;">10G
                                </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">全国电信500M月底清零</td> 							<td style="padding: 3px;">全国电信2G月底清零</td> 							<td style="padding: 3px;">全国电信6G月底清零</td> 							<td style="padding: 3px;">全国电信5G7天</td> 							<td style="padding: 3px;">全国电信2G日包</td> 							<td style="padding: 3px;">全国电信3G3天</td> 							<td style="padding: 3px;">全国电信10G5天</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">9.855元</td> 							<td style="padding: 3px;">19.71元</td> 							<td style="padding: 3px;">39.42元</td> 							<td style="padding: 3px;">21.5元</td> 							<td style="padding: 3px;">11.0元</td> 							<td style="padding: 3px;">16.2元</td> 							<td style="padding: 3px;">22.0元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">65.7 折(%)</td> 							<td style="padding: 3px;">65.7 折(%)</td> 							<td style="padding: 3px;">65.7 折(%)</td> 							<td style="padding: 3px;">21.5 折(%)</td> 							<td style="padding: 3px;">11.0 折(%)</td> 							<td style="padding: 3px;">16.2 折(%)</td> 							<td style="padding: 3px;">22.0 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                视频卡充值
                <br/>
                漫游
                </td>
                <td>
                全国
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20204</td> 							<td style="padding: 3px;">20205</td> 							<td style="padding: 3px;">20206</td> 							<td style="padding: 3px;">20207</td> 							<td style="padding: 3px;">20209</td> 							<td style="padding: 3px;">20210</td> 							<td style="padding: 3px;">20211</td> 							<td style="padding: 3px;">20213</td> 							<td style="padding: 3px;">20214</td> 							<td style="padding: 3px;">20215</td> 							<td style="padding: 3px;">20216</td> 							<td style="padding: 3px;">20217</td> 							<td style="padding: 3px;">20218</td> 							<td style="padding: 3px;">20219</td> 							<td style="padding: 3px;">20220</td> 							<td style="padding: 3px;">20223</td> 							<td style="padding: 3px;">20224</td> 							<td style="padding: 3px;">20226</td> 							<td style="padding: 3px;">20227</td> 							<td style="padding: 3px;">20228</td> 							<td style="padding: 3px;">20230</td> 							<td style="padding: 3px;">20231</td> 							<td style="padding: 3px;">20232</td> 							<td style="padding: 3px;">20233</td> 							<td style="padding: 3px;">20234</td> 							<td style="padding: 3px;">20235</td> 							<td style="padding: 3px;">20236</td> 							<td style="padding: 3px;">20237</td> 							<td style="padding: 3px;">20238</td> 							<td style="padding: 3px;">20240</td> 							<td style="padding: 3px;">20345</td> 							<td style="padding: 3px;">20346</td> 							<td style="padding: 3px;">20347</td> 							<td style="padding: 3px;">20348</td> 							<td style="padding: 3px;">20349</td> 							<td style="padding: 3px;">20350</td> 							<td style="padding: 3px;">20351</td> 							<td style="padding: 3px;">20352</td> 							<td style="padding: 3px;">20353</td> 							<td style="padding: 3px;">20354</td> 							<td style="padding: 3px;">20355</td> 							<td style="padding: 3px;">20356</td> 							<td style="padding: 3px;">20357</td> 							<td style="padding: 3px;">20358</td> 							<td style="padding: 3px;">20359</td> 							<td style="padding: 3px;">20360</td> 							<td style="padding: 3px;">20361</td> 							<td style="padding: 3px;">20362</td> 							<td style="padding: 3px;">20363</td> 							<td style="padding: 3px;">20364</td> 							<td style="padding: 3px;">20365</td> 							<td style="padding: 3px;">20366</td> 							<td style="padding: 3px;">20367</td> 							<td style="padding: 3px;">20368</td> 							<td style="padding: 3px;">20494</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">12.0元 </td> 							<td style="padding: 3px;">13.0元 </td> 							<td style="padding: 3px;">25.0元 </td> 							<td style="padding: 3px;">68.0元 </td> 							<td style="padding: 3px;">248.0元 </td> 							<td style="padding: 3px;">30.0元 </td> 							<td style="padding: 3px;">68.0元 </td> 							<td style="padding: 3px;">253.0元 </td> 							<td style="padding: 3px;">50.0元 </td> 							<td style="padding: 3px;">148.0元 </td> 							<td style="padding: 3px;">488.0元 </td> 							<td style="padding: 3px;">9.0元 </td> 							<td style="padding: 3px;">20.0元 </td> 							<td style="padding: 3px;">56.0元 </td> 							<td style="padding: 3px;">198.0元 </td> 							<td style="padding: 3px;">20.0元 </td> 							<td style="padding: 3px;">55.0元 </td> 							<td style="padding: 3px;">198.0元 </td> 							<td style="padding: 3px;">49.0元 </td> 							<td style="padding: 3px;">138.0元 </td> 							<td style="padding: 3px;">488.0元 </td> 							<td style="padding: 3px;">20.0元 </td> 							<td style="padding: 3px;">56.0元 </td> 							<td style="padding: 3px;">198.0元 </td> 							<td style="padding: 3px;">36.0元 </td> 							<td style="padding: 3px;">85.0元 </td> 							<td style="padding: 3px;">300.0元 </td> 							<td style="padding: 3px;">60.0元 </td> 							<td style="padding: 3px;">168.0元 </td> 							<td style="padding: 3px;">618.0元 </td> 							<td style="padding: 3px;">15.0元 </td> 							<td style="padding: 3px;">45.0元 </td> 							<td style="padding: 3px;">90.0元 </td> 							<td style="padding: 3px;">18.0元 </td> 							<td style="padding: 3px;">54.0元 </td> 							<td style="padding: 3px;">216.0元 </td> 							<td style="padding: 3px;">8.0元 </td> 							<td style="padding: 3px;">24.0元 </td> 							<td style="padding: 3px;">96.0元 </td> 							<td style="padding: 3px;">15.0元 </td> 							<td style="padding: 3px;">45.0元 </td> 							<td style="padding: 3px;">90.0元 </td> 							<td style="padding: 3px;">180.0元 </td> 							<td style="padding: 3px;">15.0元 </td> 							<td style="padding: 3px;">40.0元 </td> 							<td style="padding: 3px;">78.0元 </td> 							<td style="padding: 3px;">128.0元 </td> 							<td style="padding: 3px;">20.0元 </td> 							<td style="padding: 3px;">58.0元 </td> 							<td style="padding: 3px;">110.0元 </td> 							<td style="padding: 3px;">218.0元 </td> 							<td style="padding: 3px;">15.0元 </td> 							<td style="padding: 3px;">42.0元 </td> 							<td style="padding: 3px;">148.0元 </td> 							<td style="padding: 3px;">25.0元 </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">腾讯vip周卡-QQ号</td> 							<td style="padding: 3px;">爱奇艺-黄金-周卡</td> 							<td style="padding: 3px;">爱奇艺-黄金-月卡</td> 							<td style="padding: 3px;">爱奇艺-黄金-季卡</td> 							<td style="padding: 3px;">爱奇艺-黄金-年卡</td> 							<td style="padding: 3px;">腾讯vip-月卡-QQ号</td> 							<td style="padding: 3px;">腾讯vip-季卡-QQ号</td> 							<td style="padding: 3px;">腾讯vip-年卡-QQ号</td> 							<td style="padding: 3px;">腾讯云视听-月卡-QQ号</td> 							<td style="padding: 3px;">腾讯云视听-季卡-QQ号</td> 							<td style="padding: 3px;">腾讯云视听-年卡-QQ号</td> 							<td style="padding: 3px;">优酷vip-周卡</td> 							<td style="padding: 3px;">优酷vip-月卡</td> 							<td style="padding: 3px;">优酷vip-季卡</td> 							<td style="padding: 3px;">优酷vip-年卡</td> 							<td style="padding: 3px;">芒果-pc-月卡</td> 							<td style="padding: 3px;">芒果-pc-季卡</td> 							<td style="padding: 3px;">芒果-pc-年卡</td> 							<td style="padding: 3px;">芒果-全屏-月卡</td> 							<td style="padding: 3px;">芒果-全屏-季卡</td> 							<td style="padding: 3px;">芒果-全屏-年卡</td> 							<td style="padding: 3px;">搜狐-vip-月卡</td> 							<td style="padding: 3px;">搜狐-vip-季卡</td> 							<td style="padding: 3px;">搜狐-vip-年卡</td> 							<td style="padding: 3px;">搜狐-svip-月卡</td> 							<td style="padding: 3px;">搜狐-svip-季卡</td> 							<td style="padding: 3px;">搜狐-svip-年卡</td> 							<td style="padding: 3px;">爱奇艺-星钻-月卡</td> 							<td style="padding: 3px;">爱奇艺-星钻-季卡</td> 							<td style="padding: 3px;">爱奇艺-星钻-年卡</td> 							<td style="padding: 3px;">酷狗音乐豪华月卡</td> 							<td style="padding: 3px;">酷狗音乐豪华季卡</td> 							<td style="padding: 3px;">酷狗音乐豪华半年卡</td> 							<td style="padding: 3px;">网易云黑胶VIP月卡</td> 							<td style="padding: 3px;">网易云黑胶VIP季卡</td> 							<td style="padding: 3px;">网易云黑胶VIP年卡</td> 							<td style="padding: 3px;">QQ音乐付费包月卡</td> 							<td style="padding: 3px;">QQ音乐付费包季卡</td> 							<td style="padding: 3px;">QQ音乐付费包年卡</td> 							<td style="padding: 3px;">QQ音乐绿钻月卡</td> 							<td style="padding: 3px;">QQ音乐绿钻季卡</td> 							<td style="padding: 3px;">QQ音乐绿钻半年卡</td> 							<td style="padding: 3px;">QQ音乐绿钻年卡</td> 							<td style="padding: 3px;">腾讯文学QQ阅读月卡</td> 							<td style="padding: 3px;">腾讯文学QQ阅读季卡</td> 							<td style="padding: 3px;">腾讯文学QQ阅读半年卡</td> 							<td style="padding: 3px;">腾讯文学QQ阅读年卡</td> 							<td style="padding: 3px;">喜马拉雅VIP巅峰月卡</td> 							<td style="padding: 3px;">喜马拉雅VIP巅峰季卡</td> 							<td style="padding: 3px;">喜马拉雅VIP巅峰半年卡</td> 							<td style="padding: 3px;">喜马拉雅VIP巅峰年卡</td> 							<td style="padding: 3px;">懒人听书VIP月卡</td> 							<td style="padding: 3px;">懒人听书VIP季卡</td> 							<td style="padding: 3px;">懒人听书VIP年卡</td> 							<td style="padding: 3px;">哔哩哔哩大会员月卡</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">7.44元</td> 							<td style="padding: 3px;">5.85元</td> 							<td style="padding: 3px;">16.5元</td> 							<td style="padding: 3px;">44.88元</td> 							<td style="padding: 3px;">163.68元</td> 							<td style="padding: 3px;">18.6元</td> 							<td style="padding: 3px;">45.56元</td> 							<td style="padding: 3px;">151.8元</td> 							<td style="padding: 3px;">22.0元</td> 							<td style="padding: 3px;">65.12元</td> 							<td style="padding: 3px;">214.72元</td> 							<td style="padding: 3px;">5.22元</td> 							<td style="padding: 3px;">11.6元</td> 							<td style="padding: 3px;">35.28元</td> 							<td style="padding: 3px;">122.76元</td> 							<td style="padding: 3px;">10.4元</td> 							<td style="padding: 3px;">30.25元</td> 							<td style="padding: 3px;">91.08元</td> 							<td style="padding: 3px;">22.54元</td> 							<td style="padding: 3px;">63.48元</td> 							<td style="padding: 3px;">224.48元</td> 							<td style="padding: 3px;">10.8元</td> 							<td style="padding: 3px;">33.04元</td> 							<td style="padding: 3px;">106.92元</td> 							<td style="padding: 3px;">19.44元</td> 							<td style="padding: 3px;">45.9元</td> 							<td style="padding: 3px;">162.0元</td> 							<td style="padding: 3px;">25.2元</td> 							<td style="padding: 3px;">70.56元</td> 							<td style="padding: 3px;">259.56元</td> 							<td style="padding: 3px;">14.1元</td> 							<td style="padding: 3px;">42.3元</td> 							<td style="padding: 3px;">84.6元</td> 							<td style="padding: 3px;">12.06元</td> 							<td style="padding: 3px;">36.18元</td> 							<td style="padding: 3px;">144.72元</td> 							<td style="padding: 3px;">7.76元</td> 							<td style="padding: 3px;">23.28元</td> 							<td style="padding: 3px;">93.12元</td> 							<td style="padding: 3px;">13.8元</td> 							<td style="padding: 3px;">41.4元</td> 							<td style="padding: 3px;">82.8元</td> 							<td style="padding: 3px;">165.6元</td> 							<td style="padding: 3px;">12.0元</td> 							<td style="padding: 3px;">32.0元</td> 							<td style="padding: 3px;">62.4元</td> 							<td style="padding: 3px;">102.4元</td> 							<td style="padding: 3px;">10.4元</td> 							<td style="padding: 3px;">30.16元</td> 							<td style="padding: 3px;">57.2元</td> 							<td style="padding: 3px;">113.36元</td> 							<td style="padding: 3px;">11.55元</td> 							<td style="padding: 3px;">32.34元</td> 							<td style="padding: 3px;">113.96元</td> 							<td style="padding: 3px;">15.0元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">62.0 折(%)</td> 							<td style="padding: 3px;">45.0 折(%)</td> 							<td style="padding: 3px;">66.0 折(%)</td> 							<td style="padding: 3px;">66.0 折(%)</td> 							<td style="padding: 3px;">66.0 折(%)</td> 							<td style="padding: 3px;">62.0 折(%)</td> 							<td style="padding: 3px;">67.0 折(%)</td> 							<td style="padding: 3px;">60.0 折(%)</td> 							<td style="padding: 3px;">44.0 折(%)</td> 							<td style="padding: 3px;">44.0 折(%)</td> 							<td style="padding: 3px;">44.0 折(%)</td> 							<td style="padding: 3px;">58.0 折(%)</td> 							<td style="padding: 3px;">58.0 折(%)</td> 							<td style="padding: 3px;">63.0 折(%)</td> 							<td style="padding: 3px;">62.0 折(%)</td> 							<td style="padding: 3px;">52.0 折(%)</td> 							<td style="padding: 3px;">55.0 折(%)</td> 							<td style="padding: 3px;">46.0 折(%)</td> 							<td style="padding: 3px;">46.0 折(%)</td> 							<td style="padding: 3px;">46.0 折(%)</td> 							<td style="padding: 3px;">46.0 折(%)</td> 							<td style="padding: 3px;">54.0 折(%)</td> 							<td style="padding: 3px;">59.0 折(%)</td> 							<td style="padding: 3px;">54.0 折(%)</td> 							<td style="padding: 3px;">54.0 折(%)</td> 							<td style="padding: 3px;">54.0 折(%)</td> 							<td style="padding: 3px;">54.0 折(%)</td> 							<td style="padding: 3px;">42.0 折(%)</td> 							<td style="padding: 3px;">42.0 折(%)</td> 							<td style="padding: 3px;">42.0 折(%)</td> 							<td style="padding: 3px;">94.0 折(%)</td> 							<td style="padding: 3px;">94.0 折(%)</td> 							<td style="padding: 3px;">94.0 折(%)</td> 							<td style="padding: 3px;">67.0 折(%)</td> 							<td style="padding: 3px;">67.0 折(%)</td> 							<td style="padding: 3px;">67.0 折(%)</td> 							<td style="padding: 3px;">97.0 折(%)</td> 							<td style="padding: 3px;">97.0 折(%)</td> 							<td style="padding: 3px;">97.0 折(%)</td> 							<td style="padding: 3px;">92.0 折(%)</td> 							<td style="padding: 3px;">92.0 折(%)</td> 							<td style="padding: 3px;">92.0 折(%)</td> 							<td style="padding: 3px;">92.0 折(%)</td> 							<td style="padding: 3px;">80.0 折(%)</td> 							<td style="padding: 3px;">80.0 折(%)</td> 							<td style="padding: 3px;">80.0 折(%)</td> 							<td style="padding: 3px;">80.0 折(%)</td> 							<td style="padding: 3px;">52.0 折(%)</td> 							<td style="padding: 3px;">52.0 折(%)</td> 							<td style="padding: 3px;">52.0 折(%)</td> 							<td style="padding: 3px;">52.0 折(%)</td> 							<td style="padding: 3px;">77.0 折(%)</td> 							<td style="padding: 3px;">77.0 折(%)</td> 							<td style="padding: 3px;">77.0 折(%)</td> 							<td style="padding: 3px;">60.0 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                联通话费
                <br/>
                漫游
                </td>
                <td>
                全国
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20171</td> 							<td style="padding: 3px;">20172</td> 							<td style="padding: 3px;">20246</td> 							<td style="padding: 3px;">20251</td> 							<td style="padding: 3px;">20313</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 							<td style="padding: 3px;">50.0元 </td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">全国联通慢充费100元</td> 							<td style="padding: 3px;">全国联通慢充费200元</td> 							<td style="padding: 3px;">全国联通快充50元</td> 							<td style="padding: 3px;">全国联通快充100元</td> 							<td style="padding: 3px;">全国联通快充200元</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">90.0元</td> 							<td style="padding: 3px;">180.0元</td> 							<td style="padding: 3px;">48.75元</td> 							<td style="padding: 3px;">97.5元</td> 							<td style="padding: 3px;">195.0元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">90.0 折(%)</td> 							<td style="padding: 3px;">90.0 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                移动话费
                <br/>
                漫游
                </td>
                <td>
                山东
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20539</td> 							<td style="padding: 3px;">20540</td> 							<td style="padding: 3px;">20541</td> 							<td style="padding: 3px;">20542</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 							<td style="padding: 3px;">300.0元 </td> 							<td style="padding: 3px;">500.0元 </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">山东移动慢充100元</td> 							<td style="padding: 3px;">山东移动慢充200元</td> 							<td style="padding: 3px;">山东移动慢充300元</td> 							<td style="padding: 3px;">山东移动慢充500元</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">90.0元</td> 							<td style="padding: 3px;">180.0元</td> 							<td style="padding: 3px;">270.0元</td> 							<td style="padding: 3px;">450.0元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">90.0 折(%)</td> 							<td style="padding: 3px;">90.0 折(%)</td> 							<td style="padding: 3px;">90.0 折(%)</td> 							<td style="padding: 3px;">90.0 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                移动话费
                <br/>
                漫游
                </td>
                <td>
                江苏
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20531</td> 							<td style="padding: 3px;">20532</td> 							<td style="padding: 3px;">20533</td> 							<td style="padding: 3px;">20534</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 							<td style="padding: 3px;">300.0元 </td> 							<td style="padding: 3px;">500.0元 </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">江苏移动慢充费100元</td> 							<td style="padding: 3px;">江苏移动慢充费200元</td> 							<td style="padding: 3px;">江苏移动慢充费300元</td> 							<td style="padding: 3px;">江苏移动慢充费500元</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">88.0元</td> 							<td style="padding: 3px;">176.0元</td> 							<td style="padding: 3px;">264.0元</td> 							<td style="padding: 3px;">440.0元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">88.0 折(%)</td> 							<td style="padding: 3px;">88.0 折(%)</td> 							<td style="padding: 3px;">88.0 折(%)</td> 							<td style="padding: 3px;">88.0 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                联通流量包
                <br/>
                漫游
                </td>
                <td>
                全国
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20076</td> 							<td style="padding: 3px;">20077</td> 							<td style="padding: 3px;">20078</td> 							<td style="padding: 3px;">20079</td> 							<td style="padding: 3px;">20080</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">10G
                                </td> 							<td style="padding: 3px;">500M
                                </td> 							<td style="padding: 3px;">1G
                                </td> 							<td style="padding: 3px;">2G
                                </td> 							<td style="padding: 3px;">4G
                                </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">全国联通10G7天</td> 							<td style="padding: 3px;">全国联通500M日包</td> 							<td style="padding: 3px;">全国联通1G日包</td> 							<td style="padding: 3px;">全国联通2G3天</td> 							<td style="padding: 3px;">全国联通4G7天</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">28.59元</td> 							<td style="padding: 3px;">4.765元</td> 							<td style="padding: 3px;">6.671元</td> 							<td style="padding: 3px;">11.436元</td> 							<td style="padding: 3px;">15.248元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">95.3 折(%)</td> 							<td style="padding: 3px;">95.3 折(%)</td> 							<td style="padding: 3px;">95.3 折(%)</td> 							<td style="padding: 3px;">95.3 折(%)</td> 							<td style="padding: 3px;">95.3 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                移动话费
                <br/>
                漫游
                </td>
                <td>
                广东
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20104</td> 							<td style="padding: 3px;">20105</td> 							<td style="padding: 3px;">20107</td> 							<td style="padding: 3px;">20109</td> 							<td style="padding: 3px;">20113</td> 							<td style="padding: 3px;">20452</td> 							<td style="padding: 3px;">20453</td> 							<td style="padding: 3px;">20454</td> 							<td style="padding: 3px;">20514</td> 							<td style="padding: 3px;">20515</td> 							<td style="padding: 3px;">20516</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">50.0元 </td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 							<td style="padding: 3px;">300.0元 </td> 							<td style="padding: 3px;">500.0元 </td> 							<td style="padding: 3px;">31.0元 </td> 							<td style="padding: 3px;">62.0元 </td> 							<td style="padding: 3px;">93.0元 </td> 							<td style="padding: 3px;">30.0元 </td> 							<td style="padding: 3px;">60.0元 </td> 							<td style="padding: 3px;">90.0元 </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">广东移动慢充话费50元</td> 							<td style="padding: 3px;">广东移动慢充话费100元</td> 							<td style="padding: 3px;">广东移动慢充话费200元</td> 							<td style="padding: 3px;">广东移动慢充话费300元</td> 							<td style="padding: 3px;">广东移动慢充话费500元</td> 							<td style="padding: 3px;">广东特惠31元话费</td> 							<td style="padding: 3px;">广东特惠62元话费</td> 							<td style="padding: 3px;">广东特惠93元话费</td> 							<td style="padding: 3px;">慢充广东30元</td> 							<td style="padding: 3px;">慢充广东60元</td> 							<td style="padding: 3px;">慢充广东90元</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">45.25元</td> 							<td style="padding: 3px;">90.5元</td> 							<td style="padding: 3px;">181.0元</td> 							<td style="padding: 3px;">271.5元</td> 							<td style="padding: 3px;">452.5元</td> 							<td style="padding: 3px;">26.97元</td> 							<td style="padding: 3px;">53.94元</td> 							<td style="padding: 3px;">80.91元</td> 							<td style="padding: 3px;">27.0元</td> 							<td style="padding: 3px;">54.0元</td> 							<td style="padding: 3px;">81.0元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                        <td style="padding: 3px;"><font color="red">维护</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">90.5 折(%)</td> 							<td style="padding: 3px;">90.5 折(%)</td> 							<td style="padding: 3px;">90.5 折(%)</td> 							<td style="padding: 3px;">90.5 折(%)</td> 							<td style="padding: 3px;">90.5 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">87.0 折(%)</td> 							<td style="padding: 3px;">90.0 折(%)</td> 							<td style="padding: 3px;">90.0 折(%)</td> 							<td style="padding: 3px;">90.0 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                        <tr>
                                <td>
                移动话费
                <br/>
                漫游
                </td>
                <td>
                全国
                </td>
                                    <td style="padding: 5px;">
                    <table>
                        <tr>
                            <td>编号:</td> 							<td style="padding: 3px;">20177</td> 							<td style="padding: 3px;">20178</td> 							<td style="padding: 3px;">20186</td> 							<td style="padding: 3px;">20250</td> 							<td style="padding: 3px;">20310</td> 						</tr>
                        <tr>
                            <td>面值:</td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 							<td style="padding: 3px;">50.0元 </td> 							<td style="padding: 3px;">100.0元 </td> 							<td style="padding: 3px;">200.0元 </td> 						</tr>
                        <tr>
                            <td>商品名称:</td> 							<td style="padding: 3px;">全国移动慢充费100元</td> 							<td style="padding: 3px;">全国移动慢充费200元</td> 							<td style="padding: 3px;">全国移动快充50元</td> 							<td style="padding: 3px;">全国移动快充100元</td> 							<td style="padding: 3px;">全国移动快充200元</td> 						</tr>
                        <tr>
                            <td>售价:</td> 							<td style="padding: 3px;">92.0元</td> 							<td style="padding: 3px;">184.0元</td> 							<td style="padding: 3px;">48.75元</td> 							<td style="padding: 3px;">97.5元</td> 							<td style="padding: 3px;">195.0元</td> 						</tr>
                        <tr>
                            <td>状态:</td> 							<td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                        <td style="padding: 3px;"><font color="green">正常</font></td>
                                                    </tr>
                        <tr>
                            <td>折扣:</td> 							<td style="padding: 3px;">92.0 折(%)</td> 							<td style="padding: 3px;">92.0 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 							<td style="padding: 3px;">97.5 折(%)</td> 						</tr>
                    </table>
            </td>
            </tr>
                    </tbody>
    </table>
</div>
<script type="text/javascript">
    $(function() {
        $("#userId").change(function() {
            $("#userItemExportFrom").submit();
        });
        $("#bizId").change(function() {
            $("#userItemExportFrom").submit();
        });
    });
    function query() {
        jQuery('#userItemExportFrom').attr("action", "userItemExport.do");
        jQuery('#userItemExportFrom').submit();
    }
    function query2() {
        if ($("#requesytType").val() == 'group') {
            $("#requesytType").val("");
        } else {
            $("#requesytType").val("group");
        }
        jQuery('#userItemExportFrom').attr("action", "userItemExport.do");
        jQuery('#userItemExportFrom').submit();
    }
</script>

            <!-- footer content -->
            <footer>
                <div class="">
                    <p class="pull-right">
                        <span class="lead" style="font-size:15px"> <i class="fa fa-mobile-phone"
                                                                        style="margin-right: 10px"></i>	 充值平台 </span>
                    </p>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->

        </div>
        <!-- /page content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>


<!-- bootstrap progress js -->
<script src="http://br.cz500.top/assets/lib/progressbar/js/bootstrap-progressbar.min.js"></script>
<script src="http://br.cz500.top/assets/lib/nicescroll/js/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="http://br.cz500.top/assets/lib/icheck/js/icheck.min.js"></script>

<script src="http://br.cz500.top/assets/js/custom.js?v=20180927_1"></script>
<script src="http://br.cz500.top/assets/js/core.js?v=20170622"></script>
<script src="http://br.cz500.top/assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="http://br.cz500.top/assets/lib/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="http://br.cz500.top/assets/lib/datepicker/WdatePicker.js"></script>

<!-- moris js -->
<!-- 	    <script src="js/moris/raphael-min.js"></script> -->
<!-- 	    <script src="js/moris/morris.js"></script> -->
<!-- 	    <script src="js/moris/example.js"></script> -->


<script>
    $(function () {
        if () {
            setInterval(function () {
                getNews()

            }, 10000);
        }


    })

    function getNews() {
        $.ajax({
            url: "../systemNews/Deal.do?type=reload",
            type: "post",
            success: function (data) {
                if (data.status == 'success') {
                    $.each(data.module, function (n, systemNews) {
                        var title = systemNews.title;
                        var msg = systemNews.msg;
                        $.toast({
                            heading: title,
                            hideAfter: 30000,
                            text: msg,
                            icon: 'info',
                            loader: true,
                            loaderBg: 'green',
                            position: 'bottom-right',
                            stack: 20
                        });
                        for (var i = 1; i < 3; i++) {
                            $('<p></p>').notify({sticky: true});
                            $.notifySetup({sound: 'http://br.cz500.top/audio/10027.mp3'});
                        }
                    });
                }
            },
            err: function (data) {
            }
        })
    }

</script>

</body>
</html>        
STR;
        return $html;
    }
}