<template>
  <div class="box content card-shadow-s p-3 my-3 w-100">
    <div>
      <h2 class="p-4">
        <i class="fas fa-question-circle"></i>
        {{ reactiveQuestion.name }}
      </h2>
      <button class="button" @click="imgView = !imgView" v-if="reactiveQuestion.image">{{ trans.get('battles.show_hide_img') }}</button>
      <img v-if="reactiveQuestion.image && imgView" width="100%" style="max-width: 800px;" :src="reactiveQuestion.image">
      <div v-if="$parent.$parent.answered && reactiveQuestion.type == 2">
        <div
          class="p-2 m-2 is-size-3 rounded border"
          :class="{
            'has-background-danger-light': !lastText,
            'has-background-success-light': lastText,
          }"
        >
          {{ answer }}
        </div>
        <div
          class="p-2 m-2 is-size-5 rounded border has-background-success-light"
          v-for="(answer, index) in reactiveQuestion.options"
          :key="index"
        >
          {{ answer.answer }}
          <small
            v-tippy
            :content="trans.get('questions.case_sensitive')"
            class="
              border
              px-1
              rounded
              has-background-dark has-text-light
              mr-1
              is-dark
            "
            v-if="answer.caseSensitive"
            ><i class="fal fa-font-case"></i>
          </small>
        </div>
      </div>
      <div v-if="reactiveQuestion.type == 2 && !$parent.$parent.answered">
        <div class="control">
          <input
            class="input"
            v-model="answer"
            type="text"
            :placeholder="trans.get('questions.student_answer')"
          />
        </div>
        <button class="button is-primary my-2" @click="answerQuestion('', 2)">
          {{ trans.get("questions.send_answer") }}
        </button>
      </div>
      <div v-if="$parent.$parent.answered && reactiveQuestion.type == 1">
        <div v-for="(answer, index) in reactiveQuestion.options" :key="index">
          <div
            v-if="answer.answer"
            class="card-shadow-s p-4 m-3 rounded answer cursor-pointer"
            :class="{
              'has-background-success':
                answer.answer && answer.answer.id == correctAnswer,
              'has-background-danger':
                answer.answer && correctAnswer != answer.answer.id,
            }"
          >
            <h3>{{ answer.answer.text }}</h3>
          </div>
        </div>
      </div>
      <div v-if="!$parent.$parent.answered && reactiveQuestion.type == 1">
        <div v-for="(answer, index) in reactiveQuestion.options" :key="index">
          <div
            v-if="answer.answer"
            class="card-shadow-s p-4 m-3 rounded answer cursor-pointer"
            @click="answerQuestion(answer.answer.id)"
          >
            <h3>{{ answer.answer.text }}</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="buttons">
      <button
        class="button"
        v-if="$parent.$parent.answered"
        @click="nextQuestion"
      >
        {{ trans.get("battles.next") }}
      </button>
    </div>
    <button
      class="button"
      v-if="!$parent.$parent.answered"
      @click="skipQuestion"
    >
      {{ trans.get("battles.skip_question") }}
    </button>
  </div>
</template>
<script>
import confetti from "canvas-confetti";

export default {
  props: ["question", "admin", "index"],
  created: function () {
    this.reactiveQuestion = this.question;
    this.initQuestion();
  },
  data: function () {
    return {
      imgView: true,
      answer: "",
      correctAnswer: null,
      reactiveQuestion: null,
      lastText: false,
    };
  },
  methods: {
    initQuestion() {
      this.reactiveQuestion.options = _.shuffle(this.reactiveQuestion.options);
      this.reactiveQuestion.options.forEach((element) => {
        if (element.correctAnswer) {
          this.correctAnswer = element.correctAnswer;
        }
      });
      this.answer = "";
    },
    skipQuestion() {
      this.reactiveQuestion = this.$parent.$parent.skipQuestion();
      this.initQuestion();
    },
    nextQuestion() {
      this.$parent.$parent.$refs.student1.$el.classList.remove(
        "animate__bounce"
      );
      if (this.$parent.$parent.type != 3 && this.$parent.$parent.type != 2) {
        this.$parent.$parent.$refs.student2.$el.classList.remove(
          "animate__bounce"
        );
      }
      this.reactiveQuestion = this.$parent.$parent.nextQuestion();
      if (this.reactiveQuestion) this.initQuestion();
    },
    answerTextQuestion() {
      let correct = false;
      this.reactiveQuestion.options.forEach((element) => {
        if (element.caseSensitive) {
          if (this.answer == element.answer) {
            correct = true;
          }
        } else {
          if (this.answer.toLowerCase() == element.answer.toLowerCase()) {
            correct = true;
          }
        }
      });
      return correct;
    },
    answerQuestion(answer, type = 1) {
      var correct = false;
      if (type == 1) {
        this.question.options.forEach((element) => {
          if (element.correctAnswer && element.correctAnswer == answer) {
            correct = true;
          }
        });
      } else {
        correct = this.answerTextQuestion();
      }
      this.lastText = correct;
      if (correct) {
        this.$parent.$parent.answer(true, false);
      } else {
        this.$parent.$parent.answer(false, false);
      }
      this.$parent.$parent.answered = true;
      this.$parent.$forceUpdate();
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
