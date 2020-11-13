(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[30],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/card/ShowCard.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/card/ShowCard.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


var Buttons = function Buttons() {
  return __webpack_require__.e(/*! import() */ 28).then(__webpack_require__.bind(null, /*! ./Buttons.vue */ "./resources/js/components/card/Buttons.vue"));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["card", "admin", "properties", "code", "use", "student", "assign", "import"],
  components: {
    Buttons: Buttons
  },
  mounted: function mounted() {
    this.description = _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].styleText(this.trans.get(this.card.description));
  },
  data: function data() {
    return {
      description: ""
    };
  },
  methods: {
    share: function share() {
      var _this = this;

      this.$buefy.dialog.confirm({
        title: this.trans.get("cards.share"),
        message: this.trans.get("cards.share_message"),
        confirmText: this.trans.get("cards.share_btn"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-warning",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: function onConfirm() {
          axios.post("/card/share", {
            id: _this.card.id
          }).then(function (response) {
            _this.$toast(_this.trans.get("success_error.add_success"), {
              type: "success"
            });
          });
        }
      });
    },
    importCard: function importCard() {
      var _this2 = this;

      axios.post("/classroom/" + this.code + "/card/import", {
        id: this.card.id
      }).then(function (response) {
        _this2.$toast(_this2.trans.get("success_error.add_success"), {
          type: "success"
        });
      });
    },
    assignCard: function assignCard() {
      var _this3 = this;

      axios.post("/classroom/" + this.code + "/card/assign", {
        type: "student",
        id: this.assign,
        card: this.card.id
      }).then(function (response) {
        _this3.$toast(_this3.trans.get("success_error.add_success"), {
          type: "success"
        });
      });
    },
    markCard: function markCard(card, type) {
      var _this4 = this;

      var number = 0;
      if (this.$parent.$parent.$parent.student.level != null) number = this.$parent.$parent.$parent.student.level.number;
      if (type == 1 && this.card.min_lvl > number) return false;

      if (this.admin) {
        this.$buefy.dialog.confirm({
          title: this.trans.get("cards.use_title"),
          message: this.trans.get("cards.use_text_bypass"),
          confirmText: this.trans.get("cards.use_confirm"),
          cancelText: this.trans.get("general.cancel"),
          type: "is-warning",
          hasIcon: true,
          icon: "times-circle",
          iconPack: "fa",
          ariaRole: "alertdialog",
          ariaModal: true,
          onConfirm: function onConfirm() {
            axios.post("/classroom/card/usedelete/bypass/" + _this4.card.id, {
              type: type,
              student: _this4.student.id
            }).then(function (response) {
              // destroy the vue listeners, etc
              _this4.$destroy(); // remove the element from the DOM


              _this4.$el.parentNode.removeChild(_this4.$el);

              var gold = response.data.gold;
              if (gold) _this4.$toast(response.data.message, {
                type: "default",
                timeout: 0,
                closeButton: Buttons
              });else _this4.$toast(response.data.message, {
                type: response.data.type
              });
            });
          }
        });
      } else {
        this.$buefy.dialog.confirm({
          title: this.trans.get("cards.use_title"),
          message: this.trans.get("cards.use_text"),
          confirmText: this.trans.get("cards.use_confirm"),
          cancelText: this.trans.get("general.cancel"),
          type: "is-warning",
          hasIcon: true,
          icon: "times-circle",
          iconPack: "fa",
          ariaRole: "alertdialog",
          ariaModal: true,
          onConfirm: function onConfirm() {
            axios.post("/classroom/" + _this4.code + "/card/mark/" + _this4.card.id, {
              type: type,
              student: _this4.student.id
            }).then(function (response) {
              _this4.$toast(response.data.message, {
                type: response.data.type
              });

              card.pivot.marked = type;

              _this4.$forceUpdate();
            });
          }
        });
      }
    },
    getMessage: function getMessage(marked) {
      if (this.checkLevel()) return this.trans.get("students.card_level");else if (marked == 1) {
        return this.trans.get("students.card_marked");
      } else return this.trans.get("students.card_use");
    },
    checkLevel: function checkLevel() {
      var number = 0;
      if (this.$parent.$parent.$parent.student.level != null) number = this.$parent.$parent.$parent.student.level.number;
      return this.card.min_lvl > number ? true : false;
    },
    confirmDelete: function confirmDelete() {
      var _this5 = this;

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
          axios["delete"]("/classroom/card/" + _this5.card.id).then(function (response) {
            if (response.data === 1) {
              _this5.$el.parentNode.removeChild(_this5.$el);
            }
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/card/ShowCard.vue?vue&type=template&id=e270749e&":
/*!****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/card/ShowCard.vue?vue&type=template&id=e270749e& ***!
  \****************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "m-2" }, [
    this.use
      ? _c("div", { staticStyle: { "text-align": "center" } }, [
          _c(
            "button",
            {
              directives: [{ name: "tippy", rawName: "v-tippy" }],
              staticClass: "button is-success",
              class: {
                disabled: _vm.checkLevel(),
                "has-background-dark": _vm.card.pivot.marked == 1
              },
              attrs: {
                type: "submit",
                content: _vm.getMessage(_vm.card.pivot.marked)
              },
              on: {
                click: function($event) {
                  return _vm.markCard(_vm.card, 1)
                }
              }
            },
            [
              _c("i", { staticClass: "fas fa-check" }),
              _vm._v(" " + _vm._s(_vm.trans.get("cards.use")) + "\n    ")
            ]
          ),
          _vm._v(" "),
          _vm.card.xp >= 0 && _vm.card.gold >= 0 && _vm.card.hp >= 0
            ? _c(
                "button",
                {
                  staticClass: "button is-danger",
                  class: { "has-background-dark": _vm.card.pivot.marked == 2 },
                  attrs: { type: "submit" },
                  on: {
                    click: function($event) {
                      return _vm.markCard(_vm.card, 2)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fas fa-trash-alt" }),
                  _vm._v(" " + _vm._s(_vm.trans.get("cards.delete")) + "\n    ")
                ]
              )
            : _vm._e()
        ])
      : _vm._e(),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "cardContainer cardFunction",
        style: "background-color:" + _vm.card.background + ";",
        attrs: { "data-id": "1", "group-id": "" }
      },
      [
        _vm.card.min_lvl
          ? _c("div", { staticClass: "lvl-top-left" }, [
              _c("img", {
                staticClass: "levelCard",
                attrs: { src: "/img/cardgen/lvl.png" }
              }),
              _vm._v(" "),
              _c("span", { staticClass: "numberLvl" }, [
                _vm._v(_vm._s(_vm.card.min_lvl))
              ])
            ])
          : _vm._e(),
        _vm._v(" "),
        !_vm.card.fullscreen
          ? _c("img", {
              staticClass: "typeCard",
              attrs: { src: "/img/cardgen/type_" + _vm.card.type + ".png" }
            })
          : _vm._e(),
        _vm._v(" "),
        _c("div", [
          _c("h3", { staticClass: "title-cards textShadow" }, [
            _c("svg", { attrs: { viewBox: "0 0 500 500" } }, [
              _c("path", {
                attrs: {
                  id: "curve",
                  d:
                    "m 3.2938789,150.87387 c 5.55773,-3.11588 91.0078161,-49.44517 248.1526411,-48.83221 154.64384,0.61296 237.31506,46.12499 243.28962,49.54732"
                }
              }),
              _vm._v(" "),
              _c("text", { attrs: { width: "250px" } }, [
                _c(
                  "textPath",
                  {
                    attrs: {
                      "xlink:href": "#curve",
                      startOffset: "50%",
                      "text-anchor": "middle"
                    }
                  },
                  [
                    _vm._v(
                      "\n              " +
                        _vm._s(_vm.trans.get(_vm.card.title)) +
                        "\n            "
                    )
                  ]
                )
              ])
            ])
          ])
        ]),
        _vm._v(" "),
        !_vm.card.fullscreen
          ? _c("img", {
              staticClass: "ribbon",
              attrs: { src: "/img/cardgen/ribbon-" + _vm.card.type + ".png" }
            })
          : _vm._e(),
        _vm._v(" "),
        !_vm.card.special && !_vm.card.fullscreen
          ? _c("img", {
              staticClass: "background",
              attrs: {
                src: "/img/cardgen/only_back_" + _vm.card.type_bg + ".png"
              }
            })
          : _vm._e(),
        _vm._v(" "),
        _vm.card.special && !_vm.card.fullscreen
          ? _c("img", {
              staticClass: "background",
              attrs: {
                src: "/img/cardgen/only_back_" + _vm.card.type_bg + "_gold.png"
              }
            })
          : _vm._e(),
        _vm._v(" "),
        _c("div", {
          staticClass: "content-cards text_shadow",
          domProps: { innerHTML: _vm._s(_vm.description) }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "hiding-parent" }, [
          _c("img", {
            staticClass: "back",
            style:
              "margin-left: " +
              _vm.card.margin_left +
              "px;margin-top:" +
              _vm.card.margin_top +
              "px;width:" +
              _vm.card.width +
              "px;border-radius:" +
              _vm.card.radius +
              "px",
            attrs: { src: _vm.card.src }
          })
        ]),
        _vm._v(" "),
        _vm.card.xp != 0
          ? _c("div", { staticClass: "xp_modify modifiers" }, [
              _c("img", { attrs: { src: "/img/cardgen/xp_modify.png" } }),
              _vm._v(" "),
              _c("span", [_vm._v(_vm._s(_vm.card.xp))])
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.card.hp != 0
          ? _c("div", { staticClass: "hp_modify modifiers" }, [
              _c("img", { attrs: { src: "/img/cardgen/hp_modify.png" } }),
              _vm._v(" "),
              _c("span", [_vm._v(_vm._s(_vm.card.hp))])
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.card.gold != 0
          ? _c("div", { staticClass: "gold_modify modifiers" }, [
              _c("img", { attrs: { src: "/img/cardgen/gold_modify.png" } }),
              _vm._v(" "),
              _c("span", [_vm._v(_vm._s(_vm.card.gold))])
            ])
          : _vm._e()
      ]
    ),
    _vm._v(" "),
    this.admin && this.assign
      ? _c("div", { staticStyle: { "text-align": "center" } }, [
          _c(
            "button",
            { staticClass: "button is-dark", on: { click: _vm.assignCard } },
            [
              _c("i", { staticClass: "fas fa-arrow-up" }),
              _vm._v(" " + _vm._s(_vm.trans.get("general.assign")) + "\n    ")
            ]
          )
        ])
      : _vm._e(),
    _vm._v(" "),
    this.admin && this.import
      ? _c("div", { staticStyle: { "text-align": "center" } }, [
          _c(
            "button",
            { staticClass: "button is-success", on: { click: _vm.importCard } },
            [
              _c("i", { staticClass: "fas fa-arrow-up" }),
              _vm._v(" " + _vm._s(_vm.trans.get("general.import")) + "\n    ")
            ]
          )
        ])
      : _vm._e(),
    _vm._v(" "),
    this.admin && this.properties && !this.assign
      ? _c("div", { staticStyle: { "text-align": "center" } }, [
          _c(
            "a",
            {
              directives: [{ name: "tippy", rawName: "v-tippy" }],
              staticClass: "button is-dark",
              attrs: {
                href: "/classroom/" + _vm.code + "/cards/" + _vm.card.id,
                type: "submit",
                content: _vm.trans.get("general.edit")
              }
            },
            [_c("i", { staticClass: "fas fa-edit" })]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              directives: [{ name: "tippy", rawName: "v-tippy" }],
              staticClass: "button is-danger",
              attrs: {
                type: "submit",
                content: _vm.trans.get("general.delete")
              },
              on: { click: _vm.confirmDelete }
            },
            [_c("i", { staticClass: "fas fa-trash-alt" })]
          ),
          _vm._v(" "),
          _vm.card.own
            ? _c(
                "button",
                {
                  directives: [{ name: "tippy", rawName: "v-tippy" }],
                  staticClass: "button is-primary",
                  attrs: {
                    type: "submit",
                    content: _vm.trans.get("cards.share")
                  },
                  on: { click: _vm.share }
                },
                [_c("i", { staticClass: "fas fa-share-alt" })]
              )
            : _vm._e()
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/card/ShowCard.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/card/ShowCard.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowCard_vue_vue_type_template_id_e270749e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowCard.vue?vue&type=template&id=e270749e& */ "./resources/js/components/card/ShowCard.vue?vue&type=template&id=e270749e&");
/* harmony import */ var _ShowCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowCard.vue?vue&type=script&lang=js& */ "./resources/js/components/card/ShowCard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowCard_vue_vue_type_template_id_e270749e___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowCard_vue_vue_type_template_id_e270749e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/card/ShowCard.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/card/ShowCard.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/components/card/ShowCard.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowCard.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/card/ShowCard.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowCard_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/card/ShowCard.vue?vue&type=template&id=e270749e&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/card/ShowCard.vue?vue&type=template&id=e270749e& ***!
  \**********************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowCard_vue_vue_type_template_id_e270749e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowCard.vue?vue&type=template&id=e270749e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/card/ShowCard.vue?vue&type=template&id=e270749e&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowCard_vue_vue_type_template_id_e270749e___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowCard_vue_vue_type_template_id_e270749e___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);