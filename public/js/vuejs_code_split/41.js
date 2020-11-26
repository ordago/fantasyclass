(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[41],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/level/ShowLevels.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/level/ShowLevels.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["levels", "code"],
  created: function created() {},
  data: function data() {
    return {
      newXp: 0
    };
  },
  methods: {
    addLevel: function addLevel() {
      var _this = this;

      this.$buefy.dialog.prompt({
        message: this.trans.get("levels.add"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        inputAttrs: {
          placeholder: this.trans.get("levels.xp"),
          type: "number",
          min: this.levels[this.levels.length - 1].xp + 1
        },
        trapFocus: true,
        onConfirm: function onConfirm(value) {
          axios.post("/classroom/".concat(_this.code, "/level/add"), {
            xp: value
          }).then(function (response) {
            _this.levels.push(response.data);

            _this.$forceUpdate();
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/level/ShowLevels.vue?vue&type=template&id=59917d22&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/level/ShowLevels.vue?vue&type=template&id=59917d22& ***!
  \*******************************************************************************************************************************************************************************************************************/
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
    { staticClass: "p-2" },
    [
      !_vm.levels.length
        ? _c("create-levels")
        : _c(
            "div",
            { staticClass: "columns is-multiline is-variable mt-3" },
            [
              _vm._l(_vm.levels, function(level, index) {
                return _c("show-level", {
                  key: level.id,
                  attrs: {
                    code: _vm.code,
                    edit: true,
                    last: index == _vm.levels.length - 1,
                    level: level
                  }
                })
              }),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "button mx-3 my-2",
                  on: { click: _vm.addLevel }
                },
                [
                  _c("i", { staticClass: "fas fa-plus mr-2" }),
                  _vm._v(" " + _vm._s(_vm.trans.get("levels.add")))
                ]
              )
            ],
            2
          )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/level/ShowLevels.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/level/ShowLevels.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowLevels_vue_vue_type_template_id_59917d22___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowLevels.vue?vue&type=template&id=59917d22& */ "./resources/js/components/level/ShowLevels.vue?vue&type=template&id=59917d22&");
/* harmony import */ var _ShowLevels_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowLevels.vue?vue&type=script&lang=js& */ "./resources/js/components/level/ShowLevels.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowLevels_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowLevels_vue_vue_type_template_id_59917d22___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowLevels_vue_vue_type_template_id_59917d22___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/level/ShowLevels.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/level/ShowLevels.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/level/ShowLevels.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowLevels_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowLevels.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/level/ShowLevels.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowLevels_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/level/ShowLevels.vue?vue&type=template&id=59917d22&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/level/ShowLevels.vue?vue&type=template&id=59917d22& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowLevels_vue_vue_type_template_id_59917d22___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowLevels.vue?vue&type=template&id=59917d22& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/level/ShowLevels.vue?vue&type=template&id=59917d22&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowLevels_vue_vue_type_template_id_59917d22___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowLevels_vue_vue_type_template_id_59917d22___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);