<template>
  <div class="p-2">
    <button class="button is-link mb-5" @click="isModalActive = true">
      <i class="fas fa-sparkles mr-2"></i>
      {{ trans.get("skills.new") }}
    </button>
    <button class="button is-primary mb-5">
      {{ trans.get("skills.import_default") }}
    </button>

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
                <span>{{ trans.get('skills.active') }}</span>
              </b-radio-button>

              <b-radio-button
                v-model="skill.type"
                :native-value="1"
                type="is-info"
              >
                <span>{{ trans.get('skills.passive') }}</span>
              </b-radio-button>
            </b-field>
            <article class="message is-warning">
              <div class="message-body" v-html="getType()">
              </div>
            </article>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="
                isModalActive = false;
                resetMonster();
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

    <SelectSkill :code="code" v-model="skill.icon" v-if="isImageModalActive"> </SelectSkill>
  </div>
</template>

<script>
import Utils from "../../utils.js";

import SelectSkill from "../utils/SelectSkill.vue";

export default {
  props: ["code", "skills"],

  created() {},
  data: function () {
    return {
      isLoading: false,
      isModalActive: false,
      isImageModalActive: false,
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
    getType() {
      return this.skill.type == 0
        ? this.trans.get("skills.active_info")
        : this.trans.get("skills.passive_info");
    },
    // resetMonster: function () {
    //   this.edit = false;
    //   this.monster = {
    //     image: null,
    //     name: "",
    //     reward_xp: 0,
    //     reward_gold: 0,
    //   };
    // },
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
    //       this.resetMonster();
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
          this.skills.push(response.data);
          this.$forceUpdate();
        });
    },
    // getName(name) {
    //   if (name) return name + " 🍅🍖";
    //   else return "🍅🍖";
    // },
    // deleteItem(id) {
    //   this.$buefy.dialog.confirm({
    //     title: this.trans.get("general.delete"),
    //     message: this.trans.get("general.confirm_delete"),
    //     confirmText: this.trans.get("general.delete"),
    //     cancelText: this.trans.get("general.cancel"),
    //     type: "is-danger",
    //     hasIcon: true,
    //     icon: "times-circle",
    //     iconPack: "fa",
    //     ariaRole: "alertdialog",
    //     ariaModal: true,
    //     onConfirm: () => {
    //       var index = this.monsters.findIndex(function (monster, i) {
    //         return monster.id === id;
    //       });
    //       axios.delete("/classroom/monsters/" + id).then((response) => {
    //         if (response.data === 1) {
    //           this.monsters.splice(index, 1);
    //           this.$forceUpdate();
    //         }
    //       });
    //     },
    //   });
    // },
  },
};
</script>