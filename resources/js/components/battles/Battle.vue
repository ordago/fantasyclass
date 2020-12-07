<template>
  <div class="p-3">
    <b-steps
      v-model="activeStep"
      :animated="true"
      :rounded="true"
      :has-navigation="true"
      icon-prev="chevron-left"
      icon-next="chevron-right"
      label-position="bottom"
      mobile-mode="minimalist"
    >
      <b-step-item
        step="1"
        :label="trans.get('battles.type_battle')"
        :clickable="true"
      >
        <b-field :expanded="true">
          <b-radio-button
            v-model="type"
            :native-value="0"
            type="is-info"
            expanded
          >
            <i class="fas fa-user mr-1"></i> vs <i class="fas fa-user ml-1"></i>
          </b-radio-button>

          <b-radio-button
            v-model="type"
            :native-value="1"
            type="is-info"
            expanded
            v-tippy
            :content="trans.get('battles.not_available')"
            :disabled="groups.length < 2"
          >
            <i class="fas fa-users mr-1"></i> vs
            <i class="fas fa-users ml-1"></i>
          </b-radio-button>
          <b-radio-button
            v-model="type"
            :native-value="2"
            expanded
            disabled
            v-tippy
            :content="trans.get('battles.not_available')"
            type="is-info"
          >
            <i class="fas fa-user mr-1"></i> vs
            <i class="fas fa-dragon ml-1"></i>
          </b-radio-button>
          <b-radio-button
            v-model="type"
            expanded
            :native-value="3"
            v-tippy
            :content="trans.get('battles.not_available')"
            type="is-info"
            disabled
          >
            <i class="fad fa-users-class mr-1"></i> vs
            <i class="fas fa-dragon ml-1"></i>
          </b-radio-button>
        </b-field>

        <article class="message is-link">
          <div class="message-body">
            {{ getMessage() }}
          </div>
        </article>
      </b-step-item>

      <b-step-item
        step="2"
        :label="trans.get('battles.settings')"
        :clickable="true"
      >
        <h3 class="m-2" v-if="type == 0">
          {{ trans.get("battles.loss_fail") }}
        </h3>
        <div class="columns m-2" v-if="type == 0">
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-danger">
                        <i class="fas fa-heart colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        max="0"
                        v-model="hp_loss"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-danger">
                        <i class="fas fa-fist-raised colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        max="0"
                        v-model="xp_loss"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-danger">
                        <i class="fas fa-coins colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        max="0"
                        v-model="gold_loss"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h3 class="m-2" v-if="type == 1">
          {{ trans.get("battles.reward") }}
        </h3>
        <div class="columns m-2" v-if="type == 1">
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-success">
                        <i class="fas fa-fist-raised colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        max="0"
                        v-model="xp_reward"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-success">
                        <i class="fas fa-coins colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        max="0"
                        v-model="gold_reward"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h3 class="m-2" v-if="type == 0">
          {{ trans.get("battles.gain") }}
        </h3>
        <div class="columns m-2" v-if="type == 0">
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-success">
                        <i class="fas fa-heart colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        max="0"
                        v-model="hp_transfer"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-success">
                        <i class="fas fa-fist-raised colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        max="0"
                        v-model="xp_transfer"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-success">
                        <i class="fas fa-coins colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        max="0"
                        v-model="gold_transfer"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h3 class="m-2">{{ trans.get("battles.max_fails") }}</h3>
        <div class="column is-narrow">
          <div class="field is-horizontal">
            <div class="field-body">
              <div class="field is-expanded">
                <div class="field has-addons">
                  <p class="control">
                    <a
                      class="button"
                      v-tippy
                      :content="trans.get('battles.protect_shield')"
                    >
                      <i class="far fa-shield-alt colored"></i>
                    </a>
                  </p>
                  <p class="control">
                    <input
                      type="number"
                      class="input"
                      min="0"
                      v-model="max_fails"
                    />
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </b-step-item>

      <b-step-item
        step="3"
        :label="trans.get('battles.questions')"
        :clickable="true"
      >
        <div v-if="!classroom.question_banks.length">
          <p class="m-2">
            {{ trans.get("battles.bank_empty") }}
          </p>
          <a class="button is-info" @click="activeStep += 1">
            {{ trans.get("battles.im_bank") }} 😏</a
          >
          <a
            class="button is-link"
            :href="'/classroom/' + classroom.code + '/questions'"
            >{{ trans.get("battles.bank_create") }} 🙄</a
          >
        </div>
        <div v-else class="content has-text-centered">
          <a
            class="button is-info"
            @click="
              selectedBank = null;
              activeStep += 1;
            "
          >
            {{ trans.get("battles.im_bank") }} 😏</a
          >
          <h2>{{ trans.get("battles.bank") }}</h2>

          <p class="control select is-fullwidth">
            <select v-model="selectedBank" class="mt-2" name="type">
              <option :value="null">{{ trans.get("battles.wb") }}</option>
              <option
                v-for="bank in classroom.question_banks"
                :value="bank.id"
                :key="bank.id"
              >
                {{ bank.title }}
              </option>
            </select>
          </p>
        </div>
      </b-step-item>

      <b-step-item
        step="4"
        :label="trans.get('battles.start')"
        :clickable="true"
        disabled
      >
        <div class="has-text-centered">
          <h1 class="button is-size-2 py-3 px-6 is-info m-3" @click="start">
            {{ trans.get("battles.start") }}!
          </h1>
        </div>
      </b-step-item>
    </b-steps>

    <b-modal
      :active.sync="isBattleActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("menu.battles") }}</p>
        </header>
        <section class="modal-card-body is-relative" id="confetti-bg">
          <div class="columns">
            <div
              class="column rounded is-flex is-flex-direction-column has-text-centered is-narrow"
            >
              <div v-if="type == 1 && group1">
                <h3 class="is-size-3 animate__animated animate__bounceIn">
                  {{ group1.name }}
                </h3>
              </div>
              <div style="min-width: 300px">
                <show-student
                  class="animate__animated"
                  :class="{
                    animate__flipInX: flip1,
                    animate__swing: move1,
                    'has-background-info': turn == 0,
                  }"
                  v-if="student1"
                  ref="student1"
                  :student="student1"
                  :character-theme="classroom.character_theme"
                  :theme="classroom.theme"
                ></show-student>
              </div>
              <div
                class="my-2"
                style="max-width: 270px"
                v-if="student1 || group1"
              >
                <span
                  v-for="index in getMaxFails(1)"
                  :key="index"
                  v-tippy
                  :content="trans.get('battles.protect_shield')"
                >
                  <i
                    class="far fa-shield-alt colored"
                    style="font-size: 3em"
                  ></i>
                </span>
              </div>
              <div class="my-2" style="max-width: 270px" v-if="student1">
                <span
                  v-for="(answer, index) in getAnswers(1)"
                  :key="index"
                  class="tag mr-1"
                  :class="{ 'is-success': answer, 'is-danger': !answer }"
                >
                  {{ index + 1 }}
                </span>
              </div>
              <div v-if="type == 0">
                <button
                  @click="selectStudent(1)"
                  class="button is-primary my-2"
                >
                  {{ trans.get("battles.select_student") }}
                  <i class="fas fa-random ml-1"></i>
                </button>
              </div>
              <div v-if="type == 1 && !group1">
                <button @click="selectGroup(1)" class="button is-primary my-2">
                  {{ trans.get("battles.select_group") }}
                  <i class="fas fa-random ml-1"></i>
                </button>
              </div>
            </div>
            <div class="column is-flex has-all-centered">
              <button
                class="button is-primary is-size-2"
                v-if="!started"
                :disabled="!student1 || !student2 || student1.id == student2.id"
                @click="startBattle"
              >
                <i class="fas fa-swords colored mr-2 faa-pulse animated"></i
                >{{ trans.get("battles.lets_start") }}
              </button>
              <div v-else class="w-100">
                <div
                  v-if="!selectedBank"
                  class="is-flex is-flex-direction-column has-all-centered"
                >
                  <div
                    v-if="!answered"
                    class="is-flex is-flex-direction-column has-all-centered"
                  >
                    <h1 class="is-size-2">
                      {{ trans.get("battles.tell_next") }}
                    </h1>
                    <div class="buttons my-2 has-text-centered">
                      <button class="button is-success" @click="answer(true)">
                        <i class="fad fa-thumbs-up"></i>
                        {{ trans.get("battles.answer_ok") }}
                      </button>
                      <button class="button is-danger" @click="answer(false)">
                        <i class="fad fa-thumbs-down"></i>
                        {{ trans.get("battles.answer_ko") }}
                      </button>
                    </div>
                    <count-down
                      v-if="!answered"
                      :starttime="new Date(1, 1, 1, 0, 0, 30)"
                    ></count-down>
                  </div>
                  <div v-else>
                    <button class="button is-size-2" @click="nextQuestion">
                      {{ trans.get("battles.next") }}
                    </button>
                  </div>
                </div>
                <div
                  v-else-if="!finished"
                  class="w-100 has-all-centered is-flex is-flex-direction-column"
                >
                  <show-question :question="currentQuestion"></show-question>
                  <count-down
                    v-if="!answered"
                    :starttime="new Date(1, 1, 1, 0, 0, 30)"
                  ></count-down>
                </div>
                <div v-if="finished" class="has-text-centered">
                  <h1
                    class="is-size-1 animate__animated animate__rubberBand animate__infinite"
                  >
                    {{ trans.get("battles.well_done") }}
                  </h1>
                  <a
                    class="button mt-2"
                    :href="'/classroom/' + classroom.code"
                    >{{ trans.get("battles.go_back") }}</a
                  >
                </div>
              </div>
            </div>
            <div
              class="column rounded is-flex is-flex-direction-column has-text-centered is-narrow"
            >
              <div v-if="type == 1 && group2">
                <h3 class="is-size-3 animate__animated animate__bounceIn">
                  {{ group2.name }}
                </h3>
              </div>
              <div style="min-width: 300px">
                <show-student
                  :class="{
                    animate__flipInX: flip2,
                    animate__swing: move2,
                    'has-background-info': turn == 1,
                  }"
                  class="animate__animated"
                  v-if="student2"
                  ref="student2"
                  :student="student2"
                  :character-theme="classroom.character_theme"
                  :theme="classroom.theme"
                ></show-student>
              </div>

              <div class="my-2" style="max-width: 270px" v-if="student2">
                <span
                  v-for="index in getMaxFails(2)"
                  :key="index"
                  v-tippy
                  :content="trans.get('battles.protect_shield')"
                >
                  <i
                    class="far fa-shield-alt colored"
                    style="font-size: 3em"
                  ></i>
                </span>
              </div>
              <div class="my-2" style="max-width: 270px" v-if="student2">
                <span
                  v-for="(answer, index) in getAnswers(2)"
                  :key="index"
                  class="tag mr-1"
                  :class="{ 'is-success': answer, 'is-danger': !answer }"
                >
                  {{ index + 1 }}
                </span>
              </div>
              <div v-if="type == 0">
                <button
                  @click="selectStudent(2)"
                  class="button is-primary my-2"
                >
                  {{ trans.get("battles.select_student") }}
                  <i class="fas fa-random ml-1"></i>
                </button>
              </div>
              <div v-if="type == 1 && !group2">
                <button @click="selectGroup(2)" class="button is-primary my-2">
                  {{ trans.get("battles.select_group") }}
                  <i class="fas fa-random ml-1"></i>
                </button>
              </div>
            </div>
          </div>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow is-12-mobile is-flex has-all-centered">
            <button
              class="button"
              type="button"
              @click="isBattleActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
          </div>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
import confetti from "canvas-confetti";
import ShowQuestion from "./ShowQuestion.vue";
import CountDown from "../utils/CountDown.vue";

export default {
  components: { ShowQuestion, CountDown },
  props: ["classroom"],
  mounted() {
    this.students = _.shuffle(this.classroom.students);
    this.classroom.grouping[0].groups.forEach((element) => {
      if (element.students && element.students.length) {
        this.groups.push(element);
      }
    });
    this.groups = _.shuffle(this.groups);
  },
  data: function () {
    return {
      audioOK: new Audio("/sound/clap.mp3"),
      audioKO: new Audio("/sound/wheel-bad.mp3"),
      groups: [],
      activeStep: 0,
      type: 0,
      hp_loss: -5,
      xp_loss: -5,
      gold_loss: -5,
      hp_transfer: 0,
      xp_transfer: 5,
      gold_transfer: 5,
      gold_reward: 200,
      xp_reward: 50,
      selectedBank: null,
      isBattleActive: false,
      group1: null,
      group2: null,
      group_count: 0,
      student1: null,
      student2: null,
      students: null,
      flip1: false,
      flip2: false,
      move1: false,
      move2: false,
      turn: null,
      started: false,
      finished: false,
      lastAnswer1: false,
      lastAnswer2: false,
      questions: null,
      currentQuestion: null,
      answered: false,
      max_fails: 3,
    };
  },
  methods: {
    getAnswers(slot) {
      if (slot == 1) {
        if (this.type == 0) {
          return this.student1.answers;
        } else return this.group1.answers;
      } else {
        if (this.type == 0) {
          return this.student2.answers;
        } else return this.group2.answers;
      }
    },
    getMaxFails(slot) {
      if (slot == 1) {
        if (this.type == 0) {
          return parseInt(this.student1.max_fails);
        } else return parseInt(this.group1.max_fails);
      } else {
        if (this.type == 0) {
          return parseInt(this.student2.max_fails);
        } else return parseInt(this.group2.max_fails);
      }
    },
    answerGroup(correct, next = true) {
      let group_1;
      let group_2;
      if (this.turn == 0) {
        group_1 = this.group1;
      } else {
        group_1 = this.group2;
      }
      if (!correct) {
        if (this.max_fails != 0) group_1.max_fails -= 1;
      }
        group_1.answers.push(correct)
    },
    answerIndividual(correct, next = true) {
      let student_1;
      let student_2;
      if (this.turn == 0) {
        student_1 = this.student1;
        student_2 = this.student2;
      } else {
        student_1 = this.student2;
        student_2 = this.student1;
      }
      student_1.lastAnswer = correct;
      student_1.answers.push(correct);

      if (!correct) {
        if (this.max_fails != 0) student_1.max_fails -= 1;

        student_1.hp = Math.max(student_1.hp + this.hp_loss, 0);
        this.updateProp(student_1.id, "hp", this.hp_loss);
        student_1.gold = Math.max(student_1.gold + this.gold_loss, 0);
        this.updateProp(student_1.id, "gold", this.gold_loss);
        student_1.xp = Math.max(student_1.xp + this.xp_loss, 0);
        this.updateProp(student_1.id, "xp", this.xp_loss);

        if (student_2.lastAnswer) {
          student_2.hp = Math.min(student_2.hp + this.hp_transfer, 100);
          this.updateProp(student_2.id, "hp", this.hp_transfer);
          student_2.xp += this.xp_transfer;
          this.updateProp(student_2.id, "xp", this.xp_transfer);
          student_2.gold += this.gold_transfer;
          this.updateProp(student_2.id, "gold", this.gold_transfer);
        }

        if (student_1.max_fails == 0 && this.max_fails != 0) {
          if (this.turn == 0) {
            this.$refs.student1.$el.classList.add("animate__rotateOut");
            setTimeout(() => {
              this.student1 = null;
              this.started = false;
              this.answered = false;
            }, 1000);
          } else {
            this.$refs.student2.$el.classList.add("animate__rotateOut");
            setTimeout(() => {
              this.student2 = null;
              this.started = false;
              this.answered = false;
            }, 1000);
          }
          this.$forceUpdate();
          return false;
        }
      }
    },
    answer(correct, next = true) {
      this.answered = true;
      if (this.type == 0) {
        this.answerIndividual(correct, next);
      } else {
        this.answerGroup(correct, next);
      }
      if (correct) {
        if (this.turn == 0) {
          this.$refs.student1.$el.classList.add("animate__bounce");
        } else {
          this.$refs.student2.$el.classList.add("animate__bounce");
        }
        confetti({
          particleCount: 200,
          spread: 100,
          origin: { y: 1.0 },
        });
        this.audioOK.play();
      } else {
        if (this.turn == 1) {
          this.move2 = true;
        } else {
          this.move1 = true;
        }
        this.audioKO.play();
      }
    },
    updateProp: function (id, prop, value) {
      let options = { id: id, prop: prop, value: value };
      axios.post("/classroom/students/update", options);
    },
    start() {
      if (this.selectedBank) {
        this.classroom.question_banks.forEach((element) => {
          if (element.id == this.selectedBank) {
            this.questions = _.shuffle(element.questions);
          }
        });
      }
      this.isBattleActive = true;
    },
    startBattle() {
      Math.random() < 0.5 ? (this.turn = 0) : (this.turn = 1);
      this.started = true;
      if (this.selectedBank) this.currentQuestion = this.questions.pop();
    },
    skipQuestion() {
      if (this.selectedBank && !this.questions.length) this.finished = true;
      this.currentQuestion = this.questions.pop();
      this.$forceUpdate();
      return this.currentQuestion;
    },
    nextQuestion() {
      if (this.selectedBank && !this.questions.length) this.finished = true;

      setTimeout(this.reset, 1000);
      if (this.selectedBank) this.currentQuestion = this.questions.pop();
      if(this.type == 1) {
        
        // TODO increment group count every 2.
        this.group_count++;
        if(this.turn == 0) {
          this.selectStudent(1)
        } else {
          this.selectStudent(2)
        }
      }
      this.turn = (this.turn + 1) % 2;
      this.answered = false;
      return this.currentQuestion;
    },
    reset() {
      this.flip1 = false;
      this.move1 = false;
      this.flip2 = false;
      this.move2 = false;
    },
    selectGroup(slot) {
      if (slot == 1) {
        this.group1 = this.groups.pop();
        this.group1.max_fails = this.max_fails;
        this.group1.answers = [];
        this.selectStudent(1);
      } else {
        this.group2 = this.groups.pop();
        this.group2.max_fails = this.max_fails;
        this.group2.answers = [];
        this.selectStudent(2);
      }
    },
    selectStudent(slot) {
      setTimeout(this.reset, 1000);
      if (this.type == 0) {
        if (slot == 1) {
          this.student1 = this.students.pop();
        } else {
          this.student2 = this.students.pop();
        }
        if (this.students && !this.students.length)
          this.students = _.shuffle(this.classroom.students);
        if (
          this.student2 &&
          this.student1 &&
          this.student1.id == this.student2.id
        ) {
          this.selectStudent(slot);
        }
      } else if (this.type == 1) {
        if (slot == 1) {
          let index = this.group_count % this.group1.students.length;
          this.student1 = this.group1.students[index];
        } else {
          let index = this.group_count % this.group2.students.length;
          this.student2 = this.group2.students[index];
        }
      }
      if (slot == 1) {
        this.student1.answers = [];
        this.student1.max_fails = this.max_fails;
        this.flip1 = true;
      } else {
        this.student2.max_fails = this.max_fails;
        this.student2.answers = [];
        this.flip2 = true;
      }
    },
    getMessage() {
      switch (this.type) {
        case 0:
          return "1 vs 1. " + this.trans.get("battles.1vs1");
          break;
        case 1:
          return this.trans.get("battles.groupVSgroup");
          break;
        case 2:
          return "Estudiantes se enfrentarán a monstruos ...";
          break;
        case 3:
          return "La classe se enfrentará a monstruos ...";
          break;
      }
    },
  },
};
</script>
<style>
@import "~animate.css";
</style>

