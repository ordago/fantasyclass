<template>
  <div>
    <button class="button is-link" @click="isModalActive = true">
      <i class="fas fa-dog has-margin-right-2"></i>
      {{ trans.get("pets.new_pet") }}
    </button>
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
            <b-field :label="trans.get('pets.image') + ' *'">
              <button class="button is-link">
                <i class="fas fa-image"></i>
              </button>
            </b-field>
            <img src="/img/pets/Pet-Alligator-Base.png" v-if="pet.image" class="pet-selector">
            <b-field :label="trans.get('pets.name')" class="has-margin-top-4">
              <b-input v-model="pet.name" maxlength="40" placeholder="Careful cat"></b-input>
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
  </div>
</template>

<script>
import Utils from "../../utils.js";

export default {
  props: ["code"],

  created() {},
  data: function () {
    return {
      isModalActive: false,
      pet: {
        image: null,
        hp: 100,
        hp_boost: 0,
        gold_boost: 0,
        xp_boost: 0,
        price: 0,
      },
    };
  },
  methods: {
    addPet: function () {},
  },
};
</script>