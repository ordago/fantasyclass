(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[25],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/VolumeMeter.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/VolumeMeter.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["code"],
  created: function created() {
    this.audio = new Audio("/sound/alarm.mp3");
  },
  data: function data() {
    return {
      audioContext: null,
      meter: null,
      canvasContext: null,
      width: 400,
      height: 50,
      rafID: null,
      sttoped: true,
      tolerance: 5,
      prevTime: 0,
      audio: null,
      alarmCount: 0,
      countHp: 0,
      countXp: 0,
      countGold: 0,
      hp: 1,
      xp: 5,
      gold: 10
    };
  },
  computed: {},
  mounted: function mounted() {},
  methods: {
    accept: function accept() {
      var _this = this;

      axios.post("/classroom/" + this.code + "/utils/meter", {
        gold: this.gold * this.alarmCount * this.countGold * -1,
        hp: this.hp * this.alarmCount * this.countHp * -1,
        xp: this.xp * this.alarmCount * this.countXp * -1
      }).then(function (reponse) {
        location.href = '/classroom/' + _this.code;
      });
    },
    deleteLog: function deleteLog() {
      this.alarmCount--;
    },
    onMicrophoneDenied: function onMicrophoneDenied() {
      alert("It's mandatory to grant microphone access");
    },
    onLevelChange: function onLevelChange(time) {
      // clear the background
      this.canvasContext.clearRect(0, 0, this.width, this.height); // check if we're currently clipping

      if (this.meter.checkClipping()) this.canvasContext.fillStyle = "red";else this.canvasContext.fillStyle = "green";

      if (time - this.prevTime > 1500 && !this.stopped) {
        if (this.meter.volume > this.tolerance / 20) {
          this.audio.play();
          this.alarmCount++;
        }

        this.prevTime = time;
      } // draw a bar based on the current volume


      this.canvasContext.fillRect(0, 0, this.meter.volume * this.width * 1.4, this.height); // set up the next visual callback

      this.rafID = window.requestAnimationFrame(this.onLevelChange);
    },
    onMicrophoneGranted: function onMicrophoneGranted(stream) {
      // Create an AudioNode from the stream.
      var mediaStreamSource = this.audioContext.createMediaStreamSource(stream); // Create a new volume meter and connect it.

      this.meter = _utils_js__WEBPACK_IMPORTED_MODULE_0__["default"].createAudioMeter(this.audioContext);
      mediaStreamSource.connect(this.meter); // kick off the visual updating

      this.onLevelChange();
    },
    start: function start() {
      this.stopped = false; // grab our canvas

      this.canvasContext = this.$refs.meter.getContext("2d"); // monkeypatch Web Audio

      window.AudioContext = window.AudioContext || window.webkitAudioContext; // grab an audio context

      this.audioContext = new AudioContext();
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

      if (typeof navigator.mediaDevices.getUserMedia === "undefined") {
        navigator.getUserMedia({
          audio: true
        }, this.onMicrophoneGranted, this.onMicrophoneDenied);
      } else {
        navigator.mediaDevices.getUserMedia({
          audio: true
        }).then(this.onMicrophoneGranted);
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n#meter {\n  padding: 20px;\n  background-color: rgba(255, 255, 255, 0.8);\n  border-radius: 10px;\n  clear: both;\n}\n.propertyMeter {\n  display: inline-block;\n  width: 40%;\n}\n.itemLog {\n  padding: 20px;\n  background-color: rgba(255, 255, 255, 0.8);\n  border: 1px solid #555;\n  border-radius: 5px;\n}\n.bootstrapInlineForm {\n  width: 60%;\n}\n.sensitivity {\n  margin-top: 35px;\n  position: relative;\n  padding-bottom: 15px;\n}\n.sensitivity .left {\n  padding: 4px;\n  background-color: white;\n  position: absolute;\n  top: -21px;\n  left: 0;\n  border-radius: 4px;\n}\n.sensitivity .center {\n  padding: 4px;\n  background-color: white;\n  position: absolute;\n  top: -21px;\n  left: 50%;\n  margin-left: -20px;\n  border-radius: 4px;\n}\n.sensitivity .right {\n  padding: 4px;\n  background-color: white;\n  position: absolute;\n  top: -21px;\n  right: 0;\n  border-radius: 4px;\n}\n.itemLog {\n  position: relative;\n}\n.delLog {\n  display: flex;\n  align-items: center;\n  align-content: center;\n  position: absolute;\n  top: 0;\n  right: 0;\n  padding: 20px;\n  color: white;\n  height: 100%;\n  cursor: pointer;\n}\n#info {\n  display: flex;\n  align-items: center;\n  align-content: center;\n}\n.acceptDestiny {\n  cursor: pointer;\n}\n@media screen and (max-width: 700px) {\n.flexC {\n    display: block;\n}\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./VolumeMeter.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/VolumeMeter.vue?vue&type=template&id=649cd4d6&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/VolumeMeter.vue?vue&type=template&id=649cd4d6& ***!
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
  return _c("div", { staticClass: "p-2" }, [
    _c("div", [
      _c("div", [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "columns" }, [
          _c("div", { staticClass: "column" }, [
            _c(
              "div",
              { staticClass: "propertyMeter p-3" },
              [
                _c(
                  "b-switch",
                  {
                    attrs: { "true-value": "1", "false-value": "0" },
                    model: {
                      value: _vm.countGold,
                      callback: function($$v) {
                        _vm.countGold = $$v
                      },
                      expression: "countGold"
                    }
                  },
                  [_c("i", { staticClass: "fas fa-coins colored" })]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.gold,
                      expression: "gold"
                    }
                  ],
                  staticClass: "input",
                  attrs: { type: "number" },
                  domProps: { value: _vm.gold },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.gold = $event.target.value
                    }
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "propertyMeter p-3" },
              [
                _c(
                  "b-switch",
                  {
                    attrs: { "true-value": "1", "false-value": "0" },
                    model: {
                      value: _vm.countXp,
                      callback: function($$v) {
                        _vm.countXp = $$v
                      },
                      expression: "countXp"
                    }
                  },
                  [_c("i", { staticClass: "fas fa-fist-raised colored" })]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.xp,
                      expression: "xp"
                    }
                  ],
                  staticClass: "input",
                  attrs: { type: "number" },
                  domProps: { value: _vm.xp },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.xp = $event.target.value
                    }
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "propertyMeter p-3" },
              [
                _c(
                  "b-switch",
                  {
                    attrs: { "true-value": "1", "false-value": "0" },
                    model: {
                      value: _vm.countHp,
                      callback: function($$v) {
                        _vm.countHp = $$v
                      },
                      expression: "countHp"
                    }
                  },
                  [_c("i", { staticClass: "fas fa-heart colored" })]
                ),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.hp,
                      expression: "hp"
                    }
                  ],
                  staticClass: "input",
                  attrs: { type: "number" },
                  domProps: { value: _vm.hp },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.hp = $event.target.value
                    }
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "column" }, [
            _c("div", { attrs: { id: "info" } }, [
              _c("span", { staticClass: "tag tag fa-2x m-2 is-size-5 p-4" }, [
                _c("span", [_vm._v(_vm._s(_vm.alarmCount))]),
                _vm._v(" "),
                _c("i", { staticClass: "fas fa-siren-on colored" })
              ]),
              _vm._v(" "),
              _c(
                "span",
                { staticClass: "tag tag is-warning fa-2x m-2 is-size-5 p-4" },
                [
                  _c("span", [
                    _vm._v(
                      _vm._s(_vm.gold * _vm.alarmCount * _vm.countGold * -1)
                    )
                  ]),
                  _vm._v(" "),
                  _c("i", { staticClass: "fas fa-coins colored" })
                ]
              ),
              _vm._v(" "),
              _c(
                "span",
                { staticClass: "tag tag is-dark fa-2x m-2 is-size-5 p-4" },
                [
                  _c("span", [
                    _vm._v(_vm._s(_vm.xp * _vm.alarmCount * _vm.countXp * -1))
                  ]),
                  _vm._v(" "),
                  _c("i", { staticClass: "fas fa-fist-raised colored" })
                ]
              ),
              _vm._v(" "),
              _c(
                "span",
                { staticClass: "tag tag is-danger fa-2x m-2 is-size-5 p-4" },
                [
                  _c("span", [
                    _vm._v(_vm._s(_vm.hp * _vm.alarmCount * _vm.countHp * -1))
                  ]),
                  _vm._v(" "),
                  _c("i", { staticClass: "fas fa-heart colored" })
                ]
              ),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "button is-size-6 acceptDestiny ml-2",
                  staticStyle: { "margin-top": "0!important" },
                  on: { click: _vm.accept }
                },
                [
                  _c("i", { staticClass: "fas fa-feather-alt" }),
                  _vm._v(" Accept\n            ")
                ]
              )
            ])
          ])
        ]),
        _vm._v(" "),
        _c("br"),
        _vm._v(" "),
        _vm._m(1),
        _vm._v(" "),
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.tolerance,
              expression: "tolerance"
            }
          ],
          staticStyle: { width: "100%" },
          attrs: { type: "range", min: "0", id: "tolerance", max: "10" },
          domProps: { value: _vm.tolerance },
          on: {
            __r: function($event) {
              _vm.tolerance = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _c("br"),
        _vm._v(" "),
        _c("canvas", {
          ref: "meter",
          staticClass: "mt-3",
          staticStyle: { width: "100%" },
          attrs: { id: "meter", height: "30" }
        }),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "button is-primary mt-3 start",
            on: { click: _vm.start }
          },
          [
            _c("i", { staticClass: "fas fa-play mr-2" }),
            _vm._v(" Start\n      ")
          ]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "button is-dark",
            on: {
              click: function($event) {
                _vm.stopped = true
              }
            }
          },
          [
            _c("i", { staticClass: "fas fa-stop mr-2" }),
            _vm._v(" Stop\n      ")
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        { attrs: { id: "log" } },
        _vm._l(_vm.alarmCount, function(index) {
          return _c("div", { key: index, staticClass: "p-4 m-3 itemLog" }, [
            _c("span", { staticClass: "tag is-dark" }, [_vm._v(_vm._s(index))]),
            _vm._v(" Ruido detectado\n        "),
            _c(
              "div",
              {
                staticClass: "has-background-danger p-4 delLog",
                on: { click: _vm.deleteLog }
              },
              [_c("i", { staticClass: "fas fa-trash" })]
            )
          ])
        }),
        0
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "rounded has-background-warning p-4 mb-3" },
      [
        _c("strong", [
          _c("i", { staticClass: "fas fa-flask" }),
          _vm._v(" Función experimental\n        ")
        ]),
        _vm._v(" "),
        _c("i", { staticClass: "fas fa-info-square" }),
        _vm._v(
          " Haz start y prueba los valores de tolerancia antes de activar las penalizaciones.\n      "
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "sensitivity" }, [
      _c("i", { staticClass: "fal fa-tachometer-slowest fa-2x left" }),
      _vm._v(" "),
      _c("i", { staticClass: "fal fa-tachometer-average fa-2x center" }),
      _vm._v(" "),
      _c("i", { staticClass: "fal fa-tachometer-fastest fa-2x right" })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/utils/VolumeMeter.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/utils/VolumeMeter.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _VolumeMeter_vue_vue_type_template_id_649cd4d6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./VolumeMeter.vue?vue&type=template&id=649cd4d6& */ "./resources/js/components/utils/VolumeMeter.vue?vue&type=template&id=649cd4d6&");
/* harmony import */ var _VolumeMeter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./VolumeMeter.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/VolumeMeter.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _VolumeMeter_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./VolumeMeter.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _VolumeMeter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _VolumeMeter_vue_vue_type_template_id_649cd4d6___WEBPACK_IMPORTED_MODULE_0__["render"],
  _VolumeMeter_vue_vue_type_template_id_649cd4d6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/VolumeMeter.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/VolumeMeter.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/utils/VolumeMeter.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./VolumeMeter.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/VolumeMeter.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css& ***!
  \****************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./VolumeMeter.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/VolumeMeter.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/utils/VolumeMeter.vue?vue&type=template&id=649cd4d6&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/utils/VolumeMeter.vue?vue&type=template&id=649cd4d6& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_template_id_649cd4d6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./VolumeMeter.vue?vue&type=template&id=649cd4d6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/VolumeMeter.vue?vue&type=template&id=649cd4d6&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_template_id_649cd4d6___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_VolumeMeter_vue_vue_type_template_id_649cd4d6___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);