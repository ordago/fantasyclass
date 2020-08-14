<template>
  <div class="columns">
    <div class="column is-narrow" style="min-width: 400px">
      <article class="panel is-sticky-panel is-info has-padding-bottom-4">
        <p class="panel-heading is-flex has-space-between align-items-center has-padding-3">
          <span>{{ trans.get('challenges.categories') }}</span>
          <button class="button" @click="activeAddGroup=!activeAddGroup" v-html="buttonAddGroup"></button>
        </p>

        <div
          class="panel-block is-flex is-flex-column has-padding-0"
          style="align-items: flex-start;"
          v-for="challenge in challengesgroup"
          v-bind:key="challenge.id"
        >
          <div
            @click="getChallenges(challenge.id);activeGroup=challenge"
            class="highlight-arrow w-100 has-padding-x-4 has-padding-top-4 has-padding-bottom-3 is-fullwidth cursor-pointer is-flex has-space-between"
          >
            <span class="has-padding-2">
              <span class="panel-icon">
                <i :class="challenge.icon" aria-hidden="true"></i>
              </span>
              <span :title="challenge.name">
                {{ challenge.name.length > 30 ? challenge.name.substring(0, 30) + "..." : challenge.name }}
                <b-tag type="is-info is-light" class="has-small-font">{{ challenge.numChallenges }}</b-tag>
              </span>
            </span>
            <span class="has-padding-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
          <div
            @click="activeGroup=challengeChild; getChallenges(challengeChild.id)"
            class="highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer has-padding-left-5 has-padding-right-4 has-padding-y-3"
            v-for="challengeChild in challenge.children"
            v-bind:key="challengeChild.id"
          >
            <span class="has-padding-2">
              <span class="panel-icon">
                <i :class="challengeChild.icon" aria-hidden="true"></i>
              </span>
              <span :title="challengeChild.name">
                {{ challengeChild.name.length > 30 ? challengeChild.name.substring(0, 30) + "..." : challengeChild.name }}
                <small>
                  <b-tag
                    type="is-info is-light"
                    class="has-small-font"
                  >{{ challengeChild.numChallenges }}</b-tag>
                </small>
              </span>
            </span>
            <span class="has-padding-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
        </div>
      </article>
    </div>
    <div class="column has-padding-left-0-desktop">
      <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
      <CreateChallengeGroup :code="code" v-if="activeAddGroup"></CreateChallengeGroup>
      <ShowChallenges
        :icon="icon"
        :code="code"
        :challengegroup="activeGroup"
        :challenges="challenges"
        v-if="!activeAddGroup&&activeGroup&&!isLoading"
      ></ShowChallenges>
    </div>
  </div>
</template>
<script>
import CreateChallengeGroup from "./CreateChallengeGroup.vue";
import ShowChallenges from "./ShowChallenges.vue";

export default {
  props: ["code", "challengesgroup", "icon"],
  mounted: function() {},
  data: function() {
    return {
      activeAddGroup: false,
      activeGroup: false,
      updated: false,
      challenges: [],
      isLoading: false,
      isFullPage: true
    };
  },
  methods: {
    refresh: function(elem) {
      if (elem.challenges_group_id) {
        let challenge = this.challengesgroup.filter(function(data) {
          return data.id == elem.challenges_group_id;
        });
        challenge[0].children.push(elem);
      } else this.challengesgroup.push(elem);
      this.$forceUpdate();
    },
    getChallenges(id) {
      this.isLoading = true;
      axios
        .post("/classroom/" + this.code + "/challenges/get", { id: id })
        .then(response => {
          this.challenges = response.data;
          this.$forceUpdate;
          this.isLoading = false;
        });
    }
  },
  components: {
    CreateChallengeGroup,
    ShowChallenges
  },
  computed: {
    buttonAddGroup() {
      return this.activeAddGroup
        ? this.trans.get("general.cancel")
        : "<i class='far fa-plus has-padding-right-2'></i>" +
            this.trans.get("challenges.add_category");
    }
  }
};
</script>
