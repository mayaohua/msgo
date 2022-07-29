
<?php $__env->startSection('head'); ?>
<title>卡种介绍-星耀互联</title>
<link rel="stylesheet" href="<?php echo e(URL::asset('css/swiper.min.css')); ?>">
<style>
    * {
        margin: 0;
        padding: 0;
        list-style-type:none;
    }
    .list .van-cell * {
        font-size: 16px;
    }

    .van-grid-item__text {
        font-size: 14px;
    }

    .van-grid-item__icon {
        font-size: 0px;
    }

    .van-grid-item__icon img {
        width: 2rem;
        height: 2rem;
    }

    .van-grid-item__content .van-grid-item__icon+.van-grid-item__text {
        margin-top: 0px !important;
    }

    .van-grid-item__content {
        padding: 10px 8px;
    }

    i,
    em {
        font-style: normal;
        font-weight: normal;
    }

    body {
        background: #f0f0f0;
    }

    #container {
        /* padding-bottom: 50px; */
        font-size: 16px;
        background:#000;
    }

    .best-num {
        display: flex;
        /* align-items:center; */
        /* height:320px; */
    }

    .card-items {
        /* height:220px; */

        box-sizing: border-box;
    }

    .card-item {
        margin: 10px;
        height: 220px;
        box-sizing: border-box;
        overflow: auto;
    }

    .list {
        border-radius: 5px;
        margin: 0 5px;
        margin-bottom: 10px;
        background: #fff;
    }

    .prick-items {
        background: #fff;
    }

    .prick-item {
        /* border-bottom:1px solid #ebedf0; */
        display: flex;
        align-items: center;
        font-size: 14px;
        padding: 5px;
    }

    .prick-item img {
        /* width:55px; */
        height: 55px;
        border-radius: 5px;
        margin-right: 5px;
        /* padding:5px; */
        box-sizing: border-box;
    }

    .prick-item .prick-name {
        color: #fa6016;
        font-size: 14px;
    }

    .prick-item .prick-desc {
        color: #999;
        font-size: 12px;
    }

    .prick-item .prick-desc>div {
        padding: 0;
        height: 20px;
    }

    .prick-right {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-right: 10px;
        height: 55px;
    }

    img {
        display: block;
        font-size: 0;
        width: 100%;
    }
    .btnBox{
        padding: 10px 0;
        margin:0 auto;
        text-align:center;
        width:100%;
    } 
    .btnBox a{
        margin: 0 auto;
        
    }
    .btnBox a img{
        width: 80%;
        margin:0 auto;
        max-height:0.5rem;
    }
    .flex-btn{
        position: fixed;
        bottom: 22px;
    }
    
</style>
<style>
    #carousel{margin-top:-90px;position:relative;z-index:2;height:1.5rem;transform-style:preserve-3d;perspective:800px}
    #carousel img{position:absolute;  left: 52.3%;top: 0;width: 38%;margin-left: -21.4vw;transition:transform .5s ease-in-out;box-shadow:8px 8px 20px rgba(0,0,0,.2);cursor:pointer;z-index:-1;}
    #tow_ul{margin-top:-150px;position:relative;z-index:2;height:1.5rem;transform-style:preserve-3d;perspective:800px;}
    #tow_ul img{position:absolute;  left: 52.3%;top: 0;width: 38%;margin-left: -21.4vw;transition:transform .5s ease-in-out;box-shadow:8px 8px 20px rgba(0,0,0,.2);cursor:pointer;z-index:-1;}

    /* #tow_ul img{width: 1.3rem;height: 0.82rem;position: absolute;
        -moz-transition: all .5s;
        -webkit-transition: all .5s;
        -ms-transition: all .5s;
        transition: all .5s;
        top: 50%;
        left: 50%;
        z-index: 10;
    } */
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container"  :style="'background:'+set_value('page_color','#000000')">
    <div class="top-imgs">
        <img v-for="item in details.desc_top_imgs" :src="lt_img_domain+item" alt="">
    </div>
    <div  v-if="details.is_show_cards == 1" >
        <div class="duo" id="carousel" :style="'margin-top:'+set_value('margin_top','-90px')+';'+'height:'+set_value('height','1.5rem')" v-if="details.cards.length != 2 && details.cards.length != 0">
            <img  v-for="(item1,index) in details.cards" :src="lt_img_domain+item1.card_item_img" @click="setProid(item1.id)" :data-id="item1.id" class="tab">
        </div>
        <div id="tow_ul" class="tow" :style="'margin-top:'+set_value('margin_top','-150px')+';'+'height:'+set_value('height','1.5rem')" v-else>
            <template v-for="(item1,index1) in details.cards">
                <img  :style="'transform:translate('+(index1 == 0 ? '-':'')+'50%, 0%) scale('+(card_id == item1.id ? '1.4':'1')+');z-index:'+(card_id == item1.id ? '3':'1')" :src="lt_img_domain+item1.card_item_img" @click="setProid(item1.id)" :data-id="item1.id" class="tab"/>
            </template>    
        </div>
    </div>
    
    <div  style="display: inline-block;" :class="details.is_show_cards == 1 ? 'btnBox':'btnBox flex-btn'">
        <a class="btn" @click="gotoPage('/card/apply_card/'+card_id)">
            <img v-if="has_value('btn_url')" :src="lt_img_domain+has_value('btn_url')"style="width:80%"  alt="">
            <img v-else src="https://res.mall.10010.cn/mall/scaffold-img/otherImage/btn_aeb113c0c15a6bfacfc77e0733174212.png"style="width:80%"  alt="">
        </a>
    </div>
    <div class="bottom-imgs">
        <img v-for="item in details.desc_bottom_imgs" v-if="item" :src="lt_img_domain+item" alt="">
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('js/carousel.js')); ?>"></script>
<script>
    var details = <?php echo $details; ?>;
    var card_id = <?php echo $card_id; ?>;
    document.title = details.case_name+'介绍';
    //  移动端手机自适应配置代码
    (function(doc, win) {
        var html = doc.getElementsByTagName("html")[0],
            reEvt = "orientationchange" in win ? "orientationchange" : "resize",
            reFontSize = function() {
                var clientW = doc.documentElement.clientWidth || doc.body.clientWidth;
                if(!clientW) {
                    return;
                }
                html.style.fontSize = 100 * (clientW / 375) + "px";
            }
        win.addEventListener(reEvt, reFontSize);
        doc.addEventListener("DOMContentLoaded", reFontSize);
        let curDisplay = details.cards.findIndex(n=>{return n.id == card_id})
        curDisplay = (curDisplay == -1 ) ? 0 :curDisplay
        let $ = win.$;
        if(details.cards.length != 2) $('#carousel').carousel({curDisplay: curDisplay, autoPlay: false, interval: 3000 });
        
    })(document, window);
    
</script>
 <script type="text/javascript">
    new Vue({
        el: "#app",
        data: {
            lt_img_domain: 'https://msgoxyz.oss-cn-beijing.aliyuncs.com',
            active: 0,
            details: details,
            card_id: card_id,
        },
        computed:{
            has_value() {
                return function (value) {
                    
                    if(this.details.case_other_datas != null){
                        return this.details.case_other_datas[value]
                    }
                    
                    return null;
                }
            },
            set_value() {
                var that = this;
                return function (key,value) {
                    let n = that.has_value(key);
                    return n ? n :value
                }
            },
        },
        created() {
            let curDisplay = this.details.cards.findIndex(n=>{return n.id == this.card_id})
            curDisplay = (curDisplay == -1 ) ? 0 :curDisplay
            setTimeout(() => {
                $('#carousel').carousel({curDisplay: curDisplay, autoPlay: false, interval: 3000 });
            }, 500);
        },
            onReady() {
                
            },
        methods: {
            gotoPage(url) {
                url += (this.api.getQueryString('xcx') ? '?xcx=1' : '');
                window.location.href = url;
            },
            setProid(id){
                this.card_id = id;
            }
        }
    })
</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.card', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>