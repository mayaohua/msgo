<template>
	<view>
		<swiper class="screen-swiper square-dot" :indicator-dots="true" :circular="true" :autoplay="true"
			interval="5000" duration="500" indicator-color="#8799a3" indicator-active-color="#0081ff">
			<swiper-item v-for="(item,index) in swiperList" :key="index">
				<image :src="item.url" mode="aspectFill"></image>
			</swiper-item>
		</swiper>
		<view class="content">
			<view class="cu-form-group margin-top">
				<input :value=" input.phone " placeholder="请输入要充值的手机号码" maxlength="11"
        type="number" pattern="[0-9]*" :auto-focus="input.autoFocus" :focus="input.focus" @input="onInput" name="input"></input>
				<text @click="inputClear" class='cuIcon-close text-orange' style="margin-right: 10px;font-size: 20px;"></text>
				<view v-if="isp" class="cu-capsule radius" >
					<!-- <view class='cu-tag bg-blue '>
						{{isp.province+(isp.city?'-'+isp.city:'')+' ['+isp.sp+']'}}
					</view> -->
					<view class="cu-tag line-blue ui-isp">
						{{isp.province+(isp.city?'-'+isp.city:'')+' ['+isp.sp+']'}}
					</view>
				</view>
				
			</view>
			<scroll-view scroll-x class="bg-white nav" style="margin-top: 5px;">
				<view class="flex text-center">
					<view class="cu-item flex-sub" :class="index==TabCur?'text-orange cur':''"
						v-for="(item,index) in list" :key="index" @tap="tabSelect" :data-id="index">
						{{item.type_name}}
					</view>
				</view>
			</scroll-view>
			<view v-for="(item,index) in list" :key="index" style="margin-top: 5px;">
				<scroll-view v-show="index == TabCur">
					<view class="ui-content" v-for="(caseitem,caseindex) in item.billcases" :key="caseindex">
						<view class="ui-title">
							<view>
								<text class="cuIcon-title text-green"></text>{{caseitem.case_name}}
							</view>
							<view class="ui-info" :data-desc="caseitem.desc_content" @click="xiangqing">详情</view>
						</view>
						<view class="ui-items">
							<view class="ui-item" v-for="(billitem,billindex) in caseitem.bills" :key="billindex"
							@click="onSellPut" 
							  :data-desc="billitem.order_tips"
							  :data-cc="billitem.case_name"
							  :data-price="billitem.sale_price"
							  :data-package="billitem.package"
							  :data-yh_tips="billitem.yh_tips"
							  :data-id="billitem.id"
							  :data-bill_case_id="billitem.bill_case_id">
								<view class="ui-cont">
									<view class="small-desc">{{billitem.yh_tips}}</view>
									<view style="margin:5px 0;"><text class="text-red">面值：{{billitem.package}}</text>
									</view>
									<view>售价：{{billitem.sale_price}}</view>
								</view>
							</view>
						</view>
					</view>
				</scroll-view>
			</view>
		</view>
		<view class="cu-modal" :class="dialog.show?'show':''">
			<view class="cu-dialog">
				<view class="cu-bar bg-white justify-end">
					<view class="content" style="font-size: 18px;font-weight: bold;
					text-align: left;margin-left: 30px;width: 100%;">{{dialog.title}}</view>
				</view>
				<view class="padding-xl" style="text-align: left;background: white;padding: 10px 25px;
				border-top: 1px solid #eee;font-size: 15px;">
					<rich-text :nodes="dialog.content"></rich-text>
				</view>
				<view class="cu-bar bg-white justify-end" style="padding-right: 20px;padding-bottom: 10px;">
					<view class="action">
						<view class="text-green" @click="onDialogClose" style="font-weight: bold;font-size: 16px;"
						 v-if="dialog.cancelBtn">取消</view>
						<!-- v-if="dialog.cancelBtn" -->
						<view 
						style="font-weight: bold;margin-left: 30px;font-size: 16px;"
						@click="onDialogConfirm">{{dialog.confirmButtonText}}</view>

					</view>
				</view>
			</view>
		</view>
	</view>

</template>

<script>
	import api from '../../utils/api.js'
	export default {
		data() {
			return {
				list: [],
				swiperList: [{
					id: 0,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big84000.jpg'
				}, {
					id: 1,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big37006.jpg',
				}, {
					id: 2,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big39000.jpg'
				}, {
					id: 3,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big10001.jpg'
				}, {
					id: 4,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big25011.jpg'
				}, {
					id: 5,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big21016.jpg'
				}, {
					id: 6,
					type: 'image',
					url: 'https://ossweb-img.qq.com/images/lol/web201310/skin/big99008.jpg'
				}],
				TabCur: 0,
				dialog: {
					show: false,
					content: '',
					cancelBtn: false,
					title: '',
					confirmButtonText: '',
				},
				input:{
				  phone:'',
				  focus:true,
				  autoFocus:false,
				},
				tempList:[],
				isp:false,
				orderData:false,
			};
		},
		onLoad() {
			this.init(false)
		},
		onReady() {
			uni.hideLoading()
		},
		methods: {
			init(data){
				api.getDataList('/vip/all',data, res => {
					console.log(this.list)
					this.list = res.data;
					this.TabCur = 0;
					this.tempList = this.list;
				})
			},
			inputClear(){
				this.input = {
					phone:'',
					focus:true,
					autoFocus:false,
				}
				this.list = this.tempList;
				this.isp = false;
			  },
			  onInput(event){
				  this.input.phone = event.detail.value
			    if(event.detail.value.length === 11){
					this.input.focus = false
					this.input.autoFocus = false
					api.getDataList('/vip/all',{mobile:event.detail.value}, res => {
						this.list = res.data.list;
						this.TabCur = 0;
						this.isp = res.data.ips;
					})
			    }else{
			      this.list = this.tempList
				  this.isp = false;
			    }
			  },
			xiangqing(detail) {
				this.dialog = {
					'show': true,
					'content': detail.target.dataset.desc,
					'cancelBtn': false,
					'title': '产品详情',
					'confirmButtonText': '确定'
				};
			},
			onDialogClose() {
				this.dialog.show = false;
			},
			onDialogConfirm(event) {
				if (!this.dialog.cancelBtn) {
					this.onDialogClose();
					return;
				}
				console.log('OK')
			},
			tabSelect(e) {
				this.TabCur = e.currentTarget.dataset.id;
			},
			onSellPut(event){
			    if(this.input.phone == null || this.input.phone.length != 11){
			      this.input.focus = true
			      this.input.autoFocus = true
			      return;
			    }
			    let st_obj = event.currentTarget.dataset;
			    st_obj.desc = st_obj.desc.replace(/\[/g,'<i style="color: red;font-style:normal;">');
			    st_obj.desc = st_obj.desc.replace(/\]/g,'</i>');
			    let p_sty = 'style="display: flex;justify-content: space-between;margin:2px 0;"'
			    let t_sty = 'style="width:60px;color:#666;"';
			    let s_sty='style="text-align:right;"';
			    var str = `
			    <p ${p_sty}><span ${t_sty}>充值号码</span><span ${s_sty}>${this.input.phone}</span></p>
			    <p ${p_sty}><span ${t_sty}>套餐</span><span ${s_sty}>${st_obj.cc}</span></p>
			    <p ${p_sty}><span ${t_sty}>预计</span><span ${s_sty}>${st_obj.yh_tips}</span></p>
			    
			    <p ${p_sty}><span ${t_sty}>面值</span><span ${s_sty}>${st_obj.package}</span></p>
			    <p ${p_sty}><span ${t_sty}>售价</span><span ${s_sty}>${st_obj.price}</span></p>
			    <p style="margin-top:5px;">${st_obj.desc}</span></p>
			    `;
				this.dialog = {
					'show': true,
					'content': str,
					'cancelBtn': true,
					'title': '产品详情',
					'confirmButtonText': '确定'
				};
				this.orderData = {
					'tc':st_obj.cc,
					'yh_tips':st_obj.yh_tips,
					'package':st_obj.package,
					'price':st_obj.price,
					'desc':st_obj.desc,
					'flow_id':st_obj.flow_id,
					'id':st_obj.id,
				}
			  },
		},
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
