<template>
  <div class="card rounded card-shadow-s h-100" style="overflow: visible">
    <show-character
      :show-skills="showSkills"
      :student="student"
      :classroom="classroom"
      :key="update"
    ></show-character>
    <div
      class="card-content is-relative"
      v-bind:class="{ 'has-background-hidden': student.hidden == 1 }"
    >
      <div
        class="dropdown is-right top-right custom is-hoverable"
        style="right: 10px"
      >
        <div class="dropdown-trigger fs-2">
          <span class="pl-5 py-2">
            <i class="far fa-bars"></i>
          </span>
        </div>
        <div class="dropdown-menu has-text-left" id="dropdown-menu" role="menu">
          <div class="dropdown-content">
            <a class="dropdown-item" @click="redirect(student.id)">
              <i class="fal fa-info-square" style="width: 20px"></i>
              {{ trans.get("students.student_area") }}
            </a>
            <a class="dropdown-item" @click="byPassStudent(student.id)">
              <i class="fal fa-eye" style="width: 20px"></i>
              {{ trans.get("students.student_view") }}
            </a>
            <a
              class="dropdown-item"
              target="_blank"
              :href="
                '/classroom/' +
                classroom.code +
                '/student/' +
                student.id +
                '/report'
              "
            >
              <i class="fal fa-file" style="width: 20px"></i>
              {{ trans.get("students.student_report") }}
            </a>
            <a
              class="dropdown-item"
              @click="$parent.sendMessage(0, student.id)"
            >
              <i class="fal fa-paper-plane" style="width: 20px"></i>
              {{ trans.get("students.send_message") }}
            </a>
            <!-- <hr class="dropdown-divider" /> -->
          </div>
        </div>
      </div>
      <div class="media mb-0 is-relative">
        <div class="media-left" v-if="classroom.character_theme != 0">
          <figure class="image is-48x48">
            <img :src="student.avatar" class="rounded" alt />
          </figure>
        </div>
        <div class="media-content cursor-pointer" @click="redirect(student.id)">
          <p class="title is-4">
            {{ student.name }}
            <i class="fas fa-eye-slash" v-if="student.hidden == 1"></i>
          </p>
          <p class="subtitle is-6">
            <small>@{{ student.username }}</small>
          </p>
        </div>

        <span class="bottom-right cursor-pointer is-flex has-all-centered">
          <span
            class="tag is-danger"
            v-if="student.google_uid"
            @click="redirect(student.id)"
          >
            <i class="fab fa-google"></i
          ></span>
          <span class="tag is-dark ml-1" @click="redirect(student.id)">
            {{ student.numcards[0] }} / {{ student.numcards[1]
            }}<i class="fak fa-deck ml-1"></i>
          </span>
          <span
            class="tag is-success ml-1"
            v-if="student.online"
            v-tippy
            :content="trans.get('students.online')"
          >
            <i class="fad fa-wifi"></i>
          </span>
          <span
            v-else
            class="tag is-light border ml-1"
            v-tippy
            content="Offline"
          >
            <i class="fas fa-wifi-slash"></i>
          </span>
        </span>
      </div>

      <div class="content">
        <div>
          <div
            class="mb-2 mt-3"
            v-if="student.numcards[0] > student.numcards[1]"
          >
            <article class="message is-danger">
              <div class="message-body">
                <i class="fas fa-exclamation-square"></i>
                {{ trans.get("success_error.cards_exceded") }}
                {{ student.numcards[0] }} /
                {{ student.numcards[1] }}
              </div>
            </article>
          </div>

          <hp :hp="student.hp" :size="2" class="mb-3"></hp>

          <div class="my-1 has-text-centered">
            <div class="w-100 is-flex has-all-centered">
              <button
                v-for="behaviour in behaviours"
                v-tippy
                :content="getMessage(behaviour)"
                class="button m-1 px-3 is-light"
                @click="addBehaviour(student.id, behaviour)"
                v-bind:class="[
                  behaviour.xp + behaviour.hp + behaviour.gold >= 0
                    ? 'is-success'
                    : 'is-danger',
                ]"
                v-bind:key="behaviour.id"
              >
                <i :class="behaviour.icon"></i>
              </button>
              <div
                class="button is-link is-light m-1 px-4"
                @click="show2l = !show2l"
                v-if="behaviourshidden.length"
              >
                <i
                  class="fas"
                  :class="{ 'fa-plus': !show2l, 'fa-minus': show2l }"
                ></i>
              </div>
              <a
                :href="'/classroom/' + classroom.code + '/behaviours/'"
                class="button is-link is-light m-1 px-4"
                v-tippy
                :content="trans.get('users_groups.add_behaviours')"
                v-if="behaviours.length == 0"
              >
                <i class="fas fa-plus"></i>
              </a>
            </div>
            <div v-if="show2l">
              <button
                v-for="behaviour in behaviourshidden"
                v-tippy
                :content="getMessage(behaviour)"
                class="button m-1 is-light px-4"
                v-bind:class="[
                  behaviour.xp + behaviour.hp + behaviour.gold >= 0
                    ? 'is-success'
                    : 'is-danger',
                ]"
                v-bind:key="behaviour.id"
                @click="addBehaviour(student.id, behaviour)"
              >
                <i :class="behaviour.icon"></i>
              </button>
              <a v-tippy :content="trans.get('menu.behaviours')" class="button m-1" :href="'/classroom/' + classroom.code +'/behaviours'"><i class="fas fa-cog"></i></a>
            </div>
          </div>
          <div class="columns p-0 m-0">
            <div class="column p-0 m-0">
              <div
                class="score p-3 m-1 cursor-pointer"
                @click="enableXPGold(0)"
              >
                <span>
                  <i class="fas fa-fist-raised colored"></i>
                </span>
                {{ student.xp }}
                <span class="bottom-right" style="right: 8px">
                  <i
                    class="fad"
                    :class="{
                      'fa-caret-down': !visibleXP,
                      'fa-caret-up': visibleXP,
                    }"
                  ></i>
                </span>
              </div>
            </div>

            <div class="column p-0 m-0">
              <div class="gold p-3 m-1 cursor-pointer" @click="enableXPGold(1)">
                <i class="fas fa-coins colored"></i>
                {{ student.gold }}
                <span class="bottom-right" style="right: 8px">
                  <i
                    class="fad"
                    :class="{
                      'fa-caret-down': !visibleGold,
                      'fa-caret-up': visibleGold,
                    }"
                  ></i>
                </span>
              </div>
            </div>
          </div>
          <div class="my-2 has-text-centered" v-if="visibleXP">
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', 100)"
              class="button is-dark px-3"
            >
              100
            </button>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', 50)"
              class="button is-dark px-3"
            >
              50
            </button>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', 10)"
              class="button is-dark px-3"
            >
              10
            </button>
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
                <button type="submit" class="button is-primary px-3">
                  <i class="fas fa-hashtag"></i>
                </button>
              </template>
              <span>
                <div class="is-flex">
                  <input type="number" v-model="custom" class="input mr-1" />
                  <button
                    @click="updateProp(student.id, 'xp', custom)"
                    class="button is-primary is-inline"
                  >
                    {{ trans.get("users_groups.apply") }}
                  </button>
                </div>
              </span>
            </tippy>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', -10)"
              class="button is-dark is-outlined px-2"
            >
              -10
            </button>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', -50)"
              class="button is-dark is-outlined px-2"
            >
              -50
            </button>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', -100)"
              class="button is-dark is-outlined px-2"
            >
              -100
            </button>
          </div>

          <div class="my-2 has-text-centered" v-if="visibleGold">
            <div class>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', 100)"
                class="button is-warning px-3"
              >
                100
              </button>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', 50)"
                class="button is-warning px-3"
              >
                50
              </button>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', 10)"
                class="button is-warning px-3"
              >
                10
              </button>
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
                  <button type="submit" class="button is-primary px-3">
                    <i class="fas fa-hashtag"></i>
                  </button>
                </template>

                <span>
                  <div class="is-flex">
                    <input type="number" v-model="custom" class="input mr-1" />
                    <button
                      @click="updateProp(student.id, 'gold', custom)"
                      class="button is-primary col-4 pl-1"
                    >
                      {{ trans.get("users_groups.apply") }}
                    </button>
                  </div>
                </span>
              </tippy>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', -10)"
                class="button is-dark is-outlined px-2"
              >
                -10
              </button>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', -50)"
                class="button is-dark is-outlined px-2"
              >
                -50
              </button>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', -100)"
                class="button is-dark is-outlined px-2"
              >
                -100
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    student: {},
    classroom: {},
    behaviours: {},
    behaviourshidden: {},
    random: {},
    showSkills: {
      type: Boolean,
      default: false,
    },
  },
  mounted() {},
  data: function () {
    return {
      show2l: false,
      custom: 0,
      update: 0,
      visibleXP: false,
      visibleGold: false,
      report: false,
    };
  },
  methods: {
    // getReport(id) {
    //   axios
    //     .post("/classroom/" + this.classroom.code + "/student/report", {
    //       student: id,
    //     })
    //     .then((response) => {
    //       this.student.behaviours = response.data.behaviours;
    //       this.student.evaluation = response.data.evaluation;
    //       this.student.classSettings = response.data.classSettings;
    //       this.student.grades = response.data.grades;
    //       this.report = true;
    //     });
    // },
    getMessage(behaviour) {
      let text = this.trans.get(behaviour.name) + " <small>(";
      if(behaviour.hp)
          text += ' <i class=\'fas fa-heart colored\'></i> ' + behaviour.hp ;
          
      if(behaviour.xp)
          text +=  ' <i class=\'fas fa-fist-raised colored\'></i> ' + behaviour.xp;
                  
      if(behaviour.gold)
          text += ' <i class=\'fas fa-coins colored\'></i> ' +  behaviour.gold;

      text += ')</small>';
      return text;
    },
    byPassStudent(id) {
      axios
        .post("/classroom/" + this.classroom.code + "/student/show", { id: id })
        .then((response) => {
          location.href = response.data;
        });
    },
    enableXPGold(type) {
      if (type == 0) {
        this.visibleXP = !this.visibleXP;
        this.visibleGold = false;
      } else {
        this.visibleXP = false;
        this.visibleGold = !this.visibleGold;
      }
    },
    updateProp: function (id, prop, value) {
      let options = { id: id, prop: prop, value: value, type: "teacher" };
      let student;

      axios.post("/classroom/students/update", options).then((response) => {
        if (this.random) {
          student = this.$parent.$parent.currentStudent;
        } else student = this.$parent.students.find((el) => el.id === id);
        if (prop == "xp") {
          student.xp = response.data.xp;
          student.level = response.data.level;
        } else if (prop == "gold") {
          student.gold = response.data;
        }
        this.custom = 0;
        this.$emit("students", this.students);
        this.$forceUpdate();
        this.$parent.$forceUpdate();
      });
    },
    addBehaviour: function (id, behaviour) {
      let audio;
      if(behaviour.xp + behaviour.hp + behaviour.gold >= 0) {
         audio = new Audio("/sound/positive.mp3");
      } else {
        audio = new Audio("/sound/boing.mp3");
      }
      audio.play();

      let options = { id: id, behaviour: behaviour.id };
      let student;
      axios.post("/classroom/student/behaviour", options).then((response) => {
        if (this.random) student = this.$parent.$parent.currentStudent;
        else student = this.$parent.students.find((el) => el.id === id);
        if (response.data.hp == "protect") {
          this.$toast(this.trans.get("skills.protect"));
        } else {
          student.hp = response.data.student.hp;
        }
        student.xp = response.data.student.xp;
        student.gold = response.data.student.gold;
        student.level = response.data.student.level;
        student.equipment = response.data.student.equipment;
        student.pets = response.data.student.pets;
        this.update++;
        this.$forceUpdate();
        this.$parent.$forceUpdate();
      });
    },
    redirect(id) {
      window.location.href =
        "/classroom/" + this.classroom.code + "/student/" + id;
    },
  },
  computed: {},
};
</script>
<style>
</style>
