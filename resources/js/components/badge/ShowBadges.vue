<template>
  <section class="has-padding-2">
    <div class="columns has-margin-bottom-0">
      <div class="column is-narrow">
        <a
          :href="'/classroom/' + this.code + '/badges/create'"
          class="button is-link"
        >{{ trans.get('badges.add') }}</a>
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
        <b-table-column field="icon" :label="trans.get('badges.icon')" centered>
          <span
            class="tag"
          >
            <i :class="props.row.icon"></i>
          </span>
        </b-table-column>

        <b-table-column
          field="title"
          :label="trans.get('badges.title')"
          sortable
        >{{ trans.get(props.row.title) }}</b-table-column>

        <b-table-column
          field="description"
          :label="trans.get('badges.description')"
          sortable
        >{{ trans.get(props.row.description) }}</b-table-column>

        <b-table-column field="hp" :label="trans.get('badges.hp')" sortable centered>
          <i class="fas fa-heart"></i>
          {{ props.row.hp }}
        </b-table-column>

        <b-table-column field="name" :label="trans.get('badges.experience')" sortable centered>
          <i class="fas fa-fist-raised"></i>
          {{ props.row.xp }}
        </b-table-column>

        <b-table-column field="name" :label="trans.get('badges.gold')" sortable centered>
          <i class="fas fa-coins"></i>
          {{ props.row.gold }}
        </b-table-column>

        <b-table-column field="name" :label="trans.get('menu.settings')" centered>
          <a
            :href="'/classroom/' + code + '/badges/' + props.row.id"
            class="button is-info is-small"
          >
            <i class="fas fa-edit"></i>
          </a>
          <b-button type="is-danger is-small" @click="confirmDelete(props.row.id)">
            <i class="fas fa-trash-alt"></i>
          </b-button>
        </b-table-column>
      </template>
    </b-table>
  </section>
</template>

<script>
export default {
  props: ["badges", "code"],
  created() {
    this.data = JSON.parse(this.badges);
  },
  data: function() {
    return {
      data: [],
      json_fields: {
        Icon: "icon",
        Name: "name",
        "Custom text": "custom_text",
        HP: "hp",
        XP: "xp",
        Gold: "gold"
      },
      sortIcon: "arrow-down",
      sortIconSize: "is-small"
    };
  },
  methods: {
    confirmDelete(badgeId) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          var index = this.data.findIndex(function(item, i) {
            return item.id === badgeId;
          });
          axios.delete("/classroom/badge/" + badgeId).then(response => {
            if (response.data === 1) {
              this.data.splice(index, 1);
            }
          });
        }
      });
    }
  }
};
</script>