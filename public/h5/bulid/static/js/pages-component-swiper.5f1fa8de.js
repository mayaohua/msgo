(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-component-swiper"],{"1ded":function(t,e,i){"use strict";var s=i("4583"),n=i.n(s);n.a},4583:function(t,e,i){var s=i("9f1c");"string"===typeof s&&(s=[[t.i,s,""]]),s.locals&&(t.exports=s.locals);var n=i("4f06").default;n("ff1e7608",s,!0,{sourceMap:!1,shadowMode:!1})},8309:function(t,e,i){"use strict";i("e25e"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var s={data:function(){return{cardCur:0,swiperList:[{id:0,type:"image",url:"https://ossweb-img.qq.com/images/lol/web201310/skin/big84000.jpg"},{id:1,type:"image",url:"https://ossweb-img.qq.com/images/lol/web201310/skin/big37006.jpg"},{id:2,type:"image",url:"https://ossweb-img.qq.com/images/lol/web201310/skin/big39000.jpg"},{id:3,type:"image",url:"https://ossweb-img.qq.com/images/lol/web201310/skin/big10001.jpg"},{id:4,type:"image",url:"https://ossweb-img.qq.com/images/lol/web201310/skin/big25011.jpg"},{id:5,type:"image",url:"https://ossweb-img.qq.com/images/lol/web201310/skin/big21016.jpg"},{id:6,type:"image",url:"https://ossweb-img.qq.com/images/lol/web201310/skin/big99008.jpg"}],dotStyle:!1,towerStart:0,direction:""}},onLoad:function(){this.TowerSwiper("swiperList")},methods:{DotStyle:function(t){this.dotStyle=t.detail.value},cardSwiper:function(t){this.cardCur=t.detail.current},TowerSwiper:function(t){for(var e=this[t],i=0;i<e.length;i++)e[i].zIndex=parseInt(e.length/2)+1-Math.abs(i-parseInt(e.length/2)),e[i].mLeft=i-parseInt(e.length/2);this.swiperList=e},TowerStart:function(t){this.towerStart=t.touches[0].pageX},TowerMove:function(t){this.direction=t.touches[0].pageX-this.towerStart>0?"right":"left"},TowerEnd:function(t){var e=this.direction,i=this.swiperList;if("right"==e){for(var s=i[0].mLeft,n=i[0].zIndex,a=1;a<this.swiperList.length;a++)this.swiperList[a-1].mLeft=this.swiperList[a].mLeft,this.swiperList[a-1].zIndex=this.swiperList[a].zIndex;this.swiperList[i.length-1].mLeft=s,this.swiperList[i.length-1].zIndex=n}else{for(var r=i[i.length-1].mLeft,o=i[i.length-1].zIndex,c=this.swiperList.length-1;c>0;c--)this.swiperList[c].mLeft=this.swiperList[c-1].mLeft,this.swiperList[c].zIndex=this.swiperList[c-1].zIndex;this.swiperList[0].mLeft=r,this.swiperList[0].zIndex=o}this.direction="",this.swiperList=this.swiperList}}};e.default=s},"8b0a":function(t,e,i){"use strict";i.r(e);var s=i("b13c"),n=i("c05a");for(var a in n)"default"!==a&&function(t){i.d(e,t,(function(){return n[t]}))}(a);i("1ded");var r,o=i("f0c5"),c=Object(o["a"])(n["default"],s["b"],s["c"],!1,null,"627af15d",null,!1,s["a"],r);e["default"]=c.exports},"9f1c":function(t,e,i){var s=i("24fb");e=s(!1),e.push([t.i,".tower-swiper .tower-item[data-v-627af15d]{-webkit-transform:scale(calc(.5 + var(--index) / 10));transform:scale(calc(.5 + var(--index) / 10));margin-left:calc(var(--left) * %?100?% - %?150?%);z-index:var(--index)}",""]),t.exports=e},b13c:function(t,e,i){"use strict";var s;i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return a})),i.d(e,"a",(function(){return s}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("cu-custom",{attrs:{bgColor:"bg-gradual-pink",isBack:!0}},[i("template",{attrs:{slot:"backText"},slot:"backText"},[t._v("返回")]),i("template",{attrs:{slot:"content"},slot:"content"},[t._v("轮播图")])],2),i("v-uni-view",{staticClass:"cu-bar bg-white"},[i("v-uni-view",{staticClass:"action"},[i("v-uni-text",{staticClass:"cuIcon-title text-pink"}),t._v("全屏限高轮播")],1),i("v-uni-view",{staticClass:"action"},[i("v-uni-switch",{class:t.dotStyle?"checked":"",attrs:{checked:!!t.dotStyle},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.DotStyle.apply(void 0,arguments)}}})],1)],1),i("v-uni-swiper",{staticClass:"screen-swiper",class:t.dotStyle?"square-dot":"round-dot",attrs:{"indicator-dots":!0,circular:!0,autoplay:!0,interval:"5000",duration:"500"}},t._l(t.swiperList,(function(e,s){return i("v-uni-swiper-item",{key:s},["image"==e.type?i("v-uni-image",{attrs:{src:e.url,mode:"aspectFill"}}):t._e(),"video"==e.type?i("v-uni-video",{attrs:{src:e.url,autoplay:!0,loop:!0,muted:!0,"show-play-btn":!1,controls:!1,objectFit:"cover"}}):t._e()],1)})),1),i("v-uni-view",{staticClass:"cu-bar bg-white margin-top"},[i("v-uni-view",{staticClass:"action"},[i("v-uni-text",{staticClass:"cuIcon-title text-pink"}),t._v("卡片式轮播")],1)],1),i("v-uni-swiper",{staticClass:"card-swiper",class:t.dotStyle?"square-dot":"round-dot",attrs:{"indicator-dots":!0,circular:!0,autoplay:!0,interval:"5000",duration:"500","indicator-color":"#8799a3","indicator-active-color":"#0081ff"},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.cardSwiper.apply(void 0,arguments)}}},t._l(t.swiperList,(function(e,s){return i("v-uni-swiper-item",{key:s,class:t.cardCur==s?"cur":""},[i("v-uni-view",{staticClass:"swiper-item"},["image"==e.type?i("v-uni-image",{attrs:{src:e.url,mode:"aspectFill"}}):t._e(),"video"==e.type?i("v-uni-video",{attrs:{src:e.url,autoplay:!0,loop:!0,muted:!0,"show-play-btn":!1,controls:!1,objectFit:"cover"}}):t._e()],1)],1)})),1),i("v-uni-view",{staticClass:"cu-bar bg-white margin-top"},[i("v-uni-view",{staticClass:"action"},[i("v-uni-text",{staticClass:"cuIcon-title text-pink"}),t._v("堆叠式轮播")],1)],1),i("v-uni-view",{staticClass:"tower-swiper",on:{touchmove:function(e){arguments[0]=e=t.$handleEvent(e),t.TowerMove.apply(void 0,arguments)},touchstart:function(e){arguments[0]=e=t.$handleEvent(e),t.TowerStart.apply(void 0,arguments)},touchend:function(e){arguments[0]=e=t.$handleEvent(e),t.TowerEnd.apply(void 0,arguments)}}},t._l(t.swiperList,(function(e,s){return i("v-uni-view",{key:s,staticClass:"tower-item",class:1==e.zIndex?"none":"",style:[{"--index":e.zIndex,"--left":e.mLeft}],attrs:{"data-direction":t.direction}},[i("v-uni-view",{staticClass:"swiper-item"},["image"==e.type?i("v-uni-image",{attrs:{src:e.url,mode:"aspectFill"}}):t._e(),"video"==e.type?i("v-uni-video",{attrs:{src:e.url,autoplay:!0,loop:!0,muted:!0,"show-play-btn":!1,controls:!1,objectFit:"cover"}}):t._e()],1)],1)})),1)],1)},a=[]},c05a:function(t,e,i){"use strict";i.r(e);var s=i("8309"),n=i.n(s);for(var a in s)"default"!==a&&function(t){i.d(e,t,(function(){return s[t]}))}(a);e["default"]=n.a}}]);