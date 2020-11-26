(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[37],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/Report.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/evaluation/Report.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../utils.js */ "./resources/js/utils.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["classroom", "grades", "settings", "admin"],
  created: function created() {},
  data: function data() {
    return {};
  },
  methods: {
    getGradeClass: function getGradeClass(grade) {
      return _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].getGradeClass(grade, this.settings.eval_max);
    },
    getPassFail: function getPassFail(grade) {
      return _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].getPassFail(grade, this.settings.eval_max);
    },
    getEmoji: function getEmoji(grade) {
      return _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].getEmoji(grade, this.settings.eval_max);
    },
    getGrade: function getGrade(grade) {
      var totalGrades = 0;
      var totalWeight = 0;
      grade.evaluables.forEach(function (element) {
        totalGrades += element.grade * element.pivot.weight;
        totalWeight += element.pivot.weight;
      });
      if (totalGrades == 0) return 0;
      return (totalGrades / totalWeight).toFixed(2);
    },
    finalGrade: function finalGrade(student) {
      var _this = this;

      var finalGrade = 0;
      student.grades.forEach(function (grade) {
        finalGrade += _this.getGrade(grade) * grade.percent / 100;
      });
      return finalGrade.toFixed(2);
    },
    exportReport: function exportReport() {
      var table = document.getElementById('evaluationReport');
      var columns = table.getElementsByTagName("th");
      var rows = table.getElementsByTagName("tr");
      var headings = [];
      var elements = new Array();

      for (var n = 0; n < columns.length; n++) {
        var innerHtml = columns[n].innerHTML; // Remove Html Tags

        var header = innerHtml.replace(/(<([^>]+)>)/gi, ""); // Remove break lines

        header = header.replace(/(\r\n|\n|\r)/gm, ""); // Remove whitespaces

        header = header.replace(/\s{2,}/g, "");
        headings.push(header.trim());
      }

      for (var n = 0; n < rows.length; n++) {
        var values = [];
        var row = rows[n];
        var cells = row.cells;

        for (var cont = 0; cont < cells.length; cont++) {
          var innerHtml = cells[cont].innerHTML; // Remove Html Tags

          var value = innerHtml.replace(/(<([^>]+)>)/gi, ""); // Remove break lines

          value = value.replace(/(\r\n|\n|\r)/gm, "");
          values.push(value.trim());
        }

        elements.push(values);
      }

      axios.post('/classroom/evaluation/exportEvaluationReport/', {
        headings: headings,
        values: elements
      }, {
        responseType: 'blob'
      }).then(function (response) {
        var blob = new Blob([response.data], {
          type: response.data.type
        });
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        var contentDisposition = response.headers['content-disposition'];
        var fileName = 'unknown';

        if (contentDisposition) {
          var fileNameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
          var matches = fileNameRegex.exec(contentDisposition);

          if (matches != null && matches[1]) {
            fileName = matches[1].replace(/['"]/g, '');
          }
        }

        link.download = fileName;
        link.click();
        URL.revokeObjectURL(link.href);
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/Report.vue?vue&type=template&id=8de5bd68&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/evaluation/Report.vue?vue&type=template&id=8de5bd68& ***!
  \********************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "w-100 p-2 content" }, [
    _c(
      "button",
      { staticClass: "button is-dark noprint", on: { click: _vm.print } },
      [_c("i", { staticClass: "fas fa-print" })]
    ),
    _vm._v(" "),
    _c(
      "button",
      {
        staticClass: "button is-success noprint",
        attrs: { formtarget: "_blank" },
        on: { click: _vm.exportReport }
      },
      [_c("i", { staticClass: "fas fa-file-excel" })]
    ),
    _vm._v(" "),
    _c(
      "table",
      {
        staticClass: "grades has-background-light mt-3",
        attrs: { id: "evaluationReport" }
      },
      [
        _c("th", [_vm._v(_vm._s(_vm.trans.get("evaluation.student")))]),
        _vm._v(" "),
        _vm._l(_vm.grades[0].grades, function(tag, index) {
          return _c("th", { key: index + "-" + tag.id }, [
            _vm._v("\n            " + _vm._s(tag.name) + "\n            "),
            _c("br"),
            _vm._v("\n            (" + _vm._s(tag.percent) + " %)\n        ")
          ])
        }),
        _vm._v(" "),
        _c("th", [_vm._v("Total")]),
        _vm._v(" "),
        _c(
          "tbody",
          _vm._l(_vm.grades, function(student) {
            return _c(
              "tr",
              { key: student.student_id },
              [
                _c("td", [_vm._v(_vm._s(student.name))]),
                _vm._v(" "),
                _vm._l(student.grades, function(grade) {
                  return _c("td", { key: grade.id }, [
                    _vm.admin ||
                    (_vm.settings.eval_type != 1 && _vm.settings.eval_type != 2)
                      ? _c("span", [
                          _c(
                            "span",
                            {
                              staticClass: "tag is-size-6",
                              class: _vm.getGradeClass(_vm.getGrade(grade))
                            },
                            [_vm._v(_vm._s(_vm.getGrade(grade)))]
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.settings.eval_type == 1
                      ? _c("span", [
                          _c("i", {
                            class:
                              "fas " +
                              _vm.getEmoji(_vm.getGrade(grade)) +
                              " rateEmoji"
                          })
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.settings.eval_type == 2
                      ? _c(
                          "span",
                          {
                            staticClass: "tag",
                            class: _vm.getGradeClass(_vm.getGrade(grade))
                          },
                          [
                            _c("i", {
                              class:
                                "fas " + _vm.getPassFail(_vm.getGrade(grade))
                            })
                          ]
                        )
                      : _vm._e()
                  ])
                }),
                _vm._v(" "),
                _c("td", [
                  _vm.admin ||
                  (_vm.settings.eval_type != 1 && _vm.settings.eval_type != 2)
                    ? _c("span", [
                        _c(
                          "span",
                          {
                            staticClass: "tag is-size-6",
                            class: _vm.getGradeClass(_vm.finalGrade(student))
                          },
                          [
                            _vm._v(
                              _vm._s(_vm.finalGrade(student)) +
                                " / " +
                                _vm._s(_vm.settings.eval_max)
                            )
                          ]
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.settings.eval_type == 1
                    ? _c("span", [
                        _c("i", {
                          class:
                            "fas " +
                            _vm.getEmoji(_vm.finalGrade(student)) +
                            " rateEmoji"
                        })
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.settings.eval_type == 2
                    ? _c(
                        "span",
                        {
                          staticClass: "tag",
                          class: _vm.getGradeClass(_vm.finalGrade(student))
                        },
                        [
                          _c("i", {
                            class:
                              "fas " + _vm.getPassFail(_vm.finalGrade(student))
                          })
                        ]
                      )
                    : _vm._e()
                ])
              ],
              2
            )
          }),
          0
        )
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/evaluation/Report.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/evaluation/Report.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Report_vue_vue_type_template_id_8de5bd68___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Report.vue?vue&type=template&id=8de5bd68& */ "./resources/js/components/evaluation/Report.vue?vue&type=template&id=8de5bd68&");
/* harmony import */ var _Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Report.vue?vue&type=script&lang=js& */ "./resources/js/components/evaluation/Report.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Report_vue_vue_type_template_id_8de5bd68___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Report_vue_vue_type_template_id_8de5bd68___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/evaluation/Report.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/evaluation/Report.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/evaluation/Report.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Report.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/Report.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/evaluation/Report.vue?vue&type=template&id=8de5bd68&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/evaluation/Report.vue?vue&type=template&id=8de5bd68& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_8de5bd68___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Report.vue?vue&type=template&id=8de5bd68& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/evaluation/Report.vue?vue&type=template&id=8de5bd68&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_8de5bd68___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_8de5bd68___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);