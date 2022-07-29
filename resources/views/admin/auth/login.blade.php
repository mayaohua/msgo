@extends('layouts.login')
@section('title')
{{env('APP_NAME')}}登录
@endsection
@section('style')
<style>
    .error{
       position:fixed;
       left: 0;
       top: 0px; 
       width: 100%;

    }
</style>
@endsection
@section('content')
<div id="container">
    <div class="error"> 
        @if ($errors->has('email'))
            <el-alert title="{{ $errors->first('email') }}" type="error"> </el-alert>
        @endif
        @if ($errors->has('name'))
            <el-alert title="{{ $errors->first('name') }}" type="error"> </el-alert>
        @endif
        @if ($errors->has('password'))
            <el-alert title="{{ $errors->first('password') }}" type="error"> </el-alert>
        @endif
    </div>
	<div id="output">
		<div class="containerT">
			<h1>{{env('APP_NAME')}}登录</h1>
            <form class="form" id="entry_form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <input id="name" placeholder="请输入邮箱/用户名" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
				<input id="password" placeholder="请输入密码" type="password" class="form-control" name="password" required>
                <div style="display: none">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : 'checked' }}> 记住我
                </div>
                <button id="entry_btn" type="submit">登录</button>
				<div id="prompt" class="prompt"></div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('script')

<script type="text/javascript">
$(function(){
    Victor("container", "output");  
    $("#entry_name").focus();
});
</script>
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            
        },
        methods: {
            
        },
    })
</script>
@endsection