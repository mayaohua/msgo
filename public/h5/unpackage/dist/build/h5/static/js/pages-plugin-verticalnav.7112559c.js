(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-plugin-verticalnav"],{"204e":function(t,i,a){"use strict";var e=a("210f"),s=a.n(e);s.a},"210f":function(t,i,a){var e=a("b22e");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var s=a("4f06").default;s("e96ec8aa",e,!0,{sourceMap:!1,shadowMode:!1})},"772a":function(t,i,a){"use strict";a.r(i);var e=a("8791"),s=a("77f2");for(var n in s)"default"!==n&&function(t){a.d(i,t,(function(){return s[t]}))}(n);a("204e");var c,l=a("f0c5"),r=Object(l["a"])(s["default"],e["b"],e["c"],!1,null,"555c5211",null,!1,e["a"],c);i["default"]=r.exports},"77f2":function(t,i,a){"use strict";a.r(i);var e=a("c1e1"),s=a.n(e);for(var n in e)"default"!==n&&function(t){a.d(i,t,(function(){return e[t]}))}(n);i["default"]=s.a},8791:function(t,i,a){"use strict";var e;a.d(i,"b",(function(){return s})),a.d(i,"c",(function(){return n})),a.d(i,"a",(function(){return e}));var s=function(){var t=this,i=t.$createElement,a=t._self._c||i;return a("v-uni-view",[a("v-uni-view",{staticClass:"fixed"},[a("cu-custom",{attrs:{isBack:!0,bgColor:"bg-shadeTop text-white"}},[a("template",{attrs:{slot:"backText"},slot:"backText"},[t._v("返回")]),a("template",{attrs:{slot:"content"},slot:"content"},[t._v("垂直导航")])],2)],1),a("v-uni-swiper",{staticClass:"screen-swiper round-dot",attrs:{"indicator-dots":!0,circular:!0,autoplay:!0,interval:"5000",duration:"500"}},t._l(4,(function(t,i){return a("v-uni-swiper-item",{key:i},[a("v-uni-image",{attrs:{src:"https://ossweb-img.qq.com/images/lol/web201310/skin/big3900"+i+".jpg",mode:"aspectFill"}})],1)})),1),a("v-uni-view",{staticClass:"VerticalBox"},[a("v-uni-scroll-view",{staticClass:"VerticalNav nav",staticStyle:{height:"calc(100vh - 375upx)"},attrs:{"scroll-y":!0,"scroll-with-animation":!0,"scroll-top":t.verticalNavTop}},t._l(t.list,(function(i,e){return a("v-uni-view",{key:e,staticClass:"cu-item",class:e==t.tabCur?"text-green cur":"",attrs:{"data-id":e},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.TabSelect.apply(void 0,arguments)}}},[t._v("Tab-"+t._s(i.name))])})),1),a("v-uni-scroll-view",{staticClass:"VerticalMain",staticStyle:{height:"calc(100vh - 375upx)"},attrs:{"scroll-y":!0,"scroll-with-animation":!0,"scroll-into-view":"main-"+t.mainCur},on:{scroll:function(i){arguments[0]=i=t.$handleEvent(i),t.VerticalMain.apply(void 0,arguments)}}},t._l(t.list,(function(i,e){return a("v-uni-view",{key:e,staticClass:"padding-top padding-lr",attrs:{id:"main-"+e}},[a("v-uni-view",{staticClass:"cu-bar solid-bottom bg-white"},[a("v-uni-view",{staticClass:"action"},[a("v-uni-text",{staticClass:"cuIcon-title text-green"}),t._v("Tab-"+t._s(i.name))],1)],1),a("v-uni-view",{staticClass:"cu-list menu-avatar"},[a("v-uni-view",{staticClass:"cu-item"},[a("v-uni-view",{staticClass:"cu-avatar round lg",staticStyle:{"background-image":"url(https://ossweb-img.qq.com/images/lol/web201310/skin/big10001.jpg)"}}),a("v-uni-view",{staticClass:"content"},[a("v-uni-view",{staticClass:"text-grey"},[t._v("凯尔")]),a("v-uni-view",{staticClass:"text-gray text-sm flex"},[a("v-uni-text",{staticClass:"text-cut"},[a("v-uni-text",{staticClass:"cuIcon-infofill text-red  margin-right-xs"}),t._v("我已天理为凭，踏入这片荒芜，不再受凡人的枷锁遏制。我已天理为凭，踏入这片荒芜，不再受凡人的枷锁遏制。")],1)],1)],1),a("v-uni-view",{staticClass:"action"},[a("v-uni-view",{staticClass:"text-grey text-xs"},[t._v("22:20")]),a("v-uni-view",{staticClass:"cu-tag round bg-grey sm"},[t._v("5")])],1)],1),a("v-uni-view",{staticClass:"cu-item"},[a("v-uni-view",{staticClass:"cu-avatar round lg",staticStyle:{"background-image":"url(https://ossweb-img.qq.com/images/lol/img/champion/Taric.png)"}},[a("v-uni-view",{staticClass:"cu-tag badge"},[t._v("99+")])],1),a("v-uni-view",{staticClass:"content"},[a("v-uni-view",{staticClass:"text-grey"},[a("v-uni-text",{staticClass:"text-cut"},[t._v("瓦洛兰之盾-塔里克")]),a("v-uni-view",{staticClass:"cu-tag round bg-orange sm"},[t._v("战士")])],1),a("v-uni-view",{staticClass:"text-gray text-sm flex"},[a("v-uni-text",{staticClass:"text-cut"},[t._v("塔里克是保护者星灵，用超乎寻常的力量守护着符文之地的生命、仁爱以及万物之美。塔里克由于渎职而被放逐，离开了祖国德玛西亚，前去攀登巨神峰寻找救赎，但他找到的却是来自星界的更高层的召唤。现在的塔里克与古代巨神族的神力相融合，以瓦洛兰之盾的身份，永不疲倦地警惕着阴险狡诈的虚空腐化之力。")])],1)],1),a("v-uni-view",{staticClass:"action"},[a("v-uni-view",{staticClass:"text-grey text-xs"},[t._v("22:20")]),a("v-uni-view",{staticClass:"cuIcon-notice_forbid_fill text-gray"})],1)],1)],1)],1)})),1)],1)],1)},n=[]},b22e:function(t,i,a){var e=a("24fb");i=e(!1),i.push([t.i,'.fixed[data-v-555c5211]{position:fixed;z-index:99}.VerticalNav.nav[data-v-555c5211]{width:%?200?%;white-space:normal}.VerticalNav.nav .cu-item[data-v-555c5211]{width:100%;text-align:center;background-color:#fff;margin:0;border:none;height:50px;position:relative}.VerticalNav.nav .cu-item.cur[data-v-555c5211]{background-color:#f1f1f1}.VerticalNav.nav .cu-item.cur[data-v-555c5211]::after{content:"";width:%?8?%;height:%?30?%;border-radius:%?10?% 0 0 %?10?%;position:absolute;background-color:currentColor;top:0;right:%?0?%;bottom:0;margin:auto}.VerticalBox[data-v-555c5211]{display:-webkit-box;display:-webkit-flex;display:flex}.VerticalMain[data-v-555c5211]{background-color:#f1f1f1;-webkit-box-flex:1;-webkit-flex:1;flex:1}',""]),t.exports=i},c1e1:function(t,i,a){"use strict";a("ac1f"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var e={data:function(){return{list:[],tabCur:0,mainCur:0,verticalNavTop:0,load:!0}},onLoad:function(){uni.showLoading({title:"加载中...",mask:!0});for(var t=[{}],i=0;i<3;i++)t[i]={},t[i].name=String.fromCharCode(65+i),t[i].id=i;this.list=t,console.log(this.list),this.listCur=t[0]},onReady:function(){uni.hideLoading()},methods:{TabSelect:function(t){this.tabCur=t.currentTarget.dataset.id,this.mainCur=t.currentTarget.dataset.id,this.verticalNavTop=50*(t.currentTarget.dataset.id-1)},VerticalMain:function(t){var i=this,a=0;if(this.load){for(var e=function(t){var e=uni.createSelectorQuery().select("#main-"+i.list[t].id);e.fields({size:!0},(function(e){console.log(e),i.list[t].top=a,a+=e.height,i.list[t].bottom=a})).exec()},s=0;s<this.list.length;s++)e(s);this.load=!1}for(var n=t.detail.scrollTop+10,c=0;c<this.list.length;c++)if(n>this.list[c].top&&n<this.list[c].bottom)return this.verticalNavTop=50*(this.list[c].id-1),this.tabCur=this.list[c].id,console.log(n),!1}}};i.default=e}}]);