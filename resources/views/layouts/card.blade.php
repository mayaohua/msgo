<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@2.12/lib/index.css"/>
    <!-- <link rel="stylesheet" href="{{ URL::asset('element_ui/index.min.css') }}"> -->
    <script src="{{ URL::asset('logins/js/jquery.min.js') }}"></script>
    <style>
        [v-cloak]{
            display:none;
        }
        a{
            color:#444;
            display:block;
        }
        .my-swipe .van-swipe-item {
            color: #fff;
            font-size: 20px;
            text-align: center;
        }
        /* *{
            font-size:16px;
        } */
        .ui-title div,.ui-title span,.ui-title i,.ui-title em,.van-tabs__nav div span{
            font-size:16px;
        }
        .content .ui-cont div,.content .ui-cont span,.ui-tabber span{
            font-size:14px;
        }
        .van-tabs .van-tabs__wrap{
            margin-bottom:5px;
        }
        .ui-input-wrap .van-field__control{
            font-size:16px;
        }
        .ui-input-wrap{
            position: relative;
        }
        .ui-input-wrap .ui-input-field>div:last-child{
            position: absolute;
            right: 10px;
            top: 9px;
        }
        #container{
            padding-bottom: {!! $active == -1 ? '0' :'50px' !!};
        }
        .loading{
            height:100vh;
            width:100vw;
            position:fixed;
            z-index: 999;
        }
        .el-loading-mask {
            position: absolute;
            z-index: 2000;
            background-color: hsla(0,0%,100%,.9);
            margin: 0;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            transition: opacity .3s;
            background-color: hsla(0,0%,100%,.9);
        }
        .el-loading-spinner {
            top: 50%;
            margin-top: -21px;
            width: 100%;
            text-align: center;
            position: absolute;
        }
        .el-loading-spinner .circular {
            height: 42px;
            width: 42px;
            animation: loading-rotate 2s linear infinite;
            text-align: center;
            font-size: 14px;
            color: #606266;
        }
        .el-loading-spinner .path {
            animation: loading-dash 1.5s ease-in-out infinite;
            stroke-dasharray: 90,150;
            stroke-dashoffset: 0;
            stroke-width: 2;
            stroke: #409eff;
            stroke-linecap: round;
        }
        
        @-webkit-keyframes loading-rotate {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @keyframes loading-rotate {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @-webkit-keyframes loading-dash {
            0% {
                stroke-dasharray: 1,200;
                stroke-dashoffset: 0
            }

            50% {
                stroke-dasharray: 90,150;
                stroke-dashoffset: -40px
            }

            100% {
                stroke-dasharray: 90,150;
                stroke-dashoffset: -120px
            }
        }

        @keyframes loading-dash {
            0% {
                stroke-dasharray: 1,200;
                stroke-dashoffset: 0
            }

            50% {
                stroke-dasharray: 90,150;
                stroke-dashoffset: -40px
            }

            100% {
                stroke-dasharray: 90,150;
                stroke-dashoffset: -120px
            }
        }
    </style>
    @yield('head')
</head>
<body>
    <div class="loading">
        <div class="el-loading-mask">
          <div class="el-loading-spinner">
            <svg viewBox="25 25 50 50" class="circular"><circle cx="50" cy="50" r="20" fill="none" class="path"></circle></svg>
          </div>
      </div>
    </div>
    <div id="app" v-cloak>
        @yield('content')
        <van-tabbar class="ui-tabber" v-model="active_table" route v-if="active_table != -1">
            <van-tabbar-item replace url="/card/">
                <span :style="active_table == 0 ? 'color:#1989fa;':''">靓号商城</span>
                <template #icon="props">
                    <img v-if="active_table != 0" src="{{ URL::asset('images/phone.png') }}" />
                    <img v-else src="{{ URL::asset('images/phone_on.png') }}" />
                </template>
            </van-tabbar-item>
            <van-tabbar-item replace url="/card/bestnum/">
                <span :style="active_table == 1 ? 'color:#1989fa;':''">精品靓号</span>
                <template #icon="props">
                    <img v-if="active_table != 1" src="{{ URL::asset('images/flow.png') }}" />
                    <img v-else src="{{ URL::asset('images/flow_on.png') }}" />
                </template>
            </van-tabbar-item>
            <van-tabbar-item replace url="/card/kind/">
                <span :style="active_table == 2 ? 'color:#1989fa;':''">靓号广场</span>
                <template #icon="props">
                    <img v-if="active_table != 2" src="{{ URL::asset('images/vip.png') }}" />
                    <img v-else src="{{ URL::asset('images/vip_on.png') }}" />
                </template>
            </van-tabbar-item>
            <van-tabbar-item replace url="/card/us">
                <span :style="active_table == 3 ? 'color:#1989fa;':''">联系我们</span>
                <template #icon="props">
                    <img v-if="active_table != 3" src="{{ URL::asset('images/center.png') }}" />
                    <img v-else src="{{ URL::asset('images/center_on.png') }}" />
                </template>
            </van-tabbar-item>
        </van-tabbar>
    </div>
</body>
<script src="{{ URL::asset('js/axios.min.js') }}"></script>
<script src="{{ URL::asset('js/vue.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vant@2.12/lib/vant.min.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
<script>
//     (function (doc, win) {
//     var docEl = doc.documentElement,
//     resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
//     recalc = function () {
//       var clientWidth = docEl.clientWidth;
//       if (!clientWidth) return;
//       docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
//     };
   
//     if (!doc.addEventListener) return;
//        win.addEventListener(resizeEvt, recalc, false);
//        doc.addEventListener('DOMContentLoaded', recalc, false);
// })(document, window);



</script> 
<script>
    let token = document.head.querySelector('meta[name="csrf-token"]');
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    var my_loading = null;
    var message = Vue.prototype.$notify;
    
    axios.interceptors.request.use(
        config => {
            my_loading = Vue.prototype.$toast.loading({
                message: '加载中...',
                forbidClick: true,
                duration:0
            });
            return config;
        },
        error => {
            return Promise.error(error);
        }
    );
    axios.interceptors.response.use(
        response => {
            my_loading.clear()
            if (response.status === 200) {
                if(response.data.code === 0){
                    //message({ type: 'success', message: response.data.msg })
                }else{
                    if(response.data.msg){
                        message({ type: 'danger', message: response.data.msg })
                    }
                }
                return Promise.resolve(response.data);
            } else {
                return Promise.reject(response.data);
            }
        },
        error => {
            my_loading.clear()
            if (error.response.status) {
            switch (error.response.status) {
                case 403:
                    message({ type: 'danger', message: "无权访问" })
                break;
                case 404:
                    message({ type: 'danger', message: "请求地址不存在" })
                break;
                case 405:
                    message({ type: 'danger', message: "请求地址不存在" })
                break;
                case 500:
                    message({ type: 'danger', message: "系统错误" })
                break;
                default:
                    message({ type: 'danger', message: "内部错误" })
            }
            return Promise.reject(error.response);
            }
        }
    );
    Vue.prototype.$axios = axios;
</script>
<script>
const domainUrl = '{!! env("APP_WX_URL") !!}/api';

const getJSSDKConfig = (data,callback) => {
	let url = domainUrl+'/js_config';
    $.post(url,data,function(res){
        callback && callback(res);
    })
}
const regPhone = function(phone) {
    var arr = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    for (var s in phone) { arr[phone[s]]++; }
    for (var a in arr) {
        if (arr[a] >= 5) {
        //  return a;
        }
    }
    var reg = {
        abcd: "(?:(?:0(?=1)|1(?=2)|2(?=3)|3(?=4)|4(?=5)|5(?=6)|6(?=7)|7(?=8)|8(?=9)){3,}|(?:9(?=8)|8(?=7)|7(?=6)|6(?=5)|5(?=4)|4(?=3)|3(?=2)|2(?=1)|1(?=0)){3,})\\d",
        aabbcc: "(\\d)\\1((?!\\1)\\d)\\2((?!\\1)\\d)\\3",
        aabb: "(\\d)\\1((?!\\1)\\d)\\2",
        ababab: "(\\d)((?!\\1)\\d)\\1\\2\\1\\2",
        abab: "(\\d)((?!\\1)\\d)\\1\\2",
        abcabc: "(\\d)(\\d)(\\d)\\1\\2\\3",
        aaa: "([\\d])\\1{2,}",
        aabcc: "(\\d)\\1((?!\\1)\\d)((?!\\1)\\d)\\3",
        abba: "(\\d)((?!\\1)\\d)\\2\\1{1}",
        days: "((0[1-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1]))$",
        year: "((19[4-9][0-9])|(20[0-1][0-9]))$",
        abaa: "(\\d)(?!\\1)\\d\\1{2}",
        aaba: "(\\d)\\1(?!\\1)\\d\\1",
        aa: "([\\d])\\1{1,}$",
        love: "(520)|(521)$",
        ysys: "(1314)$",
        ylf: "(168)$"
    };
    for (var i in reg) {
        var result = (new RegExp(reg[i])).exec(phone);
        if (result != null) {
            //console.log(i + "——" + result[0]);
        return result[0];
        }
    }
    return null;
}
const sendCaptcha = (data,callback) => {
	let url = domainUrl+'/card/send_captcha';
    axios({
		url:url,
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
const putOrderByNumber = (data,callback) => {
    let url = domainUrl+'/card/put_order_by_number';
    $.post(url,data,function(res){
        callback && callback(res);
    })
}
const putOrderByBest = (data,callback) => {
    let url = domainUrl+'/card/put_order_by_best';
    $.post(url,data,function(res){
        callback && callback(res);
    })
}

const numSelect = (data,callback) => {
    if(data.product_type){
        let url = domainUrl+'/card/num_select';
        $.post(url,data,function(res){
            callback && callback(res);
        })
    }else{
        let timestamp = new Date().getTime();
        let url = `https://msgo.10010.com/NumApp/NumberCenter/qryNum?callback=jsonp_queryMoreNums&provinceCode=${data['provinceCode']}&cityCode=${data['cityCode']}&monthFeeLimit=0&goodsId=${data['product_id']}&searchCategory=3&net=01&amounts=200&codeTypeCode=&searchValue=${data['search']}&qryType=02&goodsNet=4&channel=msg-xsg&_=${timestamp}`;
        $.get(url,function(res){
            var m = res;
            var result = {code:-1,msg:'获取号码失败',data:[]}
            if (m = m.replace(";", ""), m = m.replace("jsonp_queryMoreNums(", ""), m = m.replace(")", ""), 
            "M0" == (m = JSON.parse(m)).code) {
                for (var y = [], g = 0, x = 0; x < m.numArray.length; x++){
                     m.numArray[x] > 5 && (y[g] = m.numArray[x], 
                          g++);  
                }
                if(y.length == 0){
                    result = {code:-1,msg:'未找到号码',data:[]}
                }else{
                    result = {code:0,msg:'',data:y}
                }
                
            }else if("T1" == m.code){
                result = {code:-1,msg:'没有符合的号码',data:[]}
            }
            callback && callback(result);
        })
    }
	
}

const putQuestion = (data,callback) => {
	axios({
		url:domainUrl+'/card/put_question',
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
const uploadImg = (file,callback) => {
    var formData = new FormData();
    formData.append('fileUpload',file);
    $.ajax({
        url:domainUrl+'/upload',
        type:'post',
        processData:false,
        contentType:false,
        data:formData,
        success:function (res) {
            callback && callback(res);
        }
    })
}
const getQueryString  = (name) => {
    var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
    var r = window.location.search.substr(1).match(reg);
    if (r != null) {
    return unescape(r[2]);
    }
    return null;
}
const getProgram = () => { //是否为小程序环境
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
        if(window.__wxjs_environment === 'miniprogram'){
            return 'wxapp';
        }else{
            return 'official';
        }
        // wx.miniProgram.getEnv((res) => {
        //     if (res.miniprogram) {//小程序环境
        //         alert("在小程序里");
        //         return 'wxapp';
        //     } else {
        //         alert("不在小程序里");
        //         return 'official1'
        //     }
        // });
    }else{
        return 'web';
    } 
}
const isMiniProgram = (callback) => { //是否为小程序环境
     var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
        wx.miniProgram.getEnv((res) => {
            if (res.miniprogram) {//小程序环境
                callback(true)
            } else {
                callback(false)
            }
        });
    }else{
        callback(false)
    } 
}
const hasSellUser = (data,callback) => {
    axios({
		url:'{!! env("APP_WX_URL") !!}'+'/official/has_sell_user',
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
const replaceImgSrc = () => {
    var elements = document.getElementsByTagName("img"),
    rootpath = "{{env('STATIC_DOMAIN')}}",
    root = "{{env('APP_URL')}}";
    root_wx = "{{env('APP_WX_URL')}}";
    console.log(root)
    for(let index = 0; index < elements.length; index++) {
        // console.log(elements[index].src)
        var src = elements[index].src.replace(root,rootpath).replace(root_wx,rootpath);
        console.log(index)
        console.log(elements[index].src)
        // elements[index].src = src;
        console.log(elements[index].src)
        
    }
}

Vue.prototype.api = {
  getJSSDKConfig,
  sendCaptcha,
  numSelect,
  putOrderByNumber,
  putOrderByBest,
  regPhone,
  putQuestion,
  uploadImg,
  getQueryString,
  isMiniProgram,
  getProgram,
  hasSellUser
}
</script>
<script>
getJSSDKConfig(false,res => {
    // alert(JSON.stringify(res))
    if(res.code != 0){
        message({ type: 'danger', message: res.msg })
    }else{
        wx.config(res.data);
    }
})
let user_key = getQueryString('key');
if(user_key){
    window.sessionStorage.setItem('card_user_key',user_key)
}
// 定义一个混入对 1象 
var HeaderMixin = {
    data  () {
        return {
            active_table: "{!! $active !!}",
            swiperList: [
                {
					id: 1,
					url: 'http://www.baidu.com',
					src: "{{ URL::asset('images/ylmb.gif') }}"
				},
                {
					id: 2,
					url: 'http://www.baidu.com',
					src: "{{ URL::asset('images/20190916-134749-a406.gif') }}"
				},
            ],
        }
    },
    
    created: function () {
        if(document.getElementsByClassName('loading').length){
            document.getElementsByClassName('loading')[0].remove()
        }
    },
    methods: {

    }
};
Vue.config.ignoredElements = [ // 忽略自定义元素标签抛出的报错
  'wx-open-launch-weapp', 
  'wx-open-subscribe', 
];
</script>
@yield('script')
</html>
