<template>
  <div class="p-2">
    <div
      class="
        utilities
        columns
        is-multiline is-flex
        rounded
        card-shadow-s
        m-0
        mt-1
      "
    >
      <div class="tools rounded-left">
        <i class="fal fa-tools"></i>
      </div>
      <div
        class="column px-0 is-12-mobile is-flex is-center-vertically"
        style="flex-flow: wrap"
      >
        <span v-if="allStudents.length" class="is-flex has-all-centered">
          <a
            class="has-text-light p-2 has-background-link rounded"
            v-tippy
            :content="trans.get('users_groups.add_students')"
            :href="'/classroom/' + classroom.code + '/students/add'"
          >
            <i class="fad fa-user" style="font-size: 1.75em"></i>
            <i
              class="fas fa-plus"
              style="font-size: 1em; position: relative; top: 4px; left: -3px"
            ></i>
            <!-- <span class="pl-1">{{
              trans.get("users_groups.add_students")
            }}</span> -->
          </a>
        </span>
        <a
          class="link outer_glow has-text-dark pr-2"
          v-tippy
          :content="trans.get('menu.groups')"
          :href="'/classroom/' + classroom.code + '/groups'"
        >
          <i class="fad fa-users outer_glow" style="font-size: 2em"></i>
        </a>
        <div
          v-if="allStudents && allStudents.length"
          class="dropdown is-hoverable mr-1"
          style="display: inline-block"
        >
          <span
            class="has-text-danger dropdown-trigger link outer_glow m-0 p-0"
          >
            <i class="fa-duotone fa-alien-8bit glow" style="font-size: 2em"></i>
            <span class="icon is-small">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </span>

          <div class="dropdown-menu has-background-white rounded p-3">
            <a
              class="dropdown-item"
              v-if="students.length >= 2"
              :href="'/classroom/' + classroom.code + '/battles'"
            >
              <i class="fad fa-swords outer_glow" style="font-size: 2em"></i>
              {{ trans.get("menu.battles") }}
            </a>
            <a @click="isImpostorActive = true" class="dropdown-item">
              <i class="fad fa-user-secret" style="font-size: 2em"></i> Impostor
            </a>
            <a :href="'/classroom/' + classroom.code + '/games/wordle'" class="dropdown-item">
              <i class="fa-duotone fa-w" style="font-size: 2em"></i> WordleFC
            </a>
          </div>
        </div>

        <a
          class="link outer_glow has-text-dark pl-0 ml-0 pr-2"
          v-tippy
          :content="trans.get('menu.attendance')"
          v-if="students.length"
          :href="'/classroom/' + classroom.code + '/attendance'"
        >
          <i class="fad fa-calendar-alt outer_glow" style="font-size: 2em"></i>
        </a>
        <div class="dropdown is-hoverable" style="display: inline-block">
          <span class="dropdown-trigger link outer_glow m-0 p-0">
            <i class="fad fa-random outer_glow" style="font-size: 2em"></i>
            <span class="icon is-small">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </span>

          <div class="dropdown-menu has-background-white rounded p-3">
            <a
              class="dropdown-item"
              :href="'/classroom/' + classroom.code + '/event/random'"
              v-if="students.length"
            >
              <i class="fad fa-scroll-old mr-2"></i>
              {{ trans.get("utils.random") }}: {{ trans.get("menu.events") }}
            </a>
            <a
              class="dropdown-item"
              @click="randomStudents"
              v-if="students.length"
            >
              <i class="fad fa-user mr-2"></i>
              {{ trans.get("utils.random") }}: {{ trans.get("menu.students") }}
            </a>
            <a
              class="dropdown-item"
              @click="randomGroups"
              v-if="classroom.grouping[0].groups.length > 0"
            >
              <i class="fad fa-users mr-2"></i>
              {{ trans.get("utils.random") }}: {{ trans.get("menu.groups") }}
            </a>
            <a
              class="dropdown-item"
              @click="getRandomCard"
              v-if="allStudents.length || classroom.grouping[0].groups.length"
            >
              <i class="fak fa-deck mr-2"></i>
              {{ trans.get("utils.random") }}: {{ trans.get("menu.card") }}
            </a>
            <a class="dropdown-item" @click="isWheelModalActive = true">
              <i class="fad fa-treasure-chest mr-2"></i>
              {{ trans.get("utils.fortune") }}
            </a>
          </div>
        </div>
        <div class="dropdown is-hoverable" style="display: inline-block">
          <span class="dropdown-trigger link outer_glow m-0 p-0">
            <i class="fad fa-tools outer_glow" style="font-size: 2em"></i>
            <span class="icon is-small">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </span>

          <div class="dropdown-menu has-background-white rounded p-3">
            <a class="dropdown-item" @click="rollTheDice">
              <i class="fad fa-dice mr-2"></i>
              {{ trans.get("menu.dice") }}
            </a>
            <a class="dropdown-item" href="/utils/music" target="_blank">
              <i class="fad fa-music mr-2"></i>
              {{ trans.get("menu.music") }}
            </a>
            <a class="dropdown-item" @click="isCountDownModalActive = true">
              <i class="fad fa-stopwatch mr-2"></i>
              {{ trans.get("menu.countdown") }}
            </a>
            <a
              class="dropdown-item"
              :href="'/classroom/' + classroom.code + '/utils/meter'"
            >
              <i class="fad fa-microphone mr-2"></i>
              {{ trans.get("menu.noise") }}
            </a>
          </div>
        </div>
        <div class="dropdown is-hoverable" style="display: inline-block">
          <span class="dropdown-trigger link outer_glow m-0 p-0">
            <i
              class="fad fa-file-download outer_glow"
              style="font-size: 2em"
            ></i>
            <span class="icon is-small">
              <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
          </span>

          <div class="dropdown-menu has-background-white rounded p-3">
            <a
              class="dropdown-item"
              :href="'/classroom/' + classroom.code + '/students/report'"
              target="_blank"
              v-if="allStudents.length"
            >
              <i class="fas fa-file mr-2"></i>
              {{ trans.get("utils.students_report") }}
            </a>
            <a
              class="dropdown-item"
              :href="
                '/classroom/' +
                classroom.code +
                '/utils/exportConfidentialDataStudent'
              "
              target="_blank"
              v-if="allStudents.length"
            >
              <i class="fas fa-file-excel mr-2"></i>
              {{ trans.get("utils.download_confidential_data_students") }}
            </a>
            <a
              class="dropdown-item"
              :href="'/classroom/' + this.classroom.code + '/evaluation/report'"
            >
              <i class="mr-2 fas fa-file-chart-line"></i>
              {{ trans.get("evaluation.report") }}
            </a>
          </div>
        </div>
        <a
          class="link outer_glow has-text-dark px-1"
          v-tippy
          :content="trans.get('menu.classcode')"
          @click="showClassCode"
        >
          <i class="fad fa-qrcode outer_glow" style="font-size: 2em"></i>
        </a>
        <a
          @click="isMassiveModalActive = true"
          v-tippy
          :content="trans.get('menu.massive')"
          class="link outer_glow px-1 cursor-pointer has-text-dark"
        >
          <i class="fad fa-poll-people" style="font-size: 2em"></i>
        </a>
        <a
          v-tippy
          v-if="allStudents && allStudents.length"
          :content="trans.get('menu.send_message_all')"
          @click="sendMessage(1)"
          class="link outer_glow px-1 cursor-pointer has-text-dark"
        >
          <i class="fad fa-comment-alt-lines" style="font-size: 2em"></i>
        </a>
        <tippy
          interactive
          :animate-fill="false"
          theme="light"
          placement="bottom"
          animation="fade"
          trigger="click"
          style="display: inline-block"
          arrow
        >
          <template v-slot:trigger>
            <a
              v-tippy
              :content="trans.get('utils.announcement')"
              class="link outer_glow px-1 cursor-pointer has-text-dark"
            >
              <i class="fad fa-bullhorn" style="font-size: 2em"></i>
            </a>
          </template>
          <span>
            <div>{{ trans.get("utils.announcement_info") }}</div>
            <div class="is-flex is-center-vertically">
              <input type="text" v-model="announcement" class="input mr-1" />
              <button
                @click="updateProp()"
                class="button is-primary is-inline ml-1"
              >
                {{ trans.get("users_groups.apply") }}
              </button>
              <button
                @click="updateProp('forget')"
                class="button is-danger is-inline ml-1"
              >
                {{ trans.get("general.delete") }}
              </button>
            </div>
          </span>
        </tippy>
        <a
          v-tippy
          :content="trans.get('menu.videochat')"
          @click="isVideoChatActive = true"
          class="link outer_glow px-1 cursor-pointer"
        >
          <i class="fad fa-video" style="font-size: 2em"></i>
        </a>
      </div>
      <div
        class="column is-narrow has-text-right is-center-vertically is-flex"
        v-if="allStudents.length > 0"
      >
        <span class="p-2 py-3 mr-2 has-background-white border rounded">
          <span>
            <i class="fal fa-sort-numeric-down-alt mr-3"></i>
          </span>
          <span
            v-tippy
            :content="trans.get('users_groups.order_name')"
            v-bind:class="{ coloredGray: sortKey != 'name' }"
            @click="orderBy('name')"
            style="color: #eee"
            data-id="0"
            class="colored cursor-pointer"
          >
            <i class="fas fa-user pointer mr-3"></i>
          </span>
          <span
            v-tippy
            :content="trans.get('users_groups.order_hp')"
            v-bind:class="{ coloredGray: sortKey != 'hp' }"
            @click="orderBy('hp')"
            class="colored cursor-pointer"
          >
            <i class="fas fa-heart pointer mr-3"></i>
          </span>
          <span
            v-tippy
            :content="trans.get('users_groups.order_xp')"
            v-bind:class="{ coloredGray: sortKey != 'xp' }"
            @click="orderBy('xp')"
            class="colored cursor-pointer"
          >
            <i class="fas fa-fist-raised pointer mr-3"></i>
          </span>
          <span
            v-tippy
            :content="trans.get('users_groups.order_gold')"
            v-bind:class="{ coloredGray: sortKey != 'gold' }"
            @click="orderBy('gold')"
            class="colored cursor-pointer"
          >
            <i class="fas fa-coins pointer mr-3"></i>
          </span>
        </span>
        <span class="p-2 py-3 has-background-white border rounded">
          <span v-if="view == 0 || view == 1">
            <span
              class="cursor-pointer colored"
              @click="assignView(2)"
              v-tippy
              :content="trans.get('menu.view_list')"
            >
              <i class="fas fa-th-list" style="color: white"></i>
            </span>
            <span
              class="cursor-pointer colored"
              @click="assignView(0)"
              v-tippy
              :content="trans.get('menu.view_student')"
              v-if="groups.length && view == 1"
            >
              <i class="fas fa-user has-text-light"></i>
            </span>
            <span
              class="cursor-pointer colored"
              @click="assignView(1)"
              v-tippy
              :content="trans.get('menu.view_group')"
              v-if="groups.length && view == 0"
            >
              <i class="fas fa-users has-text-light"></i>
            </span>
          </span>
          <span
            class="cursor-pointer colored"
            @click="assignView(0)"
            v-tippy
            :content="trans.get('menu.view_full')"
            v-else
          >
            <i class="fas fa-th-large" style="color: white"></i>
          </span>
        </span>
      </div>
    </div>

    <div
      class="panel-block mt-1 mb-0 px-1"
      v-if="allStudents.length && view != 1"
    >
      <b-autocomplete
        v-model="search"
        :placeholder="trans.get('students.search')"
        :open-on-focus="true"
        :data="filteredDataObj"
        field="name"
        icon-pack="fas"
        icon="search"
        :loading="loading"
        :clearable="false"
        @input="searchStudents"
      >
      </b-autocomplete>
    </div>

    <div class="column px-1" v-if="view == 2">
      <article
        class="media"
        v-for="student in orderedStudents"
        :key="student.id"
      >
        <figure class="media-left">
          <p class="image is-64x64">
            <img class="rounded" :src="student.avatar" />
          </p>
        </figure>
        <div class="media-content">
          <div class="content cursor-pointer" @click="redirect(student.id)">
            <div class="">
              <div class="">
                <strong>{{ student.name }}</strong>
                <small>@{{ student.username }}</small>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <hp :hp="student.hp" :size="2"></hp>
              </div>
              <div class="column">
                <div class="">
                  <div class="score p-2 m-1">
                    <span>
                      <i
                        class="fas fa-fist-raised colored"
                        aria-hidden="true"
                      ></i>
                    </span>
                    {{ student.xp }}
                  </div>
                </div>
              </div>
              <div class="column">
                <div class="">
                  <div class="gold p-2 m-1">
                    <span>
                      <i class="fas fa-coins colored" aria-hidden="true"></i>
                    </span>
                    {{ student.gold }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <nav class="level is-mobile">
                      <div class="level-left">
                        <a class="level-item">
                          <span class="icon is-small"><i class="fas fa-reply"></i></span>
                        </a>
                        <a class="level-item">
                          <span class="icon is-small"
                            ><i class="fas fa-retweet"></i
                          ></span>
                        </a>
                        <a class="level-item">
                          <span class="icon is-small"><i class="fas fa-heart"></i></span>
                        </a>
                      </div>
                    </nav>-->
        </div>
        <div class="media-right"></div>
      </article>
      <infinite-loading
        ref="infiniteComponent"
        :distance="100"
        spinner="waveDots"
        force-use-infinite-wrapper=".infinite"
        :on-infinite="infiniteHandler"
      >
        <div slot="no-more"></div>
        <div slot="no-results"></div>
      </infinite-loading>
    </div>

    <div class="column px-1" v-if="view == 1">
      <show-group-view
        :behaviours="mainBehavioursJson"
        :behaviourshidden="otherBehavioursJson"
        :groups="groups"
        v-if="allStudents && allStudents.length < max"
        :classroom="classroom"
        :students="students"
      ></show-group-view>
      <div v-else>Too many students to show group view</div>
    </div>

    <div class="columns is-multiline is-variable is-1 my-2" v-if="view == 0">
      <div
        class="column py-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
        v-for="student in orderedStudents"
        v-bind:key="student.id"
        ref="wrapper"
      >
        <show-student-teacher
          :show-skills="settings.skill_enabled == 1 ? true : false"
          :behaviours="mainBehavioursJson"
          :behaviourshidden="otherBehavioursJson"
          :student="student"
          :classroom="classroom"
        ></show-student-teacher>
      </div>
      <infinite-loading
        ref="infiniteComponent"
        :distance="100"
        spinner="waveDots"
        force-use-infinite-wrapper=".infinite"
        :on-infinite="infiniteHandler"
      >
        <div slot="no-more"></div>
        <div slot="no-results">
          <div
            class="
              column
              py-2
              is-6-tablet is-12-mobile is-4-desktop is-3-fullhd
            "
          >
            <div
              class="
                box
                card-shadow-s
                is-flex
                has-background-link has-all-centered
                h-100
              "
            >
              <a
                :href="'/classroom/' + classroom.code + '/students/add'"
                style="color: white"
              >
                <img src="/img/new_std.svg" class="ml-1" />
                <strong>{{ trans.get("users_groups.add_students") }}</strong>
              </a>
            </div>
          </div>
        </div>
      </infinite-loading>
    </div>

    <!-- Modals -->
    <b-modal :active.sync="isQrModalActive" :width="640" scroll="keep">
      <div class="card rounded">
        <div class="card-image p-4">
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
              <h3 class="subtitle is-1 has-text-centered">
                {{ classroom.enrollment_code }}
              </h3>
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
      class="has-text-centered overflow-show"
    >
      <show-student-teacher
        :show-skills="settings.skill_enabled == 1 ? true : false"
        :behaviours="mainBehavioursJson"
        :behaviourshidden="otherBehavioursJson"
        :character-theme="classroom.character_theme"
        :classroom="classroom"
        :student="currentStudent"
        :random="true"
      ></show-student-teacher>
      <button
        class="button is-link m-2"
        v-if="shuffledStudents && shuffledStudents.length"
        @click="uppdateCurrentStudent"
        :class="{ 'is-loading': isLoading }"
      >
        <i class="fad fa-random mr-3"></i>
        {{ trans.get("utils.random") }}
      </button>
      <button class="button m-2" @click="refresh">
        <i class="fas fa-times mr-3"></i>
        {{ trans.get("general.close") }}
      </button>
    </b-modal>
    <b-modal
      :active.sync="isRandomGroupActive"
      :width="640"
      scroll="keep"
      class="has-text-centered has-background-light"
    >
      <div class="columns has-background-light rounded p-2">
        <div class="column is-narrow is-flex has-all-centered">
          <img
            :src="currentGroup.logo"
            v-if="isRandomGroupActive && currentGroup.logo"
          />
        </div>
        <div class="column is-flex has-all-centered">
          <h1 class="is-size-1 p-4 m-3" v-if="isRandomGroupActive">
            {{ currentGroup.name }}
          </h1>
        </div>
      </div>

      <button
        class="button is-link m-2"
        v-if="shuffledGroups && shuffledGroups.length"
        @click="currentGroup = shuffledGroups.shift()"
      >
        <i class="fad fa-random"></i>
      </button>
    </b-modal>
    <b-modal :active.sync="dice" has-modal-card full-screen :can-cancel="false">
      <div class="modal-card" style="width: auto">
        <button class="button" type="button" @click="dice = false">
          {{ trans.get("general.close") }}
        </button>
        <iframe :src="diceUrl" width="100%" style="height: 100vh"></iframe>
      </div>
    </b-modal>

    <b-modal
      :active.sync="isCountDownModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Countdown</p>
          <p class="modal-card-title is-flex is-center-vertically">
            {{ trans.get("menu.battles") }}
            <audio :src="'/music/' + track" loop controls></audio>
            <select class="select" v-model="track">
              <option v-for="(trackS, index) in music" :key="index">
                {{ trackS }}
              </option>
            </select>
          </p>
        </header>
        <section
          class="modal-card-body is-flex has-all-centered"
          style="align-items: flex-start"
        >
          <count-down :width="500"></count-down>
        </section>
        <footer class="modal-card-foot">
          <button
            class="button"
            type="button"
            @click="isCountDownModalActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <b-modal
      :active.sync="isWheelModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("utils.fortune") }}</p>
        </header>
        <section class="modal-card-body is-flex has-all-centered">
          <wheel :code="classroom.code" :students="allStudents"></wheel>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="refresh">
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <b-modal :active.sync="isMassiveModalActive" has-modal-card full-screen>
      <massive-actions
        :students="allStudents"
        :classroom="classroom"
        :groups="groups"
      ></massive-actions>
    </b-modal>
    <Impostor
      v-if="isImpostorActive"
      :current="impostor"
      :code="classroom.code"
      :students="allStudents"
    >
    </Impostor>
    <Videochat v-if="isVideoChatActive" :groups="groups" :code="classroom.code">
    </Videochat>
    <random-card
      ref="showCard"
      :card="randomCard"
      :admin="1"
      :code="classroom.code"
    ></random-card>
  </div>
</template>

<script>
import Impostor from "../utils/Impostor.vue";
import Videochat from "../utils/Videochat.vue";
import RandomCard from "../utils/RandomCard.vue";
import InfiniteLoading from "vue-infinite-loading";

export default {
  props: ["classroom", "groups", "impostor", "settings"],
  created() {
    // let view = this.$cookies.get("view");
    // if (view) {
    //   if (view == 1 && !this.groups.length) this.view = 0;
    //   else this.view = this.$cookies.get("view");
    // }
  },
  mounted() {
    this.announcement = this.settings.announcement;

    axios
      .get("/classroom/" + this.classroom.code + "/students/all")
      .then((response) => {
        this.allStudents = response.data;
      });
    this.mainBehavioursJson = this.orderedBehaviours.slice(0, this.numItems);
    this.otherBehavioursJson = this.orderedBehaviours.slice(this.numItems);
    this.sortKey = $cookies.get("order") ?? "name";
  },

  data: function () {
    return {
      students: [],
      allStudents: [],
      view: "0",
      search: "",
      mainBehavioursJson: [],
      otherBehavioursJson: [],
      sortKey: "",
      viewGrid: "",
      buttons: "",
      numItems: 5,
      randomCard: null,
      isImpostorActive: false,
      isVideoChatActive: false,
      isQrModalActive: false,
      isRandomStudentActive: false,
      isLoading: false,
      isRandomGroupActive: false,
      isCardModalActive: false,
      isCountDownModalActive: false,
      isMassiveModalActive: false,
      isWheelModalActive: false,
      dice: false,
      image: null,
      currentStudent: null,
      shuffledStudents: null,
      shuffledGroups: null,
      diceUrl: "",
      event: null,
      page: 0,
      loading: false,
      firstLoad: true,
      announcement: "",
      max: process.env.MIX_MAX_STUDENTS,
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
    updateProp(action = "send") {
      if (action == "send")
        axios
          .patch("/classroom/" + this.classroom.code + "/setting", {
            _method: "patch",
            prop: "announcement",
            value: this.announcement,
            action: "update",
          })
          .then((response) => {
            this.$toast(this.trans.get("success_error.update_success"), {
              type: "success",
            });
          });
      else {
        axios
          .post("/classroom/" + this.classroom.code + "/setting/forget", {
            prop: "announcement",
          })
          .then((response) => {
            this.announcement = "";
            this.$toast(this.trans.get("success_error.update_success"), {
              type: "success",
            });
          });
      }
    },
    infiniteHandler($state) {
      axios
        .post("/classroom/" + this.classroom.code + "/students/get", {
          page: this.page,
          order: this.sortKey,
        })
        .then((response) => {
          let students = response.data.students;
          if (students.length) {
            this.students.push(...students);
            $state.loaded();
          }
          if (!students.length || students.length < this.max) {
            $state.complete();
          }
          this.page++;
        });
    },
    sendMessage(type, id = null) {
      this.$buefy.dialog.prompt({
        message: this.trans.get("students.send_message"),
        inputAttrs: {},
        cancelText: this.trans.get("general.cancel"),
        confirmText: this.trans.get("general.send"),
        trapFocus: true,
        onConfirm: (message) => {
          let action = "/classroom/" + this.classroom.code + "/push";
          if (type === 1) {
            action += "/all";
          }
          axios
            .post(action, {
              message: message,
              id: id,
            })
            .then((response) => {
              this.$toast(this.trans.get("success_error.add_success"), {
                type: "success",
              });
            });
        },
      });
    },
    redirect(id) {
      window.location.href =
        "/classroom/" + this.classroom.code + "/student/" + id;
    },
    assignView(view) {
      this.$cookies.set("view", view, Infinity);
      this.view = view;
    },
    refresh() {
      location.reload();
    },
    rollTheDice() {
      var audio = new Audio("/sound/dice.mp3");
      audio.play();
      this.diceUrl = "/dice/dice?notation=1d6&roll";
      this.dice = true;
    },
    uppdateCurrentStudent() {
      this.isLoading = true;
      let idRandom = this.shuffledStudents.shift().id;
      axios.get("/classroom/student/" + idRandom + "/get/").then((response) => {
        this.currentStudent = response.data;
        if (this.currentStudent.hidden == 1) this.uppdateCurrentStudent();
        this.isRandomStudentActive = true;
        this.isLoading = false;
      });
    },
    randomStudents() {
      this.shuffledStudents = _.shuffle(this.allStudents);
      this.uppdateCurrentStudent();
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
          this.$refs.showCard.count++;
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
      this.students = [];
      this.page = 0;
      this.sortKey = sorKey;
      this.$nextTick(() => {
        this.$refs.infiniteComponent.stateChanger.reset();
      });
      this.$cookies.set("order", sorKey, Infinity);
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
    searchStudents() {
      if (this.allStudents.length > this.max) {
        this.loading = true;
        axios
          .post("/classroom/" + this.classroom.code + "/students/get", {
            page: 0,
            order: this.sortKey,
            search: this.search.toLowerCase(),
          })
          .then((response) => {
            this.students = response.data.students;
            this.loading = false;
          });
      }
    },
    changeView: function () {
      this.viewGrid = (this.viewGrid + 1) % 3;
      this.$cookies.set("viewGrid", this.viewGrid, Infinity);
    },
  },
  components: {
    Impostor,
    Videochat,
    InfiniteLoading,
    RandomCard,
  },
  computed: {
    filteredDataObj() {
      if (this.allStudents.length <= this.max) {
        return this.allStudents.filter((option) => {
          return (
            option.name
              .toString()
              .toLowerCase()
              .indexOf(this.search.toLowerCase()) >= 0
          );
        });
      }
    },
    orderedBehaviours: function () {
      return _.orderBy(this.classroom.behaviours, "count_number", "desc");
    },
    orderedStudents: function () {
      return this.students.filter((student) => {
        return student.name.toLowerCase().includes(this.search.toLowerCase());
      });
    },
  },
};
</script>
<style>
.infinite-loading-container {
  width: 100%;
}
</style>