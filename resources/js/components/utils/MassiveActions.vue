<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">{{ trans.get("menu.massive") }}</p>
    </header>
    <section
      class="modal-card-body is-flex has-all-centered"
      style="align-items: flex-start"
    >
      <div class="has-text-centered w-100">
        <div class="control">
          <label class="label">{{ trans.get("menu.behaviours") }}</label>

          <div class="select">
            <select v-model="behaviour">
              <option
                :class="{
                  'has-background-danger-light':
                    behaviour.hp + behaviour.xp + behaviour.gold < 0,
                  'has-background-success-light':
                    behaviour.hp + behaviour.xp + behaviour.gold >= 0,
                }"
                v-for="behaviour in classroom.behaviours"
                :key="behaviour.id"
                :value="behaviour.id"
              >
                {{ trans.get(behaviour.name) }} {{ getText(behaviour) }}
              </option>
            </select>
          </div>
        </div>
        <label class="label mt-3 mb-0">{{ trans.get("general.stats") }}</label>
        <div class="columns mt-0" style="width: 60%; margin: 0 20%">
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span
                  class="button is-static"
                  v-bind:class="{
                    'has-background-success': hp > 0,
                    'has-background-danger': hp < 0,
                  }"
                  ><i class="fas fa-heart colored"></i
                ></span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="hp"
                  class="input"
                  v-model="hp"
                  required
                />
              </p>
            </div>
          </div>
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span
                  class="button is-static"
                  v-bind:class="{
                    'has-background-success': xp > 0,
                    'has-background-danger': xp < 0,
                  }"
                  ><i class="fas fa-fist-raised colored"></i
                ></span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="xp"
                  class="input"
                  v-model="xp"
                  required
                />
              </p>
            </div>
          </div>
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span
                  class="button is-static"
                  v-bind:class="{
                    'has-background-success': gold > 0,
                    'has-background-danger': gold < 0,
                  }"
                  ><i class="fas fa-coins colored"></i
                ></span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="gold"
                  class="input"
                  v-model="gold"
                  required
                />
              </p>
            </div>
          </div>
        </div>
        <div class="buttons mt-3 is-flex has-all-centered">
          <button class="button mb-0 is-info" @click="changeAll(true)">
            <i class="fas fa-ballot-check"></i>
            <i class="far fa-users mr-2"></i>
            {{ trans.get("utils.select_all") }}
          </button>
          <button class="button mb-0 is-info" @click="changeAll(false)">
            <i class="fas fa-eraser mr-2"></i>
            {{ trans.get("utils.remove_selection") }}
          </button>
          <button class="button mb-0 is-info" @click="random">
            <i class="fas fa-random mr-2"></i> {{ trans.get("utils.random") }}
          </button>
          <div class="control select mt-0" v-if="groups && groups.length && orderedStudents.length < max">
            <select v-model="groupSelected" @input="updateGroup()">
              <option :value="null" disabled>{{ trans.get('utils.by_group') }}</option>
              <option
                :value="group"
                v-for="group in groups"
                :key="'g-' + group.id"
              >
                {{ group.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="columns is-multiline is-variable mt-3">
          <div
            class="column p-3 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
            v-for="student in orderedStudents"
            :key="student.id"
            v-bind:class="{ hidden: student.hidden == 1 }"
          >
            <div
              v-if="student.hidden != 1"
              :id="student.id"
              @click="toggle(student.id)"
              class="student-massive p-3 is-flex has-all-centered rounded"
            >
              <img
                :src="getAvatar(student.avatar_url)"
                width="64px"
                class="mr-3 rounded"
              />
              {{ student.name }}
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button
        class="button"
        type="button"
        @click="$parent.$parent.isMassiveModalActive = false"
      >
        {{ trans.get("general.close") }}
      </button>
      <button
        class="button is-link"
        :class="{ 'is-loading': isLoading }"
        v-if="behaviour || hp != 0 || xp != 0 || gold != 0"
        type="button"
        @click="accept"
      >
        {{ trans.get("general.accept") }}
      </button>
    </footer>
  </div>
</template>
<script>
export default {
  props: ["classroom", "students", "groups"],
  mounted() {},
  data: function () {
    return {
      hp: 0,
      xp: 0,
      gold: 0,
      behaviour: null,
      groupSelected: null,
      isLoading: false,
      max: process.env.MIX_MAX_STUDENTS,  
    };
  },
  methods: {
    updateGroup() {
      var vm = this;
      this.changeAll(false);
      setTimeout(() => {
        this.groupSelected.students.forEach(function (element) {
          vm.toggle(element.id);
        });
      }, 100);
    },
    getAvatar(url) {
      if (url) return url;
      return "/img/no_avatar.png";
    },
    accept() {
      this.isLoading = true;
      let ids = [];
      let elements = document.querySelectorAll(".student-massive.selected");
      elements.forEach(function (element) {
        ids.push(element.getAttribute("id"));
      });
      axios
        .post("/classroom/" + this.classroom.code + "/utils/massive", {
          students: ids,
          behaviour: this.behaviour,
          hp: this.hp,
          xp: this.xp,
          gold: this.gold,
        })
        .then((response) => {
          // this.$parent.$parent.isMassiveModalActive = false
          location.reload();
        });
    },
    random() {
      this.changeAll(false);
      let elements = document.querySelectorAll(".student-massive");
      elements.forEach(function (element) {
        if (Math.random() >= 0.5) {
          element.classList.add("selected");
        } else {
          element.classList.remove("selected");
        }
      });
    },
    changeAll(select) {
      let elements = document.querySelectorAll(".student-massive");
      elements.forEach(function (element) {
        if (select) element.classList.add("selected");
        else element.classList.remove("selected");
      });
    },
    toggle(id) {
      let element = document.getElementById(id);
      if (element.classList.contains("selected"))
        element.classList.remove("selected");
      else element.classList.add("selected");
    },
    getText(behaviour) {
      let text = "";
      if (behaviour.hp != 0) text += behaviour.hp + " 💗 ";
      if (behaviour.xp != 0) text += behaviour.xp + " ✊ ";
      if (behaviour.gold != 0) text += behaviour.gold + " 💰 ";
      return text;
    },
  },

  computed: {
    orderedStudents: function () {
      return _.orderBy(this.students, "name", "asc");
      // return this.students.sort((a, b) => {
      //   let a1, b1;
      //   if (a.name.includes(" ")) {
      //     a1 = a.name.split(" ")[1];
      //   } else {
      //     a1 = a.name;
      //   }
      //   if (b.name.includes(" ")) b1 = b.name.split(" ")[1];
      //   else b1 = b.name;
      //   if (a1 === b1) {
      //     return 0;
      //   }
      //   return a1 > b1 ? 1 : -1;
      // });
    },
  },
};
</script>
<style scoped>
.selected {
  margin: 0;
  background-color: lightskyblue;
}
</style>