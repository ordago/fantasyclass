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
        <div class="buttons mt-3 has-all-centered">
          <button class="button is-info" @click="changeAll(true)">
            <i class="fas fa-ballot-check"></i>
            <i class="far fa-users mr-2"></i>
            {{ trans.get("utils.select_all") }}
          </button>
          <button class="button is-info" @click="changeAll(false)">
            <i class="fas fa-eraser mr-2"></i>
            {{ trans.get("utils.remove_selection") }}
          </button>
          <button class="button is-info" @click="random">
            <i class="fas fa-random mr-2"></i> {{ trans.get("utils.random") }}
          </button>
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
        v-if="behaviour"
        type="button"
        @click="accept"
      >
        Accept
      </button>
    </footer>
  </div>
</template>
<script>
export default {
  props: ["classroom", "students"],
  mounted() {},
  data: function () {
    return {
      behaviour: null,
      isLoading: false,
    };
  },
  methods: {
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
        })
        .then((response) => {
          // this.$parent.$parent.isMassiveModalActive = false
          location.reload();
        });
    },
    random() {
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
      return this.students.sort((a, b) => {
        let a1, b1;
        if (a.name.includes(" ")) {
          a1 = a.name.split(" ")[1];
        } else {
          a1 = a.name;
        }
        if (b.name.includes(" ")) b1 = b.name.split(" ")[1];
        else b1 = b.name;
        if (a1 === b1) {
          return 0;
        }
        return a1 > b1 ? 1 : -1;
      });
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