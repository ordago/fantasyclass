(window.webpackJsonp=window.webpackJsonp||[]).push([[41],{I14s:function(e,t,s){"use strict";s.r(t);var l={props:["levels","code"],created:function(){},data:function(){return{newXp:0}},methods:{addLevel:function(){var e=this;this.$buefy.dialog.prompt({message:this.trans.get("levels.add"),confirmText:this.trans.get("general.add"),cancelText:this.trans.get("general.cancel"),inputAttrs:{placeholder:this.trans.get("levels.xp"),type:"number",min:this.levels[this.levels.length-1].xp+1},trapFocus:!0,onConfirm:function(t){axios.post("/classroom/".concat(e.code,"/level/add"),{xp:t}).then((function(t){e.levels.push(t.data),e.$forceUpdate()}))}})}}},n=s("KHd+"),a=Object(n.a)(l,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"p-2"},[e.levels.length?s("div",{staticClass:"columns is-multiline is-variable mt-3"},[e._l(e.levels,(function(t,l){return s("show-level",{key:t.id,attrs:{code:e.code,edit:!0,last:l==e.levels.length-1,level:t}})})),e._v(" "),s("button",{staticClass:"button mx-3 my-2",on:{click:e.addLevel}},[s("i",{staticClass:"fas fa-plus mr-2"}),e._v(" "+e._s(e.trans.get("levels.add")))])],2):s("create-levels")],1)}),[],!1,null,null,null);t.default=a.exports}}]);