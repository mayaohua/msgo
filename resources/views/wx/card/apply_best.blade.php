@extends('layouts.card')
@section('head')
<title>靓号申请-星耀互联</title>
<style>
        *{
        margin:0;
        padding:0;
    }
    #container{
        background:#f7f7f7;
        
    }
    .container *{
        font-size :.875rem;
    }
    .card .card_title{
        color: #6e6e6e;
        font-size: 14px;
        line-height: 1.5625rem;
        padding: 0.625rem 1.125rem;
        margin: 0;
        border-bottom: 1PX solid #f1f1f1;
    }
    .card .card_content{
        
    }
    .card_item{
        padding-left: 1.125rem;
        line-height: 2.875rem;
        background-color: #fff;
        font-size: 0.8125rem;
    }
    .p-title{
        width: 3.75rem;
        float: left;
    }
    .p-content{
        padding-left: 5.625rem;
        padding-right: 1.125rem;
        position: relative;
        height: 2.875rem;
    }
    .red_text{
        color:#ff1414;
    }
    .blue_text{
        color:#1e96fa;
    }
    .phone-wrap{
		position: fixed;
		width: 100%;
		height: 100%;
		top:0;
		left: 0;
		bottom: 0;
		right: 0;
		background: rgba(0,0,0,0.5);
		z-index: 1;
		display: flex;
		align-items: center;
		flex-direction: column;
		justify-content: center;
	}
	.phone-content{
		width: 94%; 
		height: 18.75rem;
		background: white;
		padding: 0 auto;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
        border-radius: 5px;
	}
	.phone-wrap .number-icon{
		margin-top: 1.25rem;
	}
	
	.phone-items{
		flex: 1;
		margin: .5rem 0;
		overflow: hidden;
        text-align:center;
	}
	.phone-wrap .phone-items .phone-item{
		width: 50%;
		text-align: center;
		font-size: 1.25rem;
        float: left;
        margin: 5px 0;
	}
    .phone-item img{
        width:15px;
        height:15px;
    }
	.phone-content .phone-change{
		text-align: center;
		color: #007AFF;
		padding: 0.8rem 0;
		border-top: .0625rem solid #dfdfdf;
	}
    .van-search{
            padding: 10px 12px 0;
            border-radius: 5px!important;
    }
    .cell-div{
        width: 100%;
        padding: 10px 16px;
        overflow: hidden;
        color: #323233;
        font-size: 14px;
        line-height: 24px;
        background-color: #fff;
        box-sizing: border-box;
    }
    .privacy {
        font-size: 0.75rem;
        text-align: center;
        color: #adadad;
        line-height: 0.9375rem;
        -moz-transform: scale(0.75, 0.75);
        -ms-transform: scale(0.75, 0.75);
        -webkit-transform: scale(0.75, 0.75);
        transform: scale(0.75, 0.75);
        white-space: nowrap;
        width:100%;
        padding-bottom: 8px;
    }
    .van-checkbox__label{
        color:rgb(150, 151, 153);
    }
    .fristM span{
        width: 6.8rem;
        text-align: center;
        display: inline-block;
        background-color: #f6f5f5;
        border-radius: 3px;
        height: 2rem;
        line-height: 2rem;
        border: 1px solid transparent;
        box-sizing: border-box;
        margin :0 .5rem .625rem 0 ;
        border: 1px solid #f6f5f5;
    }
    .fristM span.selected{
        background: #e7f2fb;
        border: 1px solid #8ec9fa;
    }
    .success-bg{
        background:rgba(255,255,255,0.9);
        position:fixed;
        top:0;
        bottom:0;
        left:0;
        right:0;
        z-index:999;

    }
    .success-bg>div{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        width: 100vw;
    }
    .ddf{
        width:70px;
        display:inline-block;
    }
</style>
@endsection
@section('content')
<div id="container" id="container">
    <div class="card">
        {{-- <div class="card_title">号码信息</div> --}}
        <div class="card_content cell-div" style="font-size: 16px;">
            <p><span class='ddf'>已选择</span><span class="red_text">@{{otherinfo.number}}</span></p>
            <p style="margin:5px 0"><span  class='ddf'>归属地：</span><span class="blue_text">@{{otherinfo.provinceName+otherinfo.cityName}}</span></p>
            <p><span  class='ddf'>套餐：</span> <span class="blue_text">@{{otherinfo.card_name}}</span></p>
        </div>
    </div>
    <div class="card" v-if="cardinfo.text_short_desc || cardinfo.img_short_desc">
        <div class="card_title">套餐介绍</div>
        <div class="card_content cell-div">
            <div v-if="cardinfo.text_short_desc" class="red_text">@{{cardinfo.text_short_desc}}</div>
            <div v-if="cardinfo.img_short_desc" style='width:100%;margin:10px 0;'>
                <img :src="cardinfo.img_short_desc" style="width:100%"/>
            </div>
        </div>
    </div>
    <div class="card" v-if="has_value('firstMonthFee')">
        <div class="card_title">套餐选择</div>
        <div class="card_content">
            <div class="van-cell van-field">
                <div class="van-cell__title van-field__label" style="width:4.2rem;">
                    <span>首月资费</span>
                </div>
                <div class="van-cell__value van-field__value">
                    <div class="van-field__body">
                        <div class="van-field__control fristM">
                            <span @click="numberData.firstMonthFee=item.attrValCode;attrValDesc=item.attrValDesc" v-for="item in cardinfo.card_other_datas.firstMonthFee" :class="{'selected':numberData.firstMonthFee == item.attrValCode}">@{{item.attrValName}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="van-cell van-field">
                <div class="van-cell__title van-field__label"  style="width:4.2rem;">
                    <span>资费说明</span>
                </div>
                <div class="van-cell__value van-field__value">
                    <div class="van-field__body">
                        <div class="van-field__control" style="color:#999">
                            @{{attrValDesc}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <van-form @submit="onSubmit" validate-trigger="onSubmit" ref="myFrom" validate-first  error-message-align="left" :show-error="false">
        <div class="card">
            <div class="card_title">根据国家实名制要求, 请准确提供身份证信息</div>
            <div class="card_content">
                <van-field
                    v-model="userData.username"
                    name="userData.username"
                    label="姓名"
                    placeholder="请输入身份证姓名"
                    center
                    clearable
                    :rules="[{ required: true,trigger:'onBlur', message: '姓名不能为空' }
                    ]" >
                </van-field>
                <van-field
                    v-model="userData.usercode"
                    name="userData.usercode"
                    label="身份证号"
                    placeholder="请输入身份证号"
                    center
                    clearable
                    :rules="[{ required: true,trigger:'onBlur', message: '身份证号不能为空' },
                    { validator: idcardCheck,trigger:'onBlur', message: '身份证号不正确' }]" >
                </van-field>
                <van-field
                    v-model="userData.userphone"
                    name="userData.userphone"
                    label="联系电话"
                    placeholder="请输入联系电话"
                    center
                    clearable
                    maxlength="11"
                    type="number"
                    :rules="[{ required: true, message: '电话号码不能为空' },
                    { pattern:/^1[3|4|5|6|7|8|9]\d{9}$/, message: '电话号码不正确' }]" >
                </van-field>
                <van-field
                    v-model="userData.captcha"
                    name="userData.captcha"
                    label="验证码"
                    v-if="otherinfo.mobile_from!='dsf'"
                    placeholder="请输入验证码"
                    type="number"
                    center
                    clearable
                    :rules="[{ required: true, message: '验证码不能为空' }]" >
                    <template #button>
                        <van-button native-type="button" 
                        :disabled="captcha.disabled" 
                        :style="{'background':captcha.disabled?'#c5c5c5':'#1e96fa','border': captcha.disabled?'.0625rem solid #c5c5c5':'.0625rem solid #1e96fa'}"
                        class="send_code"
                        @click.stop="sendCaptcha" size="small" type="info">@{{captcha.disabled ? captcha.time+' 秒后获取':'获取验证码'}}</van-button>
                    </template>
                </van-field>
            </div>
        </div>
        <div class="card">
            <div class="card_title">配送地址<span class="red_text">(支持全国配送，新疆、西藏仅限省内配送)</span></div>
            <div class="card_content">
                <van-field
                    v-model="twonData.fieldValue"
                    name="twonData.fieldValue"
                    is-link
                    readonly
                    label="所在地区"
                    placeholder="请选择省/市/区"
                    @click="showTwon"
                    :rules="[{ required: true, message: '所在地区不能为空' }]"
                >
                </van-field>
                <van-field v-model="userData.address"
                rows="1"
                autosize
                 type="textarea" label="" placeholder="街道/镇+村/小区/写字楼+门牌号" 
                 :rules="[{ required: true, message: '地址不能为空' }]"
                 >
                </van-field>
            </div>
        </div>
        <div class="cell-div" style="margin-top:10px;">
            <van-checkbox style="font-size:12px;margin:10px 0 20px;color:#969799;" v-model="checked" shape="square">我已阅读并同意 
                <span class="blue_text" @click.stop="readXieyi" data-title="信息使用公告" data-desc="尊敬的客户：<br/>根据《中华人民共和国反恐怖主义法》、《全国人民代表大会常务委员会关于加强网络信息保护的决定》、《电信和互联网用户个人信息保护规定》（工业和信息化部令第24号）和《电话用户真实身份信息登记规定》（工业和信息化部令第25号）等国家法律法规的要求，客户在中国联合网络通信有限公司各类营业网点（含自有营业厅、手机营业厅、网上营业厅、授权合作代理商等）办理固定电话、移动电话（含无线上网卡）入网、过户以及需要出示客户证件的有关业务时，客户应配合出示有效证件原件并进行查验、登记，登记信息包括姓名、证件类型、号码及地址等。同时，为更好地提供服务，需要客户提供如联系人、联系电话、通信地址、电子邮箱等信息。客户本人持有效证件可通过自有营业厅查询和/或更正本人信息，或登录手机营业厅查询本人信息。<br/>如客户拒绝依法提供个人有效证件及真实信息，我公司有权不提供服务或终止服务。<br/>为向客户提供优质、个性化的服务，包括但不限于提供通信服务、保障通信服务安全、改善服务质量、推介个性化产品等，我公司将遵循合法、正当、必要的原则，按照法律法规规定和/或协议约定使用留存客户个人信息，并妥善保管，严格保密，依法保护客户个人信息，非因下列事由，不对外泄露客户个人信息：<br/>(a)事先获得客户的明确授权；<br/>(b)根据有关的法律法规要求；<br/>(c)按照相关司法机关和/或政府主管部门的要求；<br/>(d)为维护社会公众的利益所必需且适当；<br/>(e)为维护我公司或客户的合法权益所必需且适当。<br/>中国联合网络通信有限公司" >《信息使用公告》</span>
                <span class="blue_text" @click.stop="readXieyi" data-title="入网协议"  data-desc="甲方与乙方经自愿协商一致，就电信服务的相关事宜达成如下协议：<br/>一、 服务内容<br/>1. 甲方自主选择乙方提供的电信服务，乙方在通信网络覆盖范围内，按照国家颃布的 《电信服务规范》标准为甲方有偿提供其所选择的电信服务。<br/>2. 电信服务费用根据政府主管部门批准或备案的资费标准及双方的约定执行。计费周 期为自然月，即每月1日0时至当月最后一曰24时。<br/>3. 乙方提供标准资费及各类套餐资费供甲方使用。如选择套餐资费，月通信消费量未超过套餐约定包含的内容及使用量时收取套餐基本费；月通信消费量超出套餐约定包含的内容或使用量时收取套餐基本费及超出费用。<br/>二、 甲方的权利与义务<br/>1. 甲方有权自主选择乙方提供的各类电信服务，有权选择符合国家入网许可规定的终端设备，并在双方约定的电信服务范围内使用。<br/>2. 甲方或其委托人办理电信业务时，应提供真实有效的信息资料，并配合乙方进行核实；对身份不明或拒绝身份查验的，乙方有权拒绝提供服务。协议有效期内，甲方登记资料如有变更，应及时办理变更手续。<br/>3. 甲方应按照与乙方约定的时间和方式，及时足额向乙方支付电信服务费用，否则乙方有权停止电信服务。<br/>4. 甲方可对暂不使用的电信服务申谓停机，若为套餐资费应将套餐中包含的所有电信服务同时停机。<br/>5. 甲方负责其自备的终端设备或线路的安装与维修。乙方可协助甲方安装或维修， 按服务标准收取费用。<br/>6. 甲方使用电信服务时，应遵守国家法律、法规。<br/>7. 甲方应对其使用的电信业务终端妥善保管，因甲方使用不当而造成的损失，由甲方自行承担；甲方电信业务终端丟失，应及时办理停机手续，办理停机前产生的损失由甲方承担。<br/>8. 甲方入网后应立即修改初始产品密码，并注意保管。凡使用甲方产品密码定制、变更电信业务的行为均视为甲方行为，责任由甲方承担。<br/>三、 乙方的权利与义务<br/>1. 乙方应积极、努力的为甲方提供优质的电信服务。<br/>2. 乙方应向甲方提供业务受理、咨询、查询、障碍申告、投诉等服务渠道。<br/>3. 乙方应在双方约定的期限内为甲方开通其所申请的电信服务业务，若因客观原因无法为甲方开通的，应及时通知甲方。<br/>4. 乙方按约定的资费标准向甲方收取电信服务费用，并可代收甲方定制的第三方收费业务之费用。<br/>5. 乙方应保留甲方的电信服务费用信息5个月，以备甲方查询。<br/>6. 乙方对甲方办理、使用电信业务产生的各类信息资料依法保密；但为建立与甲方沟通渠道，改善服务工作，乙方可以使用本协议涉及的甲方资料。<br/>7. 乙方保留因技术进步或国家法律法规、政策变动等原因对电信业务的服务功能、操作方法、业务号码等做出调整的权利，但调整时应提前公告并提供相应解决方案。<br/>8. 乙方在本协议外不得作出对甲方不公平、不合理的规定，或者减轻、免除乙方损害甲方合法权益应当承担的民事责任。<br/>四、 其他约定<br/>1.甲方应在乙方自营或授权代理电信业务的经营场所办理电信业务，否则责任自负。<br/>2.甲方办理各类电信业务的表单均为本协议的补充协议；补充协议与本协议冲突部分 以补充协议为准，补充协议中未约定部分以本协议为准。<br/>3.乙方提供的标准资费及各类套餐资费有效期为2年，另有约定的以约定为准。期满双方无异议则自动延续，延续期间，一方提出异议即可终止相应资费。<br/>4.由于不可抗力、政府行为、国家法律法规、规章或政策变动，导致本协议部分或全部无法履行的，双方均不需承担违约责任。<br/>5.乙方可采用电话、广播、短信、彩信、电子邮件、电视、公开张贴、信函、报纸或 联网等方式进行业务公告、通知。<br/>6.未经乙方同意并办理过户手续，甲方将协议的全部或部分转让给第三方，对乙方不发生法律效力，责任甶甲方承担。<br/>五、 违约责任<br/>1.甲方超过交费时限，每曰按欠费金额的3‰向乙方支付违约金。<br/>2.乙方提供的电信服务若需终端设备具备相应功能支持，应在办理该业务时告知甲方; 对甲方终端设备不具备相应功能而造成的问题，乙方不承担责任。<br/>3.甲、乙方中一方违约给对方造成损失，应依法按实际损失向守约方承担赔偿责任。 赔偿责任不包括预期利益、商业信誉损失、数据的丟失、第三方损失以及其他间接损失。<br/>六、 协议的变更与终止<br/>1.自甲方办理电信业务注销或过户手续之曰，协议相应解除或转移。<br/>2.甲方有下列情形之一者，乙方有权暂停或终止向甲方提供本协议约定的部分或全部服务；若引起甲方损失，乙方不承担责任：<br/>（1）甲方办理入网、变更手续时提供虚假信息资料；<br/>（2）甲方办理电信业务时有担保法律关系，违反保证条款或担保人无能力屨行保证义务的；<br/>（3）甲方发送违法信息，或大量发送骚扰信息、拨打骚扰电话等引起接收方投诉或举报并经查实的；<br/>（4）甲方自行改变电信业务使用性质或超出双方约定使用范围的；<br/>（5）甲方使用未取得入网许可，或可能影响网络安全或服务质量设备的；<br/>（6）甲方欠费停机60日仍未补交通信费用和违约金，或因虚假信息资料被停机60日仍未更正信息资料的；<br/>（7）甲方被司法、行政机关认定为从事违法活动或其他不当用途的；<br/>（8）其他违反相关法律、法规、规章的行为。<br/>3.因技术进步、国家政策变动等原因导致本协议无法继续履行的，本协议应终止或变更。<br/>4.本协议终止后，乙方收回甲方电信服务号码，并保留向甲方追偿所欠费用的权利。<br/>七、 争议解决<br/>因本协议引起的有关争议，双方协商解决。协商不成，双方均可向消费者协会投泝或电信管理部门申坼；也可向有管辖权的人民法院提起诉讼。<br/>八、 附则<br/>本协议自甲方确认阅读后自动生效">《入网协议》</span>
            </van-checkbox>
            <van-button block :loading="subLoading" :disabled="subLoading" loading-text="领取中..." type="info" native-type="submit">限时免费，免费送货上门</van-button>
        </div>
    </van-form>
    <div class="privacy">
        <p>请保持联系号码畅通，我们可能随时与您联系。本次为阶段性优惠活动，</p>
        <p>数量有限，联系电话无人接听或恶意下单情况，将不予发货。</p>
    </div>
    <van-popup v-model="selectData.show" position="bottom">
        <van-cascader
            v-model="selectData.cascaderValue"
            :title="selectData.title"
            placeholder="请选择"
            :options="selectData.options"
            :field-names="fieldNames"
            @close="selectData.show = false"
            @change="onChange"
            @finish="onFinish"
        >
        </van-cascader>
    </van-popup>
    <div class="success-bg" v-show="success_data.is_show">
        <div>
            <van-circle
            size="150px"
            color="#07c160"
            stroke-width="60"
            v-model="success_data.currentRate"
            :speed="success_data.speed"
            :rate="success_data.rate"
            >
            <template slot><div class="van-circle__text">申请成功<br/>正在跳转</div></template>
            </van-circle>
        </div>
    </div>
</div>
@endsection
@section('script')

<script src="{{ URL::asset('js/areaInfo.js') }}"></script>
<script src="{{ URL::asset('js/fillout_order_info_area.js') }}"></script>
<script type="text/javascript">
    new Vue({
        el:"#app",
        mixins: [HeaderMixin],
        data:{
            success_data:{
                is_show:false,
                currentRate:0,
                speed:0,
                rate:100,
                text:'申请成功'
            },
            cardinfo:{!! $cardinfo !!},
            otherinfo:{!! $otherinfo !!},
            twonData:{
                title:'请选择省/市/区',
                options:[],
                fieldValue:'',
                cascaderValue:'',
            },
            selectData:{
                title:'',
                show:false,
                options:[],
                fieldValue:'',
                cascaderValue:'',
                who:''
            },
            fieldNames: {
                text: 'name',
                value: 'code',
                children: 'children',
            },
            userData:{
                username:'',
                usercode:'',
                userphone:'',
                province:null,
                city:null,
                twon:null,
                captcha:'',
                address:'',
            },
            numberData:{
                mobile:'',
                province:null,
                city:null,
                firstMonthFee:null
            },
            checked:true,
            subLoading:false,
            attrValDesc:'',
            captcha:{
				disabled:false,
                time:60,
                timer:0,
                value:'',
            },
            static_domain: "{{env('STATIC_DOMAIN')}}",
            sell_user_key:''
        },
        computed:{
            cityOption(){
                let area_city_option = [];
                allAreaNew.PROVINCE_LIST.forEach(p=>{
                    var data = {
                        name : p.PROVINCE_NAME,
                        code : p.PROVINCE_CODE,
                        ess_code: p.ESS_PROVINCE_CODE
                    }
                    data.children = [];
                    var temp_p = Object.assign({},p)
                    temp_p.children = allAreaNew.PROVINCE_MAP[p.PROVINCE_CODE];
                    temp_p.children.forEach((c,ci)=>{
                        let n = {
                            name : c.CITY_NAME,
                            code : c.CITY_CODE,
                            ess_code: c.ESS_CITY_CODE
                        }
                        data.children.push(n)
                    })
                    area_city_option.push(data)
                    
                })
                return area_city_option
            },
            twonOption(){
                let area_twon_option = [];
                allAreaNew.PROVINCE_LIST.forEach(p=>{
                    var data = {
                        name : p.PROVINCE_NAME,
                        code : p.PROVINCE_CODE,
                        ess_code: p.ESS_PROVINCE_CODE
                    }
                    data.children = [];
                    var temp_p = Object.assign({},p)
                    temp_p = allAreaNew.PROVINCE_MAP[p.PROVINCE_CODE];
                    temp_p.forEach((c,ci)=>{

                        let n = {
                            name : c.CITY_NAME,
                            code : c.CITY_CODE,
                            ess_code: c.ESS_CITY_CODE
                        }
                        data.children.push(n)
                        n.children=[];
                        var temp_c = Object.assign({},p)
                        temp_c = allAreaNew.CITY_MAP[c.CITY_CODE]
                        temp_c.forEach((p,ci)=>{
                            let xx = {
                                name : p.DISTRICT_NAME,
                                code : p.DISTRICT_CODE,
                                ess_code: p.DISTRICT_CODE
                            }
                            n.children.push(xx)
                        })
                    })
                    area_twon_option.push(data)
                    
                })
                return area_twon_option
            },
            numList(){
                let startIndex = this.phoneData.startIndex;
                let endIndex = startIndex+10;
                return this.phoneData.list.slice(startIndex,endIndex)
            },
            has_value() {
                return function (value) {
                    
                    if(this.cardinfo.card_other_datas != null){
                        return this.cardinfo.card_other_datas[value]
                    }
                    
                    return null;
                }
            },
        },
        created() {
            let value = this.has_value('firstMonthFee')
            if(value){
                this.numberData.firstMonthFee = value[0].attrValCode;
                this.attrValDesc = value[0].attrValDesc;
            }
            this.numberData.mobile = this.otherinfo.number;
            this.numberData.province = {
                name:this.otherinfo.provinceName,
                ess_code:this.otherinfo.provinceCode,
            };
            this.numberData.city = {
                name:this.otherinfo.cityName,
                ess_code:this.otherinfo.cityCode,
            };
            this.numberData.mobileFrom = this.otherinfo.mobile_from

            let user_key = window.sessionStorage.getItem('card_user_key')
            if(!user_key){return;}
            this.api.hasSellUser({user_key:user_key},res => {
                if(res === 1){
                    this.sell_user_key = user_key;
                }
            })
		},
		onReady() {
			//setInterval(n=>{
            //    console.log(this.success_data.currentRate)
            //    if(this.success_data.currentRate <= this.success_data.rate){
            //        this.success_data.currentRate = this.success_data.currentRate + 1;
            //    }else{
            //        clearInterval()
            //    }
            //},1000)
		},
        mounted() {
            //this.$refs.myFrom.toggle();
        },
		methods: {
            readXieyi(e){
                let title = e.target.dataset.title;
                let content = e.target.dataset.desc;
                this.$dialog.alert({
                    title: title,
                    message: "<p>"+content +"</p>",
                    messageAlign:'left',
                    allowHtml:true,
                })
            },
            showTwon(){
                this.selectData =  {
                    title:this.twonData.title,
                    show:true,
                    options:this.twonOption,
                    fieldValue:this.twonData.fieldValue,
                    cascaderValue:this.twonData.cascaderValue,
                    who:'twonData'
                }
                
            },
			gotoPage(url){
                window.location.href= url;
            },
            onSubmit(){
                if(!this.checked){
                    message({ type: 'danger', message: '请先阅读并同意协议' })
                    return false;
                }
                this.subLoading = true;
                let data = {
                    userData:this.userData,
                    numberData:this.numberData,
                    card_id:this.cardinfo.id,
                    apply_from: this.api.getProgram(),
                    user_key: this.sell_user_key
                }
                this.api.putOrderByBest(data, res => {
                    this.subLoading = false;
                    if(res.code != 0){
                        message({ type: 'danger', message: res.msg })
                    }else{
                        //后续操作
                        this.success_data.currentRate = 100;
                        this.success_data.rate = 100;
                        this.success_data.speed = 100;
                        this.success_data.is_show = true;
                        setTimeout(n=>{
                            if(res.data.shortUrl){
                                window.location.href=res.data.shortUrl
                            }else{
                                if(this.api.getProgram() == 'wxapp'){
                                    window.location.href= '/card/bestnum/?xcx=1';
                                }else{
                                    window.location.href= '/card';
                                }
                            }
                        },2000)
                    }
                });
            },
            onChange({ value }) {
                
            },
            onFinish({ selectedOptions }) {
                this.selectData.show = false;
                this.selectData.fieldValue = selectedOptions.map((option) => option.name).join(' ');
                this[this.selectData.who].fieldValue = this.selectData.fieldValue
                this[this.selectData.who].cascaderValue = this.selectData.cascaderValue
                if(this.selectData.who == 'twonData'){
                    this.userData.province = {
                        ess_code:selectedOptions[0].ess_code,
                        code:selectedOptions[0].code,
                        name:selectedOptions[0].name
                    }
                    this.userData.city = {
                        ess_code:selectedOptions[1].ess_code,
                        code:selectedOptions[1].code,
                        name:selectedOptions[1].name
                    }
                    this.userData.twon = {
                        ess_code:selectedOptions[2].ess_code,
                        code:selectedOptions[2].code,
                        name:selectedOptions[2].name
                    }
                    return;
                }
            },
            sendCaptcha(){
                let that = this;
                if(that.captcha.disabled){return;}
                this.$refs.myFrom.validate(['userData.userphone','userData.usercode']).then(res=>{
                    let data = {phone:this.userData.userphone,usercode:this.userData.usercode,product_type:this.cardinfo.card_product_type};
                    this.api.sendCaptcha(data, res => {
                        if(res.code == 0){
                            that.captcha.disabled = true;
                            that.captcha.time--
                            that.captcha.timer = setInterval(n=>{
                                if(that.captcha.time == 1){
                                    that.captcha.time = 60;
                                    that.captcha.disabled = false;
                                    clearInterval(that.captcha.timer)
                                }
                                that.captcha.time--
                            },1000)
                        }else{
                            message({ type: 'danger', message: res.msg })
                        }
                        
                    })
                    
                })
            },
            idcardCheck: function(value, rule) {
			    var t = {
			        11: "北京",
			        12: "天津",
			        13: "河北",
			        14: "山西",
			        15: "内蒙古",
			        21: "辽宁",
			        22: "吉林",
			        23: "黑龙江 ",
			        31: "上海",
			        32: "江苏",
			        33: "浙江",
			        34: "安徽",
			        35: "福建",
			        36: "江西",
			        37: "山东",
			        41: "河南",
			        42: "湖北 ",
			        43: "湖南",
			        44: "广东",
			        45: "广西",
			        46: "海南",
			        50: "重庆",
			        51: "四川",
			        52: "贵州",
			        53: "云南",
			        54: "西藏 ",
			        61: "陕西",
			        62: "甘肃",
			        63: "青海",
			        64: "宁夏",
			        65: "新疆",
			        71: "台湾",
			        81: "香港",
			        82: "澳门",
			        91: "国外 "
			      }, o = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/i, e = "", n = !0;
			      if (value && o.test(value)) if (t[value.substr(0, 2)]) {
			          if (18 == value.length) {
			              value = value.split("");
			              for (var c = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ], s = [ 1, 0, "X", 9, 8, 7, 6, 5, 4, 3, 2 ], i = 0, r = 0; r < 17; r++) i += value[r] * c[r];
			              s[i % 11] != value[17] && (e = "您输入的身份证号不存在！", n = !1);
			          }
			      } else e = "您输入的身份证地址编码有误！", n = !1; else e = "您输入的身份证号格式有误！", n = !1;
			      if(!n){
                      rule.message = e;
                  }else{
                      rule.message = '';
                  }
                  return n
			},
		}
    })
</script>
@endsection
<script>
/*
 * @Author: a
 * @Date:   2017-03-11 15:08:34
 * @Last Modified by:   a
 * @Last Modified time: 2017-03-11 15:08:59
 */

'use strict';
(function(doc, win) {
    var docEl = doc.documentElement, // 获取html对象
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize', // 横屏是否支持，不支持则为浏览器大小改变

        // 计算页面字体大小
        recalc = function() {
            // 获取页面宽度
            var clientWidth = docEl.clientWidth;
            // 获取不到页面宽度，直接返回
            if (!clientWidth) return;
            // 设置html字体大小(浏览器默认字体大小为1rem)
            docEl.style.fontSize = clientWidth / 375 * 16 + "px";
        };
    // 不支持addEventListener,返回
    if (!doc.addEventListener) return;
    // 监听事件，获取当前html标签的字体大小
    win.addEventListener(resizeEvt, recalc, false);
    // dom内容加在完成事件
    doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);
</script>