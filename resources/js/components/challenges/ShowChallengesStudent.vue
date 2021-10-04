<template>
  <div class="p-2">
    <div class="mb-2">
      <button @click="setOpt('challenges_type', 0);" class="button is-rounded" :class="{ 'has-background-info-light' : type == 0 }">
        <span> {{ trans.get('challenges.filter_all') }} </span>
      </button>
      <button @click="setOpt('challenges_type', 1);" class="button is-rounded" :class="{ 'has-background-info-light' : type == 1 }">
        <span> {{ trans.get('challenges.filter_ok') }} </span>
      </button>
      <button @click="setOpt('challenges_type', 2);" class="button is-rounded" :class="{ 'has-background-info-light' : type == 2 }">
        <span> {{ trans.get('challenges.filter_ko') }} </span>
      </button>
      <i class="fas fa-ellipsis-v mx-2 mt-3"></i>
      <button @click="setOpt('challenges_cat', 0);" class="button is-rounded" :class="{ 'has-background-info-light' : cat == 0 }">
        <span> {{ trans.get('challenges.filter_cats_all') }} </span>
      </button>
      <button :class="{ 'has-background-info-light' : cat == category.id }" @click="setOpt('challenges_cat', category.id);" class="button is-rounded" v-for="category in cats" :key="'category-' + category.id">
        <span> <i class="mr-1" :class="category.icon"></i> {{ category.name }} </span>
      </button>
    </div>
    <show-challenge
      v-for="challenge in filteredChallenges"
      :key="challenge.id"
      class="mb-3"
      :full="true"
      :prev-rating="challenge.rated"
      :challenge="challenge"
      :edit="false"
      :admin="false"
      :code="code"
    ></show-challenge>
  </div>
</template>

<script>
// import Utils from "../../utils.js";

export default {
  props: ["challenges", "code", "cats"],
  created() {
    this.cat = $cookies.get("challenges_cat") ?? 0;
    this.type = $cookies.get("challenges_type") ?? 0;
  },
  data: function () {
    return {
      cat: 0,
      type: 0,
    };
  },
  methods: {
     setOpt(name, type) {
      this.$cookies.set(name, type, Infinity);
      if(name == "challenges_type")
        this.type = type;
      else
        this.cat = type;
    },
  },
  computed: {
    filteredChallenges: function () {
      let challenges = this.challenges;
      if(this.cat != 0) {
         challenges = this.challenges.filter((challenge) => {
          return challenge.group.id == this.cat;
        });
      }
      if(this.type == 1) {
        challenges = challenges.filter((challenge) => {
          return challenge.completed == true;
        });
      } else if(this.type == 2) {
        challenges = challenges.filter((challenge) => {
          return challenge.completed != true && challenge.is_conquer == 1;
        });
      }
      return challenges;
    },
  },
};
</script>