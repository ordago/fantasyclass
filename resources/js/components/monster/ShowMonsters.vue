<template>
  <div class="p-2">
    <button class="button is-link mb-5" @click="isModalActive = true">
      <i class="fas fa-dragon mr-2"></i>
      {{ trans.get("monsters.new") }}
    </button>

    <div
      v-for="monster in monsters"
      class="columns is-multiline is-variable is-1 has-all-centered p-3 has-hr"
      v-bind:key="monster.id"
    >
      <div class="column is-narrow is-relative">
        <img
          v-tippy="{
            theme: 'light bordered',
            placement: 'bottom',
            arrow: true,
          }"
          width="81px"
          :content="getName(monster.name)"
          :src="monster.image"
          class=""
          style="margin-top: -20px"
        />
      </div>
      <div class="column is-narrow" style="width: 200px">
        <hp :size="2" :hp="monster.hp"></hp>
      </div>
      <div class="column is-narrow">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div class="field has-addons">
                <p class="control">
                  <a class="button is-static">
                    <i class="fas fa-fist-raised colored mr-2"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input
                    type="number"
                    disabled
                    class="input"
                    style="border: 1px solid"
                    v-model="monster.reward_xp"
                  />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column is-narrow">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div class="field has-addons">
                <p class="control">
                  <a class="button is-static">
                    <i class="fas fa-coins colored mr-2"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input
                    type="number"
                    class="input"
                    disabled
                    style="border: 1px solid"
                    v-model="monster.reward_gold"
                  />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <button class="button ml-2" @click="editMonster(monster)">
        <i class="fas fa-edit"></i>
      </button>
      <button class="button is-danger ml-2" @click="deleteItem(monster.id)">
        <i class="fas fa-trash-alt"></i>
      </button>
    </div>

    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addMonster">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              <i class="fas fa-dragon mr-2"></i>{{ trans.get("monsters.new") }}
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
                {{ trans.get("monsters.image") + " *" }}
              </button>
              <img
                width="81px"
                :src="monster.image"
                v-if="monster.image"
                class="pet-selector"
              />
            </b-field>
            <b-field :label="trans.get('monsters.name')" class="mt-4">
              <b-input
                v-model="monster.name"
                maxlength="40"
                required
                placeholder="Careful cat"
              ></b-input>
            </b-field>
            <div class="my-2" v-if="edit">
              <b-field>
                <template slot="label">
                  {{ trans.get("monsters.hp") }}
                  <i class="fas fa-heart colored"></i>
                </template>
                <b-input
                  v-model="monster.hp"
                  required
                  type="number"
                  :max="100"
                  :min="0"
                  step="1"
                ></b-input>
              </b-field>
            </div>
            <div class="columns">
              <div class="column">
                <b-field>
                  <template slot="label">
                    {{ trans.get("monsters.reward_xx") }}
                    <i class="fas fa-fist-raised colored"></i>
                  </template>
                  <b-input
                    v-model="monster.reward_xp"
                    required
                    type="number"
                    step="0.1"
                  ></b-input>
                </b-field>
              </div>
              <div class="column">
                <b-field>
                  <template slot="label">
                    {{ trans.get("monsters.reward_xx") }}
                    <i class="fas fa-coins colored"></i>
                  </template>
                  <b-input
                    v-model="monster.reward_gold"
                    required
                    type="number"
                    step="0.1"
                  ></b-input>
                </b-field>
              </div>
            </div>
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
            <button @click.prevent="sendEdit" v-else class="button is-primary">
              <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>

    <SelectPet :code="code" v-model="monster.image" v-if="isImageModalActive"> </SelectPet>
  </div>
</template>

<script>
import Utils from "../../utils.js";

import SelectPet from "../utils/SelectPet.vue";

export default {
  props: ["code", "monsters"],

  created() {},
  data: function () {
    return {
      isLoading: false,
      isModalActive: false,
      isImageModalActive: false,
      images: null,
      edit: false,
      monster: {
        image: null,
        name: "",
        reward_xp: 0,
        reward_gold: 0,
      },
    };
  },
  components: {
    SelectPet,
  },
  methods: {
    resetMonster: function () {
      this.edit = false;
      this.monster = {
        image: null,
        name: "",
        reward_xp: 0,
        reward_gold: 0,
      };
    },
    selectImage: function (e) {
      this.$refs.selectbutton.classList.remove("is-danger");
      this.isLoading = true;
      this.isImageModalActive = true;
    },

    editMonster: function (monster) {
      this.edit = true;
      this.monster = monster;
      this.isModalActive = true;
    },
    sendEdit: function () {
      axios
        .patch("/classroom/" + this.code + "/monsters", {
          monster: this.monster,
        })
        .then((response) => {
          this.isModalActive = false;
          this.resetMonster();
        });
    },
    addMonster: function () {
      if (this.monster.image == null) {
        this.$refs.selectbutton.classList.add("is-danger");
        return false;
      }
      axios
        .post("/classroom/" + this.code + "/monsters", {
          monster: this.monster,
        })
        .then((response) => {
          this.isModalActive = false;
          this.monsters.push(response.data);
          this.$forceUpdate();
        });
    },
    getName(name) {
      if (name) return name + " 🍅🍖";
      else return "🍅🍖";
    },
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
          var index = this.monsters.findIndex(function (monster, i) {
            return monster.id === id;
          });
          axios.delete("/classroom/monsters/" + id).then((response) => {
            if (response.data === 1) {
              this.monsters.splice(index, 1);
              this.$forceUpdate();
            }
          });
        },
      });
    },
  },
};
</script>