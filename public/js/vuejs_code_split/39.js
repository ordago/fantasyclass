(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[39],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/EditGroup.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/group/EditGroup.vue?vue&type=script&lang=js& ***!
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
  props: ["group", "code"],
  created: function created() {
    this.prevImage = this.group.logo;
  },
  data: function data() {
    return {
      image: null,
      prevImage: null
    };
  },
  components: {},
  methods: {
    remove: function remove() {
      var _this = this;

      axios["delete"]("/classroom/groups/" + this.group.id).then(function (response) {
        _this.$toast(_this.trans.get("success_error.update_success"), {
          type: "success"
        });

        _this.$destroy();

        location.reload(); // this.$el.parentNode.removeChild(this.$el);
      });
    },
    edit: function edit() {
      var _this2 = this;

      this.image.generateBlob(function (blob) {
        // form data
        var formData = new FormData();
        if (blob) formData.append("logo", blob, "logo.png");
        formData.append("id", _this2.group.id);
        formData.append("name", _this2.group.name);
        formData.append("_method", "patch");
        axios.post("/classroom/" + _this2.code + "/groups/info", formData, {
          headers: {
            "content-type": "multipart/form-data"
          }
        }).then(function (response) {
          _this2.$toast(_this2.trans.get("success_error.update_success"), {
            type: "success"
          });
        });
      }, "image/png", 0.8);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/EditGroup.vue?vue&type=template&id=99b7be2c&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/group/EditGroup.vue?vue&type=template&id=99b7be2c& ***!
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
  return _c("div", { staticClass: "box p-4 m-3" }, [
    _c("figure", { staticClass: "image is-128x128" }, [
      _c(
        "label",
        { staticClass: "cursor-pointer" },
        [
          _c("croppa", {
            staticClass: "p-2 card-shadow-s is-full-rounded",
            attrs: {
              width: 128,
              height: 128,
              quality: 1,
              accept: "image/*",
              placeholder: "Image",
              "placeholder-font-size": 16,
              "canvas-color": "transparent",
              "show-remove-button": true,
              "remove-button-color": "black",
              "show-loading": true,
              "loading-size": 50,
              "initial-image": _vm.prevImage
            },
            model: {
              value: _vm.image,
              callback: function($$v) {
                _vm.image = $$v
              },
              expression: "image"
            }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("label", [_vm._v(_vm._s(_vm.trans.get("groups.group_name")))]),
    _vm._v(" "),
    _c("input", {
      directives: [
        {
          name: "model",
          rawName: "v-model",
          value: _vm.group.name,
          expression: "group.name"
        }
      ],
      staticClass: "input",
      attrs: { type: "text" },
      domProps: { value: _vm.group.name },
      on: {
        input: function($event) {
          if ($event.target.composing) {
            return
          }
          _vm.$set(_vm.group, "name", $event.target.value)
        }
      }
    }),
    _vm._v(" "),
    _c(
      "button",
      { staticClass: "button is-dark m-3", on: { click: _vm.edit } },
      [_vm._v("\n    " + _vm._s(_vm.trans.get("general.edit")) + "\n  ")]
    ),
    _vm._v(" "),
    _c(
      "button",
      { staticClass: "button is-danger m-3", on: { click: _vm.remove } },
      [_vm._v("\n    " + _vm._s(_vm.trans.get("general.delete")) + "\n  ")]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/group/EditGroup.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/group/EditGroup.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _EditGroup_vue_vue_type_template_id_99b7be2c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditGroup.vue?vue&type=template&id=99b7be2c& */ "./resources/js/components/group/EditGroup.vue?vue&type=template&id=99b7be2c&");
/* harmony import */ var _EditGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/group/EditGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EditGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EditGroup_vue_vue_type_template_id_99b7be2c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _EditGroup_vue_vue_type_template_id_99b7be2c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/group/EditGroup.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/group/EditGroup.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/group/EditGroup.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./EditGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/EditGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/group/EditGroup.vue?vue&type=template&id=99b7be2c&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/group/EditGroup.vue?vue&type=template&id=99b7be2c& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGroup_vue_vue_type_template_id_99b7be2c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./EditGroup.vue?vue&type=template&id=99b7be2c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/EditGroup.vue?vue&type=template&id=99b7be2c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGroup_vue_vue_type_template_id_99b7be2c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGroup_vue_vue_type_template_id_99b7be2c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);