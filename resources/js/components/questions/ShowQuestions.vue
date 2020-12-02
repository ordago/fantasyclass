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
            v-if="questions.length == 0 && bank.id && !$parent.isLoading"
          >
            <i class="fas fa-trash"></i>
          </button>
        </span>
        <span v-if="bank.id">
          <Xlsx type="importTest"></Xlsx>
          <!-- <button class="button" @click="isImportModalActive = true">
            <i class="fas fa-file-import"></i>
            <span class="is-hidden-mobile ml-2">{{
              trans.get("general.import")
            }}</span>
          </button> -->
          <button class="button" @click="modal = true">
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

      <article class="message is-warning m-2" v-if="$parent.banks.length == 0">
        <div class="message-body">
          {{ trans.get("questions.alert") }}
        </div>
      </article>

      <div class="panel-block" v-if="questions.length == 0 && !addQuestion">
        <h4 v-if="bank.id" class="is-size-4 p-4 w-100 has-text-centered">
          {{ trans.get("questions.empty") }}
        </h4>
        <h4 v-else class="is-size-4 p-4 w-100 has-text-centered">
          {{ trans.get("questions.empty_challenges") }}
        </h4>
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

    <AddQuestion
      v-if="modal"
      :modal="modal"
      :questioncopy="question"
      :bank="bank"
      :code="code"
    >
    </AddQuestion>
  </div>
</template>
<script>
import AddQuestion from "./AddQuestion.vue";
import ShowQuestion from "./ShowQuestion.vue";
const Xlsx = () => import("../utils/ImportExcel.vue");

export default {
  props: ["bank", "questions", "code"],
  created: function () {},
  data: function () {
    return {
      type: 0,
      currentAnswer: "",
      currentCaseSensitive: true,
      addQuestion: false,
      search: "",
      importFlag: false,
      challengeEdit: null,
      isModalActive: false,
      isImportModalActive: false,
      modal: false,
      students: null,
      groups: null,
      currentChallenge: null,
      mark: null,
      question: null,
    };
  },
  methods: {
    addFromExcel(questions) {
      questions.forEach((question) => {
        axios
          .post("/classroom/question/add", {
            type: 1,
            bank: this.bank.id,
            question: {
              name: question['Title'],
              correctAnswer: question['CorrectAnswer'],
              incorrectAnswer1: question['Incorrect1'],
              incorrectAnswer2: question['Incorrect2'] ? question['Incorrect2'] : "",
              incorrectAnswer3: question['Incorrect3'] ? question['Incorrect3'] : "",
            },
          })
          .then((response) => {
            this.$toast(this.trans.get("success_error.add_success"), {
              type: "success",
            });
            if (this.bank.id) {
              this.$parent.getQuestions(this.bank.id);
            }
          });
      });
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
          axios.delete("/classroom/bank/" + id).then((response) => {
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
    AddQuestion,
    ShowQuestion,
    Xlsx,
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