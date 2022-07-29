
<?php $__env->startSection('head'); ?>
<title>联系我们-星耀互联</title>
<style>
    #container{
        display: flex;
        align-items: flex-end;
        justify-content: center;
        height: calc(100vh - 50px);
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <!--URL::asset('images/20210525125456.png')-->
    <img style="width:100%;height: 100%;" src="<?php echo e(URL::asset('images/qq.png')); ?>" alt="">
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    new Vue({
        el:"#app",
        mixins: [HeaderMixin],
        data:{
            
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
<?php echo $__env->make('layouts.card', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>