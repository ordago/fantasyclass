<template>
  <div class="p-2">
    <button class="button is-link mb-5" @click="isModalActive = true">
      <i class="fas fa-sparkles mr-2"></i>
      {{ trans.get("skills.new") }}
    </button>
    <button
      v-if="mutableSkills.length < 6"
      @click="importDefault"
      class="button is-primary mb-5"
    >
      {{ trans.get("skills.import_default") }}
    </button>
    <button class="button is-dark mb-5" @click="isPrefsModalActive = true">
      <i class="fas fa-cog mr-2"></i> {{ trans.get("menu.config") }}
    </button>

    <article class="message is-warning m-2">
      <div class="message-body has-text-justified">{{ trans.get("skills.info") }}</div>
    </article>

    <b-table
      v-if="mutableSkills.length"
      :data="mutableSkills"
      :default-sort="['name', 'desc']"
      icon-pack="fas"
      sort-icon="arrow-up"
    >
      <template slot-scope="props">
        <b-table-column
          field="icon"
          style="width: 80px"
          :label="trans.get('skills.image')"
          centered
        >
          <img class="rounded" :src="props.row.icon" />
        </b-table-column>

        <b-table-column
          field="title"
          :label="trans.get('skills.name')"
          sortable
          >{{ trans.get(props.row.name) }}</b-table-column
        >

        <b-table-column
          field="description"
          :label="trans.get('skills.description')"
          sortable
          >{{ trans.get(props.row.description) }}</b-table-column
        >

        <b-table-column
          field="hp"
          :label="trans.get('skills.type')"
          sortable
          centered
        >
          {{
            props.row.type == 0
              ? trans.get("skills.active")
              : trans.get("skills.passive")
          }}
        </b-table-column>

        <b-table-column
          field="name"
          :label="trans.get('menu.settings')"
          centered
        >
          <a class="button is-info is-small">
            <i class="fas fa-edit"></i>
          </a>
          <b-button type="is-danger is-small" @click="deleteItem(props.row.id)">
            <i class="fas fa-trash-alt"></i>
          </b-button>
        </b-table-column>
      </template>
    </b-table>

    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addSkill">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              <i class="fas fa-sparkles mr-2"></i>{{ trans.get("skills.new") }}
            </p>
          </header>
          <section class="modal-card-body">
            <b-field>
              <button
                ref="selectbutton"
                @click.prevent="selectImage"
                style="z-index: 5"
                class="button is-link mr-2"
                :class="{ 'is-loading': isLoading }"
              >
                <i class="fas fa-image mr-2"></i>
                {{ trans.get("skills.image") + " *" }}
              </button>
              <img
                width="60px"
                :src="skill.icon"
                v-if="skill.icon"
                class="rounded"
              />
            </b-field>
            <b-field :label="trans.get('skills.name')" class="mt-4">
              <b-input
                v-model="skill.name"
                maxlength="40"
                required
                placeholder=""
              ></b-input>
            </b-field>
            <b-field :label="trans.get('skills.description')" class="mt-4">
              <b-input
                v-model="skill.description"
                required
                placeholder=""
              ></b-input>
            </b-field>
            <b-field>
              <b-radio-button
                v-model="skill.type"
                :native-value="0"
                type="is-link"
              >
                <span>{{ trans.get("skills.active") }}</span>
              </b-radio-button>

              <b-radio-button
                v-model="skill.type"
                :native-value="1"
                type="is-info"
              >
                <span>{{ trans.get("skills.passive") }}</span>
              </b-radio-button>
            </b-field>
            <article class="message is-warning">
              <div class="message-body" v-html="getType()"></div>
            </article>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="
                isModalActive = false;
                resetSkill();
              "
            >
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-primary" v-if="!edit">
              {{ trans.get("general.add") }}
            </button>
            <button @click.prevent="sendEdit" v-else class="button is-link">
              {{ trans.get("general.edit") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>

    <SelectSkill :code="code" v-model="skill.icon" v-if="isImageModalActive">
    </SelectSkill>

    <b-modal
      :active.sync="isPrefsModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="updatePrefs">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">{{ trans.get("skills.config") }}</p>
          </header>
          <section class="modal-card-body">
            <div class="field">
              <label class="label">{{ trans.get("skills.price") }}</label>
              <div class="control">
                <input
                  class="input"
                  type="number"
                  v-model="settings.skill_price"
                />
              </div>
            </div>
            <div class="field">
              <b-switch
                true-value="1"
                false-value="0"
                v-model="settings.skill_enabled"
                >{{ trans.get("skills.enabled") }}</b-switch
              >
            </div>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="isPrefsModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-primary" @click="updatePrefs">
              {{ trans.get("general.update") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
import Utils from "../../utils.js";

import SelectSkill from "../utils/SelectSkill.vue";

export default {
  props: ["code", "skills", "settings"],

  created() {
    this.mutableSkills = this.skills;
  },
  data: function () {
    return {
      isLoading: false,
      isModalActive: false,
      isImageModalActive: false,
      isPrefsModalActive: false,
      images: null,
      edit: false,
      skill: {
        icon: null,
        name: "",
        description: null,
        properties: null,
        type: 0,
      },
    };
  },
  components: {
    SelectSkill,
  },
  methods: {
    updatePrefs() {
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "skill_price",
        value: this.settings.skill_price,
        action: "update",
      });
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "skill_enabled",
        value: this.settings.skill_enabled,
        action: "update",
      });
      this.isPrefsModalActive = false;
    },
    getType() {
      return this.skill.type == 0
        ? this.trans.get("skills.active_info")
        : this.trans.get("skills.passive_info");
    },
    resetSkill: function () {
      this.edit = false;
      this.skill = {
        icon: null,
        name: "",
        description: null,
        properties: null,
        type: 0,
      };
    },
    importDefault() {
      axios
        .get("/classroom/" + this.code + "/skills/import")
        .then((response) => {
          this.mutableSkills = response.data;
          this.$forceUpdate();
          this.$toast(this.trans.get("success_error.import_success"), {
            type: "success",
          });
        });
    },
    selectImage: function (e) {
      this.$refs.selectbutton.classList.remove("is-danger");
      this.isLoading = true;
      this.isImageModalActive = true;
    },

    // editMonster: function (monster) {
    //   this.edit = true;
    //   this.monster = monster;
    //   this.isModalActive = true;
    // },
    // sendEdit: function () {
    //   axios
    //     .patch("/classroom/" + this.code + "/skills", {
    //       monster: this.monster,
    //     })
    //     .then((response) => {
    //       this.isModalActive = false;
    //       this.resetSkill();
    //     });
    // },
    addSkill: function () {
      if (this.skill.icon == null) {
        this.$refs.selectbutton.classList.add("is-danger");
        return false;
      }
      axios
        .post("/classroom/" + this.code + "/skill", {
          skill: this.skill,
        })
        .then((response) => {
          this.isModalActive = false;
          this.mutableSkills.push(response.data);
          this.$toast(this.trans.get("success_error.add_success"), {
            type: "success",
          });
          this.$forceUpdate();
        });
    },
    // getName(name) {
    //   if (name) return name + " 🍅🍖";
    //   else return "🍅🍖";
    // },
    deleteItem(id) {
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
          var index = this.mutableSkills.findIndex(function (skill, i) {
            return skill.id === id;
          });
          axios.delete("/classroom/skills/" + id).then((response) => {
            if (response.data === 1) {
              this.mutableSkills.splice(index, 1);
              this.$toast(this.trans.get("success_error.delete_success"), {
                type: "success",
              });

              this.$forceUpdate();
            }
          });
        },
      });
    },
  },
};
</script>