(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[54],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Mobile.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Mobile.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {};
  },
  mounted: function mounted() {},
  methods: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Mobile.vue?vue&type=template&id=728d93ab&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Mobile.vue?vue&type=template&id=728d93ab& ***!
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
    {
      staticClass: "p-3 fs-1-2 has-background-light has-text-centered",
      staticStyle: { height: "90vh" }
    },
    [
      _c(
        "b-tabs",
        { attrs: { type: "is-toggle", expanded: "" } },
        [
          _c(
            "b-tab-item",
            {
              attrs: { label: "Android", "icon-pack": "fab", icon: "android" }
            },
            [
              _c("div", { staticClass: "p-3" }, [
                _c("div", {
                  staticClass: "notification is-info is-light mb-1",
                  domProps: {
                    innerHTML: _vm._s(
                      _vm.trans.get("utils.mobile_text_android")
                    )
                  }
                }),
                _vm._v(" "),
                _c(
                  "a",
                  {
                    attrs: {
                      href:
                        "https://play.google.com/store/apps/details?id=app.fantasyclass.climentjoan",
                      target: "_blank"
                    }
                  },
                  [
                    _c("img", {
                      attrs: {
                        width: "300px",
                        alt: "google play logo",
                        src: "/gplay.png"
                      }
                    })
                  ]
                )
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            "b-tab-item",
            {
              attrs: {
                label: "iOs (iPhone & iPad)",
                "icon-pack": "fab",
                icon: "apple"
              }
            },
            [
              _c("div", { staticClass: "p-3" }, [
                _c("div", {
                  staticClass: "notification is-warning is-light mb-1",
                  domProps: {
                    innerHTML: _vm._s(_vm.trans.get("utils.mobile_text_apple"))
                  }
                }),
                _vm._v(" "),
                _c("video", { attrs: { controls: "", width: "300px" } }, [
                  _c("source", {
                    attrs: { src: "/videos/ios.mp4", type: "video/mp4" }
                  })
                ])
              ])
            ]
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/utils/Mobile.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/utils/Mobile.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Mobile_vue_vue_type_template_id_728d93ab___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Mobile.vue?vue&type=template&id=728d93ab& */ "./resources/js/components/utils/Mobile.vue?vue&type=template&id=728d93ab&");
/* harmony import */ var _Mobile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Mobile.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/Mobile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Mobile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Mobile_vue_vue_type_template_id_728d93ab___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Mobile_vue_vue_type_template_id_728d93ab___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/Mobile.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/Mobile.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/utils/Mobile.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Mobile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Mobile.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Mobile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Mobile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/Mobile.vue?vue&type=template&id=728d93ab&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/utils/Mobile.vue?vue&type=template&id=728d93ab& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Mobile_vue_vue_type_template_id_728d93ab___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Mobile.vue?vue&type=template&id=728d93ab& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Mobile.vue?vue&type=template&id=728d93ab&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Mobile_vue_vue_type_template_id_728d93ab___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Mobile_vue_vue_type_template_id_728d93ab___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);