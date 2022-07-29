@extends('layouts.bill')
@section('head')
<title>联系我们-星耀互联</title>
<style>
    #container{
        display: flex;
        align-items: flex-end;
        justify-content: center;
        height: 100vh;
    }
</style>
@endsection
@section('content')
<div id="container">
    <img style="width:100%;height: 100%;" src="{{ URL::asset('images/fuwu.png') }}" alt="">
</div>
@endsection
@section('script')
<script type="text/javascript">
    new Vue({
        el:"#app",
        mixins: [HeaderMixin],
        data:{
            
        },
		computed:{
			
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