<template>
  <div>
    <button class="button is-primary my-3" @click="showAddModal">
      {{ trans.get("events.add") }}
    </button>
    <div class="m-0 w-100">
      <b-table
        :data="events"
        :default-sort="['id']"
        icon-pack="fas"
        cell-class="align-right"
        sort-icon="arrow-up"
        :row-class="(row, index) => isDisabled(row.id) && 'is-disabled'"
      >
        <template slot-scope="props">
          <b-table-column
            field="name"
            :label="trans.get('events.title')"
            sortable
            ><span v-html="trans.get(props.row.title)"></span
          ></b-table-column>

          <b-table-column
            field="url"
            :label="trans.get('events.content')"
            sortable
            ><span v-html="trans.get(props.row.content)"></span
          ></b-table-column>

          <b-table-column
            field="settings"
            :label="trans.get('menu.settings')"
            centered
            class="w-100 is-flex has-all-centered"
          >
            <a
              v-tippy
              :content="
                isDisabled(props.row.id)
                  ? trans.get('general.enable')
                  : trans.get('general.disable')
              "
              @click.prevent="toggle(props.row.id)"
              class="button is-small mr-3"
              :class="{
                'is-dark': !isDisabled(props.row.id),
                'is-light': isDisabled(props.row.id),
              }"
            >
              <i class="fas fa-eye" v-if="isDisabled(props.row.id)"></i>
              <i class="fas fa-eye-slash" v-else></i>
            </a>
            <button
              v-tippy
              :content="trans.get('general.edit')"
              v-if="props.row.classroom_id != null"
              @click="editModal(props.row)"
              class="button is-info is-small mr-3"
            >
              <i class="fas fa-edit"></i>
            </button>
            <b-button
              v-tippy
              :content="trans.get('general.delete')"
              type="is-danger is-small"
              v-if="props.row.classroom_id != null"
              @click="confirmDelete(props.row.id)"
            >
              <i class="fas fa-trash-alt"></i>
            </b-button>
          </b-table-column>
        </template>
      </b-table>
    </div>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("events.add") }}</p>
        </header>
        <section class="modal-card-body is-relative" id="confetti-bg">
          <b-field :label="trans.get('events.title')">
            <b-input
              type="text"
              minlength="5"
              maxlength="50"
              required
              v-model="event.title"
            >
            </b-input>
          </b-field>
          <b-field :label="trans.get('events.content')">
            <b-input
              type="textarea"
              minlength="5"
              maxlength="200"
              required
              v-model="event.content"
            >
            </b-input>
          </b-field>
          <button
            class="button is-primary"
            type="button"
            @click="addEvent(0)"
            v-if="!edit"
          >
            {{ trans.get("events.add") }}
          </button>
          <button
            class="button is-info"
            type="button"
            @click="addEvent(1)"
            v-else
          >
            {{ trans.get("events.edit") }}
          </button>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow">
            <button class="button" type="button" @click="isModalActive = false">
              {{ trans.get("general.close") }}
            </button>
          </div>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["classroom", "events", "disabled"],
  mounted() {},
  data: function () {
    return {
      isModalActive: false,
      event: {
        title: "",
        content: "",
        id: null,
        type: 0,
        options: null,
        classroom_id: this.classroom.id,
      },
      edit: false,
    };
  },
  methods: {
    addEvent(type) {
      if (type == 0) {
        if(this.event.title != '' && this.event.content != '')
        axios
          .post("/classroom/events/add", { event: this.event })
          .then((response) => {
            location.reload();
          });
      } else {
        axios
          .post("/classroom/events/edit", { event: this.event })
          .then((response) => {
            location.reload();
          });
      }
    },
    showAddModal() {
      this.edit = false;
      this.event.title = "";
      this.event.content = "";
      this.isModalActive = true;
    },
    editModal(event) {
      this.event.id = event.id;
      this.event.title = event.title;
      this.event.content = event.content;
      this.edit = true;
      this.isModalActive = true;
    },
    toggle(event) {
      axios
        .post("/classroom/" + this.classroom.code + "/events/disable", {
          id: event,
        })
        .then((response) => {
          if (this.isDisabled(event)) {
            const index = this.disabled.indexOf(event);
            if (index > -1) {
              this.disabled.splice(index, 1);
            }
          } else this.disabled.push(event);
          this.$forceUpdate();
        });
    },
    isDisabled(event) {
      return this.disabled.includes(event);
    },
    confirmDelete(event) {
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
          var index = this.events.findIndex(function (item, i) {
            return item.id === event;
          });
          axios.delete("/classroom/events/" + event).then((response) => {
            if (response.data === 1) {
              this.events.splice(index, 1);
            }
          });
        },
      });
    },
  },
};
</script>
<style>
tr.is-disabled {
  background: #999;
  color: #fff;
}
</style>