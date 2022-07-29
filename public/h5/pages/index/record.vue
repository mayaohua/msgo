<template>
	<view>
		<view>
			
		</view>
	</view>

</template>

<script>
	import api from '../../utils/api.js'
	
	export default {
		data() {
			return {
				
			};
		},
		onLoad() {
			api.getOpenid('',false, res => {
				uni.setStorageSync('openid',res.openid)
				this.init()
			})
			//
			//this.tempList = this.list
			
		},
		onReady() {
			
		},
		methods: {
			init(){
				let data = {
					openid : uni.getStorageSync('openid')
				};
				api.wxPay('',data, res => {
					console.log(res)
					wx.chooseWXPay({
					  timestamp: 0, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
					  nonceStr: '', // 支付签名随机串，不长于 32 位
					  package: '', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=\*\*\*）
					  signType: '', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
					  paySign: '', // 支付签名
					  success: function (res) {
					    // 支付成功后的回调函数
					  }
					});
					// function onBridgeReady(){
					// 	var order_id = res.data.order_id
					// 	WeixinJSBridge.invoke(
					// 		'getBrandWCPayRequest', res.data,
					// 		function(res){
					// 		if(res.err_msg == "get_brand_wcpay_request:ok" ){
					// 			alert('支付成功');
					// 			//支付成功
					// 			that.getUserBills();
					// 			that.changeTab(1)
					// 		}else{
					// 			//取消支付
					// 			alert('取消支付');
					// 			that.$axios.post('/api/wxpay/cancelOrder',{oid:order_id}).then(res=>{
					// 				that.getUserBills();
					// 				that.changeTab(1)
					// 			})
					// 		} 
					// 	}); 
					// }
					// if (typeof WeixinJSBridge == "undefined"){
					// 	if( document.addEventListener ){
					// 		document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
					// 	}else if (document.attachEvent){
					// 		document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
					// 		document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
					// 	}
					// }else{
					// 	onBridgeReady();
					// }
				})
			},
		}
	}
</script>

<style>
	.ui-content {
		width: 100%;
		margin-bottom: 20px;
	}
	.ui-isp::after{
		border: 0.5px solid currentColor!important;
	}
	.ui-title {
		display: flex;
		/* position: relative; */
		align-items: center;
		justify-content: space-between;
		min-height: 50px;
		background-color: #ffffff;
		color: #666666;
		font-size: 14px;
		padding: 0 10px;
	}

	.ui-info {
		color: #999;
	}

	.ui-items {
		display: flex;
		flex-wrap: wrap;
		padding: 0 10px;
	}

	.ui-item {
		width: 33.333%;
		font-size: 14px;
		margin-top: 5px;
		color: #1aad19;
	}

	.ui-cont {
		border: 1px solid #1aad19;
		box-sizing: border-box;
		border-radius: 5px;
		transform: scale(0.95);
		padding-bottom: 5px;

	}

	.text-red {
		color: red;
		text-decoration: line-through;
	}

	.ui-cont view {
		text-align: center;
	}

	.small-desc {
		color: white;
		padding: 1px;
		border-radius: 5px;
		border-bottom-left-radius: 0;
		border-top-right-radius: 0;
		background-color: #1aad19;
		/* line-height: 16px; */
		font-size: 14px;
		display: inline;
	}
</style>
