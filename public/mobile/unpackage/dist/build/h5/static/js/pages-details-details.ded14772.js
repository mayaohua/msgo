(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-details-details"],{"07bb":function(t,e,i){"use strict";var n=i("4186"),r=i.n(n);r.a},"0d29":function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return r})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}));var r=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"carousel-3d-container",style:{height:this.slideHeight+"px"}},[i("v-uni-view",{staticClass:"carousel-3d-slider",style:{width:this.slideWidth+"px",height:this.slideHeight+"px"}},[t._t("default")],2)],1)},s=[]},"0ed1":function(t,e,i){"use strict";i.r(e);var n=i("27c9"),r=i("87c4");for(var s in r)"default"!==s&&function(t){i.d(e,t,(function(){return r[t]}))}(s);i("07bb");var a,o=i("f0c5"),d=Object(o["a"])(r["default"],n["b"],n["c"],!1,null,"ad5378cc",null,!1,n["a"],a);e["default"]=d.exports},"12a3":function(t,e,i){"use strict";var n=i("4ea4");i("a9e3"),i("e25e"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r=n(i("ade3")),s={name:"curry-slide",props:{index:{type:Number}},data:function(){return{parent:this.$parent.$parent.$parent,styles:{},zIndex:999}},computed:{isCurrent:function(){return this.index===this.parent.currentIndex},leftIndex:function(){return this.getSideIndex(this.parent.leftIndices)},rightIndex:function(){return this.getSideIndex(this.parent.rightIndices)},slideStyle:function(){var t={};if(!this.isCurrent){var e=this.leftIndex,i=this.rightIndex;(e>=0||i>=0)&&(t=e>=0?this.calculatePosition(e,!0,this.zIndex):this.calculatePosition(i,!1,this.zIndex),t.opacity=1,t.visibility="visible"),this.parent.hasHiddenSlides&&(this.matchIndex(this.parent.leftOutIndex)?t=this.calculatePosition(this.parent.leftIndices.length-1,!1,this.zIndex):this.matchIndex(this.parent.rightOutIndex)&&(t=this.calculatePosition(this.parent.rightIndices.length-1,!0,this.zIndex)))}return Object.assign(t,{"border-width":"0px",width:this.parent.slideWidth+"px",height:this.parent.slideHeight+"px",transition:" transform "+this.parent.animationSpeed+"ms,                opacity "+this.parent.animationSpeed+"ms,                visibility "+this.parent.animationSpeed+"ms"})},computedClasses:function(){var t;return t={},(0,r.default)(t,"left-".concat(this.leftIndex+1),this.leftIndex>=0),(0,r.default)(t,"right-".concat(this.rightIndex+1),this.rightIndex>=0),(0,r.default)(t,"current",this.isCurrent),t}},methods:{getSideIndex:function(t){for(var e=-1,i=0;i<t.length;i++)this.matchIndex(t[i])&&(e=i);return e},matchIndex:function(t){return t>=0?this.index===t:this.parent.total+t===this.index},calculatePosition:function(t,e,i){var n=this.parent.disable3d?0:parseInt(this.parent.inverseScaling)+100*(t+1),r=this.parent.disable3d?0:parseInt(this.parent.perspective),s="auto"===this.parent.space?parseInt((t+1)*(this.parent.width/1.2),10):parseInt((t+1)*this.parent.space,10),a=e?"translateX("+s+"px) translateZ(-"+n+"px) rotateY(-"+r+"deg)":"translateX(-"+s+"px) translateZ(-"+n+"px) rotateY("+r+"deg)",o="auto"===this.parent.space?0:parseInt((t+1)*this.parent.space);return{transform:a,top:o,zIndex:i-(Math.abs(t)+1)}},goTo:function(){this.isCurrent?this.parent.onMainSlideClick():!0===this.parent.clickable&&this.parent.goFar(this.index)}}};e.default=s},"27c9":function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return r})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}));var r=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"carousel-3d-slide",class:t.computedClasses,style:t.slideStyle,on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.goTo()}}},[t._t("default",null,{index:t.index,isCurrent:t.isCurrent,leftIndex:t.leftIndex,rightIndex:t.rightIndex})],2)},s=[]},4186:function(t,e,i){var n=i("ed80");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var r=i("4f06").default;r("03ec2bf2",n,!0,{sourceMap:!1,shadowMode:!1})},5450:function(t,e,i){"use strict";i.r(e);var n=i("cf5c"),r=i("6a81");for(var s in r)"default"!==s&&function(t){i.d(e,t,(function(){return r[t]}))}(s);i("8a9a");var a,o=i("f0c5"),d=Object(o["a"])(r["default"],n["b"],n["c"],!1,null,"5449de48",null,!1,n["a"],a);e["default"]=d.exports},"55e1":function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,".detail-img[data-v-5449de48]{width:100%;margin:0;padding:0;display:block}.swp-wrap[data-v-5449de48]{padding:.3rem 1.2rem;position:relative;max-width:40rem;margin:0 auto}.btn-wrapper[data-v-5449de48]{padding:10px 0;text-align:center;position:relative;z-index:1}",""]),t.exports=e},"5aff":function(t,e,i){"use strict";var n=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r=n(i("e262")),s=n(i("ad54")),a=n(i("0ed1")),o={data:function(){return{data:{lt_data:null},lt:{img_url:"https://res.mall.10010.cn/mall/scaffold-img",detail_url:"https://m.10010.com/decoration-data/scaffold/queryPagealiasProData?page_alias="}}},components:{currySwiper:s.default,currySlide:a.default},onLoad:function(t){var e=this,i=t.index;void 0==i&&(i=0),this.$nextTick((function(t){e.getDetails(i)}))},computed:{syncBtnStyle:function(){var t=this.data.lt_data.button_detail[0],e={display:"inline-block",width:t.button_width/16+"rem",height:t.button_height/16+"rem","font-size":t.button_font_size/16+"rem","border-radius":t.button_radius/16+"rem",background:'url("'+this.lt.img_url+t.button_bg_url+'") 0% 0% / 100% 100%'};return e},syncBtnWrapStyle:function(){var t=this.data.lt_data.button_detail[0],e={"margin-top":t.btn_margin_top/16+"rem","margin-bottom":t.btn_margin_bottom/16+"rem","margin-left":t.btn_margin_left/16+"rem"};return e},syncSwpStyle:function(){var t=this.data.lt_data.sim_Slide;return{"margin-top":t.productPosition/16+"rem"}}},methods:{getDetails:function(t){var e=this;uni.request({url:r.default.Host+"mobile/details?index="+t,success:function(t){0==t.data.code&&(e.data=t.data.data)}})},toDetails:function(t){uni.navigateTo({url:"/pages/details/details?index="+t})}}};e.default=o},6278:function(t,e,i){var n=i("55e1");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var r=i("4f06").default;r("6ad70dee",n,!0,{sourceMap:!1,shadowMode:!1})},"6a81":function(t,e,i){"use strict";i.r(e);var n=i("5aff"),r=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=r.a},7343:function(t,e,i){"use strict";i.r(e);var n=i("f7a9"),r=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=r.a},"87c4":function(t,e,i){"use strict";i.r(e);var n=i("12a3"),r=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=r.a},"8a9a":function(t,e,i){"use strict";var n=i("6278"),r=i.n(n);r.a},ad54:function(t,e,i){"use strict";i.r(e);var n=i("0d29"),r=i("7343");for(var s in r)"default"!==s&&function(t){i.d(e,t,(function(){return r[t]}))}(s);i("e7cd");var a,o=i("f0c5"),d=Object(o["a"])(r["default"],n["b"],n["c"],!1,null,"69ba24fb",null,!1,n["a"],a);e["default"]=d.exports},cf5c:function(t,e,i){"use strict";i.d(e,"b",(function(){return r})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}));var n={currySwiper:i("ad54").default},r=function(){var t=this,e=t.$createElement,i=t._self._c||e;return t.data.lt_data?i("v-uni-view",{staticClass:"content",style:{"background-color":t.data.lt_data.page_bg.page_color}},[i("v-uni-view",{staticClass:"top-img"},t._l(t.data.lt_data.top_img_detail.images,(function(e,n){return i("v-uni-image",{key:n,staticClass:"detail-img",attrs:{mode:"widthFix",src:t.lt.img_url+e.image_url}})})),1),i("v-uni-view",{staticClass:"ui-swp"},[i("v-uni-view",{staticClass:"swp-wrap",style:t.syncSwpStyle},[i("curry-swiper",{ref:"swiper",attrs:{width:195,space:112,inverseScaling:400,height:107,perspective:14,border:3,count:10}},t._l(t.data.lt_data.sim_Slide.switchImg,(function(e,n){return i("curry-slide",{key:n,attrs:{index:n},scopedSlots:t._u([{key:"default",fn:function(n){var r=n.index,s=n.isCurrent,a=n.leftIndex,o=n.rightIndex;return[i("v-uni-image",{class:{current:s,onLeft:a>=0,onRight:o>=0},staticStyle:{width:"100%"},attrs:{mode:"widthFix","data-index":r,src:t.lt.img_url+e.image}})]}}],null,!0)})})),1)],1)],1),i("v-uni-view",{staticClass:"ui-action"},[i("v-uni-view",{staticClass:"btn-wrapper",style:t.syncBtnWrapStyle},[i("v-uni-view",{style:t.syncBtnStyle})],1)],1),i("v-uni-view",{staticClass:"det-img"},t._l(t.data.lt_data.detail_img_detail.images,(function(e,n){return i("v-uni-image",{key:n,staticClass:"detail-img",attrs:{mode:"widthFix",src:t.lt.img_url+e.image_url}})})),1)],1):t._e()},s=[]},e262:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n="https://wx.1001020.cn/api/",r={Host:n};e.default=r},e7cd:function(t,e,i){"use strict";var n=i("fb1d"),r=i.n(n);r.a},ed80:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,".carousel-3d-slide[data-v-ad5378cc]{position:absolute;opacity:0;visibility:hidden;overflow:hidden;top:0;border-color:#023c41;border-style:solid;background-size:cover;\n  /* background-color: #ccc; */display:block;margin:0;box-sizing:border-box}.carousel-3d-slide[data-v-ad5378cc]{text-align:left}.carousel-3d-slide img[data-v-ad5378cc]{width:100%}.carousel-3d-slide.current[data-v-ad5378cc]{opacity:1!important;visibility:visible!important;-webkit-transform:none!important;transform:none!important;z-index:999}",""]),t.exports=e},f152:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\r\n/**\r\n * 这里是uni-app内置的常用样式变量\r\n *\r\n * uni-app 官方扩展插件及插件市场（https://ext.dcloud.net.cn）上很多三方插件均使用了这些样式变量\r\n * 如果你是插件开发者，建议你使用scss预处理，并在插件代码中直接使用这些变量（无需 import 这个文件），方便用户通过搭积木的方式开发整体风格一致的App\r\n *\r\n */\r\n/**\r\n * 如果你是App开发者（插件使用者），你可以通过修改这些变量来定制自己的插件主题，实现自定义主题功能\r\n *\r\n * 如果你的项目同样使用了scss预处理，你也可以直接在你的 scss 代码中使用如下变量，同时无需 import 这个文件\r\n */\r\n/* 颜色变量 */\r\n/* 行为相关颜色 */\r\n/* 文字基本颜色 */\r\n/* 背景颜色 */\r\n/* 边框颜色 */\r\n/* 尺寸变量 */\r\n/* 文字尺寸 */\r\n/* 图片尺寸 */\r\n/* Border Radius */\r\n/* 水平间距 */\r\n/* 垂直间距 */\r\n/* 透明度 */\r\n/* 文章场景相关 */.carousel-3d-container[data-v-69ba24fb]{min-height:1px;width:100%;position:relative;z-index:0;overflow:hidden;margin:0 auto;box-sizing:border-box}.carousel-3d-slider[data-v-69ba24fb]{position:relative;margin:0 auto;-webkit-transform-style:preserve-3d;transform-style:preserve-3d;-webkit-perspective:1000px;-moz-perspective:1000px;perspective:1000px}',""]),t.exports=e},f7a9:function(t,e,i){"use strict";(function(t){i("4de4"),i("a9e3"),i("e25e"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=function(){},r={name:"curry-swiper",props:{count:{type:[Number,String],default:0},perspective:{type:[Number,String],default:35},display:{type:[Number,String],default:3},loop:{type:Boolean,default:!0},animationSpeed:{type:[Number,String],default:500},dir:{type:String,default:"ltr"},width:{type:[Number,String],default:360},height:{type:[Number,String],default:270},border:{type:[Number,String],default:1},space:{type:[Number,String],default:"auto"},startIndex:{type:[Number,String],default:0},clickable:{type:Boolean,default:!0},disable3d:{type:Boolean,default:!1},minSwipeDistance:{type:Number,default:10},inverseScaling:{type:[Number,String],default:300},onLastSlide:{type:Function,default:n},onSlideChange:{type:Function,default:n},bias:{type:String,default:"left"},onMainSlideClick:{type:Function,default:n}},data:function(){return{viewport:0,currentIndex:0,total:0,dragOffset:0,dragStartX:0,mousedown:!1,zIndex:998}},watch:{count:function(){this.computeData()}},computed:{isLastSlide:function(){return this.currentIndex===this.total-1},isFirstSlide:function(){return 0===this.currentIndex},isNextPossible:function(){return!(!this.loop&&this.isLastSlide)},isPrevPossible:function(){return!(!this.loop&&this.isFirstSlide)},slideWidth:function(){var t=this.viewport,e=parseInt(this.width)+2*parseInt(this.border,10);return t<e?t:e},slideHeight:function(){var t=parseInt(this.width,10)+2*parseInt(this.border,10),e=parseInt(parseInt(this.height)+2*this.border,10),i=this.calculateAspectRatio(t,e);return this.slideWidth/i},visible:function(){var t=this.display>this.total?this.total:this.display;return t},hasHiddenSlides:function(){return this.total>this.visible},leftIndices:function(){var t=(this.visible-1)/2;t="left"===this.bias.toLowerCase()?Math.ceil(t):Math.floor(t);for(var e=[],i=1;i<=t;i++)e.push("ltr"===this.dir?(this.currentIndex+i)%this.total:(this.currentIndex-i)%this.total);return e},rightIndices:function(){var t=(this.visible-1)/2;t="right"===this.bias.toLowerCase()?Math.ceil(t):Math.floor(t);for(var e=[],i=1;i<=t;i++)e.push("ltr"===this.dir?(this.currentIndex-i)%this.total:(this.currentIndex+i)%this.total);return e},leftOutIndex:function(){var t=(this.visible-1)/2;return t="left"===this.bias.toLowerCase()?Math.ceil(t):Math.floor(t),t++,"ltr"===this.dir?this.total-this.currentIndex-t<=0?-parseInt(this.total-this.currentIndex-t):this.currentIndex+t:this.currentIndex-t},rightOutIndex:function(){var t=(this.visible-1)/2;return t="right"===this.bias.toLowerCase()?Math.ceil(t):Math.floor(t),t++,"ltr"===this.dir?this.currentIndex-t:this.total-this.currentIndex-t<=0?-parseInt(this.total-this.currentIndex-t,10):this.currentIndex+t}},methods:{goNext:function(){this.isNextPossible&&(this.isLastSlide?this.goSlide(0):this.goSlide(this.currentIndex+1))},goPrev:function(){this.isPrevPossible&&(this.isFirstSlide?this.goSlide(this.total-1):this.goSlide(this.currentIndex-1))},goSlide:function(e){var i=this;this.currentIndex=e<0||e>this.total-1?0:e,this.isLastSlide&&(this.onLastSlide!==n&&t("warn","onLastSlide deprecated, please use @last-slide"," at components/curry-swiper/curry-swiper.vue:222"),this.onLastSlide(this.currentIndex),this.$emit("last-slide",this.currentIndex)),this.$emit("before-slide-change",this.currentIndex),setTimeout((function(){return i.animationEnd()}),this.animationSpeed)},goFar:function(t){var e=this,i=t===this.total-1&&this.isFirstSlide?-1:t-this.currentIndex;this.isLastSlide&&0===t&&(i=1);var n=i<0?-i:i,r=0,s=0;while(s<n){s+=1;var a=1===n?0:r;setTimeout((function(){return i<0?e.goPrev(n):e.goNext(n)}),a),r+=this.animationSpeed/n}},animationEnd:function(){this.onSlideChange!==n&&t("warn","onSlideChange deprecated, please use @after-slide-change"," at components/curry-swiper/curry-swiper.vue:253"),this.onSlideChange(this.currentIndex),this.$emit("after-slide-change",this.currentIndex)},handleMouseup:function(){this.mousedown=!1,this.dragOffset=0},handleMousedown:function(t){t.touches||t.preventDefault(),this.mousedown=!0,this.dragStartX="ontouchstart"in window?t.touches[0].clientX:t.clientX},handleMousemove:function(t){if(this.mousedown){var e="ontouchstart"in window?t.touches[0].clientX:t.clientX,i=this.dragStartX-e;this.dragOffset=i,this.dragOffset>this.minSwipeDistance?(this.handleMouseup(),this.goNext()):this.dragOffset<-this.minSwipeDistance&&(this.handleMouseup(),this.goPrev())}},attachMutationObserver:function(){var t=this,e=window.MutationObserver||window.WebKitMutationObserver||window.MozMutationObserver;if(e){var i={attributes:!0,childList:!0,characterData:!0};this.mutationObserver=new e((function(){t.$nextTick((function(){t.computeData()}))})),this.$el&&this.mutationObserver.observe(this.$el,i)}},detachMutationObserver:function(){this.mutationObserver&&this.mutationObserver.disconnect()},getSlideCount:function(){return void 0!==this.$slots.default?this.$slots.default.filter((function(t){return void 0!==t.tag})).length:0},calculateAspectRatio:function(t,e){return Math.min(t/e)},computeData:function(t){this.total=this.getSlideCount(),(t||this.currentIndex>=this.total)&&(this.currentIndex=parseInt(this.startIndex)>this.total-1?this.total-1:parseInt(this.startIndex)),this.viewport=this.$el.clientWidth},setSize:function(){this.$el.style.cssText+="height:"+this.slideHeight+"px;",this.$el.childNodes[0].style.cssText+="width:"+this.slideWidth+"px; height:"+this.slideHeight+"px;"}},mounted:function(){this.computeData(!0),this.attachMutationObserver(),this.$isServer||(window.addEventListener("resize",this.setSize),"ontouchstart"in window?(this.$el.addEventListener("touchstart",this.handleMousedown),this.$el.addEventListener("touchend",this.handleMouseup),this.$el.addEventListener("touchmove",this.handleMousemove)):(this.$el.addEventListener("mousedown",this.handleMousedown),this.$el.addEventListener("mouseup",this.handleMouseup),this.$el.addEventListener("mousemove",this.handleMousemove)))},beforeDestroy:function(){this.$isServer||(this.detachMutationObserver(),"ontouchstart"in window?this.$el.removeEventListener("touchmove",this.handleMousemove):this.$el.removeEventListener("mousemove",this.handleMousemove),window.removeEventListener("resize",this.setSize))}};e.default=r}).call(this,i("0de9")["log"])},fb1d:function(t,e,i){var n=i("f152");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var r=i("4f06").default;r("171fe3e9",n,!0,{sourceMap:!1,shadowMode:!1})}}]);