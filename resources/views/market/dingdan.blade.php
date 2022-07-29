@extends('layouts.market')
@section('head')
<title>推广订单</title>
<style>
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
.user-right h1{
    display: flex;
    align-items: center;
    font-size: 16px;
}
.user-right h1 span{
    font-size: 16px;
    font-weight: bold;
}
.user-right h1 img{
    height: 16px;
    margin-left: 10px;
}
.user-money{
    background: #fb7e09;
    border-radius: 4px;
    margin: 10px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    flex-direction: column;
    padding: 20px 0;
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
    color: #feb032;
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
.wenti p{
    color: #999;
    font-size: 12px;
    margin: 5px 0;
}
.lll .mobney-text{
    font-size: 12px;
    color: white;
}
.lll .mobney{
    font-size: 20px;
    color: white;
    
}
.sb{
    margin-left: 20px;
}
.tips{
    margin: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.user-top{
    background: white;
    border-bottom: 1px solid transparent;
}
.jilu{
    margin: 10px;
}
.jilu-item{
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #fcdcfc;
    padding: 10px 0;
}
.jilu-left{
    font-size: 12px;
    color: #666;
    flex: 1;
}
.jilu-right h1{
    color: #fb7e09;
    font-size: 15px;
    width: 70px;
    text-align: center;
}
.jilu-right .gray{
    color: #ccc;
}
.jilu-right .red{
    color: red;
}
.item-wrap{
    display: flex;
    align-items: center;
    padding:10px 20px;
    justify-content: space-between;
    background: white;
}
.step-item{
    display: flex;
    align-items: center;
    flex-direction: column;
    
}
.step-item span{
    font-size: 12px;
    margin-top: 5px;
    color: #ccc;
}
.step-item i{
    width: 20px;
    height: 20px;
    border-radius: 100%;
    background: #ccc;
}
.step-item i img{
    width: 100%;
    height: 100%;
}
.step-line{
    flex: 1;
    margin: 0 10px;
    height: 2px;
    background: #ccc;
    position: relative;
    top:-10px;
}
.status span{
    color: black;
}
.julu-items{
    padding:10px 0;
    /* border-bottom: 1px solid #eee; */
}
.mypoup{
    width: 100%;
}
.mypoup .content{
    padding:10px;
}
.xiangqing{
    padding:0 10px;
    font-size: 12px;

}
.xiangqing h1{
    font-size: 14px;
    color: #666;
    margin: 5px 0;
}
</style>
@endsection
@section('content')
<div id="container" style="background: #eee;">
    <div class="user-top">
        <div class="user-money">
            <div style="display: flex;justify-content: space-between;width: 100%;">
                <div class="money-left sb">
                    <p class="mobney-text">累计入账收益（元）</p>
                    <p class="mobney">@{{user_money}}</p>
                </div>
                <div class="money-left lll" style="margin-right: 10px;">
                    <p class="mobney-text">预估收益（元）</p>
                    <p class="mobney">@{{yugu_money}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="jilu">
        <mt-navbar v-model="selected">
            <mt-tab-item id="0">进行中(@{{orderItems[0].length}})</mt-tab-item>
            <mt-tab-item id="1">审核中(@{{orderItems[1].length}})</mt-tab-item>
            <mt-tab-item id="2">已发放(@{{orderItems[2].length}})</mt-tab-item>
            <mt-tab-item id="3">已失效(@{{orderItems[3].length}})</mt-tab-item>
        </mt-navbar>
          <!-- tab-container -->
          <mt-tab-container v-model="selected">
            <mt-tab-container-item :id="String(index)" v-for="(ord,index) in orderItems">
              <div style="margin-top: 3px;">
                <div class="julu-items" v-for="item in ord" @click="xiangqing(item)">
                    <mt-cell :title="(item.order_type == 'bill'?'充值':'卡号')+'订单 (佣金'+item.order_money+'元)'" value="查看订单" is-link></mt-cell>
                    <div class="item-wrap" v-if="index != 3">
                        <!-- <div class="step-item status">
                            <i><img src="/smarket/images/ok.png" alt=""></i>
                            <span>下单</span>
                        </div>
                        <div class="step-line"></div> -->
                        <div class="step-item" :class="{'status':index == 0}">
                            <i><img v-if='index == 0' src="/smarket/images/ok.png" alt=""></i>
                            <span>@{{item.order_type == 'bill'?'充值中':'等待激活'}}</span>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item" :class="{'status':index == 1}">
                            <i><img v-if='index == 1' src="/smarket/images/ok.png" alt=""></i>
                            <span>审核中</span>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-item" :class="{'status':index == 2}">
                            <i><img v-if='index == 2' src="/smarket/images/ok.png" alt=""></i>
                            <span>发放佣金</span>
                        </div>
                    </div>
                    <div v-else style="padding: 10px;background: white;">
                        <span style="color: red;">失效原因：@{{item.fail_msg}}</span>
                    </div>
                </div>
              </div>
            </mt-tab-container-item>
            <!-- <mt-tab-container-item id="2">
              <div style="margin-top: 3px;"><mt-cell v-for="n in 4" :title="'测试 ' + n" /></div>
            </mt-tab-container-item>
            <mt-tab-container-item id="3">
              <div style="margin-top: 3px;"><mt-cell v-for="n in 6" :title="'选项 ' + n" /></div>
            </mt-tab-container-item> -->
          </mt-tab-container>
          <mt-popup
            class="mypoup"
            v-model="popup.visible"
            position="bottom"
            >
            <div class="content">
                <mt-cell title="订单详情"></mt-cell>
                <div class="xiangqing">
                    <h1>订单类型：@{{popup.data.order_type == 'bill' ? '充值':'卡号'}}订单</h1>
                    <h1>订单名称：@{{popup.data.order_name}}</h1>
                    <h1>订单编号：@{{popup.data.order_uuid}}</h1>
                    <template v-if="popup.data.order_type == 'card'">
                        <h1>选购号码：@{{popup.data.order_info.card_phone}}</h1>
                        <h1>下单号码：@{{popup.data.order_info.user_phone}}</h1>
                    </template>
                    <template v-else>
                        <h1>充值号码：@{{popup.data.order_info.bill_phone}}</h1>
                    </template>
                    <h1>佣金金额：@{{popup.data.order_money}}元</h1>
                    <h1>下单时间：@{{popup.data.created_at}}</h1>
                    <h1>订单状态：
                        <template v-if='popup.data.order_status == 1'>@{{popup.data.order_type == 'bill'?'充值中':'等待激活'}}</template>
                        <template v-if='popup.data.order_status == 2'>审核中</template>
                        <template v-if='popup.data.order_status == 3'>已发放佣金</template>
                        <template v-if='popup.data.order_status == 4'>订单失效</template>
                    </h1>
                    <h1 v-if='popup.data.order_status == 4'><span style="color: red;">失效原因：@{{popup.data.fail_msg}}</span></h1>
                </div>
            </div>
            </mt-popup>
    </div>
</div>
@endsection
@section('script')
<script src="/smarket/js/jquery-1.11.2.min.js"></script>
<script src="/smarket/js/jqueryqr.js"></script>
<script src="/smarket/js/qrcode.js"></script>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            user_money: "{{$user_money}}",
            user_tixian_money: "{{$user_tixian_money}}",
            user_dongjie_money: "{{$user_dongjie_money}}",
            yugu_money: "{{$yugu_money}}",
            selected: "0",
            popup:{
                visible:false,
                data:{
                    order_info:'',
                }
            },
            orderItems: {!! $orderItems !!},
        },
        methods: {
            xiangqing:function(item){
                this.popup.visible = true;
                this.popup.data = item
                console.log(this.popup.data.order_info.bill_phone)
            }
        },
    })
</script>
@endsection