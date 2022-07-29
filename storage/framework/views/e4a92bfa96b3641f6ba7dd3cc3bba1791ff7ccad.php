
<?php $__env->startSection('head'); ?>
<title>请先关注公众号</title>
<style>
    *{
        margin:0;
        padding:0;
    }
    img{
        width:80%;
    }
    #container{
        height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        flex-direction: column;
        
    }
    p{
        text-align:center;
        margin-top:20px;
        font-size: 20px;
        color:#666;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <img src='/images/qrcode_for_gh_0d3b69ccb119_258.jpg'/>
    <p>长按关注公众号</p>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            active: 0,
            static_domain:"<?php echo e(env('STATIC_DOMAIN')); ?>",
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
<?php echo $__env->make('layouts.market', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>