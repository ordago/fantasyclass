(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallenge.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowChallenge.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["challenge", "edit", "admin", "code", "full"],
  created: function created() {
    this.challengeReactive = this.challenge;
  },
  data: function data() {
    return {
      challengeReactive: null,
      isAttachmentModalActive: false,
      isQuestionModalActive: false,
      attachment: {
        mode: "0",
        type: null,
        name: "",
        url: "",
        challenge_id: null
      },
      question: {
        challenge_id: null,
        question: '',
        correctAnswer: '',
        incorrectAnswer1: '',
        incorrectAnswer2: '',
        incorrectAnswer3: ''
      },
      comment: ""
    };
  },
  methods: {
    deleteComment: function deleteComment(id) {
      var _this = this;

      axios["delete"]("/classroom/challenge/comment/" + id).then(function (response) {
        var index = _this.challenge.comments.findIndex(function (comment, i) {
          return comment.id === id;
        });

        _this.challenge.comments.splice(index, 1);

        _this.$forceUpdate();
      });
    },
    sendComment: function sendComment() {
      var _this2 = this;

      this.comment = this.comment.replace("&nbsp;", " ");
      axios.post("/classroom/challenge/comment", {
        challenge_id: this.challenge.id,
        text: this.comment
      }).then(function (response) {
        _this2.challenge.comments.push(response.data);

        _this2.comment = "";
      });
    },
    confirmDelete: function confirmDelete(id, index) {
      var _this3 = this;

      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: function onConfirm() {
          axios["delete"]("/classroom/challenge/attachment/" + id).then(function (response) {
            console.log(response.data);

            if (response.data === 1) {
              _this3.challenge.attachments.splice(index, 1);

              _this3.$forceUpdate();
            }
          });
        }
      });
    },
    getYoutube: function getYoutube(url) {
      return _utils_js__WEBPACK_IMPORTED_MODULE_1__["default"].getYoutube(url);
    },
    addQuestion: function addQuestion() {
      var _this4 = this;

      this.question.challenge_id = this.challenge.id;
      axios.post("/classroom/challenge/question", {
        question: this.question
      }).then(function (response) {
        _this4.isQuestionModalActive = false; // this.challenge.questions.push(response.data);

        _this4.$parent().$forceUpdate();
      });
    },
    addAttachment: function addAttachment() {
      var _this5 = this;

      var type = this.attachment.type;
      if (type == 3 || type == 4 || type == 6 || type == 7 || type == 8) this.attachment.mode = 0;
      this.attachment.challenge_id = this.challenge.id;
      axios.post("/classroom/challenge/attachment", {
        attachment: this.attachment
      }).then(function (response) {
        _this5.isAttachmentModalActive = false;

        _this5.challenge.attachments.push(response.data);

        _this5.$parent().$forceUpdate();
      });
    },
    markCompleted: function markCompleted(challenge) {
      var _this6 = this;

      this.$buefy.dialog.confirm({
        title: "Class change",
        message: "Are you sure you have done all the the work? Trust is needed there.",
        confirmText: "Confirm done",
        type: "is-warning",
        iconPack: "fa",
        hasIcon: true,
        onConfirm: function onConfirm() {
          axios.post("/classroom/" + _this6.code + "/student/markchallenge", {
            challenge: _this6.challengeReactive.id
          }).then(function (response) {
            if (response.data.success == true) {
              Object(canvas_confetti__WEBPACK_IMPORTED_MODULE_0__["default"])({
                particleCount: 200,
                spread: 100,
                origin: {
                  y: 1.0
                }
              });
              _this6.challengeReactive.count++;
              _this6.$parent.$parent.$parent.student.hp = response.data.hp;
              _this6.$parent.$parent.$parent.student.xp = response.data.xp;
              _this6.$parent.$parent.$parent.student.gold = response.data.gold;
              _this6.$parent.$parent.$parent.forceReload++;
            }
          });
        }
      });
    }
  },
  computed: {
    orderedComments: function orderedComments() {
      return _.orderBy(this.challenge.comments, "created_at", "desc");
    },
    checkCompletion: function checkCompletion() {
      if (this.challengeReactive.completion == 1) return this.challengeReactive.count == 1;
      if (this.challengeReactive.completion == 2) return this.challengeReactive.count == 2;
    },
    getBackground: function getBackground() {
      if (this.full) {
        if (this.challengeReactive.is_conquer == 1) {
          return "has-background-conquer";
        } else {
          return "has-background-story";
        }
      } else if (this.edit) {
        return "";
      } else {
        switch (this.challengeReactive.completion) {
          case 0:
          case 1:
            return this.challengeReactive.count == 1 ? "has-background-success" : "has-background-danger";
            break;

          case 2:
            return this.challengeReactive.count == 2 ? "has-background-success" : "has-background-danger";
            break;
        }
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallenge.vue?vue&type=template&id=28f9fe32&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/ShowChallenge.vue?vue&type=template&id=28f9fe32& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "box card-shadow-s has-margin-bottom-3",
      class: _vm.getBackground
    },
    [
      _c("section", { staticClass: "media" }, [
        _c("div", { staticClass: "media-content" }, [
          _c(
            "div",
            { staticClass: "content" },
            [
              _c("h1", [
                _vm.challengeReactive.is_conquer && _vm.challengeReactive.icon
                  ? _c("i", {
                      staticClass: "is-size-4",
                      class: _vm.challengeReactive.icon + " colored",
                      style: "color:" + _vm.challengeReactive.color
                    })
                  : _vm._e(),
                _vm._v(" "),
                _vm.challengeReactive.type == 1
                  ? _c("i", { staticClass: "fas fa-users is-size-4 colored" })
                  : _vm._e(),
                _vm._v(
                  "\n          " +
                    _vm._s(_vm.challengeReactive.title) +
                    "\n          "
                ),
                _c("span", { staticClass: "tag is-light" }, [
                  _vm._v(_vm._s(_vm.challengeReactive.datetime))
                ])
              ]),
              _vm._v(" "),
              _c("p", [
                _c("small", [_vm._v(_vm._s(_vm.challengeReactive.description))])
              ]),
              _vm._v(" "),
              _vm.challengeReactive.is_conquer
                ? _c("p", [
                    _vm.challengeReactive.xp != 0
                      ? _c("small", [
                          _c("i", {
                            staticClass: "fas fa-fist-raised colored"
                          }),
                          _vm._v(
                            "\n            " +
                              _vm._s(_vm.challengeReactive.xp) +
                              "\n          "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.challengeReactive.hp != 0
                      ? _c("small", [
                          _c("i", { staticClass: "fas fa-heart colored" }),
                          _vm._v(
                            "\n            " +
                              _vm._s(_vm.challengeReactive.hp) +
                              "\n          "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.challengeReactive.gold != 0
                      ? _c("small", [
                          _c("i", { staticClass: "fas fa-coins colored" }),
                          _vm._v(
                            "\n            " +
                              _vm._s(_vm.challengeReactive.gold) +
                              "\n          "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.challengeReactive.cards != 0
                      ? _c("small", [
                          _c("i", { staticClass: "fas fa-club colored" }),
                          _vm._v(
                            "\n            " +
                              _vm._s(_vm.challengeReactive.cards) +
                              "\n          "
                          )
                        ])
                      : _vm._e()
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm.edit || _vm.full
                ? _c("div", {
                    domProps: {
                      innerHTML: _vm._s(_vm.challengeReactive.content)
                    }
                  })
                : _vm._e(),
              _vm._v(" "),
              _vm._l(_vm.challenge.questioninfo, function(question, index) {
                return _c(
                  "div",
                  { key: index },
                  [
                    _c("show-question", {
                      attrs: { admin: _vm.admin, question: question }
                    })
                  ],
                  1
                )
              }),
              _vm._v(" "),
              _vm._l(_vm.challenge.stats, function(question, index) {
                return _c(
                  "div",
                  { key: index },
                  [
                    _c("show-question", {
                      attrs: { admin: _vm.admin, question: question }
                    })
                  ],
                  1
                )
              }),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "has-margin-top-5" },
                _vm._l(_vm.challenge.attachments, function(attachment, index) {
                  return _c(
                    "div",
                    {
                      key: attachment.id,
                      staticClass:
                        "columns has-padding-4 has-margin-3 card rounded card-shadow-s"
                    },
                    [
                      _c("div", { staticClass: "column is-narrow" }, [
                        attachment.type == 1
                          ? _c("i", { staticClass: "fad fa-globe" })
                          : attachment.type == 2
                          ? _c("i", { staticClass: "fad fa-icons" })
                          : attachment.type == 3
                          ? _c("i", { staticClass: "fad fa-graduation-cap" })
                          : attachment.type == 4
                          ? _c("i", { staticClass: "fab fa-google-drive" })
                          : attachment.type == 5
                          ? _c("i", { staticClass: "fab fa-youtube" })
                          : attachment.type == 6
                          ? _c("i", { staticClass: "fab fa-dropbox" })
                          : attachment.type == 7
                          ? _c("i", { staticClass: "fad fa-file" })
                          : _vm._e(),
                        _vm._v(" "),
                        _c("i", {
                          staticClass: "fad has-margin-left-3",
                          class: {
                            "fa-link": attachment.mode == 0,
                            "fa-expand": attachment.mode == 1
                          }
                        })
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "column",
                          staticStyle: { "word-break": "break-all" }
                        },
                        [
                          attachment.mode == 0
                            ? _c(
                                "a",
                                {
                                  attrs: {
                                    target: "_blank",
                                    href: attachment.url
                                  }
                                },
                                [
                                  _vm._v(
                                    _vm._s(
                                      attachment.name
                                        ? attachment.name
                                        : attachment.url
                                    )
                                  )
                                ]
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          attachment.mode == 1
                            ? _c("div", { staticStyle: { width: "100%" } }, [
                                _c(
                                  "div",
                                  {
                                    staticStyle: {
                                      position: "relative",
                                      "padding-bottom": "46.57%",
                                      "padding-top": "0",
                                      height: "0"
                                    }
                                  },
                                  [
                                    attachment.type == 2
                                      ? _c("iframe", {
                                          staticClass: "rounded",
                                          staticStyle: {
                                            position: "absolute",
                                            top: "0",
                                            left: "0",
                                            width: "100%",
                                            height: "100%"
                                          },
                                          attrs: {
                                            frameborder: "0",
                                            width: "3000px",
                                            height: "1397px",
                                            src: attachment.url.slice(
                                              0,
                                              attachment.url.lastIndexOf("/")
                                            ),
                                            type: "text/html",
                                            allowscriptaccess: "always",
                                            allowfullscreen: "true",
                                            scrolling: "yes",
                                            allownetworking: "all"
                                          }
                                        })
                                      : _vm._e(),
                                    _vm._v(" "),
                                    attachment.type == 5
                                      ? _c(
                                          "div",
                                          { staticClass: "video-wrapper" },
                                          [
                                            _c("iframe", {
                                              attrs: {
                                                width: "560",
                                                height: "315",
                                                src:
                                                  "https://youtube.com/embed/" +
                                                  _vm.getYoutube(
                                                    attachment.url
                                                  ),
                                                frameborder: "0",
                                                allow:
                                                  "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture",
                                                allowfullscreen: ""
                                              }
                                            })
                                          ]
                                        )
                                      : _vm._e()
                                  ]
                                )
                              ])
                            : _vm._e()
                        ]
                      ),
                      _vm._v(" "),
                      _vm.admin
                        ? _c("div", { staticClass: "column is-narrow" }, [
                            _c(
                              "button",
                              {
                                staticClass: "button is-danger",
                                on: {
                                  click: function($event) {
                                    return _vm.confirmDelete(
                                      attachment.id,
                                      index
                                    )
                                  }
                                }
                              },
                              [_c("i", { staticClass: "fas fa-trash" })]
                            )
                          ])
                        : _vm._e()
                    ]
                  )
                }),
                0
              ),
              _vm._v(" "),
              _c("input-emoji"),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "has-margin-top-3 comments" },
                _vm._l(_vm.orderedComments, function(comment, index) {
                  return _c(
                    "div",
                    { key: index, staticClass: "comment has-margin-0" },
                    [
                      _c("div", { staticClass: "flexCenter imgTeacher" }, [
                        comment.info.type == "student"
                          ? _c("img", {
                              attrs: {
                                width: "32px",
                                height: "32px",
                                src: comment.info.avatar
                              }
                            })
                          : _vm._e(),
                        _vm._v(" "),
                        comment.info.type == "teacher"
                          ? _c("i", {
                              staticClass:
                                "fas fa-user-graduate text-light textshadow"
                            })
                          : _vm._e()
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "commentInfo has-padding-2" }, [
                        _c("div", [
                          _c(
                            "span",
                            { staticClass: "tag is-info has-padding-2" },
                            [_vm._v(_vm._s(comment.info.name))]
                          ),
                          _vm._v(" "),
                          _c(
                            "span",
                            { staticClass: "tag is-link has-padding-2" },
                            [_vm._v(_vm._s(comment.info.datetime))]
                          ),
                          _vm._v(" "),
                          _vm.admin
                            ? _c(
                                "button",
                                {
                                  staticClass:
                                    "button tag is-danger has-text-light has-padding-2",
                                  on: {
                                    click: function($event) {
                                      return _vm.deleteComment(
                                        comment.id,
                                        index
                                      )
                                    }
                                  }
                                },
                                [_c("i", { staticClass: "far fa-trash-alt" })]
                              )
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "flexVertical has-padding-2" },
                          [_vm._v(_vm._s(comment.text))]
                        )
                      ])
                    ]
                  )
                }),
                0
              ),
              _vm._v(" "),
              (_vm.edit && _vm.admin) || !_vm.admin
                ? _c("div", { staticClass: "has-padding-3 has-text-right" }, [
                    !_vm.admin &&
                    (_vm.challengeReactive.completion == 2 ||
                      _vm.challengeReactive.completion == 1) &&
                    !_vm.checkCompletion
                      ? _c(
                          "button",
                          {
                            staticClass: "button is-info",
                            on: {
                              click: function($event) {
                                return _vm.markCompleted(_vm.challenge)
                              }
                            }
                          },
                          [
                            _vm._m(0),
                            _vm._v(" "),
                            _c("span", [_vm._v("Mark as realised")])
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.admin
                      ? _c(
                          "button",
                          {
                            staticClass: "button is-outlined is-link",
                            on: {
                              click: function($event) {
                                _vm.isAttachmentModalActive = true
                              }
                            }
                          },
                          [
                            _vm._m(1),
                            _vm._v(" "),
                            _c("span", [_vm._v("Add attachment")])
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.admin
                      ? _c(
                          "button",
                          {
                            staticClass: "button is-outlined is-primary",
                            on: {
                              click: function($event) {
                                _vm.isQuestionModalActive = true
                              }
                            }
                          },
                          [
                            _vm._m(2),
                            _vm._v(" "),
                            _c("span", [_vm._v("Add question")])
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.challengeReactive.is_conquer && _vm.admin
                      ? _c(
                          "button",
                          {
                            staticClass: "button is-success is-outlined",
                            on: {
                              click: function($event) {
                                return _vm.$parent.showModal(_vm.challenge)
                              }
                            }
                          },
                          [_vm._m(3), _vm._v(" "), _c("span", [_vm._v("Mark")])]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.admin
                      ? _c(
                          "button",
                          {
                            staticClass: "button is-dark is-outlined",
                            on: {
                              click: function($event) {
                                _vm.$parent.challengeEdit = _vm.challenge
                                _vm.$parent.addChallenge = true
                              }
                            }
                          },
                          [_vm._m(4), _vm._v(" "), _c("span", [_vm._v("Edit")])]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.admin
                      ? _c(
                          "button",
                          {
                            staticClass: "button is-danger is-outlined",
                            on: {
                              click: function($event) {
                                return _vm.$parent.confirmDelete(
                                  _vm.challengeReactive.id
                                )
                              }
                            }
                          },
                          [
                            _vm._m(5),
                            _vm._v(" "),
                            _c("span", [_vm._v("Delete")])
                          ]
                        )
                      : _vm._e()
                  ])
                : _vm._e()
            ],
            2
          )
        ])
      ]),
      _vm._v(" "),
      _vm.admin
        ? _c(
            "b-modal",
            {
              attrs: {
                active: _vm.isAttachmentModalActive,
                "has-modal-card": "",
                "trap-focus": "",
                "destroy-on-hide": false,
                "aria-role": "dialog",
                "aria-modal": ""
              },
              on: {
                "update:active": function($event) {
                  _vm.isAttachmentModalActive = $event
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
                      return _vm.addAttachment($event)
                    }
                  }
                },
                [
                  _c(
                    "div",
                    {
                      staticClass: "modal-card",
                      staticStyle: { width: "auto" }
                    },
                    [
                      _c("header", { staticClass: "modal-card-head" }, [
                        _c("p", { staticClass: "modal-card-title" }, [
                          _vm._v("Add attachment")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "section",
                        { staticClass: "modal-card-body" },
                        [
                          _c(
                            "b-field",
                            [
                              _c(
                                "b-select",
                                {
                                  staticStyle: {
                                    "font-family": "Arial, FontAwesome"
                                  },
                                  attrs: {
                                    placeholder: "Attachment type",
                                    icon: "paperclip",
                                    "icon-pack": "fas",
                                    required: ""
                                  },
                                  model: {
                                    value: _vm.attachment.type,
                                    callback: function($$v) {
                                      _vm.$set(_vm.attachment, "type", $$v)
                                    },
                                    expression: "attachment.type"
                                  }
                                },
                                [
                                  _c(
                                    "option",
                                    {
                                      attrs: {
                                        value: "1",
                                        icon: "paperclip",
                                        "icon-pack": "fas"
                                      }
                                    },
                                    [_vm._v("Web page")]
                                  ),
                                  _vm._v(" "),
                                  _c("option", { attrs: { value: "2" } }, [
                                    _vm._v("Genial.ly")
                                  ]),
                                  _vm._v(" "),
                                  _c("option", { attrs: { value: "3" } }, [
                                    _vm._v("Moodle")
                                  ]),
                                  _vm._v(" "),
                                  _c("option", { attrs: { value: "4" } }, [
                                    _vm._v("Google drive")
                                  ]),
                                  _vm._v(" "),
                                  _c("option", { attrs: { value: "5" } }, [
                                    _vm._v("Youtube")
                                  ]),
                                  _vm._v(" "),
                                  _c("option", { attrs: { value: "6" } }, [
                                    _vm._v("Dropbox")
                                  ]),
                                  _vm._v(" "),
                                  _c("option", { attrs: { value: "7" } }, [
                                    _vm._v("File")
                                  ])
                                ]
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm.attachment.type == 1 ||
                          _vm.attachment.type == 2 ||
                          _vm.attachment.type == 5
                            ? _c(
                                "div",
                                [
                                  _c(
                                    "b-radio-button",
                                    {
                                      attrs: {
                                        "native-value": "0",
                                        type: "is-link"
                                      },
                                      model: {
                                        value: _vm.attachment.mode,
                                        callback: function($$v) {
                                          _vm.$set(_vm.attachment, "mode", $$v)
                                        },
                                        expression: "attachment.mode"
                                      }
                                    },
                                    [
                                      _c("b-icon", { attrs: { icon: "link" } }),
                                      _vm._v(" "),
                                      _c("span", [_vm._v("Link")])
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-radio-button",
                                    {
                                      attrs: {
                                        "native-value": "1",
                                        type: "is-link"
                                      },
                                      model: {
                                        value: _vm.attachment.mode,
                                        callback: function($$v) {
                                          _vm.$set(_vm.attachment, "mode", $$v)
                                        },
                                        expression: "attachment.mode"
                                      }
                                    },
                                    [
                                      _c("b-icon", {
                                        attrs: { icon: "expand" }
                                      }),
                                      _vm._v(" "),
                                      _c("span", [_vm._v("Embedded")])
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _c(
                            "b-field",
                            { staticClass: "has-margin-top-3" },
                            [
                              _c("b-input", {
                                attrs: { placeholder: "Name (Optional)" },
                                model: {
                                  value: _vm.attachment.name,
                                  callback: function($$v) {
                                    _vm.$set(_vm.attachment, "name", $$v)
                                  },
                                  expression: "attachment.name"
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
                                  placeholder: "URL",
                                  required: "",
                                  type: "url"
                                },
                                model: {
                                  value: _vm.attachment.url,
                                  callback: function($$v) {
                                    _vm.$set(_vm.attachment, "url", $$v)
                                  },
                                  expression: "attachment.url"
                                }
                              })
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
                                _vm.isAttachmentModalActive = false
                              }
                            }
                          },
                          [_vm._v("Close")]
                        ),
                        _vm._v(" "),
                        _c("button", { staticClass: "button is-primary" }, [
                          _vm._v("Add")
                        ])
                      ])
                    ]
                  )
                ]
              )
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.admin
        ? _c(
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
                    {
                      staticClass: "modal-card",
                      staticStyle: { width: "auto" }
                    },
                    [
                      _c("header", { staticClass: "modal-card-head" }, [
                        _c("p", { staticClass: "modal-card-title" }, [
                          _vm._v("Add question")
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "section",
                        { staticClass: "modal-card-body" },
                        [
                          _c(
                            "b-field",
                            [
                              _c("b-input", {
                                attrs: {
                                  placeholder: "Question",
                                  type: "text",
                                  required: ""
                                },
                                model: {
                                  value: _vm.question.question,
                                  callback: function($$v) {
                                    _vm.$set(_vm.question, "question", $$v)
                                  },
                                  expression: "question.question"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "field is-horizontal has-margin-bottom-3"
                            },
                            [
                              _c("div", { staticClass: "field-body" }, [
                                _c(
                                  "div",
                                  { staticClass: "field is-expanded" },
                                  [
                                    _c(
                                      "div",
                                      { staticClass: "field has-addons" },
                                      [
                                        _c("p", { staticClass: "control" }, [
                                          _c(
                                            "a",
                                            {
                                              staticClass: "button is-success"
                                            },
                                            [
                                              _c("i", {
                                                staticClass:
                                                  "fas fa-check colored"
                                              })
                                            ]
                                          )
                                        ]),
                                        _vm._v(" "),
                                        _c(
                                          "p",
                                          {
                                            staticClass: "control is-expanded"
                                          },
                                          [
                                            _c(
                                              "b-field",
                                              [
                                                _c("b-input", {
                                                  attrs: {
                                                    placeholder:
                                                      "Correct answer",
                                                    type: "text",
                                                    required: ""
                                                  },
                                                  model: {
                                                    value:
                                                      _vm.question
                                                        .correctAnswer,
                                                    callback: function($$v) {
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
                            {
                              staticClass:
                                "field is-horizontal has-margin-bottom-3"
                            },
                            [
                              _c("div", { staticClass: "field-body" }, [
                                _c(
                                  "div",
                                  { staticClass: "field is-expanded" },
                                  [
                                    _c(
                                      "div",
                                      { staticClass: "field has-addons" },
                                      [
                                        _c("p", { staticClass: "control" }, [
                                          _c(
                                            "a",
                                            { staticClass: "button is-danger" },
                                            [
                                              _c("i", {
                                                staticClass:
                                                  "fas fa-times colored"
                                              })
                                            ]
                                          )
                                        ]),
                                        _vm._v(" "),
                                        _c(
                                          "p",
                                          {
                                            staticClass: "control is-expanded"
                                          },
                                          [
                                            _c(
                                              "b-field",
                                              [
                                                _c("b-input", {
                                                  attrs: {
                                                    placeholder:
                                                      "Inorrect answer",
                                                    required: "",
                                                    type: "text"
                                                  },
                                                  model: {
                                                    value:
                                                      _vm.question
                                                        .incorrectAnswer1,
                                                    callback: function($$v) {
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
                            {
                              staticClass:
                                "field is-horizontal has-margin-bottom-3"
                            },
                            [
                              _c("div", { staticClass: "field-body" }, [
                                _c(
                                  "div",
                                  { staticClass: "field is-expanded" },
                                  [
                                    _c(
                                      "div",
                                      { staticClass: "field has-addons" },
                                      [
                                        _c("p", { staticClass: "control" }, [
                                          _c(
                                            "a",
                                            { staticClass: "button is-danger" },
                                            [
                                              _c("i", {
                                                staticClass:
                                                  "fas fa-times colored"
                                              })
                                            ]
                                          )
                                        ]),
                                        _vm._v(" "),
                                        _c(
                                          "p",
                                          {
                                            staticClass: "control is-expanded"
                                          },
                                          [
                                            _c(
                                              "b-field",
                                              [
                                                _c("b-input", {
                                                  attrs: {
                                                    placeholder:
                                                      "Inorrect answer",
                                                    type: "text"
                                                  },
                                                  model: {
                                                    value:
                                                      _vm.question
                                                        .incorrectAnswer2,
                                                    callback: function($$v) {
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
                            {
                              staticClass:
                                "field is-horizontal has-margin-bottom-3"
                            },
                            [
                              _c("div", { staticClass: "field-body" }, [
                                _c(
                                  "div",
                                  { staticClass: "field is-expanded" },
                                  [
                                    _c(
                                      "div",
                                      { staticClass: "field has-addons" },
                                      [
                                        _c("p", { staticClass: "control" }, [
                                          _c(
                                            "a",
                                            { staticClass: "button is-danger" },
                                            [
                                              _c("i", {
                                                staticClass:
                                                  "fas fa-times colored"
                                              })
                                            ]
                                          )
                                        ]),
                                        _vm._v(" "),
                                        _c(
                                          "p",
                                          {
                                            staticClass: "control is-expanded"
                                          },
                                          [
                                            _c(
                                              "b-field",
                                              [
                                                _c("b-input", {
                                                  attrs: {
                                                    placeholder:
                                                      "Inorrect answer",
                                                    type: "text"
                                                  },
                                                  model: {
                                                    value:
                                                      _vm.question
                                                        .incorrectAnswer3,
                                                    callback: function($$v) {
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
                                _vm.isAttachmentModalActive = false
                              }
                            }
                          },
                          [_vm._v("Close")]
                        ),
                        _vm._v(" "),
                        _c("button", { staticClass: "button is-primary" }, [
                          _vm._v("Add")
                        ])
                      ])
                    ]
                  )
                ]
              )
            ]
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "icon is-small" }, [
      _c("i", { staticClass: "fas fa-check" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "icon is-small" }, [
      _c("i", { staticClass: "fas fa-paperclip" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "icon is-small" }, [
      _c("i", { staticClass: "fas fa-question" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "icon is-small" }, [
      _c("i", { staticClass: "fas fa-check" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "icon is-small" }, [
      _c("i", { staticClass: "fas fa-edit" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "icon is-small" }, [
      _c("i", { staticClass: "fas fa-trash-alt" })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/challenges/ShowChallenge.vue":
/*!**************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallenge.vue ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowChallenge_vue_vue_type_template_id_28f9fe32___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowChallenge.vue?vue&type=template&id=28f9fe32& */ "./resources/js/components/challenges/ShowChallenge.vue?vue&type=template&id=28f9fe32&");
/* harmony import */ var _ShowChallenge_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowChallenge.vue?vue&type=script&lang=js& */ "./resources/js/components/challenges/ShowChallenge.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowChallenge_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowChallenge_vue_vue_type_template_id_28f9fe32___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowChallenge_vue_vue_type_template_id_28f9fe32___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/challenges/ShowChallenge.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/challenges/ShowChallenge.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallenge.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenge_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowChallenge.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallenge.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenge_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/challenges/ShowChallenge.vue?vue&type=template&id=28f9fe32&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/challenges/ShowChallenge.vue?vue&type=template&id=28f9fe32& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenge_vue_vue_type_template_id_28f9fe32___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowChallenge.vue?vue&type=template&id=28f9fe32& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/ShowChallenge.vue?vue&type=template&id=28f9fe32&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenge_vue_vue_type_template_id_28f9fe32___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowChallenge_vue_vue_type_template_id_28f9fe32___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);