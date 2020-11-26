(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[18],{

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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateQuestionBank_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateQuestionBank.vue */ "./resources/js/components/questions/CreateQuestionBank.vue");
/* harmony import */ var _ShowQuestions_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowQuestions.vue */ "./resources/js/components/questions/ShowQuestions.vue");
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
//
//
//
//
// import Utils from "../../utils.js";


_CreateQuestionBank_vue__WEBPACK_IMPORTED_MODULE_0__["default"];
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["code", "banks"],
  created: function created() {},
  data: function data() {
    return {
      activeAddBank: false,
      activeBank: false,
      updated: false,
      questions: [],
      isLoading: false
    };
  },
  methods: {
    getQuestions: function getQuestions() {
      var _this = this;

      var bank = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;

      if (!bank) {
        // That is whithout category, just for clarify
        bank = "wc";
      }

      axios.get("/classroom/" + this.code + "/questions/" + bank).then(function (response) {
        _this.questions = response.data;
        console.log(response.data);
      });
    }
  },
  components: {
    CreateQuestionBank: _CreateQuestionBank_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    ShowQuestions: _ShowQuestions_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  computed: {
    buttonAddGroup: function buttonAddGroup() {
      return this.activeAddBank ? this.trans.get("general.cancel") : "<i class='far fa-plus pr-2'></i>" + this.trans.get("challenges.add_category");
    }
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=template&id=2c310917&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=template&id=2c310917& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "columns p-2" }, [
    _c(
      "div",
      {
        staticClass: "column is-narrow pr-0",
        staticStyle: { "min-width": "400px" }
      },
      [
        _c(
          "article",
          { staticClass: "panel is-info" },
          [
            _c(
              "p",
              {
                staticClass:
                  "panel-heading is-flex has-space-between align-items-center p-3"
              },
              [
                _c("span", [
                  _vm._v(_vm._s(_vm.trans.get("challenges.categories")))
                ]),
                _vm._v(" "),
                _c("button", {
                  staticClass: "button",
                  domProps: { innerHTML: _vm._s(_vm.buttonAddGroup) },
                  on: {
                    click: function($event) {
                      _vm.activeAddBank = !_vm.activeAddBank
                    }
                  }
                })
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "panel-block is-flex is-flex-column p-0",
                staticStyle: { "align-items": "flex-start" }
              },
              [
                _c(
                  "div",
                  {
                    staticClass:
                      "highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer pl-1 pr-4 py-3",
                    on: {
                      click: function($event) {
                        _vm.getQuestions()
                        _vm.activeBank = { title: "Without category" }
                      }
                    }
                  },
                  [_vm._m(0), _vm._v(" "), _vm._m(1)]
                )
              ]
            ),
            _vm._v(" "),
            _vm._l(_vm.banks, function(questionB) {
              return _c(
                "div",
                {
                  key: questionB.id,
                  staticClass: "panel-block is-flex is-flex-column p-0",
                  staticStyle: { "align-items": "flex-start" }
                },
                [
                  _c(
                    "div",
                    {
                      staticClass:
                        "highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer pl-1 pr-4 py-3",
                      on: {
                        click: function($event) {
                          _vm.getQuestions(questionB.id)
                          _vm.activeBank = questionB
                        }
                      }
                    },
                    [
                      _c("span", { staticClass: "p-2" }, [
                        _vm._m(2, true),
                        _vm._v(" "),
                        _c("span", { attrs: { title: questionB.title } }, [
                          _vm._v(
                            "\n              " +
                              _vm._s(
                                questionB.title.length > 30
                                  ? questionB.title.substring(0, 30) + "..."
                                  : questionB.title
                              ) +
                              "\n              "
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _vm._m(3, true)
                    ]
                  )
                ]
              )
            })
          ],
          2
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "column pr-0" },
      [
        _c("b-loading", {
          attrs: {
            "is-full-page": true,
            active: _vm.isLoading,
            "can-cancel": false
          },
          on: {
            "update:active": function($event) {
              _vm.isLoading = $event
            }
          }
        }),
        _vm._v(" "),
        _vm.activeAddBank
          ? _c("CreateQuestionBank", {
              attrs: { code: _vm.code, "edit-bank": "" }
            })
          : _vm._e(),
        _vm._v(" "),
        !_vm.activeAddBank && _vm.activeBank && !_vm.isLoading
          ? _c("ShowQuestions", {
              attrs: {
                code: _vm.code,
                bank: _vm.activeBank,
                questions: _vm.questions
              }
            })
          : _vm._e()
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "p-2" }, [
      _c("span", { staticClass: "panel-icon" }, [
        _c("i", { staticClass: "fad fa-books", staticStyle: { color: "#ccc" } })
      ]),
      _vm._v(" "),
      _c("span", [_vm._v(" Without category ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "p-2 arrow rounded-right" }, [
      _c("i", { staticClass: "fal fa-angle-right" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "panel-icon" }, [
      _c("i", { staticClass: "fad fa-books" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "p-2 arrow rounded-right" }, [
      _c("i", { staticClass: "fal fa-angle-right" })
    ])
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



/***/ }),

/***/ "./resources/js/components/questions/ShowQuestionBanks.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestionBanks.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowQuestionBanks_vue_vue_type_template_id_2c310917___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowQuestionBanks.vue?vue&type=template&id=2c310917& */ "./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=template&id=2c310917&");
/* harmony import */ var _ShowQuestionBanks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowQuestionBanks.vue?vue&type=script&lang=js& */ "./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowQuestionBanks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowQuestionBanks_vue_vue_type_template_id_2c310917___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowQuestionBanks_vue_vue_type_template_id_2c310917___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/questions/ShowQuestionBanks.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestionBanks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestionBanks.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestionBanks_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=template&id=2c310917&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=template&id=2c310917& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestionBanks_vue_vue_type_template_id_2c310917___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestionBanks.vue?vue&type=template&id=2c310917& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestionBanks.vue?vue&type=template&id=2c310917&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestionBanks_vue_vue_type_template_id_2c310917___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestionBanks_vue_vue_type_template_id_2c310917___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);