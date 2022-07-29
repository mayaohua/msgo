<html>
  <head>
    <title>打开小程序</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/2.4.1/weui.min.css"></link>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="<?php echo e(URL::asset('logins/js/jquery.min.js')); ?>"></script>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
    <style>
    .launchBtn{
         width: 100% !important;
        padding: 10px !important;
        background-color: #07c160 !important;
        text-align: center !important;
        border: 0;color: #ffffff !important;
    }
    .title{
        text-align:center;
        padding:10px 0;
    }
    </style>
  </head>
  <body>
    <div id="wechat-web-container" style="width: 100%;height: 100vh;display: flex; align-items: center;justify-content: center;">
      <div id='weixin' style='display:none'>
        <wx-open-launch-weapp id="launch-btn" username="gh_41e4770ea29b" path="/pages/cardscan/index.html">
            <template>
            <style>
            .launchBtn {
                width: 100% !important;
                padding: 12px !important;
                font-size: 30px !important;
                background-color: #07c160 !important;
                text-align: center !important;
                border: 0;color: #ffffff !important;
            }</style>
            <div class="launchBtn" >打开微信小程序</div>
            </template>
        </wx-open-launch-weapp>
      </div>
      <div id='mobile' style='display:none'>
        <div class='title'>正在打开 “靓号扫购”...</div>
        <div class='launchBtn' onclick="h5launchWeapp()">打开微信小程序</div>
      </div>
      <div id='desktop' style='display:none'>
        <div class='title'>请在手机打开网页链接</div>
      </div>
    </div>
    <script type="text/javascript">
          const initDeviceType = () => {
            let ua = navigator.userAgent.toLowerCase()
            let isWXWork = ua.match(/wxwork/i) == 'wxwork' // wxwork 企业微信
            let isWeixin = !isWXWork && ua.match(/micromessenger/i) == 'micromessenger'
            let isMobile = false
            let isDesktop = false
            if (navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|IEMobile)/i)) {
                isMobile = true
            } else {
                isDesktop = true
            }

            if (isWeixin) {
                //$('#weixin').show();
                //this.getWxConfig()
                $('#mobile').show();
                h5launchWeapp()
            } else if (isDesktop) {
                $('#desktop').show();
                console.log('isDesktop')
            } else if (isMobile) {
                $('#mobile').show();
                h5launchWeapp()
            }
          }
        function h5launchWeapp (){
            location.href = 'weixin://dl/business/?t=TVqOQAbsI1r' 
        }
        function getWxConfig(){
            const domainUrl = '<?php echo env("APP_WX_URL"); ?>/api';
            $.ajax({
            url: domainUrl+'/js_config',
            //`公司后端写的 获取wx.config参数接口?appId=公众号的appId&weixinId=要跳转的微信小程序的appId&url=${encodeURIComponent(window.location.href)}`,
            type: 'GET',
            success:function(result){
                wx.config(result.data);
                wx.ready(function () {
                    console.log('config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中')
        
                    var btn = document.getElementById('launch-btn');
                    btn.addEventListener('launch', function (e) {
                        console.log('success');
                        // alert('success')
                    });
                    console.log(btn)
                    btn.addEventListener('error', function (e) {
                        console.log('fail', e.detail);
                        alert('fail', e.detail)
                        // alert('fail', e.detail)
                    });
                });
                wx.error(function (res) {
                    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名
                    console.log(res);
                });
            }});
        }
      $(document).ready(function(){
          initDeviceType();
      });
    </script>
  </body>
</html>