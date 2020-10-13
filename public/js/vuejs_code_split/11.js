(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[11],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/badge/CreateBadge.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/badge/CreateBadge.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
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
var IconSelector = function IconSelector() {
  return Promise.all(/*! import() */[__webpack_require__.e(3), __webpack_require__.e(2)]).then(__webpack_require__.bind(null, /*! ../utils/IconSelector.vue */ "./resources/js/components/utils/IconSelector.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['code', 'badge'],
  created: function created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    if (this.badge) {
      this.title = this.trans.get(this.badge.title);
      this.description = this.trans.get(this.badge.description);
      this.hp = this.badge.hp;
      this.xp = this.badge.xp;
      this.gold = this.badge.gold;
      this.icon = this.badge.icon;
      this.id = this.badge.id;
    }
  },
  data: function data() {
    return {
      icon: null,
      csrfToken: null,
      title: null,
      description: null,
      xp: 0,
      hp: 0,
      gold: 0,
      id: null
    };
  },
  components: {
    IconSelector: IconSelector
  },
  methods: {
    formSubmit: function formSubmit(e) {
      e.preventDefault();
    },
    update: function update() {
      var _this = this;

      axios.patch('/classroom/badges/' + this.id, this.$data).then(function (response) {
        _this.$toasted.show(response.data.message, {
          position: "top-center",
          duration: 3000,
          iconPack: 'fontawesome',
          icon: response.data.icon,
          type: response.data.type
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/badge/CreateBadge.vue?vue&type=template&id=ba865980&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/badge/CreateBadge.vue?vue&type=template&id=ba865980& ***!
  \********************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "container has-padding-3" }, [
    _c(
      "form",
      {
        attrs: {
          method: "post",
          action: "/classroom/" + this.code + "/badges",
          enctype: "multipart/form-data"
        }
      },
      [
        _c("input", {
          attrs: { type: "hidden", name: "_token" },
          domProps: { value: _vm.csrfToken }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "field has-addons" }, [
          _c("p", { staticClass: "control" }, [_c("IconSelector")], 1),
          _vm._v(" "),
          _c("p", { staticClass: "control" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.icon,
                  expression: "icon"
                }
              ],
              staticClass: "input",
              attrs: {
                name: "icon",
                required: "",
                placeholder: _vm.trans.get("badges.icon_select"),
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
          { staticClass: "form-group", staticStyle: { "margin-top": "-10px" } },
          [
            _c("label", [
              _c("small", [
                _vm._v(_vm._s(_vm.trans.get("badges.fontawesome")) + " "),
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
        _c("div", { staticClass: "has-margin-top-4" }, [
          _c("label", { attrs: { for: "name" } }, [
            _c("span", { staticClass: "help is-danger is-inline" }, [
              _vm._v("* ")
            ]),
            _vm._v(" " + _vm._s(_vm.trans.get("badges.title")))
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.title,
                expression: "title"
              }
            ],
            staticClass: "input has-margin-y-3",
            attrs: { type: "text", id: "title", name: "title", required: "" },
            domProps: { value: _vm.title },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.title = $event.target.value
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "has-margin-top-2" }, [
          _c("label", { attrs: { for: "custom_text" } }, [
            _vm._v(_vm._s(_vm.trans.get("badges.description")))
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.description,
                expression: "description"
              }
            ],
            staticClass: "input",
            attrs: {
              type: "text",
              name: "description",
              required: "",
              placeholder: ""
            },
            domProps: { value: _vm.description },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.description = $event.target.value
              }
            }
          })
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "has-margin-top-3" }, [
          _c("label", [
            _vm._v(_vm._s(_vm.trans.get("badges.attributes")) + " "),
            _c("small", { staticClass: "font-italic" }, [
              _vm._v(
                "(" + _vm._s(_vm.trans.get("badges.attributes_info")) + ")"
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "columns has-margin-y-1" }, [
            _c("div", { staticClass: "column" }, [
              _c("div", { staticClass: "field has-addons" }, [
                _c("p", { staticClass: "control" }, [
                  _c(
                    "span",
                    {
                      staticClass: "button is-static",
                      class: {
                        "has-background-success": _vm.hp > 0,
                        "has-background-danger": _vm.hp < 0
                      }
                    },
                    [_c("i", { staticClass: "fas fa-heart colored" })]
                  )
                ]),
                _vm._v(" "),
                _c("p", { staticClass: "control is-expanded" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.hp,
                        expression: "hp"
                      }
                    ],
                    staticClass: "input",
                    attrs: { type: "number", name: "hp", required: "" },
                    domProps: { value: _vm.hp },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.hp = $event.target.value
                      }
                    }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "column" }, [
              _c("div", { staticClass: "field has-addons" }, [
                _c("p", { staticClass: "control" }, [
                  _c(
                    "span",
                    {
                      staticClass: "button is-static",
                      class: {
                        "has-background-success": _vm.xp > 0,
                        "has-background-danger": _vm.xp < 0
                      }
                    },
                    [_c("i", { staticClass: "fas fa-fist-raised colored" })]
                  )
                ]),
                _vm._v(" "),
                _c("p", { staticClass: "control is-expanded" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.xp,
                        expression: "xp"
                      }
                    ],
                    staticClass: "input",
                    attrs: { type: "number", name: "xp", required: "" },
                    domProps: { value: _vm.xp },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.xp = $event.target.value
                      }
                    }
                  })
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "column" }, [
              _c("div", { staticClass: "field has-addons" }, [
                _c("p", { staticClass: "control" }, [
                  _c(
                    "span",
                    {
                      staticClass: "button is-static",
                      class: {
                        "has-background-success": _vm.gold > 0,
                        "has-background-danger": _vm.gold < 0
                      }
                    },
                    [_c("i", { staticClass: "fas fa-coins colored" })]
                  )
                ]),
                _vm._v(" "),
                _c("p", { staticClass: "control is-expanded" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.gold,
                        expression: "gold"
                      }
                    ],
                    staticClass: "input",
                    attrs: { type: "number", name: "gold", required: "" },
                    domProps: { value: _vm.gold },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.gold = $event.target.value
                      }
                    }
                  })
                ])
              ])
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", [
          _vm.badge
            ? _c(
                "button",
                {
                  staticClass: "button is-link",
                  attrs: { type: "button" },
                  on: { click: _vm.update }
                },
                [_vm._v(_vm._s(_vm.trans.get("badges.edit")))]
              )
            : _vm._e(),
          _vm._v(" "),
          !_vm.badge
            ? _c(
                "button",
                { staticClass: "button is-success", attrs: { type: "submit" } },
                [_vm._v(_vm._s(_vm.trans.get("badges.create")))]
              )
            : _vm._e()
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/badge/CreateBadge.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/badge/CreateBadge.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateBadge_vue_vue_type_template_id_ba865980___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateBadge.vue?vue&type=template&id=ba865980& */ "./resources/js/components/badge/CreateBadge.vue?vue&type=template&id=ba865980&");
/* harmony import */ var _CreateBadge_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateBadge.vue?vue&type=script&lang=js& */ "./resources/js/components/badge/CreateBadge.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreateBadge_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateBadge_vue_vue_type_template_id_ba865980___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateBadge_vue_vue_type_template_id_ba865980___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/badge/CreateBadge.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/badge/CreateBadge.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/badge/CreateBadge.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBadge_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateBadge.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/badge/CreateBadge.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBadge_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/badge/CreateBadge.vue?vue&type=template&id=ba865980&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/badge/CreateBadge.vue?vue&type=template&id=ba865980& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBadge_vue_vue_type_template_id_ba865980___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateBadge.vue?vue&type=template&id=ba865980& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/badge/CreateBadge.vue?vue&type=template&id=ba865980&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBadge_vue_vue_type_template_id_ba865980___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateBadge_vue_vue_type_template_id_ba865980___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);