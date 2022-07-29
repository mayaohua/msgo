@extends('layouts.card')
@section('head')
<title>靓号商城-星耀互联</title>
<style>
    *{
        margin:0;
        padding:0;
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
    .griditem{
        width:100%;
        height:100%;
    }
    .griditem .van-image{
        flex:1;
        width:50px;
        height:50px;
    }
    .griditem .van-grid-item__content{
        padding:10px 5px;
    }
    .griditem .gridtext{
        flex:1;
        margin-top:8px;
        font-size: 14px;
    }
    .notice-swipe {
		height: 40px;
		line-height: 40px;
	}
    .best-num{
        display:flex;
        /* align-items:center; */
        height:250px;
    }
    .van-sidebar {
        background: #f7f8fa;
    }
    .card-items{
        /* height:220px; */
        
        box-sizing: border-box;
    }
    .card-item{
        /* margin:10px; */
        height:250px;
        box-sizing: border-box;
        overflow: auto;
    }
    .jinpin-items{
        background:#fff;
    }
    .jinpin-item{
        border-bottom:1px solid #ebedf0;
        display:flex;
        align-items: center;
        font-size:14px;
        padding:5px;
    }
    .jinpin-item img{
        width:50px;
        height:50px;
        border-radius:5px;
        margin-right:5px;
        
        box-sizing: border-box;
    }
    .jinpin-item .number{
        color:#000;
        font-size:17px;
    }
    .jinpin-item .number i{
        color:#ff8e08;
        font-size:17px;
    }
    .jinpin-item .guishudi{
        color:#ff8e08;
        font-size:15px;
    }
    .jinpin-item .card-name{
        color:#000;
        font-size:15px;
    }
    .jinpin-item .xiadan{
        color:#ff8e08;
        font-size:16px;
    }
    .jinpin-right{
        flex:1;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-right:10px;
    }
    .jinpin-top-text{
        display:flex;
        align-items: center;
        justify-content: space-between;
    }
    .jinpin-bottom-text{
        display:flex;
        align-items: center;
        justify-content: space-between;
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
        display:flex;
        align-items: center;
        font-size:14px;
        /* padding: 5px; */
    }
    .prick-item img{
        /* width:55px; */
        height:63px;
        border-radius:5px;
        margin-right:5px;
        /* padding:5px; */
        box-sizing: border-box;
    }
    .prick-item .prick-name{
        color:#fa6016;
        font-size:15px;
        text-overflow: -o-ellipsis-lastline;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        line-clamp: 1;
        -webkit-box-orient: vertical;
    }
    .prick-item .prick-name i{
        color:#ff8e08;
        font-size:12px;
        float: right;
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
        line-height: 18px;
    }
    .prick-item .prick-desc i{
        color:#ff8e08;
        font-size:12px;
    }
    .prick-right{
        flex:1;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        margin-right:10px;
        height: 63px;
    }
    .van-cell .van-cell__title i{
        color:#ed6a0c;
        font-size:12px;
        margin-left:5px;
    }
    .van-cell .van-cell__title{
        display:flex;
        align-items:center;
        flex:2;
        font-size:16px;
    }

</style>
@endsection
@section('content')
<div id="container">
    <div style="">
        @include('wx.card.swipe')
    </div>
    <!-- color="#000000" background="#ffffff"  -->
    <van-notice-bar  left-icon="volume-o" :scrollable="false">
        <van-swipe
            vertical
            class="notice-swipe"
            :autoplay="5000"
            :show-indicators="false"
        >
            <van-swipe-item>如订单有问题客服进行处理</van-swipe-item>
            <van-swipe-item>不要用同一个身份证下多单</van-swipe-item>
            <van-swipe-item>关注公众号“星耀互联”了解更多福利</van-swipe-item>
        </van-swipe>
    </van-notice-bar>
    <div style="margin:10px 5px;">
        <van-grid>
            <van-grid-item @click="gotoPage(value.href)" :border="false"   v-for="(value,index) in gridArr" :key="index">
                <i class="van-icon  van-grid-item__icon">
                    <img :src="value.src" class="van-icon__image">
                </i>
                <span class="van-grid-item__text" v-html="value.name"></span>
            </van-grid-item>
        </van-grid>
    </div>
    <div>
        <div class="list">
            <van-cell is-link value="更多" @click="gotoPage('/card/kind/')">
                <template slot="title"><span>热门卡种</span><i>🔥多款卡种任意选</i></template>
            </van-cell>
            <div class="best-num">
                <van-sidebar v-model="activeKey">
                    <van-sidebar-item  v-for="item in hotCards" :title="item.case_name"></van-sidebar-item>
                </van-sidebar>
                <div class="card-items" style="flex:1;">
                    <div class="card-item" v-for="(item,index) in hotCards" v-if="activeKey == index">
                        <div class="prick-items">
                            <van-cell v-for="(item1,index1) in item.cards" :key="index1">
                                <div class="prick-item" @click="gotoPage('/card/details/'+item.id+'?card_id='+item1.id)">
                                    <img :src="item.case_icon" alt="">
                                    <div class="prick-right">
                                        <span class="prick-name">@{{item1.card_name}}<i>【推荐】</i></span>
                                        <div class='prick-desc'>@{{item1.text_short_desc}}</div>
                                    </div>
                                </div>
                            </van-cell>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="list" style="border-radius: 5px;">
            <van-cell is-link value="更多" style="margin-top:10px;" @click="gotoPage('/card/bestnum/')">
                <template slot="title"><span>精品靓号</span><i>🔥24小时更新中</i></template>
            </van-cell>
            <div class="jinpin-items" v-if="!first" >
                <div class="jinpin-item" v-for="item in bestNums"  @click="gotoOrder(item)">
                    <img :src="item.card_icon" alt="">
                    <div class="jinpin-right">
                        <div class="jinpin-top-text">
                            <span class="number" v-html="item.show_mob?item.show_mob:item.mobile_number"></span>
                            <span class="card-name">@{{item.card_name}}</span>
                        </div>
                        <div class="jinpin-bottom-text">
                            <span class="guishudi">@{{item.data.area.provice.name+item.data.area.city.name}}</span>
                            <span class="xiadan"><em>免费领取</em></span>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else><van-empty description="靓号初始化中" ></van-empty></div>
        </div>
        
    </div>
    <!-- <van-grid direction="horizontal" :column-num="3">
        <van-grid-item>
            <i class="van-icon  van-grid-item__icon">
                <img src="https://b.yzcdn.cn/vant/icon-demo-1126.png" class="van-icon__image">
            </i>
            <span class="van-grid-item__text">卡种选购</span>
        </van-grid-item>
        <van-grid-item icon="photo-o" text="卡种选购" /></van-grid-item>
        <van-grid-item icon="photo-o" text="精品靓号" /></van-grid-item>
    </van-grid> -->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('js/fillout_order_info_area.js') }}"></script>
<script src="https://api.map.baidu.com/api?v=2.0&ak=gVwQ06QIoeyyvL1EBHinTkd7tyKPgPaz"></script>
<script type="text/javascript">

</script>  
<script type="text/javascript">
    new Vue({
        el:"#app",
        mixins: [HeaderMixin],
        data:{
            static_domain:"{{env('STATIC_DOMAIN')}}",
            activeKey:0,
            gridArr:[
                {
                    name:'精品靓号',
                    src:"{!! URL::asset('images/002_jinpin.png') !!}",
                    href:"/card/bestnum/"
                },
                {
                    name:'卡种选购',
                    src:"{!! URL::asset('images/002_fenlei.png') !!}",
                    href:"/card/kind"
                },
                {
                    name:'靓号扫描',
                    src:"{!! URL::asset('images/002_setting.png') !!}",
                    href:"/card/wxapp"
                },
                {
                    name:'订单查询',
                    src:"{!! URL::asset('images/order.png') !!}",
                    href:"https://m.10010.com/mfront/views/my-order/main.html#/orderlist?oneKey=t&refresh_sign=1&from=tx"
                },
                {
                    name:'QQ群聊',
                    src:"{!! URL::asset('images/help.png') !!}",
                    href:"/card/qq"
                },
                {
                    name:'<i style="color:#ed6a0c;">充值业务</i>',
                    src:"{!! URL::asset('images/002_file.png') !!}",
                    href:"/bill/"
                },
                {
                    name:'问题反馈',
                    src:"{!! URL::asset('images/jl.png') !!}",
                    href:"/card/question"
                },
                {
                    name:'联系我们',
                    src:"{!! URL::asset('images/002_me.png') !!}",
                    href:"/card/us"
                }
            ],
            first : true,
            hotCards: {!! $hot_cards !!},
            bestNums:{!! $best_nums !!},
            localAddress:{
                province:'',
                city:'',
            }
        },
        created() {
            var index_best_numbers = sessionStorage.getItem("index_best_numbers");
            if(index_best_numbers){
                this.bestNums = JSON.parse(index_best_numbers)
                this.first = false;
            }else{
                // 百度地图API功能
                var map = new BMap.Map("allmap");
                var geoc = new BMap.Geocoder(); 
                var geolocation = new BMap.Geolocation();
                let that = this;
                setTimeout(function(){
                    if(that.bestNums.length == 0){
                        that.changeBestNum()
                    }
                },4000)
                geolocation.getCurrentPosition(function(r){
                    if(this.getStatus() == BMAP_STATUS_SUCCESS){
                        var pt = r.point;
                        geoc.getLocation(pt, function(rs){
                            var addComp = rs.addressComponents;
                            that.localAddress.province = addComp.province;
                            that.localAddress.city = addComp.city;
                            that.changeBestNum()
                        });    
                    }        
                },{enableHighAccuracy: true})
            }
            let user_key = window.sessionStorage.getItem('card_user_key')
            console.log(user_key)
            if(!user_key){return;}
            this.api.hasSellUser({user_key:user_key},res => {
                if(res === 1){
                    this.gridArr[5].href+=("?key="+user_key);
                }
            })
		},
		onReady() {
			
		},
		methods: {
            gotoOrder(item){
                let url = '/card/apply_best?number='
                +item.mobile_number+
                '&provinceName='+item.data.area.provice.name+
                '&provinceCode='+item.data.area.provice.ess_code+
                '&cityCode='+item.data.area.city.code+
                '&cityName='+item.data.area.city.name+
                '&card_id='+item.card_id+
                '&card_name='+item.card_name+
                '&mobile_from='+item.mobile_from;
                window.location.href= url;
            },
			gotoPage(url){
                window.location.href= url;
            },
            changeBestNum(){
                let city_ess_code = 0;
                let province_ess_code = 0;
                let province_code = null;
                if(this.localAddress.province){
                    allArea.PROVINCE_LIST.forEach((p,i)=>{
                        if(this.localAddress.province.search(p.PROVINCE_NAME) != -1){
                            province_ess_code = p.ESS_PROVINCE_CODE;
                            province_code = p.PROVINCE_CODE;
                            return false;
                        }
                    })
                }
                if(this.localAddress.city){
                    allArea.PROVINCE_MAP[province_code].forEach((p,i)=>{
                        if(p.CITY_NAME == this.localAddress.city){
                            city_ess_code = p.ESS_CITY_CODE;
                            return false;
                        }
                    })
                }
                
                let url = '/api/card/index_best_num';
                let data = {
                    province_ess_code:province_ess_code,
                    city_ess_code:city_ess_code,
                }
                let that = this;
                $.post(url,data,function(res){
                    if(res.code == 0){
                        let Ndata = res.data.data;
                        $.each(Ndata, function (i, v) {
                            var tel = v.mobile_number;
                            var ptype=1;
                            var lh=that.api.regPhone(tel);
                            if(lh){
                                var str_before = tel.split(lh)[0]; 
                                var str_after = tel.split(lh)[1]; 
                                tel=str_before+"<i style='color:#F00'>"+lh+"</i>"+str_after;  
                                is_lh = true;
                            }
                            v.show_mob = tel;
                        })
                        if(Ndata.length) {
                            that.bestNums = Ndata
                            that.first = false;
                            sessionStorage.setItem("index_best_numbers", JSON.stringify(that.bestNums));
                        }
                    }
                })
            },
		}
    })
</script>
@endsection