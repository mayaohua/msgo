<?php $__env->startSection('title'); ?>
<?php echo e(env('APP_NAME')); ?>登录
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
<style>
    .error{
       position:fixed;
       left: 0;
       top: 0px; 
       width: 100%;

    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <div class="error"> 
        <?php if($errors->has('email')): ?>
            <el-alert title="<?php echo e($errors->first('email')); ?>" type="error"> </el-alert>
        <?php endif; ?>
        <?php if($errors->has('name')): ?>
            <el-alert title="<?php echo e($errors->first('name')); ?>" type="error"> </el-alert>
        <?php endif; ?>
        <?php if($errors->has('password')): ?>
            <el-alert title="<?php echo e($errors->first('password')); ?>" type="error"> </el-alert>
        <?php endif; ?>
    </div>
	<div id="output">
		<div class="containerT">
			<h1><?php echo e(env('APP_NAME')); ?>登录</h1>
            <form class="form" id="entry_form" method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo e(csrf_field()); ?>

                <input id="name" placeholder="请输入邮箱/用户名" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
				<input id="password" placeholder="请输入密码" type="password" class="form-control" name="password" required>
                <div style="display: none">
                    <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : 'checked'); ?>> 记住我
                </div>
                <button id="entry_btn" type="submit">登录</button>
				<div id="prompt" class="prompt"></div>
			</form>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script type="text/javascript">
$(function(){
    Victor("container", "output");  
    $("#entry_name").focus();
});
</script>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            
        },
        methods: {
            
        },
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>