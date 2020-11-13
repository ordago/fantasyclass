(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[4],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallenges.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowChallenges.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateChallenges_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateChallenges.vue */ "./resources/js/components/challenges/CreateChallenges.vue");
/* harmony import */ var _ShowChallenge_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowChallenge.vue */ "./resources/js/components/challenges/ShowChallenge.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["challengegroup", "challenges", "code", "icon"],
  created: function created() {},
  data: function data() {
    return {
      addChallenge: false,
      search: "",
      importFlag: false,
      challengeEdit: null,
      isModalActive: false,
      isImportModalActive: false,
      students: null,
      groups: null,
      currentChallenge: null,
      mark: null
    };
  },
  methods: {
    deleteChallengeGroup: function deleteChallengeGroup(id) {
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
          axios["delete"]("/classroom/challenges/group/" + id).then(function (response) {
            location.reload();
          });
        }
      });
    },
    confirmDelete: function confirmDelete(id) {
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
          axios["delete"]("/classroom/challenges/" + id).then(function (response) {
            if (response.data === 1) {
              _this.$parent.getChallenges(_this.challengegroup.id);
            }
          });
        }
      });
    },
    showModal: function showModal(challenge) {
      var _this2 = this;

      this.currentChallenge = challenge;
      axios.post("/classroom/" + this.code + "/challenges/info", {
        type: challenge.type,
        challenge: challenge.id
      }).then(function (response) {
        if (challenge.type == 0) _this2.students = response.data;else _this2.groups = response.data;
        _this2.isModalActive = true;
      });
    },
    toggleChallenge: function toggleChallenge($id) {
      axios.post("/classroom/" + this.code + "/challenges/toggle", {
        id: $id,
        challenge: this.currentChallenge.id
      });
    },
    buttonAddChallege: function buttonAddChallege(type) {
      var append = type == 0 ? "<span class='ml-2'>" + this.trans.get("challenges.add") + "</span>" : "";
      return this.addChallenge ? this.trans.get("general.cancel") : "<i class='far fa-plus'></i>" + append;
    }
  },
  components: {
    CreateChallenges: _CreateChallenges_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    ShowChallenge: _ShowChallenge_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  computed: {
    filteredList: function filteredList() {
      var _this3 = this;

      return this.orderedChallenges.filter(function (challenge) {
        return challenge.title.toLowerCase().includes(_this3.search.toLowerCase());
      });
    },
    orderedChallenges: function orderedChallenges() {
      return _.orderBy(this.challenges, "datetime", "desc");
    }
  },
  updated: function updated() {// this.$refs.topref.scrollTop=0;
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallenges.vue?vue&type=template&id=0c1d2d9e&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowChallenges.vue?vue&type=template&id=0c1d2d9e& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
    { ref: "topref", staticClass: "pl-0" },
    [
      _c("div", { staticClass: "panel is-primary pl-0" }, [
        _c(
          "p",
          {
            staticClass:
              "panel-heading is-flex has-space-between align-items-center p-3"
          },
          [
            _c("span", [
              _c("i", { class: _vm.challengegroup.icon }),
              _vm._v(" "),
              _c("span", { staticClass: "pl-3" }, [
                _vm._v(_vm._s(_vm.challengegroup.name))
              ]),
              _vm._v(" "),
              _vm.challenges.length == 0
                ? _c(
                    "button",
                    {
                      staticClass: "button is-danger",
                      staticStyle: { "font-size": "0.5em" },
                      on: {
                        click: function($event) {
                          return _vm.deleteChallengeGroup(_vm.challengegroup.id)
                        }
                      }
                    },
                    [_c("i", { staticClass: "fas fa-trash" })]
                  )
                : _vm._e()
            ]),
            _vm._v(" "),
            _c("span", [
              _c(
                "button",
                {
                  staticClass: "button",
                  on: {
                    click: function($event) {
                      _vm.isImportModalActive = true
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fas fa-file-import" }),
                  _vm._v(" "),
                  _c("span", { staticClass: "is-hidden-mobile ml-2" }, [
                    _vm._v(_vm._s(_vm.trans.get("general.import")))
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "button",
                  on: {
                    click: function($event) {
                      _vm.challengeEdit = null
                      _vm.addChallenge = !_vm.addChallenge
                    }
                  }
                },
                [
                  _c("span", {
                    staticClass: "is-hidden-tablet",
                    domProps: { innerHTML: _vm._s(_vm.buttonAddChallege(1)) }
                  }),
                  _vm._v(" "),
                  _c("span", {
                    staticClass: "is-hidden-mobile",
                    domProps: { innerHTML: _vm._s(_vm.buttonAddChallege(0)) }
                  })
                ]
              )
            ])
          ]
        ),
        _vm._v(" "),
        !_vm.addChallenge && _vm.challenges.length > 0
          ? _c("div", { staticClass: "panel-block" }, [
              _c("p", { staticClass: "control has-icons-left" }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.search,
                      expression: "search"
                    }
                  ],
                  staticClass: "input",
                  attrs: { type: "text", placeholder: "Search" },
                  domProps: { value: _vm.search },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.search = $event.target.value
                    }
                  }
                }),
                _vm._v(" "),
                _vm._m(0)
              ])
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.addChallenge
          ? _c(
              "div",
              { staticClass: "panel-block" },
              [
                _c("CreateChallenges", {
                  attrs: {
                    edit: _vm.challengeEdit,
                    "import-flag": _vm.importFlag,
                    iconPrev: _vm.icon,
                    challengegroups: _vm.$parent.challengesgroup,
                    code: _vm.code,
                    challengegroup: _vm.challengegroup.id,
                    "students-loaded": _vm.students
                  }
                })
              ],
              1
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.challenges.length == 0 && !_vm.addChallenge
          ? _c("div", { staticClass: "panel-block" }, [
              _c(
                "h3",
                { staticClass: "is-size-3 p-4 w-100 has-text-centered" },
                [
                  _c("i", { staticClass: "fal fa-smile-wink" }),
                  _vm._v(
                    "\n        " +
                      _vm._s(_vm.trans.get("challenges.empty")) +
                      "\n      "
                  )
                ]
              )
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.challenges.length > 0 && !_vm.addChallenge
          ? _c(
              "div",
              { staticClass: "panel-block is-block p-3" },
              _vm._l(_vm.filteredList, function(challenge) {
                return _c(
                  "div",
                  { key: challenge.id },
                  [
                    _c("ShowChallenge", {
                      attrs: {
                        code: _vm.code,
                        challenge: challenge,
                        admin: true,
                        edit: true,
                        students: _vm.students
                      }
                    })
                  ],
                  1
                )
              }),
              0
            )
          : _vm._e()
      ]),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: { active: _vm.isModalActive, width: "95%", scroll: "keep" },
          on: {
            "update:active": function($event) {
              _vm.isModalActive = $event
            }
          }
        },
        [
          _vm.currentChallenge
            ? _c("div", { staticClass: "p-5 rounded has-background-light" }, [
                _c("h1", { staticClass: "is-size-1 mb-3" }, [
                  _vm._v(
                    "\n        " +
                      _vm._s(_vm.currentChallenge.title) +
                      "\n      "
                  )
                ]),
                _vm._v(" "),
                _vm.currentChallenge.type == 0
                  ? _c(
                      "div",
                      _vm._l(_vm.students, function(student) {
                        return _c(
                          "div",
                          { key: student.id, staticClass: "p-3" },
                          [
                            _c("div", { staticClass: "columns" }, [
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "column is-narrow is-flex has-all-centered"
                                },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "field" },
                                    [
                                      student.challenges
                                        ? _c(
                                            "b-switch",
                                            {
                                              attrs: {
                                                value: student.challenges.length
                                                  ? 1
                                                  : 0,
                                                "true-value": "1",
                                                "false-value": "0",
                                                type: "is-info"
                                              },
                                              on: {
                                                input: function($event) {
                                                  return _vm.toggleChallenge(
                                                    student.id
                                                  )
                                                }
                                              }
                                            },
                                            [_vm._v(_vm._s(student.name))]
                                          )
                                        : _vm._e()
                                    ],
                                    1
                                  )
                                ]
                              )
                            ])
                          ]
                        )
                      }),
                      0
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.currentChallenge.type == 1
                  ? _c(
                      "div",
                      _vm._l(_vm.groups, function(group) {
                        return _c(
                          "div",
                          { key: group.id, staticClass: "p-3" },
                          [
                            _c("div", { staticClass: "columns" }, [
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "column is-narrow is-flex has-all-centered"
                                },
                                [
                                  _c(
                                    "div",
                                    { staticClass: "field" },
                                    [
                                      _c(
                                        "b-switch",
                                        {
                                          attrs: {
                                            value: group.challenges.length
                                              ? 1
                                              : 0,
                                            "true-value": "1",
                                            "false-value": "0",
                                            type: "is-info"
                                          },
                                          on: {
                                            input: function($event) {
                                              return _vm.toggleChallenge(
                                                group.id
                                              )
                                            }
                                          }
                                        },
                                        [_vm._v(_vm._s(group.name))]
                                      )
                                    ],
                                    1
                                  )
                                ]
                              )
                            ])
                          ]
                        )
                      }),
                      0
                    )
                  : _vm._e()
              ])
            : _vm._e()
        ]
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            active: _vm.isImportModalActive,
            "has-modal-card": "",
            "full-screen": ""
          },
          on: {
            "update:active": function($event) {
              _vm.isImportModalActive = $event
            }
          }
        },
        [
          _c("import-challenge", {
            attrs: {
              classroom: _vm.code,
              challengegroup: _vm.challengegroup.id
            }
          })
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "icon is-left" }, [
      _c("i", {
        staticClass: "fas fa-search",
        attrs: { "aria-hidden": "true" }
      })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/challenges/ShowChallenges.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallenges.vue ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowChallenges_vue_vue_type_template_id_0c1d2d9e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowChallenges.vue?vue&type=template&id=0c1d2d9e& */ "./resources/js/components/challenges/ShowChallenges.vue?vue&type=template&id=0c1d2d9e&");
/* harmony import */ var _ShowChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowChallenges.vue?vue&type=script&lang=js& */ "./resources/js/components/challenges/ShowChallenges.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowChallenges_vue_vue_type_template_id_0c1d2d9e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowChallenges_vue_vue_type_template_id_0c1d2d9e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/challenges/ShowChallenges.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/challenges/ShowChallenges.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallenges.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowChallenges.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallenges.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/challenges/ShowChallenges.vue?vue&type=template&id=0c1d2d9e&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallenges.vue?vue&type=template&id=0c1d2d9e& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenges_vue_vue_type_template_id_0c1d2d9e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowChallenges.vue?vue&type=template&id=0c1d2d9e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallenges.vue?vue&type=template&id=0c1d2d9e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenges_vue_vue_type_template_id_0c1d2d9e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenges_vue_vue_type_template_id_0c1d2d9e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);