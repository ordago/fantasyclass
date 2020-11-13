(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[33],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ImportChallenges.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ImportChallenges.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["classroom", "challengegroup"],
  created: function created() {
    var _this = this;

    axios.get('/user/challenges').then(function (response) {
      _this.fullChallenges = response.data;
    });
  },
  data: function data() {
    return {
      behaviour: null,
      fullChallenges: null
    };
  },
  methods: {
    importChallenge: function importChallenge(challenge) {
      var _this2 = this;

      axios.post('/user/challenges/import/' + challenge.id, {
        'group': this.challengegroup
      }).then(function (response) {
        _this2.$parent.$parent.isImportModalActive = false;

        _this2.$parent.$parent.$parent.getChallenges(_this2.challengegroup);
      }); // this.$parent.$parent.challengeEdit = challenge;
      // this.$parent.$parent.challengeEdit.id = null
      // this.$parent.$parent.challengeEdit.challengeGroup = null
      // this.$parent.$parent.addChallenge = true
      // this.$parent.$parent.importFlag = true
      // // this.$parent.$parent.reload = true
      // this.$parent.$parent.isImportModalActive = false;
    }
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ImportChallenges.vue?vue&type=template&id=1eba78d9&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ImportChallenges.vue?vue&type=template&id=1eba78d9& ***!
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
  return _c(
    "div",
    { staticClass: "modal-card", staticStyle: { width: "auto" } },
    [
      _c("header", { staticClass: "modal-card-head" }, [
        _c("p", { staticClass: "modal-card-title" }, [
          _vm._v(_vm._s(_vm.trans.get("menu.challenges")))
        ])
      ]),
      _vm._v(" "),
      _c(
        "section",
        {
          staticClass: "modal-card-body content",
          staticStyle: { "align-items": "flex-start" }
        },
        _vm._l(_vm.fullChallenges, function(classroom, index) {
          return _c("div", { key: index }, [
            classroom.challenge_groups.length
              ? _c(
                  "details",
                  [
                    _c("summary", { staticClass: "my-3 cursor-pointer" }, [
                      _c("h1", { staticStyle: { display: "inline-block" } }, [
                        _vm._v(_vm._s(classroom.name))
                      ])
                    ]),
                    _vm._v(" "),
                    _c("hr"),
                    _vm._v(" "),
                    _vm._l(classroom.challenge_groups, function(group) {
                      return _c(
                        "div",
                        { key: group.id },
                        [
                          group.challenges.length
                            ? _c("h2", { staticClass: "pl-3" }, [
                                _vm._v(_vm._s(group.name))
                              ])
                            : _c("h2", [
                                _vm._v(
                                  _vm._s(
                                    _vm.trans.get(
                                      "success_error.challenges_empty"
                                    )
                                  )
                                )
                              ]),
                          _vm._v(" "),
                          _vm._l(group.challenges, function(challenge) {
                            return _c(
                              "div",
                              { key: challenge.id, staticClass: "box my-4" },
                              [
                                _c("article", { staticClass: "media" }, [
                                  _c("div", { staticClass: "media-content" }, [
                                    _c("div", { staticClass: "content" }, [
                                      _c("p", { staticClass: "m-3" }, [
                                        _c("strong", [
                                          _vm._v(_vm._s(challenge.title))
                                        ]),
                                        _vm._v(" "),
                                        _c("small", [
                                          _vm._v(_vm._s(challenge.description))
                                        ]),
                                        _vm._v(" "),
                                        _c("br")
                                      ]),
                                      _c("div", {
                                        staticStyle: {
                                          "max-height": "100px",
                                          overflow: "auto"
                                        },
                                        domProps: {
                                          innerHTML: _vm._s(challenge.content)
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("p")
                                    ])
                                  ])
                                ]),
                                _vm._v(" "),
                                _c(
                                  "button",
                                  {
                                    staticClass: "button is-primary my-4",
                                    on: {
                                      click: function($event) {
                                        return _vm.importChallenge(challenge)
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      _vm._s(_vm.trans.get("general.import"))
                                    )
                                  ]
                                )
                              ]
                            )
                          })
                        ],
                        2
                      )
                    })
                  ],
                  2
                )
              : _vm._e()
          ])
        }),
        0
      ),
      _vm._v(" "),
      _c("footer", { staticClass: "modal-card-foot" }, [
        _c(
          "button",
          {
            staticClass: "button",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                _vm.$parent.$parent.isImportModalActive = false
              }
            }
          },
          [_vm._v(_vm._s(_vm.trans.get("general.close")))]
        )
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/challenges/ImportChallenges.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/challenges/ImportChallenges.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ImportChallenges_vue_vue_type_template_id_1eba78d9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImportChallenges.vue?vue&type=template&id=1eba78d9& */ "./resources/js/components/challenges/ImportChallenges.vue?vue&type=template&id=1eba78d9&");
/* harmony import */ var _ImportChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ImportChallenges.vue?vue&type=script&lang=js& */ "./resources/js/components/challenges/ImportChallenges.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ImportChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ImportChallenges_vue_vue_type_template_id_1eba78d9___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ImportChallenges_vue_vue_type_template_id_1eba78d9___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/challenges/ImportChallenges.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/challenges/ImportChallenges.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/challenges/ImportChallenges.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ImportChallenges.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ImportChallenges.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/challenges/ImportChallenges.vue?vue&type=template&id=1eba78d9&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/challenges/ImportChallenges.vue?vue&type=template&id=1eba78d9& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportChallenges_vue_vue_type_template_id_1eba78d9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ImportChallenges.vue?vue&type=template&id=1eba78d9& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ImportChallenges.vue?vue&type=template&id=1eba78d9&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportChallenges_vue_vue_type_template_id_1eba78d9___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportChallenges_vue_vue_type_template_id_1eba78d9___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);