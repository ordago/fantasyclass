(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Editor.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Editor.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! element-ui */ "./node_modules/element-ui/lib/element-ui.common.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(element_ui__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var element_tiptap__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! element-tiptap */ "./node_modules/element-tiptap/lib/element-tiptap.esm.js");
/* harmony import */ var element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! element-ui/lib/theme-chalk/index.css */ "./node_modules/element-ui/lib/theme-chalk/index.css");
/* harmony import */ var element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var element_tiptap_lib_index_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! element-tiptap/lib/index.css */ "./node_modules/element-tiptap/lib/index.css");
/* harmony import */ var element_tiptap_lib_index_css__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(element_tiptap_lib_index_css__WEBPACK_IMPORTED_MODULE_4__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


 // import ElementUI's styles

 // import this package's styles

 // use ElementUI's plugin

vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(element_ui__WEBPACK_IMPORTED_MODULE_1___default.a); // use this package's plugin

vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(element_tiptap__WEBPACK_IMPORTED_MODULE_2__["ElementTiptapPlugin"], {
  /* plugin options */
}); // Now you register `'el-tiptap'` component globally.


/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["code"],
  created: function created() {},
  data: function data() {
    return {
      extensions: [new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Doc"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Text"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["History"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Paragraph"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Heading"]({
        level: 5
      }), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Bold"](), // render command-button in bubble menu.
      new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Underline"](), // render command-button in bubble menu but not in menubar.
      new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Italic"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Strike"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["ListItem"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["BulletList"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["OrderedList"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Link"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Image"]({
        uploadRequest: function uploadRequest(file) {
          var formData = new FormData();
          formData.append("file", file);
          var request = axios.post("/classroom/challenges/image", formData);
          return request.then(function (result) {
            return result.data;
          });
        }
      }), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["CodeBlock"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Blockquote"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TextAlign"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Indent"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["LineHeight"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["HorizontalRule"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Table"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TableHeader"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TableCell"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TableRow"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["FontType"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["FontSize"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TextColor"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TextHighlight"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["FormatClear"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Print"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Fullscreen"]()]
    };
  },
  methods: {
    sendImage: function sendImage() {}
  },
  components: {
    ElementUI: element_ui__WEBPACK_IMPORTED_MODULE_1___default.a,
    ElementTiptapPlugin: element_tiptap__WEBPACK_IMPORTED_MODULE_2__["ElementTiptapPlugin"]
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214& ***!
  \***************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _vm._m(0),
      _vm._v(" "),
      _c("el-tiptap", {
        attrs: {
          extensions: _vm.extensions,
          placeholder: "Write here some fun stuff!"
        },
        model: {
          value: _vm.$parent.content,
          callback: function($$v) {
            _vm.$set(_vm.$parent, "content", $$v)
          },
          expression: "$parent.content"
        }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "tag is-warning has-margin-y-2" }, [
      _vm._v("\n    %HP%  "),
      _c("i", { staticClass: "fas fa-heart colored" }),
      _vm._v(" "),
      _c("i", { staticClass: "fal fa-ellipsis-v has-margin-x-3" }),
      _vm._v("\n    %XP% "),
      _c("i", { staticClass: "fas fa-fist-raised colored" }),
      _vm._v(" "),
      _c("i", { staticClass: "fal fa-ellipsis-v has-margin-x-3" }),
      _vm._v("\n    %GOLD% "),
      _c("i", { staticClass: "fas fa-coins colored" })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/utils/Editor.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/utils/Editor.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Editor.vue?vue&type=template&id=d7987214& */ "./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214&");
/* harmony import */ var _Editor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Editor.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/Editor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Editor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/Editor.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/Editor.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/utils/Editor.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Editor.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Editor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Editor.vue?vue&type=template&id=d7987214& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);