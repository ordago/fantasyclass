<template>
  <div class="p-2">
    <div
      class="is-flex p-2"
      style="flex-direction: column"
      v-if="!settings.attendance_start"
    >
      <h5 class="is-size-5">__ Configura el marco horario</h5>
      <div class="columns mt-2">
        <div class="column is-narrow is-flex has-all-centered">
          <i class="fad fa-hourglass-start mr-1"></i> __ Hora entrada
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
        <div class="p-0 m-0 column is-narrow is-flex has-all-centered">:</div>
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
          <i class="fad fa-hourglass-end mr-1"></i> __ Hora Salida
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
        <div class="p-0 m-0 column is-narrow is-flex has-all-centered">:</div>
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
      <div class="mt-0">
        <small class="is-italic"
          >__ Lo podrás cambiar más tarde en la configuración de la
          asistencia</small
        >
      </div>
      <div class="mt-1">
        <button class="button is-success" @click="sendSettings()">
          <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
        </button>
      </div>
    </div>
    <div v-else>
      <div class="buttons mb-0">
        <button
          v-if="subjects && subjects.length"
          class="button is-success"
          @click="isModalActive = true"
        >
          __ Add event
        </button>
        <button class="button is-primary" @click="isModalSubjectActive = true">
          __ Add subject
        </button>
      </div>
      <div class="my-1" v-if="subjects && subjects.length">
        <span
          :class="`tag mx-1 ${sub.class}`"
          v-for="sub in subjects"
          :key="`subject-${sub.id}`"
        >
          {{ sub.name }}
        </span>
      </div>
      <vue-cal
        ref="vuecal"
        locale="es"
        :events="events"
        hide-weekends
        hide-week-number
        hide-view-selector
        :time-from="start_h * 60 + start_m"
        :time-to="end_h * 60 + end_m"
        :time-step="30"
        class="vuecal--blue-theme"
        :disable-views="['years', 'year', 'month', 'day']"
        :on-event-click="onEventClick"
      >
      </vue-cal>
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
                <b-field label="__ Subject">
                  <b-select
                    v-model="cal_event.subject"
                    placeholder="__Select a subject"
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
                <b-field label="__Select a date">
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
                <b-field label="__From">
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
                <b-field label="__To">
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
                  __ Repeat every week
                </b-switch>
              </b-field>
            </div>
            <div class="columns mt-3" v-if="cal_event.repeat">
              <div class="column is-narrow">
                <b-field label="__Max date">
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
              {{ trans.get("subject.add_subject") }}
            </p>
          </header>
          <section class="modal-card-body">
            <b-field :label="trans.get('subject.name')" class="mt-4">
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
  </div>
</template>

<script>
// import Utils from "../../utils.js";
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";
import "vue-cal/dist/i18n/es.js";

export default {
  props: ["code", "settings"],
  created() {},
  mounted() {
    let attendance_start = JSON.parse(this.settings.attendance_start);
    let attendance_end = JSON.parse(this.settings.attendance_end);
    this.start_h = parseInt(attendance_start[0]);
    this.start_m = parseInt(attendance_start[1]);
    this.end_h = parseInt(attendance_end[0]);
    this.end_m = parseInt(attendance_end[1]);
    this.reloadEvents();
  },
  data: function () {
    return {
      subjects: null,
      maxDate: new Date(new Date().setFullYear(new Date().getFullYear() + 1)),
      start_h: 8,
      start_m: 0,
      end_h: 17,
      end_m: 0,
      isModalActive: false,
      isAttendanceModalActive: false,
      isModalSubjectActive: false,
      events: [],
      selectedEvent: null,
      subject: {
        name: "",
        class: "subject1",
      },
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
    addSubject() {
      axios
        .post(`/classroom/${this.code}/subjects`, {
          name: this.subject.name,
          class: this.subject.class,
        })
        .then((response) => {
          this.subjects = response.data;
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
      this.isAttendanceModalActive = true;
      console.log(event);
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
      location.reload();
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
  opacity: 0.5;
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
</style>