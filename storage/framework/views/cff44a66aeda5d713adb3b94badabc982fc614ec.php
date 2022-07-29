
<?php $__env->startSection('head'); ?>
<title>关于我们-星耀互联</title>
<link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('home/css/aboutUs.css')); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="banner banner-about">
        <div class="wrap">
            <div class="banner-inner">
                <div class="banner-text-wrap">
                    <p class="banner-title banner-text-space">万物连接助手</p>
                    <p class="banner-desc banner-desc-en">ALL THINGS CAN BE CONNECTED</p>	
                </div>
                
            </div>
        </div>
    </div>
    <section class="about-main clear">
        <div class="about-item">
            <p class="about-item-title">01丨倡导更为便捷的通信连接方式</p>
            <p class="about-item-text" style="margin-top: 54px;">张家川县星耀科技工作室致力于用技术与创新力为国内中小企业带来赋能，公司以“5G+数字营销”为主旨理念，以广告服务、数字产品分发、SAAS服务平台、号卡分销平台为基础围绕企业需求提供安全可靠的技术支撑服务。</p>
        </div>
        <div class="about-item" style="width: 280px;">
            <p class="about-item-title">02丨使命</p>
            <p class="about-item-text">为客户、员工及股东创造价值。</p>
        </div>
        <div class="about-item" style="width: 240px;">
            <p class="about-item-title">03丨愿景</p>
            <p class="about-item-text">成为5G营销行业标杆企业。</p>
        </div>
    </section>
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>