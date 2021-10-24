<template>
  <div class="pl-0">
    <div class="panel is-primary pl-0">
      <p class="panel-heading is-flex has-space-between align-items-center p-3">
        <span>
          <i :class="challengegroup.icon"></i>
          <span class="pl-3">{{ challengegroup.name }}</span>
          <!-- <button style="font-size: .5em" class="button is-info"><i class="fas fa-edit"></i></button> -->
          <button
            style="font-size: 0.5em"
            class="button is-danger"
            @click="deleteChallengeGroup(challengegroup.id)"
            v-if="challenges.length == 0 && !$parent.isLoading"
          >
            <i class="fas fa-trash"></i>
          </button>
        </span>
        <span>
          <button class="button" @click="isImportModalActive = true">
            <i class="fas fa-file-import"></i>
            <span class="is-hidden-mobile ml-2">{{
              trans.get("general.import")
            }}</span>
          </button>
          <button
            class="button"
            @click="
              challengeEdit = null;
              addChallenge = !addChallenge;
            "
          >
            <span v-html="buttonAddChallege(1)" class="is-hidden-tablet"></span>
            <span v-html="buttonAddChallege(0)" class="is-hidden-mobile"></span>
          </button>
        </span>
      </p>
      <div class="panel-block" v-if="!addChallenge && challenges.length > 0">
        <p class="control has-icons-left">
          <input
            class="input"
            type="text"
            v-model="search"
            placeholder="Search"
          />
          <span class="icon is-left">
            <i class="fas fa-search" aria-hidden="true"></i>
          </span>
        </p>
      </div>

      <div class="panel-block" v-if="addChallenge">
        <CreateChallenges
          :edit="challengeEdit"
          :import-flag="importFlag"
          :iconPrev="icon"
          :challengegroups="$parent.challengesgroup"
          :code="code"
          :challengegroup="challengegroup.id"
          :students-loaded="students"
        ></CreateChallenges>
      </div>

      <div class="panel-block" v-if="challenges.length == 0 && !addChallenge">
        <h3 class="is-size-3 p-4 w-100 has-text-centered">
          <i class="fal fa-smile-wink"></i>
          {{ trans.get("challenges.empty") }}
        </h3>
      </div>

      <div
        class="panel-block is-block p-3"
        v-if="challenges.length > 0 && !addChallenge"
      >
        <div v-for="challenge in filteredList" v-bind:key="challenge.id">
          <ShowChallenge
            class="mb-3"
            :code="code"
            :challenge="challenge"
            :admin="true"
            :edit="true"
            :students="students"
          ></ShowChallenge>
        </div>
      </div>
    </div>
    <b-modal :active.sync="isModalActive" width="95%" scroll="keep">
      <div v-if="currentChallenge" class="p-5 rounded has-background-light">
        <h1 class="is-size-1 mb-3">
          {{ currentChallenge.title }}
        </h1>
        <div v-if="currentChallenge.type == 0 && isModalActive">
          <button class="button is-info" @click="selectAll()">
            {{ trans.get("utils.select_all") }}
          </button>
          <button class="button is-success" :class="{ 'is-loading': isLoading }" @click="sendStudentsChallenge">
            <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
          </button>
          <div class="columns is-1 is-multiline p-3 mt-2">
            <div
              v-for="student in students"
              class="column is-half"
              :key="student.id"
            >
              <div class="p-3 border rounded">
                <div class="columns">
                  <div
                    class="
                      column
                      is-narrow is-flex
                      has-all-centered
                      is-hidden-tablet
                    "
                  >
                    <img
                      :src="student.avatar"
                      width="32px"
                      alt="student image"
                    />
                    <span class="ml-1"
                      ><strong>{{ student.name }}</strong></span
                    >
                  </div>
                  <div class="column is-narrow is-flex has-all-centered">
                    <div class="field mb-0">
                      <b-field>
                        <b-radio-button
                          v-model="student.challenges[0].pivot.count"
                          :native-value="0"
                          type="is-danger is-light"
                        >
                          <b-icon icon="times" icon-pack="fas"></b-icon>
                        </b-radio-button>

                        <b-radio-button
                          v-model="student.challenges[0].pivot.count"
                          :native-value="null"
                          type="is-dark is-light"
                        >
                          <span>-</span>
                        </b-radio-button>

                        <b-radio-button
                          :disabled="checkDisabled(student)"
                          v-model="student.challenges[0].pivot.count"
                          :native-value="1"
                          type="is-success is-light"
                        >
                          <b-icon icon="check" icon-pack="fas"></b-icon>
                          {{ trans.get("challenges.completed") }}
                        </b-radio-button>
                      </b-field>
                    </div>
                  </div>
                  <div
                    class="
                      column
                      is-narrow is-flex
                      has-all-centered
                      is-hidden-mobile
                    "
                  >
                    <img
                      :src="student.avatar"
                      width="32px"
                      alt="student image"
                    />
                    <span class="ml-1"
                      ><strong>{{ student.name }}</strong></span
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="currentChallenge.type == 1">
          <button class="button is-info" @click="selectAllGroup()">
            {{ trans.get("utils.select_all") }}
          </button>
          <button class="button is-success" @click="sendGroupChallenge">
            <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
          </button>
          <div class="columns is-1 is-multiline p-3 mt-2">
           <div v-for="group in groups" class="p-3" :key="group.id">
              <div class="p-3 border rounded">
                <div class="columns">
                  <div
                    class="
                      column
                      is-narrow is-flex
                      has-all-centered
                      is-hidden-tablet
                    "
                  >
                    <img
                      :src="group.logo"
                      width="32px"
                      alt="student image"
                    />
                    <span class="ml-1"
                      ><strong>{{ group.name }}</strong></span
                    >
                  </div>
                  <div class="column is-narrow is-flex has-all-centered">
                    <div class="field mb-0">
                      <b-field>
                        <b-radio-button
                          v-model="group.challenges[0].pivot.count"
                          :native-value="0"
                          type="is-danger is-light"
                        >
                          <b-icon icon="times" icon-pack="fas"></b-icon>
                        </b-radio-button>

                        <b-radio-button
                          v-model="group.challenges[0].pivot.count"
                          :native-value="null"
                          type="is-dark is-light"
                        >
                          <span>-</span>
                        </b-radio-button>

                        <b-radio-button
                          v-model="group.challenges[0].pivot.count"
                          :native-value="1"
                          type="is-success is-light"
                        >
                          <b-icon icon="check" icon-pack="fas"></b-icon>
                          {{ trans.get("challenges.completed") }}
                        </b-radio-button>
                      </b-field>
                    </div>
                  </div>
                  <div
                    class="
                      column
                      is-narrow is-flex
                      has-all-centered
                      is-hidden-mobile
                    "
                  >
                    <img
                      :src="group.logo"
                      width="32px"
                      alt="student image"
                    />
                    <span class="ml-1"
                      ><strong>{{ group.name }}</strong></span
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div v-for="group in groups" class="p-3" :key="group.id">
            <div class="columns">
              <div class="column is-narrow is-flex has-all-centered">
                <div class="field">
                  <b-switch
                    :value="group.challenges.length ? 1 : 0"
                    true-value="1"
                    false-value="0"
                    @input="toggleChallenge(group.id)"
                    type="is-info"
                    >{{ group.name }}</b-switch
                  >
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
    </b-modal>
    <b-modal :active.sync="isImportModalActive" has-modal-card full-screen>
      <import-challenge
        :classroom="code"
        :challengegroup="challengegroup.id"
      ></import-challenge>
    </b-modal>
  </div>
</template>
<script>
import CreateChallenges from "./CreateChallenges.vue";
import ShowChallenge from "./ShowChallenge.vue";

export default {
  props: ["challengegroup", "challenges", "code", "icon"],
  created: function () {},
  data: function () {
    return {
      addChallenge: false,
      isLoading: false,
      search: "",
      importFlag: false,
      challengeEdit: null,
      isModalActive: false,
      isImportModalActive: false,
      students: null,
      groups: null,
      currentChallenge: null,
      mark: null,
    };
  },
  methods: {
    deleteChallengeGroup(id) {
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
          axios.delete("/classroom/challenges/group/" + id).then((response) => {
            location.reload();
          });
        },
      });
    },
    confirmDelete(id) {
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
          axios.delete("/classroom/challenges/" + id).then((response) => {
            if (response.data === 1) {
              this.$parent.getChallenges(this.challengegroup.id);
            }
          });
        },
      });
    },
    showModal(challenge) {
      this.currentChallenge = challenge;
      axios
        .post("/classroom/" + this.code + "/challenges/info", {
          type: challenge.type,
          challenge: challenge.id,
        })
        .then((response) => {
          if (challenge.type == 0) this.students = response.data;
          else this.groups = response.data;
          this.isModalActive = true;
          this.isLoading = false;
        });
    },
    checkDisabled(student) {
      let foundItems = 0;
      if (
        this.currentChallenge.requirements &&
        this.currentChallenge.requirements.length &&
        !student.challenges[0].pivot.count
      ) {
        this.currentChallenge.requirements.forEach((element) => {
          let found = student.items.find((object) => object.id == element.id);
          if (found) foundItems++;
        });
        if (foundItems != this.currentChallenge.requirements.length)
          return true;
      }
      return false;
    },
    selectAll() {
      this.students.forEach((student) => {
        // this.toggleChallenge(student.id, true);
        student.challenges[0].pivot.count = 1;
        student.challenges[0].pivot.evaluated = 1;
      });
      this.$forceUpdate();
    },
    selectAllGroup() {
      this.groups.forEach((group) => {
        // this.toggleChallenge(group.id, true);
        group.challenges[0].pivot.count = 1;
        group.challenges[0].pivot.evaluated = 1;
      });
      this.$forceUpdate();
    },
    sendStudentsChallenge() {
      this.isLoading = true;
      axios
        .post("/classroom/" + this.code + "/challenges/update", {
          challenge: this.currentChallenge.id,
          students: this.students,
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
          this.isLoading = false;
          this.isModalActive = false;
        });
    },
    sendGroupChallenge() {
      axios
        .post("/classroom/" + this.code + "/challenges/groups/update", {
          challenge: this.currentChallenge.id,
          groups: this.groups,
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
          this.isModalActive = false;
        });
    },
    toggleChallenge(id, force = false) {
      axios
        .post("/classroom/" + this.code + "/challenges/toggle", {
          id: id,
          challenge: this.currentChallenge.id,
          force: force,
        })
        .then((response) => {
          this.students.forEach((student) => {
            if (student.id == id) {
              student.challenges = response.data;
            }
          });
        });
    },
    buttonAddChallege(type) {
      let append =
        type == 0
          ? "<span class='ml-2'>" + this.trans.get("challenges.add") + "</span>"
          : "";
      return this.addChallenge
        ? this.trans.get("general.cancel")
        : "<i class='far fa-plus'></i>" + append;
    },
  },
  components: {
    CreateChallenges,
    ShowChallenge,
  },
  computed: {
    filteredList: function () {
      return this.orderedChallenges.filter((challenge) => {
        return challenge.title
          .toLowerCase()
          .includes(this.search.toLowerCase());
      });
    },
    orderedChallenges: function () {
      return _.orderBy(this.challenges, "datetime", "desc");
    },
  },
  updated: function () {},
};
</script>