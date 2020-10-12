<template>
  <section class="has-padding-2">
    <div class="columns has-margin-bottom-0">
      <div class="column is-narrow">
        <a
          :href="'/classroom/' + this.code + '/behaviours/create'"
          class="button is-link"
          >{{ trans.get("behaviours.add") }}</a
        >
        <a
          v-if="behaviours.length < 4"
          :href="'/classroom/' + this.code + '/behaviours/import/default'"
          class="button is-info"
          >{{ trans.get("behaviours.import_default") }}</a
        >
      </div>

      <div class="column is-hidden-mobile"></div>
      <div class="column is-narrow" v-if="data.length">
        <download-excel
          style="display: inline"
          :data="data"
          :fields="json_fields"
        >
          <b-button type="is-success has-margin-2">
            <i class="fas fa-file-spreadsheet"></i>
          </b-button>
        </download-excel>
      </div>
    </div>

    <b-table
      v-if="data.length"
      :data="data"
      :default-sort="['hp', 'desc']"
      icon-pack="fas"
      sort-icon="arrow-up"
    >
      <template slot-scope="props">
        <b-table-column
          field="icon"
          :label="trans.get('behaviours.icon')"
          centered
        >
          <span
            class="tag"
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
          :label="trans.get('behaviours.name')"
          sortable
          >{{ trans.get(props.row.name) }}</b-table-column
        >

        <b-table-column
          field="custom_text"
          :label="trans.get('behaviours.custom_text')"
          sortable
          >{{ trans.get(props.row.custom_text) }}</b-table-column
        >

        <b-table-column
          field="hp"
          :label="trans.get('behaviours.hp')"
          sortable
          centered
        >
          <i class="fas fa-heart"></i>
          {{ props.row.hp }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('behaviours.experience')"
          sortable
          centered
        >
          <i class="fas fa-fist-raised"></i>
          {{ props.row.xp }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('behaviours.gold')"
          sortable
          centered
        >
          <i class="fas fa-coins"></i>
          {{ props.row.gold }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('menu.settings')"
          centered
        >
          <a
            :href="'/classroom/' + code + '/behaviours/' + props.row.id"
            class="button is-info is-small"
          >
            <i class="fas fa-edit"></i>
          </a>
          <b-button
            type="is-danger is-small"
            @click="confirmDelete(props.row.id)"
          >
            <i class="fas fa-trash-alt"></i>
          </b-button>
        </b-table-column>
      </template>
    </b-table>
  </section>
</template>

<script>
import JsonExcel from "vue-json-excel";
Vue.component("download-excel", JsonExcel);

export default {
  props: ["behaviours", "code"],
  created() {
    this.data = JSON.parse(this.behaviours);
  },
  data: function () {
    return {
      data: [],
      json_fields: {
        Icon: "icon",
        Name: "name",
        "Custom text": "custom_text",
        HP: "hp",
        XP: "xp",
        Gold: "gold",
      },
      sortIcon: "arrow-down",
      sortIconSize: "is-small",
    };
  },
  methods: {
    confirmDelete(behaviourId) {
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
          var index = this.data.findIndex(function (item, i) {
            return item.id === behaviourId;
          });
          axios
            .delete("/classroom/behaviour/" + behaviourId)
            .then((response) => {
              if (response.data === 1) {
                this.data.splice(index, 1);
              }
            });
        },
      });
    },
  },
};
</script>