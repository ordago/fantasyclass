(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[22],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/CountDown.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/CountDown.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
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
var FULL_DASH_ARRAY = 283;
var WARNING_THRESHOLD = 10;
var ALERT_THRESHOLD = 5;
var COLOR_CODES = {
  info: {
    color: "green"
  },
  warning: {
    color: "orange",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "red",
    threshold: ALERT_THRESHOLD
  }
};
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['starttime'],
  created: function created() {
    if (this.starttime) {
      this.timeConfigured = this.starttime;
      this.startTimer();
    }
  },
  data: function data() {
    return {
      timeConfigured: new Date(1, 1, 1, 0, 10, 0),
      timePassed: 0,
      timerInterval: null,
      time: 20,
      pause: true
    };
  },
  computed: {
    circleDasharray: function circleDasharray() {
      return "".concat((this.timeFraction * FULL_DASH_ARRAY).toFixed(0), " 283");
    },
    formattedTimeLeft: function formattedTimeLeft() {
      var timeLeft = this.timeLeft;
      var minutes = Math.floor(timeLeft / 60);
      var seconds = timeLeft % 60;

      if (seconds < 10) {
        seconds = "0".concat(seconds);
      }

      return "".concat(minutes, ":").concat(seconds);
    },
    timeLeft: function timeLeft() {
      return this.time - this.timePassed;
    },
    timeFraction: function timeFraction() {
      var rawTimeFraction = this.timeLeft / this.time;
      return rawTimeFraction - 1 / this.time * (1 - rawTimeFraction);
    },
    remainingPathColor: function remainingPathColor() {
      var alert = COLOR_CODES.alert,
          warning = COLOR_CODES.warning,
          info = COLOR_CODES.info;

      if (this.timeLeft <= alert.threshold) {
        return alert.color;
      } else if (this.timeLeft <= warning.threshold) {
        return warning.color;
      } else {
        return info.color;
      }
    }
  },
  watch: {
    timeLeft: function timeLeft(newValue) {
      if (newValue === 0) {
        this.onTimesUp();
      }
    }
  },
  mounted: function mounted() {},
  methods: {
    calculateSeconds: function calculateSeconds(info) {
      var seconds = 0;
      if (this.timeConfigured) seconds = this.timeConfigured.getHours() * 60 * 60 + this.timeConfigured.getMinutes() * 60 + this.timeConfigured.getSeconds();
      this.time = seconds;
    },
    onTimesUp: function onTimesUp() {
      clearInterval(this.timerInterval);
    },
    pauseTimer: function pauseTimer() {
      this.pause = !this.pause;
      clearInterval(this.timerInterval);
    },
    resetTimer: function resetTimer() {
      this.timePassed = 0;
      clearInterval(this.timerInterval);
    },
    startTimer: function startTimer() {
      var _this = this;

      this.pause = !this.pause;
      this.timerInterval = setInterval(function () {
        return _this.timePassed += 1;
      }, 1000);
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".base-timer[data-v-4eeb8d50] {\n  position: relative;\n  width: 300px;\n  height: 300px;\n}\n.base-timer__svg[data-v-4eeb8d50] {\n  transform: scaleX(-1);\n}\n.base-timer__circle[data-v-4eeb8d50] {\n  fill: none;\n  stroke: none;\n}\n.base-timer__path-elapsed[data-v-4eeb8d50] {\n  stroke-width: 7px;\n  stroke: grey;\n}\n.base-timer__path-remaining[data-v-4eeb8d50] {\n  stroke-width: 7px;\n  stroke-linecap: round;\n  transform: rotate(90deg);\n  transform-origin: center;\n  transition: 1s linear all;\n  fill-rule: nonzero;\n  stroke: currentColor;\n}\n.base-timer__path-remaining.green[data-v-4eeb8d50] {\n  color: #41b883;\n}\n.base-timer__path-remaining.orange[data-v-4eeb8d50] {\n  color: orange;\n}\n.base-timer__path-remaining.red[data-v-4eeb8d50] {\n  color: red;\n}\n.base-timer__label[data-v-4eeb8d50] {\n  position: absolute;\n  width: 300px;\n  height: 300px;\n  top: 0;\n  display: flex;\n  align-items: center;\n  justify-content: center;\n  font-size: 48px;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/CountDown.vue?vue&type=template&id=4eeb8d50&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/CountDown.vue?vue&type=template&id=4eeb8d50&scoped=true& ***!
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
  return _c("div", { staticClass: "base-timer" }, [
    _c(
      "svg",
      {
        staticClass: "base-timer__svg",
        attrs: { viewBox: "0 0 100 100", xmlns: "http://www.w3.org/2000/svg" }
      },
      [
        _c("g", { staticClass: "base-timer__circle" }, [
          _c("circle", {
            staticClass: "base-timer__path-elapsed",
            attrs: { cx: "50", cy: "50", r: "45" }
          }),
          _vm._v(" "),
          _c("path", {
            staticClass: "base-timer__path-remaining",
            class: _vm.remainingPathColor,
            attrs: {
              "stroke-dasharray": _vm.circleDasharray,
              d:
                "\n          M 50, 50\n          m -45, 0\n          a 45,45 0 1,0 90,0\n          a 45,45 0 1,0 -90,0\n        "
            }
          })
        ])
      ]
    ),
    _vm._v(" "),
    _c("span", { staticClass: "base-timer__label" }, [
      _vm._v(_vm._s(_vm.formattedTimeLeft))
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "has-text-centered" },
      [
        _c("b-timepicker", {
          attrs: {
            "enable-seconds": "",
            inline: "",
            input: _vm.calculateSeconds()
          },
          model: {
            value: _vm.timeConfigured,
            callback: function($$v) {
              _vm.timeConfigured = $$v
            },
            expression: "timeConfigured"
          }
        }),
        _vm._v(" "),
        _vm.pause
          ? _c(
              "button",
              {
                staticClass: "button mt-2 is-success",
                on: { click: _vm.startTimer }
              },
              [_vm._v("Start")]
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.pause && _vm.timePassed
          ? _c(
              "button",
              {
                staticClass: "button mt-2 is-danger",
                on: { click: _vm.resetTimer }
              },
              [_vm._v("Reset")]
            )
          : _vm._e(),
        _vm._v(" "),
        !_vm.pause
          ? _c(
              "button",
              {
                staticClass: "button mt-2 is-info",
                on: { click: _vm.pauseTimer }
              },
              [_vm._v("Pause")]
            )
          : _vm._e()
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/utils/CountDown.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/utils/CountDown.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CountDown_vue_vue_type_template_id_4eeb8d50_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CountDown.vue?vue&type=template&id=4eeb8d50&scoped=true& */ "./resources/js/components/utils/CountDown.vue?vue&type=template&id=4eeb8d50&scoped=true&");
/* harmony import */ var _CountDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CountDown.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/CountDown.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _CountDown_vue_vue_type_style_index_0_id_4eeb8d50_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss& */ "./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _CountDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CountDown_vue_vue_type_template_id_4eeb8d50_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CountDown_vue_vue_type_template_id_4eeb8d50_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "4eeb8d50",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/CountDown.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/CountDown.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/utils/CountDown.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./CountDown.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/CountDown.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss& ***!
  \***************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_style_index_0_id_4eeb8d50_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/CountDown.vue?vue&type=style&index=0&id=4eeb8d50&scoped=true&lang=scss&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_style_index_0_id_4eeb8d50_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_style_index_0_id_4eeb8d50_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_style_index_0_id_4eeb8d50_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_style_index_0_id_4eeb8d50_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_style_index_0_id_4eeb8d50_scoped_true_lang_scss___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/utils/CountDown.vue?vue&type=template&id=4eeb8d50&scoped=true&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/utils/CountDown.vue?vue&type=template&id=4eeb8d50&scoped=true& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_template_id_4eeb8d50_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./CountDown.vue?vue&type=template&id=4eeb8d50&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/CountDown.vue?vue&type=template&id=4eeb8d50&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_template_id_4eeb8d50_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CountDown_vue_vue_type_template_id_4eeb8d50_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);