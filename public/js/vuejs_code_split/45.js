(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[45],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/CreateQuestionBank.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/questions/CreateQuestionBank.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
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
  props: ["code", "editBank"],
  created: function created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if (this.editBank) this.questionBank = this.editBank;
  },
  data: function data() {
    return {
      csrfToken: null,
      questionBank: {
        id: null,
        title: null
      },
      icon: null
    };
  },
  components: {},
  methods: {
    formSubmit: function formSubmit(e) {
      axios.post("/classroom/" + this.code + "/questions", this.$data.questionBank).then(function (response) {// this.$toast(response.data.message, { type: response.data.type });
        // if (response.data.challenge) {
        //   this.$parent.refresh(response.data.challenge);
        // }
      });
      this.$parent.activeAddBank = false;
      this.$parent.$forceUpdate();
    },
    update: function update() {}
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/CreateQuestionBank.vue?vue&type=template&id=7ac0204b&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/questions/CreateQuestionBank.vue?vue&type=template&id=7ac0204b& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "pl-0-desktop" }, [
    _c("div", { staticClass: "panel pl-0" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "p-4 panel-block" }, [
        _c(
          "form",
          {
            staticClass: "w-100",
            attrs: {
              method: "post",
              action: "/classroom/" + this.code + "/challenge"
            },
            on: {
              submit: function($event) {
                $event.preventDefault()
                return _vm.formSubmit($event)
              }
            }
          },
          [
            _c("input", {
              attrs: { type: "hidden", name: "_token" },
              domProps: { value: _vm.csrfToken }
            }),
            _vm._v(" "),
            _c("div", { staticClass: "mt-3" }, [
              _c("label", { attrs: { for: "title" } }, [
                _c("span", { staticClass: "help is-danger is-inline" }, [
                  _vm._v("* ")
                ]),
                _vm._v(
                  "\n            " + _vm._s(_vm.trans.get("challenges.name"))
                )
              ]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.questionBank.title,
                    expression: "questionBank.title"
                  }
                ],
                staticClass: "input my-3",
                attrs: {
                  type: "text",
                  name: "title",
                  id: "title",
                  required: "",
                  minlength: "3"
                },
                domProps: { value: _vm.questionBank.title },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.questionBank, "title", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "mt-3" }, [
              _vm.editBank
                ? _c(
                    "button",
                    {
                      staticClass: "button is-link",
                      attrs: { type: "button" },
                      on: { click: _vm.update }
                    },
                    [
                      _vm._v(
                        "\n            " +
                          _vm._s(_vm.trans.get("challenges.edit")) +
                          "\n          "
                      )
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              !_vm.editBank
                ? _c(
                    "button",
                    {
                      staticClass: "button is-success",
                      attrs: { type: "submit" }
                    },
                    [
                      _vm._v(
                        "\n            " +
                          _vm._s(_vm.trans.get("challenges.create")) +
                          "\n          "
                      )
                    ]
                  )
                : _vm._e()
            ])
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "p",
      {
        staticClass:
          "panel-heading is-flex has-space-between align-items-center p-4"
      },
      [_c("span", { staticClass: "pl-3" }, [_vm._v("Create ")])]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/questions/CreateQuestionBank.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/questions/CreateQuestionBank.vue ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateQuestionBank_vue_vue_type_template_id_7ac0204b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateQuestionBank.vue?vue&type=template&id=7ac0204b& */ "./resources/js/components/questions/CreateQuestionBank.vue?vue&type=template&id=7ac0204b&");
/* harmony import */ var _CreateQuestionBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateQuestionBank.vue?vue&type=script&lang=js& */ "./resources/js/components/questions/CreateQuestionBank.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreateQuestionBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateQuestionBank_vue_vue_type_template_id_7ac0204b___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateQuestionBank_vue_vue_type_template_id_7ac0204b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/questions/CreateQuestionBank.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/questions/CreateQuestionBank.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/questions/CreateQuestionBank.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateQuestionBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateQuestionBank.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/CreateQuestionBank.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateQuestionBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/questions/CreateQuestionBank.vue?vue&type=template&id=7ac0204b&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/questions/CreateQuestionBank.vue?vue&type=template&id=7ac0204b& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateQuestionBank_vue_vue_type_template_id_7ac0204b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateQuestionBank.vue?vue&type=template&id=7ac0204b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/CreateQuestionBank.vue?vue&type=template&id=7ac0204b&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateQuestionBank_vue_vue_type_template_id_7ac0204b___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateQuestionBank_vue_vue_type_template_id_7ac0204b___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);