
<?php $__env->startSection('head'); ?>
<title>推广咨询</title>
<style>
.content img{
    width: 100%;
    display:block;
}
.content{
    background: #0e1234;
    height: 100vh;
}
.ql-editor{
    padding: 0 !important;
    display: flex;
    align-items:center;
    justify-content: center;
    background: #0e1234;
    height: 100vh;
}
</style>
<link href="https://cdn.quilljs.com/1.3.4/quill.core.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.4/quill.bubble.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <div class="content ">
        <div class='ql-editor'><?php echo $page_content ? $page_content : ''; ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            
        },
        methods: {
        }
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.market', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>