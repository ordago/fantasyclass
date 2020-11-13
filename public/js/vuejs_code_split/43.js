(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[43],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/rules/EditRules.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/rules/EditRules.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
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
var Editor = function Editor() {
  return Promise.all(/*! import() */[__webpack_require__.e(7), __webpack_require__.e(12)]).then(__webpack_require__.bind(null, /*! ../utils/Editor.vue */ "./resources/js/components/utils/Editor.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["code", "rules"],
  mounted: function mounted() {
    if (this.rules) {
      this.content = this.rules.content;
    }
  },
  data: function data() {
    return {
      content: ""
    };
  },
  methods: {
    saveRules: function saveRules() {
      var _this = this;

      axios.patch("/classroom/" + this.code + "/rules", {
        content: this.content,
        _method: "patch"
      }).then(function (response) {
        _this.$toast(_this.trans.get("success_error.update_success"), {
          type: "success"
        });
      });
    },
    getRules: function getRules(lang) {
      var _this2 = this;

      axios.post("/classroom/default/rules", {
        lang: lang
      }).then(function (response) {
        _this2.content = response.data;
      });
    }
  },
  components: {
    Editor: Editor
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/rules/EditRules.vue?vue&type=template&id=933dd04c&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/rules/EditRules.vue?vue&type=template&id=933dd04c& ***!
  \******************************************************************************************************************************************************************************************************************/
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
    { staticClass: "w-100 p-2 content" },
    [
      _c("div", { staticClass: "buttons" }, [
        _c(
          "button",
          {
            staticClass: "button is-primary",
            on: {
              click: function($event) {
                return _vm.getRules("en")
              }
            }
          },
          [_vm._v("\n      Import default (EN)\n    ")]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "button is-link",
            on: {
              click: function($event) {
                return _vm.getRules("es")
              }
            }
          },
          [_vm._v("\n      Importa por defecto (ES)\n    ")]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "button is-info",
            on: {
              click: function($event) {
                return _vm.getRules("ca")
              }
            }
          },
          [_vm._v("\n      Importa per defecte (CA)\n    ")]
        )
      ]),
      _vm._v(" "),
      _c("Editor", { attrs: { height: "70vh", code: _vm.code } }),
      _vm._v(" "),
      _c("div", [
        _c(
          "button",
          {
            staticClass: "button is-primary mt-4",
            on: { click: _vm.saveRules }
          },
          [
            _c("i", { staticClass: "fas fa-save mr-2" }),
            _vm._v(
              "\n      " + _vm._s(_vm.trans.get("general.save")) + "\n    "
            )
          ]
        )
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/rules/EditRules.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/rules/EditRules.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _EditRules_vue_vue_type_template_id_933dd04c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditRules.vue?vue&type=template&id=933dd04c& */ "./resources/js/components/rules/EditRules.vue?vue&type=template&id=933dd04c&");
/* harmony import */ var _EditRules_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditRules.vue?vue&type=script&lang=js& */ "./resources/js/components/rules/EditRules.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EditRules_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EditRules_vue_vue_type_template_id_933dd04c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _EditRules_vue_vue_type_template_id_933dd04c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/rules/EditRules.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/rules/EditRules.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/rules/EditRules.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditRules_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./EditRules.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/rules/EditRules.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditRules_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/rules/EditRules.vue?vue&type=template&id=933dd04c&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/rules/EditRules.vue?vue&type=template&id=933dd04c& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditRules_vue_vue_type_template_id_933dd04c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./EditRules.vue?vue&type=template&id=933dd04c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/rules/EditRules.vue?vue&type=template&id=933dd04c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditRules_vue_vue_type_template_id_933dd04c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditRules_vue_vue_type_template_id_933dd04c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);