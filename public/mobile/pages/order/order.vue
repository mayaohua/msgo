<template>
	<view class="content">
		<view class="phone-wrap" v-if="phoneData.visible" @touchmove.stop.prevent>
			<view class="phone-content">
				<input type="number" v-model="phoneData.search" confirm-type="search" placeholder="生日,幸运数字等" @confirm="searchPhoneList">
				<view class="phone-items">
					<view class="phone-item" v-for="item in phoneData.list" @click="data.mobile.phone = item;phoneData.visible = false">{{item}}</view>
				</view>
				<view class="phone-change" @tap="searchPhoneList">换一批</view>
			</view>
			<icon @tap="phoneData.visible = false" type="cancel" size="26"></icon>
		</view>
		<lotus-address v-on:choseVal="choseValue" :lotusAddressData="lotusAddressData"></lotus-address>
		<view class="fill-desc">
			已选择
			<text id="goodsName">{{pageData.product_name}}</text>
		</view>
		<view class="top-desc">
			根据国家实名制要求, 请准确提供身份证信息
		</view>
		<view class="items">
			<view class="item">
				<view class="item-text">姓名</view>
				<view class="item-input">
					<input type="text" v-model="data.user.name" placeholder="请输入身份证件姓名">
				</view>
			</view>
			<view class="item">
				<view class="item-text">身份证</view>
				<view class="item-input">
					<input type="number" v-model="data.user.code" placeholder="请输入身份证号">
				</view>
			</view>
			<view class="item">
				<view class="item-text">联系电话</view>
				<view class="item-input">
					<input type="number" v-model="data.user.phone" placeholder="请输入联系电话">
				</view>
			</view>
			<view class="item">
				<view class="item-text">验证码</view>
				<view class="item-input yzm">
					<input type="number" v-model="captcha.value" placeholder="请输入验证码">
					<button :disabled="captcha.disabled" :style="{'background':captcha.disabled?'#c5c5c5':'#1e96fa'}" class="send_code" @tap="send_code"> {{captcha.disabled ? captcha.time+' 秒后获取':'获取验证码'}}</button>
				</view>
			</view>
		</view>
		<view class="fill-desc">
			请选择号码
		</view>
		<view class="items">
			<view class="item">
				<view class="item-text">号码归属</view>
				<view class="item-input">
					<view @tap="openPicker(false)">{{data.mobile.address?data.mobile.address:'请选择号码归属地'}}</view>
				</view>
			</view>
			<view class="item" v-if="pageData.product_zifei">
				<view class="item-text">选择资费</view>
				<view class="item-input">
					<picker @change="bindZiFeiChange" :range-key="'name'" :value="zifeiIndex" :range="zifeiArray">
						<view class="uni-input">{{data.mobile.zifei?zifeiArray[zifeiIndex].name:'请选择资费'}}</view>
					</picker>
				</view>
			</view>
			<view class="item">
				<view class="item-text">选择号码</view>
				<view class="item-input">
					<view @click="openChanPhone">{{data.mobile.phone?data.mobile.phone:'请选择号码'}}</view>
				</view>
			</view>
		</view>
		<view class="fill-desc">
			请填写配送地址
		</view>
		<view class="items">
			<view class="item">
				<view class="item-text">所在地区</view>
				<view class="item-input">
					<view @tap="openPicker(true)">{{data.user.address?data.user.address:'请选择区/县'}}</view>
				</view>
			</view>
			<view class="item">
				<textarea id="address" v-model="data.user.info" class="text-area" name="address" rows="1"  title="delivery-desc" placeholder="街道/镇+村/小区/写字楼+门牌号"></textarea>
			</view>
			
		</view>
		<view style="font-size: 0.71875rem;" class="top-desc f-xieyi">我已阅读并同意<text class="xieyi">《客户入网服务协议及业务协议》</text><text class="xieyi">《关于客户个人信息收集、使用规则的公告》</text></view>
		<view style="font-size: 0.71875rem;" class="top-desc">国际/港澳台漫游和国际/港澳台长途功能将于号码激活时同步生效</view>
		<view class="sub-warpper">
			<button @click="submit">立即提交，免费送货上门</button>
		</view>
		<view class="ts">
			<view>请保持联系号码畅通，我们可能随时与您联系。本次为阶段性优惠活动，数量有限，联系电话无人接听或恶意下单情况，将不予发货。</view>
		</view>
	</view>
</template>

<script>
	// import allArea from '../../until/areaInfo.js'
	import lotusAddress from "../../components/Winglau14-lotusAddress/Winglau14-lotusAddress.vue";
	import Api from '../../until/api.js'
	export default {
		data() {
			return {
				pageData:{
					product_name:null,
					product_id:'871610241535',
					product_zifei:false,
				},
				lotusAddressData:{
					visible:false,
					provinceName:'北京',
					cityName:'北京市',
					townName:'朝阳区',
					showt:true,
				},
				region:'',
				data:{
					user:{
						name:'',
						code:'',
						address:'',
						info:'',
						phone:'',
						provinceCode : 0,
						cityCode : 0,
						townCode: 0,
					},
					mobile:{
						phone:'',
						zifei:'',
						address:'',
						provinceCode : 0,
						cityCode : 0,
					}
				},
				zifeiArray:[{
					name:'首月收费',
					value:'sdfsdf'
				}],
				zifeiIndex:0,
				lt:{
					img_url:'https://res.mall.10010.cn/mall/scaffold-img',
					detail_url:'https://m.10010.com/decoration-data/scaffold/queryPagealiasProData?page_alias=',
				},
				switchArr:null,
				captcha:{
					disabled:false,
					time:60,
					timer:0,
					value:'',
				},
				phoneData:{
					list:[],
					visible:false,
					search:'',
				}
				
			}
		},
		components: {
			"lotus-address":lotusAddress
		},
		onLoad(e) {
			this.pageData.product_name = e.pn;
			this.pageData.product_id = e.pid;
			this.pageData.product_zifei = (e.zifei == 'true' ? true :false);
			
			this.$nextTick(n=>{
				this.getDetails();
			})
		},
		computed: {
			
		},
		watch:{
			'phoneData.visible'(n,o){
				if(n && this.phoneData.list.length == 0){
					this.searchPhoneList()
				}
			},
			
		},
		methods: {
			searchPhoneList(){
				uni.showLoading();
				let that = this;
				console.log(that.phoneData)
				uni.request({
					method:'POST',
					data:{
						provinceCode:that.data.mobile.provinceCode,
						cityCode:that.data.mobile.cityCode,
						card_goodsid:that.pageData.product_id,
						searchValue:that.phoneData.search
					},
					url: Api.Host+'mobile/mobile_list',
					success: function(res) {
						if(res.data.code == 0){
							that.phoneData.list = res.data.data
						}else{
							uni.showToast({
							title: res.data.msg,
							icon:'none',
							duration: 2000
							});
						}
						uni.hideLoading();
					},
					fail:function(){
						uni.hideLoading();
					}
				});
			},
			openChanPhone(){
				var arr = [
					[this.data.mobile.provinceCode == 0 || this.data.mobile.cityCode == 0, '请选择号码归属地'],
				]
				if(!this.verData(arr)){return false;}
				this.phoneData.visible = true;
			},
			bindZiFeiChange(e){
				this.zifeiIndex = e.target.value
				this.data.mobile.zifei = this.zifeiArray[this.zifeiIndex].value
			},
			//打开picker
			openPicker(showt) {
				this.lotusAddressData.visible = true;
				this.lotusAddressData.showt = showt;
			},
			//回传已选的省市区的值
			choseValue(res){
				//res数据源包括已选省市区与省市区code
				console.log(res);
				this.lotusAddressData.visible = res.visible;//visible为显示与关闭组件标识true显示false隐藏
				//res.isChose = 1省市区已选 res.isChose = 0;未选
				if(res.isChose){
					this.lotusAddressData.provinceName = res.province;//省
					this.lotusAddressData.cityName = res.city;//市
					this.lotusAddressData.townName = res.town;//区
					if(this.lotusAddressData.showt){
						
						this.data.user.address = `${res.province}${res.city}${res.town}`;
						this.data.user.provinceCode = res.provinceCode;
						this.data.user.cityCode = res.cityCode;
						this.data.user.townCode = res.townCode;
						console.log('设置地区：'+this.data.user.address);
					}else{
						this.data.mobile.address = `${res.province}${res.city}`; //region为已选的省市区的值
						this.data.mobile.provinceCode = res.provinceCode;
						this.data.mobile.cityCode = res.cityCode;
						console.log('设置归属地：'+this.data.mobile.address);
					}
					// console.log(this.region)
				}
			},
			getDetails(){
				let that = this;return;
				uni.request({
					url: Api.Host+'mobile/details?index='+index,
					success: function(res) {
						if(res.data.code == 0){
							that.data = res.data.data
							console.log(that.data.lt_data)
							var data = that.data.lt_data.sim_Slide
							if(data.length == 0){
								data = that.data.lt_data.sim_Image.switchImg;
							}else{
								data = data.switchImg;
							}
							that.switchArr = data;
						}
					}
				});
			},
			send_code(){
				if(this.captcha.disabled){return;}
				console.log(this.data.user.phone)
				var arr = [
					[this.data.user.phone ==='','手机号码不能为空'],
					[ 11 !== this.data.user.phone.length || !/^1[3|4|5|6|7|8|9]\d{9}$/.test(this.data.user.phone),'手机号格式不正确']
				]
				if(!this.verData(arr)){return false;}
				uni.showLoading();
				let that = this;
				uni.request({
					url: Api.Host+'mobile/captcha?phone='+that.data.user.phone,
					success: function(res) {
						if(res.data.code == 0){
							uni.showToast({
							title: '验证码发送成功',
							icon:'none',
							duration: 2000
							});
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
							uni.showToast({
							title: res.data.msg,
							icon:'none',
							duration: 2000
							});
						}
						uni.hideLoading();
					},
					fail:function(e){
						uni.showToast({
						title: '验证码发送失败',
						icon:'none',
						duration: 2000
						});
						uni.hideLoading();
					}
				});
				
			},
			idcardCheck: function(a) {
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
			        console.log(a)
			        if (a && o.test(a)) if (t[a.substr(0, 2)]) {
			            if (18 == a.length) {
			                a = a.split("");
			                for (var c = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ], s = [ 1, 0, "X", 9, 8, 7, 6, 5, 4, 3, 2 ], i = 0, r = 0; r < 17; r++) i += a[r] * c[r];
			                s[i % 11] != a[17] && (e = "您输入的身份证号不存在！", n = !1);
			            }
			        } else e = "您输入的身份证地址编码有误！", n = !1; else e = "您输入的身份证号格式有误！", n = !1;
			        return {
			            errorMess: e,
			            isPass: n
			        };
			    },
				
			submit(){
				var x = this.idcardCheck(this.data.user.code);
				var arr = [
					[this.data.user.name == '','姓名不能为空'],
					[x.isPass === '','身份证不能为空'],
					[!x.isPass,x.errorMess],
					[this.data.user.phone ==='','手机号码不能为空'],
					[ 11 !== this.data.user.phone.length || !/^1[3|4|5|6|7|8|9]\d{9}$/.test(this.data.user.phone),'手机号格式不正确'],
					[this.captcha.value === '','验证码不能为空'],
					[this.data.mobile.provinceCode == 0 || this.data.mobile.cityCode == 0, '请选择号码归属地'],
					[this.pageData.product_zifei && this.data.mobile.zifei == '','请选择资费'],
					[this.data.mobile.phone == '','请选择号码'],
					[this.data.user.provinceCode == 0 || this.data.user.cityCode == 0 || this.data.user.townCode == 0, '请选择配送地区'],
					[this.data.user.info == '','请填写配送详细地址'],
				]
				if(!this.verData(arr)){return false;}
				uni.showLoading();
				this.data.user.captcha = this.captcha.value
				this.data.product = {id:this.pageData.product_id,name:this.pageData.product_name}
				let that = this;
				uni.request({
					method:'POST',
					data:that.data,
					url: Api.Host+'mobile/order',
					success: function(res) {
						uni.showToast({
							title: res.data.msg,
							icon:'none',
							duration: 2000
						});
						uni.hideLoading();
					},
					fail:function(){
						uni.hideLoading();
					}
				});
			},
			verData(array){
				let noError = true;
				for (var i = 0; i < array.length; i++) {
					if(array[i][0]){
						uni.showToast({
						    title: array[i][1],
						    duration: 2000,
							icon: 'none',
							position:'bottom'
						});
						noError = false;
						break;
					}
				}
				return noError;
			},
			
		}
	}
</script>

<style>
	page{
		background-color: #f7f7f7;
	}
	.content *{
		font-size: 0.8125rem;
		color: #6e6e6e;
		
	}
	.f-xieyi{
		margin-bottom: 15rpx;
		line-height: 2.5rem;
	}
	.xieyi{
		color: #1e96fa;
	}
	.content{
		
	}
	.content .fill-desc{
		line-height: 2.8125rem;
		padding: 0 1.125rem;
	}
	#goodsName{
		
		margin-left: 15rpx;
		color: #1e96fa;
	}
	.top-desc{
		line-height: 1.25rem;
		padding: 0 1.125rem;
	}
	.items{
		background-color: #fff;
		padding: 0 1.125rem;
		margin-top: 10rpx;
	}
	.item{
		border-bottom: 1PX solid #f8f8f8;
	}
	.item{
		display: flex;
		line-height: 2.4rem;
		align-items: center;
	}
	.item .item-text{
		width: 160rpx;
	}
	.item-input{
		line-height: 2.4rem;
		flex: 1;
		display: block;
	}
	/* .item view{
		flex:1;
	} */
	.sub-warpper{
		padding: 0.375rem 0.75rem;
		background: #fff;
	}
	.sub-warpper button{
		display: block;
		width: 100%;
		height: 2.5rem;
		line-height: 2.5rem;
		font-size: 1.0625rem;
		text-align: center;
		text-decoration: none;
		border-radius: 3px;
		background-color: #1e96fa;
		color: #FFF;
	}
	.ts view{
		font-size: 0.75rem;
		text-align: center;
		color: #adadad;
		line-height: 0.9375rem;
		padding: 0 1.125rem;
		margin: 10rpx 0;
	}
	.yzm{
		display: flex;
		align-items: center;
		flex:1;
	}
	.yzm input{
		flex: 1;
	}
	.yzm button{
		display: block;
		width: 6.25rem;
		text-align: center;
		color: #fff;
		background: #1e96fa;
		font-size: 0.8125rem;
		border-radius: 4px;
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
		height: 550rpx;
		background: white;
		padding: 0 auto;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	.phone-wrap icon{
		margin-top: 20rpx;
	}
	.phone-content input{
		padding:15rpx 20rpx;
		margin: 10rpx 20rpx;
		border: 1px solid #dfdfdf;
	}
	.phone-items{
		flex: 1;
		margin: 20rpx 0;
		height: 60rpx;
		overflow: hidden;
	}
	.phone-item{
		width: 50%;
		float: left;
		text-align: center;
		margin: 10rpx 0;
		font-size: 36rpx;
	}
	.phone-content .phone-change{
		text-align: center;
		color: #007AFF;
		padding: 20rpx 0;
		border-top: 1px solid #dfdfdf;
	}
</style>
