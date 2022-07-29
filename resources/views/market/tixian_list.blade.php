
@extends('layouts.market')
@section('head')
<title>提现记录</title>
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
.jilu-left h1{
    font-size: 12px;
    margin: 2px 0;
}
.jilu-right h1{
    color: #fb7e09;
    font-weight: bold;
    font-size: 14px;
    width: 100px;
    text-align: center;
}
.jilu-right .gray{
    color: #ccc;
}
.jilu-right .red{
    color: red;
}
</style>
@endsection
@section('content')
<div id="container">
    <div class="user-top">
        <div class="user-money">
            <div style="display: flex;justify-content: space-between;width: 100%;">
                <div class="money-left sb">
                    <p class="mobney-text">累计提现金额（元）</p>
                    <p class="mobney">@{{user_tixian_money}}</p>
                </div>
                <div class="money-left lll" style="margin-right: 10px;">
                    <p class="mobney-text">提现审核中（元）</p>
                    <p class="mobney">@{{user_dongjie_money}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="jilu">
        <div class="jilu-item" v-for="item in tixianItems">
            <div class="jilu-left">
                <h1>提现金额：@{{item.tixian_money}}元</h1>
                <h1>备注信息：@{{item.tixian_info}}</h1>
                <h1>提现时间：@{{item.created_at}}</h1>
                <h1 v-if='item.tixian_status == 3'><span style="color:red;">拒绝原因：@{{item.fail_msg}}</span></h1>
            </div>
            <div class="jilu-right">
                <h1 v-if='item.tixian_status == 2'>审核通过</h1>
                <h1 v-if='item.tixian_status == 1' class="gray">审核中</h1>
                <h1 v-if='item.tixian_status == 3' class="red">申请拒绝</h1>
            </div>
        </div>
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
            tixianItems: {!! $tixianItems !!},
        },
        methods: {
            goto:function(url){
                window.location.href= url
            },
        },
    })
</script>
@endsection