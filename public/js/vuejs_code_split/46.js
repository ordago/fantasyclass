(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[46],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/student/AddStudents.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/student/AddStudents.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../utils.js */ "./resources/js/utils.js");
/* harmony import */ var vue_toastification__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-toastification */ "./node_modules/vue-toastification/dist/esm/index.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



var Xlsx = function Xlsx() {
  return Promise.all(/*! import() */[__webpack_require__.e(8), __webpack_require__.e(13)]).then(__webpack_require__.bind(null, /*! ../utils/ImportExcel.vue */ "./resources/js/components/utils/ImportExcel.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    Xlsx: Xlsx
  },
  props: ["code", "modalVisible"],
  mounted: function mounted() {
    if (this.modalVisible == true) this.loadGoogleCourses();
  },
  data: function data() {
    return {
      students: [],
      stdName: "",
      stdEmail: "",
      stdCourse: "",
      stdGoogleUid: "",
      stdUsername: "",
      nextId: 1,
      gcourses: [],
      gstudents: [],
      isModalActive: false,
      isLoading: false
    };
  },
  methods: {
    loadGoogleStudents: function loadGoogleStudents(id) {
      var _this = this;

      axios.get("/google/classroom/list/" + id + "/students").then(function (response) {
        _this.gstudents = response.data;
      });
    },
    loadGoogleCourses: function loadGoogleCourses() {
      var _this2 = this;

      axios.get("/google/classroom/list/courses").then(function (response) {
        _this2.gcourses = response.data;
        _this2.isModalActive = true;
      })["catch"](function (error) {
        location.href = "/google/classroom/link/" + _this2.code;
      });
    },
    addFromClassroom: function addFromClassroom() {
      var _this3 = this;

      this.gstudents.forEach(function (student) {
        _this3.addStudent(student.profile.name.fullName, student.profile.emailAddress, student.courseId, student.userId);

        _this3.stdName = "";
        _this3.stdEmail = "";
      });
      this.gstudents = [];
      this.isModalActive = false;
    },
    addFromExcel: function addFromExcel(students) {
      var _this4 = this;

      students.forEach(function (student) {
        _this4.addStudent(student["Name"], student["E-mail"]);

        _this4.stdName = "";
        _this4.stdEmail = "";
      });
    },
    addStudentForm: function addStudentForm() {
      this.addStudent(this.stdName, this.stdEmail);
      this.stdEmail = "";
      this.stdNameP = "";
    },
    addStudent: function addStudent(name, email) {
      var _this5 = this;

      var gcourse = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
      var guid = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

      if (email && !_utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].validEmail(email)) {
        _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].toast(this, this.trans.get("validation.email"), vue_toastification__WEBPACK_IMPORTED_MODULE_1__["TYPE"].ERROR);
        return false;
      }

      if (!email) email = "";
      var search = this.students.find(function (student) {
        return student.name === name;
      });

      if (name && !search) {
        axios.post("/classroom/students/getusername", {
          name: name,
          email: email
        }).then(function (response) {
          _this5.stdUsername = response.data;

          _this5.students.push({
            id: _this5.nextId++,
            name: name,
            email: email,
            username: _this5.stdUsername,
            google_course: gcourse,
            google_uid: guid
          });

          name = email = _this5.stdEmail = _this5.stdName = _this5.stdUsername = "";
        });
      } else {
        _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].toast(this, this.trans.get("validation.distinct"), vue_toastification__WEBPACK_IMPORTED_MODULE_1__["TYPE"].ERROR);
      }
    },
    sendStudents: function sendStudents() {
      var _this6 = this;

      if (this.students.length) {
        this.isLoading = true;
        this.$forceUpdate();
        axios.post("/classroom/students", {
          students: this.students
        }).then(function (response) {
          _this6.isLoading = false;

          if (response.data) {
            response.data.forEach(function (element) {
              _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].toast(_this6, element, vue_toastification__WEBPACK_IMPORTED_MODULE_1__["TYPE"].ERROR);
            });
            _this6.students = [];
          } else {
            window.location = "/classroom/" + _this6.code;
          }
        })["catch"](function (error) {
          _this6.isLoading = false;
          _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].toast(_this6, error, vue_toastification__WEBPACK_IMPORTED_MODULE_1__["TYPE"].ERROR);
          _this6.students = [];
        });
      }
    },
    deleteStudent: function deleteStudent(index) {
      this.students.splice(index, 1);
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/student/AddStudents.vue?vue&type=template&id=16f87a2c&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/student/AddStudents.vue?vue&type=template&id=16f87a2c& ***!
  \**********************************************************************************************************************************************************************************************************************/
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
    { staticClass: "p-4" },
    [
      _c("div", { staticClass: "columns" }, [
        _c(
          "div",
          { staticClass: "column is-narrow p-0 m-1" },
          [_c("Xlsx", { attrs: { type: "addstudent" } })],
          1
        ),
        _vm._v(" "),
        _c("div", { staticClass: "column is-narrow p-0 m-1" }, [
          _c(
            "button",
            {
              staticClass: "button button is-white border",
              on: { click: _vm.loadGoogleCourses }
            },
            [
              _c("img", {
                attrs: { src: "/img/google-logo.svg", width: "40px" }
              }),
              _vm._v(
                "\n        " +
                  _vm._s(_vm.trans.get("students.import_gclassroom")) +
                  "\n      "
              )
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "field is-horizontal" }, [
        _c(
          "form",
          {
            on: {
              submit: function($event) {
                $event.preventDefault()
                return _vm.addStudentForm($event)
              }
            }
          },
          [
            _c("div", { staticClass: "field-body" }, [
              _c("div", { staticClass: "field is-expanded" }, [
                _c("div", { staticClass: "field has-addons mobile" }, [
                  _vm._m(0),
                  _vm._v(" "),
                  _c("p", { staticClass: "control is-expanded" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.stdName,
                          expression: "stdName"
                        }
                      ],
                      staticClass: "input",
                      attrs: {
                        required: "",
                        type: "text",
                        minlength: "4",
                        placeholder: _vm.trans.get("students.name_surname")
                      },
                      domProps: { value: _vm.stdName },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.stdName = $event.target.value
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "control is-expanded" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.stdEmail,
                          expression: "stdEmail"
                        }
                      ],
                      staticClass: "input",
                      attrs: {
                        type: "email",
                        placeholder:
                          "Email (" + _vm.trans.get("general.optional") + ")"
                      },
                      domProps: { value: _vm.stdEmail },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.stdEmail = $event.target.value
                        }
                      }
                    })
                  ]),
                  _vm._v(" "),
                  _c("p", { staticClass: "control" }, [
                    _c("button", { staticClass: "button is-primary" }, [
                      _vm._v(
                        "\n                " +
                          _vm._s(_vm.trans.get("users_groups.add_student")) +
                          "\n              "
                      )
                    ])
                  ])
                ])
              ])
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _vm._l(_vm.students, function(student, index) {
        return _c("div", { key: student.name }, [
          _c(
            "div",
            {
              staticClass:
                "my-2 p-5 border has-background-white rounded relative"
            },
            [
              _c("span", { staticClass: "pr-3" }, [_vm._v(_vm._s(index + 1))]),
              _vm._v(" "),
              student.google_uid
                ? _c("span", { staticClass: "tag is-danger" }, [
                    _c("i", { staticClass: "fab fa-google" })
                  ])
                : _vm._e(),
              _vm._v("\n      " + _vm._s(student.name) + "\n      "),
              student.email && student.email.length
                ? _c("i", { staticClass: "fal fa-at pl-2" })
                : _vm._e(),
              _vm._v(" "),
              _c("span", { staticClass: "is-italic" }, [
                _vm._v(" " + _vm._s(student.email))
              ]),
              _vm._v(" "),
              student.username.length
                ? _c(
                    "span",
                    {
                      directives: [{ name: "tippy", rawName: "v-tippy" }],
                      staticClass: "tag is-warning ml-2",
                      attrs: {
                        content:
                          "User already exists in FantasyClass, it'll be registered in the classroom"
                      }
                    },
                    [
                      _c("i", { staticClass: "fal fa-user pr-2" }),
                      _vm._v(" " + _vm._s(student.username))
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "button is-danger delete-button-right",
                  on: {
                    click: function($event) {
                      return _vm.deleteStudent(index)
                    }
                  }
                },
                [_c("i", { staticClass: "far fa-trash" })]
              )
            ]
          )
        ])
      }),
      _vm._v(" "),
      _vm.students.length
        ? _c(
            "button",
            {
              staticClass: "button is-link",
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.sendStudents($event)
                }
              }
            },
            [
              _vm._v(
                "\n    " +
                  _vm._s(_vm.trans.get("users_groups.create_students")) +
                  "\n  "
              )
            ]
          )
        : _vm._e(),
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
                  _vm._v("Google Classroom")
                ])
              ]),
              _vm._v(" "),
              _c("section", { staticClass: "modal-card-body is-relative" }, [
                _vm.gcourses && _vm.gcourses.length && !_vm.gstudents.length
                  ? _c(
                      "div",
                      _vm._l(_vm.gcourses, function(course) {
                        return _c(
                          "div",
                          {
                            key: course.id,
                            staticClass: "p-5 m-2 card-shadow-s cursor-pointer",
                            on: {
                              click: function($event) {
                                return _vm.loadGoogleStudents(course.id)
                              }
                            }
                          },
                          [
                            _c("i", { staticClass: "fad fa-chalkboard mr-2" }),
                            _vm._v(" " + _vm._s(course.name) + "\n          ")
                          ]
                        )
                      }),
                      0
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.gstudents && _vm.gstudents.length
                  ? _c(
                      "div",
                      _vm._l(_vm.gstudents, function(student) {
                        return _c(
                          "div",
                          { key: student.profile.id, staticClass: "p-3 m-1" },
                          [
                            _vm._v(
                              "\n            " +
                                _vm._s(student.profile.name.fullName) +
                                " (" +
                                _vm._s(student.profile.emailAddress) +
                                ")\n            "
                            ),
                            _c("hr")
                          ]
                        )
                      }),
                      0
                    )
                  : _vm._e()
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
                        _vm.isModalActive = false
                      }
                    }
                  },
                  [
                    _vm._v(
                      "\n          " +
                        _vm._s(_vm.trans.get("general.close")) +
                        "\n        "
                    )
                  ]
                ),
                _vm._v(" "),
                _vm.gstudents && _vm.gstudents.length
                  ? _c(
                      "button",
                      {
                        staticClass: "button is-link",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            _vm.gstudents = []
                          }
                        }
                      },
                      [_c("i", { staticClass: "fas fa-arrow-left" })]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.gstudents && _vm.gstudents.length
                  ? _c(
                      "button",
                      {
                        staticClass: "button is-success",
                        attrs: { type: "button" },
                        on: { click: _vm.addFromClassroom }
                      },
                      [
                        _vm._v(
                          "\n          " +
                            _vm._s(_vm.trans.get("general.import")) +
                            "\n        "
                        )
                      ]
                    )
                  : _vm._e()
              ])
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c("b-loading", {
        attrs: {
          "is-full-page": true,
          active: _vm.isLoading,
          "can-cancel": false
        },
        on: {
          "update:active": function($event) {
            _vm.isLoading = $event
          }
        }
      })
    ],
    2
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "control" }, [
      _c("a", { staticClass: "button is-static" }, [
        _c("i", { staticClass: "far fa-user-plus" })
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/student/AddStudents.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/student/AddStudents.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AddStudents_vue_vue_type_template_id_16f87a2c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AddStudents.vue?vue&type=template&id=16f87a2c& */ "./resources/js/components/student/AddStudents.vue?vue&type=template&id=16f87a2c&");
/* harmony import */ var _AddStudents_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AddStudents.vue?vue&type=script&lang=js& */ "./resources/js/components/student/AddStudents.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AddStudents_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AddStudents_vue_vue_type_template_id_16f87a2c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AddStudents_vue_vue_type_template_id_16f87a2c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/student/AddStudents.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/student/AddStudents.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/student/AddStudents.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddStudents_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./AddStudents.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/student/AddStudents.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddStudents_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/student/AddStudents.vue?vue&type=template&id=16f87a2c&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/student/AddStudents.vue?vue&type=template&id=16f87a2c& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddStudents_vue_vue_type_template_id_16f87a2c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./AddStudents.vue?vue&type=template&id=16f87a2c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/student/AddStudents.vue?vue&type=template&id=16f87a2c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddStudents_vue_vue_type_template_id_16f87a2c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddStudents_vue_vue_type_template_id_16f87a2c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);