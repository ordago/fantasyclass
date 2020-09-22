<template>
  <div class="has-margin-2">
    <div style="text-align:center;" v-if="this.use">
      <button
        type="submit"
        class="button is-success"
        @click="markCard(card, 1)"
        v-tippy
        :content="getMessage(card.pivot.marked)"
        v-bind:class="{ disabled : checkLevel() , 'has-background-dark' : card.pivot.marked == 1 }"
      >
        <i class="fas fa-check"></i> Use
      </button>
      <button
        type="submit"
        v-if="card.xp >= 0 && card.gold >= 0 && card.hp >= 0 "
        @click="markCard(card, 2)"
        class="button is-danger"
        v-bind:class="{ 'has-background-dark' : card.pivot.marked == 2 }"
      >
        <i class="fas fa-trash-alt"></i> Delete
      </button>
    </div>
    <div
      class="cardContainer cardFunction"
      data-id="1"
      group-id
      :style="'background-color:'+ card.background + ';'"
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
              >{{ trans.get(card.title) }}</textPath>
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
        :src="'/img/cardgen/only_back_'+ card.type_bg +'.png'"
        class="background"
        v-if="!card.special && !card.fullscreen"
      />
      <img
        :src="'/img/cardgen/only_back_'+ card.type_bg +'_gold.png'"
        class="background"
        v-if="card.special  && !card.fullscreen"
      />

      <div class="content-cards text_shadow" v-html="description"></div>

      <div class="hiding-parent">
        <img
          :src="card.src"
          :style="'margin-left: '+ card.margin_left + 'px;margin-top:'+ card.margin_top +'px;width:'+card.width+'px;border-radius:'+ card.radius +'px'"
          class="back"
        />
      </div>
      <div class="xp_modify modifiers" v-if="card.xp!=0">
        <img src="/img/cardgen/xp_modify.png" class />
        <span>{{ card.xp }}</span>
      </div>
      <div class="hp_modify modifiers" v-if="card.hp!=0">
        <img src="/img/cardgen/hp_modify.png" class />
        <span>{{ card.hp }}</span>
      </div>
      <div class="gold_modify modifiers" v-if="card.gold!=0">
        <img src="/img/cardgen/gold_modify.png" />
        <span>{{ card.gold }}</span>
      </div>
    </div>
    <div style="text-align:center;" v-if="this.admin==1">
      <a :href="'/classroom/' + code + '/cards/' + card.id" type="submit" class="button is-dark">
        <i class="fas fa-edit"></i>
      </a>
      <button type="submit" @click="confirmDelete" class="button is-danger">
        <i class="fas fa-trash-alt"></i>
      </button>
      <button type="submit" disabled class="button is-primary">
        <i class="fas fa-share-alt"></i>
      </button>
    </div>
  </div>
</template>


<script>
import Utils from "../../utils.js";

export default {
  props: ["card", "admin", "code", "use", "student"],
  mounted() {
    this.description = Utils.styleText(this.trans.get(this.card.description));
  },
  data: function () {
    return {
      description: "",
    };
  },
  methods: {
    markCard(card, type) {
      let number = 0;
      if (this.$parent.$parent.$parent.student.level != null)
        number = this.$parent.$parent.$parent.student.level.number;
      if (type == 1 && this.card.min_lvl > number) return false;

      this.$buefy.dialog.confirm({
        title: this.trans.get("cards.use_title"),
        message: this.trans.get("cards.use_text"),
        confirmText: this.trans.get("cards.use_confirm"),
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
              this.$toasted.show(response.data.message, {
                position: "top-center",
                duration: 3000,
                iconPack: "fontawesome",
                icon: response.data.icon,
                type: response.data.type,
              });
              card.pivot.marked = type;
              this.$forceUpdate();
            });
        },
      });
    },
    getMessage(marked) {
      if (this.checkLevel()) return this.trans.get('students.card_level');
      else if(marked == 1) {
        return this.trans.get('students.card_marked')
      } else return this.trans.get('students.card_use');
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
