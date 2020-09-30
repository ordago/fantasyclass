<template>
  <div>
    <div
      class="utilities columns is-multiline is-flex rounded card-shadow-s has-padding-y-2 has-margin-2 has-margin-left-0"
      id="utilities"
    >
      <div class="tools rounded-left">
        <i class="fal fa-tools"></i>
      </div>
      <div class="column has-padding-x-0 is-flex">
        <a
          class="link outer_glow has-text-dark has-padding-x-2"
          v-tippy
          :content="trans.get('menu.groups')"
          :href="'/classroom/' + classroom.code + '/groups'"
        >
          <i class="fad fa-users outer_glow" style="font-size:2em;"></i>
        </a>
          <a 
            class="link outer_glow has-text-dark has-padding-x-2"
            v-tippy 
            :content="trans.get('menu.event') + ' ' + trans.get('utils.random')" 
            :href="'/classroom/' + classroom.code + '/event/random'">
            <i class="fad fa-scroll-old has-margin-right-2" style="font-size:2em;"></i>
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
            <a class="dropdown-item" @click="randomStudents" v-if="students.length">
              <i class="fad fa-user has-margin-right-2"></i>
              {{ trans.get('utils.random') }}: {{ trans.get('menu.students') }}
            </a>
            <a
              class="dropdown-item"
              @click="randomGroups"
              v-if="classroom.grouping[0].groups.length > 0"
            >
              <i class="fad fa-users has-margin-right-2"></i>
              {{ trans.get('utils.random') }}: {{ trans.get('menu.groups') }}
            </a>
            <a
              class="dropdown-item"
              @click="getRandomCard"
              v-if="students.length || classroom.grouping[0].groups.length"
            >
              <i class="fad fa-club has-margin-right-2"></i>
              {{ trans.get('utils.random') }}: {{ trans.get('menu.card') }}
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
        <a
          :href="'/classroom/' + classroom.code + '/utils/meter'"
          target="_blank"
          v-tippy
          :content="trans.get('menu.noise')"
          class="link outer_glow has-padding-x-2 cursor-pointer has-text-dark"
        >
          <i class="fad fa-microphone outer_glow" style="font-size:2em;"></i>
        </a>
        <a
          @click="isMassiveModalActive = true"
          v-tippy
          :content="trans.get('menu.massive')"
          class="link outer_glow has-padding-x-2 cursor-pointer has-text-dark"
        >
          <i class="fad fa-poll-people" style="font-size: 2em;"></i>
        </a>
      </div>
      <!--<span class="link outer_glow"><i class="fad fa-chart-pie" style="font-size:2em;"></i></span>
        <span class="lin
        k outer_glow"><a style="font-size: 2em;" href="utils/attendance.php"><i class="fad fa-calendar-check"></i></a></span>
        <a href="utils/questions.php" class="link outer_glow"><i class="fad fa-question-square" style="font-size:2em;"></i></a>
      -->
      <div class="column has-text-right is-center-vertically" v-if="students.length>0">
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
        <span v-if="groups.length">
        <span><i class="fas fa-user ml-2 outer_glow"></i></span>
          <b-switch v-model="view" true-value="1" @input="toggleView"
                  false-value="0" class="has-margin-right-0"></b-switch>
          <span><i class="fas fa-users outer_glow"></i></span>
        </span>
      </div>
    </div>

    <div class="column has-padding-x-1" v-if="view == 1">
      <show-group-view :behaviours="mainBehavioursJson" :behaviourshidden="otherBehavioursJson" :groups="groups" :classroom="classroom" :students="students"></show-group-view>
    </div>

    <div class="columns is-multiline is-variable is-1 has-margin-y-2" v-else>
      <div
        class="column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
        v-for="student in orderedStudents"
        v-bind:key="student.id"
      >
        <show-student-teacher :behaviours="mainBehavioursJson" :behaviourshidden="otherBehavioursJson" :student="student" :classroom="classroom"></show-student-teacher>
      </div>

      <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd">
        <div
          class="box card-shadow-s is-flex has-background-link has-all-centered"
          style="min-height: 160px"
        >
          <a :href="'/classroom/' + classroom.code + '/students/add'" style="color: white">
            <img src="/img/new_std.svg" class="has-margin-left-1" />
            <strong>{{ trans.get('users_groups.add_students') }}</strong>
          </a>
        </div>
      </div>
    </div>

    <!-- Modals -->
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
      :can-cancel="false"
      class="has-text-centered"
    >

      <show-student-teacher
        :behaviours="mainBehavioursJson" 
        :behaviourshidden="otherBehavioursJson"
        :character-theme="classroom.character_theme"
        :classroom="classroom"
        :student="currentStudent"
        :random="true"
      ></show-student-teacher>
      <button
        class="button is-link has-margin-2"
        v-if="shuffledStudents && shuffledStudents.length"
        @click="uppdateCurrentStudent"
      >
        <i class="fad fa-random has-margin-right-3"></i> {{ trans.get('utils.random') }}
      </button>
      <button class="button has-margin-2" @click="refresh"><i class="fas fa-times has-margin-right-3"></i> {{ trans.get('general.close') }}</button>
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
    <b-modal :active.sync="isMassiveModalActive" has-modal-card full-screen>
      <massive-actions :classroom="classroom"></massive-actions>
    </b-modal>
  </div>
</template>

<script>
import Utils from "../../utils.js";
import confetti from "canvas-confetti";

export default {
  props: ["students", "classroom", "groups"],
  created() {
    this.view = this.$cookies.get("view");
  },
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
  data: function () {
    return {
      view: 1,
      mainBehavioursJson: [],
      otherBehavioursJson: [],
      sortKey: "",
      viewGrid: "",
      buttons: "",
      numItems: 5,
      isQrModalActive: false,
      isRandomStudentActive: false,
      isRandomGroupActive: false,
      isCardModalActive: false,
      isCountDownModalActive: false,
      isMassiveModalActive: false,
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
      event: null,
    };
  },
  methods: {
    toggleView() {
      this.$cookies.set("view", this.$cookies.get("view") == 0 ? 1 : 0);
      this.view = this.$cookies.get("view")
    },
    refresh() {
        location.reload()
    },
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
            ariaModal: true,
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
            ariaModal: true,
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
          card: card,
        })
        .then((response) => {
          this.getRandomCard();
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
            colors: colors,
          });
          confetti({
            particleCount: 4,
            angle: 120,
            spread: 105,
            origin: { x: 1 },
            colors: colors,
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
    uppdateCurrentStudent() {
      this.currentStudent = this.shuffledStudents.shift();
      if (this.currentStudent.hidden == 1) this.uppdateCurrentStudent();
    },
    randomStudents() {
      this.shuffledStudents = _.shuffle(this.students);
      this.uppdateCurrentStudent();
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
        .then((response) => {
          this.randomCard = response.data;
          this.isCardModalActive = true;
        });
    },
    showClassCode() {
      let link =
        "https://fantasyclass.app/classroom/join/" +
        this.classroom.enrollment_code;
      this.image =
        "https://api.qrserver.com/v1/create-qr-code/?data=" +
        link +
        "&amp;size=400x400";
      this.isQrModalActive = true;
    },
    orderBy: function (sorKey) {
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
    changeView: function () {
      this.viewGrid = (this.viewGrid + 1) % 3;
      this.$cookies.set("viewGrid", this.viewGrid, Infinity);
    },
  },
  computed: {
    orderedStudents: function () {
      let order = "desc";
      if (this.sortKey == "name") order = "asc";
      return _.orderBy(
        _.orderBy(this.students, this.sortKey, order),
        "hidden",
        "asc"
      );
    },
  },
};
</script>
