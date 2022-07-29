<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="https://unpkg.com/mint-ui/lib/style.css">
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
    </style>
    <?php echo $__env->yieldContent('head'); ?>
</head>
<body>
    <div id="app" v-cloak>
        <?php echo $__env->yieldContent('content'); ?>
      </div>
</body>

  <!-- 先引入 Vue -->
  <script src="https://unpkg.com/vue/dist/vue.js"></script>
  <script src="<?php echo e(URL::asset('js/axios.min.js')); ?>"></script>
  <!-- 引入组件库 -->
  <script src="https://unpkg.com/mint-ui/lib/index.js"></script>
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
  </script>
  <?php echo $__env->yieldContent('script'); ?>
</html>