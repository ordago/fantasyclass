<template>
  <span class="p-2">
    <span v-if="admin">
      <span
        @click="toggle(badge.id)"
        :class="{
          notColored: findInStudent(badge.id),
        }"
        class="personalBadge"
        :style="'background-image: url(\'' + badge.background + '\')'"
        v-tippy
        :content="
          '<h1 class=\'is-size-5\'>' + badge.title + '</h1><h3>' + badge.description + '</h3>'
        "
      >
        <i :class="badge.icon" class="has-text-light"  v-if="badge.type == 0"></i>
        <!-- <img class="rounded" v-else width="80px" :src="badge.image" /> -->
      </span>
    </span>
    <span v-else>
      <span
        v-tippy
         class="personalBadge"
        :style="'background-image: url(\'' + badge.background + '\')'"
        :content="
          '<h1 class=\'is-size-5\'>' + badge.title + '</h1><h3>' + badge.description + '</h3>'
        "
      >
        <i :class="badge.icon" class="has-text-light" v-if="badge.type == 0"></i>
        <!-- <img class="rounded" v-else width="80px" :src="badge.image" /> -->
      </span>
    </span>
  </span>
</template>

<script>
// import Utils from "../../utils.js";

export default {
  props: ["badge", "admin", "code", "student"],
  created() {},
  data: function () {
    return {};
  },
  methods: {
    toggle(id) {
      axios
        .post("/classroom/student/badge", {
          badge: id,
          student: this.student.id,
        })
        .then((response) => {
          this.student.badges = response.data.badges;
          this.student.hp = response.data.hp;
          this.student.xp = response.data.xp;
          this.student.gold = response.data.gold;
          this.$forceUpdate();
        });
    },
    findInStudent(id) {
      var index = this.student.badges.findIndex(function (badge, i) {
        return badge.id === id;
      });
      if (index >= 0) return false;
      return true;
    },
  },
};
</script>