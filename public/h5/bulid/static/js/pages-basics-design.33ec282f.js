(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-basics-design"],{"0785":function(t,i,a){var e=a("24fb");i=e(!1),i.push([t.i,".box[data-v-4302e67f]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;height:100px}",""]),t.exports=i},"1c1d":function(t,i,a){"use strict";Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var e={data:function(){return{ColorList:this.ColorList,modalName:"",round:!1,size:"",color:"red",shadow:!1,border:!1,bordersize:""}},methods:{showModal:function(t){this.modalName=t.currentTarget.dataset.target},hideModal:function(t){this.modalName=null},SetRound:function(t){this.round=t.detail.value},SetSize:function(t){this.size=t.detail.value},SetColor:function(t){this.color=t.currentTarget.dataset.color,this.modalName=null},SetShadow:function(t){this.shadow=t.detail.value},SetBorder:function(t){this.border=t.detail.value,t.detail.value||(this.bordersize=!1)},SetBorderSize:function(t){this.bordersize=t.detail.value}}};i.default=e},"2b2c":function(t,i,a){"use strict";var e=a("3763"),s=a.n(e);s.a},"2f5f":function(t,i,a){"use strict";a.r(i);var e=a("e7e6"),s=a("508b");for(var n in s)"default"!==n&&function(t){a.d(i,t,(function(){return s[t]}))}(n);a("2b2c");var o,l=a("f0c5"),c=Object(l["a"])(s["default"],e["b"],e["c"],!1,null,"4302e67f",null,!1,e["a"],o);i["default"]=c.exports},3763:function(t,i,a){var e=a("0785");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var s=a("4f06").default;s("d1fd97ea",e,!0,{sourceMap:!1,shadowMode:!1})},"508b":function(t,i,a){"use strict";a.r(i);var e=a("1c1d"),s=a.n(e);for(var n in e)"default"!==n&&function(t){a.d(i,t,(function(){return e[t]}))}(n);i["default"]=s.a},e7e6:function(t,i,a){"use strict";var e;a.d(i,"b",(function(){return s})),a.d(i,"c",(function(){return n})),a.d(i,"a",(function(){return e}));var s=function(){var t=this,i=t.$createElement,a=t._self._c||i;return a("v-uni-view",[a("cu-custom",{attrs:{bgColor:"bg-gradual-blue",isBack:!0}},[a("template",{attrs:{slot:"backText"},slot:"backText"},[t._v("返回")]),a("template",{attrs:{slot:"content"},slot:"content"},[t._v("按钮 / 设计")])],2),a("v-uni-view",{staticClass:"padding-xl"},[a("v-uni-view",{staticClass:"box bg-white text-center radius"},[a("v-uni-button",{staticClass:"cu-btn",class:[t.border?t.bordersize?"lines-"+t.color:"line-"+t.color:"bg-"+t.color,t.round?"round":"",t.size,t.shadow?"shadow":""]},[t._v("我是一个按钮")])],1),a("v-uni-view",{staticClass:"padding text-center"},[t._v('class="cu-btn'),t.color?a("v-uni-text",[t._v(t._s(" ")+" "+t._s(t.border?t.bordersize?"lines-"+t.color:"line-"+t.color:"bg-"+t.color)+" "+t._s(t.round?"round":"")+" "+t._s(t.size)+" "+t._s(t.shadow?"shadow":""))]):t._e(),t._v('"')],1)],1),a("v-uni-view",{staticClass:"cu-form-group margin-top",attrs:{"data-target":"ColorModal"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.showModal.apply(void 0,arguments)}}},[a("v-uni-view",{staticClass:"title"},[t._v("选择颜色")]),a("v-uni-view",{staticClass:"padding solid radius shadow-blur",class:"bg-"+t.color})],1),a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[t._v("是否圆角")]),a("v-uni-switch",{staticClass:"blue",class:t.round?"checked":"",on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.SetRound.apply(void 0,arguments)}}})],1),a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[t._v("选择尺寸")]),a("v-uni-radio-group",{on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.SetSize.apply(void 0,arguments)}}},[a("v-uni-label",{staticClass:"margin-left-sm"},[a("v-uni-radio",{staticClass:"blue radio",attrs:{value:"sm"}}),a("v-uni-text",{staticClass:"margin-left-sm"},[t._v("小")])],1),a("v-uni-label",{staticClass:"margin-left-sm"},[a("v-uni-radio",{staticClass:"blue radio",attrs:{value:"",checked:!0}}),a("v-uni-text",{staticClass:"margin-left-sm"},[t._v("中")])],1),a("v-uni-label",{staticClass:"margin-left-sm"},[a("v-uni-radio",{staticClass:"blue radio",attrs:{value:"lg"}}),a("v-uni-text",{staticClass:"margin-left-sm"},[t._v("大")])],1)],1)],1),a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[t._v("是否添加阴影")]),a("v-uni-switch",{class:t.shadow?"checked":"",on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.SetShadow.apply(void 0,arguments)}}})],1),a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[t._v("是否镂空")]),a("v-uni-switch",{class:t.border?"checked":"",on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.SetBorder.apply(void 0,arguments)}}})],1),t.border?a("v-uni-view",{staticClass:"cu-form-group"},[a("v-uni-view",{staticClass:"title"},[t._v("边框大小")]),a("v-uni-radio-group",{on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.SetBorderSize.apply(void 0,arguments)}}},[a("v-uni-label",{staticClass:"margin-left-sm"},[a("v-uni-radio",{staticClass:"blue radio",attrs:{value:"",checked:!0}}),a("v-uni-text",{staticClass:"margin-left-sm"},[t._v("小")])],1),a("v-uni-label",{staticClass:"margin-left-sm"},[a("v-uni-radio",{staticClass:"blue radio",attrs:{value:"s"}}),a("v-uni-text",{staticClass:"margin-left-sm"},[t._v("大")])],1)],1)],1):t._e(),a("v-uni-view",{staticClass:"cu-modal",class:"ColorModal"==t.modalName?"show":""},[a("v-uni-view",{staticClass:"cu-dialog"},[a("v-uni-view",{staticClass:"cu-bar justify-end solid-bottom"},[a("v-uni-view",{staticClass:"content"},[t._v("选择颜色")]),a("v-uni-view",{staticClass:"action",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.hideModal.apply(void 0,arguments)}}},[a("v-uni-text",{staticClass:"cuIcon-close text-red"})],1)],1),a("v-uni-view",{staticClass:"grid col-5 padding"},t._l(t.ColorList,(function(i,e){return"white"!=i.name?a("v-uni-view",{key:e,staticClass:"padding-xs",attrs:{"data-color":i.name},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.SetColor.apply(void 0,arguments)}}},[a("v-uni-view",{staticClass:"padding-tb radius",class:"bg-"+i.name},[t._v(t._s(i.title))])],1):t._e()})),1)],1)],1)],1)},n=[]}}]);