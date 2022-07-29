
<?php $__env->startSection('head'); ?>
<title>个人中心-星耀互联</title>
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
    #container{
        box-sizing: border-box;
        overflow-x: hidden;
        min-height: 100vh;
        background: #f2f2f2;
    }
    #container .info {
        display: flex;
        align-items: center;
        background: #fff;
        padding-bottom: 20px;
        padding-top: 60px;
    }
    #container .info .img {
        background: #f2f2f2;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-right: 20px;
        overflow: hidden;
        margin-left: 20px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
    }
    #container .info .img  img{
        width:100%;
        height:100%;
        display:block;
    }
    #container .info .nickname{
        font-size:20px;
    }
    .items{
        display: flex;
        flex-direction: column;
        background:white;
        margin: 20px 10px;
        border-radius: 10px;
    }
    .item a{
        padding:20px 20px;
        border-bottom: 1px solid #f2f2f2;
        color: #444;
        display: flex;
        align-items: center;
    }
    .item a span{
        font-size:18px;
    }
    .item img{
        width: 30px;
        height: 30px;
        margin-right: 10px;
    }
    #container{
        margin-bottom:50px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <div class="info">
        <div class="img" >
            <img :src="user.headimgurl" alt="">
        </div>
        <div class="nickname">{{user.nickname}}</div>
    </div>
    <div class="items">
        <div  class="item">
            <a href="/bill/record">
                <img src="<?php echo e(URL::asset('images/order.png')); ?>">
                <span>充值记录</span>
            </a>
        </div>
        <div class="item">
           <a href="/card/">
                <img src="<?php echo e(URL::asset('images/002_rili.png')); ?>">
                <span>靓卡领取</span>
           </a>
        </div>
        
        <div class="item">
            <a href="/bill/question">
                <img src="<?php echo e(URL::asset('images/002_info.png')); ?>">
                <span>反馈建议</span>
            </a>
        </div> 
        <div class="item">
            <a href="/bill/us">
                <img src="<?php echo e(URL::asset('images/help.png')); ?>">
                <span>联系我们</span>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript">
    new Vue({
        el:"#app",
        mixins: [HeaderMixin],
        data:{
            user:<?php echo $user; ?>

        },
		computed:{
			
		},
        created() {
            
		},
		onReady() {

		},
		methods: {
			
		}
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bill', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>