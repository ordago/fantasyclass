<template>
  <div>
    <div
      class="utilities columns is-multiline is-flex rounded card-shadow-s has-padding-y-2 has-margin-2 has-margin-left-0"
      id="utilities"
    >
      <div class="tools rounded-left">
        <i class="fal fa-tools"></i>
      </div>
      <div class="column is-flex">
        <a
          class="link outer_glow has-text-dark has-padding-x-2"
          v-tippy
          :content="trans.get('menu.groups')"
          :href="'/classroom/' + classroom.code + '/groups'"
        >
          <i class="fad fa-users outer_glow" style="font-size:2em;"></i>
        </a>
        <div class="dropdown is-hoverable" style="display:inline-block">
          <span
            class="dropdown-trigger link outer_glow has-margin-y-0 has-padding-y-0 has-padding-x-1"
          >
            <i class="fad fa-random outer_glow" style="font-size:2em;"></i>
            <span class="icon is-small">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </span>

          <div class="dropdown-menu has-background-white rounded has-padding-3">
            <a class="dropdown-item" :href="'/classroom/' + classroom.code + '/event/random'">
              <i class="fad fa-scroll-old has-margin-right-2"></i>
              Random {{ trans.get('menu.events') }}
            </a>
            <a class="dropdown-item" @click="randomStudents" v-if="students.length">
              <i class="fad fa-user has-margin-right-2"></i>
              Random {{ trans.get('menu.students') }}
            </a>
            <a
              class="dropdown-item"
              @click="randomGroups"
              v-if="classroom.grouping[0].groups.length > 0"
            >
              <i class="fad fa-users has-margin-right-2"></i>
              Random {{ trans.get('menu.groups') }}
            </a>
            <a
              class="dropdown-item"
              @click="getRandomCard"
              v-if="students.length || classroom.grouping[0].groups.length"
            >
              <i class="fad fa-club has-margin-right-2"></i>
              Random {{ trans.get('menu.card') }}
            </a>
          </div>
        </div>
        <a
          class="link outer_glow has-text-dark has-padding-x-2"
          v-tippy
          :content="trans.get('menu.classcode')"
          @click="showClassCode"
        >
          <i class="fad fa-qrcode outer_glow" style="font-size:2em;"></i>
        </a>
        <span
          class="link outer_glow cursor-pointer"
          @click="rollTheDice"
          v-tippy
          :content="trans.get('menu.dice')"
        >
          <i class="fad fa-dice" style="font-size:2em;"></i>
        </span>
        <a
          href="/utils/music"
          target="_blank"
              v-tippy
          :content="trans.get('menu.music')"
          class="link outer_glow has-padding-x-2 cursor-pointer has-text-dark"
        >
          <i class="fad fa-music outer_glow" style="font-size:2em;"></i>
        </a>
        <span
          class="link outer_glow has-padding-x-2 cursor-pointer"
              v-tippy
          :content="trans.get('menu.countdown')"
          @click="isCountDownModalActive=true"
        >
          <i class="fad fa-stopwatch outer_glow" style="font-size:2em;"></i>
        </span>
        <!-- <span class="link outer_glow has-padding-x-2 cursor-pointer">
          <i class="fad fa-poll-people" style="font-size: 2em;"></i>
        </span>-->
      </div>
      <!--<span class="link outer_glow"><i class="fad fa-chart-pie" style="font-size:2em;"></i></span>
        <span class="lin
        k outer_glow"><a style="font-size: 2em;" href="utils/attendance.php"><i class="fad fa-calendar-check"></i></a></span>
        <span class="link outer_glow" ><i class="fad fa-microphone outer_glow" style="font-size:2em;"></i></span>
        <a href="utils/questions.php" class="link outer_glow"><i class="fad fa-question-square" style="font-size:2em;"></i></a>
      -->
      <div class="column has-text-right is-center-vertically" v-if="students.length>0">
        <!-- <span class="mr-1 hideGrid pointer" v-tippy :content="trans.get('users_groups.change_layout')" @click="changeView"><i class="fas fa-th fs-1 colored" style="color:white"></i></span> -->
        <span>
          <i class="fal fa-sort-numeric-down-alt has-margin-right-3"></i>
        </span>
        <span
          v-tippy
          :content="trans.get('users_groups.order_name')"
          v-bind:class="{ coloredGray: sortKey != 'name' }"
          @click="orderBy('name');"
          style="color: #eee;"
          data-id="0"
          class="colored pointer"
        >
          <i class="fas fa-user pointer has-margin-right-3"></i>
        </span>
        <span
          v-tippy
          :content="trans.get('users_groups.order_hp')"
          v-bind:class="{ coloredGray: sortKey != 'hp' }"
          @click="orderBy('hp');"
          class="colored"
        >
          <i class="fas fa-heart pointer has-margin-right-3"></i>
        </span>
        <span
          v-tippy
          :content="trans.get('users_groups.order_xp')"
          v-bind:class="{ coloredGray: sortKey != 'xp' }"
          @click="orderBy('xp');"
          class="colored"
        >
          <i class="fas fa-fist-raised pointer has-margin-right-3"></i>
        </span>
        <span
          v-tippy
          :content="trans.get('users_groups.order_gold')"
          v-bind:class="{ coloredGray: sortKey != 'gold' }"
          @click="orderBy('gold');"
          class="colored"
        >
          <i class="fas fa-coins pointer has-margin-right-3"></i>
        </span>
        <!-- <input type="checkbox" id="toggleStdView" class="cbx" style="display:none"/>
            <label  style="width: 40px" for="toggleStdView" class="toggle"><span></span></label>
        <span><i class="fas fa-user ml-2 outer_glow"></i></span>-->
      </div>
    </div>
    <div class="columns is-multiline is-variable is-1 has-margin-y-2">
      <div
        class="column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
        v-for="student in orderedStudents"
        v-bind:key="student.id"
      >
        <div class="card rounded card-shadow-s">
          <span
            class="level-top rounded has-padding-4 has-background-light"
            v-if="student.level"
          >{{ student.level.number }}</span>

          <div
            class="card-image card-shadow-s rounded-top char-bg"
            :style="'background-color:' + classroom.theme.color + ';background-image: url(/img/bg/thumb_' + classroom.theme.name + ');'"
          >
            <div class="character-container character character-small is-relative">
              <img
                :src="'/img/character/' + element.src"
                :class="element.classes"
                v-for="element in student.equipment"
                v-bind:key="element.id"
              />
            </div>
          </div>
          <div class="card-content">
            <div class="media has-margin-bottom-0">
              <div class="media-left">
                <figure class="image is-48x48">
                  <img :src="student.avatar" class="rounded" alt />
                </figure>
              </div>
              <div class="media-content cursor-pointer" @click="redirect(student.id)">
                <p class="title is-4">{{ student.name }}</p>
                <p class="subtitle is-6">
                  <small>@{{ student.username }}</small>
                </p>
              </div>
            </div>

            <div class="content">
              <div>
                <div class="centered-attribute has-padding-2 has-margin-top-4 has-margin-bottom-3">
                  <span
                    class="attribute has-background-white-ter has-padding-y-2 rounded"
                    style="width:100%;"
                  >
                    <span>
                      <i class="fas fa-heart has-text-grey-light"></i>
                    </span>
                    <span class="has-text-grey-light" v-if="student.hp<20">{{ student.hp }}</span>
                  </span>
                  <span
                    class="attribute has-background-danger has-padding-y-2 rounded-left"
                    v-bind:class="{ rounded: student.hp==100 }"
                    :style="'width: ' + student.hp + '%'"
                    v-if="student.hp>0"
                  >
                    <i class="fas fa-heart" v-bind:class="{ 'has-text-danger': student.hp<52 }"></i>
                    <span v-if="student.hp>=20">{{ student.hp }}</span>
                  </span>
                </div>
                <div class="my-1 has-text-centered">
                  <div class="w-100 is-flex has-all-centered">
                    <button
                      v-for="behaviour in mainBehavioursJson"
                      v-tippy
                      :content="trans.get(behaviour.name) + ' <small>(<i class=\'fas fa-heart colored\'></i> ' + behaviour.hp + ' <i class=\'fas fa-fist-raised colored\'></i> '+ behaviour.xp +' <i class=\'fas fa-coins colored\'></i> '+ behaviour.gold +')</small>'"
                      class="button has-margin-1 has-padding-x-4 is-light"
                      @click="addBehaviour(student.id, behaviour.id)"
                      v-bind:class="[ behaviour.xp + behaviour.hp + behaviour.gold >= 0 ? 'is-success' : 'is-danger']"
                      v-bind:key="behaviour.id"
                    >
                      <i :class="behaviour.icon"></i>
                    </button>
                    <div
                      class="button is-link is-light has-margin-1 has-padding-x-4"
                      @click="show2l=!show2l"
                      v-if="otherBehavioursJson.length"
                    >
                      <i class="fas fa-plus"></i>
                    </div>
                    <a
                      :href="'/classroom/' + classroom.code + '/behaviours/'"
                      class="button is-link is-light has-margin-1 has-padding-x-4"
                      v-tippy
                      :content="trans.get('users_groups.add_behaviours')"
                      v-if="mainBehavioursJson.length == 0"
                    >
                      <i class="fas fa-plus"></i>
                    </a>
                  </div>
                  <div v-if="show2l">
                    <button
                      v-for="behaviour in otherBehavioursJson"
                      v-tippy
                      :content="trans.get(behaviour.name) + ' <small>(<i class=\'fas fa-heart colored\'></i> ' + behaviour.hp + ' <i class=\'fas fa-fist-raised colored\'></i> '+ behaviour.xp +' <i class=\'fas fa-coins colored\'></i> '+ behaviour.gold +')</small>'"
                      class="button has-margin-1 is-light has-padding-x-4"
                      v-bind:class="[ behaviour.xp + behaviour.hp + behaviour.gold >= 0 ? 'is-success' : 'is-danger']"
                      v-bind:key="behaviour.id"
                      @click="addBehaviour(student.id, behaviour.id)"
                    >
                      <i :class="behaviour.icon"></i>
                    </button>
                  </div>
                </div>
                <div class="score has-padding-3 has-margin-1">
                  <span>
                    <i class="fas fa-fist-raised colored"></i>
                  </span>
                  {{ student.xp }}
                </div>
                <div class="has-margin-y-2 has-text-centered">
                  <button
                    type="submit"
                    @click="updateProp(student.id, 'xp', 100)"
                    class="button is-dark has-padding-x-3"
                  >100</button>
                  <button
                    type="submit"
                    @click="updateProp(student.id, 'xp', 50)"
                    class="button is-dark has-padding-x-3"
                  >50</button>
                  <button
                    type="submit"
                    @click="updateProp(student.id, 'xp', 10)"
                    class="button is-dark has-padding-x-3"
                  >10</button>
                  <tippy
                    interactive
                    :animate-fill="false"
                    theme="light"
                    placement="bottom"
                    animation="fade"
                    trigger="click"
                    style="display:inline-block"
                    arrow
                  >
                    <template v-slot:trigger>
                      <button type="submit" class="button is-primary has-padding-x-3">
                        <i class="fas fa-hashtag"></i>
                      </button>
                    </template>
                    <span>
                      <div class="is-flex">
                        <input type="number" v-model="custom" class="input has-margin-right-1" />
                        <button
                          @click="updateProp(student.id, 'xp', custom)"
                          class="button is-primary is-inline"
                        >{{trans.get('users_groups.apply')}}</button>
                      </div>
                    </span>
                  </tippy>
                  <button
                    type="submit"
                    @click="updateProp(student.id, 'xp', -10)"
                    class="button is-dark is-outlined has-padding-x-2"
                  >-10</button>
                  <button
                    type="submit"
                    @click="updateProp(student.id, 'xp', -50)"
                    class="button is-dark is-outlined has-padding-x-2"
                  >-50</button>
                  <button
                    type="submit"
                    @click="updateProp(student.id, 'xp', -100)"
                    class="button is-dark is-outlined has-padding-x-2"
                  >-100</button>
                </div>
                <div class="gold has-padding-3 has-margin-y-1">
                  <i class="fas fa-coins colored"></i>
                  {{ student.gold }}
                </div>
                <div class="has-margin-y-2 has-text-centered">
                  <div class>
                    <button
                      type="submit"
                      @click="updateProp(student.id, 'gold', 100)"
                      class="button is-warning has-padding-x-3"
                    >100</button>
                    <button
                      type="submit"
                      @click="updateProp(student.id, 'gold', 50)"
                      class="button is-warning has-padding-x-3"
                    >50</button>
                    <button
                      type="submit"
                      @click="updateProp(student.id, 'gold', 10)"
                      class="button is-warning has-padding-x-3"
                    >10</button>
                    <tippy
                      interactive
                      :animate-fill="false"
                      theme="light"
                      placement="bottom"
                      animation="fade"
                      trigger="click"
                      style="display:inline-block"
                      arrow
                    >
                      <template v-slot:trigger>
                        <button type="submit" class="button is-primary has-padding-x-3">
                          <i class="fas fa-hashtag"></i>
                        </button>
                      </template>

                      <span>
                        <div class="is-flex">
                          <input type="number" v-model="custom" class="input has-margin-right-1" />
                          <button
                            @click="updateProp(student.id, 'gold', custom)"
                            class="button is-primary col-4 pl-1"
                          >{{trans.get('users_groups.apply')}}</button>
                        </div>
                      </span>
                    </tippy>
                    <button
                      type="submit"
                      @click="updateProp(student.id, 'gold', -10)"
                      class="button is-dark is-outlined has-padding-x-2"
                    >-10</button>
                    <button
                      type="submit"
                      @click="updateProp(student.id, 'gold', -50)"
                      class="button is-dark is-outlined has-padding-x-2"
                    >-50</button>
                    <button
                      type="submit"
                      @click="updateProp(student.id, 'gold', -100)"
                      class="button is-dark is-outlined has-padding-x-2"
                    >-100</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd" >
        <div class="box card-shadow-s is-flex has-background-link has-all-centered" style="min-height: 160px">
          <a :href="'/classroom/' + classroom.code + '/students/add'" style="color: white">
            <img src="/img/new_std.svg" class="has-margin-left-1" />
            <strong>Add students</strong>
          </a>
        </div>
      </div>
    </div>
    <b-modal :active.sync="isQrModalActive" :width="640" scroll="keep">
      <div class="card rounded">
        <div class="card-image has-padding-4">
          <figure class="image is-4by3">
            <img :src="image" alt="Image" />
          </figure>
        </div>
        <div class="card-content">
          <div class="media is-flex has-all-centered">
            <div class="media-left">
              <i class="fad fa-chalkboard fa-3x"></i>
            </div>
            <div class="media-content">
              <h3 class="title is-1 has-text-centered">Classroom code</h3>
              <h3 class="subtitle is-1 has-text-centered">{{ classroom.enrollment_code }}</h3>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
    <b-modal
      :active.sync="isRandomStudentActive"
      :width="640"
      scroll="keep"
      class="has-text-centered"
    >
      <show-student :student="currentStudent" :theme="classroom.theme"></show-student>
      <button
        class="button is-link has-margin-2"
        v-if="shuffledStudents && shuffledStudents.length"
        @click="currentStudent = shuffledStudents.shift()"
      >
        <i class="fad fa-random"></i>
      </button>
    </b-modal>
    <b-modal
      :active.sync="isRandomGroupActive"
      :width="640"
      scroll="keep"
      class="has-text-centered has-background-light"
    >
      <div class="columns has-background-light rounded has-padding-2">
        <div class="column is-narrow is-flex has-all-centered">
          <img :src="currentGroup.logo" v-if="isRandomGroupActive && currentGroup.logo" />
        </div>
        <div class="column is-flex has-all-centered">
          <h1
            class="is-size-1 has-padding-4 has-margin-3"
            v-if="isRandomGroupActive"
          >{{ currentGroup.name }}</h1>
        </div>
      </div>

      <button
        class="button is-link has-margin-2"
        v-if="shuffledGroups && shuffledGroups.length"
        @click="currentGroup = shuffledGroups.shift()"
      >
        <i class="fad fa-random"></i>
      </button>
    </b-modal>
    <b-modal :active.sync="dice" has-modal-card full-screen :can-cancel="false">
      <div class="modal-card" style="width: auto">
        <button class="button" type="button" @click="dice=false">Close</button>
        <iframe :src="diceUrl" width="100%" style="height: 100vh"></iframe>
      </div>
    </b-modal>
    <b-modal :active.sync="isCardModalActive" has-modal-card full-screen :can-cancel="false">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Random card</p>
        </header>
        <section class="modal-card-body is-relative" id="confetti-bg">
          <img id="deck" src="/img/deck.png" class="deck" v-if="!showCard" @click="revealCard" />
          <show-card
            :card="randomCard"
            class="deck"
            :admin="false"
            v-if="showCard"
            :code="classroom.code"
          ></show-card>
        </section>
        <footer class="modal-card-foot columns is-multiline" style="overflow-x: auto">
          <div class="column is-narrow">
            <button class="button" type="button" @click="isCardModalActive=false">Close</button>
            <button class="button is-link" @click="getRandomCard();showCard=false">
              <i class="far fa-redo-alt"></i>
            </button>
          </div>
          <div v-if="showCard" class="column is-narrow is-flex has-all-centered">
            <div class="field has-margin-0">
              <p class="control has-icons-left">
                <span class="select">
                  <select v-model="studentSelected">
                    <option value="0">Student</option>
                    <option
                      :value="student.id"
                      v-for="student in students"
                      :key="student.id"
                    >{{ student.name }}</option>
                  </select>
                </span>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </p>
            </div>
            <button class="button is-primary" @click="assignCard('student')">
              <i class="fas fa-user"></i>
            </button>
          </div>
          <div v-if="showCard" class="column is-narrow is-flex has-all-centered">
            <div class="field has-margin-0">
              <p class="control has-icons-left">
                <span class="select">
                  <select v-model="groupSelected">
                    <option value="0">Groups</option>
                    <option
                      v-for="group in classroom.grouping[0].groups"
                      :value="group.id"
                      :key="group.id"
                    >{{ group.name }}</option>
                  </select>
                </span>
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </p>
            </div>
            <button class="button is-primary" @click="assignCard('group')">
              <i class="fas fa-users"></i>
            </button>
          </div>
        </footer>
      </div>
    </b-modal>
    <b-modal :active.sync="isCountDownModalActive" has-modal-card full-screen :can-cancel="false">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Countdown</p>
        </header>
        <section class="modal-card-body is-flex has-all-centered" style="align-items: flex-start;">
          <count-down></count-down>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isCountDownModalActive=false">Close</button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
import Utils from "../../utils.js";
import confetti from "canvas-confetti";

export default {
  props: ["students", "classroom"],
  mounted() {
    let orderedBehaviours = _.orderBy(
      this.classroom.behaviours,
      "count_number",
      "desc"
    );
    this.mainBehavioursJson = orderedBehaviours.slice(0, this.numItems);
    this.otherBehavioursJson = orderedBehaviours.slice(this.numItems);
    this.sortKey = $cookies.get("order") ?? "name";
    this.viewGrid = $cookies.get("viewGrid") ?? 0;
  },
  data: function() {
    return {
      mainBehavioursJson: [],
      otherBehavioursJson: [],
      sortKey: "",
      viewGrid: "",
      buttons: "",
      custom: 0,
      numItems: 5,
      show2l: false,
      isQrModalActive: false,
      isRandomStudentActive: false,
      isRandomGroupActive: false,
      isCardModalActive: false,
      isCountDownModalActive: false,
      dice: false,
      image: null,
      currentStudent: null,
      shuffledStudents: null,
      shuffledGroups: null,
      diceUrl: "",
      randomCard: null,
      showCard: false,
      studentSelected: 0,
      groupSelected: 0,
      event: null
    };
  },
  methods: {
    assignCard(to) {
      let card = this.randomCard.id;
      let target;
      if (to == "student") {
        if (this.studentSelected == 0) {
          this.$buefy.dialog.alert({
            title: "Error",
            message: "Please, select a student",
            type: "is-danger",
            hasIcon: true,
            icon: "times-circle",
            iconPack: "fa",
            ariaRole: "alertdialog",
            ariaModal: true
          });
          return false;
        } else {
          target = this.studentSelected;
        }
      } else {
        if (this.groupSelected == 0) {
          this.$buefy.dialog.alert({
            title: "Error",
            message: "Please select a group",
            type: "is-danger",
            hasIcon: true,
            icon: "times-circle",
            iconPack: "fa",
            ariaRole: "alertdialog",
            ariaModal: true
          });
          return false;
        } else {
          target = this.groupSelected;
        }
      }
      axios
        .post("/classroom/" + this.classroom.code + "/card/assign", {
          type: to,
          id: target,
          card: card
        })
        .then(response => {
          this.showCard = false;
        });
    },
    revealCard() {
      var audio = new Audio("/sound/victory.mp3");
      audio.play();
      setTimeout(() => {
        var end = Date.now() + 15 * 125;

        // go Buckeyes!
        var colors = ["#bb0000", "#00bb00", "#0000bb", "#bbbb00"];

        (function frame() {
          confetti({
            particleCount: 4,
            angle: 60,
            spread: 105,
            origin: { x: 0 },
            colors: colors
          });
          confetti({
            particleCount: 4,
            angle: 120,
            spread: 105,
            origin: { x: 1 },
            colors: colors
          });

          if (Date.now() < end) {
            requestAnimationFrame(frame);
          }
        })();
        this.showCard = true;
      }, 300);
    },
    rollTheDice() {
      var audio = new Audio("/sound/dice.mp3");
      audio.play();
      this.diceUrl = "/dice/dice?notation=1d6&roll";
      this.dice = true;
    },
    randomStudents() {
      this.shuffledStudents = _.shuffle(this.students);
      this.currentStudent = this.shuffledStudents.shift();
      this.isRandomStudentActive = true;
    },
    randomGroups() {
      this.shuffledGroups = _.shuffle(this.classroom.grouping[0].groups);
      this.currentGroup = this.shuffledGroups.shift();
      this.isRandomGroupActive = true;
    },
    getRandomCard() {
      axios
        .get("/classroom/" + this.classroom.code + "/card/random")
        .then(response => {
          this.randomCard = response.data;
          this.isCardModalActive = true;
        });
    },
    showClassCode() {
      let link =
        "https://fantasyclass.app/classroom/join/" +
        this.classroom.enrollmen_code;
      this.image =
        "https://api.qrserver.com/v1/create-qr-code/?data=" +
        link +
        "&amp;size=400x400";
      this.isQrModalActive = true;
    },
    orderBy: function(sorKey) {
      this.$cookies.set("order", sorKey, Infinity);
      this.sortKey = sorKey;
    },
    updateSlice() {
      this.numItems--;
      this.mainBehavioursJson = JSON.parse(this.behaviours).slice(
        0,
        this.numItems
      );
      this.otherBehavioursJson = JSON.parse(this.behaviours).slice(
        this.numItems
      );
    },
    changeView: function() {
      this.viewGrid = (this.viewGrid + 1) % 3;
      this.$cookies.set("viewGrid", this.viewGrid, Infinity);
    },
    updateProp: function(id, prop, value) {
      let options = { id: id, prop: prop, value: value };
      axios.post("/classroom/students/update", options).then(response => {
        if (prop == "xp") {
          let student = this.students.find(el => el.id === id);
          student.xp = response.data.xp;
          student.level = response.data.level;
        } else if (prop == "gold")
          this.students.find(el => el.id === id).gold = response.data;
        this.custom = 0;
        this.$emit("students", this.students);
        this.$forceUpdate();
      });
    },
    addBehaviour: function(id, behaviour) {
      let options = { id: id, behaviour: behaviour };
      axios.post("/classroom/student/behaviour", options).then(response => {
        let student = this.students.find(el => el.id === id);
        student.hp = response.data.hp;
        student.xp = response.data.xp.xp;
        student.gold = response.data.gold;
        student.level = response.data.xp.level;
        this.$forceUpdate();
      });
    },
    redirect(id) {
      window.location.href =
        "/classroom/" + this.classroom.code + "/student/" + id;
    }
  },
  computed: {
    orderedStudents: function() {
      let order = "desc";
      if (this.sortKey == "name") order = "asc";
      return _.orderBy(this.students, this.sortKey, order);
    }
  }
};
</script>
