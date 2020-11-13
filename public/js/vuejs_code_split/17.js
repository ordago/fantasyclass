(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[17],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/CreateGroups.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/group/CreateGroups.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_drag_n_drop__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-drag-n-drop */ "./node_modules/vue-drag-n-drop/dist/vue-drag-n-drop.esm.js");
/* harmony import */ var _CustomCard_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CustomCard.vue */ "./resources/js/components/group/CustomCard.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["groups", "code", "students"],
  mounted: function mounted() {
    var _this = this;

    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var itemsDelete = [];
    this.groups.forEach(function (element) {
      var children = [];

      _this.students.forEach(function (std) {
        std.groups.forEach(function (group) {
          if (group.id == element.id) {
            children.push(std);
            itemsDelete.push(std.id);
          }
        });
      });

      _this.dropGroups.push({
        id: element.id,
        name: element.name,
        logo: element.logo,
        children: children
      });
    });
    itemsDelete.forEach(function (element) {
      var index = _this.$refs.dnditems.items.findIndex(function (item) {
        return item.id === element;
      });

      _this.$refs.dnditems.items.splice(index, 1);
    });
  },
  data: function data() {
    return {
      csrfToken: null,
      groupsNumber: 5,
      dropGroups: [],
      editGroups: false
    };
  },
  components: {
    DragDrop: vue_drag_n_drop__WEBPACK_IMPORTED_MODULE_0__["default"],
    CustomCard: _CustomCard_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  methods: {
    createGroups: function createGroups() {
      var groupsNumber = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      if (!groupsNumber) groupsNumber = this.groupsNumber;
      axios.post("/classroom/" + this.code + "/groups/create", {
        groupsNumber: groupsNumber
      }).then(function (response) {
        location.reload();
      });
    },
    save: function save() {
      var _this2 = this;

      axios.patch("/classroom/" + this.code + "/groups/students", {
        _method: "patch",
        dropGroups: this.dropGroups
      }).then(function (response) {
        _this2.$toast(_this2.trans.get("success_error.update_success"), {
          type: "success"
        });
      });
    },
    cancel: function cancel() {
      location.reload();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/CustomCard.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/group/CustomCard.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'StudentCard',
  props: ['data'],
  methods: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/CreateGroups.vue?vue&type=template&id=3e4705aa&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/group/CreateGroups.vue?vue&type=template&id=3e4705aa& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "content p-2" }, [
    !_vm.groups.length
      ? _c(
          "form",
          {
            attrs: { method: "post", action: "" },
            on: {
              submit: function($event) {
                $event.preventDefault()
                return _vm.createGroups()
              }
            }
          },
          [
            _c("input", {
              attrs: { type: "hidden", name: "_token" },
              domProps: { value: _vm.csrfToken }
            }),
            _vm._v(" "),
            _c("div", { staticClass: "p-4" }, [
              _c("div", [
                _c("span", { staticClass: "my-2" }, [
                  _vm._v(_vm._s(_vm.trans.get("groups.number_groups")))
                ]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.groupsNumber,
                      expression: "groupsNumber"
                    }
                  ],
                  staticClass: "input mt-3",
                  attrs: { type: "number" },
                  domProps: { value: _vm.groupsNumber },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.groupsNumber = $event.target.value
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("button", { staticClass: "button is-primary mt-3" }, [
                _vm._v(
                  "\n        " +
                    _vm._s(_vm.trans.get("groups.create")) +
                    "\n      "
                )
              ])
            ])
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.groups.length
      ? _c(
          "div",
          [
            _c(
              "button",
              {
                staticClass: "button is-link",
                on: {
                  click: function($event) {
                    return _vm.createGroups(1)
                  }
                }
              },
              [
                _vm._v(
                  "\n      " +
                    _vm._s(_vm.trans.get("groups.new_group")) +
                    "\n    "
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
                    _vm.editGroups = !_vm.editGroups
                  }
                }
              },
              [
                _vm._v(
                  "\n      " +
                    _vm._s(_vm.trans.get("groups.edit_groups")) +
                    "\n    "
                )
              ]
            ),
            _vm._v(" "),
            !_vm.editGroups
              ? _c("drag-drop", {
                  ref: "dnditems",
                  staticClass: "mt-3",
                  attrs: {
                    dropzones: _vm.dropGroups,
                    dropzonesTitle: "Groups",
                    originalData: _vm.students,
                    originalTitle: "Students",
                    inPlace: true
                  },
                  on: { save: _vm.save, cancel: _vm.cancel },
                  scopedSlots: _vm._u(
                    [
                      {
                        key: "dd-card",
                        fn: function(ref) {
                          var cardData = ref.cardData
                          return [
                            _c("custom-card", { attrs: { data: cardData } })
                          ]
                        }
                      }
                    ],
                    null,
                    false,
                    3993616045
                  )
                })
              : _c("div", [
                  _c(
                    "div",
                    { staticClass: "m-3 columns is-multiline is-variable" },
                    _vm._l(_vm.dropGroups, function(group) {
                      return _c(
                        "div",
                        {
                          key: group.id,
                          staticClass:
                            "column is-6-tablet is-12-mobile is-3-desktop"
                        },
                        [
                          _c("edit-group", {
                            attrs: { group: group, code: _vm.code }
                          })
                        ],
                        1
                      )
                    }),
                    0
                  )
                ])
          ],
          1
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/CustomCard.vue?vue&type=template&id=60fd699c&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/group/CustomCard.vue?vue&type=template&id=60fd699c& ***!
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
  return _c("div", { staticClass: "cc-card box m-2" }, [
    _c("h5", [_vm._v(_vm._s(_vm.data.name))])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/group/CreateGroups.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/group/CreateGroups.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateGroups_vue_vue_type_template_id_3e4705aa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateGroups.vue?vue&type=template&id=3e4705aa& */ "./resources/js/components/group/CreateGroups.vue?vue&type=template&id=3e4705aa&");
/* harmony import */ var _CreateGroups_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateGroups.vue?vue&type=script&lang=js& */ "./resources/js/components/group/CreateGroups.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreateGroups_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateGroups_vue_vue_type_template_id_3e4705aa___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateGroups_vue_vue_type_template_id_3e4705aa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/group/CreateGroups.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/group/CreateGroups.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/group/CreateGroups.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateGroups_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateGroups.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/CreateGroups.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateGroups_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/group/CreateGroups.vue?vue&type=template&id=3e4705aa&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/group/CreateGroups.vue?vue&type=template&id=3e4705aa& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateGroups_vue_vue_type_template_id_3e4705aa___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateGroups.vue?vue&type=template&id=3e4705aa& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/CreateGroups.vue?vue&type=template&id=3e4705aa&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateGroups_vue_vue_type_template_id_3e4705aa___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateGroups_vue_vue_type_template_id_3e4705aa___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/group/CustomCard.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/group/CustomCard.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CustomCard_vue_vue_type_template_id_60fd699c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CustomCard.vue?vue&type=template&id=60fd699c& */ "./resources/js/components/group/CustomCard.vue?vue&type=template&id=60fd699c&");
/* harmony import */ var _CustomCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CustomCard.vue?vue&type=script&lang=js& */ "./resources/js/components/group/CustomCard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CustomCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CustomCard_vue_vue_type_template_id_60fd699c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CustomCard_vue_vue_type_template_id_60fd699c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/group/CustomCard.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/group/CustomCard.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/group/CustomCard.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CustomCard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/CustomCard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/group/CustomCard.vue?vue&type=template&id=60fd699c&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/group/CustomCard.vue?vue&type=template&id=60fd699c& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomCard_vue_vue_type_template_id_60fd699c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CustomCard.vue?vue&type=template&id=60fd699c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/group/CustomCard.vue?vue&type=template&id=60fd699c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomCard_vue_vue_type_template_id_60fd699c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CustomCard_vue_vue_type_template_id_60fd699c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);