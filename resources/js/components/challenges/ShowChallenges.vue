<template>
  <div class="has-padding-left-0-desktop">
    <div class="panel has-padding-left-0-desktop">
      <p class="panel-heading is-flex has-space-between align-items-center has-padding-3">
        <span class="has-padding-left-3">{{ challengegroup.name }}</span>
        <button class="button" @click="addChallenge=!addChallenge" v-html="buttonAddChallege"></button>
      </p>
      <div class="panel-block" v-if="!addChallenge&&challenges.length > 0">
        <p class="control has-icons-left">
          <input class="input" type="text" v-model="search" placeholder="Search" />
          <span class="icon is-left">
            <i class="fas fa-search" aria-hidden="true"></i>
          </span>
        </p>
      </div>

      <div class="panel-block" v-if="addChallenge">
        <create-challenges
          :edit="challengeEdit"
          :iconPrev="icon"
          :code="code"
          :challengegroup="challengegroup.id"
        ></create-challenges>
      </div>

      <div class="panel-block" v-if="challenges.length == 0 && !addChallenge">
        <h3 class="is-size-3 has-padding-4 w-100 has-text-centered">
          <i class="fal fa-smile-wink"></i>
          {{ trans.get('challenges.empty') }}
        </h3>
      </div>

      <div class="panel-block is-block has-padding-3" v-if="challenges.length > 0 && !addChallenge">
        <div v-for="challenge in filteredList" v-bind:key="challenge.id">
          <show-challenge :challenge="challenge" :admin="true" :edit="true"></show-challenge>
        </div>
      </div>
    </div>
    <b-modal :active.sync="isModalActive" width="95%" scroll="keep">
      <div class="has-padding-5 rounded has-background-light">
        <h1
          class="is-size-1 has-margin-bottom-3"
          v-if="currentChallenge"
        >{{ currentChallenge.title }}</h1>
        <div v-for="student in students" class="has-padding-3" :key="student.id">
          <div class="columns">
            <div class="column is-flex has-all-centered is-narrow">{{ student.name }}</div>
            <div class="column">
              <div class="field">
                <b-switch
                  :value="student.challenges.length ? 1 : 0"
                  true-value="1"
                  false-value="0"
                  @input="toggleChallenge(student.id)"
                  type="is-info"
                ></b-switch>
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: ["challengegroup", "challenges", "code", "icon"],
  created: function() {},
  data: function() {
    return {
      addChallenge: false,
      search: "",
      challengeEdit: null,
      isModalActive: false,
      students: null,
      groups: null,
      currentChallenge: null
    };
  },
  methods: {
    confirmDelete(id) {
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
          axios.delete("/classroom/challenges/" + id).then(response => {
            if (response.data === 1) {
              this.$parent.getChallenges(this.challengegroup.id);
            }
          });
        }
      });
    },
    showModal(challenge) {
      this.currentChallenge = challenge;
      axios
        .post("/classroom/" + this.code + "/challenges/info", {
          type: challenge.type,
          challenge: challenge.id
        })
        .then(response => {
          if(type == 0)
            this.students = response.data;
          else
            this.groups = response.data;
          this.isModalActive = true;
        });
    },
    toggleChallenge($studentId) {
      axios.post("/classroom/" + this.code + "/challenges/toggle", {
        student: $studentId,
        challenge: this.currentChallenge.id
      });
    }
  },
  components: {},
  computed: {
    buttonAddChallege() {
      return this.addChallenge
        ? this.trans.get("general.cancel")
        : "<i class='far fa-plus has-padding-right-2'></i>" +
            this.trans.get("challenges.add");
    },
    filteredList: function() {
      return this.orderedChallenges.filter(challenge => {
        return challenge.title
          .toLowerCase()
          .includes(this.search.toLowerCase());
      });
    },
    orderedChallenges: function() {
      return _.orderBy(this.challenges, "datetime", "desc");
    }
  }
};
</script>