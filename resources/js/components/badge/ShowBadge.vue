<template>
  <div class="p-2">
    <div v-if="admin">
      <div
        @click="toggle(badge.id)"
        :class="{
          personalBadge: badge.type == 0,
          notColored: findInStudent(badge.id),
        }"
        v-tippy
        :content="
          '<h1>' + badge.title + '</h1><h3>' + badge.description + '</h3>'
        "
      >
        <i :class="badge.icon" v-if="badge.type == 0"></i>
        <img class="rounded" v-else width="80px" :src="badge.image" />
      </div>
    </div>
    <div v-else>
      <div
        v-tippy
         :class="{
          personalBadge: badge.type == 0,
        }"
        :content="
          '<h1>' + badge.title + '</h1><h3>' + badge.description + '</h3>'
        "
      >
        <i :class="badge.icon" v-if="badge.type == 0"></i>
        <img class="rounded" v-else width="80px" :src="badge.image" />
      </div>
    </div>
  </div>
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