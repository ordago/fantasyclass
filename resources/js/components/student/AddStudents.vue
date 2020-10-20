<template>
  <div class="has-padding-4">
    <div class="columns">
      <div class="column is-narrow p-0 m-1">
        <Xlsx type="addstudent"></Xlsx>
      </div>
      <div class="column is-narrow p-0 m-1">
        <button class="button is-primary" @click="loadGoogleCourses">
          <i class="fad fa-chalkboard-teacher mr-2"></i>
          {{ trans.get("students.import_gclassroom") }}
        </button>
      </div>
    </div>
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
        <span class="tag is-danger" v-if="student.google_uid"
          ><i class="fab fa-google"></i
        ></span>
        {{ student.name }}
        <i
          class="fal fa-at pl-2"
          v-if="student.email && student.email.length"
        ></i>
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
    <button
      v-if="students.length"
      @click.prevent="sendStudents"
      class="button is-link"
    >
      {{ trans.get("users_groups.create_students") }}
    </button>

    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Google Classroom</p>
        </header>
        <section class="modal-card-body is-relative">
          <div v-if="gcourses && gcourses.length && !gstudents.length">
            <div
              class="p-5 m-2 card-shadow-s cursor-pointer"
              v-for="course in gcourses"
              :key="course.id"
              @click="loadGoogleStudents(course.id)"
            >
              <i class="fad fa-chalkboard mr-2"></i> {{ course.name }}
            </div>
          </div>
          <div v-if="gstudents && gstudents.length">
            <div
              class="p-3 m-1"
              v-for="student in gstudents"
              :key="student.profile.id"
            >
              {{ student.profile.name.fullName }} ({{
                student.profile.emailAddress
              }})
              <hr />
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isModalActive = false">
            {{ trans.get("general.close") }}
          </button>
          <button
            class="button is-link"
            type="button"
            v-if="gstudents && gstudents.length"
            @click="gstudents = []"
          >
            <i class="fas fa-arrow-left"></i>
          </button>
          <button
            class="button is-success"
            type="button"
            v-if="gstudents && gstudents.length"
            @click="addFromClassroom"
          >
            {{ trans.get("general.import") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>

  </div>
</template>

<script>
import Utils from "../../utils.js";
const Xlsx = () => import("../utils/ImportExcel.vue");

export default {
  components: {
    Xlsx,
  },
  props: ["code", "modalVisible"],
  mounted() {
    if (this.modalVisible == true) this.loadGoogleCourses();
  },
  data: function () {
    return {
      students: [],
      stdName: "",
      stdEmail: "",
      stdCourse: "",
      stdGoogleUid: "",
      stdUsername: "",
      nextId: 1,
      gcourses: [],
      gstudents: [],
      isModalActive: false,
      isLoading: false,
    };
  },
  methods: {
    loadGoogleStudents(id) {
      axios
        .get("/google/classroom/list/" + id + "/students")
        .then((response) => {
          this.gstudents = response.data;
        });
    },
    loadGoogleCourses() {
      axios
        .get("/google/classroom/list/courses")
        .then((response) => {
          this.gcourses = response.data;
          this.isModalActive = true;
        })
        .catch((error) => {
          location.href = "/google/classroom/link/" + this.code;
        });
    },
    addFromClassroom() {
      this.gstudents.forEach((student) => {
        this.addStudent(
          student.profile.name.fullName,
          student.profile.emailAddress,
          student.courseId,
          student.userId
        );
        this.stdName = "";
        this.stdEmail = "";
      });
      this.gstudents = [];
      this.isModalActive = false;
    },
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
    addStudent(name, email, gcourse = null, guid = null) {
      if (email && !Utils.validEmail(email)) {
        Utils.toast(this, this.trans.get("validation.email"), 2);
        return false;
      }
      if (!email) email = "";
      let search = this.students.find((student) => student.name === name);
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
              google_course: gcourse,
              google_uid: guid,
            });
            name = email = this.stdUsername = "";
          });
      } else {
        Utils.toast(this, this.trans.get("validation.distinct"), 2);
      }
    },
    sendStudents() {
      if (this.students.length) {
        this.isLoading = true;
        this.$forceUpdate();
        axios
          .post("/classroom/students", {
            students: this.students,
          })
          .then((response) => {
            this.isLoading = false;
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
              window.location = "/classroom/" + this.code;
            }
          })
          .catch((error) => {
            this.isLoading = false;
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
