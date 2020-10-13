<template>
  <div class="has-padding-4">
    <Xlsx type="addstudent"></Xlsx>
    <div class="field is-horizontal">
      <form @submit.prevent="addStudentForm">
        <div class="field-body">
          <div class="field is-expanded">
            <div class="field has-addons">
              <p class="control">
                <a class="button is-static">
                  <i class="far fa-user-plus"></i>
                </a>
              </p>
              <p class="control is-expanded">
                <input
                  class="input"
                  v-model="stdName"
                  required
                  type="text"
                  minlength="4"
                  :placeholder="trans.get('students.name_surname')"
                />
              </p>
              <p class="control is-expanded">
                <input
                  class="input"
                  v-model="stdEmail"
                  type="email"
                  :placeholder="'Email (' + trans.get('general.optional') + ')'"
                />
              </p>
              <p class="control">
                <button class="button is-primary">
                  {{ trans.get("users_groups.add_student") }}
                </button>
              </p>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div v-for="(student, index) in students" v-bind:key="student.name">
      <div
        class="has-margin-y-2 has-padding-4 has-background-dark has-text-light rounded text-light relative"
      >
        <span class="has-padding-right-3">{{ index + 1 }}</span>
        {{ student.name }}
        <i class="fal fa-at pl-2" v-if="student.email && student.email.length"></i>
        <span class="is-italic"> {{ student.email }}</span>
        <span
          class="tag is-warning has-margin-left-2"
          v-if="student.username.length"
          v-tippy
          content="User already exists in FantasyClass, it'll be registered in the classroom"
          ><i class="fal fa-user pr-2"></i> {{ student.username }}</span
        >
        <button
          class="button is-danger delete-button-right"
          v-on:click="deleteStudent(index)"
        >
          <i class="far fa-trash"></i>
        </button>
      </div>
    </div>
    <button v-if="students.length" @click="sendStudents" class="button is-link">
      {{ trans.get("users_groups.create_students") }}
    </button>
  </div>
</template>

<script>
import Utils from "../../utils.js";
const Xlsx = () => import("../utils/ImportExcel.vue");

export default {
  components: {
    Xlsx,
  },
  mounted() {},
  data: function () {
    return {
      students: [],
      stdName: "",
      stdEmail: "",
      stdUsername: "",
      nextId: 1,
    };
  },
  methods: {
    addFromExcel(students) {
        students.forEach((student) => {
        this.addStudent(student["Name"], student["E-mail"]);
        this.stdName = "";
        this.stdEmail = "";
      });
    },
    addStudentForm() {
        this.addStudent(this.stdName, this.stdEmail);
        this.stdEmail = "";
        this.stdNameP = "";
    },
    addStudent(name, email) {
      if (email && !Utils.validEmail(email)) {
        Utils.toast(this, this.trans.get("validation.email"), 2);
        return false;
      }
      let search = this.students.find(
        (student) => student.name === name
      );
      if (name && !search) {
        axios
          .post("/classroom/students/getusername", {
            name: name,
            email: email,
          })
          .then((response) => {
            this.stdUsername = response.data;
            this.students.push({
              id: this.nextId++,
              name: name,
              email: email,
              username: this.stdUsername,
            });
            name = email = this.stdUsername = "";
          });
      } else {
        Utils.toast(this, this.trans.get("validation.distinct"), 2);
      }
    },
    sendStudents() {
      if (this.students.length) {
        axios
          .post("/classroom/students", {
            students: this.students,
          })
          .then((response) => {
            if (response.data) {
              response.data.forEach((element) => {
                this.$toasted.show(element, {
                  position: "top-right",
                  iconPack: "fontawesome",
                  type: "error",
                  action: {
                    text: this.trans.get("general.close"),
                    onClick: (e, toastObject) => {
                      toastObject.goAway(0);
                    },
                  },
                });
              });
              this.students = [];
            } else {
              window.location = document.referrer;
            }
          })
          .catch((error) => {
            Utils.toast(this, error, 2);
            this.students = [];
          });
      }
    },
    deleteStudent(index) {
      this.students.splice(index, 1);
    },
  },
};
</script>
