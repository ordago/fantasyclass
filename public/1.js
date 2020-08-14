(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/CreateChallenges.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/CreateChallenges.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_Editor_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/Editor.vue */ "./resources/js/components/utils/Editor.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["challengegroup", "code", "iconPrev", "edit", "groups"],
  mounted: function mounted() {
    if (this.edit) {
      this.challenge = this.edit;
      this.icon = this.challenge.icon;
      this.content = this.edit.content;
      this.datepicker = new Date(this.edit.datetime);
    } else {
      this.icon = this.iconPrev.icon;
      this.challenge.color = this.iconPrev.color;
      this.datepicker = new Date();
    }
  },
  data: function data() {
    return {
      content: "",
      datepicker: null,
      icon: null,
      challenge: {
        icon: null,
        color: null,
        datetime: null,
        description: null,
        title: null,
        content: "",
        is_conquer: 0,
        completion: 0,
        xp: 0,
        hp: 0,
        gold: 0,
        cards: 0,
        auto_assign: 0,
        optional: 0,
        type: 0,
        password: null,
        challenges_group_id: null,
        _method: "post"
      }
    };
  },
  methods: {
    createChallenge: function createChallenge() {
      var _this = this;

      this.challenge.content = this.content;
      this.challenge.icon = this.icon;
      this.challenge.challenges_group_id = this.challengegroup;
      var date = this.datepicker;
      this.challenge.datetime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes();
      var route;

      if (this.edit) {
        this.challenge._method = "patch";
        route = "/classroom/" + this.code + "/challenges/" + this.challenge.id;
      } else {
        route = "/classroom/" + this.code + "/challenges";
      }

      axios.post(route, this.challenge).then(function (response) {
        _this.$toasted.show(response.data.message, {
          position: "top-center",
          duration: 3000,
          iconPack: "fontawesome",
          icon: response.data.icon,
          type: response.data.type
        });

        if (response.data.type == "success") {
          _this.$parent.addChallenge = false;

          _this.$parent.$parent.getChallenges(_this.challenge.challenges_group_id);
        }
      });
      this.$parent.$parent.$forceUpdate();
    },
    dateFormatter: function dateFormatter(dt) {
      return dt.toLocaleDateString("es-ES", dateoptions);
    }
  },
  components: {
    Editor: _utils_Editor_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Editor.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Editor.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! element-ui */ "./node_modules/element-ui/lib/element-ui.common.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(element_ui__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var element_tiptap__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! element-tiptap */ "./node_modules/element-tiptap/lib/element-tiptap.esm.js");
/* harmony import */ var element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! element-ui/lib/theme-chalk/index.css */ "./node_modules/element-ui/lib/theme-chalk/index.css");
/* harmony import */ var element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(element_ui_lib_theme_chalk_index_css__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var element_tiptap_lib_index_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! element-tiptap/lib/index.css */ "./node_modules/element-tiptap/lib/index.css");
/* harmony import */ var element_tiptap_lib_index_css__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(element_tiptap_lib_index_css__WEBPACK_IMPORTED_MODULE_4__);
//
//
//
//
//
//
//
//


 // import ElementUI's styles

 // import this package's styles

 // use ElementUI's plugin

vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(element_ui__WEBPACK_IMPORTED_MODULE_1___default.a); // use this package's plugin

vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(element_tiptap__WEBPACK_IMPORTED_MODULE_2__["ElementTiptapPlugin"], {
  /* plugin options */
}); // Now you register `'el-tiptap'` component globally.


/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["code"],
  created: function created() {},
  data: function data() {
    return {
      extensions: [new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Doc"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Text"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["History"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Paragraph"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Heading"]({
        level: 5
      }), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Bold"](), // render command-button in bubble menu.
      new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Underline"](), // render command-button in bubble menu but not in menubar.
      new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Italic"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Strike"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["ListItem"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["BulletList"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["OrderedList"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Link"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Image"]({
        uploadRequest: function uploadRequest(file) {
          var formData = new FormData();
          formData.append("file", file);
          var request = axios.post("/classroom/challenges/image", formData);
          return request.then(function (result) {
            return result.data;
          });
        }
      }), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["CodeBlock"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Blockquote"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TextAlign"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Indent"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["LineHeight"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["HorizontalRule"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Table"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TableHeader"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TableCell"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TableRow"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["FontType"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["FontSize"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TextColor"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["TextHighlight"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["FormatClear"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Print"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Fullscreen"](), new element_tiptap__WEBPACK_IMPORTED_MODULE_2__["Preview"]()]
    };
  },
  methods: {
    sendImage: function sendImage() {
      console.log("hit");
    }
  },
  components: {
    ElementUI: element_ui__WEBPACK_IMPORTED_MODULE_1___default.a,
    ElementTiptapPlugin: element_tiptap__WEBPACK_IMPORTED_MODULE_2__["ElementTiptapPlugin"]
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/CreateChallenges.vue?vue&type=template&id=58fd01f0&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/challenges/CreateChallenges.vue?vue&type=template&id=58fd01f0& ***!
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
  return _c("div", { staticClass: "w-100" }, [
    _c(
      "form",
      {
        attrs: { action: "#", method: "post" },
        on: {
          submit: function($event) {
            $event.preventDefault()
            return _vm.createChallenge($event)
          }
        }
      },
      [
        _c("div", { staticClass: "field w-100" }, [
          _c("label", { staticClass: "label" }, [_vm._v("Title *")]),
          _vm._v(" "),
          _c("div", { staticClass: "control" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.challenge.title,
                  expression: "challenge.title"
                }
              ],
              staticClass: "input",
              attrs: { type: "text", required: "", placeholder: "" },
              domProps: { value: _vm.challenge.title },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.challenge, "title", $event.target.value)
                }
              }
            })
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "field w-100" }, [
          _c("label", { staticClass: "label" }, [_vm._v("Description")]),
          _vm._v(" "),
          _c("div", { staticClass: "control" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.challenge.description,
                  expression: "challenge.description"
                }
              ],
              staticClass: "input",
              attrs: {
                type: "text",
                placeholder: "This is real world info. E.g. Trigonometry test"
              },
              domProps: { value: _vm.challenge.description },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.challenge, "description", $event.target.value)
                }
              }
            })
          ])
        ]),
        _vm._v(" "),
        _c(
          "b-field",
          { attrs: { label: "Password" } },
          [
            _c("b-input", {
              attrs: {
                type: "password",
                "icon-pack": "fas",
                placeholder: "Don't abuse of this :D",
                "password-reveal": ""
              },
              model: {
                value: _vm.challenge.password,
                callback: function($$v) {
                  _vm.$set(_vm.challenge, "password", $$v)
                },
                expression: "challenge.password"
              }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "w-100" },
          [
            _c(
              "b-field",
              { attrs: { label: "When it will be visible?" } },
              [
                _c(
                  "b-datetimepicker",
                  {
                    attrs: {
                      placeholder: "Click to select...",
                      "icon-pack": "fa"
                    },
                    model: {
                      value: _vm.datepicker,
                      callback: function($$v) {
                        _vm.datepicker = $$v
                      },
                      expression: "datepicker"
                    }
                  },
                  [
                    _c("template", { slot: "left" }, [
                      _c(
                        "button",
                        {
                          staticClass: "button is-primary",
                          on: {
                            click: function($event) {
                              _vm.datetime = new Date()
                            }
                          }
                        },
                        [
                          _c("b-icon", { attrs: { icon: "clock" } }),
                          _vm._v(" "),
                          _c("span", [_vm._v("Now")])
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("template", { slot: "right" }, [
                      _c(
                        "button",
                        {
                          staticClass: "button is-danger",
                          on: {
                            click: function($event) {
                              _vm.datetime = null
                            }
                          }
                        },
                        [
                          _c("b-icon", { attrs: { icon: "close" } }),
                          _vm._v(" "),
                          _c("span", [_vm._v("Clear")])
                        ],
                        1
                      )
                    ])
                  ],
                  2
                )
              ],
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c("div", { staticClass: "field w-100 has-padding-top-3" }, [
          _c("label", { staticClass: "label" }, [_vm._v("Content")]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "control content", attrs: { "data-app": "" } },
            [_c("editor", { attrs: { code: _vm.code } })],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "field" },
          [
            _c(
              "b-switch",
              {
                attrs: {
                  type: "is-info",
                  "true-value": "1",
                  "false-value": "0"
                },
                model: {
                  value: _vm.challenge.is_conquer,
                  callback: function($$v) {
                    _vm.$set(_vm.challenge, "is_conquer", $$v)
                  },
                  expression: "challenge.is_conquer"
                }
              },
              [_vm._v("Is a conquer challenge?")]
            )
          ],
          1
        ),
        _vm._v(" "),
        _vm.challenge.is_conquer == 1
          ? _c("div", { staticClass: "has-padding-4 has-border rounded" }, [
              _c("div", { staticClass: "field w-100 has-padding-top-3" }, [
                _c("label", { staticClass: "label" }, [_vm._v("Icon")]),
                _vm._v(" "),
                _c("div", { staticClass: "field has-addons" }, [
                  _c("p", { staticClass: "control" }, [_c("icon-selector")], 1),
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
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "control" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.challenge.color,
                          expression: "challenge.color"
                        }
                      ],
                      staticClass: "input",
                      staticStyle: { padding: "0", "min-width": "50px" },
                      attrs: { name: "color", type: "color" },
                      domProps: { value: _vm.challenge.color },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.challenge, "color", $event.target.value)
                        }
                      }
                    })
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("label", { staticClass: "label" }, [_vm._v("Rewards")]),
              _vm._v(" "),
              _c("div", { staticClass: "columns" }, [
                _c("div", { staticClass: "column" }, [
                  _c("div", { staticClass: "field has-addons" }, [
                    _vm._m(0),
                    _vm._v(" "),
                    _c("p", { staticClass: "control is-expanded" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.challenge.xp,
                            expression: "challenge.xp"
                          }
                        ],
                        staticClass: "input",
                        attrs: { type: "number", name: "xp", required: "" },
                        domProps: { value: _vm.challenge.xp },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.challenge, "xp", $event.target.value)
                          }
                        }
                      })
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "column" }, [
                  _c("div", { staticClass: "field has-addons" }, [
                    _vm._m(1),
                    _vm._v(" "),
                    _c("p", { staticClass: "control is-expanded" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.challenge.hp,
                            expression: "challenge.hp"
                          }
                        ],
                        staticClass: "input",
                        attrs: { type: "number", name: "hp", required: "" },
                        domProps: { value: _vm.challenge.hp },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.challenge, "hp", $event.target.value)
                          }
                        }
                      })
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "columns" }, [
                _c("div", { staticClass: "column" }, [
                  _c("div", { staticClass: "field has-addons" }, [
                    _vm._m(2),
                    _vm._v(" "),
                    _c("p", { staticClass: "control is-expanded" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.challenge.gold,
                            expression: "challenge.gold"
                          }
                        ],
                        staticClass: "input",
                        attrs: { type: "number", name: "gold", required: "" },
                        domProps: { value: _vm.challenge.gold },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(_vm.challenge, "gold", $event.target.value)
                          }
                        }
                      })
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "column" }, [
                  _c("div", { staticClass: "field has-addons" }, [
                    _vm._m(3),
                    _vm._v(" "),
                    _c("p", { staticClass: "control is-expanded" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.challenge.cards,
                            expression: "challenge.cards"
                          }
                        ],
                        staticClass: "input",
                        attrs: { type: "number", name: "cards", required: "" },
                        domProps: { value: _vm.challenge.cards },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.challenge,
                              "cards",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ])
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm.challenge.type == 0
                ? _c("div", { staticClass: "has-margin-top-3" }, [
                    _c("label", { attrs: { for: "name" } }, [
                      _vm._v(_vm._s(_vm.trans.get("challenges.completion")))
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "field has-margin-top-3" }, [
                      _c("div", { staticClass: "control" }, [
                        _c("div", { staticClass: "select is-fullwidth" }, [
                          _c(
                            "select",
                            {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.challenge.completion,
                                  expression: "challenge.completion"
                                }
                              ],
                              on: {
                                change: function($event) {
                                  var $$selectedVal = Array.prototype.filter
                                    .call($event.target.options, function(o) {
                                      return o.selected
                                    })
                                    .map(function(o) {
                                      var val =
                                        "_value" in o ? o._value : o.value
                                      return val
                                    })
                                  _vm.$set(
                                    _vm.challenge,
                                    "completion",
                                    $event.target.multiple
                                      ? $$selectedVal
                                      : $$selectedVal[0]
                                  )
                                }
                              }
                            },
                            [
                              _c("option", { attrs: { value: "0" } }, [
                                _vm._v(
                                  _vm._s(
                                    _vm.trans.get(
                                      "challenges.completion_teacher"
                                    )
                                  )
                                )
                              ]),
                              _vm._v(" "),
                              _c("option", { attrs: { value: "1" } }, [
                                _vm._v(
                                  _vm._s(
                                    _vm.trans.get(
                                      "challenges.completion_student"
                                    )
                                  )
                                )
                              ])
                            ]
                          )
                        ])
                      ])
                    ])
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "field has-margin-top-3" },
                [
                  _vm.challenge.cards > 0
                    ? _c(
                        "b-switch",
                        {
                          attrs: {
                            type: "is-info",
                            "true-value": "1",
                            "false-value": "0"
                          },
                          model: {
                            value: _vm.challenge.auto_assign,
                            callback: function($$v) {
                              _vm.$set(_vm.challenge, "auto_assign", $$v)
                            },
                            expression: "challenge.auto_assign"
                          }
                        },
                        [_vm._v("Auto-assign cards?")]
                      )
                    : _vm._e()
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "field" },
                [
                  _c(
                    "b-switch",
                    {
                      attrs: {
                        type: "is-info",
                        "true-value": "1",
                        "false-value": "0"
                      },
                      model: {
                        value: _vm.challenge.type,
                        callback: function($$v) {
                          _vm.$set(_vm.challenge, "type", $$v)
                        },
                        expression: "challenge.type"
                      }
                    },
                    [_vm._v("Group challenge")]
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "field" },
                [
                  _c(
                    "b-switch",
                    {
                      attrs: {
                        type: "is-info",
                        "true-value": "1",
                        "false-value": "0"
                      },
                      model: {
                        value: _vm.challenge.optional,
                        callback: function($$v) {
                          _vm.$set(_vm.challenge, "optional", $$v)
                        },
                        expression: "challenge.optional"
                      }
                    },
                    [_vm._v("Optional")]
                  )
                ],
                1
              )
            ])
          : _vm._e(),
        _vm._v(" "),
        !_vm.edit
          ? _c(
              "button",
              { staticClass: "button is-primary", attrs: { type: "submit" } },
              [_vm._v(_vm._s(_vm.trans.get("challenges.create_challenge")))]
            )
          : _c(
              "button",
              { staticClass: "button is-info", attrs: { type: "submit" } },
              [_vm._v(_vm._s(_vm.trans.get("challenges.edit_challenge")))]
            )
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
    return _c("p", { staticClass: "control" }, [
      _c("span", { staticClass: "button is-static" }, [
        _c("i", { staticClass: "fas fa-fist-raised colored" })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "control" }, [
      _c("span", { staticClass: "button is-static" }, [
        _c("i", { staticClass: "fas fa-heart colored" })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "control" }, [
      _c("span", { staticClass: "button is-static" }, [
        _c("i", { staticClass: "fas fa-coins colored" })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "control" }, [
      _c("span", { staticClass: "button is-static" }, [
        _c("i", { staticClass: "fas fa-club colored" })
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214&":
/*!***************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214& ***!
  \***************************************************************************************************************************************************************************************************************/
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
  return _c("el-tiptap", {
    attrs: {
      extensions: _vm.extensions,
      placeholder: "Write here some fun stuff!"
    },
    model: {
      value: _vm.$parent.content,
      callback: function($$v) {
        _vm.$set(_vm.$parent, "content", $$v)
      },
      expression: "$parent.content"
    }
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/challenges/CreateChallenges.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/challenges/CreateChallenges.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateChallenges_vue_vue_type_template_id_58fd01f0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateChallenges.vue?vue&type=template&id=58fd01f0& */ "./resources/js/components/challenges/CreateChallenges.vue?vue&type=template&id=58fd01f0&");
/* harmony import */ var _CreateChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateChallenges.vue?vue&type=script&lang=js& */ "./resources/js/components/challenges/CreateChallenges.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreateChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateChallenges_vue_vue_type_template_id_58fd01f0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateChallenges_vue_vue_type_template_id_58fd01f0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/challenges/CreateChallenges.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/challenges/CreateChallenges.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/challenges/CreateChallenges.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateChallenges.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/CreateChallenges.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallenges_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/challenges/CreateChallenges.vue?vue&type=template&id=58fd01f0&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/challenges/CreateChallenges.vue?vue&type=template&id=58fd01f0& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallenges_vue_vue_type_template_id_58fd01f0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateChallenges.vue?vue&type=template&id=58fd01f0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/challenges/CreateChallenges.vue?vue&type=template&id=58fd01f0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallenges_vue_vue_type_template_id_58fd01f0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateChallenges_vue_vue_type_template_id_58fd01f0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/utils/Editor.vue":
/*!**************************************************!*\
  !*** ./resources/js/components/utils/Editor.vue ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Editor.vue?vue&type=template&id=d7987214& */ "./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214&");
/* harmony import */ var _Editor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Editor.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/Editor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Editor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/Editor.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/Editor.vue?vue&type=script&lang=js&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/utils/Editor.vue?vue&type=script&lang=js& ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Editor.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Editor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214& ***!
  \*********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Editor.vue?vue&type=template&id=d7987214& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Editor.vue?vue&type=template&id=d7987214&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Editor_vue_vue_type_template_id_d7987214___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);