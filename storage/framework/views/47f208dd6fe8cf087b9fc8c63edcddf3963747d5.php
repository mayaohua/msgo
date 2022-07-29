

<?php $__env->startSection('head'); ?>
<title>我的客户</title>
<style> 
.content{
    padding:10px;
}
.head{
    padding:10px;
}
.item{
    display: flex;
    align-items: center;
    padding:5px 0;
    /* justify-content: space-between; */
}
.item img{
    width: 50px;
    height: 50px;
    margin-right: 20px;
}
.head p{
    font-size: 18px;
}
.item p{
    font-size: 18px;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <div class="head">
    <p>共有{{users.length}}个客户</p>
    </div>
    <div class='content'>
        <div class="item" v-for='item in users'>
            <img :src="item.user_info.headimgurl" alt="">
            <div class="right">
                <p>昵称：{{item.user_info.nickname}}</p>
                <p>订单数：{{item.order_count}}</p>
            </div>
        </div>
    </div>
</div> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            users: <?php echo $users; ?>

        },
        methods: {

        },
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.market', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>