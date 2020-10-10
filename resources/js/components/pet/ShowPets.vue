<template>
  <div>
    <button class="button is-link mb-4" @click="isModalActive = true">
      <i class="fas fa-dog has-margin-right-2"></i>
      {{ trans.get("pets.new_pet") }}
    </button>

    <div
      v-for="pet in pets"
      class="columns is-multiline is-variable is-1 has-all-centered has-padding-3"
      style="border-bottom: 1px dashed #999"
      v-bind:key="pet.id"
    >
      <div class="column is-narrow is-relative">
        <img :src="'/img/pets/' + pet.image" class="pet-selector" />
      </div>
      <div class="column is-narrow">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div class="field has-addons">
                <p class="control">
                  <a class="button is-static">
                    <i class="fas fa-heart colored mr-2"></i> %
                  </a>
                </p>
                <p class="control is-expanded">
                  <input
                    type="number"
                    disabled
                    class="input"
                    style="border: 1px solid"
                    v-model="pet.hp_boost"
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
                    <i class="fas fa-fist-raised colored mr-2"></i> %
                  </a>
                </p>
                <p class="control is-expanded">
                  <input
                    type="number"
                    class="input"
                    disabled
                    style="border: 1px solid"
                    v-model="pet.xp_boost"
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
                    <i class="fas fa-coins colored mr-2"></i> %
                  </a>
                </p>
                <p class="control is-expanded">
                  <input
                    type="number"
                    class="input"
                    disabled
                    style="border: 1px solid"
                    v-model="pet.gold_boost"
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
                    Price
                    <i class="fas fa-coins colored"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input
                    type="number"
                    class="input"
                    disabled
                    style="border: 1px solid"
                    v-model="pet.price"
                  />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="column is-narrow">
        <div class="field">
          <b-switch
            v-model="pet.for_sale"
            @input="updateForSale(pet)"
            true-value="1"
            false-value="0"
            >For sale?</b-switch
          >
        </div>
      </div>

      <!-- <a :href="'/classroom/' + code + '/shop/' + item.id" class="button">
        <i class="fas fa-edit"></i>
      </a>
      <button
        class="button is-danger has-margin-left-2"
        @click="deleteItem(item.id)"
      >
        <i class="fas fa-trash-alt"></i>
      </button> -->
    </div>

    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addPet">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              <i class="fas fa-dog has-margin-right-2"></i
              >{{ trans.get("pets.new_pet") }}
            </p>
          </header>
          <section class="modal-card-body">
            <b-field>
              <button
                ref="selectbutton"
                @click.prevent="selectImage"
                style="z-index: 5"
                class="button is-link mr-2"
              >
                <i class="fas fa-image mr-2"></i>
                {{ trans.get("pets.image") + " *" }}
              </button>
              <img
                :src="'/img/pets/' + pet.image"
                v-if="pet.image"
                class="pet-selector"
              />
            </b-field>
            <b-field :label="trans.get('pets.name')" class="has-margin-top-4">
              <b-input
                v-model="pet.name"
                maxlength="40"
                placeholder="Careful cat"
              ></b-input>
            </b-field>
            <div class="columns">
              <div class="column">
                <b-field>
                  <template slot="label">
                    {{ trans.get("pets.xx_boost") }}
                    <i class="fas fa-heart colored"></i> %
                  </template>
                  <b-input
                    v-model="pet.hp_boost"
                    required
                    type="number"
                    step="0.1"
                  ></b-input>
                </b-field>
              </div>
              <div class="column">
                <b-field>
                  <template slot="label">
                    {{ trans.get("pets.xx_boost") }}
                    <i class="fas fa-fist-raised colored"></i> %
                  </template>
                  <b-input
                    v-model="pet.xp_boost"
                    required
                    type="number"
                    step="0.1"
                  ></b-input>
                </b-field>
              </div>
              <div class="column">
                <b-field>
                  <template slot="label">
                    {{ trans.get("pets.xx_boost") }}
                    <i class="fas fa-coins colored"></i> %
                  </template>
                  <b-input
                    v-model="pet.gold_boost"
                    required
                    type="number"
                    step="0.1"
                  ></b-input>
                </b-field>
              </div>
            </div>
            <b-field>
              <template slot="label">
                {{ trans.get("pets.price") }}
                <i class="fas fa-coins colored"></i>
              </template>
              <b-input
                v-model="pet.price"
                required
                type="number"
                step="0.1"
              ></b-input>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isModalActive = false">
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-primary">
              {{ trans.get("general.add") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>

    <b-modal
      :active.sync="isImageModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("pets.image") }}</p>
        </header>
        <section class="modal-card-body is-relative">
          <div class="columns is-multiline" v-if="images">
            <img
              width="75px"
              @click="
                pet.image = image;
                isImageModalActive = false;
              "
              v-for="image in images"
              :key="image"
              :src="'/img/pets/' + image"
            />
            <!-- <span class="m-2" v-for="image in images"
              :key="image">{{ image }}</span> -->
          </div>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow">
            <button
              class="button"
              type="button"
              @click="isImageModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
          </div>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
import Utils from "../../utils.js";

export default {
  props: ["code", "pets"],

  created() {},
  data: function () {
    return {
      isModalActive: false,
      isImageModalActive: false,
      images: null,
      pet: {
        image: null,
        hp_boost: 0,
        gold_boost: 0,
        xp_boost: 0,
        price: 0,
      },
    };
  },
  methods: {
    selectImage: function (e) {
      this.$refs.selectbutton.classList.remove('is-danger')
      e.target.classList.add("is-loading");
      if (this.images == null)
        axios.get("/classroom/pets/get").then((response) => {
          this.images = response.data;
          this.isImageModalActive = true;
          e.target.classList.remove("is-loading");
        });
      else {
        this.isImageModalActive = true;
        e.target.classList.remove("is-loading");
      }
    },
    addPet: function () {
      if(this.pet.image == null) {
        this.$refs.selectbutton.classList.add('is-danger')
        return false;
      }
      axios.post("/classroom/" + this.code + "/pets", { pet: this.pet }).then((response) => {
        console.log("success");
      });
    },
  },
};
</script>