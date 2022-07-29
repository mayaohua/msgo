const domainUrl = 'http://10010lh.com.cn/api';
const getDataList = (url,data,callback,errorback) => {
	url = domainUrl+url;
	uni.showLoading({
		title:'加载中',
		mask: true
	})
	uni.request({
		url:url,
		data: data?data:{},
		method:'POST',
		success:function(res){
			callback(res);
		},
		fail(error) {
			console.log(error)
			errorback && errorback(error);
		},
		complete() {
			uni.hideLoading();
		}
	})
}

const wxPay = (data,callback,errorback) => {
	url = 'http://10010lh.com.cn/myWxpay';
	uni.showLoading({
		title:'加载中',
		mask: true
	})
	uni.request({
		url:url,
		data: data?data:{},
		method:'POST',
		success:function(res){
			callback(res);
		},
		fail(error) {
			console.log(error)
			errorback && errorback(error);
		},
		complete() {
			uni.hideLoading();
		}
	})
}
const getJSSDKConfig = (data,callback,errorback) => {
	url = domainUrl+'/get_jssdk_config';
	uni.showLoading({
		title:'加载中',
		mask: true
	})
	uni.request({
		url:url,
		data: data?data:{},
		method:'POST',
		success:function(res){
			callback(res);
		},
		fail(error) {
			console.log(error)
			errorback && errorback(error);
		},
		complete() {
			uni.hideLoading();
		}
	})
}
const getOpenid = (url,data,callback,errorback) => {
	url = domainUrl+url;
	uni.showLoading({
		title:'加载中',
		mask: true
	})
	uni.request({
		url:'http://10010lh.com.cn/api/openid',
		data: data?data:{},
		method:'POST',
		success:function(res){
			callback(res);
		},
		fail(error) {
			console.log(error)
			errorback && errorback(error);
		},
		complete() {
			uni.hideLoading();
		}
	})
}
module.exports = {
  domainUrl,
  getDataList,
  wxPay,
  getOpenid,
  getJSSDKConfig
}