(window.webpackJsonp=window.webpackJsonp||[]).push([[21],{"2hEd":function(t,s,e){var a=e("r5dO");"string"==typeof a&&(a=[[t.i,a,""]]);var n={hmr:!0,transform:void 0,insertInto:void 0};e("aET+")(a,n);a.locals&&(t.exports=a.locals)},"4Mt9":function(t,s,e){"use strict";var a=e("2hEd");e.n(a).a},IN4B:function(t,s,e){"use strict";e.r(s);var a={props:["classroom"],mounted:function(){},data:function(){return{behaviour:null}},methods:{accept:function(){var t=[];document.querySelectorAll(".student-massive.selected").forEach((function(s){t.push(s.getAttribute("id"))})),axios.post("/classroom/"+this.classroom.code+"/utils/massive",{students:t,behaviour:this.behaviour}).then((function(t){location.reload()}))},random:function(){document.querySelectorAll(".student-massive").forEach((function(t){Math.random()>=.5?t.classList.add("selected"):t.classList.remove("selected")}))},changeAll:function(t){document.querySelectorAll(".student-massive").forEach((function(s){t?s.classList.add("selected"):s.classList.remove("selected")}))},toggle:function(t){var s=document.getElementById(t);s.classList.contains("selected")?s.classList.remove("selected"):s.classList.add("selected")},getText:function(t){var s="";return 0!=t.hp&&(s+=t.hp+" 💗 "),0!=t.xp&&(s+=t.xp+" ✊ "),0!=t.gold&&(s+=t.gold+" 💰 "),s}},computed:{}},n=(e("4Mt9"),e("KHd+")),i=Object(n.a)(a,(function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"modal-card",staticStyle:{width:"auto"}},[e("header",{staticClass:"modal-card-head"},[e("p",{staticClass:"modal-card-title"},[t._v(t._s(t.trans.get("menu.massive")))])]),t._v(" "),e("section",{staticClass:"modal-card-body is-flex has-all-centered",staticStyle:{"align-items":"flex-start"}},[e("div",{staticClass:"has-text-centered w-100"},[e("div",{staticClass:"select"},[e("select",{directives:[{name:"model",rawName:"v-model",value:t.behaviour,expression:"behaviour"}],on:{change:function(s){var e=Array.prototype.filter.call(s.target.options,(function(t){return t.selected})).map((function(t){return"_value"in t?t._value:t.value}));t.behaviour=s.target.multiple?e:e[0]}}},t._l(t.classroom.behaviours,(function(s){return e("option",{key:s.id,class:{"has-background-danger-light":s.hp+s.xp+s.gold<0,"has-background-success-light":s.hp+s.xp+s.gold>=0},domProps:{value:s.id}},[t._v(t._s(t.trans.get(s.name))+" "+t._s(t.getText(s)))])})),0)]),t._v(" "),e("div",{staticClass:"buttons mt-3 has-all-centered"},[e("button",{staticClass:"button is-info",on:{click:function(s){return t.changeAll(!0)}}},[e("i",{staticClass:"fas fa-ballot-check"}),t._v(" "),e("i",{staticClass:"far fa-users mr-2"}),t._v(" "+t._s(t.trans.get("utils.select_all"))+"\n        ")]),t._v(" "),e("button",{staticClass:"button is-info",on:{click:function(s){return t.changeAll(!1)}}},[e("i",{staticClass:"fas fa-eraser mr-2"}),t._v(" "+t._s(t.trans.get("utils.remove_selection"))+"\n        ")]),t._v(" "),e("button",{staticClass:"button is-info",on:{click:t.random}},[e("i",{staticClass:"fas fa-random mr-2"}),t._v(" "+t._s(t.trans.get("utils.random"))+"\n        ")])]),t._v(" "),e("div",{staticClass:"columns is-multiline is-variable mt-3"},t._l(t.classroom.students,(function(s){return e("div",{key:s.id,staticClass:"column p-3 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd",class:{hidden:1==s.hidden}},[1!=s.hidden?e("div",{staticClass:"student-massive p-3 is-flex has-all-centered rounded",attrs:{id:s.id},on:{click:function(e){return t.toggle(s.id)}}},[e("img",{staticClass:"mr-3",attrs:{src:s.avatar,width:"64px"}}),t._v("\n            "+t._s(s.name)+"\n          ")]):t._e()])})),0)])]),t._v(" "),e("footer",{staticClass:"modal-card-foot"},[e("button",{staticClass:"button",attrs:{type:"button"},on:{click:function(s){t.$parent.$parent.isMassiveModalActive=!1}}},[t._v(t._s(t.trans.get("general.close")))]),t._v(" "),t.behaviour?e("button",{staticClass:"button is-link",attrs:{type:"button"},on:{click:t.accept}},[t._v("Accept")]):t._e()])])}),[],!1,null,"6fd5843c",null);s.default=i.exports},r5dO:function(t,s,e){(t.exports=e("I1BE")(!1)).push([t.i,".selected[data-v-6fd5843c]{margin:0;background-color:#87cefa}",""])}}]);