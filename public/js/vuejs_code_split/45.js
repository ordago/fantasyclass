(window.webpackJsonp=window.webpackJsonp||[]).push([[45],{qF3S:function(t,n,s){"use strict";s.r(n);var e={props:["code","rules"],mounted:function(){this.rules&&(this.content=this.rules.content)},data:function(){return{content:""}},methods:{saveRules:function(){var t=this;axios.patch("/classroom/"+this.code+"/rules",{content:this.content,_method:"patch"}).then((function(n){t.$toast(t.trans.get("success_error.update_success"),{type:"success"})}))},getRules:function(t){var n=this;axios.post("/classroom/default/rules",{lang:t}).then((function(t){n.content=t.data}))}},components:{Editor:function(){return Promise.all([s.e(4),s.e(10)]).then(s.bind(null,"KiP7"))}},computed:{}},o=s("KHd+"),c=Object(o.a)(e,(function(){var t=this,n=t.$createElement,s=t._self._c||n;return s("div",{staticClass:"w-100 p-2 content"},[s("div",{staticClass:"buttons"},[s("button",{staticClass:"button is-primary",on:{click:function(n){return t.getRules("en")}}},[t._v("\n      Import default (EN)\n    ")]),t._v(" "),s("button",{staticClass:"button is-link",on:{click:function(n){return t.getRules("es")}}},[t._v("\n      Importa por defecto (ES)\n    ")]),t._v(" "),s("button",{staticClass:"button is-info",on:{click:function(n){return t.getRules("ca")}}},[t._v("\n      Importa per defecte (CA)\n    ")])]),t._v(" "),s("Editor",{attrs:{height:"70vh",code:t.code}}),t._v(" "),s("div",[s("button",{staticClass:"button is-primary mt-4",on:{click:t.saveRules}},[s("i",{staticClass:"fas fa-save mr-2"}),t._v("\n      "+t._s(t.trans.get("general.save"))+"\n    ")])])],1)}),[],!1,null,null,null);n.default=c.exports}}]);