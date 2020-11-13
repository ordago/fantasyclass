(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[25],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/MassiveActions.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/MassiveActions.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["classroom"],
  mounted: function mounted() {},
  data: function data() {
    return {
      behaviour: null
    };
  },
  methods: {
    accept: function accept() {
      var ids = [];
      var elements = document.querySelectorAll(".student-massive.selected");
      elements.forEach(function (element) {
        ids.push(element.getAttribute('id'));
      });
      axios.post('/classroom/' + this.classroom.code + '/utils/massive', {
        'students': ids,
        'behaviour': this.behaviour
      }).then(function (response) {
        // this.$parent.$parent.isMassiveModalActive = false
        location.reload();
      });
    },
    random: function random() {
      var elements = document.querySelectorAll(".student-massive");
      elements.forEach(function (element) {
        if (Math.random() >= 0.5) {
          element.classList.add("selected");
        } else {
          element.classList.remove("selected");
        }
      });
    },
    changeAll: function changeAll(select) {
      var elements = document.querySelectorAll(".student-massive");
      elements.forEach(function (element) {
        if (select) element.classList.add("selected");else element.classList.remove("selected");
      });
    },
    toggle: function toggle(id) {
      var element = document.getElementById(id);
      if (element.classList.contains("selected")) element.classList.remove("selected");else element.classList.add("selected");
    },
    getText: function getText(behaviour) {
      var text = "";
      if (behaviour.hp != 0) text += behaviour.hp + " 💗 ";
      if (behaviour.xp != 0) text += behaviour.xp + " ✊ ";
      if (behaviour.gold != 0) text += behaviour.gold + " 💰 ";
      return text;
    }
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.selected[data-v-57e7ecfc] {\n  margin: 0;\n  background-color: lightskyblue;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/MassiveActions.vue?vue&type=template&id=57e7ecfc&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/MassiveActions.vue?vue&type=template&id=57e7ecfc&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
          _vm._v(_vm._s(_vm.trans.get("menu.massive")))
        ])
      ]),
      _vm._v(" "),
      _c(
        "section",
        {
          staticClass: "modal-card-body is-flex has-all-centered",
          staticStyle: { "align-items": "flex-start" }
        },
        [
          _c("div", { staticClass: "has-text-centered w-100" }, [
            _c("div", { staticClass: "select" }, [
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.behaviour,
                      expression: "behaviour"
                    }
                  ],
                  on: {
                    change: function($event) {
                      var $$selectedVal = Array.prototype.filter
                        .call($event.target.options, function(o) {
                          return o.selected
                        })
                        .map(function(o) {
                          var val = "_value" in o ? o._value : o.value
                          return val
                        })
                      _vm.behaviour = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    }
                  }
                },
                _vm._l(_vm.classroom.behaviours, function(behaviour) {
                  return _c(
                    "option",
                    {
                      key: behaviour.id,
                      class: {
                        "has-background-danger-light":
                          behaviour.hp + behaviour.xp + behaviour.gold < 0,
                        "has-background-success-light":
                          behaviour.hp + behaviour.xp + behaviour.gold >= 0
                      },
                      domProps: { value: behaviour.id }
                    },
                    [
                      _vm._v(
                        _vm._s(_vm.trans.get(behaviour.name)) +
                          " " +
                          _vm._s(_vm.getText(behaviour))
                      )
                    ]
                  )
                }),
                0
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "buttons mt-3 has-all-centered" }, [
              _c(
                "button",
                {
                  staticClass: "button is-info",
                  on: {
                    click: function($event) {
                      return _vm.changeAll(true)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fas fa-ballot-check" }),
                  _vm._v(" "),
                  _c("i", { staticClass: "far fa-users mr-2" }),
                  _vm._v(
                    " " +
                      _vm._s(_vm.trans.get("utils.select_all")) +
                      "\n        "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "button is-info",
                  on: {
                    click: function($event) {
                      return _vm.changeAll(false)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fas fa-eraser mr-2" }),
                  _vm._v(
                    " " +
                      _vm._s(_vm.trans.get("utils.remove_selection")) +
                      "\n        "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                { staticClass: "button is-info", on: { click: _vm.random } },
                [
                  _c("i", { staticClass: "fas fa-random mr-2" }),
                  _vm._v(
                    " " + _vm._s(_vm.trans.get("utils.random")) + "\n        "
                  )
                ]
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "columns is-multiline is-variable mt-3" },
              _vm._l(_vm.classroom.students, function(student) {
                return _c(
                  "div",
                  {
                    key: student.id,
                    staticClass:
                      "column p-3 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd",
                    class: { hidden: student.hidden == 1 }
                  },
                  [
                    student.hidden != 1
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "student-massive p-3 is-flex has-all-centered rounded",
                            attrs: { id: student.id },
                            on: {
                              click: function($event) {
                                return _vm.toggle(student.id)
                              }
                            }
                          },
                          [
                            _c("img", {
                              staticClass: "mr-3",
                              attrs: { src: student.avatar, width: "64px" }
                            }),
                            _vm._v(
                              "\n            " +
                                _vm._s(student.name) +
                                "\n          "
                            )
                          ]
                        )
                      : _vm._e()
                  ]
                )
              }),
              0
            )
          ])
        ]
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
                _vm.$parent.$parent.isMassiveModalActive = false
              }
            }
          },
          [_vm._v(_vm._s(_vm.trans.get("general.close")))]
        ),
        _vm._v(" "),
        _vm.behaviour
          ? _c(
              "button",
              {
                staticClass: "button is-link",
                attrs: { type: "button" },
                on: { click: _vm.accept }
              },
              [_vm._v("Accept")]
            )
          : _vm._e()
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/utils/MassiveActions.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/utils/MassiveActions.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _MassiveActions_vue_vue_type_template_id_57e7ecfc_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MassiveActions.vue?vue&type=template&id=57e7ecfc&scoped=true& */ "./resources/js/components/utils/MassiveActions.vue?vue&type=template&id=57e7ecfc&scoped=true&");
/* harmony import */ var _MassiveActions_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MassiveActions.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/MassiveActions.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _MassiveActions_vue_vue_type_style_index_0_id_57e7ecfc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css& */ "./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _MassiveActions_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MassiveActions_vue_vue_type_template_id_57e7ecfc_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _MassiveActions_vue_vue_type_template_id_57e7ecfc_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "57e7ecfc",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/MassiveActions.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/MassiveActions.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/utils/MassiveActions.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./MassiveActions.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/MassiveActions.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css& ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_style_index_0_id_57e7ecfc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/MassiveActions.vue?vue&type=style&index=0&id=57e7ecfc&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_style_index_0_id_57e7ecfc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_style_index_0_id_57e7ecfc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_style_index_0_id_57e7ecfc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_style_index_0_id_57e7ecfc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_style_index_0_id_57e7ecfc_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/utils/MassiveActions.vue?vue&type=template&id=57e7ecfc&scoped=true&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/utils/MassiveActions.vue?vue&type=template&id=57e7ecfc&scoped=true& ***!
  \*****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_template_id_57e7ecfc_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./MassiveActions.vue?vue&type=template&id=57e7ecfc&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/MassiveActions.vue?vue&type=template&id=57e7ecfc&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_template_id_57e7ecfc_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MassiveActions_vue_vue_type_template_id_57e7ecfc_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);