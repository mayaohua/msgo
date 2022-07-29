
<?php $__env->startSection('head'); ?>
<title>收益记录</title>
<style>
.user{
    display: flex;
    margin: 20px;
}
.user-left{
    width: 50px;
    height: 50px;
    border-radius: 100%;
    margin-right: 20px;
}
.user-right{
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
}
.user-right p span{
    background: orange;
    color: white;
    border-radius: 4px;
    padding: 0px 8px;
    font-size: 12px;
}
.user-right h1{
    display: flex;
    align-items: center;
    font-size: 16px;
}
.user-right h1 span{
    font-size: 16px;
    font-weight: bold;
}
.user-right h1 img{
    height: 16px;
    margin-left: 10px;
}
.user-money{
    background: #fb7e09;
    border-radius: 4px;
    margin: 10px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    flex-direction: column;
    padding: 20px 0;
}
.user-money .mobney-text{
    color: white;
}
.user-money .mobney{
    font-size: 24px;
    color: white;
    margin: 10px 0;
    font-weight: bold;
}
.user-money .money-right span{
    display: block;
    color: #fb7e09;
    background: yellow;
    padding: 8px 20px;
    border-radius: 22px;
}
.user-shuju{
    display: flex;
    margin: 10px;
    justify-content: space-around;
}
.shuju-item{
    display: flex;
    flex-direction: column;
    align-items: center;
    
}
.shuju-price{
    font-size: 16px;
    font-weight: bold;
}
.shuju-name{
    font-size: 12px;
    color: #999;
    margin-top: 5px;
}
.mint-swipe-item img{
    width: 100%;
    height: 100%;
}
.wenti p{
    color: #999;
    font-size: 12px;
    margin: 5px 0;
}
.lll .mobney-text{
    font-size: 12px;
    color: white;
}
.lll .mobney{
    font-size: 20px;
    color: white;
    
}
.sb{
    margin-left: 20px;
}
.tips{
    margin: 10px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size:14px;
    color: #333;
}
.user-top{
    background: white;
}
.jilu{
    margin: 10px;
    padding:0 10px;
}
.jilu-item{
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #fcdcfc;
    padding: 10px 0;
}
.jilu-left{
    font-size: 12px;
    color: #666;
    flex: 1;
}
.jilu-left h1{
    font-size: 14px;
    margin: 2px 0;
    color:#666;
}
.jilu-right{
    width: 80px;
}
.jilu-right h1{
    color: #fb7e09;
    font-weight: bold;
    font-size: 18px;
    
    text-align: center;
}
.jilu-right .gray{
    color: #ccc;
}
.jilu-right .red{
    color: red;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <div class="user-top">
        <div class="user-money">
            <div style="display: flex;justify-content: space-between;width: 100%;">
                <div class="money-left sb">
                    <p class="mobney-text">可提现金额（元）</p>
                    <p class="mobney">{{user_money}}</p>
                </div>
                <div class="money-right" style="margin-right: 10px;">
                    <span @click="goto('/market/tixian')">立即提现</span>
                </div>
            </div>
            <div style="display: flex;
            align-items: center;width: 100%;">
            <div class="money-left lll sb">
                <p class="mobney-text">累计提现（元）</p>
                <p class="mobney">{{user_tixian_money}}</p>
            </div>
            <div class="money-left lll sb">
                <p class="mobney-text">提现审核中（元）</p>
                <p class="mobney">{{user_dongjie_money}}</p>
            </div>
            </div>
        </div>
        
    </div>
    <div class="jilu">
        <div class="tips">
            <span>收益记录</span>
            <span>历史总收益：{{Number(user_money)+Number(user_tixian_money)+Number(user_dongjie_money)}}元</span>
        </div>
        <div class="jilu-item" v-for="item in profitItems">
            <div class="jilu-left">
                <h1>任务名称：{{item.order_type == 'bill' ?'充值':'卡号'}}返佣（佣金{{item.order_money}}元）</h1>
                <h1>任务编号：{{item.order_uuid}}</h1>
                <h1>任务说明：{{item.order_name}}</h1>
                <h1>发放时间：{{item.created_at}}</h1>
            </div>
            <div class="jilu-right">
                <h1>+{{item.order_money}}元</h1>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="/smarket/js/jquery-1.11.2.min.js"></script>
<script src="/smarket/js/jqueryqr.js"></script>
<script src="/smarket/js/qrcode.js"></script>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            user_money: "<?php echo e($user_money); ?>",
            user_tixian_money: "<?php echo e($user_tixian_money); ?>",
            user_dongjie_money: "<?php echo e($user_dongjie_money); ?>",
            profitItems: <?php echo $profitItems; ?>,
        },
        methods: {
            goto:function(url){
                window.location.href= url
            },
        },
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.market', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>