(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[42],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Profile.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/profile/Profile.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["user", "lang"],
  mounted: function mounted() {
    this.name = this.user.name;
    this.user_lang = this.user.locale;
    this.email = this.user.email;
  },
  data: function data() {
    return {
      name: "",
      current_password: "",
      password: "",
      password_confirm: "",
      user_lang: "",
      email_change: false,
      email: "",
      _method: "patch"
    };
  },
  methods: {
    promote: function promote() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("profile.only_teachers_title"),
        message: this.trans.get("profile.only_teachers"),
        confirmText: this.trans.get("profile.only_teachers_accept"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-warning",
        hasIcon: true,
        icon: "exclamation-triangle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: function onConfirm() {
          axios.get("/profile/promote").then(function (response) {
            location.href = "/classroom";
          });
        }
      });
    },
    axiosSend: function axiosSend() {
      var _this = this;

      axios.patch("/profile/update", this.$data).then(function (response) {
        _this.$toast(_this.trans.get("profile.update_success"), {
          type: "success"
        });

        location.reload();
      })["catch"](function (error) {
        _this.$toast(_this.trans.get("profile.incorrect_password"), {
          type: "error"
        });
      });
    },
    send: function send() {
      var _this2 = this;

      if (this.password != this.password_confirm) {
        this.$refs.new_password.classList.add("is-danger");
        this.$refs.password_confirm.classList.add("is-danger");
        return false;
      }

      if (this.email_change) {
        this.$buefy.dialog.prompt({
          message: "Please repeat the e-mail",
          inputAttrs: {
            placeholder: ""
          },
          trapFocus: true,
          onConfirm: function onConfirm(value) {
            if (value == _this2.email) _this2.axiosSend();else {
              _this2.$toast("The e-mail verification failed", {
                type: "error"
              });
            }
          }
        });
      } else this.axiosSend();
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Profile.vue?vue&type=template&id=5031abb0&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/profile/Profile.vue?vue&type=template&id=5031abb0& ***!
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
  return _c("div", { staticClass: "p-2" }, [
    _c(
      "form",
      {
        on: {
          submit: function($event) {
            $event.preventDefault()
            return _vm.send($event)
          }
        }
      },
      [
        _c("section", { staticClass: "px-3" }, [
          _c("h1", { staticClass: "is-size-2" }, [
            _c("i", { staticClass: "fal fa-cog faa-spin animated faa-slow" }),
            _vm._v(
              "\n        " +
                _vm._s(_vm.trans.get("profile.profile")) +
                "\n      "
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "my-4" }, [
            _c("label", { staticClass: "my-2", attrs: { for: "name" } }, [
              _vm._v(_vm._s(_vm.trans.get("profile.name")))
            ]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.name,
                  expression: "name"
                }
              ],
              staticClass: "input my-2 is-info",
              attrs: {
                id: "name",
                type: "text",
                minlength: "2",
                name: "name",
                required: "",
                autocomplete: "name",
                autofocus: ""
              },
              domProps: { value: _vm.name },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.name = $event.target.value
                }
              }
            })
          ]),
          _vm._v(" "),
          _vm.user.email
            ? _c("span", [
                _c("div", { staticClass: "my-4" }, [
                  _c(
                    "label",
                    { staticClass: "my-2", attrs: { for: "new-password" } },
                    [_vm._v(_vm._s(_vm.trans.get("profile.new_password")))]
                  ),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.password,
                        expression: "password"
                      }
                    ],
                    ref: "new_password",
                    staticClass: "input my-2 is-info",
                    attrs: {
                      type: "password",
                      name: "password",
                      minlength: "8",
                      autocomplete: "new-password"
                    },
                    domProps: { value: _vm.password },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.password = $event.target.value
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "my-4" }, [
                  _vm.password.length
                    ? _c(
                        "label",
                        {
                          staticClass: "my-2",
                          attrs: { for: "password_confirmation" }
                        },
                        [
                          _vm._v(
                            _vm._s(
                              _vm.trans.get("profile.confirm_new_password")
                            )
                          )
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.password.length
                    ? _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.password_confirm,
                            expression: "password_confirm"
                          }
                        ],
                        ref: "password_confirm",
                        staticClass: "input my-2 is-info",
                        attrs: {
                          type: "password",
                          minlength: "8",
                          name: "password_confirmation",
                          autocomplete: "new-password"
                        },
                        domProps: { value: _vm.password_confirm },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.password_confirm = $event.target.value
                          }
                        }
                      })
                    : _vm._e()
                ])
              ])
            : _c("div", { staticClass: "notification is-warning is-light" }, [
                _c("i", { staticClass: "fas fa-exclamation-triangle mr-1" }),
                _vm._v(
                  "\n        " +
                    _vm._s(_vm.trans.get("profile.password_email")) +
                    "\n      "
                )
              ]),
          _vm._v(" "),
          _c("div", { staticClass: "mt-4" }, [
            _c(
              "label",
              { staticClass: "my-2", attrs: { for: "new-password" } },
              [_vm._v("E-mail")]
            ),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.email,
                  expression: "email"
                }
              ],
              staticClass: "input my-2 is-info",
              attrs: { type: "email" },
              domProps: { value: _vm.email },
              on: {
                input: [
                  function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.email = $event.target.value
                  },
                  function($event) {
                    _vm.email_change = true
                  }
                ]
              }
            })
          ]),
          _vm._v(" "),
          _c("small", [_vm._v(_vm._s(_vm.trans.get("profile.info_email")))]),
          _vm._v(" "),
          _c("div", { staticClass: "my-4" }, [
            _vm.password.length || _vm.email_change
              ? _c(
                  "label",
                  { staticClass: "my-2", attrs: { for: "current-password" } },
                  [_vm._v(_vm._s(_vm.trans.get("profile.current_password")))]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.password.length || _vm.email_change
              ? _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.current_password,
                      expression: "current_password"
                    }
                  ],
                  staticClass: "input my-2 is-info",
                  attrs: {
                    type: "password",
                    name: "current_password",
                    required: "",
                    autocomplete: "current-password"
                  },
                  domProps: { value: _vm.current_password },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.current_password = $event.target.value
                    }
                  }
                })
              : _vm._e()
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "my-4 form-group" }, [
            _c("label", { staticClass: "my-2", attrs: { for: "language" } }, [
              _vm._v(_vm._s(_vm.trans.get("profile.language")))
            ]),
            _vm._v(" "),
            _c(
              "select",
              {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.user_lang,
                    expression: "user_lang"
                  }
                ],
                staticClass: "form-control input my-2 is-info",
                attrs: { id: "locale" },
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
                    _vm.user_lang = $event.target.multiple
                      ? $$selectedVal
                      : $$selectedVal[0]
                  }
                }
              },
              _vm._l(_vm.lang, function(language, code) {
                return _c(
                  "option",
                  { key: language, domProps: { value: code } },
                  [_vm._v("\n            " + _vm._s(language) + "\n          ")]
                )
              }),
              0
            )
          ]),
          _vm._v(" "),
          _vm.user.is_student == 1 && _vm.user.email
            ? _c(
                "button",
                {
                  staticClass: "button is-dark",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.promote($event)
                    }
                  }
                },
                [
                  _vm._v(
                    "\n        " +
                      _vm._s(_vm.trans.get("profile.upgrade")) +
                      "\n      "
                  )
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "is-flex px-4 py-4",
              staticStyle: { position: "fixed", bottom: "0", right: "0" }
            },
            [
              _c("button", { staticClass: "button is-link" }, [
                _vm._v(
                  "\n          " +
                    _vm._s(_vm.trans.get("profile.edit")) +
                    "\n        "
                )
              ])
            ]
          )
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/profile/Profile.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/profile/Profile.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Profile_vue_vue_type_template_id_5031abb0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Profile.vue?vue&type=template&id=5031abb0& */ "./resources/js/components/profile/Profile.vue?vue&type=template&id=5031abb0&");
/* harmony import */ var _Profile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Profile.vue?vue&type=script&lang=js& */ "./resources/js/components/profile/Profile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Profile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Profile_vue_vue_type_template_id_5031abb0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Profile_vue_vue_type_template_id_5031abb0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/profile/Profile.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/profile/Profile.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/profile/Profile.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Profile.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Profile.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/profile/Profile.vue?vue&type=template&id=5031abb0&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/profile/Profile.vue?vue&type=template&id=5031abb0& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_template_id_5031abb0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Profile.vue?vue&type=template&id=5031abb0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Profile.vue?vue&type=template&id=5031abb0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_template_id_5031abb0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Profile_vue_vue_type_template_id_5031abb0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);