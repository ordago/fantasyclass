<template>
  <div class="p-2">
    <vue-cal
      locale="es"
      hide-weekends
      hide-week-number
      hide-view-selector
      :time-from="8 * 60"
      :time-to="14 * 60"
      :time-step="30"
      class="vuecal--blue-theme"
      :disable-views="['years', 'year', 'month', 'day']"
    >
    </vue-cal>
  </div>
</template>

<script>
// import Utils from "../../utils.js";
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";
import "vue-cal/dist/i18n/es.js";

export default {
  props: ["code"],
  created() {},
  data: function () {
    return {};
  },
  methods: {},
  components: { VueCal },
};
</script>