
<?php $__env->startSection('head'); ?>
<title>充值记录-星耀互联</title>
<style>
    *{
        margin:0;
        padding:0;
    }
    body{
        background:#f0f0f0;
    }
    .content{
		padding: 0 10px;
        padding-bottom: 50px;
        font-size:16px;
		margin-top:10px;
    }
  	.ui-content {
		width: 100%;
		margin-bottom: 10px;
        /* margin-top:5px; */
	}
    .custom-image .van-empty__image {
		width: 90px;
		height: 90px;
	}
    .van-dialog__message *{
        line-height:initial;
    }
    .van-dialog__message{
        line-height:initial;
        white-space:unset;
        text-align:left;
    }
	.van-panel__header-value{
		flex: inherit;
	}
	.ui-panel-content{
		padding:10px;
		font-size:14px;
		color:#969799;
		padding-bottom:0;
	}
	.van-panel{
		margin-bottom:10px;
	}
	.ui-item{
		display:flex;
		margin:5px;
		align-items: center;
    	/* justify-content: space-between; */
	}
	.ui-item-title{
		/* font-weight:bold; */
		width:70px;
	}
	.ui-item-text{
		flex:1;
	}
	.van-cell__title_my span{
		font-size: 16px;
    	font-weight: bold;
	}
	.ui-panel-content .ui-item span{
		font-size:14px;
	}
	.success{
		border:0.5px solid #07c160;
		color:#07c160;
		padding:0 4px;
		display:block;
		border-radius: 4px;
	}
	.fail{
		border:0.5px solid #ee0a24;
		color:#ee0a24;
		padding:0 4px;
		display:block;
		border-radius: 4px;
	}
	.primary{
		border:0.5px solid #1989fa;
		color:#1989fa;
		padding:0 4px;
		display:block;
		border-radius: 4px;
	}
	 .error-page{
		display: flex;
		align-items: start;
		justify-content: center;
		height: calc(100vh - 50px);
	} 
	.notice-swipe {
		height: 40px;
		line-height: 40px;
	}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
	<div>
		<van-notice-bar
		left-icon="volume-o"
		text="充值有延迟，请耐心等待哦，如订单有问题，点击下面订单编号复制订单号之后找客服进行处理，更多福利请关注公众号‘星耀互联’"
		/>
	</div>
    <div class="content"> 
		<van-pull-refresh 
		v-model="refreshing"
		success-text="加载完毕"
		@refresh="onRefresh">
		<div v-show="list.length == 0" class="error-page">
		<van-empty
			class="custom-image"
			image="https://img01.yzcdn.cn/vant/custom-empty-image.png"
			description="暂无充值记录，下拉刷新"
			/>
		</div>
		<van-list
			v-show="list.length>0" 
			v-model="loading"
			:finished="finished"
			finished-text="没有更多了"
			@load="init"
		>
			<van-panel v-for="(item,index) in list" :key="index" >
				<div class="ui-panel-content">
					<div class="ui-item">
						<span class="ui-item-title">充值号码：</span>
						<span class="ui-item-text">{{item.bill_mobile}}</span>
					</div>
					<div class="ui-item">
						<span class="ui-item-title">订单备注：</span>
						<span class="ui-item-text">{{item.bill_type_text}}</span>
					</div>
					
					<div class="ui-item" @click="createCopy(item.bill_app_order_id)">
						<span class="ui-item-title">订单编号：</span>
						<span class="ui-item-text">{{item.bill_app_order_id}}</span>
					</div>
					<div class="ui-item" v-if="item.bill_msg">
						<span class="ui-item-title">失败原因：</span>
						<span class="ui-item-text" style="color:#ee0a24;">{{item.bill_msg}}</span>
					</div>
					<div class="ui-item">
						<span class="ui-item-title">提交时间：</span>
						<span class="ui-item-text">{{item.created_at}}</span>
					</div>
					<div v-if="statusData(item).finish" class="ui-item">
						<span class="ui-item-title">完成时间：</span>
						<span class="ui-item-text">{{item.finished_at}}</span>
					</div>
					<div style="height:20px;"></div>
					<!-- <div class="ui-item">
						<van-cell style="padding: 5px 0;border-top: 1px solid #ebedf0;margin-top:-10px;" title="查看详情" is-link />
					</div>  -->
				</div>
				<template #header>
					<div class="van-cell van-panel__header">
						<div class="van-cell__title van-cell__title_my">
								<span>{{item.bill_type_name}}</span>
								<!-- <div class="van-cell__label">{{item.bill_type_text}}</div> -->
						</div>
						<div class="van-cell__value van-panel__header-value">
							<span :class="statusData(item).class_name">{{statusData(item).status_name}}</span>
						</div>
					</div>
				</template>
			</van-panel>
		</van-list>
		</van-pull-refresh>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="https://cdn.bootcdn.net/ajax/libs/vue-clipboard2/0.3.1/vue-clipboard.min.js"></script>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            list:[],
            loading: false,
			finished: false,
			refreshing: false,
			page:1,
        },
		computed:{
			statusData() {
				return function (item) {
					var class_name = '',status_name = '',finish=false;
					if(item.bill_status == 0){
						status_name = '支付核验中';
						class_name = 'primary';
						finish = false;
					}else if(item.bill_status == 1){
						status_name = '等待充值';
						class_name = 'primary';
					}else if(item.bill_status == 2){
						status_name = '支付失败';
						class_name = 'fail';
						finish = true;
					}else if(item.bill_status == 5){
						status_name = '充值中';
						class_name = 'primary';
					}else if(item.bill_status == 3){
						status_name = '充值成功';
						class_name = 'success';
						finish = true;
					}else if(item.bill_status == 4){
						status_name = '充值失败';
						class_name = 'fail';
					}else if(item.bill_status == 6){
						status_name = '正在退款';
						class_name = 'primary';
					}else if(item.bill_status == 7){
						status_name = '退款完成';
						class_name = 'success';
						finish = true;
					}else if(item.bill_status == 8){
						status_name = '退款失败';
						class_name = 'fail';
						finish = true;
					}else if(item.bill_status == 9){
						status_name = '异常订单';
						class_name = 'fail';
						finish = true;
					}else{
						status_name = '异常订单';
						class_name = 'fail';
						finish = true;
					}
					return {status_name,class_name,finish}
				}
			}
		},
        created() {
			this.onRefresh();
		},
		onReady() {

		},
		methods: {
			onRefresh() {
				// 清空列表数据
				this.finished = false;
				// 重新加载数据
				// 将 loading 设置为 true，表示处于加载状态
				this.loading = true;
				this.init();
			},
			init(){
				if (this.refreshing) {
					this.page=1;
				}
				this.api.getOrderList({
					page:this.page
				}, res => {
					if (this.refreshing) {
						this.list = [];
						this.refreshing = false;
					}
					this.list = this.list.concat(res.data.data);
					this.loading = false;
					this.page++;
					if (res.data.next_page_url == null) {
						this.finished = true;
					}
				});
				
			},
			createCopy(orderid){
				this.$copyText(orderid).then(function (e) {
					message({ type: 'success', message: '订单号已复制' })
				}, function (e) {
					message({ type: 'danger', message: '复制失败' })
				})  
			},
		}
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bill', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>