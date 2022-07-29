<?php

use Illuminate\Database\Seeder;
use App\Models\BillType;
use App\Models\BillCase;
use App\Models\Bill;
use App\Models\BillData;
use Illuminate\Support\Facades\Log;

class BillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillType::insert([
            [
                'type_name' => '移动',
                'type_isp' => '10086',
                'type_where' => 'huafei'
            ],
            [
                'type_name' => '电信',
                'type_isp' => '10000',
                'type_where' => 'huafei'
            ],
            [
                'type_name' => '联通',
                'type_isp' => '10010',
                'type_where' => 'huafei'
            ],
            [
                'type_name' => '会员/卡券',
                'type_isp' => 'vip',
                'type_where' => 'card_vip'
            ],
            [
                'type_name' => '移动',
                'type_isp' => '10086',
                'type_where' => 'flow'
            ],
            [
                'type_name' => '电信',
                'type_isp' => '10000',
                'type_where' => 'flow'
            ],
            [
                'type_name' => '联通',
                'type_isp' => '10010',
                'type_where' => 'flow'
            ],
        ]);
          
        $bill_cases = array(
            array('case_name' => '全国移动慢充话费','short_desc' => '全国移动慢充话费（72小时内到账，急单勿拍）','desc_content' => '<p>全国移动话费慢充介绍： <br>【充值对象】全国移动用户都可充值<br>【有效期限】话费到帐无有效期，可任意使用<br>【使用范围】可以用于扣月租、扣话费、套餐费等<br>【到账方式】可能会被拆分成30  50 100 200的面值随机到账。  <br>【到账时间】下单后72小时内到齐，急单勿拍  <br>【查询方式】官方可查，正常有短信提醒   <br>【注意事项】携号转网/虚拟运营商号码无法充值。本产品不提供发票。充错号码无法退款，请注核实号码后再下单！</p>','isp' => '10086','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '1','item_profit' => '90.5','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '移动快充（到账快）','short_desc' => '全国移动话费快充','desc_content' => '<p>【充值对象】所有用户<br>【话费性质】属于快充话费 <br>【使用范围】可以用于扣基本月租、扣话费、套餐费等, </p><p>【到帐时间】0-30分钟内到账</p><p>【查询方式】致电运营商移动10086/电信10000/联通10010可查，正常有短信提醒<br>【注意事项】携号转网/虚拟运营商号码无法充值。充错号码无法退款，请注核实号码后再下单！个别延迟则24小时内到账，本产品暂不提供发票</p><p><br></p>','isp' => '10086','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '1','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '全国电信慢充话费','short_desc' => '全国电信慢充话费（72小时内到账，急单勿拍）','desc_content' => '<p>全国电信话费慢充介绍： <br>【充值对象】全国电信用户<br>【有效期限】话费到帐无有效期，可任意使用<br>【使用范围】可以用于扣月租、扣话费、套餐费等<br>【到账方式】可能会被拆分成30  50 100 200的面值随机到账。  <br>【到账时间】下单后72小时内到齐，急单勿拍<br>【查询方式】10000官方可查，正常有短信提醒  <br>【注意事项】携号转网/虚拟运营商号码无法充值。本产品不提供发票。充错号码无法退款，请注核实号码后再下单！</p>','isp' => '10000','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '2','item_profit' => '90.5','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '电信快充（到账快）','short_desc' => '全国电信话费快充','desc_content' => '<p>【充值对象】所有用户<br>【话费性质】属于快充话费 <br>【使用范围】可以用于扣基本月租、扣话费、套餐费等, </p><p>【到帐时间】0-30分钟内到账</p><p>【查询方式】致电运营商移动10086/电信10000/联通10010可查，正常有短信提醒<br>【注意事项】携号转网/虚拟运营商号码无法充值。充错号码无法退款，请注核实号码后再下单！个别延迟则24小时内到账，本产品暂不提供发票</p><p><br></p>','isp' => '10000','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '2','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '全国联通慢充话费','short_desc' => '全国联通慢充话费（72小时内到账，急单勿拍）','desc_content' => '<p>【充值对象】所有用户<br>【话费性质】属于快充话费 <br>【使用范围】可以用于扣基本月租、扣话费、套餐费等, </p><p>【到帐时间】0-30分钟内到账</p><p>【查询方式】致电运营商移动10086/电信10000/联通10010可查，正常有短信提醒<br>【注意事项】携号转网/虚拟运营商号码无法充值。充错号码无法退款，请注核实号码后再下单！个别延迟则24小时内到账，本产品暂不提供发票</p><p><br></p>','isp' => '10010','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '3','item_profit' => '90.5','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '联通快充（到账快）','short_desc' => '全国联通话费快充','desc_content' => '<p>【充值对象】所有用户<br>【话费性质】属于快充话费 <br>【使用范围】可以用于扣基本月租、扣话费、套餐费等, </p><p>【到帐时间】0-30分钟内到账</p><p>【查询方式】致电运营商移动10086/电信10000/联通10010可查，正常有短信提醒<br>【注意事项】携号转网/虚拟运营商号码无法充值。充错号码无法退款，请注核实号码后再下单！个别延迟则24小时内到账，本产品暂不提供发票</p><p><br></p>','isp' => '10010','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '3','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '爱奇艺会员','short_desc' => '爱奇艺会员','desc_content' => '<p>{注意事项}</p><p>1.黄金VIP仅支持手机/电脑/平板使用；</p><p>星钻VIP会员可以免费观看爱奇艺超前点播剧集和星钻影院电影内容 ，支持手机/电脑/平板/电视/VR设备使用；  <br></p><p>2.下单注意核对手机号码，一旦充值成功，无法处理。</p><p>3.不支持开发票。    <br></p><p><br></p>','isp' => 'vip','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '4','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '腾讯会员','short_desc' => '腾讯会员','desc_content' => '<p>{注意事项}<br>1.黄金VIP会员仅支持手机/电脑/平板使用；<br>2.钻石VIP会员可在手机/电脑/平板使用，还可在电视端（智能电视或盒子）使用。<br>3.下单注意核对手机号码，一旦充值成功，无法处理。<br>4.不支持开发票。</p><p><br></p>','isp' => 'vip','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '4','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '芒果TV会员','short_desc' => '芒果TV会员','desc_content' => '<p>{注意事项}<br>1.黄金VIP会员仅支持手机/电脑/平板使用；<br>2.钻石VIP会员可在手机/电脑/平板使用，还可在电视端（智能电视或盒子）使用。<br>3.下单注意核对手机号码，一旦充值成功，无法处理。<br>4.不支持开发票。</p><p><br></p>','isp' => 'vip','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '4','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '优酷会员','short_desc' => '优酷会员','desc_content' => '<p>{注意事项}<br>1.优酷VIP仅支持手机/电脑/平板使用；<br>2.下单注意核对手机号码，一旦充值成功，无法处理。<br>3.不支持开发票。  <br></p><p><br></p>','isp' => 'vip','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '4','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '酷狗音乐会员豪华包','short_desc' => '酷狗音乐会员豪华包','desc_content' => '<p>{注意事项}<br>1.酷狗音乐豪华VIP的权益以酷狗音乐公示为准；<br>2.下单注意核对手机号码，一旦充值成功，无法处理。<br>3.不支持开发票。   </p><p><br></p>','isp' => 'vip','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '4','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '喜马拉雅VIP巅峰','short_desc' => '喜马拉雅VIP巅峰','desc_content' => '<p>喜马拉雅VIP巅峰</p>','isp' => 'vip','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '4','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '懒人听书VIP','short_desc' => '懒人听书VIP','desc_content' => '<p>懒人听书VIP</p>','isp' => 'vip','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '4','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '哔哩哔哩大会员','short_desc' => '哔哩哔哩大会员','desc_content' => '<p>哔哩哔哩大会员</p>','isp' => 'vip','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '4','item_profit' => '98.0','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '全国移动流量热销产品','short_desc' => '全国移动流量热销产品','desc_content' => '<p>【充值对象】：全国移动2G/3G/4G手机用户充值；<br>【有效期限】：看菜单栏；<br>【流量类型】：全国2G/3G/4G流量；<br>【使用范围】：所充值流量全国范围内使用；<br>【充值限制】：流量王、随心王和转品牌套餐不得使用；<br>【注意事项】：由于用户误填写手机号码后充入别人账号，责任用户自行承担；<br>【特殊情况】：此产品只能充值全国移动的手机号，其他省份一概不支持；<br>【到帐时间】：一般10分钟左右，最晚不超过24小时，若不到账，请24小时后联系我们；<br>【查询方式】：发送CXLL至10086查询；<br>【其他问题】：充值成功一般有短信提醒，若未收到短信可咨询10086查询流量情况（流量查询）；流量无法抵扣超出的流量及话费！</p><p><br></p>','isp' => '10086','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '5','item_profit' => '90.5','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '全国电信流量特惠包','short_desc' => '全国电信流量特惠包','desc_content' => '全国电信国内流量介绍： <br>1.【充值对象】：全国电信用户； <br>2.【流量类型】：4G、3G、2G通用网络流量； <br>3.【使用范围】：全国通用流量，全天24小时，不分时段； <br>4.【充值限制】：可无限次充值； <br>5.【注意事项】：流量充值无法进行冲正，请务必填写正确的手机号码，如填写错误损失自行负责； <br>6.【到帐时间】：一般1-10分钟到账，24小时后充值流量生效；24小时内还查不到流量到帐的或者漏充的，请联系客服处理； <br>7.【查询方式】：电信查询发送702到10001查询</p><p><br></p>','isp' => '10000','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '6','item_profit' => '90.5','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '全国电信流量','short_desc' => '全国电信流量','desc_content' => '<p>【充值对象】：仅限全国电信2G/3G/4G手机用户充值；<br>【有效期限】：月底清零；<br>【流量类型】：全国2G/3G/4G流量；<br>【使用范围】：所充值流量全国范围内使用；<br>【充值限制】：流量王、随心王和转品牌套餐不得使用；<br>【注意事项】：由于用户误填写手机号码后充入别人账号，责任用户自行承担；<br>【特殊情况】：此产品只能充值全国电信的手机号，移动联通号码一概不支持；<br>【到帐时间】：一般10分钟左右，最晚不超过24小时，若不到账，请24小时后联系我们；<br>【查询方式】：发送702至10001查询；<br>【其他问题】：充值成功一般有短信提醒，若未收到短信可咨询10001查询流量情况（流量查询）；流量无法抵扣超出的流量及话费！</p><p><br></p>','isp' => '10000','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '6','item_profit' => '90.5','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL),
            array('case_name' => '全国联通流量','short_desc' => '全国联通流量','desc_content' => '<p>【充值对象】：仅限全国联通2G/3G/4G手机用户充值；<br>【流量类型】：全国联通2G/3G/4G流量；<br>【使用范围】：所充值流量全国范围内使用；<br>【充值限制】：流量王、随心王和转品牌套餐不得使用；<br>【注意事项】：由于用户误填写手机号码后充入别人账号，责任用户自行承担；<br>【特殊情况】：此产品只能充值全国联通的手机号，移动电信一概不支持；<br>【到帐时间】：一般10分钟左右，最晚不超过24小时，若不到账，请24小时后联系我们；<br>【查询方式】：发送CXLL至10010查询；<br>【其他问题】：充值成功一般有短信提醒，若未收到短信可咨询10010查询流量情况（流量查询）；流量无法抵扣超出的流量及话费！&nbsp;&nbsp;<br></p><p><br></p>','isp' => '10010','stop_sale' => '0','stop_sale_tips' => '','bill_type_id' => '7','item_profit' => '90.5','user_can_sale' => '1','created_at' => NULL,'updated_at' => NULL)
        );
        BillCase::insert($bill_cases);
        $bills = array(
            array('package' => '50元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20176','itemProfit' => '91','itemFacePrice' => '50000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '1','created_at' => NULL,'updated_at' => NULL),
            array('package' => '100元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20177','itemProfit' => '91','itemFacePrice' => '100000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '1','created_at' => NULL,'updated_at' => NULL),
            array('package' => '200元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20178','itemProfit' => '91','itemFacePrice' => '200000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '1','created_at' => NULL,'updated_at' => NULL),
            array('package' => '300元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20179','itemProfit' => '91','itemFacePrice' => '300000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '1','created_at' => NULL,'updated_at' => NULL),
            array('package' => '500元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20130','itemProfit' => '91','itemFacePrice' => '500000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '1','created_at' => NULL,'updated_at' => NULL),
            array('package' => '30元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20185','itemProfit' => '91','itemFacePrice' => '30000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '2','created_at' => NULL,'updated_at' => NULL),
            array('package' => '50元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20186','itemProfit' => '91','itemFacePrice' => '50000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '2','created_at' => NULL,'updated_at' => NULL),
            array('package' => '100元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20250','itemProfit' => '91','itemFacePrice' => '100000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '2','created_at' => NULL,'updated_at' => NULL),
            array('package' => '200元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20310','itemProfit' => '91','itemFacePrice' => '200000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '2','created_at' => NULL,'updated_at' => NULL),
            array('package' => '50元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20164','itemProfit' => '91','itemFacePrice' => '50000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '3','created_at' => NULL,'updated_at' => NULL),
            array('package' => '100元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20165','itemProfit' => '91','itemFacePrice' => '100000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '3','created_at' => NULL,'updated_at' => NULL),
            array('package' => '200元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20166','itemProfit' => '91','itemFacePrice' => '200000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '3','created_at' => NULL,'updated_at' => NULL),
            array('package' => '300元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20167','itemProfit' => '91','itemFacePrice' => '300000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '3','created_at' => NULL,'updated_at' => NULL),
            array('package' => '500元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20168','itemProfit' => '91','itemFacePrice' => '500000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '3','created_at' => NULL,'updated_at' => NULL),
            array('package' => '30元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20248','itemProfit' => '91','itemFacePrice' => '30000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '4','created_at' => NULL,'updated_at' => NULL),
            array('package' => '50元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20249','itemProfit' => '91','itemFacePrice' => '50000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '4','created_at' => NULL,'updated_at' => NULL),
            array('package' => '100元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20252','itemProfit' => '91','itemFacePrice' => '100000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '4','created_at' => NULL,'updated_at' => NULL),
            array('package' => '200元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20316','itemProfit' => '91','itemFacePrice' => '200000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '4','created_at' => NULL,'updated_at' => NULL),
            array('package' => '50元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20170','itemProfit' => '91','itemFacePrice' => '50000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '5','created_at' => NULL,'updated_at' => NULL),
            array('package' => '100元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20171','itemProfit' => '91','itemFacePrice' => '100000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '5','created_at' => NULL,'updated_at' => NULL),
            array('package' => '200元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20172','itemProfit' => '91','itemFacePrice' => '200000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '5','created_at' => NULL,'updated_at' => NULL),
            array('package' => '300元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20173','itemProfit' => '91','itemFacePrice' => '300000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '5','created_at' => NULL,'updated_at' => NULL),
            array('package' => '500元','is_hot' => '1','order_tips' => '[温馨提示：72小时内到账，停机欠费可以充值]','yh_tips' => '72小时内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20174','itemProfit' => '91','itemFacePrice' => '500000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '5','created_at' => NULL,'updated_at' => NULL),
            array('package' => '30元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20245','itemProfit' => '91','itemFacePrice' => '30000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '6','created_at' => NULL,'updated_at' => NULL),
            array('package' => '50元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20246','itemProfit' => '91','itemFacePrice' => '50000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '6','created_at' => NULL,'updated_at' => NULL),
            array('package' => '100元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20251','itemProfit' => '91','itemFacePrice' => '100000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '6','created_at' => NULL,'updated_at' => NULL),
            array('package' => '200元','is_hot' => '1','order_tips' => '[温馨提示：30分钟内到账，停机欠费可以充值]','yh_tips' => '30分钟内到账','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20313','itemProfit' => '91','itemFacePrice' => '200000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '6','created_at' => NULL,'updated_at' => NULL),
            array('package' => '爱奇艺周卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20205','itemProfit' => '91','itemFacePrice' => '13000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '7','created_at' => NULL,'updated_at' => NULL),
            array('package' => '爱奇艺月卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20206','itemProfit' => '91','itemFacePrice' => '25000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '7','created_at' => NULL,'updated_at' => NULL),
            array('package' => '爱奇艺季卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20207','itemProfit' => '91','itemFacePrice' => '68000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '7','created_at' => NULL,'updated_at' => NULL),
            array('package' => '爱奇艺年卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20209','itemProfit' => '91','itemFacePrice' => '248000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '7','created_at' => NULL,'updated_at' => NULL),
            array('package' => '爱奇艺月卡','is_hot' => '1','order_tips' => '','yh_tips' => '星钻VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20237','itemProfit' => '91','itemFacePrice' => '60000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '7','created_at' => NULL,'updated_at' => NULL),
            array('package' => '爱奇艺季卡','is_hot' => '1','order_tips' => '','yh_tips' => '星钻VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20238','itemProfit' => '91','itemFacePrice' => '168000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '7','created_at' => NULL,'updated_at' => NULL),
            array('package' => '爱奇艺年卡','is_hot' => '1','order_tips' => '','yh_tips' => '星钻VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20240','itemProfit' => '91','itemFacePrice' => '618000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '7','created_at' => NULL,'updated_at' => NULL),
            array('package' => '腾讯周卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20204','itemProfit' => '91','itemFacePrice' => '12000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '8','created_at' => NULL,'updated_at' => NULL),
            array('package' => '腾讯月卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20210','itemProfit' => '91','itemFacePrice' => '30000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '8','created_at' => NULL,'updated_at' => NULL),
            array('package' => '腾讯季卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20211','itemProfit' => '91','itemFacePrice' => '68000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '8','created_at' => NULL,'updated_at' => NULL),
            array('package' => '腾讯年卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20213','itemProfit' => '91','itemFacePrice' => '253000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '8','created_at' => NULL,'updated_at' => NULL),
            array('package' => '腾讯月卡','is_hot' => '1','order_tips' => '','yh_tips' => '钻石VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20214','itemProfit' => '91','itemFacePrice' => '50000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '8','created_at' => NULL,'updated_at' => NULL),
            array('package' => '腾讯季卡','is_hot' => '1','order_tips' => '','yh_tips' => '钻石VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20215','itemProfit' => '91','itemFacePrice' => '148000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '8','created_at' => NULL,'updated_at' => NULL),
            array('package' => '腾讯年卡','is_hot' => '1','order_tips' => '','yh_tips' => '钻石VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20216','itemProfit' => '91','itemFacePrice' => '488000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '8','created_at' => NULL,'updated_at' => NULL),
            array('package' => '芒果月卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20223','itemProfit' => '91','itemFacePrice' => '20000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '9','created_at' => NULL,'updated_at' => NULL),
            array('package' => '芒果季卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20224','itemProfit' => '91','itemFacePrice' => '55000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '9','created_at' => NULL,'updated_at' => NULL),
            array('package' => '芒果年卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20226','itemProfit' => '91','itemFacePrice' => '198000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '9','created_at' => NULL,'updated_at' => NULL),
            array('package' => '芒果月卡','is_hot' => '1','order_tips' => '','yh_tips' => '钻石VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20227','itemProfit' => '91','itemFacePrice' => '49000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '9','created_at' => NULL,'updated_at' => NULL),
            array('package' => '芒果季卡','is_hot' => '1','order_tips' => '','yh_tips' => '钻石VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20228','itemProfit' => '91','itemFacePrice' => '138000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '9','created_at' => NULL,'updated_at' => NULL),
            array('package' => '芒果年卡','is_hot' => '1','order_tips' => '','yh_tips' => '钻石VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20230','itemProfit' => '91','itemFacePrice' => '448000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '9','created_at' => NULL,'updated_at' => NULL),
            array('package' => '优酷周卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20217','itemProfit' => '91','itemFacePrice' => '9000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '10','created_at' => NULL,'updated_at' => NULL),
            array('package' => '优酷月卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20218','itemProfit' => '91','itemFacePrice' => '20000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '10','created_at' => NULL,'updated_at' => NULL),
            array('package' => '优酷季卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20219','itemProfit' => '91','itemFacePrice' => '56000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '10','created_at' => NULL,'updated_at' => NULL),
            array('package' => '优酷年卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20220','itemProfit' => '91','itemFacePrice' => '198000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '10','created_at' => NULL,'updated_at' => NULL),
            array('package' => '酷狗音乐月卡','is_hot' => '1','order_tips' => '','yh_tips' => '豪华VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20345','itemProfit' => '91','itemFacePrice' => '15000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '11','created_at' => NULL,'updated_at' => NULL),
            array('package' => '酷狗音乐季卡','is_hot' => '1','order_tips' => '','yh_tips' => '豪华VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20346','itemProfit' => '91','itemFacePrice' => '45000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '11','created_at' => NULL,'updated_at' => NULL),
            array('package' => '酷狗音乐半年卡','is_hot' => '1','order_tips' => '','yh_tips' => '豪华VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20347','itemProfit' => '91','itemFacePrice' => '90000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '11','created_at' => NULL,'updated_at' => NULL),
            array('package' => '喜马拉雅月卡','is_hot' => '1','order_tips' => '','yh_tips' => '巅峰VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20362','itemProfit' => '91','itemFacePrice' => '20000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '12','created_at' => NULL,'updated_at' => NULL),
            array('package' => '喜马拉雅季卡','is_hot' => '1','order_tips' => '','yh_tips' => '巅峰VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20363','itemProfit' => '91','itemFacePrice' => '58000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '12','created_at' => NULL,'updated_at' => NULL),
            array('package' => '喜马拉雅半年卡','is_hot' => '1','order_tips' => '','yh_tips' => '巅峰VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20364','itemProfit' => '91','itemFacePrice' => '110000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '12','created_at' => NULL,'updated_at' => NULL),
            array('package' => '喜马拉雅年卡','is_hot' => '1','order_tips' => '','yh_tips' => '巅峰VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20365','itemProfit' => '91','itemFacePrice' => '218000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '12','created_at' => NULL,'updated_at' => NULL),
            array('package' => '懒人听书月卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20366','itemProfit' => '91','itemFacePrice' => '15000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '13','created_at' => NULL,'updated_at' => NULL),
            array('package' => '懒人听书季卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20367','itemProfit' => '91','itemFacePrice' => '42000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '13','created_at' => NULL,'updated_at' => NULL),
            array('package' => '懒人听书年卡','is_hot' => '1','order_tips' => '','yh_tips' => '黄金VIP','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20368','itemProfit' => '91','itemFacePrice' => '148000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '13','created_at' => NULL,'updated_at' => NULL),
            array('package' => '哔哩哔哩','is_hot' => '1','order_tips' => '','yh_tips' => '大会员','stop_sale' => '0','stop_sale_tips' => '','itemId' => '20494','itemProfit' => '91','itemFacePrice' => '25000','app_profit' => '20','user_can_sale' => '1','user_profit' => '15','user_app_profit' => '25','bill_case_id' => '14','created_at' => NULL,'updated_at' => NULL),
            array('package' => '1G日包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '24小时有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20403','itemProfit' => '3.4','itemFacePrice' => '100000','app_profit' => '1','user_can_sale' => '1','user_profit' => '1','user_app_profit' => '25','bill_case_id' => '15','created_at' => NULL,'updated_at' => '2021-05-25 16:15:52'),
            array('package' => '2G日包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '24小时有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20404','itemProfit' => '5.5','itemFacePrice' => '100000','app_profit' => '1','user_can_sale' => '1','user_profit' => '1','user_app_profit' => '25','bill_case_id' => '15','created_at' => '2021-05-25 15:27:31','updated_at' => '2021-05-25 16:16:14'),
            array('package' => '5G7天包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '7天有效期','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20309','itemProfit' => '10.8','itemFacePrice' => '100000','app_profit' => '1','user_can_sale' => '1','user_profit' => '1','user_app_profit' => '25','bill_case_id' => '15','created_at' => '2021-05-25 15:29:21','updated_at' => '2021-05-25 15:30:50'),
            array('package' => '500M日包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '24小时有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20077','itemProfit' => '95.3','itemFacePrice' => '5000','app_profit' => '80','user_can_sale' => '1','user_profit' => '80','user_app_profit' => '25','bill_case_id' => '18','created_at' => '2021-05-25 15:34:56','updated_at' => '2021-05-25 15:36:16'),
            array('package' => '1G日包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '24小时有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20078','itemProfit' => '95.3','itemFacePrice' => '7000','app_profit' => '20','user_can_sale' => '1','user_profit' => '20','user_app_profit' => '25','bill_case_id' => '18','created_at' => '2021-05-25 15:39:30','updated_at' => '2021-05-25 15:39:30'),
            array('package' => '2G3天包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '3天内有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20079','itemProfit' => '95.3','itemFacePrice' => '12000','app_profit' => '20','user_can_sale' => '1','user_profit' => '20','user_app_profit' => '25','bill_case_id' => '18','created_at' => '2021-05-25 15:41:20','updated_at' => '2021-05-25 15:45:17'),
            array('package' => '4G7天包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '7天内有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20080','itemProfit' => '95.3','itemFacePrice' => '16000','app_profit' => '20','user_can_sale' => '1','user_profit' => '20','user_app_profit' => '25','bill_case_id' => '18','created_at' => '2021-05-25 15:43:13','updated_at' => '2021-05-25 15:45:22'),
            array('package' => '10G7天包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '7天内有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20076','itemProfit' => '95.3','itemFacePrice' => '30000','app_profit' => '20','user_can_sale' => '1','user_profit' => '20','user_app_profit' => '25','bill_case_id' => '18','created_at' => '2021-05-25 15:45:09','updated_at' => '2021-05-25 16:21:40'),
            array('package' => '2G日包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '24小时有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20436','itemProfit' => '11','itemFacePrice' => '100000','app_profit' => '1','user_can_sale' => '1','user_profit' => '1','user_app_profit' => '25','bill_case_id' => '16','created_at' => '2021-05-25 16:01:24','updated_at' => '2021-05-25 16:20:17'),
            array('package' => '3G日包','is_hot' => '1','order_tips' => NULL,'yh_tips' => '24小时有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20437','itemProfit' => '16.2','itemFacePrice' => '100000','app_profit' => '1','user_can_sale' => '1','user_profit' => '1','user_app_profit' => '25','bill_case_id' => '16','created_at' => '2021-05-25 16:02:17','updated_at' => '2021-05-25 16:02:17'),
            array('package' => '5G7天','is_hot' => '1','order_tips' => NULL,'yh_tips' => '7天内有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20435','itemProfit' => '21.5','itemFacePrice' => '100000','app_profit' => '1','user_can_sale' => '1','user_profit' => '1','user_app_profit' => '25','bill_case_id' => '16','created_at' => '2021-05-25 16:04:15','updated_at' => '2021-05-25 16:04:15'),
            array('package' => '10G5天','is_hot' => '1','order_tips' => NULL,'yh_tips' => '5天内有效','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20512','itemProfit' => '22','itemFacePrice' => '100000','app_profit' => '1','user_can_sale' => '1','user_profit' => '1','user_app_profit' => '25','bill_case_id' => '16','created_at' => '2021-05-25 16:05:12','updated_at' => '2021-05-25 16:05:12'),
            array('package' => '500M月底清零','is_hot' => '1','order_tips' => NULL,'yh_tips' => '一个月','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20091','itemProfit' => '65.7','itemFacePrice' => '15000','app_profit' => '2','user_can_sale' => '1','user_profit' => '2','user_app_profit' => '25','bill_case_id' => '17','created_at' => '2021-05-25 16:05:46','updated_at' => '2021-05-25 16:18:40'),
            array('package' => '2G月底清零','is_hot' => '1','order_tips' => NULL,'yh_tips' => '一个月','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20092','itemProfit' => '65.7','itemFacePrice' => '30000','app_profit' => '2','user_can_sale' => '1','user_profit' => '2','user_app_profit' => '25','bill_case_id' => '17','created_at' => '2021-05-25 16:10:32','updated_at' => '2021-05-25 16:12:53'),
            array('package' => '6G月底清零','is_hot' => '1','order_tips' => NULL,'yh_tips' => '一个月','stop_sale' => '0','stop_sale_tips' => NULL,'itemId' => '20093','itemProfit' => '65.7','itemFacePrice' => '60000','app_profit' => '2','user_can_sale' => '1','user_profit' => '2','user_app_profit' => '25','bill_case_id' => '17','created_at' => '2021-05-25 16:12:32','updated_at' => '2021-05-25 16:12:32')
          );
        Bill::insert($bills);

        //设置sell_data
        $billTypeList = BillType::all();
        $billCaseList = BillCase::all();
        $billList = Bill::with(['sell_data'])->get();
        foreach($billList as $data){
            $id = $data->id;
            $sell_data = $this->getOtherData($data);
            $sell_data['bill_id'] = $id;
            BillData::create($sell_data);
        }
    }

    private function getOtherData($value){
            // $value = (object) $value;
            $sell_data = $value->sell_data = (object) [];
            //商品面值
            $sell_data = $value->sell_data = (object) [];
            $facePrice = floatval(bcdiv($value->itemFacePrice , 1000, 2));
            $sell_data->facePrice = $facePrice;
            //商品折扣率
            $bill_profit = $value->itemProfit;
            if($bill_profit == -1){
                $bill_profit = BillCase::find($value->bill_case_id)->first()->item_profit;
            }
            $bill_profit = floatval(bcdiv($bill_profit , 100, 2));
            //进货价
            $sell_data->itemSalePrice = floatval(bcmul($facePrice,$bill_profit,2));
            //剩余利润 
            $sell_data->itemFreePrice = floatval(bcsub($facePrice , $sell_data->itemSalePrice,2));
            //平台利润率
            $app_profit_later = $value->app_profit;
            if($value->app_profit == -1){
                $app_profit_later = Setting::where('key','app_profit')->first()->app_profit;
            }
            $app_profit_later = floatval(bcdiv($app_profit_later , 100, 2));
            //平台出售利润
            $sell_data->AppFreePrice = floatval(bcmul($sell_data->itemFreePrice , $app_profit_later,2));
            //平台出售价
            $sell_data->AppSalePrice = floatval(bcadd($sell_data->AppFreePrice , $sell_data->itemSalePrice,2));

            //分销者利润率
            $user_profit_later = $value->user_profit;
            if($value->user_profit == -1){
                $user_profit_later = Setting::where('key','user_profit')->first()->user_profit;
            }
            $user_profit_later = floatval(bcdiv($user_profit_later , 100, 2));
            //分销剩余利润
            $ProfixFreePrice = $sell_data->ProfixFreePrice = floatval(bcmul($sell_data->itemFreePrice , $user_profit_later,2));
            // dd($ProfixFreePrice);
            //分销者出售平台利润率
            $user_app_profit_later = $value->user_app_profit;
            if($value->user_app_profit == -1){
                $user_app_profit_later = Setting::where('key','user_app_profit')->first()->user_app_profit;
            }
            $user_app_profit_later = floatval(bcdiv($user_app_profit_later , 100, 2));
            
            //分销者出售平台利润
            $sell_data->UserAppFreePrice = floatval(bcmul($ProfixFreePrice , $user_app_profit_later,2));
            
            //分销者利润
            $sell_data->UserFreePrice = floatval(bcsub($ProfixFreePrice , $sell_data->UserAppFreePrice,2));
            //分销者出售价
            $sell_data->UserSalePrice = floatval(bcadd($sell_data->ProfixFreePrice , $sell_data->itemSalePrice,2));
        return (array) $sell_data;
    }
}
