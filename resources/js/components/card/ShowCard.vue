<template>
  <div class="m-2">
    <div
      style="text-align: center"
      :class="{ grayscale: card.disabled == 1 }"
      v-if="this.use"
    >
      <button
        type="submit"
        class="button is-success"
        @click="markCard(card, 1)"
        v-tippy
        :content="getMessage(card.pivot.marked)"
        v-bind:class="{
          disabled: checkLevel() || card.disabled == 1,
          'has-background-dark': card.pivot.marked == 1,
        }"
      >
        <i class="fas fa-check"></i> {{ trans.get("cards.use") }}
      </button>
      <button
        type="submit"
        v-if="card.xp >= 0 && card.gold >= 0 && card.hp >= 0"
        @click="markCard(card, 2)"
        class="button is-danger"
        v-bind:class="{ 'has-background-dark': card.pivot.marked == 2 }"
      >
        <i class="fas fa-trash-alt"></i> {{ trans.get("cards.delete") }}
      </button>
    </div>
    <div
      class="cardContainer cardFunction"
      data-id="1"
      group-id
      style="-webkit-print-color-adjust: exact;print-color-adjust: exact;"
      :class="{ grayscale: card.disabled == 1 }"
      :style="'background-color:' + card.background + ';'"
    >
      <div class="lvl-top-left" v-if="card.min_lvl">
        <img src="/img/cardgen/lvl.png" class="levelCard" />
        <span class="numberLvl">{{ card.min_lvl }}</span>
      </div>
      <img
        :src="'/img/cardgen/type_' + card.type + '.png'"
        v-if="!card.fullscreen"
        class="typeCard"
      />
      <span
        v-tippy
        :content="trans.get('cards.automatic_info')"
        class="typeCard"
        style="top: 203px; z-index: 100"
      >
        <i
          v-if="card.automatic == 1"
          class="fas fa-bolt has-text-light colored"
        ></i>
      </span>
      <div>
        <h3 class="title-cards textShadow">
          <svg viewBox="0 0 500 500">
            <path
              id="curve"
              d="m 3.2938789,150.87387 c 5.55773,-3.11588 91.0078161,-49.44517 248.1526411,-48.83221 154.64384,0.61296 237.31506,46.12499 243.28962,49.54732"
            />
            <text width="250px">
              <textPath
                xlink:href="#curve"
                startOffset="50%"
                text-anchor="middle"
              >
                {{ trans.get(card.title) }}
              </textPath>
            </text>
          </svg>
        </h3>
      </div>
      <img
        :src="'/img/cardgen/ribbon-' + card.type + '.png'"
        class="ribbon"
        v-if="!card.fullscreen"
      />
      <img
        :src="'/img/cardgen/only_back_' + card.type_bg + '.png'"
        class="background"
        v-if="!card.special && !card.fullscreen"
      />
      <img
        :src="'/img/cardgen/only_back_' + card.type_bg + '_gold.png'"
        class="background"
        v-if="card.special && !card.fullscreen"
      />

      <div class="content-cards text_shadow" v-html="description"></div>

      <div class="hiding-parent">
        <img
          :src="card.src"
          :style="
            'margin-left: ' +
            card.margin_left +
            'px;margin-top:' +
            card.margin_top +
            'px;width:' +
            card.width +
            'px;border-radius:' +
            card.radius +
            'px'
          "
          class="back-card"
        />
      </div>
      <div class="xp_modify modifiers" v-if="card.xp != 0">
        <img src="/img/cardgen/xp_modify.png" class />
        <span>{{ card.xp }}</span>
      </div>
      <div class="hp_modify modifiers" v-if="card.hp != 0">
        <img src="/img/cardgen/hp_modify.png" class />
        <span>{{ card.hp }}</span>
      </div>
      <div class="gold_modify modifiers" v-if="card.gold != 0">
        <img src="/img/cardgen/gold_modify.png" />
        <span>{{ card.gold }}</span>
      </div>
    </div>
    <div style="text-align: center" v-if="this.admin && this.assign">
      <button class="button is-dark" @click="assignCard">
        <i class="fas fa-arrow-up"></i> {{ trans.get("general.assign") }}
      </button>
    </div>
    <div style="text-align: center" v-if="this.admin && this.import">
      <button class="button is-success" @click="importCard">
        <i class="fas fa-arrow-up"></i> {{ trans.get("general.import") }}
      </button>
    </div>
    <div
      style="text-align: center"
      class="noprint"
      v-if="this.admin && this.properties && !this.assign"
    >
      <button
        type="submit"
        @click="toggleAutomatic"
        v-tippy
        :content="getMessageAutomatic()"
        class="button is-light"
        :class="{
          'is-warning is-light': card.automatic == 0,
          'is-success is-light': card.automatic == 1,
        }"
      >
        <i
          class="fas"
          :class="{
            'fa-bolt': card.automatic == 0,
            'fa-hand-sparkles': card.automatic == 1,
          }"
        ></i>
      </button>
      <button
        type="submit"
        @click="toggleDisable"
        v-tippy
        :content="getMessageDisable()"
        class="button is-light"
        :class="{
          'is-light': card.disabled == 0,
          'is-danger is-light': card.disabled == 1,
        }"
      >
        <i
          class="fas"
          :class="{
            'fa-eye-slash': card.disabled == 0,
            'fa-eye': card.disabled == 1,
          }"
        ></i>
      </button>
      <a
        :href="'/classroom/' + code + '/cards/' + card.id"
        type="submit"
        class="button is-dark"
        v-tippy
        :content="trans.get('general.edit')"
      >
        <i class="fas fa-edit"></i>
      </a>
      <button
        type="submit"
        @click="confirmDelete"
        v-tippy
        :content="trans.get('general.delete')"
        class="button is-danger"
      >
        <i class="fas fa-trash-alt"></i>
      </button>
      <button
        type="submit"
        @click="share"
        v-tippy
        v-if="card.own"
        :content="trans.get('cards.share')"
        class="button is-primary"
      >
        <i class="fas fa-share-alt"></i>
      </button>
    </div>
    <div v-if="pagebreak % 2 == 0" style="page-break-before: always;"></div>
  </div>
</template>


<script>
import Utils from "../../utils.js";
const Buttons = () => import("./Buttons.vue");

export default {
  props: [
    "card",
    "admin",
    "properties",
    "code",
    "use",
    "student",
    "assign",
    "import",
    "pagebreak",
  ],
  components: {
    Buttons,
  },
  mounted() {
    this.description = Utils.styleText(this.trans.get(this.card.description));
  },
  data: function () {
    return {
      description: "",
    };
  },
  methods: {
    getMessageAutomatic() {
      if (this.card.automatic) return this.trans.get("cards.manual");
      return (
        this.trans.get("cards.automatic") +
        ". " +
        this.trans.get("cards.automatic_info")
      );
    },
    toggleAutomatic() {
      axios
        .get("/classroom/card/automatic/" + this.card.id)
        .then((response) => {
          this.card.automatic
            ? (this.card.automatic = 0)
            : (this.card.automatic = 1);
        });
    },
    getMessageDisable() {
      if (this.card.disabled) return this.trans.get("general.enable");
      return this.trans.get("general.disable");
    },
    toggleDisable() {
      axios.get("/classroom/card/disable/" + this.card.id).then((response) => {
        this.card.disabled
          ? (this.card.disabled = 0)
          : (this.card.disabled = 1);
      });
    },
    share() {
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
        onConfirm: () => {
          axios
            .post("/card/share", {
              id: this.card.id,
            })
            .then((response) => {
              this.$toast(this.trans.get("success_error.add_success"), {
                type: "success",
              });
            });
        },
      });
    },
    importCard() {
      axios
        .post("/classroom/" + this.code + "/card/import", {
          id: this.card.id,
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.add_success"), {
            type: "success",
          });
        });
    },
    assignCard() {
      axios
        .post("/classroom/" + this.code + "/card/assign", {
          type: "student",
          id: this.assign,
          card: this.card.id,
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.add_success"), {
            type: "success",
          });
        });
    },
    markCard(card, type) {
      if (type == 1 && this.card.disabled == 1) return false;
      let number = 0;
      if (this.$parent.$parent.$parent.student.level != null)
        number = this.$parent.$parent.$parent.student.level.number;
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
          onConfirm: () => {
            axios
              .post("/classroom/card/usedelete/bypass/" + this.card.id, {
                type: type,
                student: this.student.id,
              })
              .then((response) => {
                // destroy the vue listeners, etc
                this.$destroy();

                // remove the element from the DOM
                this.$el.parentNode.removeChild(this.$el);
                let gold = response.data.gold;
                if (gold)
                  this.$toast(response.data.message, {
                    type: "default",
                    timeout: 0,
                    closeButton: Buttons,
                  });
                else
                  this.$toast(response.data.message, {
                    type: response.data.type,
                  });
              });
          },
        });
      } else {
        this.$buefy.dialog.confirm({
          title: this.trans.get("cards.use_title"),
          message: this.card.automatic ? this.trans.get("cards.use_text_automatic") : this.trans.get("cards.use_text"),
          confirmText: this.trans.get("cards.use_confirm"),
          cancelText: this.trans.get("general.cancel"),
          type: "is-warning",
          hasIcon: true,
          icon: "times-circle",
          iconPack: "fa",
          ariaRole: "alertdialog",
          ariaModal: true,
          onConfirm: () => {
            axios
              .post("/classroom/" + this.code + "/card/mark/" + this.card.id, {
                type: type,
                student: this.student.id,
              })
              .then((response) => {
                if(this.card.automatic)
                  location.reload();
                this.$toast(response.data.message, {
                  type: response.data.type,
                });
                if (response.data.type == "success") card.pivot.marked = type;
                this.$forceUpdate();
              });
          },
        });
      }
    },
    getMessage(marked) {
      if (this.checkLevel()) return this.trans.get("students.card_level");
      else if (marked == 1) {
        return this.trans.get("students.card_marked");
      } else return this.trans.get("students.card_use");
    },
    checkLevel() {
      let number = 0;
      if (this.$parent.$parent.$parent.student.level != null)
        number = this.$parent.$parent.$parent.student.level.number;
      return this.card.min_lvl > number ? true : false;
    },
    confirmDelete() {
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
        onConfirm: () => {
          axios.delete("/classroom/card/" + this.card.id).then((response) => {
            if (response.data === 1) {
              this.$el.parentNode.removeChild(this.$el);
            }
          });
        },
      });
    },
  },
};
</script>
<style>
.grayscale {
  filter: grayscale(100%);
}
</style>