
<?php $__env->startSection('head'); ?>
<title>卡种选购-星耀互联</title>
<style>
    *{
        margin:0;
        padding:0;
    }
    .list .van-cell *{
        font-size:16px;
    }
    .van-grid-item__text{
        font-size:14px;
    }
    .van-grid-item__icon{
        font-size:0px;
    }
    .van-grid-item__icon img{
        width:2rem;
        height:2rem;
    }
    .van-grid-item__content .van-grid-item__icon+.van-grid-item__text{
        margin-top:0px!important;
    }
    .van-grid-item__content{
        padding:10px 8px;
    }
    i,em{
        font-style: normal;
        font-weight: normal;
    }
    body{
        background:#f0f0f0;
    }
    #container{
        /* padding-bottom: 50px; */
        font-size:16px;
    }
    .best-num{
        display:flex;
        /* align-items:center; */
        /* height:320px; */
    }
    .card-items{
        /* height:220px; */
        
        box-sizing: border-box;
    }
    .card-item{
        margin:10px;
        height:220px;
        box-sizing: border-box;
        overflow: auto;
    }
    
    .list{
        border-radius:5px;
        margin:0 5px;
        margin-bottom:10px;
        background:#fff;
    }

    .prick-items{
        background:#fff;
    }
    .prick-item{
        /* border-bottom:1px solid #ebedf0; */
        display:flex;
        align-items: center;
        font-size:14px;
        padding: 5px;
    }
    .prick-item img{
        /* width:55px; */
        height:55px;
        border-radius:5px;
        margin-right:5px;
        /* padding:5px; */
        box-sizing: border-box;
    }
    .prick-item .prick-name{
        color:#fa6016;
        font-size:14px;
    }
    .prick-item .prick-desc{
        color:#999;
        font-size:12px;
        text-overflow: -o-ellipsis-lastline;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 16px;
    }
    .prick-item .prick-desc>div{
        padding:0;
        height: 20px;
    }
    .prick-right{
        flex:1;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-right:10px;
        height: 55px;
    }

</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="container">
    <van-notice-bar
    style="margin-bottom:10px;"
    left-icon="volume-o"
    text="联通卡种多多，靓号丰富，欢迎抢购"
    ></van-notice-bar>
    <!-- <van-cell title="联通卡种多多，靓号丰富，欢迎抢购"  style="margin-top:10px;"></van-cell> -->
    <van-tabs v-model="active" scrollspy sticky>
        <van-tab :title="item.case_name" v-for="(item,index) in cards">
            <van-notice-bar
                color="#1989fa"
                background="#ecf9ff"
                wrapable
                :scrollable="false"
                :text="item.text_short_desc">
            </van-notice-bar>
            <div class="prick-items">
                <van-cell v-for="(item1,index1) in item.cards" :key="index1">
                    <div class="prick-item" @click="gotoPage('/card/details/'+item.id+'?card_id='+item1.id)">
                        <img :src="lt_img_domain+item1.card_icon" alt="">
                        <div class="prick-right">
                            <span class="prick-name">{{(item1.card_name == item.case_name) ? item.case_name : (item.case_name+'-'+item1.card_name) }}</span>
                            <div class='prick-desc'>{{item1.text_short_desc}}</div>
                        </div>
                    </div>
                </van-cell>
            </div>
        </van-tab>
    </van-tabs>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            active: 0,
            cards: <?php echo $cards; ?>,
            lt_img_domain:'https://msgoxyz.oss-cn-beijing.aliyuncs.com',
        },
        created() {

		},
		onReady() {
			
		},
		methods: {
			gotoPage(url){
                url += (this.api.getQueryString('xcx') ? '&xcx=1' : '');
                this.api.isMiniProgram((res)=>{//判断是否是小程序页面的回调函数
                    if (res) {//小程序页面
                        wx.miniProgram.navigateTo({url: '/pages/center/navigator?url=' + escape(window.location.origin+url)});
                    } else {
                        window.location.href= url;
                    }
                })
                
            },
		}
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.card', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>