<template>
  <div class="p-2">
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
        <b-table-column
          v-slot="props"
          field="name"
          :label="trans.get('events.title')"
          sortable
          ><span v-html="trans.get(props.row.title)"></span
        ></b-table-column>

        <b-table-column
          v-slot="props"
          field="url"
          :label="trans.get('events.content')"
          sortable
          ><span v-html="trans.get(props.row.content)"></span
        ></b-table-column>

        <b-table-column
          v-slot="props"
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
        <section class="modal-card-body">
          <b-field :label="trans.get('events.title')" class="mt-4">
            <b-input
              type="text"
              minlength="5"
              maxlength="50"
              required
              v-model="event.title"
            >
            </b-input>
          </b-field>
          <b-field :label="trans.get('events.content')" class="mt-4">
            <b-input
              type="textarea"
              minlength="5"
              maxlength="200"
              required
              v-model="event.content"
            >
            </b-input>
          </b-field>

          <b-field :label="trans.get('skills.type')">
            <b-select
              @input="updateProps"
              v-model="event.options.type"
              expanded
            >
              <option
                v-for="(eType, index) in types"
                :key="index"
                :value="eType"
              >
                {{ trans.get("events.type_" + eType) }}
              </option>
            </b-select>
          </b-field>
          <div v-for="(value, key, index) in event.options" :key="index">
            <b-field class="mb-2" v-if="key != 'type'">
              <template slot="label">
                <span class="mt-2" v-html="trans.get('events.' + key)"></span>
              </template>
              <b-switch
                v-if="key == 'mult'"
                v-model="event.options[key]"
                :true-value="1"
                :false-value="-1"
              >
                {{
                  event.options[key] == 1
                    ? trans.get("events.type_win")
                    : trans.get("events.type_lose")
                }}
              </b-switch>
              <b-input
                v-else-if="key == 'textOK' || key == 'textKO'"
                type="text"
                minlength="5"
                maxlength="200"
                required
                v-model="event.options[key]"
              >
              </b-input>
              <b-numberinput
                v-else
                v-model="event.options[key]"
                controls-position="compact"
                controls-rounded
              ></b-numberinput>
            </b-field>
          </div>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow">
            <button class="button" type="button" @click="isModalActive = false">
              {{ trans.get("general.close") }}
            </button>
            <button
              class="button is-primary"
              type="button"
              @click="addEvent(0)"
              v-if="!edit"
            >
              {{ trans.get("events.add") }}
            </button>
            <button
              class="button is-primary"
              type="button"
              @click="addEvent(1)"
              v-else
            >
              <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
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
        options: { type: "common" },
        classroom_id: this.classroom.id,
      },
      types: [
        "common",
        "lose_life_one",
        "lose_life_all",
        "win_life_one",
        "win_life_all",
        "random_student",
        "random_type_character",
        "action_one_hp_gold",
        "action_one_xp",
        "win_lose_gold_one",
        "interactive",
      ],
      edit: false,
    };
  },
  methods: {
    updateProps() {
      switch (this.event.options.type) {
        case "lose_life_one":
          this.event.type = 1;
          this.event.options = {
            hpMin: 5,
            hpMax: 15,
            type: "lose_life_one",
          };
          break;
        case "lose_life_all":
          this.event.type = 2;
          this.event.options = {
            hpMin: 2,
            hpMax: 8,
            type: "lose_life_all",
          };
          break;
        case "win_life_one":
          this.event.type = 1;
          this.event.options = {
            hpMin: 5,
            hpMax: 15,
            type: "win_life_one",
          };
          break;

        case "win_life_all":
          this.event.type = 2;
          this.event.options = {
            hpMin: 5,
            hpMax: 15,
            type: "win_life_all",
          };
          break;
        case "random_student":
          this.event.type = 3;
          this.event.options = { type: "win_life_all" };
          break;
        case "random_type_character":
          this.event.type = 7;
          this.event.options = { type: "random_type_character" };
          break;

        case "action_one_hp_gold":
          this.event.type = 8;
          this.event.options = {
            hpMin: 5,
            hpMax: 15,
            goldMin: 50,
            goldMax: 200,
            type: "action_one_hp_gold",
          };
          break;
        case "action_one_xp":
          this.event.type = 9;
          this.event.options = {
            xpMin: 10,
            xpMax: 20,
            type: "action_one_xp",
          };
          break;
        case "win_lose_gold_one":
          this.event.type = 10;
          this.event.options = {
            goldMin: 50,
            goldMax: 200,
            mult: 1,
            type: "win_lose_gold_one",
          };
          break;
        case "interactive":
          this.event.type = 12;
          this.event.options = {
            type: "interactive",
            textOK: "",
            goldMin: 50,
            goldMax: 200,
            textKO: "",
            hpMin: 1,
            hpMax: 15,
          };
          break;
        default:
          this.event.options = { type: "common" };
          break;
      }
    },
    addEvent(type) {
      if (type == 0) {
        if (this.event.title != "" && this.event.content != "") {
          if (
            (this.event.options.type == "win_life_one" ||
              this.event.options.type == "win_life_all") &&
            this.event.options.hpMin > 0
          ) {
            this.event.options.hpMin *= -1;
            this.event.options.hpMax *= -1;
          }
          axios
            .post("/classroom/events/add", { event: this.event })
            .then((response) => {
              location.reload();
            });
        }
      } else {
        if (
          (this.event.options.type == "win_life_one" ||
            this.event.options.type == "win_life_all") &&
          this.event.options.hpMin > 0
        ) {
          this.event.options.hpMin *= -1;
          this.event.options.hpMax *= -1;
        }
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
      this.event.options = { type: "common" };
      this.isModalActive = true;
    },
    editModal(editEvent) {
      this.event.id = editEvent.id;
      this.event.title = editEvent.title;
      this.event.content = editEvent.content;
      this.event.type = editEvent.type;
      this.event.options = JSON.parse(editEvent.options);
      if (
        (this.event.options.type == "win_life_one" ||
          this.event.options.type == "win_life_all") &&
        this.event.options.hpMin < 0
      ) {
        this.event.options.hpMin *= -1;
        this.event.options.hpMax *= -1;
      }
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