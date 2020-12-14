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
            :disabled="groups.length < 2"
          >
            <i class="fas fa-users mr-1"></i> vs
            <i class="fas fa-users ml-1"></i>
          </b-radio-button>
          <b-radio-button
            v-model="type"
            :native-value="2"
            expanded
            type="is-info"
            v-tippy
            :content="trans.get('battles.not_available')"
            disabled
          >
            <i class="fas fa-user mr-1"></i> vs
            <i class="fas fa-dragon ml-1"></i>
          </b-radio-button>
          <b-radio-button
            v-model="type"
            expanded
            :native-value="3"
            type="is-info"
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
        <article
          class="message is-warning"
          v-if="classroom.monsters.length == 0 && type == 3"
        >
          <div class="message-body">
            {{ trans.get("battles.monster_empty") }}:
            <a :href="'/classroom/' + classroom.code + '/monsters'">{{
              trans.get("menu.monsters")
            }}</a>
          </div>
        </article>
      </b-step-item>

      <b-step-item
        step="2"
        :label="trans.get('battles.settings')"
        :clickable="true"
      >
        <h3 class="m-2" v-if="type == 0">
          <i class="fas fa-user"></i> {{ trans.get("battles.loss_fail") }}
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
        <h3 class="m-2" v-if="type == 3">
          <i class="fas fa-user"></i> {{ trans.get("battles.loss_fail") }}
        </h3>
        <div class="columns m-2" v-if="type == 3">
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
        </div>
        <h3 class="m-2" v-if="type == 3">
          <i class="fas fa-dragon"></i>
          {{ trans.get("battles.monster_hp_loss") }}
        </h3>
        <div class="column is-narrow" v-if="type == 3">
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
                      v-model="monster_hp_loss"
                    />
                  </p>
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
                        min="0"
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
                        min="0"
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
        <div class="colums m-2">
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
        </div>
        <h3 class="m-2">
          {{ trans.get("battles.timer_default") }}
        </h3>
        <div class="columns m-2">
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button">
                        <i class="fas fa-stopwatch colored has-text-light"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        min="0"
                        v-model="timer_default"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </b-step-item>

      <b-step-item
        step="3"
        :visible="type == 3"
        :label="trans.get('battles.monster')"
        :clickable="true"
      >
        <div
          v-for="monster in classroom.monsters"
          :key="monster.id"
          @click="monsterSelected = monster"
          class="my-3 monster-select cursor-pointer"
          :class="{
            'has-background-info':
              monsterSelected && monster.id == monsterSelected.id,
            'has-hr':
               monster.hp > 0,
          }"
        >
          <div
            v-if="monster.hp > 0"
            class="columns"
          >
            <div class="column is-narrow">
              <img
                :src="'/img/pets/' + monster.image"
                class="pet-selector mt-2"
              />
            </div>
            <div class="column is-narrow is-flex has-all-centered">
              <span>{{ monster.name }}</span>
            </div>
            <div class="column">
              <hp class="mt-3" :hp="monster.hp"></hp>
            </div>
            <div class="column is-narrow is-flex has-all-centered">
              {{ monster.reward_xp }}
              <i class="fas fa-fist-raised colored"></i> /
              {{ monster.reward_gold }} <i class="fas fa-coins colored"></i>
            </div>
          </div>
        </div>
        <a
          :href="'/classroom/' + classroom.code + '/monsters'"
          class="button is-info mt-5"
        >
          {{ trans.get("monsters.new") }}
        </a>
      </b-step-item>

      <b-step-item
        :step="type == 3 ? '4' : '3'"
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
                :value="bank"
                :key="bank.id"
              >
                {{ bank.title }}
              </option>
            </select>
          </p>
        </div>
      </b-step-item>

      <b-step-item
        :step="type == 3 ? '5' : '4'"
        :label="trans.get('battles.start')"
        :clickable="true"
        disabled
      >
        <div class="content">
          <h1>{{ trans.get('general.summary') }}</h1>
          <ul class="fs-2">
            <li>
              <i class="fas" :class="{'fa-user': type == 0 || type == 3, 'fa-users': type == 1}"></i>
              vs
              <i class="fas" :class="{'fa-user': type == 0, 'fa-users': type == 1, 'fa-dragon': type == 3}"></i>
            </li>
            <li>
              <span v-if="!selectedBank">{{ trans.get('battles.wb') }}</span>
              <span v-else>{{ trans.get('battles.questions') }}: {{ selectedBank.title }}</span>
            </li>
            <li v-if="type == 3">
              <span class="has-text-danger" v-if="type == 3 && !monsterSelected">{{ trans.get('battles.wm') }}</span>
              <span v-else-if="type == 3">{{ trans.get('battles.monster') }}: {{ monsterSelected.name }}</span>
            </li>
          </ul>
        </div>
        <div class="has-text-centered">
          <h1 class="button is-size-2 py-3 px-6 is-info m-3" :disabled="type == 3 && !monsterSelected" @click="start">
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
              <div v-if="(type == 0 || type == 3) && !finished">
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
                :disabled="cantStart"
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
                    v-if="!answered && !finished"
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
                    <button
                      class="button"
                      @click="showTimer = true"
                      v-if="!showTimer && !answered"
                    >
                      <i class="fad fa-stopwatch mr-1"></i>
                      {{ trans.get("battles.show_timer") }}
                    </button>
                    <count-down
                      v-if="!answered && showTimer"
                      :starttime="new Date(1, 1, 1, 0, 0, timer_default)"
                    ></count-down>
                  </div>
                  <div v-else-if="!finished">
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
                  <button
                    class="button"
                    @click="showTimer = true"
                    v-if="!showTimer && !answered"
                  >
                    <i class="fad fa-stopwatch mr-1"></i>
                    {{ trans.get("battles.show_timer") }}
                  </button>
                  <count-down
                    v-if="!answered && showTimer"
                    :starttime="new Date(1, 1, 1, 0, 0, timer_default)"
                  ></count-down>
                </div>
                <div v-if="finished" class="has-text-centered">
                  <h1
                    class="is-size-1 animate__animated animate__rubberBand animate__infinite"
                    v-if="type != 3 || (type == 3 && monsterSelected.hp == 0)"
                  >
                    {{ trans.get("battles.well_done") }}
                    <span v-if="winnerElem">{{ winnerElem.name }}</span>
                  </h1>
                  <div class="is-size-3" v-else>{{ monsterSelected.name }} {{ trans.get('battles.defeat') }}</div>
                  <button
                    class="button is-success mt-2"
                    v-if="winnerElem"
                    @click="sendReward"
                  >
                    {{ trans.get("battles.give_reward") }} {{ winnerElem.name }}
                  </button>
                  <button
                    class="button is-success mt-2"
                    v-if="type == 3 && monsterSelected.hp == 0"
                    @click="sendReward"
                  >
                    {{ trans.get("battles.give_reward") }}
                  </button>
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
              <div ref="monsterdiv" v-if="type == 3 && monsterSelected">
                <img
                  ref="monster"
                  :src="'/img/pets/' + monsterSelected.image"
                  width="250px"
                  class="pet-selector pet-battle mt-2"
                />
                <hp :hp="monsterSelected.hp" :size="2"></hp>
              </div>
            </div>
          </div>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow is-12-mobile is-flex has-all-centered">
            <a class="button" :href="'/classroom/' + classroom.code">
              {{ trans.get("general.close") }}
            </a>
            <button
              class="button is-link"
              v-if="started && type == 1"
              @click="checkWinner"
            >
              {{ trans.get("battles.finish") }}
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
  computed: {
    cantStart() {
      if (this.type == 0 || this.type == 1) {
        return (
          !this.student1 ||
          !this.student2 ||
          this.student1.id == this.student2.id
        );
      } else if (this.type == 3) {
        return !this.student1;
      }
      this.$forceUpdate();
    },
  },
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
      monster_hp_loss: -10,
      xp_loss: -5,
      gold_loss: -5,
      hp_transfer: 0,
      xp_transfer: 5,
      gold_transfer: 5,
      gold_reward: 100,
      xp_reward: 10,
      selectedBank: null,
      isBattleActive: false,
      group1: null,
      group2: null,
      group_count1: 0,
      group_count2: 0,
      student1: null,
      student2: null,
      students: null,
      flip1: false,
      flip2: false,
      move1: false,
      move2: false,
      turn: 0,
      started: false,
      finished: false,
      lastAnswer1: false,
      lastAnswer2: false,
      questions: null,
      currentQuestion: null,
      answered: false,
      max_fails: 3,
      winnerElem: null,
      showTimer: false,
      timer_default: 30,
      monsterSelected: null,
      classroom_max_fails: 0,
      classroom_answers: [],
    };
  },
  methods: {
    sendReward() {
      if (this.type == 1 && this.winner) {
        axios
          .post("/classroom/" + this.classroom.code + "/group/reward", {
            group: this.winnerElem.id,
            xp: this.xp_reward,
            gold: this.gold_reward,
          })
          .then((response) => {
            this.$toast(this.trans.get("success_error.add_success"), {
              type: "success",
            });
            setTimeout(() => {
              location.href = "/classroom/" + this.classroom.code;
            }, 1000);
          });
      } else if (this.type == 3) {
        axios
          .post("/classroom/" + this.classroom.code + "/reward", {
            xp: this.monsterSelected.reward_xp,
            gold: this.monsterSelected.reward_gold,
          })
          .then((response) => {
            this.$toast(this.trans.get("success_error.add_success"), {
              type: "success",
            });
            setTimeout(() => {
              location.href = "/classroom/" + this.classroom.code;
            }, 1000);
          });
      }
    },
    getAnswers(slot) {
      if (slot == 1) {
        if (this.type == 0) {
          return this.student1.answers;
        } else if (this.type == 3) {
          return this.classroom_answers;
        } else if (this.type == 1) {
          return this.group1.answers;
        }
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
        } else if (this.type == 1) {
          return parseInt(this.group1.max_fails);
        } else if (this.type == 3) {
          return parseInt(this.classroom_max_fails);
        }
      } else {
        if (this.type == 0) {
          return parseInt(this.student2.max_fails);
        } else return parseInt(this.group2.max_fails);
      }
    },
    checkWinner() {
      let points1 = 0;
      let points2 = 0;
      this.group1.answers.forEach((answer) => {
        if (answer) {
          points1++;
        } else points1--;
      });
      this.group2.answers.forEach((answer) => {
        if (answer) {
          points2++;
        } else points2--;
      });
      if (points1 > points2) this.winner(this.group1);
      else if (points2 > points1) this.winner(this.group2);
      else {
        this.winner(null);
      }
    },
    winnerClass() {
      this.finished = true;
      if (this.monsterSelected.hp == 0) {
        this.$refs.monster.classList.remove("pet-battle");
        this.$refs.monster.classList.add("pet-dead");
        confetti({
          particleCount: 200,
          spread: 100,
          origin: { y: 1.0 },
        });
      } else if (this.classroom_max_fails == 0) {
        this.$refs.monster.classList.add("animate__fast");
        this.$refs.monster.classList.add("animate__bounce");
        this.$refs.monster.classList.add("animate__infinite");
      }
    },
    winner(group) {
      this.finished = true;
      this.winnerElem = group;
    },
    answerClass(correct, next = true) {
      if (!correct) {
        this.student1.hp += parseInt(this.hp_loss);
        this.updateProp(this.student1.id, "hp", parseInt(this.hp_loss));
        if (this.max_fails != 0) this.classroom_max_fails -= 1;
        if (this.classroom_max_fails == 0 && this.max_fails != 0) {
          this.$refs.student1.$el.classList.add("animate__rotateOut");
          this.classroom_answers.push(correct);
          this.winnerClass();
          return true;
        }
      } else {
        this.monsterSelected.hp = Math.max(
          this.monsterSelected.hp + parseInt(this.monster_hp_loss),
          0
        );
        let options = {
          id: this.monsterSelected.id,
          value: parseInt(this.monster_hp_loss),
        };
        axios.post("/classroom/monsters/fight", options);

        this.$refs.monster.classList.add("shake-slow");
        this.$refs.monster.classList.add("shake-constant");
        this.$refs.monster.classList.add("shake-constant--hover");
        setTimeout(() => {
          this.$refs.monster.classList.remove("shake-constant");
        }, 1000);

        if (this.monsterSelected.hp == 0) {
          confetti({
            particleCount: 200,
            spread: 100,
            origin: { y: 1.0 },
          });
          this.winnerClass();
          return true;
        }
      }
      this.classroom_answers.push(correct);
      return false;
    },
    answerGroup(correct, next = true) {
      let group_1;
      let group_2;
      if (this.turn == 0) {
        group_1 = this.group1;
        group_2 = this.group2;
      } else {
        group_1 = this.group2;
        group_2 = this.group1;
      }
      if (!correct) {
        if (this.max_fails != 0) group_1.max_fails -= 1;
        if (group_1.max_fails == 0 && this.max_fails != 0) {
          if (this.turn == 0) {
            this.$refs.student1.$el.classList.add("animate__rotateOut");
          } else {
            this.$refs.student2.$el.classList.add("animate__rotateOut");
          }
          group_1.answers.push(correct);
          this.winner(group_2);
          return true;
        }
      }
      group_1.answers.push(correct);
      return false;
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

        student_1.hp = Math.max(student_1.hp + parseInt(this.hp_loss), 0);
        this.updateProp(student_1.id, "hp", parseInt(this.hp_loss));
        student_1.gold = Math.max(student_1.gold + parseInt(this.gold_loss), 0);
        this.updateProp(student_1.id, "gold", parseInt(this.gold_loss));
        student_1.xp = Math.max(student_1.xp + parseInt(this.xp_loss), 0);
        this.updateProp(student_1.id, "xp", parseInt(this.xp_loss));

        if (student_2.lastAnswer) {
          student_2.hp = Math.min(
            student_2.hp + parseInt(this.hp_transfer),
            100
          );
          this.updateProp(student_2.id, "hp", parseInt(this.hp_transfer));
          student_2.xp += parseInt(this.xp_transfer);
          this.updateProp(student_2.id, "xp", parseInt(this.xp_transfer));
          student_2.gold += this.gold_transfer;
          this.updateProp(student_2.id, "gold", parseInt(this.gold_transfer));
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
          return true;
        }
      }
      return false;
    },
    answer(correct, next = true) {
      this.answered = true;
      let gameOver;
      if (this.type == 0) {
        gameOver = this.answerIndividual(correct, next);
      } else if (this.type == 1) {
        gameOver = this.answerGroup(correct, next);
      } else if (this.type == 3) {
        gameOver = this.answerClass(correct, next);
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
        if (!gameOver) {
          if (this.turn == 1) {
            this.$refs.student2.$el.classList.add("shake-slow");
            this.$refs.student2.$el.classList.add("shake-constant");
            this.$refs.student2.$el.classList.add("shake-constant--hover");
            setTimeout(() => {
              this.$refs.student2.$el.classList.remove("shake-slow");
              this.$refs.student2.$el.classList.remove("shake-constant");
              this.$refs.student2.$el.classList.remove("shake-constant--hover");
            }, 2000);
          } else {
            this.$refs.student1.$el.classList.add("shake-slow");
            this.$refs.student1.$el.classList.add("shake-constant");
            this.$refs.student1.$el.classList.add("shake-constant--hover");
            setTimeout(() => {
              this.$refs.student1.$el.classList.remove("shake-slow");
              this.$refs.student1.$el.classList.remove("shake-constant");
              this.$refs.student1.$el.classList.remove("shake-constant--hover");
            }, 2000);
          }
        }
        this.audioKO.play();
      }
      this.showTimer = false;
    },
    updateProp: function (id, prop, value) {
      let options = { id: id, prop: prop, value: value, type: "battle" };
      axios.post("/classroom/students/update", options);
    },
    start() {
      if (this.selectedBank) {
        this.classroom.question_banks.forEach((element) => {
          if (element.id == this.selectedBank.id) {
            this.questions = _.shuffle(element.questions);
          }
        });
      }
      if (this.type == 3 && !this.monsterSelected) return false;
      if (this.type == 3) this.classroom_max_fails = this.max_fails;
      this.isBattleActive = true;
    },
    startBattle() {
      if (this.type != 3) {
        Math.random() < 0.5 ? (this.turn = 0) : (this.turn = 1);
      }
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
      this.showTimer = false;
      if (this.selectedBank && !this.questions.length) {
        this.finished = true;
        this.checkWinner();
      }

      setTimeout(this.reset, 1000);
      if (this.selectedBank) this.currentQuestion = this.questions.pop();
      if (this.type == 1) {
        if (this.turn == 0) {
          this.group_count1++;
          this.selectStudent(1);
        } else {
          this.group_count2++;
          this.selectStudent(2);
        }
      }
      if (this.type != 3) {
        this.turn = (this.turn + 1) % 2;
      } else {
        this.selectStudent(1);
      }
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
      if (this.type == 0 || this.type == 3) {
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
          let index = this.group_count1 % this.group1.students.length;
          this.student1 = this.group1.students[index];
        } else {
          let index = this.group_count2 % this.group2.students.length;
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
          return "";
          break;
        case 3:
          return this.trans.get("battles.allVSmonsters");
          break;
      }
    },
  },
};
</script>
<style>
@import "~csshake";
@import "~animate.css";
.monster-select:hover,
.monster-selected {
  background-color: skyblue;
}
</style>

