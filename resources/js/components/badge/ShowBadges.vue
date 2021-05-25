<template>
  <section class="p-2">
    <div class="columns mb-0">
      <div class="column is-narrow">
        <a
          :href="'/classroom/' + this.code + '/badges/create'"
          class="button is-link"
          >{{ trans.get("badges.add") }}</a
        >
      </div>
    </div>

    <div class="my-3">
      <h4 class="is-size-4 mb-1 ml-2">{{ trans.get('badges.base_theme') }}</h4>
      <img @click="changeDefault(index)" :class="{ 'selected' : getSelected(index) }" :src="'/img/badges/badge_'+ (index - 1) +'.png'" v-for="index in 18" :key="index">
    </div>

    <b-table
      v-if="data.length"
      :data="data"
      :default-sort="['hp', 'desc']"
      icon-pack="fas"
      sort-icon="arrow-up"
    >
      <template slot-scope="props">
        <b-table-column field="icon" style="width:80px" :label="trans.get('badges.icon')" centered>
          <ShowBadge :admin="false" :badge="props.row"></ShowBadge>
        </b-table-column>

        <b-table-column
          field="title"
          :label="trans.get('badges.title')"
          sortable
          >{{ trans.get(props.row.title) }}</b-table-column
        >

        <b-table-column
          field="description"
          :label="trans.get('badges.description')"
          sortable
          >{{ trans.get(props.row.description) }}</b-table-column
        >

        <b-table-column
          field="hp"
          :label="trans.get('badges.hp')"
          sortable
          centered
        >
          <i class="fas fa-heart"></i>
          {{ props.row.hp }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('badges.experience')"
          sortable
          centered
        >
          <i class="fas fa-fist-raised"></i>
          {{ props.row.xp }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('badges.gold')"
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
            :href="'/classroom/' + code + '/badges/' + props.row.id"
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

import ShowBadge from "./ShowBadge.vue";

export default {
  props: ["badges", "code", "background"],
  created() {
    this.data = JSON.parse(this.badges);
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
  components: {
    ShowBadge,
  },
  methods: {
    changeDefault(index) {
      axios.patch('/classroom/' + this.code + '/setting', {action: 'update', prop: 'badge_background', value: '/img/badges/badge_' + (index-1) + ".png" })
      location.reload();
    },
    getSelected(index) {
      if(this.background == '/img/badges/badge_' + (index -1) + ".png") {
        return true;
      }
      return false;
    },
    confirmDelete(badgeId) {
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
            return item.id === badgeId;
          });
          axios.delete("/classroom/badge/" + badgeId).then((response) => {
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