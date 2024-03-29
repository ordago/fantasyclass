<template>
  <div class="columns is-multiline is-variable is-relative is-1 p-2 pt-3">
    <span class="monsters-bar cursor-pointer" @click="monsterBar = true">
      <img class="mt-3" src="/img/eye_small.gif" width="25px" />
    </span>
    <div
      class="column py-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
      v-for="student in orderedStudents"
      v-bind:key="student.id"
    >
      <show-student
        :show-skills="settings.skill_enabled == 1 ? true : false"
        :character-theme="characterTheme"
        :student="student"
        :theme="theme"
      ></show-student>
    </div>
    <infinite-loading
      ref="infiniteComponent"
      :distance="100"
      spinner="waveDots"
      force-use-infinite-wrapper=".infinite"
      :on-infinite="infiniteHandler"
    >
      <div slot="no-more"></div>
      <div slot="no-results"></div>
    </infinite-loading>

    <b-sidebar
      type="is-light"
      :fullheight="true"
      :fullwidth="false"
      :overlay="false"
      :right="true"
      :open.sync="monsterBar"
      icon-pack="fa"
      mobile="fullwidth"
    >
      <div class="pt-5 px-4">
        <div class="close-button" @click="monsterBar = false">
          <button class="button"><i class="fal fa-times"></i></button>
        </div>
        <h4 class="mt-5 is-size-4">{{ trans.get("students.rating") }}</h4>
        <input
          v-if="rating > 0"
          type="range"
          disabled
          min="1"
          max="5"
          :value="rating"
          class="slider mt-2"
        />
        <div class="mt-2" v-else>
          {{ trans.get("students.vote") }}
        </div>
        <h4 class="mt-5 is-size-4" v-if="monsters.length">
          {{ trans.get("menu.monsters") }}
        </h4>
        <div
          class="columns has-hr pb-4 pt-5"
          v-for="monster in monsters"
          :key="monster.id"
        >
          <div class="column is-narrow">
            <img
              @contextmenu.prevent=""
              ref="monster"
              :src="monster.image"
              width="81px"
              class="pet-selector mt-2"
              v-tippy
              :content="
                '<strong class=\'has-text-light\'>' +
                monster.name +
                '</strong> <i class=\'fas fa-fist-raised colored\'></i>: ' +
                monster.reward_xp +
                ', <i class=\'fas fa-coins colored\'></i>: ' +
                monster.reward_gold
              "
              :class="{
                'pet-battle': monster.hp > 0,
                'pet-dead': monster.hp == 0,
              }"
            />
          </div>
          <div class="column is-flex has-all-centered w-100">
            <hp class="w-100" :hp="monster.hp" :size="2"></hp>
          </div>
        </div>
      </div>
    </b-sidebar>
  </div>
</template>

<script>
import Utils from "../../utils.js";
import InfiniteLoading from "vue-infinite-loading";

export default {
  props: ["theme", "characterTheme", "monsters", "rating", "settings", "code"],
  mounted() {},
  data: function () {
    return {
      monsterBar: false,
      sortKey: "xp",
      page: 0,
      students: [],
    };
  },
  methods: {
    infiniteHandler($state) {
      axios
        .post("/classroom/" + this.code + "/studentsview/get", {
          page: this.page,
        })
        .then((response) => {
          let students = response.data.students;
          if (students.length) {
            this.students.push(...students);
            $state.loaded();
          }

          if (!students.length || students.length < this.max) {
            $state.complete();
          }

          this.page++;
        });
    },
  },
  computed: {
    orderedStudents: function () {
      let order = "desc";
      if (this.sortKey == "name") order = "asc";
      return _.orderBy(this.students, this.sortKey, order);
    },
  },
};
</script>
