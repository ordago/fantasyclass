(window.webpackJsonp=window.webpackJsonp||[]).push([[28],{LR9I:function(t,a,n){"use strict";n.r(a);n("o0O0");var s={props:[],created:function(){axios.get("/")},data:function(){return{}},methods:{pay:function(){var t=this;axios.post("/classroom/students/update",{action:"pay"}).then((function(a){"error"==a.data.type?t.$toast(a.data.message,{type:a.data.type}):location.reload()}))}}},e=n("KHd+"),o=Object(e.a)(s,(function(){var t=this,a=t.$createElement,n=t._self._c||a;return n("div",{staticClass:"buttons"},[n("button",{staticClass:"button",on:{click:function(a){return a.preventDefault(),t.pay(a)}}},[t._v(t._s(t.trans.get("cards.pay")))]),t._v(" "),n("button",{staticClass:"button"},[t._v(t._s(t.trans.get("general.close")))])])}),[],!1,null,null,null);a.default=o.exports}}]);