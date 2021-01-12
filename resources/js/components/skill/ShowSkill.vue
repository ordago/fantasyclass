<template>
  <span class="skills-big mx-1 is-flex has-all-centered">
    <img
      :src="skill.icon"
      @click="removeSkill()"
      class="skill-item skill-item-big cursor-pointer"
      v-tippy
      interactive
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

  created() {},
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
      )}: <span class="tag is-light ml-1 pl-1 pr-2">${
        this.skill.type == 0
          ? this.trans.get("skills.active")
          : this.trans.get("skills.passive")
      }</span></small></div>`;

      if(this.skill.properties.success) {
        message += `<div class='has-text-left my-2'><small class="is-italic">Success: ${this.skill.properties.success}%</small></div>`
      }
      if(this.skill.properties.hp_increment) {
        message += `<div class='has-text-left my-2'><small class="is-italic"><i class="fas fa-heart colored"></i><i class="fas fa-arrow-up"></i>: ${this.skill.properties.hp_increment}%</small></div>`
      }
      if(this.skill.properties.cards) {
        message += `<div class='has-text-left my-2'><small class="is-italic"><i class="fas fa-club colored"></i><i class="fas fa-arrow-up"></i>: ${this.skill.properties.cards}</small></div>`
      }

      return message;
    },
    removeSkill() {
      axios
        .get(
          "/classroom/" + this.code + "/student/skills/delete/" + this.skill.id
        )
        .then((response) => {
          this.$parent.student.skills = response.data;
          this.$parent.$forceUpdate();
        });
    },
  },
};
</script>