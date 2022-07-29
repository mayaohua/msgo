

	<meta charset="UTF-8">
	<meta content="target-densitydpi=device-dpi,width=740" name="viewport">
	<!-- <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"> -->
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>店铺首页</title>
	
	<style type="text/css">
		
		*{box-sizing: border-box;-moz-box-sizing:border-box; /* Firefox */-webkit-box-sizing:border-box; /* Safari */}
		body,dl,dd,ul,ol,h1,h2,h3,h4,h5,h6,pre,form,input,textarea,p,hr,thead,tbody,tfoot,th,td{margin:0;padding:0;}
		ul,ol{list-style:none;}
		a{text-decoration:none;}
		html{-ms-text-size-adjust:none;-webkit-text-size-adjust:none;text-size-adjust:none;}
		/* body{line-height:1.5; font-size:14px;} */
		body,button,input,select,textarea{font-family:'helvetica neue',tahoma,'hiragino sans gb',stheiti,'wenquanyi micro hei',5FAE8F6F96C59ED1,5B8B4F53,sans-serif;}
		b,strong{font-weight:bold;}
		i,em{font-style:normal;}
		table{border-collapse:collapse;border-spacing:0;}
		table th,table td{border:1px solid #ddd;padding:5px;}
		table th{font-weight:inherit;border-bottom-width:2px;border-bottom-color:#ccc;}
		img{border:0 none;width:auto9;max-width:100%;vertical-align:top; height:auto;}
		button,input,select,textarea{font-family:inherit;font-size:100%;margin:0;vertical-align:baseline;}
		button,html input[type="button"],input[type="reset"],input[type="submit"]{-webkit-appearance:button;cursor:pointer;}
		button[disabled],input[disabled]{cursor:default;}
		input[type="checkbox"],input[type="radio"]{box-sizing:border-box;padding:0;}
		input[type="search"]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;}
		input[type="search"]::-webkit-search-decoration{-webkit-appearance:none;}
		input:focus{outline:none;}
		select[size],select[multiple],select[size][multiple]{border:1px solid #AAA;padding:0;}
		article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block;}
		audio,canvas,video,progress{display:inline-block;}
		body{background:#fff;}
		input::-webkit-input-speech-button {display: none}
		button,input,textarea{
		-webkit-tap-highlight-color: rgba(0,0,0,0);
		}
		body{ width:740px;margin:0 auto; }
		@font-face
		{
			font-family: PingFang;
			src: url('https://huazj.oss-cn-beijing.aliyuncs.com/PingFang%20Medium.ttf');
		} 
		*{
			font-family: "PingFang";
		}
	</style>
	<style type="text/css">
		.header{
			background: url("https://huazj.oss-cn-beijing.aliyuncs.com/beijing.png") no-repeat center top;
			height: auto;
			border-top: 1px solid transparent;
			padding: 39.466642px;
			height: 390.72px;
			background-size: cover;
		}
		.app-nav-search{
			display: flex;
			align-items: center;
			margin-top: 19.733284px;
		}
		.app-nav{
			width: 29.6px;
			height: 39.466642px;
		}
		.app-nav img{
			width: 100%;
			height: 100%;
		}
		.app-search{
			background: rgba(255,255,255,0.7);
			width: 493.333284px;
			height: 49.333284px;
			border-radius: 27.626642px;
			/* margin: 0 auto; */
			margin-left: 51.8px;
			display: flex;
			align-items: center;
		}
		.app-search input{
			background: transparent;
			border: none;
			outline: none;
			color: #4c4c4c;
			font-size: 21.706642px;
			line-height: 49.333284px;
			height: 49.333284px;
			margin-left: 49.333284px;
			flex: 1;
		}
		.app-search img{
			width: 29.6px;
			height: 29.6px;
			position: relative;
			left: 19.733284px;
		}
		.app-shop{
			margin-top: 34.533284px;
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
		}
		.app-shop-left{
			display: flex;
			align-items: center;
		}
		.shop-pic{
			width: 63.146642px;
			height: 63.146642px;
		}
		.shop-pic img{
			width: 63.146642px;
			height: 63.146642px;
			border-radius: 3.946642px;
		}
		.shop-info{
			margin-left: 24.666642px;
			display: flex;
			flex-direction: column;
			justify-content: space-between;
		}
		.shop-info .shop-name{
			color: white;
			font-size: 29.6px;
		}
		.shop-info .shop-guan-users{
			font-size: 15.786642px;
		}
		.shop-ping{
			display: flex;
			align-items: center;
			padding:0 9.866642px;
			background: #fff;
			border-radius: 7.893284px;
			font-size: 17.76px;
			align-content: flex-start;
			width: max-content;
			margin-top: 0px;
		} 
		.shop-xing{
			margin-left: 9.866642px;
			display: flex;
		}
		.shop-ping-wrap{
			
		}
		.shop-xing img{
			margin-left: 4.93284px;
			width: 13.813284px;
			height: 13.813284px;
		}
		.shop-guan{
			display: flex;
			align-items: center;
			border-radius: 18.253284px;
			background-image: linear-gradient(#e82d5d, #ffb184);
			padding:3.9466642px 15.046642px;
		}
		.shop-guan span{
			font-size: 23.68px;
			color: white;
		}
		.shop-guan img{
			width: 19.733284px;
			height: 19.733284px;
			margin-left: 4.933284px;
		}
		.app-menu{
			margin-top: 19.733284px;
			display: flex;
			justify-content: space-between;
		}
		.menu-item{
			display: flex;
			flex-direction: column;
		}
		.menu-item a{
			font-size: 25.653284px;
			color: white;
		}
		.menu-item span{
			height: 3.946642px;
			border-radius: 1.973284px;
			background:transparent;
			margin-top: 5.92px;
		}
		.menu-item.on span{
			background-image: linear-gradient(to right,#e82d5d, #ffb184);
		}
		.footer{
			position: fixed;
			bottom: 0;
			left: 0;
			z-index: 9;
			background: white;
			width: 100%;
		}
		.foot-menu{
			display: flex;
			justify-content: space-between;
			align-items: center;
			width: 601.866642px;
			margin: 9.866642px auto;
			height: 88.8px;
		}
		.foot-menu .foot-item{
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			
		}
		.foot-menu .foot-item img{
			width: 49.333284px;
		}
		.foot-menu .foot-item span{
			font-size: 21.706642px;
			margin-top: 4.933284px;
		}
		.foot-menu .foot-item.on span{
			background-image: -webkit-linear-gradient(left, #e82d5d, #ffb184);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
		}
	</style>
	<style type="text/css">
	/* https://huazj.oss-cn-beijing.aliyuncs.com/PingFang%20Medium.ttf */
	
		.content{
			background-image:linear-gradient(#fdd4de,#cde8f8);
			
		}
		.app-content{
			background: url("https://huazj.oss-cn-beijing.aliyuncs.com/c5f146165ebcbaafc3aa573c6090d35b%20%E6%8B%B7%E8%B4%9D.png") no-repeat left top;
			padding-bottom: 130px;
			background-size: cover;
		}
		.app-swiper{
			
			height: 339.999975px;
			position: relative;
			top: -45px;
		}
		.app-swiper img{
			width: 100%;
			height: 100%;
		}
		.app-magin{
			margin: 0 auto;
			width: 669.999975px;
		}
		.app-quan{
			display: flex;
			justify-content: space-between;
		}
		.quan-item{
			width: 159.999975px;
			height: 117.999975px;
			background: url("https://huazj.oss-cn-beijing.aliyuncs.com/%E7%9F%A9%E5%BD%A2%203%20%E6%8B%B7%E8%B4%9D.png") no-repeat center;
			position: relative;
			background-size: cover;
		}
		.quan-dao{
			position: absolute;
			font-size: 17.82px;
			font-weight: bold;
			left: 34.99995px;
			top: 33.75px;
		}
		.quan-title{
			position: absolute;
			font-size: 43.47px;
			font-weight: bold;
			top: 7.5px;
			left: 49.99995px;
		}
		.quan-info{
			font-size: 16.029975px;
			color: white;
		}
		.quan-info-qj{
			font-size: 12px;
			color: white;
		}
		.quan-info-warp{
			width: 159.999975px;
			height: 49.99995px;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: space-around;
			position: absolute;
			top:67.5px
		}
		.product-case{
			margin-top: 30px;
		}
		.product-title{
			background: url("https://huazj.oss-cn-beijing.aliyuncs.com/%E7%9F%A9%E5%BD%A2%2010.png") no-repeat center;
			background-size: contain;
			width: 312px;
			margin: 0 auto;
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		.product-title span{
			/* display: flex; */
			
		}
		.title-blod{
			font-size: 30px;
			font-weight: bold;
			margin-top: 15px;
		}
		.title-en{
			color: #999999;
			font-size: 18px;
			text-transform: uppercase;
			letter-spacing: 0.999975px;
		}
		.product-hot,.product-zhuanxiang,.product-more{
			margin-top: 33.75px;
		}
		.case-pro-items{
			display: grid;
			grid-template-columns: repeat(auto-fill, 159.999975px);
			justify-content: space-between;
			column-gap: 0px;
			margin: 25.99995px 0;
		}
		.case-item{
			width: 159.999975px;
			display: flex;
			flex-direction: column;
			margin: 9.999975px 0;
		}
		.case-item:nth-child(even){
			margin-top: 62.499975px
		}
		.case-item img{
			/* width: 159.999975px; */
			padding:4.99995px;
			padding-bottom: 0;
			height: 229.99995px;
			box-shadow: 0px 2px 6px 0px #535353;
			border-radius: 9.999975px;
		}
		.case-item span{
			text-align: center;
		}
		.case-item .case-item-name{
			font-size: 21.999975px;
			margin-top: 12px;
		}
		.case-item .goto-page{
			font-size: 18px;
			font-weight: bold;
			border:1.99995px #ff2566 solid;
			color: #ff2566;
			border-radius: 3.999975px;
			padding:0 9.999975px;
		}
		.goto-wrap{
			margin: 0 auto;
			margin-top: 12px;
			display: flex;
		}
		.hot-pro-item{
			width: 669.999975px;
			height: 494.499975px;
			background: url("https://huazj.oss-cn-beijing.aliyuncs.com/%E5%BD%A2%E7%8A%B6%202%20%E6%8B%B7%E8%B4%9D.png") no-repeat center;
			margin-top: 19.99995px;
			background-size: cover;
			border-top: 1px solid transparent;
			display: flex;
			justify-content: space-between;
		}
		.hot-item{
			margin: 15px 19.99995px;
			width: 210px;
			text-align: right;
		}
		.hot-item img{
			width: 180px;
			height: 229.99995px;
			background: dodgerblue;
		}
		.hot-item span{
			display: block;
			color: white;
		}
		.hot-item .hot-name-en{
			font-size: 18px;
			text-transform: uppercase;
		}
		.hot-item .hot-name{
			font-size: 21.999975px;
			border-bottom: 1.99995px solid white;
			display: table;
			padding-bottom: 9.999975px;
		}
		.hot-item .hot-desc{
			font-size: 15.999975px;
			text-align: right;
			margin-top: 4.99995px;
		}
		.hot-text{
			text-align: right;
			display: flex;
			flex-direction: column;
			align-items: flex-end;
		}
		.hot-item .hot-goto{
			font-size: 18px;
			border-radius: 3.999975px;
			border: 1.99995px solid white;
			display: table;
			padding:0 12.49995px;
			margin-top: 9.999975px;
		}
		.hot-right{
			position: relative;
			top:62.499975px;
			display: flex;
			flex-direction: column;
			justify-items: end;
		}
		.hot-right img{
			margin-top: 7.5px;
		}
		.hot-right .hot-text{
			align-items: flex-start;
		}
		.hot-right .hot-desc{
			text-align: left;
		}
		.zhuanxiang-item{
			position: relative;
			width: 669.999975px;
			height: 267.999975px;
			margin-top: 30px;
		}
		.zhuanxiang-item img{
			width: 399.999975px;
			height: 267.999975px;
			background: dodgerblue;
			border-radius: 9.999975px;
			position: absolute;
			z-index: 1;
		}
		.zhuanxiang-item .zhuan-wrap{
			width: 286.99995px;
			height: 262.99995px;
			/* border: 2px solid salmon; */
			position: absolute;
			right: 0;
			top: 18px;
			background: url("https://huazj.oss-cn-beijing.aliyuncs.com/%E7%9F%A9%E5%BD%A2%2017.png") no-repeat;
			background-size: 100% 100%;
			display: flex;
			align-items: center;
		}
		.zhuanxiang-right img{
			right: 0;
			top: 0;
		}
		.zhuanxiang-right .zhuan-wrap{
			left: 0;
		}
		.zhuan-text{
			display: flex;
			flex-direction: column;
			margin-left: 30px;
			margin-right: 30px;
			align-items: flex-start;
		}
		.zhuan-text .hot-name-en{
			font-size: 18px;
			color: #333;
			text-transform: uppercase;
		}
		.zhuan-text .hot-name{
			font-size: 25.99995px;
			border-bottom: 1.99995px solid #333;
			display: table;
			padding-bottom: 9.999975px;
			color: #333;
		}
		.zhuan-text .hot-desc{
			font-size: 18px;
			color: #666;
		}
		.zhuan-text .hot-goto{
			font-size: 18px;
			border-radius: 3.999975px;
			border: 1.99995px solid #e82f5e;
			display: table;
			padding:0 12.49995px;
			margin-top: 9.999975px;
			color: #e82f5e;
		}
		.hot-dao{
			font-size: 18px;
		}
		.hot-price{
			font-size: 30px;
			color: #ff2566;
		}
		.zhuan-right{
			align-items: flex-end;
		}
		.zhuan-right .hot-desc{
			text-align: right;
		}
		.more-items{
			display: grid;
			margin-top: 39.999975px;
			grid-template-columns: repeat(auto-fill, minmax(324.999975px, 0fr));
			justify-content: space-between;
			grid-gap: 0.25em;
		}
		.more-item{
			border-radius: 9.999975px;
			background: white;
			width: 324.999975px;
			margin-bottom: 17.499975px;
		}
		.more-item .more-pic{
			width: 324.999975px;
			height: 333px;
		}
		.more-item .more-text{
			background: white;
		}
		.more-text{
			padding: 19.99995px 15px;
			border-bottom-left-radius: 9.999975px;
			border-bottom-right-radius: 9.999975px;
		}
		.more-text .more-t-w .more-name{
			font-size: 25.99995px;
		}
		.more-text .more-hot{
			font-size: 15.999975px;
			background: #e82f5e;
			color: white;
			padding:0.75px 15px;
			border-radius: 10.99995px;
			position: relative;
			top:0;
			margin-right: 4.99995px;
			
		}
		.more-text .more-hot-img{
			background: url("https://huazj.oss-cn-beijing.aliyuncs.com/re-xiao-1.png") no-repeat center;
			height: 37.5px;
			width: 45px;
			display: inline-block;
			background-size: 100% 100%;
		}
		.more-text .more-tags{
			margin-top: 12.49995px;
			font-size: 21.999975px;
			display: block;
			color: #888888;
		}
		.more-text .more-top{
			margin-top: 12.49995px;
			font-size: 21.999975px;
			display: block;
			color: #ff0000;
		}
		.more-text .more-price-wrap{
			margin-top: 12.49995px;
			display: flex;
			font-size: 21.999975px;
			color: #888888;
			align-items: center;
		}
		.more-text .more-dao{
			font-size: 12px;
			color: #ea4d4d;
		}
		.more-text .more-price{
			font-size: 30px;
			color: #ea4d4d;
		}
		.more-text .more-people{
			margin-left: 9.999975px;
		}
		.more-text .more-bottom{
			margin-top: 12.49995px;
			display: flex;
		}
		.more-text .more-bottom span{
			font-size: 18px;
			color: #666;
		}
		.more-haopin{
			margin-left: 9.999975px;
		}
		.more-quan{
			margin-top: 12.49995px;
			font-size: 15.999975px;
			color: #ff2566;
			border: 1px dashed red;
			display: table;
			padding:0 15px;
			border-radius: 3.999975px;
		}
		.back-top{
			width: 144px;
			height: 45px;
			text-align: center;
			line-height: 45px;
			border-radius: 9.999975px;
			color: white;
			font-size: 24px;
			margin: 0 auto;
			background: #e82f5e;
		}

	</style>
	<!-- <script type="text/javascript">
		!function(e,t){function n(){t.body?t.body.style.fontSize=12*o+"px":t.addEventListener("DOMContentLoaded",n)}function d(){var e=i.clientWidth/10;i.style.fontSize=e+"px"}var i=t.documentElement,o=e.devicePixelRatio||1;if(n(),d(),e.addEventListener("resize",d),e.addEventListener("pageshow",function(e){e.persisted&&d()}),o>=2){var a=t.createElement("body"),s=t.createElement("div");s.style.border=".5px solid transparent",a.appendChild(s),i.appendChild(a),1===s.offsetHeight&&i.classList.add("hairlines"),i.removeChild(a)}}(window,document);
	</script> -->
	<script src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
    <script src="https://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
    $.get('https://wx.msgo.xyz/api/js_config',function(res){
        console.log('js配置信息：')
        console.log(res.data)
        wx.config(res.data);
    })
    var  goods = function(){
		    wx.miniProgram.getEnv(function (res) {
               if (res.miniprogram) {
                   alert(2);
                 wx.miniProgram.navigateTo({url: '/pages/detail/detail'});
               }else{
                   alert(6);
               }
             });
             alert(3);
		}
    </script>
	<script type="text/javascript">
		!function () {
		  var opt = function() {
		    var ua = navigator.userAgent,
		      android = ua.match(/(Android);?[\s\/]+([\d.]+)?/),
		      ipad = ua.match(/(iPad).*OS\s([\d_]+)/),
		      ipod = ua.match(/(iPod)(.*OS\s([\d_]+))?/),
		      iphone = !ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/),
		      os = {};
		  
		    if (android){ os.android = true, os.version = android[2];}
		    if (iphone && !ipod) {os.ios = os.iphone = true, os.version = iphone[2].replace(/_/g, '.');}
		    if (ipad) {os.ios = os.ipad = true, os.version = ipad[2].replace(/_/g, '.');}
		    if (ipod) {os.ios = os.ipod = true, os.version = ipod[3] ? ipod[3].replace(/_/g, '.') : null;}
		  
		    var MetaHandler = function(){
		      //MONOSTATE
		      if(MetaHandler.prototype.instance){
		        return MetaHandler.prototype.instance;
		      }
		      var me = this;
		      var meta = {},_els;
		  
		      /**
		       * _els
		       * meta = {name:{content:String,seriation:Array,store:{property:String},...},...}
		       * @method init
		       */
		      function init(){
		        _els = document.getElementsByTagName('meta');
		        for(var i=0;i<_els.length;i++){
		          var name = _els[i].name;
		          if(name){
		            meta[name] = {};
		            meta[name].el = _els[i];
		            meta[name].content = _els[i].content;
		            meta[name].seriation = meta[name].content.split(',');
		            meta[name].store = getContentStore(name);
		          }
		        }
		        return me;
		      }
		      function getContentStore(name){
		        var content = meta[name].seriation,store = {};
		        for(var i=0;i<content.length;i++){
		          if(content[i].length<1){
		            content[i] = null;
		            delete content[i];
		            content.length--;
		          }else{
		            var ct = content[i].split('='),
		              pp = ct[0];
		            if(pp){
		              store[pp] = ct[1];
		            }
		          }
		        }
		        return store;
		      }
		      this.hasMeta = function(name){
		        return meta[name]?1:0;
		      }
		      this.createMeta = function(name){
		        if(!this.hasMeta(name)){
		          var el = document.createElement('meta');
		          el.name = name;
		          document.head.appendChild(el);
		          meta[name] = {};
		          meta[name].el = el;
		          meta[name].content = '';
		          meta[name].seriation = [];
		          meta[name].store = {};
		        }
		        return me;
		      }
		      this.setContent = function(name,value){
		        meta[name].content = value;
		        meta[name].el.content = value;
		        return me;
		      }
		      this.getContent = function(name){
		        return meta[name] && meta[name].content;
		      }
		      function updateContent(name){
		        meta[name].content = meta[name].seriation.join(',');
		        me.setContent(name,meta[name].content);
		        return me;
		      }
		      this.removeContentProperty = function(name,property){
		        var _property = property;
		        if(meta[name]){
		          if(meta[name].store[_property]!=null){
		            for(var i = 0;i<meta[name].seriation.length;i++){
		              if(meta[name].seriation[i].indexOf(property+'=')!=-1){
		                meta[name].seriation[i] = null;
		                delete meta[name].seriation[i];
		                break;
		              }
		            }
		          }
		          updateContent(name);
		        }
		        return me;
		      }
		      this.getContentProperty = function(name,property){
		        return meta[name] && meta[name].store[property];
		      }
		      this.setContentProperty = function(name,property,value){
		        var _property = property,
		          pv = property+'='+value;
		        if(meta[name]){
		          if(meta[name].store[_property]!=null){
		            meta[name].store[_property] = value;
		            for(var i = 0;i<meta[name].seriation.length;i++){
		              if(meta[name].seriation[i].indexOf(property+'=')!=-1){
		                meta[name].seriation[i] = pv;
		                break;
		              }
		            }
		          }else{
		            meta[name].store[_property] = value;
		            meta[name].seriation.push(pv);
		          }
		          updateContent(name);
		        }
		        return me;
		      }
		  
		      this.fixViewportWidth = function(width,fixBody){
		        width = width || me.getContentProperty('viewport','width');
		        if(width != 'device-width'){
		          var iw = window.innerWidth || width,
		            ow = window.outerWidth || iw,
		            sw = window.screen.width || iw,
		            saw = window.screen.availWidth || iw,
		            ih = window.innerHeight || width,
		            oh = window.outerHeight || ih,
		            sh = window.screen.height || ih,
		            sah = window.screen.availHeight || ih,
		            w = Math.min(iw,ow,sw,saw,ih,oh,sh,sah),
		            ratio = w/width,
		            dpr = window.devicePixelRatio;
		          ratio = Math.min(ratio,dpr);
		  
		          //fixBody may trigger a reflow,you should not use it if you could do it in your css
		          if(fixBody){
		            document.body.style.width = width+'px';
		          }
		  
		          if(os.android){
		            me.removeContentProperty('viewport','user-scalable')
		              .setContentProperty('viewport','target-densitydpi','device-dpi')
		              .setContentProperty('viewport','initial-scale',ratio)
		              .setContentProperty('viewport','maximum-scale',ratio);
		          }else if(os.ios && !os.android){
		            me.setContentProperty('viewport','user-scalable','no');
		            if(os.ios && parseInt(os.version)<7){
		              me.setContentProperty('viewport','initial-scale',ratio);
		            }
		          }
		        }
		      }
		      init();
		      //MONOSTATE
		      MetaHandler.prototype.instance = this;
		    };
		    return new MetaHandler;
		  }();
		  
		  // // 调用自适应屏幕的功能函数
		  opt.fixViewportWidth(750);
		}();
	</script>
</head>

	<div class="header">
		<div class="app-nav-search">
			<div class="app-nav">
				<img src="https://huazj.oss-cn-beijing.aliyuncs.com/back_btn.png" alt="">
			</div>
			<div class="app-search">
				<img src="https://huazj.oss-cn-beijing.aliyuncs.com/search_btn.png" alt="">
				<input type="text" placeholder="请输入花名\关键词">
			</div>
		</div>
		<div class="app-shop">
			<div class="app-shop-left">
				<div class="shop-pic">
					<img src="https://huazj.oss-cn-beijing.aliyuncs.com/touxiang.png" alt="">
				</div>
				<div class="shop-info">
					<div class="shop-name">
						<span class="shop-name-span">花都之家玫瑰</span>
						<span class="shop-guan-users">12.5万人关注</span>
					</div>
					<div class="shop-ping">
						<span>店铺评价</span>
						<div class="shop-xing">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/wujiao.png" alt="">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/wujiao.png" alt="">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/wujiao.png" alt="">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/wujiao.png" alt="">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/wujiao.png" alt="">
						</div>
					</div>
				</div>
			</div>
			<div class="shop-guan">
				<span>关注</span>
				<img src="https://huazj.oss-cn-beijing.aliyuncs.com/xingxing.png" alt="">
			</div>
		</div>
		<div class="app-menu">
			<div class="menu-item on">
				<a href="#">精选</a>
				<span></span>
			</div>
			<div class="menu-item">
				<a href="#">商品</a>
				<span></span>
			</div>
			<div class="menu-item">
				<a href="#">买家秀</a>
				<span></span>
			</div>
			<div class="menu-item">
				<a href="#">活动</a>
				<span></span>
			</div>
			<div class="menu-item">
				<a href="#">新品</a>
				<span></span>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="app-content">
			<div class="app-magin">
				<div class="app-swiper">
					<img src="https://huazj.oss-cn-beijing.aliyuncs.com/roses-821705_1920.png">
				</div>
				<div class="app-quan">
					<div class="quan-item" onclick="goods()">
						<div class="quan-title-warp">
							<span class="quan-dao">￥</span>
							<span class="quan-title">100</span>
						</div>
						<div class="quan-info-warp">
							<span class="quan-info">购物优惠券</span>
							<span class="quan-info-qj">（满500即可使用）</span>
						</div>
					</div>
					<div class="quan-item">
						<div class="quan-title-warp">
							<span class="quan-dao">￥</span>
							<span class="quan-title">100</span>
						</div>
						<div class="quan-info-warp">
							<span class="quan-info">购物优惠券</span>
							<span class="quan-info-qj">（满500即可使用）</span>
						</div>
					</div>
					<div class="quan-item">
						<div class="quan-title-warp">
							<span class="quan-dao">￥</span>
							<span class="quan-title">100</span>
						</div>
						<div class="quan-info-warp">
							<span class="quan-info">购物优惠券</span>
							<span class="quan-info-qj">（满500即可使用）</span>
						</div>
					</div>
				</div>
				<div class="product-case">
					<div class="product-title">
						<span class="title-blod">产品分类</span>
						<span class="title-en">Product classification</span>
					</div>
					<div class="case-pro-items">
						<div class="case-item">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/5ede3ea3e4a7735bcefd941cc91a9a33.png">
							<span class="case-item-name">红玫瑰专区</span>
							<div class="goto-wrap">
								<span class="goto-page">点击进入</span>
							</div>
						</div>
						<div class="case-item">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/74b8a29c24b09247808450a457dbea4a.png">
							<span class="case-item-name">粉玫瑰专区</span>
							<div class="goto-wrap">
								<span class="goto-page">点击进入</span>
							</div>
						</div>
						<div class="case-item">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/f70909e46995cbb9347e8a5fbdb68594.png">
							<span class="case-item-name">白玫瑰专区</span>
							<div class="goto-wrap">
								<span class="goto-page">点击进入</span>
							</div>
						</div>
						<div class="case-item">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/092add4320ba464f0b23913964dbaa80.png">
							<span class="case-item-name">蓝玫瑰专区</span>
							<div class="goto-wrap">
								<span class="goto-page">点击进入</span>
							</div>
						</div>
					</div>
				</div>
				<div class="product-hot">
					<div class="product-title">
						<span class="title-blod">热销推荐</span>
						<span class="title-en">hot-sale product</span>
					</div>
					<div class="hot-pro-item">
						<div class="hot-item">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/sp2.png">
							<div class="hot-text">
								<span class="hot-name-en">Pink rose gift box</span>
								<span class="hot-name">白玫瑰礼盒</span>
								<span class="hot-desc">产品介绍产品介绍产品介绍产品介绍产品介</span>
								<span class="hot-goto">点击进入</span>
							</div>
						</div>
						<div class="hot-item hot-right">
							<div class="hot-text">
								<span class="hot-name-en">Pink rose gift box</span>
								<span class="hot-name">白玫瑰礼盒</span>
								<span class="hot-desc">产品介绍产品介绍产品介绍产品介绍产品介</span>
								<span class="hot-goto">点击进入</span>
							</div>
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/sp1.png">
						</div>
					</div>
					<div class="hot-pro-item" style="margin-top: -0.33rem;">
						<div class="hot-item">
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/sp3.png">
							<div class="hot-text">
								<span class="hot-name-en">Pink rose gift box</span>
								<span class="hot-name">白玫瑰礼盒</span>
								<span class="hot-desc">产品介绍产品介绍产品介绍产品介绍产品介</span>
								<span class="hot-goto">点击进入</span>
							</div>
						</div>
						<div class="hot-item hot-right">
							<div class="hot-text">
								<span class="hot-name-en">Pink rose gift box</span>
								<span class="hot-name">白玫瑰礼盒</span>
								<span class="hot-desc">产品介绍产品介绍产品介绍产品介绍产品介</span>
								<span class="hot-goto">点击进入</span>
							</div>
							<img src="https://huazj.oss-cn-beijing.aliyuncs.com/sp4.png">
						</div>
					</div>
				</div>
				<div class="product-zhuanxiang">
					<div class="product-title">
						<span class="title-blod">专享礼遇</span>
						<span class="title-en">Exclusive treatment</span>
					</div>
					<div class="zhuanxiang-item">
						<img src="https://huazj.oss-cn-beijing.aliyuncs.com/tu1.png" alt="">
						<div class="zhuan-wrap">
							<div class="zhuan-text">
								<span class="hot-name-en">Pink rose gift box</span>
								<span class="hot-name">白玫瑰礼盒</span>
								<span class="hot-desc">产品介绍产品介绍产品介绍产品</span>
								<span class="hot-price"> <i class="hot-dao">￥</i>195</span>
								<span class="hot-goto">点击进入</span>
							</div>
						</div>
					</div>
					<div class="zhuanxiang-item zhuanxiang-right">
						<img src="https://huazj.oss-cn-beijing.aliyuncs.com/tu2.png" alt="">
						<div class="zhuan-wrap">
							<div class="zhuan-text zhuan-right">
								<span class="hot-name-en">Pink rose gift box</span>
								<span class="hot-name">白玫瑰礼盒</span>
								<span class="hot-desc">产品介绍产品介绍产品介绍产品</span>
								<span class="hot-price"> <i class="hot-dao">￥</i>195</span>
								<span class="hot-goto">点击进入</span>
							</div>
						</div>
					</div>
					<div class="zhuanxiang-item">
						<img src="https://huazj.oss-cn-beijing.aliyuncs.com/tu3.png" alt="">
						<div class="zhuan-wrap">
							<div class="zhuan-text">
								<span class="hot-name-en">Pink rose gift box</span>
								<span class="hot-name">白玫瑰礼盒</span>
								<span class="hot-desc">产品介绍产品介绍产品介绍产品</span>
								<span class="hot-price"> <i class="hot-dao">￥</i>195</span>
								<span class="hot-goto">点击进入</span>
							</div>
						</div>
					</div>
				</div>
				<div class="product-more">
					<div class="product-title">
						<span class="title-blod">更多推荐</span>
						<span class="title-en">More recommendations</span>
					</div>
					<div class="more-items">
						<div class="more-item">
							<img class="more-pic" src="https://huazj.oss-cn-beijing.aliyuncs.com/a7a1c3709842ee902ed0f1a620aaa4cd52276449ec92-d6ZZQr_fw1200.png" alt="">
							<div class="more-text">
								<div class="more-t-w">
									<p class="more-name"><span class="more-hot">热销</span>520情人节鲜花速递同</p>
								</div>
								<div class="more-tags">混搭花束 | 表达爱意 | 情人节| 表达爱意 | 情人节</div>
								<div class="more-price-wrap">
									<span class="more-dao">￥</span>
									<span class="more-price">119.99</span>
									<span class="more-people">11212人付款</span>
								</div>
								
								<div class="more-bottom">
									<span class="more-say">1万+条评论</span>
									<span class="more-haopin">98%好评</span>
								</div>
							</div>
						</div>
						<div class="more-item">
							<img class="more-pic" src="https://huazj.oss-cn-beijing.aliyuncs.com/a7a1c3709842ee902ed0f1a620aaa4cd52276449ec92-d6ZZQr_fw1200.png" alt="">
							<div class="more-text">
								<div class="more-t-w">
									<p class="more-name"><span class="more-hot more-hot-img"></span>520情人节鲜花速递同</p>
								</div>
								<div class="more-top">本店产品速卖热销榜第2名</div>
								<div class="more-price-wrap">
									<span class="more-dao">￥</span>
									<span class="more-price">119.99</span>
									<span class="more-people">11212人付款</span>
								</div>
								
								<div class="more-quan">
									满100减10元
								</div> 
							</div>
						</div>
						<div class="more-item">
							<img class="more-pic" src="https://huazj.oss-cn-beijing.aliyuncs.com/a7a1c3709842ee902ed0f1a620aaa4cd52276449ec92-d6ZZQr_fw1200.png" alt="">
							<div class="more-text">
								<div class="more-t-w">
									<p class="more-name"><span class="more-hot">热销</span>520情人节鲜花速递同</p>
								</div>
								<div class="more-tags">混搭花束 | 表达爱意 | 情人节| 表达爱意 | 情人节</div>
								<div class="more-price-wrap">
									<span class="more-dao">￥</span>
									<span class="more-price">119.99</span>
									<span class="more-people">11212人付款</span>
								</div>
								
								<div class="more-bottom">
									<span class="more-say">1万+条评论</span>
									<span class="more-haopin">98%好评</span>
								</div>
							</div>
						</div>
						<div class="more-item">
							<img class="more-pic" src="https://huazj.oss-cn-beijing.aliyuncs.com/a7a1c3709842ee902ed0f1a620aaa4cd52276449ec92-d6ZZQr_fw1200.png" alt="">
							<div class="more-text">
								<div class="more-t-w">
									<p class="more-name"><span class="more-hot">热销</span>520情人节鲜花速递同</p>
								</div>
								<div class="more-tags">混搭花束 | 表达爱意 | 情人节| 表达爱意 | 情人节</div>
								<div class="more-price-wrap">
									<span class="more-dao">￥</span>
									<span class="more-price">119.99</span>
									<span class="more-people">11212人付款</span>
								</div>
								
								<div class="more-bottom">
									<span class="more-say">1万+条评论</span>
									<span class="more-haopin">98%好评</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="back-top" onclick="document.body.scrollTop = 0;document.documentElement.scrollTop = 0;">
					返回顶部
				</div>
			</div>
		</div>
		
	</div>
	<div class="footer">
		<div class="foot-menu">
			<div class="foot-item on">
				<img src="https://huazj.oss-cn-beijing.aliyuncs.com/shouye%20%E6%8B%B7%E8%B4%9D%202.png" alt="">
				<span>首页</span>
			</div>
			<div class="foot-item">
				<img src="https://huazj.oss-cn-beijing.aliyuncs.com/%E7%9F%A9%E5%BD%A2%204%20%E6%8B%B7%E8%B4%9D%203.png" alt="">
				<span>分类</span>
			</div>
			<div class="foot-item">
				<img src="https://huazj.oss-cn-beijing.aliyuncs.com/%E6%A4%AD%E5%9C%86%205%20%E6%8B%B7%E8%B4%9D.png" alt="">
				<span>我的</span>
			</div>
		</div>
	</div>

