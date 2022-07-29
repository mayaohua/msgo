<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', '后台系统') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('element_ui/index.min.css') }}">
    <script src="{{ URL::asset('logins/js/jquery.min.js') }}"></script>
    <style>
        *{
            margin: 0;padding: 0;
            font-family: normal;
            font-style: normal;
            text-decoration: none;
            box-sizing: border-box;
        }
        a{
            color:#333333;
        }
        .el-menu{
            height: 100%;
        }
        .el-menu-vertical:not(.el-menu--collapse){
            width: 240px;
            height: 100%;
        }
        #app{
            display: flex;
        }
        #app .contents{
            display: flex;
            flex-direction: column;
            flex: 1;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }
        ._el-menu-item {
            font-size:14px;
            color:#303133;
            padding:0 20px;
            cursor:pointer;
            -webkit-transition:border-color .3s,background-color .3s,color .3s;
            transition:border-color .3s,background-color .3s,color .3s;
            box-sizing:border-box;
            float: left;
            height: 60px;
            line-height: 60px;
            margin: 0;
            border-bottom: solid 1px #e6e6e6;
        }
        ._el-menu-item i{
            margin-right:5px;
            width:24px;
            text-align:center;
            font-size:18px;
            vertical-align:middle;
        }
        .scroll{
            width: 98%;
            margin: 20px auto;
            height: 100%;
            overflow: hidden;
        }
        .scroll_view{
            overflow: auto;
            height: 100%;
            width: 100%;
        }
        .el-menu-item.is-active *{
            color:#409EFF;
        }
        
        .el-menu-item a{
            display: inline-block;
            width: 100%;
            height: 100%;
        }
        [v-cloak] {
            display: none !important;
        }
        .load-bg{
            width:100%;
            height:100%;
            position: fixed;
            z-index:-1;
            background:white;
            
        }
    </style>
    @yield('style')
</head>
<body>
    <?php $route = Route::currentRouteName();  ?>
    <div class="load-bg"></div>
    <div id="app" v-cloak>
        {{-- 左侧 --}}
        <div class="menus" v-show="isCollapse">
            <el-menu
            default-active="{{$route}}"
            class="el-menu-vertical"
            @open="handleOpen"
            @close="handleClose"
            {{-- :collapse="isCollapse" --}}
            >
            <el-menu-item>
                <a href="{{route('home')}}">
                <i class="el-icon-menu"></i>
                <span slot="title">控制台</span></a>
            </el-menu-item>
            <el-submenu index="Order">
                <template slot="title">
                <i class="el-icon-location"></i>
                <span>订单中心</span>
                </template>
                <el-menu-item index="PhoneBillOrderList"> <a href="{{route('PhoneBillOrderList')}}"><span>充值订单</span></a></el-menu-item>
                <el-menu-item index="PhoneCardOrderList"> <a href="{{route('PhoneCardOrderList')}}"><span>号码订单</span></a></el-menu-item>
                </el-submenu>
            </el-submenu>
            <el-menu-item index="Bill"><a href="{{route('Bill')}}"><i class="el-icon-location"></i><span>充值商品</span></a></el-menu-item>
            <el-menu-item index="Card"><a href="{{route('Card')}}"><i class="el-icon-location"></i><span>卡种商品</span></a></el-menu-item>

            <el-submenu index="WebUser">
                <template slot="title">
                <i class="el-icon-location"></i>
                <span>分销管理</span>
                </template>
                <el-menu-item index="WebUser"><a href="{{route('WebUser')}}"><span>分销用户</span></a></el-menu-item>
                <el-menu-item index="UserSellOrder"><a href="{{route('UserSellOrder')}}"><span>分销订单</span></a></el-menu-item>
                <el-menu-item index="UserTiXian"><a href="{{route('UserTiXian')}}"><span>提现申请</span></a></el-menu-item>
                </el-submenu>
            </el-submenu>

            <el-menu-item index="SuggestList"><a href="{{route('SuggestList')}}"><i class="el-icon-location"></i><span>反馈建议</span></a></el-menu-item>
             {{-- <el-menu-item index="BNumberList"><a href="{{route('BNumberList')}}"><i class="el-icon-location"></i><span>精品号码</span></a></el-menu-item>
            <el-submenu index="Rule">
                <template slot="title">
                <i class="el-icon-location"></i>
                <span>规则管理</span>
                </template>
                <el-menu-item index="RuleList"> <a href="{{route('RuleList')}}"><span>规则列表</span></a></el-menu-item>
                <el-menu-item index="RuleAdd"> <a href="{{route('RuleAdd')}}"><span>规则添加</span></a></el-menu-item>
                </el-submenu>
            </el-submenu> --}}
            <el-menu-item index="SettingIndex"><a href="{{route('SettingIndex')}}"><i class="el-icon-location"></i><span>系统设置</span></a></el-menu-item>
            

            </el-menu>
          </div>
        <div class="contents">
            <div class="navs" style="display: flex;">
                <div class="_el-menu-item" @click="collapseChange">
                    <i class="el-icon-s-fold"></i>
                </div>
                <div class="_el-menu-item">
                    <a href="{{route('home')}}"><span>首页</span></a>
                </div>
                <el-menu style="display: flex;justify-content: flex-end;flex:1;" default-active="{{$route}}" mode="horizontal" @select="handleSelect">
                    <el-submenu index="1">
                        <template slot="title">个人中心</template>
                        <!--<el-menu-item index="1-1">修改密码</el-menu-item>-->
                        <el-menu-item index="1-2">
                        <form action="{{route('logout')}}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" style="cursor:pointer;background: none;width:100%;height:36px;text-align:left;border:none;color:inherit;">退出登录</button>
                        </form>
                        </el-menu-item>
                    </el-submenu>
                </el-menu>
            </div>
            <div class="scroll">
              <div class="scroll_view">
                    @yield('content')
                </div>  
            </div>
            
        </div>
    </div>
</body>
<script src="{{ URL::asset('logins/js/ui.js') }}"></script>
<script src="{{ URL::asset('js/axios.min.js') }}"></script>
<script src="{{ URL::asset('js/vue.js') }}"></script>
<script src="{{ URL::asset('element_ui/index.min.js') }}"></script>
<script>
    // 定义一个混入对象
    var HeaderMixin = {
        data: function () {
            return {
                activeIndex: '1',
                isCollapse:false,
            }
        },
        created: function () {
            // console.log(window.localStorage.getItem('isCollapse'))
            if(window.localStorage.getItem('isCollapse') == 1){
                this.isCollapse = true
            }else{
                this.isCollapse = false;
            }
        },
        methods: {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            },
            collapseChange(){
                this.isCollapse = !this.isCollapse;
                window.localStorage.setItem('isCollapse',this.isCollapse?1:0)
                console.log(this.isCollapse)
            },
        }
    };
    Vue.mixin(HeaderMixin);
    let token = document.head.querySelector('meta[name="csrf-token"]');
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    var my_loading = null;
    axios.interceptors.request.use(
        config => {
            my_loading = Vue.prototype.$loading({
                lock: true,
                text: '拼命加载中',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            return config;
        },
        error => {
            return Promise.error(error);
        }
    );

    axios.interceptors.response.use(
        response => {
            my_loading.close()
            if (response.status === 200) {
                if(response.data.code === 0){
                    Vue.prototype.$message.success(response.data.msg);
                }else{
                    Vue.prototype.$message.error(response.data.msg);
                }
                return Promise.resolve(response.data);
            } else {
                return Promise.reject(response.data);
            }
        },
        error => {
            my_loading.close()
            if (error.response.status) {
            switch (error.response.status) {
                case 403:
                Vue.prototype.$message.error("无权访问");
                break;
                case 404:
                Vue.prototype.$message.error("请求地址不存在");
                break;
                case 405:
                Vue.prototype.$message.error("请求地址不存在");
                break;
                case 500:
                Vue.prototype.$message.error("系统错误");
                break;
                default:
                Vue.prototype.$message.error("内部错误");
            }
            return Promise.reject(error.response);
            }
        }
    );
    Vue.prototype.$axios = axios;

    window.parseParam = function(param, key){
        var paramStr="";
        if(param instanceof String||param instanceof Number||param instanceof Boolean){
            paramStr+="&"+key+"="+encodeURIComponent(param);
        }else{
            $.each(param,function(i){
                var k=key==null?i:key+(param instanceof Array?"["+i+"]":"."+i);
                paramStr+='&'+window.parseParam(this, k);
            });
        }
        return paramStr.substr(1);
    }
</script>

@yield('script')
</html>
