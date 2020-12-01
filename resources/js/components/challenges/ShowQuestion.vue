<template>
  <div class="box card-shadow-s p-3 my-3">
    <div v-if="admin" class="columns">
      <div class="column">
        <p class="p-4">
          <i class="fas fa-question-circle"></i>
          {{ reactiveQuestion.question }}
          <span
            class="tag is-dark"
            v-tippy
            :content="reactiveQuestion.stats.remainning"
          >
            <i class="fas fa-user"></i>
            {{ reactiveQuestion.stats.answered }} /
            <i class="fas fa-user-slash"></i>
            {{ reactiveQuestion.stats.remainning.length }}
          </span>
          <span
            class="tag is-success"
            v-if="reactiveQuestion.stats.answeredOK.length"
            v-tippy
            :content="reactiveQuestion.stats.answeredOK"
          >
            <i class="fas fa-check"></i>
            {{ reactiveQuestion.stats.answeredOK.length }}
          </span>
          <span
            class="tag is-danger"
            v-if="reactiveQuestion.stats.answeredKO.length"
            v-tippy
            :content="reactiveQuestion.stats.answeredKO"
          >
            <i class="fas fa-times"></i>
            {{ reactiveQuestion.stats.answeredKO.length }}
          </span>
        </p>
      </div>
      <div class="column is-narrow" v-if="admin">
        <button
          class="button is-danger"
          @click="confirmDelete(reactiveQuestion.id, index)"
        >
          <i class="fas fa-trash"></i>
        </button>
      </div>
    </div>
    <div v-if="!admin">
      <h3 class="p-4">
        <i class="fas fa-question-circle"></i>
        {{ reactiveQuestion.question }}
      </h3>
      <div v-if="reactiveQuestion.answered">
        <div
          class="has-background-danger-light card-shadow-s p-4 m-3 rounded"
          v-if="reactiveQuestion.answerKO"
        >
          <i
            class="fas fa-sad-tear colored pr-2"
            v-if="!reactiveQuestion.correct"
          ></i>
          {{ reactiveQuestion.answerKO.answer.text }}
        </div>
        <div
          class="has-background-success-light card-shadow-s p-4 m-3 rounded"
        >
          <i
            class="fas fa-smile-beam colored pr-2"
            v-if="reactiveQuestion.correct"
          ></i>
          {{ reactiveQuestion.answerOK.answer.text }}
        </div>
      </div>
      <div v-if="!reactiveQuestion.answered && reactiveQuestion.type == 1">
        <div
          class="card-shadow-s p-4 m-3 rounded answer cursor-pointer"
          v-for="answer in reactiveQuestion.answers"
          @click="answerQuestion(answer.id)"
          :key="answer.id"
        >
          {{ answer.text }}
        </div>
      </div>
      <div v-if="reactiveQuestion.type == 2 && !reactiveQuestion.answered">
        <div class="control">
          <input class="input" v-model="answer" type="text" placeholder="Answer">
        </div>
        <button class="button is-primary mt-2" v-if="answer != ''">Send answer</button>
      </div>
    </div>
  </div>
</template>
<script>
import confetti from "canvas-confetti";

export default {
  props: ["question", "admin", "index"],
  created: function () {
    this.reactiveQuestion = this.question;
  },
  data: function () {
    return {
      answer: "",
      reactiveQuestion: null,
    };
  },
  methods: {
    confirmDelete(id, index) {
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
          axios
            .delete("/classroom/challenge/question/" + id)
            .then((response) => {
              if (response.data === 1) {
                this.$parent.challenge.stats.splice(index, 1);
                // this.$forceUpdate();
              }
            });
        },
      });
    },
    answerTextQuestion(answer) {


      this.answerQuestion(answer, 2);
    },
    answerQuestion(answer, type = 1) {
      axios
        .post("/classroom/question/answer", {
          answer: answer,
          type: type,
          question: this.reactiveQuestion,
        })
        .then((response) => {
          if (response.data.correct == true) {
            confetti({
              particleCount: 200,
              spread: 100,
              origin: { y: 1.0 },
            });
          }
          this.reactiveQuestion = response.data;
        });
    },
  },
  computed: {},
};
</script>
<style lang="scss">
.answer:hover {
  background-color: wheat;
}
</style>
