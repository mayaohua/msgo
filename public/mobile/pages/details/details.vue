<template>
	<view class="content" v-if="data.lt_data" :style="{'background-color':data.lt_data.page_bg.page_color}">
		<view class="top-img" >
			<image v-for="(item,index) in data.lt_data.top_img_detail.images" class="detail-img" mode="widthFix" :src="lt.img_url+item.image_url" :key="index"></image>
		</view>
		<view class="ui-swp">
			<view class="swp-wrap" :style="syncSwpStyle">
				<curry-swiper
				  :width="195"
				  :space="100"
				  :inverseScaling="300"
				  :height="130"
				  :perspective="14"
				  :border="3"
				  :count="switchArr.length"
				  
				  ref="swiper"
				>
				  <curry-slide v-for="(slide, i) in switchArr" :index="i" :key="i" :data-index="i" :data-goodsId="slide.productId" :data-productName="data.cards_name+'-'+slide.productName" :data-zifei="slide.is_package">
				    <template slot-scope="{ index, isCurrent, leftIndex, rightIndex,slideStyle }">
					  <img
					    :data-index="index"
						style="width: 100%;"
					    :class="{ current: isCurrent, onLeft: (leftIndex >= 0), onRight: (rightIndex >= 0) }"
					    :src="lt.img_url+slide.image" />
				    </template>
				  </curry-slide>
				</curry-swiper>
			</view>
		</view>
		<view class="ui-action">
			<view class="btn-wrapper" :style="syncBtnWrapStyle">
				<view :style="syncBtnStyle" @tap="goToOrder"></view>
			</view>
		</view>
		<view class="det-img" >
			<image  v-for="(item,index) in data.lt_data.detail_img_detail.images" class="detail-img" mode="widthFix" :src="lt.img_url+item.image_url" :key="index"></image>
		</view> 
	</view>
</template>

<script>
	import Api from '../../until/api.js'
	import currySwiper from '@/components/curry-swiper/curry-swiper.vue';
	import currySlide from '@/components/curry-swiper/curry-slide.vue';
	export default {
		data() {
			return {
				data:{
					lt_data:null
				},
				lt:{
					img_url:'https://res.mall.10010.cn/mall/scaffold-img',
					detail_url:'https://m.10010.com/decoration-data/scaffold/queryPagealiasProData?page_alias=',
				},
				switchArr:null
			}
		},
		components: {
			currySwiper,
			currySlide
		},
		onLoad(e) {
			let index = e.index;
			if(index == undefined){
				index = 6
			}
			this.$nextTick(n=>{
				this.getDetails(index);
			})
		},
		computed: {
			syncBtnStyle(){
				let data = this.data.lt_data.button_detail[0];
				let sty = {
					'display': 'inline-block',
					'width': data.button_width/16 +'rem',
					'height': data.button_height/16+'rem',
					'font-size': data.button_font_size/16+'rem',
					'border-radius':data.button_radius/16+'rem',
					'background':'url("'+this.lt.img_url+data.button_bg_url+'") 0% 0% / 100% 100%'
				}
				// console.log(sty)
				return sty
			},
			syncBtnWrapStyle(){
				let data = this.data.lt_data.button_detail[0];
				let sty = {
					'margin-top':data.btn_margin_top/16 +'rem',
					'margin-bottom':data.btn_margin_bottom/16 +'rem',
					'margin-left':data.btn_margin_left/16 +'rem',
				}
				return sty
			},
			syncSwpStyle(){
				let data = this.data.lt_data.sim_Slide;
				if(data.length == 0){
					data = this.data.lt_data.sim_Image;
				}
				return {
					'margin-top':data.productPosition/16 +'rem'
				}
			}
			
		},
		methods: {
			getDetails(index){
				let that = this;
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
						}else{
							uni.showToast({
								title: '获取套餐失败，请稍后重试',
								icon:'none',
								duration: 2000
							});
						}
					},
					fail:function(){
						uni.showToast({
							title: '获取套餐失败，请稍后重试',
							icon:'none',
							duration: 2000
						});
					}
				});
			},
			goToOrder(){
				var imgData = this.$refs.swiper.$el.querySelector('.current')
				let pn = imgData.dataset.productname
				let pid = imgData.dataset.goodsid
				let zifei = imgData.dataset.is_package == null ? false: true;
				let url ='/pages/order/order?pn='+pn+'&pid='+pid+'&zifei='+zifei
				console.log(url)
				uni.navigateTo({
				    url: url
				});
			},
		}
	}
</script>

<style>
	.detail-img{
		width: 100%;
		margin: 0;
		padding:0;
		display: block;
	}
	.swp-wrap{
		padding: .3rem 1.2rem;
		position: relative;
		max-width: 40rem;
		margin: 0 auto;
	}
	.btn-wrapper{
		padding:10px 0;
		text-align: center;
		position: relative;
		z-index: 1;
	}
</style>
