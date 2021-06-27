<template>
  <div class="p-2">
    <div class="is-flex justify-content-center" v-if="type == 'behaviours'">
      <apexchart
        v-if="series.length"
        width="450"
        type="donut"
        :options="{
          labels: labels,
          colors: colors,
        }"
        :series="series"
      ></apexchart>
    </div>

    <div class="columns">
      <div class="column">
        <input type="date" class="input is-rounded" v-model="dateStart" />
      </div>
      <div class="column">
        <input type="date" class="input is-rounded" v-model="dateEnd" />
      </div>
    </div>

    <b-table
      :data="filteredEntries"
      v-if="type == 'behaviours' && filteredEntries.length"
      default-sort-direction="asc"
      default-sort="created_at"
      icon-pack="fas"
      sort-icon="arrow-up"
    >
      <template slot-scope="props">
        <b-table-column
          field="icon"
          :label="trans.get('students.icon')"
          centered
        >
          <span
            class="tag is-light"
            v-bind:class="[
              props.row.xp + props.row.hp + props.row.gold >= 0
                ? 'is-success'
                : 'is-danger',
            ]"
          >
            <i :class="props.row.icon"></i>
          </span>
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('students.name')"
          centered
          sortable
          >{{ trans.get(props.row.name) }}</b-table-column
        >

        <b-table-column
          field="created_at"
          :custom-sort="sortByDate"
          :label="trans.get('students.created_at')"
          sortable
          centered
          >{{ getDate(props.row.pivot.created_at) }}</b-table-column
        >

        <b-table-column
          field="hp"
          :label="trans.get('students.hp')"
          centered
          sortable
        >
          <i class="fas fa-heart"></i>
          {{ props.row.hp }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('students.xp')"
          sortable
          centered
        >
          <i class="fas fa-fist-raised"></i>
          {{ props.row.xp }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('students.gold')"
          sortable
          centered
        >
          <i class="fas fa-coins"></i>
          {{ props.row.gold }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('students.settings')"
          v-if="admin"
          centered
        >
          <b-button
            type="is-danger is-small"
            @click="
              confirmDelete('behaviour', props.row, props.row.pivot.created_at)
            "
          >
            <i class="fas fa-trash-alt"></i>
          </b-button>
        </b-table-column>
      </template>
    </b-table>
    <b-table
      v-else
      :data="filteredLogEntries"
      default-sort-direction="asc"
      default-sort="created_at"
      icon-pack="fas"
      sort-icon="arrow-up"
    >
      <template slot-scope="props">
        <b-table-column
          field="type"
          :label="trans.get('students.type')"
          centered
        >
          <span
            class="tag is-light"
            v-bind:class="[
              props.row.value > 0 ||
              props.row.type == 'card_use' ||
              props.row.type == 'card_assign'
                ? 'is-success'
                : 'is-danger',
            ]"
          >
            <span v-if="props.row.type == 'xp'"
              ><i class="fas fa-fist-raised colored"></i
            ></span>
            <span v-else-if="props.row.type == 'gold'"
              ><i class="fas fa-coins colored"></i
            ></span>
            <span v-else-if="props.row.type == 'hp'"
              ><i class="fas fa-heart colored"></i
            ></span>
            <span v-else-if="props.row.type == 'card_use'"
              ><i class="fak fa-deck colored"></i
            ></span>
            <span v-else-if="props.row.type == 'card_delete'"
              ><i class="fak fa-deck colored"></i
            ></span>
            <span v-else-if="props.row.type == 'card_assign'"
              ><i class="fak fa-deck colored"></i
            ></span>
          </span>
        </b-table-column>

        <b-table-column
          field="value"
          centered
          :label="trans.get('students.value')"
          sortable
          ><span v-if="props.row.value">{{ props.row.value }}</span>
          <span v-else>----</span>
        </b-table-column>

        <b-table-column
          field="created_at"
          :custom-sort="sortByDate"
          :label="trans.get('students.created_at')"
          sortable
          centered
          >{{ getDate(props.row.created_at) }}</b-table-column
        >

        <b-table-column
          field="message"
          :label="trans.get('students.details')"
          centered
        >
          <span
            v-tippy
            :content="getMessage(props.row)"
            v-html="getIcon(props.row.message)"
          >
          </span>
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('students.settings')"
          v-if="admin"
          centered
        >
          <b-button
            type="is-danger is-small"
            @click="confirmDelete('logentry', props.row, props.row.created_at)"
          >
            <i class="fas fa-trash-alt"></i>
          </b-button>
        </b-table-column>
      </template>
    </b-table>
  </div>
</template>

<script>
import Utils from "../../utils.js";
// Charts
import VueApexCharts from "vue-apexcharts";
Vue.use(VueApexCharts);
Vue.component("apexchart", VueApexCharts);

export default {
  props: ["code", "info", "admin", "type", "id"],
  created() {},
  data: function () {
    return {
      series: [],
      labels: [],
      colors: [],
      dateStart: null,
      dateEnd: null,
    };
  },
  methods: {
    confirmDelete(type, row, date) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios
            .post("/classroom/student/" + type, {
              row: row,
              date: date,
              student: this.id,
              _method: "delete",
            })
            .then((response) => {
              if (type == "behaviour") {
                this.$parent.$parent.$parent.behaviours = response.data;
                this.$parent.$parent.$parent.student.updated_at = new Date();
                this.$parent.$parent.$parent.forceRerender();
              } else {
                location.reload();
              }
            });
        },
      });
    },
    sortByDate(a, b) {
      if (this.type == "behaviours") {
        return (
          new Date(b.pivot.created_at).getTime() -
          new Date(a.pivot.created_at).getTime()
        );
      } else {
        return (
          new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
        );
      }
    },
    getDate(date) {
      return Utils.getDate(date);
    },
    getMessage(row) {
      let info = "";
      if (row.info) {
        info += ": " + this.trans.get(row.info);
      }
      if (row.message)
        return this.trans.get("students.log_" + row.message) + info;
    },
    getIcon(type) {
      switch (type) {
        case "behaviour":
          return "<i class='fas fa-heart colored'></i>";
        case "teacher":
          return "<i class='fas fa-user-graduate colored' style='color: white'></i>";
        case "shop":
          return "<i class='fas fa-store colored' style='color: #A52A2A'></i>";
        case "pet":
          return "<i class='fas fa-dog colored' style='color: #A52A2A'></i>";
        case "item":
          return "<i class='fas fa-flask-potion colored' style='color: #DC143C'></i>";
        case "event":
          return "<i class='fas fa-scroll colored' style='color: #A9A9A9'></i>";
        case "send":
          return "<i class='fas fa-coins colored'></i><i class='fas fa-arrow-right colored'></i>";
        case "received":
          return "<i class='fas fa-coins colored'></i><i class='fas fa-arrow-left colored'></i>";
        case "challenge":
          return "<i class='fas fa-pen-fancy colored' style='color: #eee'></i>";
        case "card":
          return "<i class='fak fa-deck colored' style='color: black'></i>";
        case "collection":
          return "<i class='fak fa-collection colored' style='color: #eee'></i>";
        case "repair":
          return "<i class='fas fa-hammer colored' style='color: #FFCB9C'></i>";
        case "badge":
          return "<i class='fas fa-award colored' style='color: #ADD8E6'></i>";
        case "battle":
          return "<i class='fas fa-swords colored' style='color: #E6E6FA'></i>";
        case "wheel":
          return "<i class='fas fa-spinner colored' style='color: #E6E6FA'></i>";
        case "feed":
          return "<i class='fas fa-apple-alt colored' style='color: red'></i>";
        default:
          return "<i class='fas fa-info-circle colored' style='color: #E6E6FA'></i>";
      }
    },
  },
  computed: {
    filteredEntries() {
      if (this.info) {
        return this.info.filter((entry) => {
          return (
            (moment(entry.pivot.created_at).isAfter(moment(this.dateStart)) ||
              !this.dateStart) &&
            (moment(entry.pivot.created_at).isBefore(this.dateEnd) ||
              !this.dateEnd)
          );
        });
      }
    },
    groupedData() {
      if (this.type == "behaviours")
        return _.groupBy(this.filteredEntries, "id");
      else return _.groupBy(this.filteredLogEntries, "id");
    },
    filteredLogEntries() {
      return this.info.filter((entry) => {
        return (
          (moment(entry.created_at).isAfter(moment(this.dateStart)) ||
            !this.dateStart) &&
          (moment(entry.created_at).isBefore(this.dateEnd) || !this.dateEnd)
        );
      });
    },
  },
  watch: {
    groupedData: {
      immediate: true,
      handler() {
        let colorsOK = [
          "#c8e6c9",
          "#a5d6a7",
          "#81c784",
          "#66bb6a",
          "#4caf50",
          "#43a047",
          "#388e3c",
          "#2e7d32",
          "#1b5e20",
          "#003300",
          "#002200",
          "#001100",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
        ];
        let colorsKO = [
          "#ffccbc",
          "#ffab91",
          "#ff8a65",
          "#ff7043",
          "#ff5722",
          "#f4511e",
          "#e64a19",
          "#d84315",
          "#bf360c",
          "#570000",
          "#370000",
          "#170000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
        ];
        this.series = this.labels = [];
        let data = this.groupedData;
        let propes = [];
        for (let property1 in data) {
          propes.push(data[property1]);
        }
        this.labels = [];
        this.series = [];
        this.colors = [];
        propes.forEach((element) => {
          let behaviour = element[0];
          this.series.push(element.length);
          this.labels.push(
            "<i class='" +
              behaviour.icon +
              "'></i> " +
              this.trans.get(behaviour.name)
          );
          if (behaviour.xp + behaviour.hp + behaviour.gold >= 0) {
            this.colors.push(colorsOK[0]);
            colorsOK.shift();
          } else {
            this.colors.push(colorsKO[0]);
            colorsKO.shift();
          }
        });
      },
    },
  },
};
</script>