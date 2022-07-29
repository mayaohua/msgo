@extends('layouts.market')
@section('head')
<title>请先关注公众号</title>
<style>
    *{
        margin:0;
        padding:0;
    }
    img{
        width:80%;
    }
    #container{
        height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        flex-direction: column;
        
    }
    p{
        text-align:center;
        margin-top:20px;
        font-size: 20px;
        color:#666;
    }
</style>
@endsection
@section('content')
<div id="container">
    <img src='/images/qrcode_for_gh_0d3b69ccb119_258.jpg'/>
    <p>长按关注公众号</p>
</div>
@endsection
@section('script')

<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            active: 0,
            static_domain:"{{env('STATIC_DOMAIN')}}",
        },
        created() {
            
		},
		onReady() {
			
		},
		methods: {
            
		}
    })
</script>
@endsection