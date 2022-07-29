<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css"> -->
    <!--<link rel="stylesheet" href="https://unpkg.com/mint-ui/lib/style.css">-->
      <link  rel="stylesheet" href="{{ URL::asset('smarket/css/mint-ui.min.css') }}">
    <style>
      *{
        margin:0;
        padding:0;
        font-size:14px;
        font-weight:normal;
        font-style:normal;
      }
      [v-cloak] {
          display: none !important;
      }
      .loading{
        height:100vh;
        width:100vw;
        position:fixed;
        z-index: 999;
      }
      .el-loading-mask {
          position: absolute;
          z-index: 2000;
          background-color: hsla(0,0%,100%,.9);
          margin: 0;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
          transition: opacity .3s;
          background-color: hsla(0,0%,100%,.9);
      }
      .el-loading-spinner {
          top: 50%;
          margin-top: -21px;
          width: 100%;
          text-align: center;
          position: absolute;
      }
      .el-loading-spinner .circular {
          height: 42px;
          width: 42px;
          animation: loading-rotate 2s linear infinite;
          text-align: center;
          font-size: 14px;
          color: #606266;
      }
      .el-loading-spinner .path {
          animation: loading-dash 1.5s ease-in-out infinite;
          stroke-dasharray: 90,150;
          stroke-dashoffset: 0;
          stroke-width: 2;
          stroke: #409eff;
          stroke-linecap: round;
      }
      
      @-webkit-keyframes loading-rotate {
          100% {
              -webkit-transform: rotate(360deg);
              transform: rotate(360deg)
          }
      }

      @keyframes loading-rotate {
          100% {
              -webkit-transform: rotate(360deg);
              transform: rotate(360deg)
          }
      }

      @-webkit-keyframes loading-dash {
          0% {
              stroke-dasharray: 1,200;
              stroke-dashoffset: 0
          }

          50% {
              stroke-dasharray: 90,150;
              stroke-dashoffset: -40px
          }

          100% {
              stroke-dasharray: 90,150;
              stroke-dashoffset: -120px
          }
      }

      @keyframes loading-dash {
          0% {
              stroke-dasharray: 1,200;
              stroke-dashoffset: 0
          }

          50% {
              stroke-dasharray: 90,150;
              stroke-dashoffset: -40px
          }

          100% {
              stroke-dasharray: 90,150;
              stroke-dashoffset: -120px
          }
      }
    </style>
    @yield('head')
</head>
<body>
    <div class="loading">
        <div class="el-loading-mask">
          <div class="el-loading-spinner">
            <svg viewBox="25 25 50 50" class="circular"><circle cx="50" cy="50" r="20" fill="none" class="path"></circle></svg>
          </div>
      </div>
    </div>
    <div id="app" v-cloak>
        @yield('content')
      </div>
</body>

  <!-- 先引入 Vue -->
  <script src="{{ URL::asset('js/vue.js') }}"></script>
  <script src="{{ URL::asset('js/axios.min.js') }}"></script>
  <!-- 引入组件库 -->
  <script src="{{ URL::asset('smarket/js/mint-ui.min.js') }}"></script>
  <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
  <script>
    let token = document.head.querySelector('meta[name="csrf-token"]');
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    axios.interceptors.response.use(
        response => {
            if (response.status === 200) {
                return Promise.resolve(response.data);
            } else {
                return Promise.reject(response.data);
            }
        },
        error => {
            Vue.prototype.$indicator.close()
            if (error.response.status) {
              return Promise.reject(error.response);
            }
        }
    );
    Vue.prototype.$axios = axios;
    axios.get('/market/api/js_config').then(res=>{
      wx.config(res.data);
    })
    // 定义一个混入对 1象 
    var HeaderMixin = {
        data  () {
            return {
              loading:true,
            }
        },
        
        created: function () {
          if(document.getElementsByClassName('loading').length){
              document.getElementsByClassName('loading')[0].remove()
          }
        },
        methods: {
            
        }
    };
    Vue.mixin(HeaderMixin);
  </script>
  @yield('script')
</html>