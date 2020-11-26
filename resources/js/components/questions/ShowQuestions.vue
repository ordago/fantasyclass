<template>
  <div class="pl-0">
    <div class="panel is-secondary pl-0">
      <p class="panel-heading is-flex has-space-between align-items-center p-3">
        <span>
          <i class="fad fa-books"></i>

          <span class="pl-3">{{ bank.title }}</span>
          <!-- <button style="font-size: .5em" class="button is-info"><i class="fas fa-edit"></i></button> -->
          <button
            style="font-size: 0.5em"
            class="button is-danger"
            @click="deleteBank(bank.id)"
            v-if="questions.length == 0"
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
          <button class="button" @click="isQuestionModalActive = true">
            <span v-html="buttonAddChallege(1)" class="is-hidden-tablet"></span>
            <span v-html="buttonAddChallege(0)" class="is-hidden-mobile"></span>
          </button>
        </span>
      </p>
      <div class="panel-block" v-if="!addQuestion && questions.length > 0">
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

      <div class="panel-block" v-if="addQuestion">
        <!-- <CreateChallenges
          :edit="challengeEdit"
          :import-flag="importFlag"
          :challengegroups="$parent.challengesgroup"
          :code="code"
          :challengegroup="challengegroup.id"
          :students-loaded="students"
        ></CreateChallenges> -->
      </div>

      <div class="panel-block" v-if="questions.length == 0 && !addQuestion">
        <h3 class="is-size-3 p-4 w-100 has-text-centered">
          <i class="fal fa-smile-wink"></i>
          {{ trans.get("questions.empty") }}
        </h3>
      </div>

      <div
        class="panel-block is-block p-3"
        v-if="questions.length > 0 && !addQuestion"
      >
        <div v-for="question in filteredList" v-bind:key="question.id">
          <ShowQuestion :code="code" :question="question"></ShowQuestion>
        </div>
      </div>
    </div>

    <b-modal
      :active.sync="isQuestionModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addQuestion">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              {{ trans.get("challenges.add_question") }}
            </p>
          </header>
          <section class="modal-card-body">
            <b-tabs v-model="type" type="is-toggle" expanded>
              <b-tab-item label="Test" icon-pack="fal" icon="list">
                <div class="py-3">
                  <b-field>
                    <b-input
                      :placeholder="trans.get('challenges.question')"
                      v-model="question.name"
                      type="text"
                      required
                    ></b-input>
                  </b-field>
                  <div class="field is-horizontal mb-3">
                    <div class="field-body">
                      <div class="field is-expanded">
                        <div class="field has-addons">
                          <p class="control">
                            <a class="button is-success">
                              <i class="fas fa-check colored"></i>
                            </a>
                          </p>
                          <p class="control is-expanded">
                            <b-field>
                              <b-input
                                :placeholder="
                                  trans.get('challenges.correct_answer')
                                "
                                v-model="question.correctAnswer"
                                type="text"
                                required
                              ></b-input>
                            </b-field>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="field is-horizontal mb-3">
                    <div class="field-body">
                      <div class="field is-expanded">
                        <div class="field has-addons">
                          <p class="control">
                            <a class="button is-danger">
                              <i class="fas fa-times colored"></i>
                            </a>
                          </p>
                          <p class="control is-expanded">
                            <b-field>
                              <b-input
                                :placeholder="
                                  trans.get('challenges.incorrect_answer')
                                "
                                v-model="question.incorrectAnswer1"
                                required
                                type="text"
                              ></b-input>
                            </b-field>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="field is-horizontal mb-3">
                    <div class="field-body">
                      <div class="field is-expanded">
                        <div class="field has-addons">
                          <p class="control">
                            <a class="button is-danger is-light">
                              <i class="fas fa-times colored"></i>
                            </a>
                          </p>
                          <p class="control is-expanded">
                            <b-field>
                              <b-input
                                :placeholder="
                                  trans.get('challenges.incorrect_answer')
                                "
                                v-model="question.incorrectAnswer2"
                                type="text"
                              ></b-input>
                            </b-field>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="field is-horizontal mb-3">
                    <div class="field-body">
                      <div class="field is-expanded">
                        <div class="field has-addons">
                          <p class="control">
                            <a class="button is-danger is-light">
                              <i class="fas fa-times colored"></i>
                            </a>
                          </p>
                          <p class="control is-expanded">
                            <b-field>
                              <b-input
                                :placeholder="
                                  trans.get('challenges.incorrect_answer')
                                "
                                v-model="question.incorrectAnswer3"
                                type="text"
                              ></b-input>
                            </b-field>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </b-tab-item>
              <b-tab-item label="Respuesta simple" icon-pack="fal" icon="text">
                <div class="py-3">
                  <b-field>
                    <b-input
                      :placeholder="trans.get('challenges.question')"
                      v-model="question1.name"
                      type="text"
                      required
                    ></b-input>
                  </b-field>
                  <b-field>
                    <b-input
                      :placeholder="trans.get('challenges.answer')"
                      type="text"
                      v-model="currentAnswer"
                    ></b-input>
                  </b-field>
                  <div class="field">
                    <b-checkbox v-model="currentCaseSensitive">
                      Distinguir mayúsculas y minúsculas
                    </b-checkbox>
                  </div>
                  <button class="button" @click.prevent="addAnswer">
                    Add answer
                  </button>
                  <div
                    class="p-2 m-2 border"
                    v-for="(answer, index) in question1.answers"
                    :key="index"
                  >
                    {{ answer.answer }}
                  </div>
                </div>
              </b-tab-item>
            </b-tabs>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="isQuestionModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <button @click.prevent="sendQuestion" class="button is-primary">
              {{ trans.get("general.add") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>

    <!-- <b-modal :active.sync="isImportModalActive" has-modal-card full-screen>
      <import-challenge
        :classroom="code"
        :bank="bank.id"
      ></import-challenge>
    </b-modal> -->
  </div>
</template>
<script>
// import CreateChallenges from "./Createquestions.vue";
import ShowQuestion from "./ShowQuestion.vue";

export default {
  props: ["bank", "questions", "code"],
  created: function () {},
  data: function () {
    return {
      type: 0,
      question: {
        name: "",
        correctAnswer: null,
        incorrectAnswer1: null,
        incorrectAnswer2: null,
        incorrectAnswer3: null,
      },
      question1: {
        name: null,
        answers: [],
      },
      currentAnswer: "",
      currentCaseSensitive: true,
      addQuestion: false,
      search: "",
      importFlag: false,
      challengeEdit: null,
      isModalActive: false,
      isImportModalActive: false,
      isQuestionModalActive: false,
      students: null,
      groups: null,
      currentChallenge: null,
      mark: null,
    };
  },
  methods: {
    sendQuestion() {
      let type = this.type + 1;
      let question;
      if (type == 1) {
        question = this.question;
      } else if (type == 2) {
        question = this.question1;
      }
      axios.post("/classroom/question/add", { type: type, bank: this.bank.id, question: question })
      .then(response => {
        console.log(response.data)
      })
    },
    addAnswer() {
      if (this.currentAnswer != "") {
        this.question1.answers.push({
          answer: this.currentAnswer,
          caseSensitive: this.currentCaseSensitive,
        });
        this.$forceUpdate();
      }
      this.currentAnswer = "";
      this.$forceUpdate();
    },
    deleteBank(id) {
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
        });
    },
    toggleChallenge(id) {
      axios.post("/classroom/" + this.code + "/challenges/toggle", {
        id: id,
        challenge: this.currentChallenge.id,
      });
    },
    buttonAddChallege(type) {
      let append =
        type == 0
          ? "<span class='ml-2'>" + this.trans.get("questions.add") + "</span>"
          : "";
      return this.addQuestion
        ? this.trans.get("general.cancel")
        : "<i class='far fa-plus'></i>" + append;
    },
  },
  components: {
    // CreateChallenges,
    ShowQuestion,
  },
  computed: {
    filteredList: function () {
      return this.orderedQuestions.filter((question) => {
        return question.name.toLowerCase().includes(this.search.toLowerCase());
      });
    },
    orderedQuestions: function () {
      return _.orderBy(this.questions, "datetime", "desc");
    },
  },
  updated: function () {},
};
</script>