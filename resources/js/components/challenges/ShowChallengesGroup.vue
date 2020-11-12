<template>
  <div class="columns p-2">
    <div class="column is-narrow pr-0" style="min-width: 400px">
      <article class="panel is-sticky-panel is-info">
        <p
          class="panel-heading is-flex has-space-between align-items-center p-3"
        >
          <span>{{ trans.get("challenges.categories") }}</span>
          <button
            class="button"
            @click="activeAddGroup = !activeAddGroup"
            v-html="buttonAddGroup"
          ></button>
        </p>

        <div
          class="panel-block is-flex is-flex-column p-0"
          style="align-items: flex-start"
          v-for="challenge in challengesgroup"
          v-bind:key="challenge.id"
        >
          <div
            @click="
              getChallenges(challenge.id);
              activeGroup = challenge;
            "
            class="highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer pl-1 pr-4 py-3"
          >
            <span class="p-2">
              <span class="panel-icon">
                <i :class="challenge.icon" aria-hidden="true"></i>
              </span>
              <span :title="challenge.name">
                {{
                  challenge.name.length > 30
                    ? challenge.name.substring(0, 30) + "..."
                    : challenge.name
                }}
                <!-- <b-tag type="is-info is-light" class="has-small-font">{{ challenge.numChallenges }}</b-tag> -->
              </span>
            </span>
            <span class="p-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
          <div
            @click="
              activeGroup = challengeChild;
              getChallenges(challengeChild.id);
            "
            class="highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer pl-5 pr-4 py-3"
            v-for="challengeChild in challenge.children"
            v-bind:key="challengeChild.id"
          >
            <span class="p-2">
              <span class="panel-icon">
                <i :class="challengeChild.icon" aria-hidden="true"></i>
              </span>
              <span :title="challengeChild.name">
                {{
                  challengeChild.name.length > 30
                    ? challengeChild.name.substring(0, 30) + "..."
                    : challengeChild.name
                }}
                <!-- <small>
                  <b-tag
                    type="is-info is-light"
                    class="has-small-font"
                  >{{ challengeChild.numChallenges }}</b-tag>
                </small> -->
              </span>
            </span>
            <span class="p-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
        </div>
      </article>
    </div>
    <div class="column pr-0">
      <!-- <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading> -->

      <CreateChallengeGroup
        :code="code"
        v-if="activeAddGroup"
      ></CreateChallengeGroup>
      <ShowChallenges
        :icon="icon"
        :code="code"
        :challengegroup="activeGroup"
        :challenges="challenges"
        v-if="!activeAddGroup && activeGroup && !isLoading"
      ></ShowChallenges>
    </div>
  </div>
</template>
<script>
import CreateChallengeGroup from "./CreateChallengeGroup.vue";
import ShowChallenges from "./ShowChallenges.vue";

export default {
  props: ["code", "challengesgroup", "icon"],
  mounted: function () {},
  data: function () {
    return {
      activeAddGroup: false,
      activeGroup: false,
      updated: false,
      challenges: [],
      isLoading: false,
    };
  },
  methods: {
    refresh: function (elem) {
      if (elem.challenges_group_id) {
        let challenge = this.challengesgroup.filter(function (data) {
          return data.id == elem.challenges_group_id;
        });
        challenge[0].children.push(elem);
      } else this.challengesgroup.push(elem);
      this.$forceUpdate();
    },
    getChallenges(id) {
      // this.isLoading = true;
      axios
        .post("/classroom/" + this.code + "/challenges/get", { id: id })
        .then((response) => {
          // this.isLoading = false;
          this.challenges = response.data;
          // this.$forceUpdate();
        });
    },
  },
  components: {
    CreateChallengeGroup,
    ShowChallenges,
  },
  computed: {
    buttonAddGroup() {
      return this.activeAddGroup
        ? this.trans.get("general.cancel")
        : "<i class='far fa-plus pr-2'></i>" +
            this.trans.get("challenges.add_category");
    },
  },
};
</script>
