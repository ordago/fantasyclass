(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[17],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowQuestion.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowQuestion.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var canvas_confetti__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! canvas-confetti */ "./node_modules/canvas-confetti/dist/confetti.module.mjs");
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
  props: ["question", "admin", "index"],
  created: function created() {
    this.reactiveQuestion = this.question;
  },
  data: function data() {
    return {
      reactiveQuestion: null
    };
  },
  methods: {
    confirmDelete: function confirmDelete(id, index) {
      var _this = this;

      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: function onConfirm() {
          axios["delete"]("/classroom/challenge/question/" + id).then(function (response) {
            if (response.data === 1) {
              _this.$parent.challenge.stats.splice(index, 1); // this.$forceUpdate();

            }
          });
        }
      });
    },
    answerQuestion: function answerQuestion(answer) {
      var _this2 = this;

      axios.post("/classroom/question/answer", {
        answer: answer,
        question: this.reactiveQuestion
      }).then(function (response) {
        if (response.data.correct == true) {
          Object(canvas_confetti__WEBPACK_IMPORTED_MODULE_0__["default"])({
            particleCount: 200,
            spread: 100,
            origin: {
              y: 1.0
            }
          });
        }

        _this2.reactiveQuestion = response.data;
      });
    }
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".answer:hover {\n  background-color: wheat;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestion.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowQuestion.vue?vue&type=template&id=09135fe7&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowQuestion.vue?vue&type=template&id=09135fe7& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "box card-shadow-s p-3 my-3" }, [
    _vm.admin
      ? _c("div", { staticClass: "columns" }, [
          _c("div", { staticClass: "column" }, [
            _c("p", { staticClass: "p-4" }, [
              _c("i", { staticClass: "fas fa-question-circle" }),
              _vm._v(
                "\n        " +
                  _vm._s(_vm.reactiveQuestion.question) +
                  "\n        "
              ),
              _c(
                "span",
                {
                  directives: [{ name: "tippy", rawName: "v-tippy" }],
                  staticClass: "tag is-dark",
                  attrs: { content: _vm.reactiveQuestion.stats.remainning }
                },
                [
                  _c("i", { staticClass: "fas fa-user" }),
                  _vm._v(
                    "\n          " +
                      _vm._s(_vm.reactiveQuestion.stats.answered) +
                      " /\n          "
                  ),
                  _c("i", { staticClass: "fas fa-user-slash" }),
                  _vm._v(
                    "\n          " +
                      _vm._s(_vm.reactiveQuestion.stats.remainning.length) +
                      "\n        "
                  )
                ]
              ),
              _vm._v(" "),
              _vm.reactiveQuestion.stats.answeredOK.length
                ? _c(
                    "span",
                    {
                      directives: [{ name: "tippy", rawName: "v-tippy" }],
                      staticClass: "tag is-success",
                      attrs: { content: _vm.reactiveQuestion.stats.answeredOK }
                    },
                    [
                      _c("i", { staticClass: "fas fa-check" }),
                      _vm._v(
                        "\n          " +
                          _vm._s(_vm.reactiveQuestion.stats.answeredOK.length) +
                          "\n        "
                      )
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.reactiveQuestion.stats.answeredKO.length
                ? _c(
                    "span",
                    {
                      directives: [{ name: "tippy", rawName: "v-tippy" }],
                      staticClass: "tag is-danger",
                      attrs: { content: _vm.reactiveQuestion.stats.answeredKO }
                    },
                    [
                      _c("i", { staticClass: "fas fa-times" }),
                      _vm._v(
                        "\n          " +
                          _vm._s(_vm.reactiveQuestion.stats.answeredKO.length) +
                          "\n        "
                      )
                    ]
                  )
                : _vm._e()
            ])
          ]),
          _vm._v(" "),
          _vm.admin
            ? _c("div", { staticClass: "column is-narrow" }, [
                _c(
                  "button",
                  {
                    staticClass: "button is-danger",
                    on: {
                      click: function($event) {
                        return _vm.confirmDelete(
                          _vm.reactiveQuestion.id,
                          _vm.index
                        )
                      }
                    }
                  },
                  [_c("i", { staticClass: "fas fa-trash" })]
                )
              ])
            : _vm._e()
        ])
      : _vm._e(),
    _vm._v(" "),
    !_vm.admin
      ? _c("div", [
          _c("h3", { staticClass: "p-4" }, [
            _c("i", { staticClass: "fas fa-question-circle" }),
            _vm._v(
              "\n      " + _vm._s(_vm.reactiveQuestion.question) + "\n    "
            )
          ]),
          _vm._v(" "),
          _vm.reactiveQuestion.answered
            ? _c("div", [
                _vm.reactiveQuestion.answerKO
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "has-background-danger-light card-shadow-s p-4 m-3 rounded"
                      },
                      [
                        !_vm.reactiveQuestion.correct
                          ? _c("i", {
                              staticClass: "fas fa-sad-tear colored pr-2"
                            })
                          : _vm._e(),
                        _vm._v(
                          "\n        " +
                            _vm._s(_vm.reactiveQuestion.answerKO.answer.text) +
                            "\n      "
                        )
                      ]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "has-background-success-light card-shadow-s p-4 m-3 rounded"
                  },
                  [
                    _vm.reactiveQuestion.correct
                      ? _c("i", {
                          staticClass: "fas fa-smile-beam colored pr-2"
                        })
                      : _vm._e(),
                    _vm._v(
                      "\n        " +
                        _vm._s(_vm.reactiveQuestion.answerOK.answer.text) +
                        "\n      "
                    )
                  ]
                )
              ])
            : _vm._e(),
          _vm._v(" "),
          !_vm.reactiveQuestion.answered
            ? _c(
                "div",
                _vm._l(_vm.reactiveQuestion.answers, function(answer) {
                  return _c(
                    "div",
                    {
                      key: answer.id,
                      staticClass:
                        "card-shadow-s p-4 m-3 rounded answer cursor-pointer",
                      on: {
                        click: function($event) {
                          return _vm.answerQuestion(answer.id)
                        }
                      }
                    },
                    [_vm._v("\n        " + _vm._s(answer.answer) + "\n      ")]
                  )
                }),
                0
              )
            : _vm._e()
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/challenges/ShowQuestion.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/challenges/ShowQuestion.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowQuestion_vue_vue_type_template_id_09135fe7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowQuestion.vue?vue&type=template&id=09135fe7& */ "./resources/js/components/challenges/ShowQuestion.vue?vue&type=template&id=09135fe7&");
/* harmony import */ var _ShowQuestion_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowQuestion.vue?vue&type=script&lang=js& */ "./resources/js/components/challenges/ShowQuestion.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _ShowQuestion_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ShowQuestion.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _ShowQuestion_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowQuestion_vue_vue_type_template_id_09135fe7___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowQuestion_vue_vue_type_template_id_09135fe7___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/challenges/ShowQuestion.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/challenges/ShowQuestion.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowQuestion.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestion.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowQuestion.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss& ***!
  \***********************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestion.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowQuestion.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/challenges/ShowQuestion.vue?vue&type=template&id=09135fe7&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowQuestion.vue?vue&type=template&id=09135fe7& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_template_id_09135fe7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestion.vue?vue&type=template&id=09135fe7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowQuestion.vue?vue&type=template&id=09135fe7&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_template_id_09135fe7___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_template_id_09135fe7___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);