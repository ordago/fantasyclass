(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[7],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/student/ShowStudentInfo.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/student/ShowStudentInfo.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../utils.js */ "./resources/js/utils.js");
/* harmony import */ var vue_apexcharts__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-apexcharts */ "./node_modules/vue-apexcharts/dist/vue-apexcharts.js");
/* harmony import */ var vue_apexcharts__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_apexcharts__WEBPACK_IMPORTED_MODULE_2__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

 // Download excel
// import JsonExcel from "vue-json-excel";
// Vue.component("download-excel", JsonExcel);
// Charts


vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_apexcharts__WEBPACK_IMPORTED_MODULE_2___default.a);
vue__WEBPACK_IMPORTED_MODULE_0___default.a.component("apexchart", vue_apexcharts__WEBPACK_IMPORTED_MODULE_2___default.a);
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["student", "classroom", "chart", "admin", "items", "shop", "challenges", "cards", "evaluation", "settings"],
  mounted: function mounted() {
    this.behaviours = this.student.behaviours;

    if (!this.admin) {
      this.activeTab = 1;
      this.updateEmpty();
      this.itemsJson = JSON.parse(this.shop.items);
      this.eq1Json = JSON.parse(this.shop.eq1);
      this.eq2Json = JSON.parse(this.shop.eq2);
      this.eq3Json = JSON.parse(this.shop.eq3);
    }
  },
  data: function data() {
    return {
      activeTab: 0,
      dateStart: null,
      dateEnd: null,
      series: [],
      labels: [],
      colors: [],
      update: 0,
      inventoryRemaining: 0,
      itemsJson: null,
      eq1Json: null,
      eq2Json: null,
      eq3Json: null,
      forceReload: 0,
      prevImage: null,
      image: null,
      behaviours: null
    };
  },
  methods: {
    calculate: function calculate(item) {
      console.log(item);
      var mult = 1;

      switch (item.offset) {
        case 1:
          mult = this.shop.multiplier1;
          break;

        case 2:
          mult = this.shop.multiplier2;
          break;

        case 3:
          mult = this.shop.multiplier3;
          break;
      }

      return Math.round(item.price * mult);
    },
    deleteStudent: function deleteStudent() {
      var _this = this;

      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: function onConfirm() {
          axios["delete"]("/classroom/" + _this.classroom.code + "/student/" + _this.student.id, {
            _method: "delete"
          }).then(function (response) {
            location.href = "/classroom/" + _this.classroom.code;
          });
        }
      });
    },
    updateName: function updateName() {
      var _this2 = this;

      if (this.student.name.length >= 4) {
        axios.post("/classroom/" + this.classroom.code + "/student/name", {
          id: this.student.id,
          name: this.student.name
        }).then(function (response) {
          _this2.$toasted.show(_this2.trans.get("success_error.update_success"), {
            position: "top-center",
            duration: 3000,
            iconPack: "fontawesome",
            icon: "check",
            type: "success"
          });

          _this2.$forceUpdate();
        });
      } else {
        this.$toasted.show(this.trans.get("success_error.min_name"), {
          position: "top-center",
          duration: 3000,
          iconPack: "fontawesome",
          icon: "times",
          type: "error"
        });
      }
    },
    confirmDelete: function confirmDelete(type, row, date) {
      var _this3 = this;

      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: function onConfirm() {
          axios.post("/classroom/student/" + type, {
            row: row,
            date: date,
            student: _this3.student.id,
            _method: "delete"
          }).then(function (response) {
            if (type == "behaviour") {
              _this3.behaviours = response.data;
              _this3.student.updated_at = new Date();

              _this3.forceRerender();
            } else {
              location.reload();
            }
          });
        }
      });
    },
    toggle: function toggle(id) {
      var _this4 = this;

      axios.post("/classroom/student/badge", {
        badge: id,
        student: this.student.id
      }).then(function (response) {
        _this4.student.badges = response.data.badges;
        _this4.student.hp = response.data.hp;
        _this4.student.xp = response.data.xp;
        _this4.student.gold = response.data.gold;

        _this4.$forceUpdate();
      });
    },
    findInStudent: function findInStudent(id) {
      var index = this.student.badges.findIndex(function (badge, i) {
        return badge.id === id;
      });
      if (index >= 0) return false;
      return true;
    },
    updateEmpty: function updateEmpty() {
      var line = 6;

      if (this.student.items.length >= 6) {
        line = 12;
      }

      this.inventoryRemaining = line - this.student.items.length;
    },
    confirmChangeClass: function confirmChangeClass(subclass) {
      var _this5 = this;

      this.$buefy.dialog.confirm({
        title: "Class change",
        message: "Basic equipment will be assigned, this action can't be undone.",
        confirmText: "Change class",
        type: "is-warning",
        iconPack: "fa",
        hasIcon: true,
        onConfirm: function onConfirm() {
          axios.post("/classroom/" + _this5.classroom.code + "/student/changecharacter", {
            id: _this5.student.id,
            character_id: subclass,
            mode: "student"
          }).then(function (response) {
            location.reload();
          });
        }
      });
    },
    useItem: function useItem(item, messageItem) {
      var _this6 = this;

      this.$buefy.dialog.confirm({
        message: messageItem + " <br><br>Would you like to use the item?",
        onConfirm: function onConfirm() {
          axios.post("/classroom/" + _this6.classroom.code + "/student/useitem", {
            id: _this6.student.id,
            itemId: item.id
          }).then(function (response) {
            if (!response.data) {} else {
              item.pivot.count--;
              if (item.pivot.count == 0) _this6.inventoryRemaining++;
              _this6.student.hp = Math.min(_this6.student.hp + response.data.hp, 100);
              _this6.student.xp += response.data.xp;

              _this6.forceRerender();
            }
          });
        }
      });
    },
    forceRerender: function forceRerender() {
      this.update += 1;
    },
    updateInventory: function updateInventory(item, count) {
      axios.patch("/classroom/student/inventory", {
        id: this.student.id,
        item_id: item,
        count: count,
        _method: "patch"
      });
    },
    message: function message(item) {
      var message = "";
      if (item.hp > 0) message += "This item recovers " + item.hp + " <i class='fas fa-heart colored'></i>. ";
      if (item.xp > 0) message += "This item gives you " + item.xp + " <i class='fas fa-fist-raised colored'></i>. ";
      if (message == "" && !item.description) return "What is that?";
      message += item.description ? item.description : "";
      return message;
    },
    propertiesMessage: function propertiesMessage(itemStore) {
      return itemStore.hp + "% <i class='fas fa-heart colored'></i> " + itemStore.xp + "% <i class='fas fa-fist-raised colored'></i> " + itemStore.gold + "% <i class='fas fa-coins colored'></i>";
    },
    sortByDate: function sortByDate(a, b) {
      var isAsc = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

      if (isAsc) {
        return new Date(b.pivot.created_at).getTime() - new Date(a.pivot.created_at).getTime();
      } else {
        return new Date(a.pivot.created_at).getTime() - new Date(b.pivot.created_at).getTime();
      }
    },
    sortLogByDate: function sortLogByDate(a, b) {
      var isAsc = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

      if (isAsc) {
        return new Date(b.created_at).getTime() - new Date(a.created_at).getTime();
      } else {
        return new Date(a.created_at).getTime() - new Date(b.created_at).getTime();
      }
    },
    buyItem: function buyItem(item) {
      var _this7 = this;

      this.$buefy.dialog.confirm({
        title: "Buy item",
        message: "Do you want to buy the item?",
        confirmText: "Buy",
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: function onConfirm() {
          axios.post("/classroom/" + _this7.classroom.code + "/student/buyitem", {
            item: item.id
          }).then(function (response) {
            _this7.$toasted.show(response.data.message, {
              position: "top-center",
              duration: 3000,
              iconPack: "fontawesome",
              icon: response.data.icon,
              type: response.data.type
            });

            if (response.data.type == "success") {
              _this7.student.items = response.data.items;

              _this7.updateEmpty();

              _this7.student.gold = _this7.student.gold - item.price;

              _this7.$forceUpdate();
            }
          });
        }
      });
    },
    buyEquipment: function buyEquipment(oldItem, newItem) {
      var _this8 = this;

      this.$buefy.dialog.confirm({
        title: "Buy item",
        message: "Do you want to buy the item " + newItem.price + "<i class='fas fa-coins colored'></i>? (" + newItem.hp + "% <i class='fas fa-heart colored'></i> | " + newItem.xp + "% <i class='fas fa-fist-raised colored'></i> | " + newItem.gold + "% <i class='fas fa-coins colored'></i>)",
        confirmText: "Buy",
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: function onConfirm() {
          axios.post("/classroom/" + _this8.classroom.code + "/student/buyequipment", {
            "new": newItem
          }).then(function (response) {
            _this8.$toasted.show(response.data.message, {
              position: "top-center",
              duration: 3000,
              iconPack: "fontawesome",
              icon: response.data.icon,
              type: response.data.type
            });

            if (response.data.type == "success") {
              _this8.student.equipment = response.data.equipment;
              _this8.student.gold = _this8.student.gold - _this8.calculate(newItem);
              oldItem.src = newItem.src;
              var reference = "item" + oldItem.id;
              _this8.student.boost = response.data.boost;
              var newClass = "inv-item-armor-bronce";

              switch (newItem.offset) {
                case 2:
                  newClass = "inv-item-armor-silver";
                  break;

                case 3:
                  newClass = "inv-item-armor-gold";
                  break;
              }

              _this8.$refs[reference][0].classList.add(newClass);

              _this8.$forceUpdate();
            }
          });
        }
      });
    },
    filterEquipment: function filterEquipment(equipment, type) {
      if (equipment) {
        return equipment.filter(function (gear) {
          return gear.type == type;
        });
      }
    },
    updateAvatar: function updateAvatar() {
      var _this9 = this;

      this.image.generateBlob(function (blob) {
        if (blob != null) {
          var formData = new FormData();
          formData.append("avatar", blob, "avatar.png");

          if (_this9.admin) {
            formData.append("student_id", _this9.student.id);
          }

          axios.post("/classroom/" + _this9.classroom.code + "/setting/updateavatar", formData, {
            headers: {
              "content-type": "multipart/form-data"
            }
          }).then(function (response) {
            location.reload();
          });
        }
      }, "image/png", 0.8);
    }
  },
  computed: {
    filteredEntries: function filteredEntries() {
      var _this10 = this;

      if (this.behaviours) {
        return this.behaviours.filter(function (entry) {
          return (entry.pivot.created_at >= _this10.dateStart || !_this10.dateStart) && (entry.pivot.created_at <= _this10.dateEnd || !_this10.dateEnd);
        });
      }
    },
    filteredLogEntries: function filteredLogEntries() {
      var _this11 = this;

      return this.student.log_entries.filter(function (entry) {
        return (entry.created_at >= _this11.dateStart || !_this11.dateStart) && (entry.created_at <= _this11.dateEnd || !_this11.dateEnd);
      });
    },
    groupedData: function groupedData() {
      var array = _.groupBy(this.filteredEntries, "id");

      return array;
    },
    orderedEquipment: function orderedEquipment() {
      return _.orderBy(this.student.equipment, "type");
    },
    orderedChallenges: function orderedChallenges() {
      return _.orderBy(this.challenges, "datetime", "desc");
    }
  },
  watch: {
    groupedData: {
      immediate: true,
      handler: function handler() {
        var _this12 = this;

        var colorsOK = ["#c8e6c9", "#a5d6a7", "#81c784", "#66bb6a", "#4caf50", "#43a047", "#388e3c", "#2e7d32", "#1b5e20", "#003300", "#002200", "#001100", "#000000", "#000000", "#000000", "#000000", "#000000", "#000000", "#000000"];
        var colorsKO = ["#ffccbc", "#ffab91", "#ff8a65", "#ff7043", "#ff5722", "#f4511e", "#e64a19", "#d84315", "#bf360c", "#570000", "#370000", "#170000", "#000000", "#000000", "#000000", "#000000", "#000000", "#000000", "#000000"];
        this.series = this.labels = [];
        var data = this.groupedData;
        var propes = [];

        for (var property1 in data) {
          propes.push(data[property1]);
        }

        this.labels = [];
        this.series = [];
        this.colors = [];
        propes.forEach(function (element) {
          var behaviour = element[0];

          _this12.series.push(element.length);

          _this12.labels.push("<i class='" + behaviour.icon + "'></i> " + _this12.trans.get(behaviour.name));

          if (behaviour.xp + behaviour.hp + behaviour.gold >= 0) {
            _this12.colors.push(colorsOK[0]);

            colorsOK.shift();
          } else {
            _this12.colors.push(colorsKO[0]);

            colorsKO.shift();
          }
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/student/ShowStudentInfo.vue?vue&type=template&id=ce880446&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/student/ShowStudentInfo.vue?vue&type=template&id=ce880446& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
    {
      staticClass: "columns h-100 has-margin-right-0",
      class: { "has-bg-student": !_vm.admin }
    },
    [
      _c("div", { staticClass: "column is-narrow has-padding-right-0" }, [
        _c(
          "div",
          {
            staticClass: "card rounded card-shadow-s",
            staticStyle: { "min-width": "275px" }
          },
          [
            _vm.student.level
              ? _c(
                  "span",
                  {
                    staticClass:
                      "level-top rounded has-padding-4 has-background-light"
                  },
                  [
                    _c("show-level", {
                      staticClass: "level-hidden",
                      attrs: { level: _vm.student.level, edit: false }
                    }),
                    _vm._v(
                      "\n        " +
                        _vm._s(_vm.student.level.number) +
                        "\n      "
                    )
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "card-image card-shadow-s rounded-top char-bg",
                style:
                  "min-height: 160px;background-color:" +
                  _vm.classroom.theme.color +
                  ";background-image: url(/img/bg/thumb_" +
                  _vm.classroom.theme.name +
                  ");"
              },
              [
                _c(
                  "span",
                  {
                    directives: [{ name: "tippy", rawName: "v-tippy" }],
                    staticClass: "boost-right outer_glow_dark",
                    attrs: {
                      content:
                        "<i class='fas fa-heart colored'></i>" +
                        _vm.student.boost.hp +
                        "% | <i class='fas fa-fist-raised colored'></i>" +
                        _vm.student.boost.xp +
                        "% | <i class='fas fa-coins colored'></i>" +
                        _vm.student.boost.gold +
                        "%"
                    }
                  },
                  [_c("i", { staticClass: "fas fa-arrow-alt-square-up" })]
                ),
                _vm._v(" "),
                _vm.classroom.character_theme
                  ? _c(
                      "div",
                      {
                        staticClass:
                          "character-container character character-small is-relative"
                      },
                      _vm._l(_vm.student.equipment, function(element) {
                        return _c("img", {
                          key: element.id,
                          class: element.classes,
                          attrs: { src: "/img/character/" + element.src }
                        })
                      }),
                      0
                    )
                  : _c(
                      "div",
                      {
                        staticClass: "is-flex has-all-centered has-padding-y-3"
                      },
                      [
                        _c("img", {
                          staticClass: "rounded",
                          attrs: {
                            src: _vm.student.avatar,
                            width: "128px",
                            height: "128px",
                            alt: ""
                          }
                        })
                      ]
                    )
              ]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "card-content" }, [
              _c(
                "div",
                { staticClass: "media has-margin-bottom-0 has-all-centered" },
                [
                  _vm.classroom.character_theme
                    ? _c("div", { staticClass: "media-left" }, [
                        _c("figure", { staticClass: "image is-48x48" }, [
                          _c("img", {
                            staticClass: "rounded",
                            attrs: { src: _vm.student.avatar, alt: "" }
                          })
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "media-content" }, [
                    _c("p", { staticClass: "title is-4" }, [
                      _vm._v(_vm._s(_vm.student.name))
                    ]),
                    _vm._v(" "),
                    _c("p", { staticClass: "subtitle is-6" }, [
                      _c("small", [_vm._v("@" + _vm._s(_vm.student.username))])
                    ])
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "score has-padding-3 centered-attribute has-margin-1 has-margin-y-4 has-all-centered",
                  staticStyle: { border: "none" }
                },
                [
                  _c(
                    "span",
                    {
                      staticClass:
                        "attribute has-background-white-ter has-padding-y-3 rounded",
                      staticStyle: { width: "100%" }
                    },
                    [
                      _c("span", [
                        _c("i", {
                          staticClass:
                            "fas fa-heart colored has-text-grey-light",
                          class: { invisible: _vm.student.hp >= 30 }
                        })
                      ]),
                      _vm._v(" "),
                      _c(
                        "span",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.student.hp < 30,
                              expression: "student.hp<30"
                            }
                          ],
                          staticClass: "has-text-grey-light"
                        },
                        [_vm._v(_vm._s(_vm.student.hp))]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _vm.student.hp > 0
                    ? _c(
                        "span",
                        {
                          staticClass:
                            "attribute has-background-danger has-padding-y-3 rounded-left",
                          class: { rounded: _vm.student.hp == 100 },
                          style: "width: " + _vm.student.hp + "%"
                        },
                        [
                          _c("i", {
                            staticClass: "fas fa-heart colored",
                            class: { invisible: _vm.student.hp < 30 }
                          }),
                          _vm._v(" "),
                          _vm.student.hp >= 30
                            ? _c("span", [_vm._v(_vm._s(_vm.student.hp))])
                            : _vm._e()
                        ]
                      )
                    : _vm._e()
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "score has-padding-3 has-margin-1 has-margin-top-3"
                },
                [
                  _vm._m(0),
                  _vm._v("\n          " + _vm._s(_vm.student.xp) + "\n        ")
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "gold has-padding-3 has-margin-1 has-margin-top-2"
                },
                [
                  _vm._m(1),
                  _vm._v(
                    "\n          " + _vm._s(_vm.student.gold) + "\n        "
                  )
                ]
              )
            ])
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "column has-padding-right-0" },
        [
          _c(
            "b-tabs",
            {
              key: _vm.update,
              model: {
                value: _vm.activeTab,
                callback: function($$v) {
                  _vm.activeTab = $$v
                },
                expression: "activeTab"
              }
            },
            [
              _c(
                "b-tab-item",
                {
                  attrs: {
                    label: "Information",
                    icon: "info-circle",
                    "icon-pack": "fad"
                  }
                },
                [
                  _c("div", {}, [
                    _c(
                      "div",
                      { staticClass: "has-margin-3" },
                      [
                        _c("croppa", {
                          staticClass: "rounded",
                          attrs: {
                            width: 128,
                            height: 128,
                            accept: "image/*",
                            placeholder: "📷 Avatar",
                            "placeholder-font-size": 16,
                            "canvas-color": "transparent",
                            "show-remove-button": true,
                            "remove-button-color": "black",
                            "show-loading": true,
                            "loading-size": 50
                          },
                          model: {
                            value: _vm.image,
                            callback: function($$v) {
                              _vm.image = $$v
                            },
                            expression: "image"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "has-margin-3" }, [
                      _vm.image && _vm.image.chosenFile
                        ? _c(
                            "button",
                            {
                              staticClass: "button is-link",
                              on: {
                                click: function($event) {
                                  return _vm.updateAvatar()
                                }
                              }
                            },
                            [_vm._v("Update avatar")]
                          )
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "field is-horizontal" }, [
                    _c("div", { staticClass: "field-label is-normal" }, [
                      _c("label", { staticClass: "label" }, [_vm._v("Name")])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "field-body" }, [
                      _c("div", { staticClass: "field has-addons" }, [
                        _c("div", { staticClass: "control" }, [
                          _c(
                            "input",
                            _vm._b(
                              {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.student.name,
                                    expression: "student.name"
                                  }
                                ],
                                staticClass: "input",
                                class: { "is-static": !_vm.admin },
                                attrs: { type: "text" },
                                domProps: { value: _vm.student.name },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.student,
                                      "name",
                                      $event.target.value
                                    )
                                  }
                                }
                              },
                              "input",
                              { disabled: !_vm.admin },
                              false
                            )
                          )
                        ]),
                        _vm._v(" "),
                        _vm.admin && _vm.student.name.length >= 4
                          ? _c("div", { staticClass: "control" }, [
                              _c(
                                "a",
                                {
                                  staticClass: "button is-info",
                                  on: { click: _vm.updateName }
                                },
                                [_c("i", { staticClass: "fas fa-save" })]
                              )
                            ])
                          : _vm._e()
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "field is-horizontal" }, [
                    _c("div", { staticClass: "field-label is-normal" }, [
                      _c("label", { staticClass: "label" }, [
                        _vm._v("Username")
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "field-body" }, [
                      _c("div", { staticClass: "field" }, [
                        _c("p", { staticClass: "control" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.student.username,
                                expression: "student.username"
                              }
                            ],
                            staticClass: "input is-static",
                            attrs: { disabled: "", type: "text" },
                            domProps: { value: _vm.student.username },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.student,
                                  "username",
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
                  _vm.student.password_plain && _vm.admin
                    ? _c("div", { staticClass: "field is-horizontal" }, [
                        _c("div", { staticClass: "field-label is-normal" }, [
                          _c("label", { staticClass: "label" }, [
                            _vm._v("Password")
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "field-body" },
                          [
                            _c(
                              "b-field",
                              { staticClass: "is-static" },
                              [
                                _c("b-input", {
                                  staticStyle: { width: "200px" },
                                  attrs: {
                                    type: "password",
                                    "icon-pack": "fas",
                                    disabled: "",
                                    "password-reveal": ""
                                  },
                                  model: {
                                    value: _vm.student.password_plain,
                                    callback: function($$v) {
                                      _vm.$set(
                                        _vm.student,
                                        "password_plain",
                                        $$v
                                      )
                                    },
                                    expression: "student.password_plain"
                                  }
                                })
                              ],
                              1
                            )
                          ],
                          1
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.classroom.character_theme && _vm.student.hp > 0
                    ? _c(
                        "div",
                        { staticClass: "has-padding-4" },
                        _vm._l(
                          _vm.classroom.character_theme.characters,
                          function(charclass) {
                            return _c("img", {
                              directives: [
                                { name: "tippy", rawName: "v-tippy" }
                              ],
                              key: charclass.id,
                              staticClass: "has-padding-2 has-margin-2 rounded",
                              class: {
                                selected:
                                  charclass.id == _vm.student.character_id
                              },
                              attrs: {
                                content:
                                  "Highlights in <i class='" +
                                  charclass.property +
                                  " colored'></i>",
                                src: "/img/character/" + charclass.id + ".png"
                              },
                              on: {
                                click: function($event) {
                                  return _vm.confirmChangeClass(charclass.id)
                                }
                              }
                            })
                          }
                        ),
                        0
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.admin
                    ? _c("div", [
                        _c(
                          "button",
                          {
                            staticClass: "button is-danger",
                            on: { click: _vm.deleteStudent }
                          },
                          [
                            _c("i", {
                              staticClass: "fas fa-trash has-margin-right-2"
                            }),
                            _vm._v(" Delete student from classroom\n          ")
                          ]
                        )
                      ])
                    : _vm._e()
                ]
              ),
              _vm._v(" "),
              _c(
                "b-tab-item",
                {
                  staticClass: "has-padding-0",
                  attrs: {
                    label: "Inventory",
                    icon: "backpack",
                    "icon-pack": "fad"
                  }
                },
                [
                  _vm.admin
                    ? _c(
                        "div",
                        { staticClass: "columns is-multiline is-variable" },
                        _vm._l(_vm.items, function(item) {
                          return _c(
                            "div",
                            {
                              key: item.id,
                              staticClass:
                                "column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
                            },
                            [
                              _c(
                                "b-field",
                                [
                                  _c("p", { staticClass: "control" }, [
                                    _c("img", { attrs: { src: item.icon } })
                                  ]),
                                  _vm._v(" "),
                                  _c("b-numberinput", {
                                    attrs: {
                                      min: "0",
                                      "icon-pack": "fa",
                                      expanded: "",
                                      controlsPosition: "compact"
                                    },
                                    on: {
                                      input: function($event) {
                                        return _vm.updateInventory(
                                          item.id,
                                          item.count
                                        )
                                      }
                                    },
                                    model: {
                                      value: item.count,
                                      callback: function($$v) {
                                        _vm.$set(item, "count", $$v)
                                      },
                                      expression: "item.count"
                                    }
                                  })
                                ],
                                1
                              )
                            ],
                            1
                          )
                        }),
                        0
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  !_vm.admin
                    ? _c(
                        "div",
                        {
                          staticClass: "inventory",
                          attrs: { id: "inventory" }
                        },
                        [
                          _c(
                            "div",
                            _vm._l(_vm.student.items, function(item) {
                              return _c(
                                "div",
                                {
                                  directives: [
                                    { name: "tippy", rawName: "v-tippy" },
                                    {
                                      name: "show",
                                      rawName: "v-show",
                                      value: item.pivot.count > 0,
                                      expression: "item.pivot.count>0"
                                    }
                                  ],
                                  key: item.id,
                                  staticClass: "inventory-item",
                                  attrs: { content: _vm.message(item) }
                                },
                                [
                                  _c("img", {
                                    staticClass: "item",
                                    attrs: { src: item.icon },
                                    on: {
                                      click: function($event) {
                                        item.hp > 0
                                          ? _vm.useItem(item, _vm.message(item))
                                          : null
                                      }
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("div", { staticClass: "number-items" }, [
                                    _vm._v(_vm._s(item.pivot.count))
                                  ])
                                ]
                              )
                            }),
                            0
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            _vm._l(_vm.inventoryRemaining, function(index) {
                              return _c("div", {
                                key: index,
                                staticClass: "inventory-item"
                              })
                            }),
                            0
                          ),
                          _vm._v(" "),
                          _vm.classroom.character_theme
                            ? _c(
                                "div",
                                { key: _vm.forceReload },
                                _vm._l(_vm.orderedEquipment, function(gear) {
                                  return _c(
                                    "div",
                                    {
                                      directives: [
                                        { name: "tippy", rawName: "v-tippy" }
                                      ],
                                      key: gear.id,
                                      ref: "item" + gear.id,
                                      refInFor: true,
                                      staticClass:
                                        "inventory-item inv-item-armor relative",
                                      class: {
                                        "inv-item-armor-bronce":
                                          gear.offset == 1,
                                        "inv-item-armor-silver":
                                          gear.offset == 2,
                                        "inv-item-armor-gold": gear.offset == 3
                                      },
                                      attrs: {
                                        content: _vm.propertiesMessage(gear)
                                      }
                                    },
                                    [
                                      _c("img", {
                                        staticClass: "item",
                                        attrs: {
                                          src: "/img/character/" + gear.src,
                                          alt: gear.id
                                        }
                                      }),
                                      _vm._v(" "),
                                      _vm.eq1Json || _vm.eq2Json || _vm.eq3Json
                                        ? _c(
                                            "div",
                                            {
                                              staticClass:
                                                "price-buy rounded not-hover"
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fas fa-plus"
                                              })
                                            ]
                                          )
                                        : _vm._e(),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass: "w-100 shop-sub-item",
                                          staticStyle: {
                                            position: "absolute",
                                            top: "100px",
                                            left: "0"
                                          }
                                        },
                                        _vm._l(
                                          [
                                            _vm.eq1Json,
                                            _vm.eq2Json,
                                            _vm.eq3Json
                                          ],
                                          function(i, index) {
                                            return _c(
                                              "div",
                                              { key: index },
                                              _vm._l(
                                                _vm.filterEquipment(
                                                  i,
                                                  gear.type
                                                ),
                                                function(itemStore) {
                                                  return _c(
                                                    "div",
                                                    {
                                                      key: itemStore.id,
                                                      staticClass:
                                                        "inventory-item inv-item-armor w-100",
                                                      class: {
                                                        "inv-item-armor-bronce":
                                                          index == 0,
                                                        "inv-item-armor-silver":
                                                          index == 1,
                                                        "inv-item-armor-gold":
                                                          index == 2
                                                      }
                                                    },
                                                    [
                                                      _c("img", {
                                                        directives: [
                                                          {
                                                            name: "tippy",
                                                            rawName: "v-tippy"
                                                          }
                                                        ],
                                                        staticClass: "item",
                                                        attrs: {
                                                          content: _vm.propertiesMessage(
                                                            itemStore
                                                          ),
                                                          src:
                                                            "/img/character/" +
                                                            itemStore.src,
                                                          alt: itemStore.id
                                                        }
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "div",
                                                        {
                                                          staticClass:
                                                            "price-buy rounded",
                                                          on: {
                                                            click: function(
                                                              $event
                                                            ) {
                                                              return _vm.buyEquipment(
                                                                gear,
                                                                itemStore
                                                              )
                                                            }
                                                          }
                                                        },
                                                        [
                                                          _vm._v(
                                                            "\n                      " +
                                                              _vm._s(
                                                                _vm.calculate(
                                                                  itemStore
                                                                )
                                                              ) +
                                                              "\n                      "
                                                          ),
                                                          _c("i", {
                                                            staticClass:
                                                              "fas fa-coins colored"
                                                          })
                                                        ]
                                                      )
                                                    ]
                                                  )
                                                }
                                              ),
                                              0
                                            )
                                          }
                                        ),
                                        0
                                      )
                                    ]
                                  )
                                }),
                                0
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _c("div", { staticStyle: { clear: "both" } })
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.itemsJson
                    ? _c(
                        "div",
                        { staticClass: "shop has-padding-top-3" },
                        [
                          _c("h2", { staticClass: "is-size-2" }, [
                            _c("i", { staticClass: "fas fa-store" }),
                            _vm._v(" Shop\n          ")
                          ]),
                          _vm._v(" "),
                          _vm._l(_vm.itemsJson, function(item) {
                            return _c(
                              "div",
                              {
                                key: item.id,
                                staticClass:
                                  "columns has-padding-4 has-margin-2 rounded"
                              },
                              [
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "column is-relative is-flex has-all-centered is-narrow"
                                  },
                                  [
                                    item.min_lvl
                                      ? _c(
                                          "div",
                                          { staticClass: "lvl-item-top-left" },
                                          [
                                            _c("img", {
                                              staticClass: "levelCard",
                                              attrs: {
                                                src: "/img/cardgen/lvl.png"
                                              }
                                            }),
                                            _vm._v(" "),
                                            _c(
                                              "span",
                                              {
                                                staticClass:
                                                  "is-flex has-all-centered"
                                              },
                                              [_vm._v(_vm._s(item.min_lvl))]
                                            )
                                          ]
                                        )
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _c("img", { attrs: { src: item.icon } })
                                  ]
                                ),
                                _vm._v(" "),
                                _c("div", {
                                  staticClass:
                                    "column is-flex has-all-centered rounded wheat",
                                  domProps: {
                                    innerHTML: _vm._s(_vm.message(item))
                                  }
                                }),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "column is-flex has-all-centered is-narrow item-price"
                                  },
                                  [
                                    _c(
                                      "button",
                                      {
                                        staticClass: "button is-success",
                                        on: {
                                          click: function($event) {
                                            return _vm.buyItem(item)
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                Buy " +
                                            _vm._s(item.price) +
                                            "\n                "
                                        ),
                                        _c("i", {
                                          staticClass: "fas fa-coins colored",
                                          staticStyle: { "z-index": "0" }
                                        })
                                      ]
                                    )
                                  ]
                                )
                              ]
                            )
                          })
                        ],
                        2
                      )
                    : _vm._e()
                ]
              ),
              _vm._v(" "),
              _vm.cards.length
                ? _c(
                    "b-tab-item",
                    {
                      attrs: {
                        label: "Cards",
                        icon: "club",
                        "icon-pack": "fad"
                      }
                    },
                    [
                      _c(
                        "div",
                        { staticClass: "columns is-multiline is-variable" },
                        _vm._l(_vm.cards, function(card, index) {
                          return _c(
                            "div",
                            {
                              key: index,
                              staticClass:
                                "column is-6-tablet is-12-mobile is-6-desktop is-4-fullhd"
                            },
                            [
                              _c("show-card", {
                                staticClass: "has-margin-4",
                                attrs: {
                                  student: _vm.student,
                                  card: card,
                                  code: _vm.classroom.code,
                                  use: true,
                                  admin: false
                                }
                              })
                            ],
                            1
                          )
                        }),
                        0
                      )
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.behaviours && _vm.behaviours.length
                ? _c(
                    "b-tab-item",
                    {
                      attrs: {
                        label: "Behaviours",
                        icon: "heart",
                        "icon-pack": "fad"
                      }
                    },
                    [
                      _c(
                        "div",
                        { staticClass: "is-flex justify-content-center" },
                        [
                          _vm.series.length
                            ? _c("apexchart", {
                                attrs: {
                                  width: "450",
                                  type: "donut",
                                  options: {
                                    labels: _vm.labels,
                                    colors: _vm.colors
                                  },
                                  series: _vm.series
                                }
                              })
                            : _vm._e()
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "columns" }, [
                        _c("div", { staticClass: "column" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.dateStart,
                                expression: "dateStart"
                              }
                            ],
                            staticClass: "input is-rounded",
                            attrs: { type: "date" },
                            domProps: { value: _vm.dateStart },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.dateStart = $event.target.value
                              }
                            }
                          })
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "column" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.dateEnd,
                                expression: "dateEnd"
                              }
                            ],
                            staticClass: "input is-rounded",
                            attrs: { type: "date" },
                            domProps: { value: _vm.dateEnd },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.dateEnd = $event.target.value
                              }
                            }
                          })
                        ])
                      ]),
                      _vm._v(" "),
                      _vm.behaviours && _vm.behaviours.length
                        ? _c("b-table", {
                            attrs: {
                              data: _vm.filteredEntries,
                              "default-sort": "created_at",
                              "default-sort-direction": "desc",
                              "icon-pack": "fas",
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
                                            field: "icon",
                                            label: "Icon",
                                            centered: ""
                                          }
                                        },
                                        [
                                          _c(
                                            "span",
                                            {
                                              staticClass: "tag",
                                              class: [
                                                props.row.xp +
                                                  props.row.hp +
                                                  props.row.gold >=
                                                0
                                                  ? "is-success"
                                                  : "is-danger"
                                              ]
                                            },
                                            [_c("i", { class: props.row.icon })]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "b-table-column",
                                        {
                                          attrs: {
                                            field: "name",
                                            label: "Name",
                                            centered: "",
                                            sortable: ""
                                          }
                                        },
                                        [
                                          _vm._v(
                                            _vm._s(
                                              _vm.trans.get(props.row.name)
                                            )
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "b-table-column",
                                        {
                                          attrs: {
                                            field: "created_at",
                                            label: "Created at",
                                            "default-sort-direction": "desc",
                                            "custom-sort": _vm.sortByDate,
                                            sortable: "",
                                            centered: ""
                                          }
                                        },
                                        [
                                          _vm._v(
                                            _vm._s(
                                              new Date(
                                                props.row.pivot.created_at
                                              ).toLocaleDateString()
                                            )
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "b-table-column",
                                        {
                                          attrs: {
                                            field: "hp",
                                            label: "Health Points",
                                            centered: "",
                                            sortable: ""
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fas fa-heart"
                                          }),
                                          _vm._v(
                                            "\n              " +
                                              _vm._s(props.row.hp) +
                                              "\n            "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "b-table-column",
                                        {
                                          attrs: {
                                            field: "name",
                                            label: "Experience",
                                            sortable: "",
                                            centered: ""
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fas fa-fist-raised"
                                          }),
                                          _vm._v(
                                            "\n              " +
                                              _vm._s(props.row.xp) +
                                              "\n            "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "b-table-column",
                                        {
                                          attrs: {
                                            field: "name",
                                            label: "Gold",
                                            sortable: "",
                                            centered: ""
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fas fa-coins"
                                          }),
                                          _vm._v(
                                            "\n              " +
                                              _vm._s(props.row.gold) +
                                              "\n            "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _vm.admin
                                        ? _c(
                                            "b-table-column",
                                            {
                                              attrs: {
                                                field: "name",
                                                label: "Settings",
                                                centered: ""
                                              }
                                            },
                                            [
                                              _c(
                                                "b-button",
                                                {
                                                  attrs: {
                                                    type: "is-danger is-small"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.confirmDelete(
                                                        "behaviour",
                                                        props.row,
                                                        props.row.pivot
                                                          .created_at
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fas fa-trash-alt"
                                                  })
                                                ]
                                              )
                                            ],
                                            1
                                          )
                                        : _vm._e()
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              1043174481
                            )
                          })
                        : _vm._e()
                    ],
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.challenges && _vm.challenges.length
                ? _c(
                    "b-tab-item",
                    {
                      attrs: {
                        label: "Challenges",
                        icon: "pen-fancy",
                        "icon-pack": "fad"
                      }
                    },
                    _vm._l(_vm.orderedChallenges, function(challenge) {
                      return _c(
                        "div",
                        { key: challenge.id },
                        [
                          _c("show-challenge", {
                            attrs: {
                              challenge: challenge,
                              code: _vm.classroom.code,
                              admin: _vm.admin,
                              edit: false
                            }
                          })
                        ],
                        1
                      )
                    }),
                    0
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.evaluation
                ? _c(
                    "b-tab-item",
                    {
                      attrs: {
                        label: "Evaluation",
                        icon: "analytics",
                        "icon-pack": "fad"
                      }
                    },
                    [
                      _c("report", {
                        attrs: {
                          classroom: _vm.classroom,
                          admin: _vm.admin,
                          grades: _vm.evaluation,
                          settings: _vm.settings
                        }
                      })
                    ],
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              (_vm.classroom.badges && _vm.classroom.badges.length) ||
              _vm.student.badges.length
                ? _c(
                    "b-tab-item",
                    {
                      attrs: {
                        label: "Badges",
                        icon: "award",
                        "icon-pack": "fad"
                      }
                    },
                    [
                      _vm.admin
                        ? _c(
                            "div",
                            { staticClass: "has-padding-left-4" },
                            _vm._l(_vm.classroom.badges, function(badge) {
                              return _c("div", { key: badge.id }, [
                                _c(
                                  "div",
                                  {
                                    directives: [
                                      { name: "tippy", rawName: "v-tippy" }
                                    ],
                                    staticClass: "personalBadge type0",
                                    class: {
                                      notColored: _vm.findInStudent(badge.id)
                                    },
                                    attrs: {
                                      content:
                                        "<h1>" +
                                        badge.title +
                                        "</h1><h3>" +
                                        badge.description +
                                        "</h3>"
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.toggle(badge.id)
                                      }
                                    }
                                  },
                                  [_c("i", { class: "fal " + badge.icon })]
                                )
                              ])
                            }),
                            0
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      !_vm.admin
                        ? _c(
                            "div",
                            { staticClass: "has-padding-left-4" },
                            _vm._l(_vm.student.badges, function(badge) {
                              return _c("div", { key: badge.id }, [
                                _c(
                                  "div",
                                  {
                                    directives: [
                                      { name: "tippy", rawName: "v-tippy" }
                                    ],
                                    staticClass: "personalBadge type0",
                                    attrs: {
                                      content:
                                        "<h1>" +
                                        badge.title +
                                        "</h1><h3>" +
                                        badge.description +
                                        "</h3>"
                                    }
                                  },
                                  [_c("i", { class: "fal " + badge.icon })]
                                )
                              ])
                            }),
                            0
                          )
                        : _vm._e()
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.student.log_entries.length
                ? _c(
                    "b-tab-item",
                    {
                      attrs: { label: "Log", icon: "file", "icon-pack": "fad" }
                    },
                    [
                      _c("div", { staticClass: "columns" }, [
                        _c("div", { staticClass: "column" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.dateStart,
                                expression: "dateStart"
                              }
                            ],
                            staticClass: "input is-rounded",
                            attrs: { type: "date" },
                            domProps: { value: _vm.dateStart },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.dateStart = $event.target.value
                              }
                            }
                          })
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "column" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.dateEnd,
                                expression: "dateEnd"
                              }
                            ],
                            staticClass: "input is-rounded",
                            attrs: { type: "date" },
                            domProps: { value: _vm.dateEnd },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.dateEnd = $event.target.value
                              }
                            }
                          })
                        ])
                      ]),
                      _vm._v(" "),
                      _vm.student.log_entries.length
                        ? _c("b-table", {
                            attrs: {
                              data: _vm.filteredLogEntries,
                              "default-sort": "created_at",
                              "default-sort-direction": "desc",
                              "icon-pack": "fas",
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
                                            field: "type",
                                            label: "Type",
                                            centered: ""
                                          }
                                        },
                                        [
                                          _c(
                                            "span",
                                            {
                                              staticClass: "tag",
                                              class: [
                                                props.row.value >= 0
                                                  ? "is-success"
                                                  : "is-danger"
                                              ]
                                            },
                                            [
                                              props.row.type == "xp"
                                                ? _c("span", [_vm._v("✊")])
                                                : _vm._e(),
                                              _vm._v(" "),
                                              props.row.type == "gold"
                                                ? _c("span", [_vm._v("💰")])
                                                : _vm._e(),
                                              _vm._v(" "),
                                              props.row.type == "hp"
                                                ? _c("span", [_vm._v("❤️")])
                                                : _vm._e()
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "b-table-column",
                                        {
                                          attrs: {
                                            field: "value",
                                            label: "value",
                                            sortable: ""
                                          }
                                        },
                                        [_vm._v(_vm._s(props.row.value))]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "b-table-column",
                                        {
                                          attrs: {
                                            field: "created_at",
                                            label: "Created at",
                                            "default-sort-direction": "desc",
                                            "custom-sort": _vm.sortLogByDate,
                                            sortable: "",
                                            centered: ""
                                          }
                                        },
                                        [
                                          _vm._v(
                                            _vm._s(
                                              new Date(
                                                props.row.created_at
                                              ).toLocaleDateString()
                                            )
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _vm.admin
                                        ? _c(
                                            "b-table-column",
                                            {
                                              attrs: {
                                                field: "name",
                                                label: "Settings",
                                                centered: ""
                                              }
                                            },
                                            [
                                              _c(
                                                "b-button",
                                                {
                                                  attrs: {
                                                    type: "is-danger is-small"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.confirmDelete(
                                                        "logentry",
                                                        props.row,
                                                        props.row.created_at
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c("i", {
                                                    staticClass:
                                                      "fas fa-trash-alt"
                                                  })
                                                ]
                                              )
                                            ],
                                            1
                                          )
                                        : _vm._e()
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              3626445575
                            )
                          })
                        : _vm._e()
                    ],
                    1
                  )
                : _vm._e()
            ],
            1
          )
        ],
        1
      )
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", [_c("i", { staticClass: "fas fa-fist-raised colored" })])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", [_c("i", { staticClass: "fas fa-coins colored" })])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/student/ShowStudentInfo.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/student/ShowStudentInfo.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ShowStudentInfo_vue_vue_type_template_id_ce880446___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowStudentInfo.vue?vue&type=template&id=ce880446& */ "./resources/js/components/student/ShowStudentInfo.vue?vue&type=template&id=ce880446&");
/* harmony import */ var _ShowStudentInfo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowStudentInfo.vue?vue&type=script&lang=js& */ "./resources/js/components/student/ShowStudentInfo.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ShowStudentInfo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ShowStudentInfo_vue_vue_type_template_id_ce880446___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ShowStudentInfo_vue_vue_type_template_id_ce880446___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/student/ShowStudentInfo.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/student/ShowStudentInfo.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/student/ShowStudentInfo.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowStudentInfo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowStudentInfo.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/student/ShowStudentInfo.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowStudentInfo_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/student/ShowStudentInfo.vue?vue&type=template&id=ce880446&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/student/ShowStudentInfo.vue?vue&type=template&id=ce880446& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowStudentInfo_vue_vue_type_template_id_ce880446___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./ShowStudentInfo.vue?vue&type=template&id=ce880446& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/student/ShowStudentInfo.vue?vue&type=template&id=ce880446&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowStudentInfo_vue_vue_type_template_id_ce880446___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowStudentInfo_vue_vue_type_template_id_ce880446___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);