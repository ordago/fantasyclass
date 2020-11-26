(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestion.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/questions/ShowQuestion.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var canvas_confetti__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! canvas-confetti */ "./node_modules/canvas-confetti/dist/confetti.module.mjs");
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../utils.js */ "./resources/js/utils.js");
//
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
  props: ["code", "question"],
  created: function created() {},
  data: function data() {
    return {};
  },
  components: {},
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestions.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/questions/ShowQuestions.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowQuestion_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowQuestion.vue */ "./resources/js/components/questions/ShowQuestion.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
// import CreateChallenges from "./Createquestions.vue";

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["bank", "questions", "code"],
  created: function created() {},
  data: function data() {
    return {
      type: 0,
      question: {
        name: "",
        correctAnswer: null,
        incorrectAnswer1: null,
        incorrectAnswer2: null,
        incorrectAnswer3: null
      },
      question1: {
        name: null,
        answers: []
      },
      currentAnswer: "",
      currentCaseSensitive: true,
      addQuestion: false,
      search: "",
      importFlag: false,
      challengeEdit: null,
      isModalActive: false,
      isImportModalActive: false,
      isQuestionModalActive: false,
      students: null,
      groups: null,
      currentChallenge: null,
      mark: null
    };
  },
  methods: {
    sendQuestion: function sendQuestion() {
      var type = this.type + 1;
      var question;

      if (type == 1) {
        question = this.question;
      } else if (type == 2) {
        question = this.question1;
      }

      axios.post("/classroom/question/add", {
        type: type,
        bank: this.bank.id,
        question: question
      }).then(function (response) {
        console.log(response.data);
      });
    },
    addAnswer: function addAnswer() {
      if (this.currentAnswer != "") {
        this.question1.answers.push({
          answer: this.currentAnswer,
          caseSensitive: this.currentCaseSensitive
        });
        this.$forceUpdate();
      }

      this.currentAnswer = "";
      this.$forceUpdate();
    },
    deleteBank: function deleteBank(id) {
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
    toggleChallenge: function toggleChallenge(id) {
      axios.post("/classroom/" + this.code + "/challenges/toggle", {
        id: id,
        challenge: this.currentChallenge.id
      });
    },
    buttonAddChallege: function buttonAddChallege(type) {
      var append = type == 0 ? "<span class='ml-2'>" + this.trans.get("questions.add") + "</span>" : "";
      return this.addQuestion ? this.trans.get("general.cancel") : "<i class='far fa-plus'></i>" + append;
    }
  },
  components: {
    // CreateChallenges,
    ShowQuestion: _ShowQuestion_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  computed: {
    filteredList: function filteredList() {
      var _this3 = this;

      return this.orderedQuestions.filter(function (question) {
        return question.name.toLowerCase().includes(_this3.search.toLowerCase());
      });
    },
    orderedQuestions: function orderedQuestions() {
      return _.orderBy(this.questions, "datetime", "desc");
    }
  },
  updated: function updated() {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestion.vue?vue&type=template&id=29842da0&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/questions/ShowQuestion.vue?vue&type=template&id=29842da0& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "box card-shadow-s mb-3" }, [
    _c("h1", [_vm._v(_vm._s(_vm.question.name))]),
    _vm._v(" "),
    _vm.question.type == 1
      ? _c(
          "div",
          { staticClass: "mt-2" },
          _vm._l(_vm.question.options, function(option, index) {
            return _c("span", { key: index }, [
              option.answer
                ? _c(
                    "span",
                    {
                      staticClass: "tag p-2 mr-1",
                      class: {
                        "is-success":
                          option.answer.id ==
                          _vm.question.options[0].correctAnswer
                      }
                    },
                    [_vm._v(_vm._s(option.answer.text))]
                  )
                : _vm._e()
            ])
          }),
          0
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestions.vue?vue&type=template&id=ffaa441a&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/questions/ShowQuestions.vue?vue&type=template&id=ffaa441a& ***!
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
  return _c(
    "div",
    { staticClass: "pl-0" },
    [
      _c("div", { staticClass: "panel is-secondary pl-0" }, [
        _c(
          "p",
          {
            staticClass:
              "panel-heading is-flex has-space-between align-items-center p-3"
          },
          [
            _c("span", [
              _c("i", { staticClass: "fad fa-books" }),
              _vm._v(" "),
              _c("span", { staticClass: "pl-3" }, [
                _vm._v(_vm._s(_vm.bank.title))
              ]),
              _vm._v(" "),
              _vm.questions.length == 0
                ? _c(
                    "button",
                    {
                      staticClass: "button is-danger",
                      staticStyle: { "font-size": "0.5em" },
                      on: {
                        click: function($event) {
                          return _vm.deleteBank(_vm.bank.id)
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
                      _vm.isQuestionModalActive = true
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
        !_vm.addQuestion && _vm.questions.length > 0
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
        _vm.addQuestion ? _c("div", { staticClass: "panel-block" }) : _vm._e(),
        _vm._v(" "),
        _vm.questions.length == 0 && !_vm.addQuestion
          ? _c("div", { staticClass: "panel-block" }, [
              _c(
                "h3",
                { staticClass: "is-size-3 p-4 w-100 has-text-centered" },
                [
                  _c("i", { staticClass: "fal fa-smile-wink" }),
                  _vm._v(
                    "\n        " +
                      _vm._s(_vm.trans.get("questions.empty")) +
                      "\n      "
                  )
                ]
              )
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.questions.length > 0 && !_vm.addQuestion
          ? _c(
              "div",
              { staticClass: "panel-block is-block p-3" },
              _vm._l(_vm.filteredList, function(question) {
                return _c(
                  "div",
                  { key: question.id },
                  [
                    _c("ShowQuestion", {
                      attrs: { code: _vm.code, question: question }
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
          attrs: {
            active: _vm.isQuestionModalActive,
            "has-modal-card": "",
            "trap-focus": "",
            "destroy-on-hide": false,
            "aria-role": "dialog",
            "aria-modal": ""
          },
          on: {
            "update:active": function($event) {
              _vm.isQuestionModalActive = $event
            }
          }
        },
        [
          _c(
            "form",
            {
              on: {
                submit: function($event) {
                  $event.preventDefault()
                  return _vm.addQuestion($event)
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
                      _vm._v(
                        "\n            " +
                          _vm._s(_vm.trans.get("challenges.add_question")) +
                          "\n          "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "section",
                    { staticClass: "modal-card-body" },
                    [
                      _c(
                        "b-tabs",
                        {
                          attrs: { type: "is-toggle", expanded: "" },
                          model: {
                            value: _vm.type,
                            callback: function($$v) {
                              _vm.type = $$v
                            },
                            expression: "type"
                          }
                        },
                        [
                          _c(
                            "b-tab-item",
                            {
                              attrs: {
                                label: "Test",
                                "icon-pack": "fal",
                                icon: "list"
                              }
                            },
                            [
                              _c(
                                "div",
                                { staticClass: "py-3" },
                                [
                                  _c(
                                    "b-field",
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          placeholder: _vm.trans.get(
                                            "challenges.question"
                                          ),
                                          type: "text",
                                          required: ""
                                        },
                                        model: {
                                          value: _vm.question.name,
                                          callback: function($$v) {
                                            _vm.$set(_vm.question, "name", $$v)
                                          },
                                          expression: "question.name"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "field is-horizontal mb-3" },
                                    [
                                      _c("div", { staticClass: "field-body" }, [
                                        _c(
                                          "div",
                                          { staticClass: "field is-expanded" },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "field has-addons"
                                              },
                                              [
                                                _c(
                                                  "p",
                                                  { staticClass: "control" },
                                                  [
                                                    _c(
                                                      "a",
                                                      {
                                                        staticClass:
                                                          "button is-success"
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fas fa-check colored"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "p",
                                                  {
                                                    staticClass:
                                                      "control is-expanded"
                                                  },
                                                  [
                                                    _c(
                                                      "b-field",
                                                      [
                                                        _c("b-input", {
                                                          attrs: {
                                                            placeholder: _vm.trans.get(
                                                              "challenges.correct_answer"
                                                            ),
                                                            type: "text",
                                                            required: ""
                                                          },
                                                          model: {
                                                            value:
                                                              _vm.question
                                                                .correctAnswer,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                _vm.question,
                                                                "correctAnswer",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "question.correctAnswer"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  ],
                                                  1
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      ])
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "field is-horizontal mb-3" },
                                    [
                                      _c("div", { staticClass: "field-body" }, [
                                        _c(
                                          "div",
                                          { staticClass: "field is-expanded" },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "field has-addons"
                                              },
                                              [
                                                _c(
                                                  "p",
                                                  { staticClass: "control" },
                                                  [
                                                    _c(
                                                      "a",
                                                      {
                                                        staticClass:
                                                          "button is-danger"
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fas fa-times colored"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "p",
                                                  {
                                                    staticClass:
                                                      "control is-expanded"
                                                  },
                                                  [
                                                    _c(
                                                      "b-field",
                                                      [
                                                        _c("b-input", {
                                                          attrs: {
                                                            placeholder: _vm.trans.get(
                                                              "challenges.incorrect_answer"
                                                            ),
                                                            required: "",
                                                            type: "text"
                                                          },
                                                          model: {
                                                            value:
                                                              _vm.question
                                                                .incorrectAnswer1,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                _vm.question,
                                                                "incorrectAnswer1",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "question.incorrectAnswer1"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  ],
                                                  1
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      ])
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "field is-horizontal mb-3" },
                                    [
                                      _c("div", { staticClass: "field-body" }, [
                                        _c(
                                          "div",
                                          { staticClass: "field is-expanded" },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "field has-addons"
                                              },
                                              [
                                                _c(
                                                  "p",
                                                  { staticClass: "control" },
                                                  [
                                                    _c(
                                                      "a",
                                                      {
                                                        staticClass:
                                                          "button is-danger is-light"
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fas fa-times colored"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "p",
                                                  {
                                                    staticClass:
                                                      "control is-expanded"
                                                  },
                                                  [
                                                    _c(
                                                      "b-field",
                                                      [
                                                        _c("b-input", {
                                                          attrs: {
                                                            placeholder: _vm.trans.get(
                                                              "challenges.incorrect_answer"
                                                            ),
                                                            type: "text"
                                                          },
                                                          model: {
                                                            value:
                                                              _vm.question
                                                                .incorrectAnswer2,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                _vm.question,
                                                                "incorrectAnswer2",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "question.incorrectAnswer2"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  ],
                                                  1
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      ])
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "field is-horizontal mb-3" },
                                    [
                                      _c("div", { staticClass: "field-body" }, [
                                        _c(
                                          "div",
                                          { staticClass: "field is-expanded" },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "field has-addons"
                                              },
                                              [
                                                _c(
                                                  "p",
                                                  { staticClass: "control" },
                                                  [
                                                    _c(
                                                      "a",
                                                      {
                                                        staticClass:
                                                          "button is-danger is-light"
                                                      },
                                                      [
                                                        _c("i", {
                                                          staticClass:
                                                            "fas fa-times colored"
                                                        })
                                                      ]
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "p",
                                                  {
                                                    staticClass:
                                                      "control is-expanded"
                                                  },
                                                  [
                                                    _c(
                                                      "b-field",
                                                      [
                                                        _c("b-input", {
                                                          attrs: {
                                                            placeholder: _vm.trans.get(
                                                              "challenges.incorrect_answer"
                                                            ),
                                                            type: "text"
                                                          },
                                                          model: {
                                                            value:
                                                              _vm.question
                                                                .incorrectAnswer3,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                _vm.question,
                                                                "incorrectAnswer3",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "question.incorrectAnswer3"
                                                          }
                                                        })
                                                      ],
                                                      1
                                                    )
                                                  ],
                                                  1
                                                )
                                              ]
                                            )
                                          ]
                                        )
                                      ])
                                    ]
                                  )
                                ],
                                1
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "b-tab-item",
                            {
                              attrs: {
                                label: "Respuesta simple",
                                "icon-pack": "fal",
                                icon: "text"
                              }
                            },
                            [
                              _c(
                                "div",
                                { staticClass: "py-3" },
                                [
                                  _c(
                                    "b-field",
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          placeholder: _vm.trans.get(
                                            "challenges.question"
                                          ),
                                          type: "text",
                                          required: ""
                                        },
                                        model: {
                                          value: _vm.question1.name,
                                          callback: function($$v) {
                                            _vm.$set(_vm.question1, "name", $$v)
                                          },
                                          expression: "question1.name"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-field",
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          placeholder: _vm.trans.get(
                                            "challenges.answer"
                                          ),
                                          type: "text"
                                        },
                                        model: {
                                          value: _vm.currentAnswer,
                                          callback: function($$v) {
                                            _vm.currentAnswer = $$v
                                          },
                                          expression: "currentAnswer"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "field" },
                                    [
                                      _c(
                                        "b-checkbox",
                                        {
                                          model: {
                                            value: _vm.currentCaseSensitive,
                                            callback: function($$v) {
                                              _vm.currentCaseSensitive = $$v
                                            },
                                            expression: "currentCaseSensitive"
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                    Distinguir mayúsculas y minúsculas\n                  "
                                          )
                                        ]
                                      )
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "button",
                                    {
                                      staticClass: "button",
                                      on: {
                                        click: function($event) {
                                          $event.preventDefault()
                                          return _vm.addAnswer($event)
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                  Add answer\n                "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _vm._l(_vm.question1.answers, function(
                                    answer,
                                    index
                                  ) {
                                    return _c(
                                      "div",
                                      {
                                        key: index,
                                        staticClass: "p-2 m-2 border"
                                      },
                                      [
                                        _vm._v(
                                          "\n                  " +
                                            _vm._s(answer.answer) +
                                            "\n                "
                                        )
                                      ]
                                    )
                                  })
                                ],
                                2
                              )
                            ]
                          )
                        ],
                        1
                      )
                    ],
                    1
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
                            _vm.isQuestionModalActive = false
                          }
                        }
                      },
                      [
                        _vm._v(
                          "\n            " +
                            _vm._s(_vm.trans.get("general.close")) +
                            "\n          "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        staticClass: "button is-primary",
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.sendQuestion($event)
                          }
                        }
                      },
                      [
                        _vm._v(
                          "\n            " +
                            _vm._s(_vm.trans.get("general.add")) +
                            "\n          "
                        )
                      ]
                    )
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

/***/ "./resources/js/components/questions/ShowQuestion.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestion.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowQuestion_vue_vue_type_template_id_29842da0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowQuestion.vue?vue&type=template&id=29842da0& */ "./resources/js/components/questions/ShowQuestion.vue?vue&type=template&id=29842da0&");
/* harmony import */ var _ShowQuestion_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowQuestion.vue?vue&type=script&lang=js& */ "./resources/js/components/questions/ShowQuestion.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowQuestion_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowQuestion_vue_vue_type_template_id_29842da0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowQuestion_vue_vue_type_template_id_29842da0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/questions/ShowQuestion.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/questions/ShowQuestion.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestion.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestion.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestion.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/questions/ShowQuestion.vue?vue&type=template&id=29842da0&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestion.vue?vue&type=template&id=29842da0& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_template_id_29842da0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestion.vue?vue&type=template&id=29842da0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestion.vue?vue&type=template&id=29842da0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_template_id_29842da0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestion_vue_vue_type_template_id_29842da0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/questions/ShowQuestions.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestions.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowQuestions_vue_vue_type_template_id_ffaa441a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowQuestions.vue?vue&type=template&id=ffaa441a& */ "./resources/js/components/questions/ShowQuestions.vue?vue&type=template&id=ffaa441a&");
/* harmony import */ var _ShowQuestions_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowQuestions.vue?vue&type=script&lang=js& */ "./resources/js/components/questions/ShowQuestions.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowQuestions_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowQuestions_vue_vue_type_template_id_ffaa441a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowQuestions_vue_vue_type_template_id_ffaa441a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/questions/ShowQuestions.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/questions/ShowQuestions.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestions.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestions_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestions.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestions.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestions_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/questions/ShowQuestions.vue?vue&type=template&id=ffaa441a&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/questions/ShowQuestions.vue?vue&type=template&id=ffaa441a& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestions_vue_vue_type_template_id_ffaa441a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowQuestions.vue?vue&type=template&id=ffaa441a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/questions/ShowQuestions.vue?vue&type=template&id=ffaa441a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestions_vue_vue_type_template_id_ffaa441a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowQuestions_vue_vue_type_template_id_ffaa441a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);