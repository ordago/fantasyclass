<template>
  <div class="p-2">
    <div v-if="settings.attendance_start">
      <div class="buttons mb-0">
        <button
          v-if="subjects && subjects.length"
          class="button is-success"
          @click="isModalActive = true"
        >
          <i class="fas fa-calendar-plus mr-1"></i> {{ trans.get('attendance.add_event') }}
        </button>
        <button class="button is-primary" @click="isModalSubjectActive = true">
          <i class="fas fa-chalkboard mr-1"></i> {{ trans.get('attendance.add_subject') }}
        </button>
      </div>
      <div class="my-1" v-if="subjects && subjects.length">
        <span
          :class="`tag mx-1 ${sub.class}`"
          v-for="sub in subjects"
          :key="`subject-${sub.id}`"
        >
          {{ sub.name }}
          <span
            class="tag is-danger ml-2 cursor-pointer"
            @click="deleteSubject(sub.id)"
            ><i class="fas fa-trash-alt"></i
          ></span>
        </span>
      </div>
      <vue-cal
        ref="vuecal"
        :locale="settings.locale"
        :events="events"
        :hide-weekends="hideWeekends"
        :time-from="start_h * 60 + start_m"
        :time-to="end_h * 60 + end_m"
        :time-step="30"
        today-button
        class="vuecal--blue-theme"
        :on-event-click="onEventClick"
      >
      </vue-cal>
      <!-- :on-event-create="onEventCreate"
        @event-drag-create="showEventCreationDialog = true" -->
      <!-- editable-events -->
      <!-- :disable-views="['years', 'year', 'month', 'day']" -->
    </div>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      trap-focus
      :full-screen="true"
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            <i class="fas fa-calendar mr-2"></i
            >{{ trans.get("attendance.new_event") }}
          </p>
        </header>
        <section class="modal-card-body">
          <form @submit.prevent="addEvent">
            <b-field :label="trans.get('attendance.title')" class="mt-4">
              <b-input v-model="cal_event.title" required></b-input>
            </b-field>
            <div class="columns mt-3">
              <div class="column is-narrow">
                <b-field :label="trans.get('attendance.subject')">
                  <b-select
                    v-model="cal_event.subject"
                    :placeholder="trans.get('attendance.select_subject')"
                  >
                    <option
                      v-for="sub in subjects"
                      :value="sub.id"
                      :key="`subjectEvent-${sub.id}`"
                    >
                      {{ sub.name }}
                    </option>
                  </b-select>
                </b-field>
              </div>
            </div>
            <div class="columns mt-3">
              <div class="column is-narrow">
                <b-field :label="trans.get('attendance.date')">
                  <b-datepicker
                    rounded
                    locale="es-ES"
                    :first-day-of-week="1"
                    placeholder="Type or select a date..."
                    icon="calendar"
                    v-model="cal_event.date"
                  >
                  </b-datepicker>
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column is-narrow">
                <b-field :label="trans.get('attendance.from')">
                  <b-timepicker
                    rounded
                    v-model="cal_event.event_start_hour"
                    placeholder="Click to select..."
                    icon="clock"
                  >
                  </b-timepicker>
                </b-field>
              </div>
              <div class="column is-narrow">
                <b-field :label="trans.get('attendance.to')">
                  <b-timepicker
                    rounded
                    v-model="cal_event.event_end_hour"
                    placeholder="Click to select..."
                    icon="clock"
                  >
                  </b-timepicker>
                </b-field>
              </div>
            </div>
            <div class="">
              <b-field>
                <b-switch v-model="cal_event.repeat">
                  {{ trans.get('attendance.repeat') }}
                </b-switch>
              </b-field>
            </div>
            <div class="columns mt-3" v-if="cal_event.repeat">
              <div class="column is-narrow">
                <b-field :label="trans.get('attendance.until')">
                  <b-datepicker
                    :first-day-of-week="1"
                    locale="es-ES"
                    placeholder="__Click to select..."
                    :max-date="maxDate"
                    v-model="cal_event.end_date"
                    required
                    rounded
                    icon="calendar"
                  >
                  </b-datepicker>
                </b-field>
              </div>
            </div>
          </form>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isModalActive = false">
            {{ trans.get("general.close") }}
          </button>
          <button
            class="button is-primary"
            @click="createEvent"
            :disabled="cal_event.title == '' || !cal_event.subject"
          >
            {{ trans.get("general.add") }}
          </button>
          <!-- <button @click.prevent="sendEdit" v-else class="button is-primary">
              <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
            </button> -->
        </footer>
      </div>
    </b-modal>
    <b-modal
      :active.sync="isModalSubjectActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addSubject">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              {{ trans.get("attendance.add_subject") }}
            </p>
          </header>
          <section class="modal-card-body">
            <b-field :label="trans.get('attendance.subject_name')" class="mt-4">
              <b-input
                required
                v-model="subject.name"
                maxlength="100"
              ></b-input>
            </b-field>
            <b-field>
              <b-radio-button
                v-model="subject.class"
                native-value="subject1"
                type="subject1 is-light is-outlined"
              >
                <span class="p-1 subject1"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject2"
                type="subject2 is-light is-outlined"
              >
                <span class="p-1 subject2"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject3"
                type="subject3 is-light is-outlined"
              >
                <span class="p-1 subject3"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject4"
                type="subject4 is-light is-outlined"
              >
                <span class="p-1 subject4"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject5"
                type="subject5 is-light is-outlined"
              >
                <span class="p-1 subject5"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject6"
                type="subject6 is-light is-outlined"
              >
                <span class="p-1 subject6"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject7"
                type="subject7 is-light is-outlined"
              >
                <span class="p-1 subject7"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject8"
                type="subject8 is-light is-outlined"
              >
                <span class="p-1 subject8"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject9"
                type="subject9 is-light is-outlined"
              >
                <span class="p-1 subject9"></span>
              </b-radio-button>
              <b-radio-button
                v-model="subject.class"
                native-value="subject10"
                type="subject10 is-light is-outlined"
              >
                <span class="p-1 subject10"></span>
              </b-radio-button>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="isModalSubjectActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <button :disabled="subject.name == ''" class="button is-success">
              {{ trans.get("general.add") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>
    <b-modal
      :active.sync="isAttendanceModalActive"
      has-modal-card
      full-screen
      v-if="students && selectedEvent"
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            {{ trans.get('menu.attendance') }} {{ selectedEvent.title }}
          </p>
        </header>
        <section class="modal-card-body is-relative">
          <div class="mb-3">
            <b-field :label="trans.get('attendance.class_info')">
              <b-input v-model="selectedEvent.task"></b-input>
            </b-field>
          </div>
          <div class="columns is-multiline is-flex">
            <div
              class="column is-narrow"
              v-for="student in orderedStudents"
              :key="`students-${student.id}`"
            >
              <div class="border rounded p-2" :class="getBg(student)">
                <div class="columns">
                  <div class="column is-narrow">
                    <img class="rounded" :src="student.avatar" width="48px" />
                  </div>
                  <div class="column">
                    <span class="is-size-3">{{ student.name }}</span>
                  </div>
                </div>
                <div>
                  <b-field>
                    <b-radio-button
                      v-model="student.calevents[0].pivot.type"
                      :native-value="2"
                      type="is-danger is-light is-outlined"
                    >
                      <b-icon icon="times"></b-icon>
                      <span>Absence</span>
                    </b-radio-button>

                    <b-radio-button
                      v-model="student.calevents[0].pivot.type"
                      :native-value="1"
                      type="is-warning is-light is-outlined"
                    >
                      <b-icon icon="clock"></b-icon>
                      <span>Late</span>
                    </b-radio-button>

                    <b-radio-button
                      v-model="student.calevents[0].pivot.type"
                      :native-value="0"
                      type="is-success is-light is-outlined"
                    >
                      <b-icon icon="check"></b-icon>

                      <span>Present</span>
                    </b-radio-button>
                  </b-field>
                </div>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot columns is-multiline">
          <div class="buttons">
            <button
              class="button"
              type="button"
              @click="isAttendanceModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-success" @click="sendAttendance">
              <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
            </button>
            <button
              @click="disableAttendance"
              class="button is-dark"
              v-tippy="{ placement: 'right', arrow: true }"
              :content="trans.get('attendance.info_enable')"
              v-if="selectedEvent.attendance == 1"
            >
              <i class="fas fa-calendar-times mr-1"></i>{{ trans.get('attendance.disable') }}
            </button>
            <b-dropdown
              position="is-top-right"
              aria-role="list"
            >
              <template #trigger>
                <button class="button is-danger">
                  <i class="fas fa-trash-alt mr-1"></i>
                  {{ trans.get("general.delete") }}
                </button>
              </template>

              <b-dropdown-item @click="deleteEvent(false)" aria-role="listitem"
                >{{ trans.get('attendance.delete_event') }}</b-dropdown-item
              >
              <b-dropdown-item @click="deleteEvent(true)" aria-role="listitem"
                >{{ trans.get('attendance.delete_all_events') }}</b-dropdown-item
              >
            </b-dropdown>
          </div>
        </footer>
      </div>
    </b-modal>
    <b-modal
      :active.sync="isPrefsModalActive"
      has-modal-card
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get('menu.config') }}</p>
        </header>
        <section class="modal-card-body is-relative">
          <div class="is-flex p-2" style="flex-direction: column">
            <h5 class="is-size-5">{{ trans.get('attendance.configure_hours') }}</h5>
            <div class="columns mt-2">
              <div class="column is-narrow is-flex has-all-centered">
                <i class="fad fa-hourglass-start mr-1"></i>{{ trans.get('attendance.start_hour') }}
              </div>
              <div class="column is-narrow">
                <input
                  class="input"
                  type="number"
                  step="1"
                  v-model="start_h"
                  min="0"
                  max="23"
                />
              </div>
              <div class="p-0 m-0 column is-narrow is-flex has-all-centered">
                :
              </div>
              <div class="column is-narrow">
                <input
                  class="input"
                  type="number"
                  v-model="start_m"
                  step="30"
                  min="0"
                  max="30"
                />
              </div>
            </div>
            <div class="columns">
              <div class="column is-narrow is-flex has-all-centered">
                <i class="fad fa-hourglass-end mr-1"></i> {{ trans.get('attendance.end_hour') }}
              </div>
              <div class="column is-narrow">
                <input
                  class="input"
                  type="number"
                  step="1"
                  v-model="end_h"
                  min="0"
                  max="23"
                />
              </div>
              <div class="p-0 m-0 column is-narrow is-flex has-all-centered">
                :
              </div>
              <div class="column is-narrow">
                <input
                  class="input"
                  type="number"
                  step="30"
                  v-model="end_m"
                  min="0"
                  max="30"
                />
              </div>
            </div>

            <b-field>
              <b-switch
                v-model="hideWeekends"
                :true-value="true"
                :false-value="false"
              >
                {{ trans.get("attendance.hide_weekends") }}
              </b-switch>
            </b-field>

            <div class="mt-0">
              <small class="is-italic" v-if="!settings.attendance_start"
                >{{ trans.get('attendance.info_change') }}</small
              >
            </div>
            <div class="mt-1"></div>
          </div>
        </section>
        <footer class="modal-card-foot columns is-multiline">
          <div class="buttons">
            <button
              v-if="settings.attendance_start"
              class="button"
              @click="isPrefsModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-success" @click="sendSettings()">
              <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
            </button>
          </div>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
// import Utils from "../../utils.js";
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";
import "vue-cal/dist/i18n/es.js";
import "vue-cal/dist/i18n/ca.js";
// import "vue-cal/dist/drag-and-drop.js";

export default {
  props: ["code", "settings"],
  created() {},
  mounted() {
    let attendance_start = JSON.parse(this.settings.attendance_start);
    if (!attendance_start) this.isPrefsModalActive = true;
    else {
      let attendance_end = JSON.parse(this.settings.attendance_end);
      this.start_h = parseInt(attendance_start[0]);
      this.start_m = parseInt(attendance_start[1]);
      this.end_h = parseInt(attendance_end[0]);
      this.end_m = parseInt(attendance_end[1]);
      this.hideWeekends = this.settings.hideWeekends == "1";
      this.reloadEvents();
    }
  },
  data: function () {
    return {
      attendance: null,
      students: null,
      subjects: null,
      maxDate: new Date(new Date().setFullYear(new Date().getFullYear() + 1)),
      start_h: 8,
      start_m: 0,
      end_h: 17,
      end_m: 0,
      hideWeekends: true,
      isPrefsModalActive: false,
      isModalActive: false,
      isAttendanceModalActive: false,
      isModalSubjectActive: false,
      events: [],
      selectedEvent: null,
      deleteEventFunction: null,
      subject: {
        name: "",
        class: "subject1",
      },
      task: "",
      cal_event: {
        title: "",
        subject: null,
        date: new Date(),
        end_date: this.getNextMonth(),
        event_start_hour: new Date(),
        event_end_hour: new Date().addHours(1),
        repeat: false,
      },
    };
  },
  methods: {
    // onEventCreate(event, deleteEventFunction) {
    //   console.log(event);
    //   this.selectedEvent = event;
    //   this.deleteEventFunction = deleteEventFunction;

    //   // return event;
    // },
    deleteSubject(id) {
      this.$buefy.dialog.confirm({
        title: this.trans.get('attendance.delete_subject'),
        message: this.trans.get('attendance.delete_event_confirm'),
        confirmText: this.trans.get('general.delete'),
        type: "is-danger",
        hasIcon: true,
        onConfirm: () => {
          axios
            .delete(`/classroom/${this.code}/subject/${id}`)
            .then((response) => {
              this.$toast(this.trans.get("success_error.delete_success"), {
                type: "success",
              });
              this.reloadEvents();
            });
        },
      });
    },
    disableAttendance() {
      axios
        .post(`/classroom/${this.code}/attendance/disable`, {
          event: this.selectedEvent.id,
        })
        .then((response) => {
          this.isAttendanceModalActive = false;
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
          this.reloadEvents();
        });
    },
    deleteEvent(all = false) {
      this.$buefy.dialog.confirm({
        title: all ? this.trans.get('attendance.delete_all_events') : this.trans.get('attendance.delete_event'),
        message: this.trans.get('attendance.delete_event_confirm'),
        confirmText: this.trans.get("general.delete"),
        type: "is-danger",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post(`/classroom/${this.code}/attendance/delete`, {
              event: this.selectedEvent.id,
              all: all,
            })
            .then((response) => {
              this.isAttendanceModalActive = false;
              this.$toast(this.trans.get("success_error.delete_success"), {
                type: "success",
              });
              this.reloadEvents();
            });
        },
      });
    },
    getBg(student) {
      switch (student.calevents[0].pivot.type) {
        case 0:
          return "has-background-success-light";
        case 1:
          return "has-background-warning-light";
        case 2:
          return "has-background-danger-light";
      }
    },
    sendAttendance() {
      axios
        .post(`/classroom/${this.code}/attendance/save`, {
          event: this.selectedEvent,
          students: this.students,
        })
        .then((response) => {
          this.isAttendanceModalActive = false;
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
          this.reloadEvents();
        });
    },
    addSubject() {
      axios
        .post(`/classroom/${this.code}/subjects`, {
          name: this.subject.name,
          class: this.subject.class,
        })
        .then((response) => {
          this.subjects = response.data;
          this.$toast(this.trans.get("success_error.add_success"), {
            type: "success",
          });
          this.isModalSubjectActive = false;
          this.subject = {
            name: "",
            class: "subject1",
          };
        });
    },
    getNextMonth() {
      var now = new Date();
      if (now.getMonth() == 11) {
        return new Date(now.getFullYear() + 1, 0, 1);
      } else {
        return new Date(now.getFullYear(), now.getMonth() + 1, 1);
      }
    },
    onEventClick(event, e) {
      this.selectedEvent = event;
      axios
        .post(`/classroom/${this.code}/attendance/info`, {
          event: event.id,
        })
        .then((response) => {
          this.students = response.data.students;
          this.students.forEach((student) => {
            if (student.calevents[0].pivot.type === null)
              student.calevents[0].pivot.type = 0;
          });
          // this.attendance = response.data.attendance;
          this.isAttendanceModalActive = true;
        });

      // Prevent navigating to narrower view (default vue-cal behavior).
      e.stopPropagation();
    },
    reloadEvents() {
      this.events = [];
      axios
        .get("/classroom/" + this.code + "/attendance/get")
        .then((response) => {
          this.subjects = response.data.subjects;
          response.data.events.forEach((element) => {
            let info = JSON.parse(element.info);
            info.id = element.id;
            info.attendance = element.attendance;
            info.task = element.task;
            if (!info.attendance) info.class = info.class + " notAttendance";
            this.events.push(info);
          });
        });
      this.$forceUpdate();
    },
    createEvent() {
      axios
        .post("/classroom/" + this.code + "/attendance/createEvent", {
          event: this.cal_event,
        })
        .then((respose) => {
          this.isModalActive = false;
          this.$toast(this.trans.get("success_error.add_success"), {
            type: "success",
          });
          this.reloadEvents();
        });
    },
    sendSettings() {
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "attendance_start",
        action: "update",
        value: [this.start_h, this.start_m],
      });
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "attendance_end",
        action: "update",
        value: [this.end_h, this.end_m],
      });
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "hideWeekends",
        action: "update",
        value: this.hideWeekends,
      });
      location.reload();
    },
  },
  computed: {
    orderedStudents() {
      return _.orderBy(this.students, "name", "asc");
    },
  },
  components: { VueCal },
};
</script>
<style>
.vuecal__event {
  cursor: pointer;
}

.vuecal__event-title {
  font-size: 1.2em;
  font-weight: bold;
  margin: 4px 0 8px;
}

.vuecal__event-time {
  display: inline-block;
  margin-bottom: 12px;
  padding-bottom: 12px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.2);
}

.vuecal__event-content {
  font-style: italic;
}
.subject1 {
  background-color: salmon !important;
  color: white !important;
}
.subject2 {
  background-color: seagreen !important;
  color: white !important;
}
.subject3 {
  background-color: royalblue !important;
  color: white !important;
}
.subject4 {
  background-color: purple !important;
  color: white !important;
}
.subject5 {
  background-color: peachpuff !important;
  color: black !important;
}
.subject6 {
  background-color: palegoldenrod !important;
  color: black !important;
}
.subject7 {
  background-color: orchid !important;
  color: white !important;
}
.subject8 {
  background-color: maroon !important;
  color: white !important;
}
.subject9 {
  background-color: lightslategray !important;
  color: white !important;
}
.subject10 {
  background-color: gold !important;
  color: white !important;
}
.notAttendance {
  opacity: 0.3;
}

.subject1 is-focused,
.subject2 is-focused,
.subject3 is-focused,
.subject4 is-focused,
.subject5 is-focused,
.subject6 is-focused,
.subject7 is-focused,
.subject8 is-focused,
.subject9 is-focused,
.subject10 is-focused {
  border: 1px solid black;
}

.dropdown-content {
  z-index: 100;
}

.vuecal__cell-date {
  padding: 15px;
}
</style>