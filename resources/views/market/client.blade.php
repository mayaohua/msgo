@extends('layouts.market')

@section('head')
<title>我的客户</title>
<style> 
.content{
    padding:10px;
}
.head{
    padding:10px;
}
.item{
    display: flex;
    align-items: center;
    padding:5px 0;
    /* justify-content: space-between; */
}
.item img{
    width: 50px;
    height: 50px;
    margin-right: 20px;
}
.head p{
    font-size: 18px;
}
.item p{
    font-size: 18px;
}
</style>
@endsection
@section('content')
<div id="container">
    <div class="head">
    <p>共有@{{users.length}}个客户</p>
    </div>
    <div class='content'>
        <div class="item" v-for='item in users'>
            <img :src="item.user_info.headimgurl" alt="">
            <div class="right">
                <p>昵称：@{{item.user_info.nickname}}</p>
                <p>订单数：@{{item.for_sell_orders}}</p>
            </div>
        </div>
    </div>
</div> 
@endsection
@section('script')
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            users: {!! $users !!}
        },
        methods: {

        },
    })
</script>
@endsection