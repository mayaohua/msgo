<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@2.12/lib/index.css"/>
    <!-- <link rel="stylesheet" href="<?php echo e(URL::asset('element_ui/index.min.css')); ?>"> -->
    <script src="<?php echo e(URL::asset('logins/js/jquery.min.js')); ?>"></script>
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
    </style>
    <?php echo $__env->yieldContent('head'); ?>
</head>
<body>
    <div id="app" v-cloak>
        <?php echo $__env->yieldContent('content'); ?>
        <van-tabbar class="ui-tabber" v-model="active_table" route v-if="active_table != -1">
            <van-tabbar-item replace url="/bill/">
                <span :style="active_table == 0 ? 'color:#1989fa;':''">话费充值</span>
                <template #icon="props">
                    <img v-if="active_table != 0" src="<?php echo e(URL::asset('images/phone.png')); ?>" />
                    <img v-else src="<?php echo e(URL::asset('images/phone_on.png')); ?>" />
                </template>
            </van-tabbar-item>
            <van-tabbar-item replace url="/bill/flow/">
                <span :style="active_table == 1 ? 'color:#1989fa;':''">流量充值</span>
                <template #icon="props">
                    <img v-if="active_table != 1" src="<?php echo e(URL::asset('images/flow.png')); ?>" />
                    <img v-else src="<?php echo e(URL::asset('images/flow_on.png')); ?>" />
                </template>
            </van-tabbar-item>
            <van-tabbar-item replace url="/bill/vip/">
                <span :style="active_table == 2 ? 'color:#1989fa;':''">会员充值</span>
                <template #icon="props">
                    <img v-if="active_table != 2" src="<?php echo e(URL::asset('images/vip.png')); ?>" />
                    <img v-else src="<?php echo e(URL::asset('images/vip_on.png')); ?>" />
                </template>
            </van-tabbar-item>
            <van-tabbar-item replace url="/bill/center/">
                <span :style="active_table == 3 ? 'color:#1989fa;':''">用户中心</span>
                <template #icon="props">
                    <img v-if="active_table != 3" src="<?php echo e(URL::asset('images/center.png')); ?>" />
                    <img v-else src="<?php echo e(URL::asset('images/center_on.png')); ?>" />
                </template>
            </van-tabbar-item>
        </van-tabbar>
    </div>
</body>
<script src="<?php echo e(URL::asset('js/axios.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('js/vue.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/vant@2.12/lib/vant.min.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>

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
const domainUrl = '<?php echo env("APP_WX_URL"); ?>/api';
const getDataList = (url,data,callback) => {
	url = domainUrl+url;
	axios({
		url:url,
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
const getOrderList = (data,callback) => {
	url = domainUrl+'/bill/record';
	axios({
		url:url,
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
const wxPay = (data,callback) => {
	let url = domainUrl+'/bill/wxpay';
	axios({
		url:url,
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
const getJSSDKConfig = (data,callback) => {
    let url = domainUrl+'/js_config';
    $.post(url,data,function(res){
        callback && callback(res);
    })
}
const getOpenid = (data,callback) => {
	axios({
		url:domainUrl+'/bill/openid',
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
const cancelPay = (data,callback) => {
	axios({
		url:domainUrl+'/bill/cancelpay',
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
const payFail = (data,callback) => {
	axios({
		url:domainUrl+'/bill/payfail',
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
    });
}
const putQuestion = (data,callback) => {
	axios({
		url:domainUrl+'/bill/put_question',
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
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
const hasSellUser = (data,callback) => {
    axios({
		url:'<?php echo env("APP_WX_URL"); ?>'+'/official/has_sell_user',
		data: data?data:{},
		method:'POST'
	}).then(function(res){
		callback && callback(res);
	})
}
Vue.prototype.api = {
  domainUrl,
  getDataList,
  wxPay,
  getOpenid,
  getJSSDKConfig,
  cancelPay,
  payFail,
  getOrderList,
  uploadImg,
  putQuestion,
  getQueryString
}
</script>
<script>
getJSSDKConfig(false,res => {
    
    if(res.code != 0){
        message({ type: 'danger', message: res.msg })
    }else{
        wx.config(res.data);
    }
});
let user_key = getQueryString('key');
if(user_key){
    window.localStorage.setItem('bill_user_key',user_key)
}


// 定义一个混入对 1象 
var HeaderMixin = {
    data  () {
        return {
            active_table: <?php echo $active; ?>,
            swiperList: [
                {
					id: 1,
					url: 'http://www.baidu.com',
					src: "https://wx.1001020.cn/storage/uploads/2021-01-25-17-14-38.jpg"
				},
                {
					id: 2,
					url: 'http://www.baidu.com',
					src: 'https://wx.1001020.cn/storage/uploads/2021-01-25-17-19-34.jpg'
				},
                {
					id: 3,
					url: 'http://www.baidu.com',
					src: "<?php echo e(URL::asset('images/20210525134838.png')); ?>"
				},
                {
					id: 4,
					url: 'http://www.baidu.com',
					src: "<?php echo e(URL::asset('images/20210525134723.png')); ?>"
				}
            ],
        }
    },
    
    created: function () {
        
    },
    methods: {
        
    }
};
Vue.mixin(HeaderMixin);
Vue.config.ignoredElements = [ // 忽略自定义元素标签抛出的报错
  'wx-open-launch-weapp', 
  'wx-open-subscribe', 
];
</script>
<?php echo $__env->yieldContent('script'); ?>
</html>
