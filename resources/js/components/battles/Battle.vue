<template>
  <div class="p-3">
    <div v-if="!isBattleActive && !battlestd">
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
              <i class="fas fa-user mr-1"></i> vs
              <i class="fas fa-user ml-1"></i>
            </b-radio-button>

            <b-radio-button
              v-model="type"
              :native-value="1"
              type="is-info"
              expanded
              :disabled="groups && groups.length < 2"
            >
              <i class="fas fa-users mr-1"></i> vs
              <i class="fas fa-users ml-1"></i>
            </b-radio-button>
            <b-radio-button
              v-model="type"
              :native-value="2"
              expanded
              type="is-info"
              :disabled="groups && groups.length < 1"
            >
              <i class="fas fa-users mr-1"></i> vs
              <i class="fas fa-dragon ml-1"></i>
            </b-radio-button>
            <b-radio-button
              v-model="type"
              :native-value="4"
              expanded
              type="is-info"
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
            v-if="
              classroom.monsters.length == 0 &&
              (type == 3 || type == 2 || type == 4)
            "
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
          <h3 class="m-2" v-if="type == 0 || type == 4">
            <i class="fas fa-user"></i> {{ trans.get("battles.loss_fail") }}
          </h3>
          <div class="columns m-2" v-if="type == 0 || type == 4">
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
          <h3 class="m-2" v-if="type == 3 || type == 2">
            <i class="fas fa-user"></i> {{ trans.get("battles.loss_fail") }}
          </h3>
          <div class="columns m-2" v-if="type == 3 || type == 2">
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
          <h3 class="m-2" v-if="type == 3 || type == 2 || type == 4">
            <i class="fas fa-dragon"></i>
            {{ trans.get("battles.monster_hp_loss") }}
          </h3>
          <div
            class="column is-narrow"
            v-if="type == 3 || type == 2 || type == 4"
          >
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
                          <i
                            class="fas fa-stopwatch colored has-text-light"
                          ></i>
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
          <b-field v-if="type != 4">
            <b-switch
              v-model="autoStart"
              :true-value="true"
              :false-value="false"
            >
              {{ trans.get("battles.auto_start") }}
            </b-switch>
          </b-field>
        </b-step-item>

        <b-step-item
          step="3"
          :visible="type == 3 || type == 2 || type == 4"
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
              'has-hr': monster.hp > 0,
            }"
          >
            <div v-if="monster.hp > 0" class="columns">
              <div class="column is-narrow">
                <img
                  @contextmenu.prevent=""
                  width="81px"
                  :src="monster.image"
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
          :step="type == 3 || type == 2 ? '4' : '3'"
          :label="trans.get('battles.questions')"
          :clickable="true"
        >
          <div v-if="!classroom.question_banks.length">
            <p class="m-2">
              {{ trans.get("battles.bank_empty") }}
            </p>
            <a class="button is-info" v-if="type != 4" @click="activeStep += 1">
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
              v-if="type != 4"
            >
              {{ trans.get("battles.im_bank") }} 😏</a
            >
            <h2 v-if="type != 4">{{ trans.get("battles.bank") }}</h2>

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
          :step="type == 3 || type == 2 ? '5' : '4'"
          :label="trans.get('battles.start')"
          :clickable="true"
          disabled
        >
          <div class="content">
            <h1>{{ trans.get("general.summary") }}</h1>
            <ul class="fs-2">
              <li>
                <i
                  class="fas"
                  :class="{
                    'fa-user': type == 0 || type == 3 || type == 4,
                    'fa-users': type == 1 || type == 2,
                  }"
                ></i>
                vs
                <i
                  class="fas"
                  :class="{
                    'fa-user': type == 0,
                    'fa-users': type == 1,
                    'fa-dragon': type == 3 || type == 2 || type == 4,
                  }"
                ></i>
              </li>
              <li>
                <span v-if="!selectedBank && type != 4">{{
                  trans.get("battles.wb")
                }}</span>
                <span class="has-text-danger" v-else-if="!selectedBank">
                  {{ trans.get("battles.wb") }}
                </span>
                <span v-else
                  >{{ trans.get("battles.questions") }}:
                  {{ selectedBank.title }}</span
                >
              </li>
              <li v-if="selectedBank && monsterSelected && checkImpossible()">
                <span class="has-text-danger">{{
                  trans.get("battles.impossible")
                }}</span>
              </li>
              <li v-if="type == 3 || type == 2 || type == 4">
                <span class="has-text-danger" v-if="!monsterSelected">{{
                  trans.get("battles.wm")
                }}</span>
                <span v-else
                  >{{ trans.get("battles.monster") }}:
                  {{ monsterSelected.name }}</span
                >
              </li>
            </ul>
          </div>
          <div class="has-text-centered">
            <button
              class="button is-size-2 py-3 px-6 is-info m-3"
              v-if="type != 4"
              :disabled="(type == 3 || type == 2) && !monsterSelected"
              @click="start"
            >
              {{ trans.get("battles.start") }}!
            </button>
            <button
              class="button is-size-2 py-3 px-6 is-info m-3"
              v-else
              :disabled="!monsterSelected || !selectedBank || checkImpossible()"
              @click="scheduleBattle"
            >
              {{ trans.get("battles.start_14") }}!
            </button>
          </div>
        </b-step-item>
      </b-steps>
      <div class="p-2 mt-2">
        <h3
          class="is-size-3 mb-3"
          v-if="classroom.battles && classroom.battles.length"
        >
          <i class="mr-2 fad fa-swords"></i> Batallas individuales
        </h3>
        <div
          @input="changeState(battle)"
          class="p-2"
          v-for="battle in sortedBattles"
          :key="battle.id"
        >
          <b-field>
            <b-switch v-model="battle.enabled" :true-value="1" :false-value="0">
              {{ battle.monster.name }}: {{ battle.monster.reward_xp }}
              <i class="fas fa-fist-raised colored"></i> |
              {{ battle.monster.reward_gold }}
              <i class="fas fa-coins colored mr-2"></i> ({{
                getDate(battle.created_at)
              }})
            </b-switch>
          </b-field>
        </div>
      </div>
    </div>

    <b-modal
      v-else
      :active.sync="isBattleActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title is-flex is-center-vertically">
            {{ trans.get("menu.battles") }}
            <span v-if="!battlestd">
              <audio :src="'/music/' + track" loop controls></audio>
              <select class="select" v-model="track">
                <option v-for="(trackS, index) in music" :key="index">
                  {{ trackS }}
                </option>
              </select>
            </span>
          </p>
        </header>
        <section class="modal-card-body is-relative" id="confetti-bg">
          <div class="columns">
            <div
              class="
                column
                rounded
                is-flex is-flex-direction-column
                has-text-centered
                is-narrow
              "
            >
              <div v-if="(type == 1 && group1) || (type == 2 && group1)">
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
                  :theme="classroom.background"
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
                  :class="{ 'is-success': answer.state, 'is-danger': !answer.state }"
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
              <div v-if="(type == 1 || type == 2) && !started && groups.length">
                <button @click="selectGroup(1)" class="button is-primary my-2">
                  {{ trans.get("battles.select_group") }}
                  <i class="fas fa-random ml-1"></i>
                </button>
              </div>
            </div>
            <div class="column is-flex has-text-centered">
              <div class="columns w-100" style="flex-direction: column">
                <div class="column is-narrow">
                  <countdown
                    v-if="!finished"
                    @finish="finishCd"
                    class="ml-2"
                    ref="cd"
                    :autoStart="false"
                    :left-time="timer"
                  >
                    <span slot="process" slot-scope="{ timeObj }">
                      <span
                        class="button fs-2"
                        :class="{
                          'is-warning': timeObj.ceil.s <= 15,
                          'is-danger': timeObj.ceil.s <= 5,
                        }"
                      >
                        {{ timeObj.ceil.s }}
                      </span>
                      <button
                        class="button is-info fs-2"
                        @click="toggleCd"
                        v-if="!battlestd"
                      >
                        <i
                          class="fas"
                          :class="{
                            'fa-play': isCountDownPaused,
                            'fa-pause': !isCountDownPaused,
                          }"
                        ></i>
                      </button>
                    </span>

                    <span slot="finish" class="button fs-2 is-danger"
                      ><i class="far fa-alarm-clock faa-wrench animated"></i
                    ></span>
                  </countdown>
                </div>
                <div class="column has-all-centered">
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
                        class="
                          is-flex is-flex-direction-column
                          has-all-centered
                        "
                      >
                        <h1 class="is-size-2">
                          {{ trans.get("battles.tell_next") }}
                        </h1>
                        <div class="buttons my-2 has-text-centered">
                          <button
                            class="button is-success"
                            @click="answer(true)"
                          >
                            <i class="fad fa-thumbs-up"></i>
                            {{ trans.get("battles.answer_ok") }}
                          </button>
                          <button
                            class="button is-danger"
                            @click="answer(false)"
                          >
                            <i class="fad fa-thumbs-down"></i>
                            {{ trans.get("battles.answer_ko") }}
                          </button>
                        </div>
                        <!-- <button
                      class="button"
                      @click="showTimer = true"
                      v-if="!showTimer && !answered"
                    >
                      <i class="fad fa-stopwatch mr-1"></i>
                      {{ trans.get("battles.show_timer") }}
                    </button> -->
                      </div>
                      <div v-else-if="!finished">
                        <button class="button is-size-2" @click="nextQuestion">
                          {{ trans.get("battles.next") }}
                        </button>
                      </div>
                    </div>
                    <div
                      v-else-if="!finished"
                      class="
                        w-100
                        has-all-centered
                        is-flex is-flex-direction-column
                      "
                    >
                      <show-question
                        :question="currentQuestion"
                      ></show-question>
                      <!-- <button
                    class="button"
                    @click="showTimer = true"
                    v-if="!showTimer && !answered"
                  >
                    <i class="fad fa-stopwatch mr-1"></i>
                    {{ trans.get("battles.show_timer") }}
                  </button> -->
                      <!-- <count-down
                    v-if="!answered && showTimer"
                    :starttime="new Date(1, 1, 1, 0, 0, timer_default)"
                  ></count-down> -->
                    </div>
                    <div v-if="finished" class="has-text-centered">
                      <h1
                        class="
                          is-size-1
                          animate__animated
                          animate__rubberBand
                          animate__infinite
                        "
                        v-if="
                          (type != 3 && type != 2) ||
                          ((type == 3 || type == 2) && monsterSelected.hp == 0)
                        "
                      >
                        {{ trans.get("battles.well_done") }}
                        <span v-if="winnerElem">{{ winnerElem.name }}</span>
                      </h1>
                      <div class="is-size-3" v-else>
                        {{ monsterSelected.name }}
                        {{ trans.get("battles.defeat") }}
                      </div>
                      <button
                        class="button is-success mt-2"
                        v-if="winnerElem"
                        @click="sendReward"
                        :class="{ 'is-loading': isLoading }"
                      >
                        {{ trans.get("battles.give_reward") }}
                        {{ winnerElem.name }}
                      </button>
                      <button
                        class="button is-success mt-2"
                        v-if="
                          (type == 3 || type == 2) && monsterSelected.hp == 0
                        "
                        @click="sendReward"
                        :class="{ 'is-loading': isLoading }"
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
              </div>
            </div>
            <div
              class="
                column
                rounded
                is-flex is-flex-direction-column
                has-text-centered
                is-narrow
              "
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
                  :theme="classroom.background"
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
                  :class="{ 'is-success': answer.state, 'is-danger': !answer.state }"
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
              <div v-if="type == 1 && !started && groups.length">
                <button @click="selectGroup(2)" class="button is-primary my-2">
                  {{ trans.get("battles.select_group") }}
                  <i class="fas fa-random ml-1"></i>
                </button>
              </div>
              <div
                ref="monsterdiv"
                v-if="(type == 3 || type == 2 || type == 4) && monsterSelected"
              >
                <img
                  @contextmenu.prevent=""
                  ref="monster"
                  :src="monsterSelected.image"
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
          v-if="!battlestd"
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
import VueAwesomeCountdown from "vue-awesome-countdown";
import Utils from "../../utils.js";

export default {
  components: { ShowQuestion, CountDown, VueAwesomeCountdown },
  props: {
    classroom: null,
    battlestd: {
      type: Number,
      default: false,
    },
  },
  computed: {
    sortedBattles() {
      return _.orderBy(this.classroom.battles, "created_at", "desc");
    },
    cantStart() {
      if (this.type == 0 || this.type == 1) {
        return (
          !this.student1 ||
          !this.student2 ||
          this.student1.id == this.student2.id
        );
      } else if (this.type == 3) {
        return !this.student1;
      } else if (this.type == 2) return !this.group1;
      this.$forceUpdate();
    },
  },
  mounted() {
    if (this.battlestd) {
      axios
        .post(`/classroom/${this.classroom.code}/battles/info`, {
          battle: this.battlestd,
        })
        .then((response) => {
          let options = JSON.parse(response.data.battle.options);
          console.log(options);
          console.log(response.data);
          this.monsterSelected = response.data.monster;

          // TODO :D
          this.monsterSelected.hp = 100;

          this.selectedBank = response.data.bank;
          this.questions = _.shuffle(this.selectedBank.questions);
          this.xp_loss = options.xp_loss;
          this.max_fails = options.max_fails;
          this.monster_hp_loss = options.monster_hp_loss;
          this.timer_default = options.timer_default;
          this.hp_loss = options.hp_loss;
          this.gold_loss = options.gold_loss;
          this.student1 = response.data.student;

          // TODO! :D
          this.student1.answers = [];
          this.autoStart = true;
          this.student1.max_fails = options.max_fails;
          this.type = 4;
          this.isBattleActive = true;
        });
    } else {
      this.students = _.shuffle(this.classroom.students);
      this.classroom.grouping[0].groups.forEach((element) => {
        if (element.students && element.students.length) {
          this.groups.push(element);
        }
      });
      this.groups = _.shuffle(this.groups);
    }
  },
  data: function () {
    return {
      isLoading: false,
      audioOK: new Audio("/sound/clap.mp3"),
      audioKO: new Audio("/sound/wheel-bad.mp3"),
      audioTimer: new Audio("/sound/beep.mp3"),
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
      isCountDownPaused: true,
      finished: false,
      lastAnswer1: false,
      lastAnswer2: false,
      questions: null,
      currentQuestion: null,
      answered: false,
      max_fails: 3,
      winnerElem: null,
      autoStart: false,
      timer_default: 30,
      timer: 30000,
      monsterSelected: null,
      classroom_max_fails: 0,
      classroom_answers: [],
      track: "Battle theme.mp3",
      music: [
        "A legend will rise.mp3",
        "Happy adveture.mp3",
        "Action game.mp3",
        "Kings feast.mp3",
        "Action track.mp3",
        "Lonelyhood.ogg",
        "Adventuring song.mp3",
        "Mega wall.mp3",
        "Battle theme.mp3",
        "Minstrel dance.mp3",
        "Battle.mp3",
        "Mythica.mp3",
        "Boss battle.mp3",
        "Out there.ogg",
        "Carnival rides.ogg",
        "Prepare your swords.mp3",
        "Dark rainy night.ogg",
        "Tavern.ogg",
        "Desert.ogg",
        "The Bards tale.mp3",
        "Enchanted tiki.mp3",
        "The field of dreams.mp3",
        "Epic Boss battle.mp3",
        "The Old Tower Inn.mp3",
        "Eye of the storm.mp3",
        "Tower defense.mp3",
        "Fantasy Choir 1.mp3",
        "Town TPG.mp3",
        "Fantasy Choir 2.mp3",
        "Wow chapter 1.ogg",
        "Fantasy Choir 3.mp3",
        "Zombies are coming.ogg",
        "Fantasy orchestral theme.mp3",
      ],
    };
  },
  methods: {
    getDate(date) {
      return Utils.getDate(date);
    },
    changeState(battle) {
      axios.post(`/classroom/${this.classroom.code}/battles/toggle`, {
        battle: battle.id,
        state: !battle.enabled ? 1 : 0,
      });
    },
    checkImpossible() {
      if (this.selectedBank.questions.length * this.monster_hp_loss * -1 < 100)
        return true;
      return false;
    },
    scheduleBattle() {
      axios
        .post(`/classroom/${this.classroom.code}/battles/schedule`, {
          question_bank_id: this.selectedBank.id,
          monster_id: this.monsterSelected.id,
          options: {
            hp_loss: this.hp_loss,
            gold_loss: this.gold_loss,
            xp_loss: this.xp_loss,
            monster_hp_loss: this.monster_hp_loss,
            timer_default: this.timer_default,
            max_fails: this.max_fails,
          },
        })
        .then((response) => {
          // console.log(response);
          this.$toast(this.trans.get("success_error.add_success"), {
            type: "success",
          });
          setTimeout(() => {
            location.reload();
          }, 1000);
        });
    },
    sendReward() {
      this.isLoading = true;
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
      } else if (this.type == 2) {
        axios
          .post("/classroom/" + this.classroom.code + "/group/reward", {
            xp: this.monsterSelected.reward_xp,
            gold: this.monsterSelected.reward_gold,
            group: this.group1.id,
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
        if (this.type == 0 || this.type == 4) {
          return this.student1.answers;
        } else if (this.type == 3) {
          return this.classroom_answers;
        } else if (this.type == 1 || this.type == 2) {
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
        if (this.type == 0 || this.type == 4) {
          return parseInt(this.student1.max_fails);
        } else if (this.type == 1 || this.type == 2) {
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
    winnerClass(all = true) {
      this.finished = true;
      if (this.monsterSelected.hp == 0) {
        this.$refs.monster.classList.remove("pet-battle");
        this.$refs.monster.classList.add("pet-dead");
        confetti({
          particleCount: 200,
          spread: 100,
          origin: { y: 1.0 },
        });
      } else if (this.classroom_max_fails == 0 || this.max_fails == 0) {
        this.$refs.monster.classList.add("animate__fast");
        this.$refs.monster.classList.add("animate__bounce");
        this.$refs.monster.classList.add("animate__infinite");
      }
    },
    winner(group) {
      this.finished = true;
      this.winnerElem = group;
    },
    shake(elem) {
      elem.classList.add("shake-slow");
      elem.classList.add("shake-constant");
      elem.classList.add("shake-constant--hover");
      setTimeout(() => {
        elem.classList.remove("shake-slow");
        elem.classList.remove("shake-constant");
        elem.classList.remove("shake-constant--hover");
      }, 2000);
    },
    hitMonster() {
      this.monsterSelected.hp = Math.max(
        this.monsterSelected.hp + parseInt(this.monster_hp_loss),
        0
      );
      let options = {
        id: this.monsterSelected.id,
        value: parseInt(this.monster_hp_loss),
      };
      axios.post("/classroom/monsters/fight", options);
      this.shake(this.$refs.monster);

      if (this.monsterSelected.hp == 0) {
        confetti({
          particleCount: 200,
          spread: 100,
          origin: { y: 1.0 },
        });
        this.winnerClass();
        return true;
      }
    },
    answerClass(correct, next = true) {
      if (!correct) {
        this.student1.hp += parseInt(this.hp_loss);
        this.student1.xp += parseInt(this.xp_loss);
        this.updateProp(this.student1.id, "hp", parseInt(this.hp_loss));
        this.updateProp(this.student1.id, "xp", parseInt(this.xp_loss));
        if (this.max_fails != 0) this.classroom_max_fails -= 1;
        if (this.classroom_max_fails == 0 && this.max_fails != 0) {
          this.$refs.student1.$el.classList.add("animate__rotateOut");
          this.classroom_answers.push({question: this.currentQuestion ? this.currentQuestion.id : null , state: correct});
          this.winnerClass();
          return true;
        }
      } else {
        this.hitMonster();
      }
      this.classroom_answers.push({question: this.currentQuestion ? this.currentQuestion.id : null , state: correct});
      return false;
    },
    answerGroupMonster(correct, next = true) {
      if (!correct) {
        this.student1.hp += parseInt(this.hp_loss);
        this.student1.xp += parseInt(this.xp_loss);
        this.updateProp(this.student1.id, "hp", parseInt(this.hp_loss));
        this.updateProp(this.student1.id, "xp", parseInt(this.xp_loss));
        if (this.max_fails != 0) this.group1.max_fails -= 1;
        if (this.group1.max_fails == 0 && this.max_fails != 0) {
          this.$refs.student1.$el.classList.add("animate__rotateOut");
          this.group1.answers.push({question: this.currentQuestion ? this.currentQuestion.id : null , state: correct});
          this.winnerClass();
          return true;
        }
      } else {
        this.hitMonster();
      }
      this.group1.answers.push({question: this.currentQuestion ? this.currentQuestion.id : null , state: correct});
      this.$forceUpdate();
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
          group_1.answers.push({question: this.currentQuestion ? this.currentQuestion.id : null , state: correct});
          this.winner(group_2);
          return true;
        }
      }
      group_1.answers.push({question: this.currentQuestion ? this.currentQuestion.id : null , state: correct});
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
      student_1.answers.push({question: this.currentQuestion ? this.currentQuestion.id : null , state: correct});

      if (!correct) {
        if (this.max_fails != 0) student_1.max_fails -= 1;

        student_1.hp = Math.max(student_1.hp + parseInt(this.hp_loss), 0);
        this.updateProp(student_1.id, "hp", parseInt(this.hp_loss));
        student_1.gold = Math.max(student_1.gold + parseInt(this.gold_loss), 0);
        this.updateProp(student_1.id, "gold", parseInt(this.gold_loss));
        student_1.xp = Math.max(student_1.xp + parseInt(this.xp_loss), 0);
        this.updateProp(student_1.id, "xp", parseInt(this.xp_loss));

        if (!this.battlestd && student_2.lastAnswer) {
          student_2.hp = Math.min(
            student_2.hp + parseInt(this.hp_transfer),
            100
          );
          this.updateProp(student_2.id, "hp", parseInt(this.hp_transfer));
          student_2.xp += parseInt(this.xp_transfer);
          this.updateProp(student_2.id, "xp", parseInt(this.xp_transfer));
          student_2.gold += parseInt(this.gold_transfer);
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
      } else if (this.type == 4) {
        this.hitMonster();
      }
      return false;
    },
    answer(correct, next = true) {
      this.pauseCd();
      this.answered = true;
      let gameOver;
      if (this.type == 0 || this.type == 4) {
        gameOver = this.answerIndividual(correct, next);
      } else if (this.type == 1) {
        gameOver = this.answerGroup(correct, next);
      } else if (this.type == 3) {
        gameOver = this.answerClass(correct, next);
      } else if (this.type == 2) {
        gameOver = this.answerGroupMonster(correct, next);
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
            this.shake(this.$refs.student2.$el);
          } else {
            this.shake(this.$refs.student1.$el);
          }
        }
        this.audioKO.play();
      }
    },
    updateProp: function (id, prop, value) {
      let options = { id: id, prop: prop, value: value, type: "battle" };
      axios.post("/classroom/students/update", options);
    },
    start() {
      this.timer = this.timer_default * 1000;
      if (this.selectedBank) {
        this.classroom.question_banks.forEach((element) => {
          if (element.id == this.selectedBank.id) {
            this.questions = _.shuffle(element.questions);
          }
        });
      }
      if ((this.type == 3 || this.type == 2) && !this.monsterSelected)
        return false;
      if (this.type == 3) this.classroom_max_fails = this.max_fails;
      this.isBattleActive = true;
    },

    finishCd() {
      this.audioTimer.play();
    },
    resetCd() {
      if (this.started && !this.finished) {
        this.timer = this.timer_default * 1000;
      }
      this.$refs.cd.startCountdown(true);
      if (!this.autoStart || !this.started) {
        this.pauseCd();
        this.isCountDownPaused = true;
      } else this.isCountDownPaused = false;
    },
    toggleCd() {
      if (this.isCountDownPaused) this.playCd();
      else this.pauseCd();
    },
    playCd() {
      this.$refs.cd.startCountdown();
      this.isCountDownPaused = false;
      this.$forceUpdate();
    },
    pauseCd() {
      this.$refs.cd.pauseCountdown();
      this.isCountDownPaused = true;
      this.$forceUpdate();
    },
    startBattle() {
      if (this.type != 3 && this.type != 2 && !this.battlestd) {
        Math.random() < 0.5 ? (this.turn = 0) : (this.turn = 1);
      }
      this.started = true;
      this.resetCd();
      if (this.selectedBank) this.currentQuestion = this.questions.pop();
    },
    skipQuestion() {
      this.resetCd();

      if (this.selectedBank && !this.questions.length) this.finished = true;
      this.currentQuestion = this.questions.pop();
      this.$forceUpdate();
      return this.currentQuestion;
    },
    nextQuestion() {
      this.resetCd();
      if (this.selectedBank && !this.questions.length) {
        this.finished = true;
        this.checkWinner();
      }

      setTimeout(this.reset, 1000);
      if (this.selectedBank) this.currentQuestion = this.questions.pop();
      if (this.type == 2) {
        this.group_count1++;
        this.selectStudent(1);
      }
      if (this.type == 1) {
        if (this.turn == 0) {
          this.group_count1++;
          this.selectStudent(1);
        } else {
          this.group_count2++;
          this.selectStudent(2);
        }
      }
      if (this.type != 3 && this.type != 2 && this.type != 4) {
        this.turn = (this.turn + 1) % 2;
      } else if (this.type != 4) {
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
      this.resetCd();

      if (slot == 1) {
        this.group1 = this.groups.pop();
        this.group1.max_fails = this.max_fails;
        this.group1.answers = [];
        this.group1.students = _.shuffle(this.group1.students);
        this.selectStudent(1);
      } else {
        this.group2 = this.groups.pop();
        this.group2.max_fails = this.max_fails;
        this.group2.answers = [];
        this.group2.students = _.shuffle(this.group2.students);
        this.selectStudent(2);
      }
    },
    selectStudent(slot) {
      this.resetCd();

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
      } else if (this.type == 1 || this.type == 2) {
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
        case 1:
          return this.trans.get("battles.groupVSgroup");
        case 2:
          return this.trans.get("battles.groupVSmonsters");
        case 3:
          return this.trans.get("battles.allVSmonsters");
        case 4:
          return this.trans.get("battles.oneVSmonsters");
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

