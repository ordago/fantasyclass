(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[50],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/ImageBank.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/ImageBank.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["code", "admin", "student"],
  created: function created() {
    var _this = this;

    axios.get("/classroom/utils/icon-packs").then(function (response) {
      _this.categories = response.data;
    });
  },
  data: function data() {
    return {
      categories: null,
      images: null,
      isModalActive: false
    };
  },
  mounted: function mounted() {},
  methods: {
    updateAvatar: function updateAvatar(image) {
      var formData = new FormData();
      formData.append("url", image);

      if (this.admin) {
        formData.append("student_id", this.student.id);
      }

      axios.post("/classroom/" + this.code + "/setting/updateavatar", formData).then(function (response) {
        location.reload();
      });
    },
    populate: function populate(cat) {
      var _this2 = this;

      axios.get("/classroom/utils/icon-packs/" + cat).then(function (response) {
        _this2.images = response.data;

        _this2.$forceUpdate();
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/ImageBank.vue?vue&type=template&id=c711eb84&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/ImageBank.vue?vue&type=template&id=c711eb84& ***!
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
  return _c(
    "div",
    [
      _c(
        "button",
        {
          staticClass: "button is-info",
          on: {
            click: function($event) {
              _vm.isModalActive = true
            }
          }
        },
        [_vm._v(_vm._s(_vm.trans.get("students.select_image")))]
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            active: _vm.isModalActive,
            "has-modal-card": "",
            "full-screen": "",
            "can-cancel": false
          },
          on: {
            "update:active": function($event) {
              _vm.isModalActive = $event
            }
          }
        },
        [
          _c(
            "div",
            { staticClass: "modal-card", staticStyle: { width: "auto" } },
            [
              _c("header", { staticClass: "modal-card-head" }, [
                _c("p", { staticClass: "modal-card-title" }, [
                  _vm._v(_vm._s(_vm.trans.get("students.select_image_title")))
                ])
              ]),
              _vm._v(" "),
              _c("section", { staticClass: "modal-card-body is-relative" }, [
                _vm.images
                  ? _c(
                      "div",
                      { staticClass: "columns is-multiline" },
                      _vm._l(_vm.images, function(image) {
                        return _c("img", {
                          key: image,
                          attrs: { width: "75px", src: image },
                          on: {
                            click: function($event) {
                              return _vm.updateAvatar(image)
                            }
                          }
                        })
                      }),
                      0
                    )
                  : _c(
                      "div",
                      { staticClass: "columns is-multiline" },
                      _vm._l(_vm.categories, function(category) {
                        return _c(
                          "div",
                          {
                            key: category,
                            staticClass:
                              "column img-categories p-4 m-2 is-flex has-all-centered rounded",
                            on: {
                              click: function($event) {
                                return _vm.populate(category)
                              }
                            }
                          },
                          [
                            _c(
                              "h4",
                              { staticStyle: { display: "inline-block" } },
                              [_vm._v(_vm._s(category))]
                            )
                          ]
                        )
                      }),
                      0
                    ),
                _vm._v(" "),
                _c("div", { staticClass: "my-3" }, [
                  _vm._v("Icons made by "),
                  _c(
                    "a",
                    {
                      attrs: {
                        href: "http://www.freepik.com",
                        title: "Freepik"
                      }
                    },
                    [_vm._v("Freepik")]
                  ),
                  _vm._v(" from "),
                  _c(
                    "a",
                    {
                      attrs: {
                        href: "https://www.flaticon.com/",
                        title: "Flaticon"
                      }
                    },
                    [_vm._v("www.flaticon.com")]
                  ),
                  _vm._v(" is licensed by "),
                  _c(
                    "a",
                    {
                      attrs: {
                        href: "http://creativecommons.org/licenses/by/3.0/",
                        title: "Creative Commons BY 3.0",
                        target: "_blank"
                      }
                    },
                    [_vm._v("CC 3.0 BY")]
                  )
                ])
              ]),
              _vm._v(" "),
              _c(
                "footer",
                {
                  staticClass: "modal-card-foot columns is-multiline",
                  staticStyle: { "overflow-x": "auto" }
                },
                [
                  _c("div", { staticClass: "column is-narrow" }, [
                    _c(
                      "button",
                      {
                        staticClass: "button",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            _vm.isModalActive = false
                          }
                        }
                      },
                      [_vm._v(_vm._s(_vm.trans.get("general.close")))]
                    ),
                    _vm._v(" "),
                    _vm.images != null
                      ? _c(
                          "button",
                          {
                            staticClass: "button is-link",
                            on: {
                              click: function($event) {
                                _vm.images = null
                              }
                            }
                          },
                          [_c("i", { staticClass: "far fa-arrow-left" })]
                        )
                      : _vm._e()
                  ])
                ]
              )
            ]
          )
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/utils/ImageBank.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/utils/ImageBank.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ImageBank_vue_vue_type_template_id_c711eb84___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImageBank.vue?vue&type=template&id=c711eb84& */ "./resources/js/components/utils/ImageBank.vue?vue&type=template&id=c711eb84&");
/* harmony import */ var _ImageBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ImageBank.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/ImageBank.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ImageBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ImageBank_vue_vue_type_template_id_c711eb84___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ImageBank_vue_vue_type_template_id_c711eb84___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/ImageBank.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/ImageBank.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/utils/ImageBank.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ImageBank.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/ImageBank.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBank_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/ImageBank.vue?vue&type=template&id=c711eb84&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/utils/ImageBank.vue?vue&type=template&id=c711eb84& ***!
  \************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBank_vue_vue_type_template_id_c711eb84___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ImageBank.vue?vue&type=template&id=c711eb84& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/ImageBank.vue?vue&type=template&id=c711eb84&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBank_vue_vue_type_template_id_c711eb84___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageBank_vue_vue_type_template_id_c711eb84___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);