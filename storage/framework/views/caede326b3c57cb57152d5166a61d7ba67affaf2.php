
<?php $__env->startSection('head'); ?>
<title>流量充值-星耀互联</title>
<style>
    *{
        margin:0;
        padding:0;
    }
    body{
        background:#f0f0f0;
    }
    .content{
        padding-bottom: 50px;
        font-size:16px;
    }
    .ui-content {
		width: 100%;
		margin-bottom: 10px;
        /* margin-top:5px; */
	}
    .van-tab{
        font-size:15px;
    }
    .van-tabs .van-tabs__wrap{
        border-bottom:1px solid #f0f0f0;
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

	.ui-cont div {
		text-align: center;
	}

	.small-desc {
		color: white;
		padding: 1px;
		border-bottom-right-radius: 5px;
		background-color: #1aad19;
		/* line-height: 16px; */
		font-size: 14px;
		display: inline-block;
	}
    .ui-input-wrap{
        margin:0 0 5px 0;
    }
    .ui-input-field{
        display:flex;
        
    }
    .van-dialog__message *{
        line-height:initial;
    }
    .van-dialog__message{
        line-height:initial;
        white-space:unset;
        text-align:left;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <!-- <wx-open-subscribe @success="dds" @error="dds" template="F4X5IgOIqx6OAf7fHuM8dmDZPhARWyVTw-pw1-ZGmdw" id="subscribe-btn">
    <script type="text/wxtag-template">
        <style>
        .subscribe-btn {
            color: #fff;
            background-color: #07c160;
        }
        </style>
    </script>
    <script type="text/wxtag-template">
        <button class="subscribe-btn">
        消息订阅              
        </button>
    </script>
    </wx-open-subscribe>
     -->
    <?php echo $__env->make('wx.bill.swipe', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="content">
        <div class="ui-input-wrap">
            <van-search v-model="input.phone" placeholder="请输入要充值的手机号码" type="number" :auto-focus="input.autoFocus" :focus="input.focus" @input="onInput" @blur="inputBlur" @focus="inputFoucus" placeholder="请输入要充值的手机号码" maxlength="11" @clear="inputClear"></van-search>
        </div>
        <van-tabs v-model="TabCur" >
            <van-tab v-for="(item,index) in list" :key="index" :data-id="index" :title="isp?(isp.province+(isp.city?'-'+isp.city:'')+' ['+isp.sp+']'):item.type_name">
                <div class="ui-content" v-for="(caseitem,caseindex) in item.billcases" :key="caseindex">
                    <div class="ui-title">
                        <div>
                            <span class="cuIcon-title text-green"></span>{{caseitem.case_name}}
                        </div>
                        <div class="ui-info" :data-desc="caseitem.desc_content" @click="xiangqing">详情</div>
                    </div>
                    <div class="ui-items">
                    <div class="ui-item" v-for="(billitem,billindex) in caseitem.bills" :key="billindex"
                        @click="onSellPut" 
                            :data-desc="billitem.order_tips"
                            :data-cc="caseitem.case_name"
                            :data-price="sell_user_key?billitem.sell_data.UserSalePrice:billitem.sell_data.AppSalePrice"
                            :data-package="billitem.package"
                            :data-yh_tips="billitem.yh_tips"
                            :data-id="billitem.id"
                            :data-yj="billitem.sell_data.facePrice"
                            :data-bill_case_id="billitem.bill_case_id">
                            <div class="ui-cont">
                                <div class="small-desc">{{billitem.yh_tips}}</div>
                                <div style="margin:5px 0;">{{billitem.package}}</div>
                                <!-- <div style="margin:0 0 5px;" class="text-red">原价：<span >{{billitem.sell_data.facePrice}}元</span></div> -->
                                <div>售价：{{sell_user_key?billitem.sell_data.UserSalePrice:billitem.sell_data.AppSalePrice}}元</div>
                            </div>
                        </div>
                    </div>
                </div>
            </van-tab>
        </van-tabs>
    </div>
    
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript">
    new Vue({
        el:"#app",
        mixins: [HeaderMixin],
        data:{
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
            list:[],
            sell_user_key:null,
        },
        created() {
			this.init(false)
			let user_key = window.localStorage.getItem('bill_user_key')
            if(!user_key){return;}
            this.api.hasSellUser({user_key:user_key},res => {
                if(res === 1){
                    this.sell_user_key = user_key;
                }
            })

		},
		onReady() {
			
		},
		methods: {
			init(data){
				this.api.getDataList('/bill/flow', data, res => {
                    this.list = res.data.list;
                    this.tempList = this.list;
					this.TabCur = 0;
                    
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
			  onInput(value){
				  this.input.phone = value
			    if(value.length === 11){
					this.input.focus = false
					this.input.autoFocus = false
					this.api.getDataList('/bill/flow',{mobile:value}, res => {
                        if(res.code != 0){
                            this.input.phone = '';
                            this.list = this.tempList;
                        }else{
                            this.list = res.data.list;

                        }
						this.TabCur = 0;
						this.isp = res.data.ips;
					})
			    }else{
			      this.list = this.tempList
				  this.isp = false;
			    }
			  },
			xiangqing(detail) {
                this.$dialog.alert({
                    title: '产品详情',
                    message: detail.target.dataset.desc,
                })
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
            inputFoucus(){
                this.input.focus = true;
				this.input.autoFocus = true;
            },
            inputBlur(){
                this.input.focus = false;
				this.input.autoFocus = false;
            },
			onSellPut(event){
			    if(this.input.phone == null || this.input.phone.length != 11){
			      this.input.focus = true
			      this.input.autoFocus = true
                  message({ type: 'danger', message: '请输入充值号码' })
			      return;
			    }

			    let st_obj = event.currentTarget.dataset;
                st_obj.desc = st_obj.desc ? st_obj.desc.replace(/\[/g,'<i style="color: red;font-style:normal;">').replace(/\]/g,'</i>') : '';
			    let p_sty = 'style="display: flex;justify-content: space-between;margin:2px 0;"'
			    let t_sty = 'style="width:60px;color:#666;"';
			    let s_sty='style="text-align:right;"';
			    var str = `
			    <p ${p_sty}><span ${t_sty}>账户</span><span ${s_sty}>${this.input.phone}</span></p>
			    <p ${p_sty}><span ${t_sty}>套餐</span><span ${s_sty}>${st_obj.cc}（${st_obj.package}）</span></p>
			    <p ${p_sty}><span ${t_sty}>时效</span><span ${s_sty}>${st_obj.yh_tips}</span></p>
			    <p ${p_sty}><span ${t_sty}>售价</span><span ${s_sty}>${st_obj.price}元</span></p>
			    <p style="margin-top:5px;">${st_obj.desc}</span></p>
			    `;
				this.$dialog.confirm({
                    title: '确认订单信息',
                    confirmButtonText:'确认下单',
                    message: str,
                }).then(() => {
                    this.orderData = {
                        'mobile':this.input.phone,
                        'id':st_obj.id,
                        'isp':this.isp,
                        'type':'flow',
                        'desc':$(str).text(),
                        'user_key':this.sell_user_key
                    }
                    var that = this;
                    this.api.wxPay(this.orderData, res => {
                        if(res.code != 0){
                            message({ type: 'danger', message: res.msg })
                        }else{
                            var data = res.data.json;
                            var req_data = {order_id : res.data.order_id}
                            data.success = function(){
                                message({ type: 'success', message: '充值成功' })
                                window.location.href="/bill/record/"
                            }
                            data.cancel = function(){
                                message({ type: 'danger', message: '充值取消' })
                                that.api.cancelPay(req_data)
                            }
                            data.fail = function(){
                                message({ type: 'danger', message: '充值失败' })
                                that.api.payFail(req_data)
                            }
                            wx.chooseWXPay(data);
                        }
						
					})
                })
				
			  },
              dds:function(){

              }
		}
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bill', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>