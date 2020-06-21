<template>
  <div class="box card-shadow-s has-padding-3 has-margin-y-3">
    <div v-if="admin">
      <p class="has-padding-4">
        <i class="fas fa-question-circle"></i>
        {{ reactiveQuestion.question }}
        <span class="tag is-dark" v-tippy :content="reactiveQuestion.stats.remainning">
          <i class="fas fa-user"></i>
          {{ reactiveQuestion.stats.answered }} /
          <i class="fas fa-user-slash"></i>
          {{ reactiveQuestion.stats.remainning.length }}
        </span>
        <span class="tag is-success" v-if="reactiveQuestion.stats.answeredOK.length" v-tippy :content="reactiveQuestion.stats.answeredOK">
          <i class="fas fa-check"></i>
          {{ reactiveQuestion.stats.answeredOK.length }}
        </span>
        <span class="tag is-danger" v-if="reactiveQuestion.stats.answeredKO.length" v-tippy :content="reactiveQuestion.stats.answeredKO">
          <i class="fas fa-times"></i>
          {{ reactiveQuestion.stats.answeredKO.length }}
        </span>
      </p>
    </div>
    <div v-if="!admin">
      <h3 class="has-padding-4">
        <i class="fas fa-question-circle"></i>
        {{ reactiveQuestion.question }}
      </h3>
      <div v-if="reactiveQuestion.answered">
        <div
          class="has-background-danger-light card-shadow-s has-padding-4 has-margin-3 rounded"
          v-if="reactiveQuestion.answerKO"
        >
          <i class="fas fa-sad-tear colored has-padding-right-2" v-if="!reactiveQuestion.correct"></i>
          {{ reactiveQuestion.answerKO.answer.text }}
        </div>
        <div class="has-background-success-light card-shadow-s has-padding-4 has-margin-3 rounded">
          <i class="fas fa-smile-beam colored has-padding-right-2" v-if="reactiveQuestion.correct"></i>
          {{ reactiveQuestion.answerOK.answer.text }}
        </div>
      </div>
      <div v-if="!reactiveQuestion.answered">
        <div
          class="card-shadow-s has-padding-4 has-margin-3 rounded answer cursor-pointer"
          v-for="answer in reactiveQuestion.answers"
          @click="answerQuestion(answer.id)"
          :key="answer.id"
        >{{ answer.answer }}</div>
      </div>
    </div>
  </div>
</template>
<script>
import confetti from "canvas-confetti";

export default {
  props: ["question", "admin"],
  created: function() {
    this.reactiveQuestion = this.question;
  },
  data: function() {
    return {
      reactiveQuestion: null
    };
  },
  methods: {
    answerQuestion(answer) {
      axios
        .post("/classroom/question/answer", {
          answer: answer,
          question: this.reactiveQuestion
        })
        .then(response => {
          if (response.data.correct == true) {
            confetti({
              particleCount: 200,
              spread: 100,
              origin: { y: 1.0 }
            });
          }
          this.reactiveQuestion = response.data;
        });
    }
  },
  computed: {}
};
</script>
<style lang="scss">
.answer:hover {
  background-color: wheat;
}
</style>
