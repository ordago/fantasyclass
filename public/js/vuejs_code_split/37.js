(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[37],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/TagManagement.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/evaluation/TagManagement.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["classroom", "tags", "rubrics", "lines", "settings"],
  created: function created() {
    this.tagsReactive = this.tags;
    this.filteredTags = this.tags;
    this.linesReactive = this.lines;
  },
  data: function data() {
    return {
      filteredTags: null,
      tagsReactive: null,
      isTagModalActive: false,
      isLineModalActive: false,
      isGradeModalActive: false,
      isPrefsModalActive: false,
      linesReactive: [],
      tag: {
        "short": "",
        description: "",
        percent: 0
      },
      line: {
        id: null,
        tags: [],
        description: "",
        weights: {},
        type: 0,
        rubric: null
      }
    };
  },
  methods: {
    updatePrefs: function updatePrefs() {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "eval_visible",
        value: this.settings.eval_visible,
        action: "update"
      });
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "eval_type",
        value: this.settings.eval_type,
        action: "update"
      });
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "eval_max",
        value: this.settings.eval_max,
        action: "update"
      });
      this.isPrefsModalActive = false;
    },
    editTag: function editTag() {
      var _this = this;

      axios.patch("/classroom/" + this.classroom.code + "/tag", this.tag).then(function (response) {
        _this.isTagModalActive = false;
      });
    },
    showEditTag: function showEditTag(tag) {
      this.tag = tag;
      this.isTagModalActive = true;
    },
    showEditLine: function showEditLine(line) {// this.line.id = line.id;
      // this.line.description = line.description;
      // this.line.weights = line.weights;
      // this.line.type = line.type;
      // this.line.rubric = line.rubric;
      // // line.tags.forEach((element) => {
      // //   let tag = this.tagsReactive.find(function (item, i) {
      // //     return item.id === element.id;
      // //   });
      // //   this.line.tags.push(tag);
      // // });
      // this.isLineModalActive = true;
    },
    deleteLine: function deleteLine(id) {
      var _this2 = this;

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
          axios["delete"]("/classroom/evaline/" + id).then(function (response) {
            var index = _this2.linesReactive.findIndex(function (item, i) {
              return item.id === id;
            });

            _this2.linesReactive.splice(index, 1);
          });
        }
      });
    },
    deleteTag: function deleteTag(id, index) {
      var _this3 = this;

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
          axios["delete"]("/classroom/tag/" + id).then(function (response) {
            _this3.tagsReactive.splice(index, 1);
          });
        }
      });
    },
    setWeight: function setWeight(elems) {
      var _this4 = this;

      elems.forEach(function (element) {
        _this4.line.weights[element.id] = 1;
      });
    },
    addLine: function addLine() {
      var _this5 = this;

      if (this.line.tags.length) {
        axios.post("/classroom/" + this.classroom.code + "/evaline", this.line).then(function (response) {
          _this5.isLineModalActive = false;

          _this5.linesReactive.push(response.data);
        });
      } else {
        this.$refs.taginput.newTag = "";
        this.$toast(this.trans.get("success_error.taginput"), {
          type: "error"
        });
      }
    },
    addTag: function addTag() {
      var _this6 = this;

      axios.post("/classroom/" + this.classroom.code + "/tag", this.tag).then(function (response) {
        _this6.isTagModalActive = false;

        _this6.tagsReactive.push(response.data);
      });
    },
    getFilteredTags: function getFilteredTags(text) {
      this.filteredTags = this.tagsReactive.filter(function (option) {
        return option["short"].toString().toLowerCase().indexOf(text.toLowerCase()) >= 0;
      });
    }
  },
  components: {},
  computed: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/TagManagement.vue?vue&type=template&id=2f00c415&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/evaluation/TagManagement.vue?vue&type=template&id=2f00c415& ***!
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
    { staticClass: "w-100 p-2 content" },
    [
      _c("div", { staticClass: "buttons" }, [
        _c(
          "button",
          {
            staticClass: "button is-link",
            on: {
              click: function($event) {
                _vm.isTagModalActive = true
              }
            }
          },
          [
            _c("i", { staticClass: "mr-2 fas fa-tag" }),
            _vm._v(
              "\n      " +
                _vm._s(_vm.trans.get("evaluation.add_tag")) +
                "\n    "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "button is-warning",
            attrs: { href: "/classroom/" + _vm.classroom.code + "/rubrics" }
          },
          [
            _c("i", { staticClass: "mr-2 fas fa-tasks-alt" }),
            _vm._v(
              "\n      " +
                _vm._s(_vm.trans.get("evaluation.rubric_management")) +
                "\n    "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "button is-primary",
            attrs: {
              href: "/classroom/" + _vm.classroom.code + "/evaluation/report"
            }
          },
          [
            _c("i", { staticClass: "mr-2 fas fa-file-chart-line" }),
            _vm._v(
              "\n      " + _vm._s(_vm.trans.get("evaluation.report")) + "\n    "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "button is-dark",
            on: {
              click: function($event) {
                _vm.isPrefsModalActive = true
              }
            }
          },
          [
            _c("i", { staticClass: "mr-2 fas fa-cog" }),
            _vm._v(
              "\n      " + _vm._s(_vm.trans.get("evaluation.config")) + "\n    "
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "my-3" },
        _vm._l(_vm.tagsReactive, function(tag, index) {
          return _c(
            "span",
            {
              directives: [{ name: "tippy", rawName: "v-tippy" }],
              key: tag.id,
              staticClass: "tag is-dark is-medium mr-2 p-5",
              attrs: { content: tag.description }
            },
            [
              _c("i", { staticClass: "fas fa-tag mr-2" }),
              _vm._v(
                "\n      " +
                  _vm._s(tag.short) +
                  " (" +
                  _vm._s(tag.percent) +
                  "%)\n      "
              ),
              _c("small", [
                _c("i", {
                  staticClass:
                    "fas fa-edit has-background-info rounded pointer p-2 ml-3",
                  on: {
                    click: function($event) {
                      return _vm.showEditTag(tag)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c(
                "small",
                {
                  on: {
                    click: function($event) {
                      return _vm.deleteTag(tag.id, index)
                    }
                  }
                },
                [
                  _c("i", {
                    staticClass:
                      "fas fa-trash-alt has-background-danger rounded pointer p-2 ml-3"
                  })
                ]
              )
            ]
          )
        }),
        0
      ),
      _vm._v(" "),
      _c("div", [
        _vm.tagsReactive.length
          ? _c(
              "button",
              {
                staticClass: "button is-link",
                on: {
                  click: function($event) {
                    _vm.isLineModalActive = true
                  }
                }
              },
              [
                _vm._v(
                  "\n      " +
                    _vm._s(_vm.trans.get("evaluation.evaluation_line")) +
                    "\n    "
                )
              ]
            )
          : _vm._e()
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "m-3" },
        [
          _vm.linesReactive.length
            ? _c("b-table", {
                attrs: {
                  data: _vm.linesReactive,
                  "icon-pack": "fas",
                  "cell-class": "align-right",
                  "sort-icon": "arrow-up"
                },
                scopedSlots: _vm._u(
                  [
                    {
                      key: "default",
                      fn: function(props) {
                        return [
                          _c(
                            "b-table-column",
                            {
                              attrs: {
                                field: "description",
                                label: _vm.trans.get("evaluation.description"),
                                sortable: ""
                              }
                            },
                            [_vm._v(_vm._s(props.row.description))]
                          ),
                          _vm._v(" "),
                          _c(
                            "b-table-column",
                            {
                              attrs: {
                                field: "tags",
                                label: _vm.trans.get("evaluation.tags"),
                                sortable: ""
                              }
                            },
                            _vm._l(props.row.tags, function(tag) {
                              return _c(
                                "span",
                                {
                                  directives: [
                                    { name: "tippy", rawName: "v-tippy" }
                                  ],
                                  key: tag.id,
                                  staticClass: "tag is-dark mr-2",
                                  attrs: {
                                    content:
                                      _vm.trans.get("evaluation.weight") +
                                      ": " +
                                      tag.pivot.weight
                                  }
                                },
                                [_vm._v(_vm._s(tag.short))]
                              )
                            }),
                            0
                          ),
                          _vm._v(" "),
                          _c(
                            "b-table-column",
                            {
                              staticClass: "w-100 is-flex has-all-centered",
                              attrs: {
                                field: "settings",
                                label: _vm.trans.get("menu.settings"),
                                centered: ""
                              }
                            },
                            [
                              _c(
                                "a",
                                {
                                  staticClass: "button is-dark is-small mr-3",
                                  attrs: {
                                    href:
                                      "/classroom/evaluation/" +
                                      props.row.id +
                                      "/grade"
                                  }
                                },
                                [
                                  _c("i", { staticClass: "fad fa-pencil" }),
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        _vm.trans.get("evaluation.grade")
                                      ) +
                                      "\n          "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "b-button",
                                {
                                  directives: [
                                    { name: "tippy", rawName: "v-tippy" }
                                  ],
                                  attrs: {
                                    content: _vm.trans.get("general.delete"),
                                    type: "is-danger is-small"
                                  },
                                  on: {
                                    click: function($event) {
                                      return _vm.deleteLine(props.row.id)
                                    }
                                  }
                                },
                                [_c("i", { staticClass: "fas fa-trash-alt" })]
                              )
                            ],
                            1
                          )
                        ]
                      }
                    }
                  ],
                  null,
                  false,
                  2701026966
                )
              })
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            active: _vm.isTagModalActive,
            "has-modal-card": "",
            "trap-focus": "",
            "destroy-on-hide": false,
            "aria-role": "dialog",
            "aria-modal": ""
          },
          on: {
            "update:active": function($event) {
              _vm.isTagModalActive = $event
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
                  return _vm.addTag($event)
                }
              }
            },
            [
              _c(
                "div",
                { staticClass: "modal-card", staticStyle: { width: "auto" } },
                [
                  _c("header", { staticClass: "modal-card-head" }, [
                    !_vm.tag.classroom_id
                      ? _c("p", { staticClass: "modal-card-title" }, [
                          _vm._v(
                            "\n            " +
                              _vm._s(_vm.trans.get("evaluation.add")) +
                              "\n          "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.tag.classroom_id
                      ? _c("p", { staticClass: "modal-card-title" }, [
                          _vm._v(
                            "\n            " +
                              _vm._s(_vm.trans.get("evaluation.edit")) +
                              "\n          "
                          )
                        ])
                      : _vm._e()
                  ]),
                  _vm._v(" "),
                  _c(
                    "section",
                    { staticClass: "modal-card-body" },
                    [
                      _c(
                        "b-field",
                        {
                          attrs: {
                            label: _vm.trans.get("evaluation.abbreviation")
                          }
                        },
                        [
                          _c("b-input", {
                            attrs: { maxlength: "15", required: "" },
                            model: {
                              value: _vm.tag.short,
                              callback: function($$v) {
                                _vm.$set(_vm.tag, "short", $$v)
                              },
                              expression: "tag.short"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-field",
                        {
                          attrs: {
                            label: _vm.trans.get("evaluation.full_description")
                          }
                        },
                        [
                          _c("b-input", {
                            attrs: { required: "" },
                            model: {
                              value: _vm.tag.description,
                              callback: function($$v) {
                                _vm.$set(_vm.tag, "description", $$v)
                              },
                              expression: "tag.description"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-field",
                        {
                          attrs: { label: _vm.trans.get("evaluation.percent") }
                        },
                        [
                          _c("b-input", {
                            attrs: {
                              type: "number",
                              step: "0.01",
                              required: ""
                            },
                            model: {
                              value: _vm.tag.percent,
                              callback: function($$v) {
                                _vm.$set(_vm.tag, "percent", $$v)
                              },
                              expression: "tag.percent"
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
                            ;(_vm.tag = {
                              short: "",
                              description: "",
                              percent: 0
                            }),
                              (_vm.isTagModalActive = false)
                          }
                        }
                      },
                      [_vm._v("\n            Close\n          ")]
                    ),
                    _vm._v(" "),
                    !_vm.tag.classroom_id
                      ? _c("button", { staticClass: "button is-primary" }, [
                          _vm._v(
                            "\n            " +
                              _vm._s(_vm.trans.get("evaluation.add")) +
                              "\n          "
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.tag.classroom_id
                      ? _c(
                          "button",
                          {
                            staticClass: "button is-primary",
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.editTag($event)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n            " +
                                _vm._s(_vm.trans.get("general.edit")) +
                                "\n          "
                            )
                          ]
                        )
                      : _vm._e()
                  ])
                ]
              )
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            active: _vm.isPrefsModalActive,
            "has-modal-card": "",
            "trap-focus": "",
            "destroy-on-hide": false,
            "aria-role": "dialog",
            "aria-modal": ""
          },
          on: {
            "update:active": function($event) {
              _vm.isPrefsModalActive = $event
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
                  return _vm.updatePrefs($event)
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
                      _vm._v(_vm._s(_vm.trans.get("evaluation.config")))
                    ])
                  ]),
                  _vm._v(" "),
                  _c("section", { staticClass: "modal-card-body" }, [
                    _c("div", { staticClass: "field" }, [
                      _c("label", { staticClass: "label" }, [
                        _vm._v(_vm._s(_vm.trans.get("evaluation.type")))
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "control" }, [
                        _c("div", { staticClass: "select" }, [
                          _c(
                            "select",
                            {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.settings.eval_type,
                                  expression: "settings.eval_type"
                                }
                              ],
                              on: {
                                input: function($event) {
                                  return _vm.$forceUpdate()
                                },
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
                                    _vm.settings,
                                    "eval_type",
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
                                  "\n                    " +
                                    _vm._s(
                                      _vm.trans.get("evaluation.number_grade")
                                    ) +
                                    "\n                  "
                                )
                              ]),
                              _vm._v(" "),
                              _c("option", { attrs: { value: "1" } }, [
                                _vm._v(
                                  "\n                    " +
                                    _vm._s(_vm.trans.get("evaluation.emoji")) +
                                    "\n                  "
                                )
                              ]),
                              _vm._v(" "),
                              _c("option", { attrs: { value: "2" } }, [
                                _vm._v(
                                  "\n                    " +
                                    _vm._s(
                                      _vm.trans.get("evaluation.passfail")
                                    ) +
                                    "\n                  "
                                )
                              ])
                            ]
                          )
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "field" }, [
                      _c("label", { staticClass: "label" }, [
                        _vm._v(_vm._s(_vm.trans.get("evaluation.max_grade")))
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "control" }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.settings.eval_max,
                              expression: "settings.eval_max"
                            }
                          ],
                          staticClass: "input",
                          attrs: { type: "number", placeholder: "Text input" },
                          domProps: { value: _vm.settings.eval_max },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                _vm.settings,
                                "eval_max",
                                $event.target.value
                              )
                            }
                          }
                        })
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "field" },
                      [
                        _c(
                          "b-switch",
                          {
                            attrs: { "true-value": "1", "false-value": "0" },
                            model: {
                              value: _vm.settings.eval_visible,
                              callback: function($$v) {
                                _vm.$set(_vm.settings, "eval_visible", $$v)
                              },
                              expression: "settings.eval_visible"
                            }
                          },
                          [
                            _vm._v(
                              _vm._s(_vm.trans.get("evaluation.visibility"))
                            )
                          ]
                        )
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("footer", { staticClass: "modal-card-foot" }, [
                    _c(
                      "button",
                      {
                        staticClass: "button",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            _vm.isPrefsModalActive = false
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
                        on: { click: _vm.updatePrefs }
                      },
                      [
                        _vm._v(
                          "\n            " +
                            _vm._s(_vm.trans.get("general.update")) +
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
      ),
      _vm._v(" "),
      _c(
        "b-modal",
        {
          attrs: {
            active: _vm.isLineModalActive,
            "has-modal-card": "",
            "trap-focus": "",
            "destroy-on-hide": false,
            "aria-role": "dialog",
            "aria-modal": ""
          },
          on: {
            "update:active": function($event) {
              _vm.isLineModalActive = $event
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
                  return _vm.addLine($event)
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
                          _vm._s(_vm.trans.get("evaluation.evaluation_line")) +
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
                        "section",
                        [
                          _c(
                            "b-field",
                            {
                              attrs: {
                                label: _vm.trans.get(
                                  "evaluation.evaluation_tags"
                                )
                              }
                            },
                            [
                              _c(
                                "b-taginput",
                                {
                                  ref: "taginput",
                                  attrs: {
                                    data: _vm.filteredTags,
                                    autocomplete: "",
                                    id: "taginput",
                                    icon: "tag",
                                    placeholder: _vm.trans.get(
                                      "evaluation.add"
                                    ),
                                    "icon-pack": "fa"
                                  },
                                  on: {
                                    input: _vm.setWeight,
                                    typing: _vm.getFilteredTags
                                  },
                                  scopedSlots: _vm._u([
                                    {
                                      key: "default",
                                      fn: function(props) {
                                        return [
                                          _c("strong", [
                                            _vm._v(_vm._s(props.option.short))
                                          ]),
                                          _vm._v(
                                            "\n                  : " +
                                              _vm._s(props.option.description) +
                                              "\n                "
                                          )
                                        ]
                                      }
                                    },
                                    {
                                      key: "selected",
                                      fn: function(props) {
                                        return _vm._l(props.tags, function(
                                          tag,
                                          index
                                        ) {
                                          return _c(
                                            "b-tag",
                                            {
                                              key: index,
                                              attrs: {
                                                rounded: "",
                                                tabstop: false,
                                                ellipsis: "",
                                                closable: "",
                                                if: "taginput"
                                              },
                                              on: {
                                                close: function($event) {
                                                  return _vm.$refs.taginput.removeTag(
                                                    index,
                                                    $event
                                                  )
                                                }
                                              }
                                            },
                                            [_vm._v(_vm._s(tag.short))]
                                          )
                                        })
                                      }
                                    }
                                  ]),
                                  model: {
                                    value: _vm.line.tags,
                                    callback: function($$v) {
                                      _vm.$set(_vm.line, "tags", $$v)
                                    },
                                    expression: "line.tags"
                                  }
                                },
                                [
                                  _vm._v(" "),
                                  _c("template", { slot: "empty" }, [
                                    _vm._v("There are no items")
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
                      _c(
                        "b-field",
                        {
                          staticClass: "mt-3",
                          attrs: {
                            label: _vm.trans.get("evaluation.description")
                          }
                        },
                        [
                          _c("b-input", {
                            attrs: { required: "" },
                            model: {
                              value: _vm.line.description,
                              callback: function($$v) {
                                _vm.$set(_vm.line, "description", $$v)
                              },
                              expression: "line.description"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "b-field",
                        { attrs: { label: _vm.trans.get("evaluation.type") } },
                        [
                          _c(
                            "b-select",
                            {
                              attrs: { expanded: "" },
                              model: {
                                value: _vm.line.type,
                                callback: function($$v) {
                                  _vm.$set(_vm.line, "type", $$v)
                                },
                                expression: "line.type"
                              }
                            },
                            [
                              _c("option", { attrs: { value: "0" } }, [
                                _vm._v(
                                  _vm._s(_vm.trans.get("evaluation.basic"))
                                )
                              ]),
                              _vm._v(" "),
                              _c("option", { attrs: { value: "1" } }, [
                                _vm._v(
                                  "\n                " +
                                    _vm._s(
                                      _vm.trans.get(
                                        "evaluation.advanced_rubric"
                                      )
                                    ) +
                                    "\n              "
                                )
                              ])
                            ]
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _vm.line.type == 1
                        ? _c(
                            "b-field",
                            {
                              attrs: {
                                label: _vm.trans.get("evaluation.rubric")
                              }
                            },
                            [
                              !_vm.rubrics.length
                                ? _c(
                                    "a",
                                    {
                                      staticClass: "button is-warning",
                                      attrs: {
                                        href:
                                          "/classroom/" +
                                          _vm.classroom.code +
                                          "/rubrics"
                                      }
                                    },
                                    [
                                      _c("i", {
                                        staticClass: "mr-2 fas fa-tasks-alt"
                                      }),
                                      _vm._v(
                                        "\n              " +
                                          _vm._s(
                                            _vm.trans.get(
                                              "evaluation.rubric_management"
                                            )
                                          ) +
                                          "\n            "
                                      )
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _vm.rubrics.length
                                ? _c(
                                    "b-select",
                                    {
                                      attrs: { expanded: "" },
                                      model: {
                                        value: _vm.line.rubric,
                                        callback: function($$v) {
                                          _vm.$set(_vm.line, "rubric", $$v)
                                        },
                                        expression: "line.rubric"
                                      }
                                    },
                                    _vm._l(_vm.rubrics, function(rubric) {
                                      return _c(
                                        "option",
                                        {
                                          key: rubric.id,
                                          domProps: { value: rubric.id }
                                        },
                                        [
                                          _vm._v(
                                            "\n                " +
                                              _vm._s(rubric.name) +
                                              "\n              "
                                          )
                                        ]
                                      )
                                    }),
                                    0
                                  )
                                : _vm._e()
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.line.type == 1 && !_vm.rubrics.length
                        ? _c("p", [
                            _vm._v(
                              "\n            " +
                                _vm._s(
                                  _vm.trans.get("evaluation.rubric_empty")
                                ) +
                                "\n          "
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.line.tags && _vm.line.tags.length
                        ? _c("div", [
                            _c(
                              "details",
                              [
                                _c("summary", { staticClass: "is-size-6" }, [
                                  _c("i", { staticClass: "fas fa-gear" }),
                                  _vm._v(
                                    "\n                " +
                                      _vm._s(
                                        _vm.trans.get("evaluation.advanced")
                                      ) +
                                      "\n              "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("h3", [
                                  _vm._v(
                                    _vm._s(
                                      _vm.trans.get("evaluation.weight_info")
                                    )
                                  )
                                ]),
                                _vm._v(" "),
                                _vm._l(_vm.line.tags, function(tag) {
                                  return _c(
                                    "div",
                                    {
                                      key: tag.id,
                                      staticClass: "is-block w-100 my-2"
                                    },
                                    [
                                      _c(
                                        "b-field",
                                        [
                                          _c(
                                            "b-field",
                                            {
                                              staticClass:
                                                "is-flex has-all-centered",
                                              attrs: { grouped: "" }
                                            },
                                            [
                                              _c(
                                                "p",
                                                { staticClass: "control" },
                                                [_vm._v(_vm._s(tag.short))]
                                              ),
                                              _vm._v(" "),
                                              _c("b-numberinput", {
                                                attrs: { step: "0.01" },
                                                model: {
                                                  value:
                                                    _vm.line.weights[tag.id],
                                                  callback: function($$v) {
                                                    _vm.$set(
                                                      _vm.line.weights,
                                                      tag.id,
                                                      $$v
                                                    )
                                                  },
                                                  expression:
                                                    "line.weights[tag.id]"
                                                }
                                              })
                                            ],
                                            1
                                          )
                                        ],
                                        1
                                      )
                                    ],
                                    1
                                  )
                                })
                              ],
                              2
                            )
                          ])
                        : _vm._e()
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
                            _vm.isLineModalActive = false
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
                    _c("button", { staticClass: "button is-primary" }, [
                      _vm._v(
                        "\n            " +
                          _vm._s(_vm.trans.get("evaluation.evaluation_line")) +
                          "\n          "
                      )
                    ])
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

/***/ "./resources/js/components/evaluation/TagManagement.vue":
/*!**************************************************************!*\
  !*** ./resources/js/components/evaluation/TagManagement.vue ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TagManagement_vue_vue_type_template_id_2f00c415___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TagManagement.vue?vue&type=template&id=2f00c415& */ "./resources/js/components/evaluation/TagManagement.vue?vue&type=template&id=2f00c415&");
/* harmony import */ var _TagManagement_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TagManagement.vue?vue&type=script&lang=js& */ "./resources/js/components/evaluation/TagManagement.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TagManagement_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TagManagement_vue_vue_type_template_id_2f00c415___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TagManagement_vue_vue_type_template_id_2f00c415___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/evaluation/TagManagement.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/evaluation/TagManagement.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/evaluation/TagManagement.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TagManagement_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./TagManagement.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/TagManagement.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TagManagement_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/evaluation/TagManagement.vue?vue&type=template&id=2f00c415&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/evaluation/TagManagement.vue?vue&type=template&id=2f00c415& ***!
  \*********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TagManagement_vue_vue_type_template_id_2f00c415___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./TagManagement.vue?vue&type=template&id=2f00c415& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/TagManagement.vue?vue&type=template&id=2f00c415&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TagManagement_vue_vue_type_template_id_2f00c415___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TagManagement_vue_vue_type_template_id_2f00c415___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);