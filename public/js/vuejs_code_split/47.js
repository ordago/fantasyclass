(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[47],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shop/ShopCreate.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/shop/ShopCreate.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["code", "item"],
  created: function created() {
    if (this.item) {
      this.id = this.item.id;
      this.hp = this.item.hp ? this.item.hp : 0;
      this.xp = this.item.xp ? this.item.xp : 0;
      this.min_lvl = this.item.min_lvl ? this.item.min_lvl : 0;
      this.price = this.item.price ? this.item.price : 0;
      this.description = this.item.description ? this.item.description : "";
      this.prevImage = this.item.icon;
    }
  },
  data: function data() {
    return {
      image: {},
      hp: 0,
      xp: 0,
      min_lvl: 0,
      price: 0,
      description: "",
      prevImage: "",
      id: null
    };
  },
  methods: {
    createItem: function createItem() {
      var _this = this;

      this.image.generateBlob(function (blob) {
        if (blob != null) {
          var formData = new FormData();
          formData.append("icon", blob, "item.png");
          formData.append("hp", _this.hp);
          formData.append("xp", _this.xp);
          formData.append("min_lvl", _this.min_lvl);
          formData.append("price", _this.price);
          formData.append("description", _this.description);

          if (_this.item) {
            formData.append("id", _this.id);
            formData.append("_method", "patch");
          }

          axios.post("/classroom/" + _this.code + "/shop", formData, {
            headers: {
              "content-type": "multipart/form-data"
            }
          }).then(function (response) {
            _this.$toast(response.data.message, {
              type: response.data.type
            });
          });
        }
      }, "image/png", 0.8);
    }
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shop/ShopCreate.vue?vue&type=template&id=2ef56b70&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/shop/ShopCreate.vue?vue&type=template&id=2ef56b70& ***!
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
  return _c("div", { staticClass: "p-3" }, [
    _c(
      "div",
      { staticClass: "rounded" },
      [
        _c("croppa", {
          staticClass: "rounded",
          attrs: {
            width: 60,
            height: 60,
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
    ),
    _vm._v(" "),
    _c("div", { staticClass: "columns mt-2" }, [
      _c("div", { staticClass: "column" }, [
        _c("div", { staticClass: "field is-horizontal" }, [
          _c("div", { staticClass: "field-body" }, [
            _c("div", { staticClass: "field is-expanded" }, [
              _c(
                "div",
                {
                  directives: [{ name: "tippy", rawName: "v-tippy" }],
                  staticClass: "field has-addons",
                  attrs: { content: _vm.trans.get("shop.item_hp") }
                },
                [
                  _vm._m(0),
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
                      attrs: { type: "number" },
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
                ]
              )
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "column" }, [
        _c("div", { staticClass: "field is-horizontal" }, [
          _c("div", { staticClass: "field-body" }, [
            _c("div", { staticClass: "field is-expanded" }, [
              _c(
                "div",
                {
                  directives: [{ name: "tippy", rawName: "v-tippy" }],
                  staticClass: "field has-addons",
                  attrs: { content: _vm.trans.get("shop.item_xp") }
                },
                [
                  _vm._m(1),
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
                      attrs: { type: "number" },
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
                ]
              )
            ])
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "columns" }, [
      _c("div", { staticClass: "column" }, [
        _c("div", { staticClass: "field is-horizontal" }, [
          _c("div", { staticClass: "field-body" }, [
            _c("div", { staticClass: "field is-expanded" }, [
              _c("div", { staticClass: "field has-addons" }, [
                _c("p", { staticClass: "control" }, [
                  _c("a", { staticClass: "button is-static" }, [
                    _vm._v(
                      "\n                  " +
                        _vm._s(_vm.trans.get("shop.price")) +
                        "\n                  "
                    ),
                    _c("i", { staticClass: "fas fa-coins colored" })
                  ])
                ]),
                _vm._v(" "),
                _c("p", { staticClass: "control is-expanded" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.price,
                        expression: "price"
                      }
                    ],
                    staticClass: "input",
                    attrs: { type: "number" },
                    domProps: { value: _vm.price },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.price = $event.target.value
                      }
                    }
                  })
                ])
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "column" }, [
        _c("div", { staticClass: "field is-horizontal" }, [
          _c("div", { staticClass: "field-body" }, [
            _c("div", { staticClass: "field is-expanded" }, [
              _c(
                "div",
                {
                  directives: [{ name: "tippy", rawName: "v-tippy" }],
                  staticClass: "field has-addons",
                  attrs: { content: _vm.trans.get("shop.min_level_info") }
                },
                [
                  _c("p", { staticClass: "control" }, [
                    _c("a", { staticClass: "button is-static" }, [
                      _vm._v(_vm._s(_vm.trans.get("shop.min_level")))
                    ])
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "control is-expanded" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.min_lvl,
                          expression: "min_lvl"
                        }
                      ],
                      staticClass: "input",
                      attrs: { type: "number" },
                      domProps: { value: _vm.min_lvl },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.min_lvl = $event.target.value
                        }
                      }
                    })
                  ])
                ]
              )
            ])
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "columns" }, [
      _c("div", { staticClass: "column" }, [
        _c("textarea", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.description,
              expression: "description"
            }
          ],
          staticClass: "input",
          attrs: { placeholder: _vm.trans.get("shop.description") },
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
      ])
    ]),
    _vm._v(" "),
    !_vm.item
      ? _c(
          "button",
          {
            staticClass: "button is-primary",
            on: {
              click: function($event) {
                return _vm.createItem()
              }
            }
          },
          [
            _c("i", { staticClass: "fas fa-plus" }),
            _vm._v(" " + _vm._s(_vm.trans.get("general.create")) + "\n  ")
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.item
      ? _c(
          "button",
          {
            staticClass: "button is-link",
            on: {
              click: function($event) {
                return _vm.createItem()
              }
            }
          },
          [
            _c("i", { staticClass: "fas fa-edit" }),
            _vm._v(" " + _vm._s(_vm.trans.get("general.edit")) + "\n  ")
          ]
        )
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "control" }, [
      _c("a", { staticClass: "button is-static" }, [
        _c("i", { staticClass: "fas fa-heart colored" })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "control" }, [
      _c("a", { staticClass: "button is-static" }, [
        _c("i", { staticClass: "fas fa-fist-raised colored" })
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/shop/ShopCreate.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/shop/ShopCreate.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShopCreate_vue_vue_type_template_id_2ef56b70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShopCreate.vue?vue&type=template&id=2ef56b70& */ "./resources/js/components/shop/ShopCreate.vue?vue&type=template&id=2ef56b70&");
/* harmony import */ var _ShopCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShopCreate.vue?vue&type=script&lang=js& */ "./resources/js/components/shop/ShopCreate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShopCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShopCreate_vue_vue_type_template_id_2ef56b70___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShopCreate_vue_vue_type_template_id_2ef56b70___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/shop/ShopCreate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/shop/ShopCreate.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/shop/ShopCreate.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShopCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShopCreate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shop/ShopCreate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShopCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/shop/ShopCreate.vue?vue&type=template&id=2ef56b70&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/shop/ShopCreate.vue?vue&type=template&id=2ef56b70& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShopCreate_vue_vue_type_template_id_2ef56b70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShopCreate.vue?vue&type=template&id=2ef56b70& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/shop/ShopCreate.vue?vue&type=template&id=2ef56b70&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShopCreate_vue_vue_type_template_id_2ef56b70___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShopCreate_vue_vue_type_template_id_2ef56b70___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);