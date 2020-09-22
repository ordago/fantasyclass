<template>
  <span>
    <span class="level-top rounded has-padding-4 has-background-light" v-if="student.level">
      {{ student.level.number }}
    </span>
    <show-level class="level-hidden" style :level="student.level" :edit="false"></show-level>
    <span v-if="student.grouplogo" class="top-right is-full-rounded">
      <img :src="student.grouplogo" class="is-full-rounded" />
    </span>
    <div
      class="card-image card-shadow-s rounded-top char-bg"
      :style="'background-color:' + classroom.theme.color + ';background-image: url(/img/bg/thumb_' + classroom.theme.name + ');'"
    >
      <span
        v-if="student.boost"
        class="boost-right outer_glow_dark"
        v-tippy
        :content="'<i class=\'fas fa-heart colored\'></i>' + student.boost.hp + '% | <i class=\'fas fa-fist-raised colored\'></i>' + student.boost.xp + '% | <i class=\'fas fa-coins colored\'></i>' + student.boost.gold + '%'"
      >
        <i class="fas fa-arrow-alt-square-up"></i>
      </span>
      <div
        v-if="classroom.character_theme != 0"
        class="character-container character character-small is-relative"
      >
        <img
          :src="'/img/character/' + element.src"
          :class="element.classes"
          v-for="element in student.equipment"
          v-bind:key="element.id"
        />
      </div>
      <div v-else class="is-flex has-all-centered has-padding-y-3">
        <img :src="student.avatar" width="128px" height="128px" class="rounded" alt />
      </div>
    </div>
  </span>
</template>

<script>
export default {
  props: ["student", "classroom"],
  mounted() {},
  data: function () {
    return {};
  },
};
</script>
