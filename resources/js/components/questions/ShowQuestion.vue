<template>
  <div class="box card-shadow-s mb-3 is-relative">
    <h1 class="fs-1-2">
      <i
        class="fas is-light tag is-link"
        :class="{
          'fa-text': question.type == 2,
          'fa-list': question.type == 1,
        }"
      ></i>
      {{ question.name }}
    </h1>
    <div class="mt-2" v-if="question.type == 1">1
      <span v-for="(option, index) in question.options" :key="index">
        <span
          class="tag is-light p-2 mr-1"
          :class="{
            'is-success': option.answer.id == question.options[0].correctAnswer,
            'is-danger': option.answer.id != question.options[0].correctAnswer,
          }"
          v-if="option.answer"
          >{{ option.answer.text }}</span>
      </span>
    </div>
    <div class="mt-2" v-else-if="question.type == 2">
      <span>{{ trans.get("questions.accepted") }}: </span>
      <span v-for="(option, index) in question.options" :key="index">
        <span class="tag p-4 pr-0 border rounded is-light mr-1 is-success">
          "{{ option.answer }}"
          <small
            v-tippy
            :content="trans.get('questions.case_sensitive')"
            class="border px-1 rounded has-background-dark has-text-light mr-1 is-dark"
            v-if="option.caseSensitive"
            ><i class="fal fa-font-case"></i>
          </small>
        </span>
      </span>
    </div>
    <small>
      <button
        class="button is-danger delete-button-right"
        v-on:click.prevent="deleteQuestion()"
      >
        <i class="far fa-trash"></i></button
    ></small>
  </div>
</template>
<script>
import confetti from "canvas-confetti";
import Utils from "../../utils.js";

export default {
  props: ["code", "question"],
  created: function () {},
  data: function () {
    return {};
  },
  components: {},
  methods: {
    deleteQuestion() {
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
            .delete("/classroom/questions/" + this.question.id)
            .then((response) => {
              let bank = this.question.question_bank_id
                ? this.question.question_bank_id
                : "wc";
              this.$parent.$parent.getQuestions(bank);
            });
        },
      });
    },
  },
};
</script>
