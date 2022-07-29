<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="星耀互联 地址：甘肃省天水市张家川回族自治县 主营业务：三网手机话费、三网手机流量、固话宽带、手机号卡、中石化加油卡、中石油加油卡">
    <!--<meta content="width=device-width,user-scalable=no" name="viewport">-->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link href="./favicon.ico" rel="shortcut icon">
    <meta name="keywords" content="星耀互联,卡号分销,张家川县星耀科技工作室,靓号业务,手机话费充值,靓号扫购,靓号扫描">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('home/css/swiper-3.4.2.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('home/css/style.css')); ?>" />
    <script src="https://hm.baidu.com/hm.js?c2558fd55cd2864dc6253eece458afc1" type="text/javascript" charset="utf-8"></script>
    <?php echo $__env->yieldContent('head'); ?>
</head>

<body>
    <div class="head-wrap">
        <div id="header">
            <div class="nav-wrap clear">
                <div class="nav nav-l left">
                    <a class="logo-wrap" href="index.html">
                        <img src="/home/img/logo-black.png" class="logo" alt="星耀互联">
                    </a>
                    <ul class="main-nav">
                        <li class="menu1">
                            <a href="index.html">号卡分销系统</a>
                        </li>
                        <li class="menu1">
                            <a href="store.html">全民分销</a>
                        </li>
                        <!--<li class="menu1">
                            <a href="product.html">号卡产品</a>
                        </li>-->
                        <li class="menu1">
                            <a href="about_us.html">关于星耀</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php echo $__env->yieldContent('content'); ?>
    <div class="foot-wrap">
        <div id="footer">
            <div class="wrap footer-main">
                <img src="/home/img/logo-black.png" class="footer-logo">
                <div class="footer-block clear">
                    <div class="footer-l left">
                        <p class="footer-title">张家川县星耀科技工作室</p>
                        <!-- <div class="code-wrap clear">
                            <div class="left">
                                <p class="code-title">公众号</p>
                                <img src="img/bottom2_img_code1.png" alt="" class="code" />
                            </div>
                            <div class="left" style="margin-left: 7px;">
                                <p class="code-title">小程序</p>
                                <img src="img/bottom2_img_code2.png" alt="" class="code" />
                            </div>
                        </div> -->

                        <div class="address-copyright" style="margin-top: 30px;">
                            <p class="contact-item">甘肃省天水市张家川回族自治县</p>
                            <a class="contact-item beian" target="_blank" rel="noopener noreferrer"
                                href="http://beian.miit.gov.cn" style="display: inline;">CopyRight@版权所有@2021  陇ICP备2021001422号-1</a>
                        </div>
                    </div>
                    <div class="footer-r left">
                        <p class="footer-title">联系我们</p>
                        <div class="contact">
                            <p class="contact-item">
                                <span class="contact-title">商务合作：</span>
                                <img src="/home/img/bottom2_icon_1.png">
                                <span>xingyao_keji@163.com</span>
                            </p>
                            <p class="contact-item">
                                <span class="contact-title">运维支撑：</span>
                                <img src="/home/img/bottom2_icon_2.png">
                                <span>1314 524 5090</span>
                            </p>
                        </div>
                        <!--<div class="footer-text">
					<p>万物连接助手</p>
					<p>从连接人到连接万物</p>
				</div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fix-wrap">
        <div id="fix-menu">
            <div class="fix-menu">
                <div class="fix-menu-item contact-menu">
                    <img class="center menu-icon" src="/home/img/icon_message.png">
                    <div class="contact-box" style="display: none;">
                        <div class="contact-head box">
                            <img class="head-icon left" src="/home/img/icon.png">
                            <span class="left">想了解更多，欢迎咨询：</span>
                            <img src="/home/img/icon_close.png" alt="" class="right close-box">
                        </div>
                        <div class="contact-content box">
                            <img class="icon-phone left" src="/home/img/icon_phone.png">
                            <div class="contact-info">
                                <p class="contact-info-title"><span>13145245090</span><span style="font-size: 14px;"></span></p>
                                <p class="contact-info-tip">您也可以留下联系方式，我们会主动和您联系</p>
                            </div>
                        </div>
                        <div class="contact-bottom">
                            <p class="use-btn3 show-board">预约</p>
                        </div>
                    </div>
                </div>
                <div class="fix-menu-item top-menu">
                    <img class="center menu-icon" src="/home/img/icon_top.png">
                </div>
            </div>
            <div class="cover">
                <div class="order-board center">
                    <div class="board-content box">
                        <img class="close-board" src="/home/img/icon_close2.png">
                        <p class="board-title">立即预约</p>
                        <div class="board-form">
                            <input class="board-input name" placeholder="请输入您的姓名" type="text">
                            <input style="margin-bottom: 16px;" class="board-input number-uncount phone" placeholder="请输入您的联系电话" type="number">
                            <select value="" class="board-input business">
                                <option value="">请选择开通业务</option>
                                <option value="1">靓号业务</option>
                                <option value="2">号卡代理业务</option>
                                <option value="3">分销系统业务</option>
                                <option value="4">其他业务</option>
                            </select>
                            <p class="board-btn order-btn">立即预约</p>
                        </div>
                    </div>
                    <div class="board-content box" style="display: none;">
                        <div class="success-info">
                            <img class="success-icon" src="/home/img/icon_success.png">
                            预约成功
                        </div>
                        <p class="success-tip">我们会安排技术人员与您联络，感谢您的支持</p>
                        <p class="board-btn close-order-board">关闭</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

<script src="/home/js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/home/js/swiper-3.4.2.jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/home/js/common.js" type="text/javascript" charset="utf-8"></script>
<?php echo $__env->yieldContent('script'); ?>
</html>