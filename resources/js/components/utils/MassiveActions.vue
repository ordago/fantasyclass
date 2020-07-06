<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">Massive actions</p>
    </header>
    <section class="modal-card-body is-flex has-all-centered" style="align-items: flex-start;">
      <div class="has-text-centered w-100">
        <div class="select">
          <select v-model="behaviour">
            <option
              :class="{ 'has-background-danger-light' : behaviour.hp + behaviour.xp + behaviour.gold < 0, 'has-background-success-light' : behaviour.hp + behaviour.xp + behaviour.gold >= 0 }"
              v-for="behaviour in classroom.behaviours"
              :key="behaviour.id"
              :value="behaviour.id"
            >{{ trans.get(behaviour.name) }} {{ getText(behaviour) }}</option>
          </select>
        </div>
        <div class="has-margin-top-3">
          <button class="button is-info" @click="changeAll(true)">
            <i class="fas fa-ballot-check"></i>
            <i class="far fa-users"></i> Select All
          </button>
          <button class="button is-info" @click="changeAll(false)">
            <i class="fas fa-eraser"></i> Remove selection
          </button>
          <button class="button is-info" @click="random">
            <i class="fas fa-random"></i> Random
          </button>
        </div>
        <div class="columns is-multiline is-variable has-margin-top-3">
          <div
            class="column has-padding-3 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
            v-for="student in classroom.students"
            :key="student.id"
          >
            <div
              :id="student.id"
              @click="toggle(student.id)"
              class="student-massive has-padding-3 is-flex has-all-centered rounded"
            >
              <img :src="student.avatar" width="64px" class="has-margin-right-3" />
              {{ student.name }}
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="$parent.$parent.isMassiveModalActive=false">Close</button>
      <button class="button is-link" v-if="behaviour" type="button" @click="accept">Accept</button>
    </footer>
  </div>
</template>
<script>
export default {
  props: ["classroom"],
  mounted() {},
  data: function() {
    return {
      behaviour: null,
    };
  },
  methods: {
    accept() {
      let ids = []
      let elements = document.querySelectorAll(".student-massive.selected");
      elements.forEach(function(element) {
        ids.push(element.getAttribute('id'))
      });
      axios.post('/classroom/' + this.classroom.code + '/utils/massive', {'students' : ids, 'behaviour' : this.behaviour})
        .then(response => {
          // this.$parent.$parent.isMassiveModalActive = false
          location.reload()
        })
    },
    random() {
      let elements = document.querySelectorAll(".student-massive");
      elements.forEach(function(element) {
        if (Math.random() >= 0.5) {
          element.classList.add("selected");
        } else {
          element.classList.remove("selected");
        }
      });
    },
    changeAll(select) {
      let elements = document.querySelectorAll(".student-massive");
      elements.forEach(function(element) {
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
    }
  },
  computed: {}
};
</script>
<style scoped>
.student-massive {
  border: 1px solid #555;
}
.selected {
  margin: 0;
  background-color: lightskyblue;
}
</style>