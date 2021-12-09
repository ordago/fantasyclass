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
      <vue-cal
        locale="es"
        hide-weekends
        hide-week-number
        hide-view-selector
        :time-from="start_h * 60 + start_m"
        :time-to="end_h * 60 + end_m"
        :time-step="30"
        class="vuecal--blue-theme"
        :disable-views="['years', 'year', 'month', 'day']"
      >
      </vue-cal>
    </div>
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
  },
  data: function () {
    return {
      start_h: 8,
      start_m: 0,
      end_h: 17,
      end_m: 0,
    };
  },
  methods: {
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
      // location.reload();
    },
  },
  components: { VueCal },
};
</script>