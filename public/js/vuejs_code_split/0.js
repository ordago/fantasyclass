(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/IconSelector.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/IconSelector.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vfa_picker__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vfa-picker */ "./node_modules/vfa-picker/dist/vfa-picker.common.js");
/* harmony import */ var vfa_picker__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vfa_picker__WEBPACK_IMPORTED_MODULE_0__);
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

Vue.use(vfa_picker__WEBPACK_IMPORTED_MODULE_0___default.a);
/* harmony default export */ __webpack_exports__["default"] = ({
  created: function created() {},
  data: function data() {
    return {
      csrfToken: null
    };
  },
  methods: {
    parentIcon: function parentIcon(iconSelected) {
      if (iconSelected.styles.indexOf("regular") > -1) {
        return "fa";
      } else if (iconSelected.styles.indexOf("solid") > -1) {
        return "fas";
      } else if (iconSelected.styles.indexOf("brands") > -1) {
        return "fab";
      }

      return "";
    },
    updateIcon: function updateIcon() {
      this.$refs.iconPreview.innerHTML = "<i class='" + this.$parent.$data.icon + "'></i>";
    },
    update: function update() {}
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/IconSelector.vue?vue&type=template&id=b999ca7e&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/IconSelector.vue?vue&type=template&id=b999ca7e& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
  return _c("vfa-picker", {
    attrs: { "is-both": "false" },
    scopedSlots: _vm._u([
      {
        key: "activator",
        fn: function(ref) {
          var on = ref.on
          return [
            _c(
              "button",
              {
                staticClass: "button is-link fullIcon",
                attrs: { type: "button" },
                on: { click: on }
              },
              [
                _c("span", { ref: "iconPreview" }, [
                  _c("i", {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: !_vm.$parent.$data.icon,
                        expression: "!$parent.$data.icon"
                      }
                    ],
                    class: "fas fa-image"
                  }),
                  _vm._v(" "),
                  _vm.$parent.$data.icon
                    ? _c("i", { class: _vm.$parent.$data.icon })
                    : _vm._e()
                ]),
                _vm._v(" "),
                _c("i", { staticClass: "fas fa-caret-down ml-1" })
              ]
            )
          ]
        }
      },
      {
        key: "icon",
        fn: function(ref) {
          var icon = ref.icon
          var picked = ref.picked
          return [
            _c(
              "div",
              {
                attrs: { title: icon.label },
                on: {
                  click: function($event) {
                    _vm.parentIcon(icon)
                    picked(icon)
                    _vm.$parent.$data.icon =
                      _vm.parentIcon(icon) + " fa-" + icon.class
                    _vm.updateIcon()
                  }
                }
              },
              [
                _c("span", {
                  class: [
                    _vm.parentIcon(icon),
                    "fa-" + icon.class,
                    "vfa-icon-preview"
                  ]
                })
              ]
            )
          ]
        }
      }
    ])
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/utils/IconSelector.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/utils/IconSelector.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _IconSelector_vue_vue_type_template_id_b999ca7e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IconSelector.vue?vue&type=template&id=b999ca7e& */ "./resources/js/components/utils/IconSelector.vue?vue&type=template&id=b999ca7e&");
/* harmony import */ var _IconSelector_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IconSelector.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/IconSelector.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _IconSelector_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _IconSelector_vue_vue_type_template_id_b999ca7e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _IconSelector_vue_vue_type_template_id_b999ca7e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/IconSelector.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/IconSelector.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/utils/IconSelector.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IconSelector_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./IconSelector.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/IconSelector.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IconSelector_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/IconSelector.vue?vue&type=template&id=b999ca7e&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/utils/IconSelector.vue?vue&type=template&id=b999ca7e& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IconSelector_vue_vue_type_template_id_b999ca7e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./IconSelector.vue?vue&type=template&id=b999ca7e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/IconSelector.vue?vue&type=template&id=b999ca7e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IconSelector_vue_vue_type_template_id_b999ca7e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IconSelector_vue_vue_type_template_id_b999ca7e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);