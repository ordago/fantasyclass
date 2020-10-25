<template>
  <div class="card rounded card-shadow-s h-100" style="overflow: visible">
    <show-character :student="student" :classroom="classroom"></show-character>
    <div
      class="card-content"
      v-bind:class="{ 'has-background-hidden': student.hidden == 1 }"
    >
      <div class="media has-margin-bottom-0 is-relative">
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

        <span
          @click="redirect(student.id)"
          class="bottom-right cursor-pointer is-flex has-all-centered"
        >
          <span
            class="tag is-success mr-1"
            v-if="student.online"
            v-tippy
            :content="trans.get('students.online')"
          >
            <i class="fad fa-wifi"></i>
          </span>
          <span class="tag is-danger mr-1" v-if="student.google_uid">
            <i class="fab fa-google"></i
          ></span>
          <span class="tag is-dark">
            {{ student.numcards[0] }} / {{ student.numcards[1]
            }}<i class="fas fa-club ml-1"></i>
          </span>
        </span>
      </div>

      <div class="content">
        <div>
          <div
            class="has-margin-bottom-2 has-margin-top-3"
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
          <div class="centered-attribute mt-5 mb-4 mx-1 p-1">
            <span
              class="attribute has-background-white-ter p-2 rounded"
              style="width: 100%"
            >
              <span>
                <i class="fas fa-heart has-text-grey-light"></i>
              </span>
              <span class="has-text-grey-light" v-if="student.hp < 20">{{
                student.hp
              }}</span>
            </span>
            <span
              class="attribute has-background-danger p-2 rounded-left"
              v-bind:class="{ rounded: student.hp == 100 }"
              :style="'width: ' + student.hp + '%'"
              v-if="student.hp > 0"
            >
              <i
                class="fas fa-heart"
                v-bind:class="{ 'has-text-danger': student.hp < 52 }"
              ></i>
              <span v-if="student.hp >= 20">{{ student.hp }}</span>
            </span>
          </div>
          <div class="my-1 has-text-centered">
            <div class="w-100 is-flex has-all-centered">
              <button
                v-for="behaviour in behaviours"
                v-tippy
                :content="
                  trans.get(behaviour.name) +
                  ' <small>(<i class=\'fas fa-heart colored\'></i> ' +
                  behaviour.hp +
                  ' <i class=\'fas fa-fist-raised colored\'></i> ' +
                  behaviour.xp +
                  ' <i class=\'fas fa-coins colored\'></i> ' +
                  behaviour.gold +
                  ')</small>'
                "
                class="button has-margin-1 has-padding-x-4 is-light"
                @click="addBehaviour(student.id, behaviour.id)"
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
                class="button is-link is-light has-margin-1 has-padding-x-4"
                @click="show2l = !show2l"
                v-if="behaviourshidden.length"
              >
                <i class="fas fa-plus"></i>
              </div>
              <a
                :href="'/classroom/' + classroom.code + '/behaviours/'"
                class="button is-link is-light has-margin-1 has-padding-x-4"
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
                :content="
                  trans.get(behaviour.name) +
                  ' <small>(<i class=\'fas fa-heart colored\'></i> ' +
                  behaviour.hp +
                  ' <i class=\'fas fa-fist-raised colored\'></i> ' +
                  behaviour.xp +
                  ' <i class=\'fas fa-coins colored\'></i> ' +
                  behaviour.gold +
                  ')</small>'
                "
                class="button has-margin-1 is-light has-padding-x-4"
                v-bind:class="[
                  behaviour.xp + behaviour.hp + behaviour.gold >= 0
                    ? 'is-success'
                    : 'is-danger',
                ]"
                v-bind:key="behaviour.id"
                @click="addBehaviour(student.id, behaviour.id)"
              >
                <i :class="behaviour.icon"></i>
              </button>
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
          <div class="has-margin-y-2 has-text-centered" v-if="visibleXP">
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', 100)"
              class="button is-dark has-padding-x-3"
            >
              100
            </button>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', 50)"
              class="button is-dark has-padding-x-3"
            >
              50
            </button>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', 10)"
              class="button is-dark has-padding-x-3"
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
                <button type="submit" class="button is-primary has-padding-x-3">
                  <i class="fas fa-hashtag"></i>
                </button>
              </template>
              <span>
                <div class="is-flex">
                  <input
                    type="number"
                    v-model="custom"
                    class="input has-margin-right-1"
                  />
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
              class="button is-dark is-outlined has-padding-x-2"
            >
              -10
            </button>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', -50)"
              class="button is-dark is-outlined has-padding-x-2"
            >
              -50
            </button>
            <button
              type="submit"
              @click="updateProp(student.id, 'xp', -100)"
              class="button is-dark is-outlined has-padding-x-2"
            >
              -100
            </button>
          </div>

          <div class="has-margin-y-2 has-text-centered" v-if="visibleGold">
            <div class>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', 100)"
                class="button is-warning has-padding-x-3"
              >
                100
              </button>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', 50)"
                class="button is-warning has-padding-x-3"
              >
                50
              </button>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', 10)"
                class="button is-warning has-padding-x-3"
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
                  <button
                    type="submit"
                    class="button is-primary has-padding-x-3"
                  >
                    <i class="fas fa-hashtag"></i>
                  </button>
                </template>

                <span>
                  <div class="is-flex">
                    <input
                      type="number"
                      v-model="custom"
                      class="input has-margin-right-1"
                    />
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
                class="button is-dark is-outlined has-padding-x-2"
              >
                -10
              </button>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', -50)"
                class="button is-dark is-outlined has-padding-x-2"
              >
                -50
              </button>
              <button
                type="submit"
                @click="updateProp(student.id, 'gold', -100)"
                class="button is-dark is-outlined has-padding-x-2"
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
  props: ["student", "classroom", "behaviours", "behaviourshidden", "random"],
  mounted() {},
  data: function () {
    return {
      show2l: false,
      custom: 0,
      visibleXP: false,
      visibleGold: false,
    };
  },
  methods: {
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
      let options = { id: id, prop: prop, value: value };
      let student;

      axios.post("/classroom/students/update", options).then((response) => {
        if (prop == "xp") {
          if (this.random)
            student = this.$parent.$parent.students.find((el) => el.id === id);
          else student = this.$parent.students.find((el) => el.id === id);
          student.xp = response.data.xp;
          student.level = response.data.level;
        } else if (prop == "gold") {
          if (this.random)
            student = this.$parent.$parent.students.find((el) => el.id === id);
          else student = this.$parent.students.find((el) => el.id === id);
          student.gold = response.data;
        }
        this.custom = 0;
        this.$emit("students", this.students);
        this.$forceUpdate();
        this.$parent.$forceUpdate();
      });
    },
    addBehaviour: function (id, behaviour) {
      let options = { id: id, behaviour: behaviour };
      let student;
      axios.post("/classroom/student/behaviour", options).then((response) => {
        if (this.random)
          student = this.$parent.$parent.students.find((el) => el.id === id);
        else student = this.$parent.students.find((el) => el.id === id);

        student.hp = response.data.hp;
        student.xp = response.data.xp.xp;
        student.gold = response.data.gold;
        student.level = response.data.xp.level;
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
