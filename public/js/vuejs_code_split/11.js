(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
var IconSelector = function IconSelector() {
  return Promise.all(/*! import() */[__webpack_require__.e(3), __webpack_require__.e(2)]).then(__webpack_require__.bind(null, /*! ../utils/IconSelector.vue */ "./resources/js/components/utils/IconSelector.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["code", "challenge", "editgroup"],
  created: function created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if (this.editgroup) this.challengeInfo = this.editgroup;
  },
  data: function data() {
    return {
      csrfToken: null,
      challengeInfo: {
        challenges_group_id: null,
        id: null,
        icon: this.icon,
        name: null
      },
      icon: null
    };
  },
  components: {
    IconSelector: IconSelector
  },
  methods: {
    formSubmit: function formSubmit(e) {
      var _this = this;

      this.challengeInfo.icon = this.icon;
      axios.post("/classroom/" + this.code + "/challenges/group", this.$data.challengeInfo).then(function (response) {
        _this.$toast(response.data.message, {
          type: response.data.type
        });

        if (response.data.challenge) {
          _this.$parent.refresh(response.data.challenge);
        }
      });
      this.$parent.activeAddGroup = false;
      this.$parent.$forceUpdate();
    },
    update: function update() {}
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=template&id=583d775c&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=template&id=583d775c& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
            _c("div", { staticClass: "my-3" }, [
              _c("label", { attrs: { for: "name" } }, [
                _c("span", { staticClass: "help is-danger is-inline" }, [
                  _vm._v("* ")
                ]),
                _vm._v(
                  "\n            " + _vm._s(_vm.trans.get("challenges.icon"))
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "field has-addons" }, [
              _c("p", { staticClass: "control" }, [_c("IconSelector")], 1),
              _vm._v(" "),
              _c("p", { staticClass: "control is-expanded" }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.icon,
                      expression: "icon"
                    }
                  ],
                  ref: "icon",
                  staticClass: "input",
                  attrs: {
                    name: "icon",
                    required: "",
                    placeholder: _vm.trans.get("behaviours.icon_select"),
                    type: "text"
                  },
                  domProps: { value: _vm.icon },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.icon = $event.target.value
                    }
                  }
                })
              ])
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "form-group",
                staticStyle: { "margin-top": "-10px" }
              },
              [
                _c("label", [
                  _c("small", [
                    _vm._v(
                      _vm._s(_vm.trans.get("behaviours.fontawesome")) +
                        "\n              "
                    ),
                    _c(
                      "a",
                      {
                        attrs: {
                          href: "https://fontawesome.com/icons?d=gallery",
                          target: "_blank"
                        }
                      },
                      [_vm._v("FontAwesome")]
                    )
                  ])
                ])
              ]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "mt-3" }, [
              _c("label", { attrs: { for: "name" } }, [
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
                    value: _vm.challengeInfo.name,
                    expression: "challengeInfo.name"
                  }
                ],
                staticClass: "input my-3",
                attrs: { type: "text", id: "name", name: "name", required: "" },
                domProps: { value: _vm.challengeInfo.name },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.challengeInfo, "name", $event.target.value)
                  }
                }
              })
            ]),
            _vm._v(" "),
            _vm.$parent.challengesgroup.length
              ? _c("div", { staticClass: "mt-3" }, [
                  _c("label", { attrs: { for: "name" } }, [
                    _vm._v(_vm._s(_vm.trans.get("challenges.parent")))
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "field" }, [
                    _c("div", { staticClass: "control" }, [
                      _c("div", { staticClass: "select is-fullwidth" }, [
                        _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.challengeInfo.challenges_group_id,
                                expression: "challengeInfo.challenges_group_id"
                              }
                            ],
                            on: {
                              change: function($event) {
                                var $$selectedVal = Array.prototype.filter
                                  .call($event.target.options, function(o) {
                                    return o.selected
                                  })
                                  .map(function(o) {
                                    var val = "_value" in o ? o._value : o.value
                                    return val
                                  })
                                _vm.$set(
                                  _vm.challengeInfo,
                                  "challenges_group_id",
                                  $event.target.multiple
                                    ? $$selectedVal
                                    : $$selectedVal[0]
                                )
                              }
                            }
                          },
                          [
                            _c("option", { attrs: { value: "0" } }),
                            _vm._v(" "),
                            _vm._l(_vm.$parent.challengesgroup, function(
                              challenge
                            ) {
                              return _c(
                                "option",
                                {
                                  key: challenge.id,
                                  domProps: { value: challenge.id }
                                },
                                [
                                  _vm._v(
                                    "\n                    " +
                                      _vm._s(challenge.name) +
                                      "\n                  "
                                  )
                                ]
                              )
                            })
                          ],
                          2
                        )
                      ])
                    ])
                  ])
                ])
              : _vm._e(),
            _vm._v(" "),
            _c("div", { staticClass: "mt-3" }, [
              _vm.challenge
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
              !_vm.challenge
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

/***/ "./resources/js/components/challenges/CreateChallengeGroup.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/challenges/CreateChallengeGroup.vue ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateChallengeGroup_vue_vue_type_template_id_583d775c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateChallengeGroup.vue?vue&type=template&id=583d775c& */ "./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=template&id=583d775c&");
/* harmony import */ var _CreateChallengeGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateChallengeGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreateChallengeGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateChallengeGroup_vue_vue_type_template_id_583d775c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateChallengeGroup_vue_vue_type_template_id_583d775c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/challenges/CreateChallengeGroup.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallengeGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateChallengeGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallengeGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=template&id=583d775c&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=template&id=583d775c& ***!
  \****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallengeGroup_vue_vue_type_template_id_583d775c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateChallengeGroup.vue?vue&type=template&id=583d775c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/CreateChallengeGroup.vue?vue&type=template&id=583d775c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallengeGroup_vue_vue_type_template_id_583d775c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallengeGroup_vue_vue_type_template_id_583d775c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);