<template>
  <span class="mr-1 has-all-centered" :class="{'skill-container' : !use, 'skill-container-big' : use}">
    <img
      :src="skill.icon"
      class="cursor-pointer skill-item"
      :class="{'skill-item-big' : use}"
      v-tippy="{ interactive: true, theme: 'light', arrow: true, trigger : 'click' }"
      :content="getSkillMessage()"
    />
    <span
      class="tag is-info"
      v-if="skill.pivot.count && skill.pivot.count > 1"
      style="position: absolute; right: 0; bottom: 0; opacity: 0.85"
      ><small>{{ skill.pivot.count }}</small></span
    >
  </span>
</template>

<script>
import Utils from "../../utils.js";

import SelectSkill from "../utils/SelectSkill.vue";

export default {
  props: ["code", "skill", "admin", "use"],

  created() {
    window.removeSkill = this.removeSkill;
    window.useSkill = this.useSkill;
  },
  data: function () {
    return {};
  },
  components: {},
  methods: {
    getSkillMessage() {
      let message =
        '<h4 class="is-size-4 has-text-left"> ' +
        this.trans.get(this.skill.name) +
        "</h4>";
      message +=
        '<h5 class="is-size-5 has-text-left"> ' +
        this.trans.get(this.skill.description) +
        "</h5>";
      message += `<div class='has-text-left my-2'><small class="is-italic">${this.trans.get(
        "skills.type"
      )}: <span class="tag is-dark ml-1 pl-1 pr-2">${
        this.skill.type == 0
          ? this.trans.get("skills.active")
          : this.trans.get("skills.passive")
      }</span></small>`;

      if (this.skill.properties.success) {
        message += `<div class="my-2"><small class="is-italic my-2">Success: ${this.skill.properties.success}%</small></div>`;
      }
      if (this.skill.properties.hp_min) {
        message += `<div class="my-2"><small class="is-italic my-2"><i class="fas fa-heart colored"></i>: ${this.skill.properties.hp_min} - ${this.skill.properties.hp_max}</small></div>`;
      }
      if (this.skill.properties.money_min) {
        message += `<div class="my-2"><small class="is-italic my-2"><i class="fas fa-coins colored"></i>: ${this.skill.properties.money_min} - ${this.skill.properties.money_max} x ${this.skill.properties.users} <i class="fas fa-user"></i></small></div>`;
      }
      if (this.skill.properties.xp_min) {
        message += `<div class="my-2"><small class="is-italic my-2"><i class="fas fa-fist-raised colored"></i>: ${this.skill.properties.xp_min} - ${this.skill.properties.xp_max} x ${this.skill.properties.users} <i class="fas fa-user"></i></small></div>`;
      }
      if (this.skill.properties.hp_increment) {
        message += `<div class="my-2"><small class="is-italic my-2"><i class="fas fa-heart colored"></i><i class="fas fa-arrow-up"></i>: ${this.skill.properties.hp_increment}%</small></div>`;
      }
      if (this.skill.properties.cards) {
        message += `<div class="my-2"><small class="is-italic my-2"><i class="fas fa-club colored"></i><i class="fas fa-arrow-up"></i>: ${this.skill.properties.cards}</small></div>`;
      }
      message += "</div>";
      message += "<div class='has-text-left'>";
      if (this.use && this.skill.type == 0) {
        message += `<small><span class="tag is-success mx-2 cursor-pointer" onclick="useSkill(${this.skill.id})">${this.trans.get(
          "cards.use"
        )}</span></small>`;
      }
      if (this.use) {
        message += `<small><span class="tag is-danger cursor-pointer" onclick="removeSkill(${this.skill.id})">${this.trans.get(
          "cards.delete"
        )}</span></small>`;
      }
      message += "</div>";

      return message;
    },
    removeSkill(id) {
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
          let student;
          if(this.admin)
            student = this.$parent.student.id
          axios
            .post(
              "/classroom/" +
                this.code +
                "/student/skills/delete/",
                {skill: id, student: student}
            )
            .then((response) => {
              this.$parent.student.skills = response.data;
              this.$parent.$forceUpdate();
              this.notify();
            });
        },
      });
    },
    notify(type) {
      this.$toast(this.trans.get('success_error.update_success', {type: 'success'}))
    },
    useSkill(id) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("skills.use"),
        message: this.trans.get("skills.use_info"),
        confirmText: this.trans.get("skills.use"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-warning",
        hasIcon: true,
        icon: "exclamation-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          let student;
          if(this.admin)
            student = this.$parent.student.id
          axios
            .post(
              "/classroom/" +
                this.code +
                "/student/skills/use"
            , {
              skill: id,
              student: student,
            })
            .then((response) => {
              this.$parent.student.gold = response.data.gold;
              this.$parent.student.hp = response.data.hp;
              this.$parent.student.xp = response.data.xp;
              this.$parent.student.skills = response.data.skills;
              this.$parent.student.logEntries = response.data.logEntries;
              this.$parent.$forceUpdate();
              this.notify();
            });
        },
      });
    },
  },
};
</script>
<style>
.skill-item {
  z-index: 100;
  width: 38px;
  border-radius: 5px;
}
.skill-item-big {
  width: 48px;
}
.skill-container {
  position: relative;
  background-image: url("/img/skill.png");
  width: 40px;
  height: 40px;
}
.skill-container-big {
  position: relative;
  width: 50px;
  height: 50px;
  background-image: url("/img/skill-big.png");
}
</style>