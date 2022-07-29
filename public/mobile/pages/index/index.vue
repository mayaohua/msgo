<template>
	<view class="content">
		<view class="items">
			<view class="item" v-for="(item,index) in dataList" @tap="toDetails(item,index)" :key="index">
				<image class="item-thum" :src="item.thum_img?lt.img_url+item.thum_img:'../../static/logo.png'"></image>
				<view class="item-text">
					<text class="item-title">{{item.cards_name}}</text>
					<text class="item-desc">{{item.cards_desc?item.cards_desc:'测试'}}</text>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import Api from '../../until/api.js'
	import {lotusAddressJson} from '../../components/Winglau14-lotusAddress/Winglau14-lotusAddress.js'
	export default {
		data() {
			return {
				dataList:[],
				lt:{
					img_url:'https://res.mall.10010.cn/mall/scaffold-img',
					detail_url:'https://m.10010.com/decoration-data/scaffold/queryPagealiasProData?page_alias=',
				}
			}
		},
		onLoad() {
			
			this.getCardList();
			// console.log(Api)
		},
		methods: {
			getCardList(){
				let that = this;
				uni.request({
					url: Api.Host+'mobile/list',
					success: function(res) {
						if(res.data.code == 0){
							that.dataList = res.data.data
						}
					}
				});
			},
			toDetails(item,index){
				let url = '/pages/details/details_2?index='+index
				if(item.page_jian){
					url = '/pages/details/details?index='+index
				}
				// console.log(url)
				uni.navigateTo({
				    url: url
				});
			}
		}
	}
</script>

<style>
	.items{
		display: flex;
		flex-direction: column;
		margin: 20rpx 30rpx;
	}
	.item{
		display: flex;
		padding: 20rpx;
		background: #F1F1F1;
		border-radius: 10rpx;
		margin-top: 20rpx;
	}
	.item .item-thum{
		width: 100rpx;
		height: 100rpx;
		border-radius: 10rpx;
	}
	.item-text{
		display: flex;
		flex-direction: column;
		margin-left: 20rpx;
		justify-content: center;
		flex: 1;
	}
	.item-title{
		color: #000000;
		font-weight: bold;
	}
	.item-desc{
		margin-top: 5rpx;
		color: #666;
		font-size: 26rpx;
	}
</style>
