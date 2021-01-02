<template>
  <b-modal
    :active.sync="modal"
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
                          <a class="button is-danger is-light" v-tippy :content="trans.get('general.optional')">
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
                          <a class="button is-danger is-light"  v-tippy :content="trans.get('general.optional')">
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
            <b-tab-item
              :label="trans.get('questions.short_answer')"
              icon-pack="fal"
              icon="text"
            >
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
                    :placeholder="getText()"
                    type="text"
                    v-model="currentAnswer"
                  ></b-input>
                </b-field>
                <div class="field">
                  <b-checkbox v-model="currentCaseSensitive">
                    {{ trans.get("questions.case_sensitive") }}
                  </b-checkbox>
                </div>

                <button class="button is-link" v-if="currentAnswer != ''" @click.prevent="addAnswer">
                  {{ trans.get("questions.add_answer") }}
                </button>
                <article
                  class="message is-info mt-3"
                  style="width: auto; max-width: 500px"
                  v-if="!question1.answers.length"
                >
                  <div class="message-body p-3">
                    <p>
                      {{ trans.get('questions.example') }}
                    </p>
                    <p class="content mt-1">
                      <small>
                      {{ trans.get('questions.example1') }}
                        <ul>
                          <li>Tony Stark</li>
                          <li>Anthony Edward Stark</li>
                          <li>Anthony Stark</li>
                        </ul>
                      </small>
                      <p>
                      {{ trans.get('questions.example2') }}
                      </p>
                    </p>
                  </div>
                </article>
                <div
                  class="p-2 m-2 border is-relative"
                  v-for="(answer, index) in question1.answers"
                  :key="index"
                >
                  "{{ answer.answer }}" <small v-tippy :content="trans.get('questions.case_sensitive')" class="border px-1 rounded has-background-dark has-text-light mr-1 is-dark" v-if="answer.caseSensitive"><i class="fal fa-font-case"></i></small>
                  <small>
                    <button
                      class="button is-danger delete-button-right"
                      v-on:click.prevent="deleteAnswer(index)"
                    >
                      <i class="far fa-trash"></i></button
                  ></small>
                </div>
              </div>
            </b-tab-item>
          </b-tabs>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="$parent.modal = false">
            {{ trans.get("general.close") }}
          </button>
          <button
            @click.prevent="sendQuestion"
            :disabled="isDisabled"
            class="button is-primary"
          >
            {{ trans.get("general.add") }}
          </button>
        </footer>
      </div>
    </form>
  </b-modal>
</template>
<script>
export default {
  props: ["bank", "code", "challenge", "modal", "challengegroup"],
  created: function () {
    this.init();
  },
  mounted: function () {},
  data: function () {
    return {
      type: 0,
      question: null,
      question1: null,
      currentAnswer: "",
      currentCaseSensitive: true,
      addQuestion: false,
    };
  },
  methods: {
    deleteAnswer(index) {
      this.question1.answers.splice(index, 1);
    },
    init() {
      this.question = {
        name: "",
        correctAnswer: "",
        incorrectAnswer1: "",
        incorrectAnswer2: "",
        incorrectAnswer3: "",
      };
      this.question1 = {
        name: null,
        answers: [],
      };
      this.$forceUpdate();
    },
    sendQuestion() {
      let type = this.type + 1;
      let question;
      if (type == 1) {
        question = this.question;
      } else if (type == 2) {
        question = this.question1;
      }
      axios
        .post("/classroom/question/add", {
          type: type,
          bank: this.bank.id,
          challenge: this.challenge,
          question: question,
        })
        .then((response) => {
          this.init();
          this.$toast(this.trans.get("success_error.add_success"), {
            type: "success",
          });
          if (this.bank.id) {
            this.$parent.$parent.getQuestions(this.bank.id);
            this.$parent.modal = false;
          } else {
            this.$parent.$parent.$parent.getChallenges(this.challengegroup);
            this.$parent.$parent.$parent.modal = false;
          }
        });
    },
    getText() {
      if (this.question1.answers.length == 0)
        return this.trans.get("questions.answer");
      return this.trans.get("questions.answer_multiple");
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
  },
  components: {},
  computed: {
    isDisabled() {
      if (this.type == 0) {
        return !(
          this.question.name != "" &&
          this.question.correctAnswer != "" &&
          this.question.incorrectAnswer1 != ""
        );
      }
      return !(this.question1.name && this.question1.answers.length);
    },
  },
  updated: function () {},
};
</script>