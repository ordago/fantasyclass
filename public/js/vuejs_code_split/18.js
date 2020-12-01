(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[18],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/Grade.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/evaluation/Grade.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["classroom", "evaluable", "students", "rubric", "settings"],
  created: function created() {},
  data: function data() {
    return {
      showRubric: false,
      studentActive: null,
      grade: null,
      rowsSelected: [],
      isLoading: false
    };
  },
  methods: {
    selectItem: function selectItem(target, row, item) {
      var element = document.querySelector("[item=item" + item.id + "]");
      document.querySelectorAll("[row=row" + row + "]").forEach(function (rowItem) {
        rowItem.classList.remove("selectedSubItem");
      });
      element.classList.add("selectedSubItem");
      this.recalculate();
    },
    recalculate: function recalculate() {
      var total = 0;
      var totalSelected = 0;
      var totalOptional = 0;
      document.querySelectorAll(".rubricSubitems:not([data-info=data-optional]) .rubricSubitem.selectedSubItem").forEach(function (rowItem) {
        totalSelected += parseFloat(rowItem.querySelector(".rubricScore").innerHTML);
      });
      document.querySelectorAll(".rubricSubitems:not([data-info=data-optional])").forEach(function (row) {
        var max = 0;
        row.querySelectorAll(".rubricSubitem").forEach(function (item) {
          var score = parseFloat(item.querySelector(".rubricScore").innerHTML);
          if (score > max) max = score;
        });
        total += max;
      }); // TODO optional rows
      // $('.rubricSubitems[data-info=data-optional]').find('.rubricSubitem.selectedSubItem').each(function(index){
      //     totalOptional += parseFloat($(this).find('.rubricScore').html());
      // });

      this.grade = Math.min(this.settings.eval_max, Math.round((totalSelected / total * this.settings.eval_max + totalOptional) * 100) / 100);
    },
    loadRubric: function loadRubric(student) {
      var _this = this;

      this.isLoading = true;
      this.grade = null;
      this.showRubric = true;
      this.studentActive = student;
      axios.post("/classroom/evaluation/student/rubric", {
        student: student.id,
        rubric: this.rubric.id
      }).then(function (response) {
        _this.isLoading = false;
        response.data.forEach(function (row) {
          document.querySelector("[row=row" + row[0] + "][item=item" + row[1] + "]").classList.add("selectedSubItem");

          _this.recalculate();
        });
      });
    },
    gradeRubric: function gradeRubric() {
      var _this2 = this;

      var elem = this;
      document.querySelectorAll(".selectedSubItem").forEach(function (item) {
        elem.rowsSelected.push([item.getAttribute("row").replace("row", ""), item.getAttribute("item").replace("item", "")]);
      });
      axios.post("/classroom/evaluation/" + this.evaluable.id + "/evaluate/rubric", {
        student: this.studentActive.id,
        rows: this.rowsSelected
      }).then(function (response) {
        _this2.studentActive.grade = _this2.grade;
        _this2.studentActive = null;
        _this2.showRubric = false;
        _this2.rowsSelected = [];
      });
    },
    save: function save() {
      var _this3 = this;

      axios.post("/classroom/evaluation/" + this.evaluable.id + "/evaluate", {
        grades: this.students
      }).then(function (response) {
        _this3.$toast(_this3.trans.get("success_error.update_success"), {
          type: "success"
        });
      });
    }
  },
  components: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/Grade.vue?vue&type=template&id=7e4d6b6f&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/evaluation/Grade.vue?vue&type=template&id=7e4d6b6f& ***!
  \*******************************************************************************************************************************************************************************************************************/
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
      _c(
        "form",
        {
          on: {
            submit: function($event) {
              $event.preventDefault()
              return _vm.save($event)
            }
          }
        },
        [
          _vm._l(_vm.students, function(student) {
            return _c("div", { key: student.id }, [
              _c(
                "div",
                { staticClass: "column is-flex align-items-center is-size-4" },
                [_vm._v("\n        " + _vm._s(student.name) + "\n      ")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "columns" }, [
                _vm.evaluable.type == 1
                  ? _c("div", { staticClass: "column is-narrow" }, [
                      _c(
                        "button",
                        {
                          staticClass: "button is-info",
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.loadRubric(student)
                            }
                          }
                        },
                        [_vm._v("\n            Rubric\n          ")]
                      )
                    ])
                  : _vm._e(),
                _vm._v(" "),
                _c("div", { staticClass: "column is-narrow" }, [
                  _c("div", { staticClass: "field" }, [
                    _c("div", { staticClass: "control" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: student.grade,
                            expression: "student.grade"
                          }
                        ],
                        staticClass: "input",
                        attrs: {
                          step: "0.01",
                          type: "number",
                          min: "0",
                          max: _vm.settings.eval_max,
                          placeholder: "Grade"
                        },
                        domProps: { value: student.grade },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(student, "grade", $event.target.value)
                          }
                        }
                      })
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "column" }, [
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: student.feedback,
                        expression: "student.feedback"
                      }
                    ],
                    staticClass: "input",
                    attrs: { placeholder: "Feedback" },
                    domProps: { value: student.feedback },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(student, "feedback", $event.target.value)
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("hr", { staticStyle: { "background-color": "black" } })
              ])
            ])
          }),
          _vm._v(" "),
          _c("button", { staticClass: "button is-primary mt-4" }, [
            _c("i", { staticClass: "fas fa-save mr-3" }),
            _vm._v(
              "\n      " + _vm._s(_vm.trans.get("general.save")) + "\n    "
            )
          ])
        ],
        2
      ),
      _vm._v(" "),
      _c("b-loading", {
        attrs: {
          "is-full-page": true,
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
      _vm.studentActive != null
        ? _c(
            "b-modal",
            {
              attrs: {
                active: _vm.showRubric,
                "has-modal-card": "",
                "trap-focus": "",
                "destroy-on-hide": false,
                "aria-role": "dialog",
                "aria-modal": "",
                "full-screen": ""
              },
              on: {
                "update:active": function($event) {
                  _vm.showRubric = $event
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
                      _vm._v(_vm._s(_vm.studentActive.name))
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "section",
                    { staticClass: "modal-card-body" },
                    _vm._l(_vm.rubric.rows, function(rubricRow) {
                      return _c(
                        "div",
                        {
                          key: rubricRow.id,
                          staticClass: "div_rounded rubricRow marginRadius"
                        },
                        [
                          _c("h2", { staticClass: "description" }, [
                            _vm._v(_vm._s(rubricRow.description))
                          ]),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "rubricSubitems" },
                            _vm._l(rubricRow.items, function(item) {
                              return _c(
                                "div",
                                {
                                  key: item.id,
                                  staticClass: "rubricSubitem marginRadius",
                                  attrs: {
                                    row: "row" + rubricRow.id,
                                    item: "item" + item.id
                                  },
                                  on: {
                                    click: function($event) {
                                      return _vm.selectItem(
                                        $event.target,
                                        rubricRow.id,
                                        item
                                      )
                                    }
                                  }
                                },
                                [
                                  _c("div", { staticClass: "rubricDetails" }, [
                                    _vm._v(_vm._s(item.description))
                                  ]),
                                  _vm._v(" "),
                                  _c("div", { staticClass: "rubricScore" }, [
                                    _vm._v(_vm._s(item.points))
                                  ])
                                ]
                              )
                            }),
                            0
                          )
                        ]
                      )
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
                            _vm.studentActive = null
                            _vm.showRubric = false
                          }
                        }
                      },
                      [_vm._v("\n          Close\n        ")]
                    ),
                    _vm._v(" "),
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.grade,
                          expression: "grade"
                        }
                      ],
                      staticClass: "input mr-3",
                      staticStyle: { width: "100px" },
                      attrs: { type: "number" },
                      domProps: { value: _vm.grade },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.grade = $event.target.value
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        staticClass: "button is-primary",
                        on: { click: _vm.gradeRubric }
                      },
                      [_vm._v("Grade")]
                    )
                  ])
                ]
              )
            ]
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/evaluation/Grade.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/evaluation/Grade.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Grade_vue_vue_type_template_id_7e4d6b6f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Grade.vue?vue&type=template&id=7e4d6b6f& */ "./resources/js/components/evaluation/Grade.vue?vue&type=template&id=7e4d6b6f&");
/* harmony import */ var _Grade_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Grade.vue?vue&type=script&lang=js& */ "./resources/js/components/evaluation/Grade.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Grade_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Grade_vue_vue_type_template_id_7e4d6b6f___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Grade_vue_vue_type_template_id_7e4d6b6f___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/evaluation/Grade.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/evaluation/Grade.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/evaluation/Grade.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Grade_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Grade.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/Grade.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Grade_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/evaluation/Grade.vue?vue&type=template&id=7e4d6b6f&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/evaluation/Grade.vue?vue&type=template&id=7e4d6b6f& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Grade_vue_vue_type_template_id_7e4d6b6f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Grade.vue?vue&type=template&id=7e4d6b6f& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/Grade.vue?vue&type=template&id=7e4d6b6f&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Grade_vue_vue_type_template_id_7e4d6b6f___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Grade_vue_vue_type_template_id_7e4d6b6f___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);