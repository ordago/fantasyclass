<template>
    <div>
        <div class="utilities columns is-multiline is-flex rounded card-shadow-s m-0 mt-1">
            <div class="tools rounded-left">
                <i class="fal fa-tools"></i>
            </div>
            <div class="column px-0 is-12-mobile is-flex is-center-vertically"
                 style="flex-flow: wrap">
                <a class="link outer_glow has-text-dark px-1"
                   v-tippy
                   :content="trans.get('menu.groups')"
                   :href="'/classroom/' + classroom.code + '/groups'">
                    <i class="fad fa-users outer_glow" style="font-size: 2em"></i>
                </a>
                <a class="link outer_glow has-text-dark px-1"
                   v-tippy
                   :content="trans.get('menu.event') + ' ' + trans.get('utils.random')"
                   :href="'/classroom/' + classroom.code + '/event/random'">
                    <i class="fad fa-scroll-old mr-2"
                       style="font-size: 2em"></i>
                </a>

                <div class="dropdown is-hoverable"
                     style="display: inline-block;">
                    <span class="dropdown-trigger link outer_glow my-0 py-0 px-1">
                        <i class="fad fa-random outer_glow" style="font-size: 2em"></i>
                        <span class="icon is-small">
                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                        </span>
                    </span>

                    <div class="dropdown-menu has-background-white rounded p-3">
                        <a class="dropdown-item"
                           @click="randomStudents"
                           v-if="students.length">
                            <i class="fad fa-user mr-2"></i>
                            {{ trans.get("utils.random") }}: {{ trans.get("menu.students") }}
                        </a>
                        <a class="dropdown-item"
                           @click="randomGroups"
                           v-if="classroom.grouping[0].groups.length > 0">
                            <i class="fad fa-users mr-2"></i>
                            {{ trans.get("utils.random") }}: {{ trans.get("menu.groups") }}
                        </a>
                        <a class="dropdown-item"
                           @click="getRandomCard"
                           v-if="students.length || classroom.grouping[0].groups.length">
                            <i class="fad fa-club mr-2"></i>
                            {{ trans.get("utils.random") }}: {{ trans.get("menu.card") }}
                        </a>
                        <a class="dropdown-item" @click="isWheelModalActive = true">
                            <i class="fad fa-treasure-chest mr-2"></i>
                            {{ trans.get("utils.fortune") }}
                        </a>
                    </div>
                </div>
                <a class="link outer_glow has-text-dark px-1"
                   v-tippy
                   :content="trans.get('menu.classcode')"
                   @click="showClassCode">
                    <i class="fad fa-qrcode outer_glow" style="font-size: 2em"></i>
                </a>
                <span class="link outer_glow cursor-pointer"
                      @click="rollTheDice"
                      v-tippy
                      :content="trans.get('menu.dice')">
                    <i class="fad fa-dice" style="font-size: 2em"></i>
                </span>
                <a href="/utils/music"
                   target="_blank"
                   v-tippy
                   :content="trans.get('menu.music')"
                   class="link outer_glow px-1 cursor-pointer has-text-dark">
                    <i class="fad fa-music outer_glow" style="font-size: 2em"></i>
                </a>
                <span class="link outer_glow px-1 cursor-pointer"
                      v-tippy
                      :content="trans.get('menu.countdown')"
                      @click="isCountDownModalActive = true">
                    <i class="fad fa-stopwatch outer_glow" style="font-size: 2em"></i>
                </span>
                <a :href="'/classroom/' + classroom.code + '/utils/meter'"
                   target="_blank"
                   v-tippy
                   :content="trans.get('menu.noise')"
                   class="link outer_glow px-1 cursor-pointer has-text-dark">
                    <i class="fad fa-microphone outer_glow" style="font-size: 2em"></i>
                </a>
                <a @click="isMassiveModalActive = true"
                   v-tippy
                   :content="trans.get('menu.massive')"
                   class="link outer_glow px-1 cursor-pointer has-text-dark">
                    <i class="fad fa-poll-people" style="font-size: 2em"></i>
                </a>
                <a v-tippy
                   v-if="students && students.length"
                   :content="trans.get('menu.send_message_all')"
                   @click="sendMessage(1)"
                   class="link outer_glow px-1 cursor-pointer has-text-dark">
                    <i class="fad fa-paper-plane" style="font-size: 2em"></i>
                </a>
                <div class="dropdown is-hoverable"
                     style="display: inline-block;">
                    <span class="dropdown-trigger link outer_glow my-0 py-0 px-1">
                        <i class="fas fa-tools outer_glow" style="font-size: 2em"></i>
                        <span class="icon is-small">
                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                        </span>
                    </span>

                    <div class="dropdown-menu has-background-white rounded p-3">
                        <a class="dropdown-item"
                           href="/utils/exportConfidentialDataStudent/"
                           v-if="students.length || classroom.grouping[0].groups.length">
                            <i class="fas fa-file-excel mr-2"></i>
                            {{ trans.get("utils.download_confidential_data_students") }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="column is-narrow has-text-right is-center-vertically is-flex"
                 v-if="students.length > 0">
                <span class="p-2 py-3 mr-2 has-background-white border rounded">
                    <span>
                        <i class="fal fa-sort-numeric-down-alt mr-3"></i>
                    </span>
                    <span v-tippy
                          :content="trans.get('users_groups.order_name')"
                          v-bind:class="{ coloredGray: sortKey != 'name' }"
                          @click="orderBy('name')"
                          style="color: #eee"
                          data-id="0"
                          class="colored cursor-pointer">
                        <i class="fas fa-user pointer mr-3"></i>
                    </span>
                    <span v-tippy
                          :content="trans.get('users_groups.order_hp')"
                          v-bind:class="{ coloredGray: sortKey != 'hp' }"
                          @click="orderBy('hp')"
                          class="colored cursor-pointer">
                        <i class="fas fa-heart pointer mr-3"></i>
                    </span>
                    <span v-tippy
                          :content="trans.get('users_groups.order_xp')"
                          v-bind:class="{ coloredGray: sortKey != 'xp' }"
                          @click="orderBy('xp')"
                          class="colored cursor-pointer">
                        <i class="fas fa-fist-raised pointer mr-3"></i>
                    </span>
                    <span v-tippy
                          :content="trans.get('users_groups.order_gold')"
                          v-bind:class="{ coloredGray: sortKey != 'gold' }"
                          @click="orderBy('gold')"
                          class="colored cursor-pointer">
                        <i class="fas fa-coins pointer mr-3"></i>
                    </span>
                </span>
                <span class="p-2 py-3 has-background-white border rounded">
                    <span v-if="view == 0 || view == 1">
                        <span class="cursor-pointer colored"
                              @click="assignView(2)"
                              v-tippy
                              :content="trans.get('menu.view_list')">
                            <i class="fas fa-th-list" style="color: white"></i>
                        </span>
                        <span class="cursor-pointer colored"
                              @click="assignView(0)"
                              v-tippy
                              :content="trans.get('menu.view_student')"
                              v-if="groups.length && view == 1">
                            <i class="fas fa-user has-text-light"></i>
                        </span>
                        <span class="cursor-pointer colored"
                              @click="assignView(1)"
                              v-tippy
                              :content="trans.get('menu.view_group')"
                              v-if="groups.length && view == 0">
                            <i class="fas fa-users has-text-light"></i>
                        </span>
                    </span>
                    <span class="cursor-pointer colored"
                          @click="assignView(0)"
                          v-tippy
                          :content="trans.get('menu.view_full')"
                          v-else>
                        <i class="fas fa-th-large" style="color: white"></i>
                    </span>
                </span>
            </div>
        </div>

        <div class="panel-block mt-1 mb-0 px-1" v-if="students.length && view != 1">
            <p class="control has-icons-left">
                <input class="input"
                       type="text"
                       v-model="search"
                       :placeholder="trans.get('students.search')" />
                <span class="icon is-left">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </span>
            </p>
        </div>

        <div class="column px-1" v-if="view == 2">
            <article class="media"
                     v-for="student in orderedStudents"
                     :key="student.id">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img :src="student.avatar" />
                    </p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <div class=" cursor-pointer" @click="redirect(student.id)">
                            <div class="">
                                <strong>{{ student.name }}</strong>
                                <small>@{{ student.username }}</small>
                            </div>
                        </div>
                        <div class="buttons">
                            <div class="">
                                <div class="score p-1 centered-attribute m-1 mt-0 has-all-centered"
                                     style="border: none; width: 150px">
                                    <span class="attribute has-background-white py-2 rounded"
                                          style="width: 100%; margin-top: 3px">
                                        <span>
                                            <i class="fas fa-heart colored has-text-grey-light"
                                               v-bind:class="{ invisible: student.hp >= 30 }"></i>
                                        </span>
                                        <span class="has-text-grey-light"
                                              v-show="student.hp < 30">{{ student.hp }}</span>
                                    </span>
                                    <span class="attribute has-background-danger py-2 rounded-left"
                                          v-bind:class="{ rounded: student.hp == 100 }"
                                          :style="'width: ' + student.hp + '%;margin-top: 3px;'"
                                          v-if="student.hp > 0">
                                        <i class="fas fa-heart colored"
                                           v-bind:class="{ invisible: student.hp < 30 }"></i>
                                        <span v-if="student.hp >= 30">{{ student.hp }}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="">
                                <div class="score p-2 m-1">
                                    <span>
                                        <i class="fas fa-fist-raised colored"
                                           aria-hidden="true"></i>
                                    </span>
                                    {{ student.xp }}
                                </div>
                            </div>
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
                    </nav> -->
                </div>
                <div class="media-right"></div>
            </article>
        </div>

        <div class="column px-1" v-else-if="view == 1">
            <show-group-view :behaviours="mainBehavioursJson"
                             :behaviourshidden="otherBehavioursJson"
                             :groups="groups"
                             :classroom="classroom"
                             :students="students"></show-group-view>
        </div>

        <div class="columns is-multiline is-variable is-1 my-2" v-else>
            <div class="column py-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
                 v-for="student in orderedStudents"
                 v-bind:key="student.id">
                <show-student-teacher :behaviours="mainBehavioursJson"
                                      :behaviourshidden="otherBehavioursJson"
                                      :student="student"
                                      :classroom="classroom"></show-student-teacher>
            </div>

            <div class="column py-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd">
                <div class="box card-shadow-s is-flex has-background-link has-all-centered h-100">
                    <a :href="'/classroom/' + classroom.code + '/students/add'"
                       style="color: white">
                        <img src="/img/new_std.svg" class="ml-1" />
                        <strong>{{ trans.get("users_groups.add_students") }}</strong>
                    </a>
                </div>
            </div>
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
        <b-modal :active.sync="isRandomStudentActive"
                 :width="640"
                 scroll="keep"
                 :can-cancel="false"
                 class="has-text-centered overflow-show">
            <show-student-teacher :behaviours="mainBehavioursJson"
                                  :behaviourshidden="otherBehavioursJson"
                                  :character-theme="classroom.character_theme"
                                  :classroom="classroom"
                                  :student="currentStudent"
                                  :random="true"></show-student-teacher>
            <button class="button is-link m-2"
                    v-if="shuffledStudents && shuffledStudents.length"
                    @click="uppdateCurrentStudent">
                <i class="fad fa-random mr-3"></i>
                {{ trans.get("utils.random") }}
            </button>
            <button class="button m-2" @click="refresh">
                <i class="fas fa-times mr-3"></i>
                {{ trans.get("general.close") }}
            </button>
        </b-modal>
        <b-modal :active.sync="isRandomGroupActive"
                 :width="640"
                 scroll="keep"
                 class="has-text-centered has-background-light">
            <div class="columns has-background-light rounded p-2">
                <div class="column is-narrow is-flex has-all-centered">
                    <img :src="currentGroup.logo"
                         v-if="isRandomGroupActive && currentGroup.logo" />
                </div>
                <div class="column is-flex has-all-centered">
                    <h1 class="is-size-1 p-4 m-3"
                        v-if="isRandomGroupActive">
                        {{ currentGroup.name }}
                    </h1>
                </div>
            </div>

            <button class="button is-link m-2"
                    v-if="shuffledGroups && shuffledGroups.length"
                    @click="currentGroup = shuffledGroups.shift()">
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
        <b-modal :active.sync="isCardModalActive"
                 has-modal-card
                 full-screen
                 :can-cancel="false">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">Random card</p>
                </header>
                <section class="modal-card-body is-relative" id="confetti-bg">
                    <img id="deck"
                         src="/img/deck.png"
                         class="deck"
                         v-if="!showCard"
                         @click="revealCard" />
                    <show-card :card="randomCard"
                               class="deck"
                               :admin="false"
                               v-if="showCard"
                               :code="classroom.code"></show-card>
                </section>
                <footer class="modal-card-foot columns is-multiline"
                        style="overflow-x: auto">
                    <div class="column is-narrow is-12-mobile is-flex has-all-centered">
                        <button class="button"
                                type="button"
                                @click="isCardModalActive = false">
                            {{ trans.get("general.close") }}
                        </button>
                        <button class="button is-link"
                                @click="
                getRandomCard();
                showCard = false;
              ">
                            <i class="far fa-redo-alt"></i>
                        </button>
                    </div>
                    <div v-if="showCard"
                         class="column is-narrow is-flex has-all-centered">
                        <div class="field m-0">
                            <p class="control has-icons-left">
                                <span class="select">
                                    <select v-model="studentSelected">
                                        <option value="0">Student</option>
                                        <option :value="student.id"
                                                v-for="student in students"
                                                :key="student.id">
                                            {{ student.name }}
                                        </option>
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
                    <div v-if="showCard"
                         class="column is-narrow is-flex has-all-centered">
                        <div class="field m-0">
                            <p class="control has-icons-left">
                                <span class="select">
                                    <select v-model="groupSelected">
                                        <option value="0">Groups</option>
                                        <option v-for="group in classroom.grouping[0].groups"
                                                :value="group.id"
                                                :key="group.id">
                                            {{ group.name }}
                                        </option>
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
        <b-modal :active.sync="isCountDownModalActive"
                 has-modal-card
                 full-screen
                 :can-cancel="false">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">Countdown</p>
                </header>
                <section class="modal-card-body is-flex has-all-centered"
                         style="align-items: flex-start">
                    <count-down></count-down>
                </section>
                <footer class="modal-card-foot">
                    <button class="button"
                            type="button"
                            @click="isCountDownModalActive = false">
                        {{ trans.get("general.close") }}
                    </button>
                </footer>
            </div>
        </b-modal>
        <b-modal :active.sync="isWheelModalActive"
                 has-modal-card
                 full-screen
                 :can-cancel="false">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">{{ trans.get("utils.fortune") }}</p>
                </header>
                <section class="modal-card-body is-flex has-all-centered">
                    <wheel :students="students"></wheel>
                </section>
                <footer class="modal-card-foot">
                    <button class="button" type="button" @click="refresh">
                        {{ trans.get("general.close") }}
                    </button>
                </footer>
            </div>
        </b-modal>
        <b-modal :active.sync="isMassiveModalActive" has-modal-card full-screen>
            <massive-actions :classroom="classroom"></massive-actions>
        </b-modal>
    </div>
</template>

<script>
    import confetti from "canvas-confetti";

    export default {
        props: ["students", "classroom", "groups"],
        created() {
            if (this.$cookies.get("view")) {
                this.view = this.$cookies.get("view");
            }
        },
        mounted() {
            this.mainBehavioursJson = this.orderedBehaviours.slice(0, this.numItems);
            this.otherBehavioursJson = this.orderedBehaviours.slice(this.numItems);
            this.sortKey = $cookies.get("order") ?? "name";
        },
        data: function () {
            return {
                view: "0",
                search: "",
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
                isWheelModalActive: false,
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
            sendMessage(type, id = null) {
                this.$buefy.dialog.prompt({
                    message: this.trans.get('students.send_message'),
                    inputAttrs: {},
                    cancelText: this.trans.get('general.cancel'),
                    confirmText: this.trans.get('general.send'),
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
                                this.$toasted.show(this.trans.get('success_error.add_success'), {
                                    position: "top-center",
                                    duration: 3000,
                                    iconPack: "fontawesome",
                                    icon: 'check',
                                    type: 'success',
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
                this.$cookies.set("view", view);
                this.view = view;
            },
            refresh() {
                location.reload();
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
            }
        },
        computed: {
            orderedBehaviours: function () {
                return _.orderBy(this.classroom.behaviours, "count_number", "desc");
            },
            orderedStudents: function () {
                let order = "desc";
                if (this.sortKey == "name") order = "asc";
                return _.orderBy(
                    _.orderBy(
                        this.students.filter((student) => {
                            return student.name
                                .toLowerCase()
                                .includes(this.search.toLowerCase());
                        }),
                        this.sortKey,
                        order
                    ),
                    "hidden",
                    "asc"
                );
            },
        },
    };
</script>
