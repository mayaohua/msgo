<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@2.12/lib/index.css"/>
    <script src="{{ URL::asset('logins/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/vue.js') }}"></script>
    <script src="{{ URL::asset('js/lib-flexible-min.js') }}"></script>
    <style>
        .a{
            font-size: .75rem /* 12px -> .75rem */;
        }
    </style>
</head>
<body>
    <div id="app">
        123
    </div>
</body>

<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
        },
        created() {

		},
		onReady() {
			
		},
		methods: {
			gotoPage(url){
                window.location.href= url;
            },
		}
    })
</script>
</html>