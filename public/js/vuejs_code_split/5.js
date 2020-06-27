(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateChallengeGroup_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateChallengeGroup.vue */ "./resources/js/components/challenges/CreateChallengeGroup.vue");
/* harmony import */ var _ShowChallenges_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowChallenges.vue */ "./resources/js/components/challenges/ShowChallenges.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["code", "challengesgroup", "icon"],
  mounted: function mounted() {},
  data: function data() {
    return {
      activeAddGroup: false,
      activeGroup: false,
      updated: false,
      challenges: [],
      isLoading: false,
      isFullPage: true
    };
  },
  methods: {
    refresh: function refresh(elem) {
      if (elem.challenges_group_id) {
        var challenge = this.challengesgroup.filter(function (data) {
          return data.id == elem.challenges_group_id;
        });
        challenge[0].children.push(elem);
      } else this.challengesgroup.push(elem);

      this.$forceUpdate();
    },
    getChallenges: function getChallenges(id) {
      var _this = this;

      this.isLoading = true;
      axios.post("/classroom/" + this.code + "/challenges/get", {
        id: id
      }).then(function (response) {
        _this.challenges = response.data;
        _this.$forceUpdate;
        _this.isLoading = false;
      });
    }
  },
  components: {
    CreateChallengeGroup: _CreateChallengeGroup_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    ShowChallenges: _ShowChallenges_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  computed: {
    buttonAddGroup: function buttonAddGroup() {
      return this.activeAddGroup ? this.trans.get("general.cancel") : "<i class='far fa-plus has-padding-right-2'></i>" + this.trans.get("challenges.add_category");
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=template&id=570e1b04&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=template&id=570e1b04& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "columns" }, [
    _c(
      "div",
      {
        staticClass: "column is-narrow",
        staticStyle: { "min-width": "400px" }
      },
      [
        _c(
          "article",
          { staticClass: "panel is-sticky-panel is-info has-padding-bottom-4" },
          [
            _c(
              "p",
              {
                staticClass:
                  "panel-heading is-flex has-space-between align-items-center has-padding-3"
              },
              [
                _c("span", [_vm._v("Categories")]),
                _vm._v(" "),
                _c("button", {
                  staticClass: "button",
                  domProps: { innerHTML: _vm._s(_vm.buttonAddGroup) },
                  on: {
                    click: function($event) {
                      _vm.activeAddGroup = !_vm.activeAddGroup
                    }
                  }
                })
              ]
            ),
            _vm._v(" "),
            _vm._l(_vm.challengesgroup, function(challenge) {
              return _c(
                "div",
                {
                  key: challenge.id,
                  staticClass:
                    "panel-block is-flex is-flex-column has-padding-0",
                  staticStyle: { "align-items": "flex-start" }
                },
                [
                  _c(
                    "div",
                    {
                      staticClass:
                        "highlight-arrow w-100 has-padding-x-4 has-padding-top-4 has-padding-bottom-3 is-fullwidth cursor-pointer is-flex has-space-between",
                      on: {
                        click: function($event) {
                          _vm.getChallenges(challenge.id)
                          _vm.activeGroup = challenge
                        }
                      }
                    },
                    [
                      _c("span", { staticClass: "has-padding-2" }, [
                        _c("span", { staticClass: "panel-icon" }, [
                          _c("i", {
                            class: challenge.icon,
                            attrs: { "aria-hidden": "true" }
                          })
                        ]),
                        _vm._v(" "),
                        _c(
                          "span",
                          { attrs: { title: challenge.name } },
                          [
                            _vm._v(
                              "\n              " +
                                _vm._s(
                                  challenge.name.length > 30
                                    ? challenge.name.substring(0, 30) + "..."
                                    : challenge.name
                                ) +
                                "\n              "
                            ),
                            _c(
                              "b-tag",
                              {
                                staticClass: "has-small-font",
                                attrs: { type: "is-info is-light" }
                              },
                              [_vm._v(_vm._s(challenge.numChallenges))]
                            )
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _vm._m(0, true)
                    ]
                  ),
                  _vm._v(" "),
                  _vm._l(challenge.children, function(challengeChild) {
                    return _c(
                      "div",
                      {
                        key: challengeChild.id,
                        staticClass:
                          "highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer has-padding-left-5 has-padding-right-4 has-padding-y-3",
                        on: {
                          click: function($event) {
                            _vm.activeGroup = challengeChild
                            _vm.getChallenges(challengeChild.id)
                          }
                        }
                      },
                      [
                        _c("span", { staticClass: "has-padding-2" }, [
                          _c("span", { staticClass: "panel-icon" }, [
                            _c("i", {
                              class: challengeChild.icon,
                              attrs: { "aria-hidden": "true" }
                            })
                          ]),
                          _vm._v(" "),
                          _c(
                            "span",
                            { attrs: { title: challengeChild.name } },
                            [
                              _vm._v(
                                "\n              " +
                                  _vm._s(
                                    challengeChild.name.length > 30
                                      ? challengeChild.name.substring(0, 30) +
                                          "..."
                                      : challengeChild.name
                                  ) +
                                  "\n              "
                              ),
                              _c(
                                "small",
                                [
                                  _c(
                                    "b-tag",
                                    {
                                      staticClass: "has-small-font",
                                      attrs: { type: "is-info is-light" }
                                    },
                                    [
                                      _vm._v(
                                        _vm._s(challengeChild.numChallenges)
                                      )
                                    ]
                                  )
                                ],
                                1
                              )
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        _vm._m(1, true)
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
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "column has-padding-left-0-desktop" },
      [
        _c("b-loading", {
          attrs: {
            "is-full-page": _vm.isFullPage,
            active: _vm.isLoading,
            "can-cancel": true
          },
          on: {
            "update:active": function($event) {
              _vm.isLoading = $event
            }
          }
        }),
        _vm._v(" "),
        _vm.activeAddGroup
          ? _c("CreateChallengeGroup", { attrs: { code: _vm.code } })
          : _vm._e(),
        _vm._v(" "),
        !_vm.activeAddGroup && _vm.activeGroup && !_vm.isLoading
          ? _c("ShowChallenges", {
              attrs: {
                icon: _vm.icon,
                code: _vm.code,
                challengegroup: _vm.activeGroup,
                challenges: _vm.challenges
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
    return _c("span", { staticClass: "has-padding-2 arrow rounded-right" }, [
      _c("i", { staticClass: "fal fa-angle-right" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "has-padding-2 arrow rounded-right" }, [
      _c("i", { staticClass: "fal fa-angle-right" })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/challenges/ShowChallengesGroup.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallengesGroup.vue ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowChallengesGroup_vue_vue_type_template_id_570e1b04___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowChallengesGroup.vue?vue&type=template&id=570e1b04& */ "./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=template&id=570e1b04&");
/* harmony import */ var _ShowChallengesGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowChallengesGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowChallengesGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowChallengesGroup_vue_vue_type_template_id_570e1b04___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowChallengesGroup_vue_vue_type_template_id_570e1b04___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/challenges/ShowChallengesGroup.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallengesGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowChallengesGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallengesGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=template&id=570e1b04&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=template&id=570e1b04& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallengesGroup_vue_vue_type_template_id_570e1b04___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowChallengesGroup.vue?vue&type=template&id=570e1b04& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallengesGroup.vue?vue&type=template&id=570e1b04&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallengesGroup_vue_vue_type_template_id_570e1b04___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallengesGroup_vue_vue_type_template_id_570e1b04___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);