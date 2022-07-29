

<?php $__env->startSection('head'); ?>
<title>推广中心</title>
<style>
    .huizong{
        /* height:60px; */
        margin:0 5px;
        margin-bottom:10px;
    }
    .huizong img{
        width:100%;
        height:100%;
        border-radius:4px;
    }
    .gonggao{
        padding:15px 10px;
        border-bottom:1px solid #e8e7e7;
    }
    .content{
        height: calc(100vh - 55px);
        overflow: auto;
    }
    .tableList{
        padding:0 5px;
    }
    .tableList .mint-tab-item-label{
        font-size:14px;
    }
    .item-left{
        width:80px;
        height:80px;
    }
    .item-right{
        margin-left: 10px;
        color:#888;
        flex:1;
        position: relative;
    }
    .item{
        padding: 10px;
        display: flex;
        border-bottom: 1px solid #e8e7e7;
        align-items: center;
    }
    .item-right h1{
        font-size:16px;
        color:#000;
    }
    .item-right span{
        color:red;
    }
    .item-right i{
        position: absolute;
        top:0;
        right:0;
        background: darkorange;
        color: white;
        padding: 5px 15px;
        border-radius: 4px;
    }
    .tuiguang{
        position:fixed;
        top:0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 5;
    }
    .mint-indicator-mask,.mint-indicator-wrapper{
        z-index: 9;
    }
    .tuiguang .center{
        width: 80%;
        overflow-y: auto;
        background: white;
        border-radius: 4px;
    }
    .tuiguang .close{
        color: white;
        border-radius: 100%;
        border: 2px solid white;
        line-height: 25px;
        height: 25px;
        width: 25px;
        text-align: center;
        margin-top: 10px;
    }
    .center .showimg{
        width: 100%;
        
    }
    .haiba{
        text-align: center;
    }
    .copytext{
        border:1px solid orange;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cotyleft{
        flex: 1;
        white-space: nowrap; 
        overflow: hidden;
        text-overflow:inherit;
        padding:0 5px;
    }
    .copyright{
        background: orange;
        color: white;
        padding: 5px 20px;
        font-size: 16px;
    }
    .haiba{
        background: orange;
        color: white;
        padding: 10px;
        font-size: 16px;
        border-radius: 4px;
        margin: 15px 0;
    }
    .bill_item{
        padding:8px 0 8px 5px;
        border:1px solid #1aad19;
        border-radius: 4px;
        /* margin:2px 0; */
    }
    .bill_items{
        /* margin: 0 10px; */
        display: grid;
        grid-template-columns: auto auto auto;
        grid-template-rows: auto auto auto;
        width: 100%;
    }
    .bill_item{
        display: flex;
        flex-direction: column;
        justify-content: center;
        transform: scale(0.95);
    }
    .bill_item span{
        font-size: 14px;
        display:block;
        color: #666;
        
        margin:1px 4px;
    }
    .bill_item .bill_title{
        margin-bottom:5px;
        font-size:16px;
        text-align:center;
        color: #1aad19;
    }
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
    .user-right .div-right{
        display: flex;
        align-items: center;
        font-size: 16px;
    }
    .user-right .div-right span{
        font-size: 16px;
        font-weight: bold;
    }
    .user-right .div-right img{
        height: 16px;
        margin-left: 10px;
    }
    .user-money{
        background: #fb7e09;
        height: 100px;
        border-radius: 4px;
        margin: 0 10px;
        display: flex;
        align-items: center;
        justify-content: space-around;
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
    .case_name .mint-cell-title{
        text-align:center;
    }
    .user-right .div-right .user_vip img{
        height: 10px;
        vertical-align: middle;
        margin-left: 0;
    }
    .user_vip em{
        font-size:10px;
        margin-left: 4px;
        vertical-align: middle;
    }
    .user_vip{
        background: #f8e7dc;
        color: #ff7900;
        padding:2px 4px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        /* height: 12px; */
        margin-left: 10px;

    }
    .user_error{
        margin-left: 10px;
        padding:2px 4px;
        font-size:10px;
        color: red;
    }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <div class="content">
        <div v-if="selected == '推广'">
            
            <mt-swipe :show-indicators="false" :auto="4000" style="height:180px;">
                <mt-swipe-item v-for='item in sell_form.bannerList'><img :src="item.src" alt=""></mt-swipe-item>
            </mt-swipe>
            
            <div class="gonggao">
            {{sell_form.indexMsg}}
            </div>
            
            <div class="huizong">
                <img src="/smarket/images/huizong1.png?a=1" @click="tuiguang()"/>
            </div>
            
            <mt-cell title=" 合作推广" style="border-bottom:1px solid #e8e8e8">
                <span>永久收益</span>
                <img slot="icon" style="background: orange;
                border-radius: 100%;" src="/smarket/images/gg.png" width="17" height="17">
            </mt-cell>

            <mt-navbar v-model="case_selected" class="tableList">
                <mt-tab-item id="1">卡号推广</mt-tab-item>
                <mt-tab-item id="2">话费充值</mt-tab-item>
                <mt-tab-item id="3">流量充值</mt-tab-item>
                <mt-tab-item id="4">会员充值</mt-tab-item>
            </mt-navbar>

            <!-- tab-container -->
            <mt-tab-container v-model="case_selected">
                <mt-tab-container-item id="1">
                    <div class="item" v-for="item in card_items">
                        <img class="item-left" :src="item.sell_item_img?item.sell_item_img:sell_form.cardImg">
                        <div class="item-right">
                            <h1>{{item.case_name}}</h1>
                            <h2>佣金：<span>{{item.sell_price}}<span></h2>
                            <p>完成条件：{{item.sell_factor}}</p>
                            <i class="btn" @click="tuiguang(item)">立即推广</i>
                        </div>
                        
                    </div>
                </mt-tab-container-item>
                <mt-tab-container-item id="2" >
                    <p class="haiba" style="margin:10px;" @click="tuiguang(sell_bill_huafei)">话费充值推广链接</p>
                    <div style="margin-top: 5px;" v-for="item in bill_items" v-if='item.type_where=="huafei"'>
                        <mt-cell class="type_name" :title="item.type_name+(item.type_where=='huafei'?'话费':(item.type_where=='flow'?'流量':''))+'推广利润'" :value="(item.type_where=='huafei'?'话费':(item.type_where=='flow'?'流量':'会员/卡券'))+'充值'"></mt-cell>
                        <div v-for="v in item.billcases" style="margin:5px 10px;">
                            <mt-cell class="case_name" :title="v.case_name"></mt-cell>
                            <div class="bill_items" >
                                <div class="bill_item" v-for="n in v.bills">
                                    <span class="bill_title">{{item.type_where == 'huafei'?'面值':''}}{{n.package}}</span>
                                    <!-- <span v-if="item.type_where != 'huafei'" style="color: red;text-decoration:line-through;">原价：{{n.itemFacePrice/1000}}元</span> -->
                                    <span>售价：{{n.sell_data.UserSalePrice}}元</span>
                                    <span>利润：<i style="color: red;">{{n.sell_data.UserFreePrice}}元</i></span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </mt-tab-container-item>
                <mt-tab-container-item id="3">
                    <p class="haiba" style="margin:10px;" @click="tuiguang(sell_bill_flow)">流量充值推广链接</p>
                    <div style="margin-top: 5px;" v-for="item in bill_items" v-if='item.type_where=="flow"'>
                        <mt-cell class="type_name" :title="item.type_name+(item.type_where=='huafei'?'话费':(item.type_where=='flow'?'流量':''))+'推广利润'" :value="(item.type_where=='huafei'?'话费':(item.type_where=='flow'?'流量':'会员/卡券'))+'充值'"></mt-cell>
                        <div v-for="v in item.billcases" style="margin:5px 10px;">
                            <mt-cell class="case_name" :title="v.case_name"></mt-cell>
                            <div class="bill_items" >
                                <div class="bill_item" v-for="n in v.bills">
                                    <span class="bill_title">{{item.type_where == 'huafei'?'面值':''}}{{n.package}}</span>
                                    <!-- <span v-if="item.type_where != 'huafei'" style="color: red;text-decoration:line-through;">原价：{{n.itemFacePrice/1000}}元</span> -->
                                    <span>售价：{{n.sell_data.UserSalePrice}}元</span>
                                    <span>利润：<i style="color: red;">{{n.sell_data.UserFreePrice}}元</i></span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </mt-tab-container-item>
                <mt-tab-container-item id="4" >
                    <p class="haiba" style="margin:10px;" @click="tuiguang(sell_bill_vip)">视频会员充值推广链接</p>
                    <div style="margin-top: 5px;" v-for="item in bill_items" v-if='item.type_where=="card_vip"'>
                        <mt-cell class="type_name" :title="item.type_name+(item.type_where=='huafei'?'话费':(item.type_where=='flow'?'流量':''))+'推广利润'" :value="(item.type_where=='huafei'?'话费':(item.type_where=='flow'?'流量':'会员/卡券'))+'充值'"></mt-cell>
                        <div v-for="v in item.billcases" style="margin:5px 10px;">
                            <mt-cell class="case_name" :title="v.case_name"></mt-cell>
                            <div class="bill_items" >
                                <div class="bill_item" v-for="n in v.bills">
                                    <span class="bill_title">{{item.type_where == 'huafei'?'面值':''}}{{n.package}}</span>
                                    <!-- <span v-if="item.type_where != 'huafei'" style="color: red;text-decoration:line-through;">原价：{{n.itemFacePrice/1000}}元</span> -->
                                    <span>售价：{{n.sell_data.UserSalePrice}}元</span>
                                    <span>利润：<i style="color: red;">{{n.sell_data.UserFreePrice}}元</i></span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </mt-tab-container-item>
            </mt-tab-container>
        </div>
        <div v-else>
            <div class="user-top">
                <div class="user">
                    <img class="user-left" :src="user_info.headimgurl" alt="">
                    <div class="user-right">
                        <div class="div-right">
                            <span>{{user_info.nickname}}</span>
                            <!-- <img src="/smarket/images/hhr.png" alt=""> -->
                            <div class="user_vip">
                                <img src="/smarket/images/hg.png" alt="">
                                <em>星耀合伙人</em>
                            </div> 
                            <div class="user_error" v-if="user_status != 1">账户异常</div>
                        </div>
                        <p @click="copy(user_key)"><span>推广码：{{user_key}}</span></p>
                    </div>
                </div>
                <div class="user-money">
                    <div class="money-left">
                        <p class="mobney-text">可提现金额（元）</p>
                        <p class="mobney">{{user_money}}</p>
                    </div>
                    <div class="money-right">
                        <span @click="goto('/market/tixian')">立即提现</span>
                    </div>
                </div>
            </div>
            <div class="user-shuju">
                <div class="shuju-item" @click="goto('/market/shouyi')">
                    <span class="shuju-price">{{Number(user_money)+Number(user_tixian_money)+Number(user_dongjie_money)}}</span>
                    <span class="shuju-name">累计收益（元）</span>
                </div>
                <div class="shuju-item">
                    <span class="shuju-price">{{yugu_money}}</span>
                    <span class="shuju-name">预估收益（元）</span>
                </div>
                <div class="shuju-item">
                    <span class="shuju-price">{{user_dongjie_money}}</span>
                    <span class="shuju-name">提现审核（元）</span>
                </div>
                <div class="shuju-item"   @click="goto('/market/dingdan')">
                    <span class="shuju-price">{{order_count}}</span>
                    <span class="shuju-name">推广订单</span>
                </div>
            </div>
            <div class="action-items" style="margin-top: 20px;">
                <mt-cell title=" 我的客户" to="/market/client"
                is-link>
                    <img slot="icon" src="/smarket/images/user_on.png" width="24" height="24">
                </mt-cell>
                <mt-cell title=" 推广订单" to="/market/dingdan"
                is-link>
                    <img slot="icon" src="/smarket/images/order.png" width="24" height="24">
                </mt-cell>
                <mt-cell title=" 收益记录" to="/market/shouyi"
                is-link>
                    <img slot="icon" src="/smarket/images/card.png" width="24" height="24">
                </mt-cell>
                <mt-cell title=" 提现记录" to="/market/tixian_list"
                is-link>
                    <img slot="icon" src="/smarket/images/tx.png" width="24" height="24">
                </mt-cell>
                <mt-cell title=" 推广咨询" to="/market/zixun"
                is-link>
                    <img slot="icon" src="/smarket/images/zx.png" width="24" height="24">
                </mt-cell>
                <mt-cell title=" 常见问题" to="/market/wenti"
                is-link>
                    <img slot="icon" src="/smarket/images/wt.png" width="24" height="24">
                </mt-cell>
            </div>
        </div>
    </div>
    <div class="tuiguang" v-if="tui.show">
        <div class="center">
            <img class="showimg" :src="tui.img" alt="">
            <div class="com">
                <div class="comtext" style="margin: 10px;">
                    <p style="margin:10px 0"><a style="font-size: 16px;" :href="tui.url">打开推广链接 >>></a></p>
                    <p style="margin:10px 0">{{tui.desc}}</p>
                    <p style="margin:10px 0" class="copytext"> <span class="cotyleft">{{tui.url}}</span> <i class="copyright" @click="copy(tui.url)">复制</i></p>
                    <p class="haiba" @click="haiba">生成我的专属海报</p>
                </div>
                <img class="user_img" crossorigin="anonymous" :src="user_info.headimgurl" alt="" hidden>
                <div id="weima" hidden>
                    <canvas width="200" height="200"></canvas>
                </div>
                <div hidden id='qrcodeCanvas'>
                    <div></div>
                    <p @click="saveimg" style="font-size: 16px;text-align: center;">长按图片保存到手机</p>
                </div>
            </div>
        </div>
        <span class="close" @click="tui.show = false">X</span>
    </div>
    <mt-tabbar v-model="selected" :fixed="true">
        <mt-tab-item id="推广">
            <img slot="icon" src="/smarket/images/ka_on.png">
            推广中心
        </mt-tab-item>
        <mt-tab-item id="个人">
            <img slot="icon" src="/smarket/images/user_on.png">
            个人中心
        </mt-tab-item>
    </mt-tabbar>
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
            static_domain: "<?php echo e(env('STATIC_DOMAIN')); ?>",
            selected:"推广",
            case_selected: "1",
            tui:{
                show:false,
                img:'/smarket/images/logo.png',
                bg_img :'/smarket/images/q.png',
                code_img:'',
                user_img:'/smarket/images/logo.png',
                url:'',
                desc:'【芝士卡次月14元佣金】，持续在网还能在得14元佣金。注意：在网是指正常开机在网，非停机、三无、长期关机等情况。',
            },
            user_info: <?php echo $userInfo; ?>,
            sell_form: <?php echo $sellForm; ?>,
            sell_bill_huafei : {sell_item_img:'/smarket/images/logo.png',sell_banner_img:'/smarket/images/logo.png',url:'https://www.baidu.com',sell_info:'123'},
            sell_bill_vip : {sell_item_img:'',sell_banner_img:'',url:'',sell_info:''},
            sell_bill_flow : {sell_item_img:'',sell_banner_img:'',url:'',sell_info:''},
            user_status: "<?php echo e($user_status); ?>",
            user_money: "<?php echo e($user_money); ?>",
            user_dongjie_money: "<?php echo e($user_dongjie_money); ?>",
            user_tixian_money: "<?php echo e($user_tixian_money); ?>",
            order_count: "<?php echo e($order_count); ?>",
            user_key: "<?php echo e($key); ?>",
            yugu_money:"<?php echo e($yugu_money); ?>",
            card_items: <?php echo $card_items; ?>,
            bill_items: <?php echo $bill_items; ?>,
            bill_active:'tab-container1',
        },
        watch: {
            selected(newName, oldName) {
                sessionStorage.setItem("selected", newName);
            }
        },
        created:function(){
            let selected = sessionStorage.getItem("selected");
            if(selected){
                this.selected = selected;
            }
            this.sell_bill_huafei = {
                sell_item_img : this.sell_form.hzImg,
                sell_banner_img : this.sell_form.hzBanner,
                url : '<?php echo e(env("APP_WX_URL")); ?>/bill/?key='+this.user_key,
                sell_info:'三网通话费充值推广一次终身绑定收益',
            };
            this.sell_bill_flow = {
                sell_item_img : this.sell_form.hzImg,
                sell_banner_img : this.sell_form.hzBanner,
                url : '<?php echo e(env("APP_WX_URL")); ?>/bill/flow/?key='+this.user_key,
                sell_info: '三网通流量充值推广一次终身绑定收益',
            };
            this.sell_bill_vip = {
                sell_item_img : this.sell_form.hzImg,
                sell_banner_img : this.sell_form.hzBanner,
                url : '<?php echo e(env("APP_WX_URL")); ?>/bill/vip/?key='+this.user_key,
                sell_info:'各大主流平台视频会员充值推广一次终身绑定收益',
            };
        },
        methods: {
            goto:function(url){
                window.location.href= url
            },
            tuiguang:function(e){
                if(e){
                    this.tui.img = e.sell_item_img ? e.sell_item_img : this.sell_form.cardImg;
                    this.tui.bg_img = e.sell_banner_img ? e.sell_banner_img : this.sell_form.cardBanner;
                    if(e.url){
                        this.tui.url = e.url;
                    }else{
                        this.tui.url = '<?php echo e(env("APP_WX_URL")); ?>/card/details/'+e.id+'?key='+this.user_key;
                    }
                    this.tui.desc = e.sell_info;
                }else{
                    this.tui.img = this.sell_form.hzImg;
                    this.tui.bg_img = this.sell_form.hzBanner;
                    this.tui.url = '<?php echo e(env("APP_WX_URL")); ?>/card/?key='+this.user_key;
                    this.tui.desc = this.sell_form.hzText;
                }
                this.tui.show = true;
            },
            haiba(){
                try {
                    this.$indicator.open();
                    $("#weima").erweima({
                        label: 'jQuery',
                        text: this.toUtf8(this.tui.url),
                        mode: 4,
                        mSize:20,
                        size: 120,
                        image: $(".user_img")[0]
                    });
                    //将二维码显示到图片上
                    var canvas=$("#weima").find('canvas').get(0);
                    this.tui.code_img = canvas.toDataURL('image/png');
                    this.drawImage()
                } catch (error) {
                    this.$indicator.close();
                    this.$toast('生成海报失败');
                }
                
            },
            drawImage(){
                $('#qrcodeCanvas img').remove()
                //图1
                let bg_img = this.tui.bg_img;
                //图3
                let code_img = this.tui.code_img;
                this.loadImg([
                    bg_img,
                    code_img,
                ]).then(([img1,img2])=> {	
                    window.img1 = img1;
                    var bgwidth= img1.width;
                    //window.screen.width;
                    //$("#qrcodeCanvas").width();
                    var bgHeight= img1.height;
                    //window.screen.height;
                    //canvas必须设定确定的宽高,设置为图片大小
                    let canvas = document.createElement('canvas')
                    canvas.width = bgwidth;
                    canvas.height = bgHeight;
                    let ctx = canvas.getContext("2d");
                    ctx.rect(0,0, canvas.width, canvas.height); //(距离左上角x坐标,距离左上角y坐标,宽度,高度)
                    ctx.fillStyle = "#fff"; //矩形的颜色
                    ctx.fill(); //填充


                    ctx.drawImage(img1, 0, 0, bgwidth, bgHeight)//(绘制图片资源,x坐标,y坐标,宽,高)
                    let w = bgwidth/2 - 100;
                    ctx.drawImage(img2, 310, 680, 120, 120)

                    // 设置字体
            //         ctx.font = "20px bold 黑体";
            //         ctx.fillStyle = "#ffa500";
            //         ctx.fillText("•长按识别二维码•",bgwidth/2 - 90,bgHeight - 30);
                    imageURL = canvas.toDataURL("image/png");

                    let compose_img = new Image();
                    compose_img.src = imageURL;
                    compose_img.setAttribute("alt", "好友邀请图片");
                    compose_img.setAttribute("width", "100%");
                    compose_img.setAttribute("crossOrigin", 'anonymous');
                    document.getElementById("qrcodeCanvas").querySelector('div').append(compose_img)		
                    canvas.style.display = "none";
                    $("#qrcodeCanvas").show();
                    $('.comtext,.showimg').hide();
                    this.$indicator.close();
                    return;

                    this.$axios.post('/market/api/upload_base64',{img:imageURL}).then(res=>{
                        if(res.code == 0){
                            this.$indicator.close();
                            wx.previewImage({
                                current : img1.src,
                                urls : [img1.src]
                            });
                        }else{
                            that.$toast(res.msg);
                        }
                    })
                    
                    
                });
            },
            base64ToBlob ({b64data = '', contentType = '', sliceSize = 512} = {}) {
                return new Promise((resolve, reject) => {
                    // 使用 atob() 方法将数据解码
                    let byteCharacters = atob(b64data);
                    let byteArrays = [];
                    for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                    let slice = byteCharacters.slice(offset, offset + sliceSize);
                    let byteNumbers = [];
                    for (let i = 0; i < slice.length; i++) {
                        byteNumbers.push(slice.charCodeAt(i));
                    }
                    // 8 位无符号整数值的类型化数组。内容将初始化为 0。
                    // 如果无法分配请求数目的字节，则将引发异常。
                    byteArrays.push(new Uint8Array(byteNumbers));
                    }
                    let result = new Blob(byteArrays, {
                    type: contentType
                    })
                    result = Object.assign(result,{
                    // 这里一定要处理一下 URL.createObjectURL
                    preview: URL.createObjectURL(result),
                    name: `XXX.png`
                    });
                    resolve(result)
                })
            },
            loadImg(src) {
                const paths = Array.isArray(src) ? src : [src];
                const promise = [];
                paths.forEach((path) => {
                    promise.push(new Promise((resolve, reject) => {
                            let img = new Image();
                            // img.setAttribute("crossorigin", 'anonymous');
                            img.crossOrigin = "Anonymous";
                            img.src = path;
                            img.onload = () => {
                                resolve(img);
                            };
                            img.onerror = (err) => {
                                this.$indicator.close();
                                this.$toast('生成海报失败');
                                console.log('图片加载失败')
                            }
                    }))
                });
                return Promise.all(promise);
            },
            toUtf8(str) {  
                var out, i, len, c;  
                out = "";  
                len = str.length;  
                for (i = 0; i < len; i++) {  
                    c = str.charCodeAt(i);  
                    if ((c >= 0x0001) && (c <= 0x007F)) {  
                    out += str.charAt(i);  
                    } else if (c > 0x07FF) {  
                    out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));  
                    out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F));  
                    out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));  
                    } else {  
                    out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));  
                    out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));  
                    }  
                }  
                return out;  
            },
            copy(data){
                let url = data;
                let oInput = document.createElement('input');
                oInput.value = url;
                document.body.appendChild(oInput);
                oInput.select(); // 选择对象;
                console.log(oInput.value)
                document.execCommand("Copy"); // 执行浏览器复制命令
                this.$toast('复制成功');
                oInput.remove()
            },
            saveimg(){
                let Url = document.getElementById("qrcodeCanvas").querySelector('div img').src;
                // alert(Url)
                var blob=new Blob([''], {type:'application/octet-stream'});
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = Url;
                a.download = Url.replace(/(.*\/)*([^.]+.*)/ig,"$2").split("?")[0];
                var e = document.createEvent('MouseEvents');
                e.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                a.dispatchEvent(e);
                URL.revokeObjectURL(url);
            },
        },
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.market', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>