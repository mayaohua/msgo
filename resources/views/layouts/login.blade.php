<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ URL::asset('//unpkg.com/element-ui/lib/theme-chalk/index.css') }}">
    <script src="{{ URL::asset('logins/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('logins/js/vector.js') }}"></script>
    <style>
        *{margin:0;padding:0;font-size:13px;font-family:microsoft yahei}
        html,body{width:100%;height:100%;background:#fff}
        #container{width:100%;height:100%;position:fixed;top:0;left:0;z-index:999}
        #output{width:100%;height:100%}
        .prompt{width:60%;height:30px;margin:5px auto;text-align:center;line-height:30px;font-family:microsoft yahei,Arial,sans-serif;font-size:13px;color:#df0000}
        .containerT{width:400px;height:300px;text-align:center;position:absolute;top:50%;left:50%;margin:-150px 0 0 -200px;border-radius:3px}
        .containerT h1{color:#fff;font-size:18px;font-family:microsoft yahei,Arial,sans-serif;-webkit-transition-duration:1s;transition-duration:1s;-webkit-transition-timing-function:ease-in-put;transition-timing-function:ease-in-put;font-weight:500}
        form{padding:20px 0;position:relative;z-index:2}
        form .form-control{-webkit-appearance:none;-moz-appearance:none;appearance:none;outline:0;border:1px solid rgba(255,255,255,.4);background-color:rgba(255,255,255,.2);width:200px;border-radius:3px;padding:8px 15px;margin:0 auto 10px;display:block;text-align:center;font-size:15px;color:#fff;-webkit-transition-duration:.25s;transition-duration:.25s;font-weight:300}
        form .form-control:hover{background-color:rgba(255,255,255,.4)}
        form .form-control:focus{background-color:#fff;width:230px;color:#333}
        form button{-webkit-appearance:none;-moz-appearance:none;appearance:none;outline:0;background-color:#fff;border:0;padding:10px 15px;color:#333;border-radius:3px;width:200px;cursor:pointer;font-family:microsoft yahei,Arial,sans-serif;font-size:16px;font-weight:700;-webkit-transition-duration:.25s;transition-duration:.25s}
        form button:hover{background-color:#f5f7f9}
        body{
            background: url('{{ URL::asset('logins/images/canvas.png') }}') no-repeat center;
            background-size: cover;
        }
    </style>
    @yield('style')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
</body>
<script src="{{ URL::asset('logins/js/ui.js') }}"></script>
<script src="{{ URL::asset('js/axios.min.js') }}"></script>
<script src="{{ URL::asset('js/vue.js') }}"></script>
<script src="{{ URL::asset('//unpkg.com/element-ui/lib/index.js') }}"></script>
<script>
    Vue.prototype.$axios = axios;
</script>
@yield('script')
</html>