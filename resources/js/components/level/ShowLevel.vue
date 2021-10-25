<template>
  <div
    v-if="level"
    :class="{
      'column is-6-tablet is-12-mobile is-3-desktop mb-0 is-flex has-all-centered':
        edit,
      column: !edit,
    }"
    :style="getStyle()"
  >
    <div
      :class="{ 'min-width': !edit }"
      class="columns w-100 is-variable is-0 py-2 is-relative"
    >
      <div
        class="
          column
          is-narrow
          py-0
          card-shadow-s
          rounded-left
          has-background-light
        "
      >
        <figure class="image is-128x128">
          <label class="cursor-pointer" :for="'file' + level.id">
            <croppa
              class="p-2 card-shadow-s is-full-rounded"
              v-model="image"
              :width="128"
              :height="128"
              :quality="1"
              style="z-index: 15"
              accept="image/*"
              placeholder="Image"
              :placeholder-font-size="16"
              canvas-color="transparent"
              :show-remove-button="true"
              remove-button-color="black"
              :show-loading="true"
              :loading-size="50"
              :initial-image="prevImage"
              v-if="edit"
            ></croppa>
            <img
              v-else
              class="p-2 card-shadow-s is-full-rounded"
              :src="prevImage"
            />
          </label>
        </figure>
        <b-progress
          style="position: absolute; bottom: -10px; color: black !important; z-index: 1000!important"
          class="w-100"
          :type="{
            'is-warning': getValue() < 50,
            'is-info': getValue() < 100,
            'is-success': getValue() == 100,
          }"
          v-if="!edit"
          :value="getValue()"
          show-value
          format="percent"
        ></b-progress>
      </div>
      <div class="column content card p-4 rounded-right card-shadow-s">
        <p class="is-size-4">
          {{ trans.get("levels.level") }} {{ level.number }}
        </p>
        <p class="my-2" v-if="edit">
          <i class="fas fa-fist-raised colored"></i>
          {{ trans.get("levels.xp") }}
        </p>
        <h2 v-if="!edit">{{ level.title }}</h2>
        <p v-if="!edit">{{ level.description }}</p>

        <input
          type="number"
          v-if="edit"
          v-model="level.xp"
          class="input w-100"
        />
        <p class="my-2" v-if="edit">{{ trans.get("levels.title") }}</p>
        <input
          v-model="level.title"
          v-if="edit"
          type="text"
          class="input w-100"
        />
        <p class="my-2" v-if="edit">{{ trans.get("levels.description") }}</p>
        <p v-if="edit">
          <textarea
            class="input"
            rows="20"
            style="height: 100px"
            v-model="level.description"
          ></textarea>
        </p>
        <div>
          <span class="mx-1" v-if="level.gold">
          {{ level.gold }} <i class="fas fa-coins colored"></i>
          </span>
          <span class="mx-1" v-if="level.pet">
            1 <i class="fas fa-dog"></i>
          </span>
          <span class="mx-1" v-if="level.collectible">
            1 <i class="fak fa-collection"></i>
          </span>
          <span class="mx-1" v-if="level.card">
            1 <i class="fak fa-deck"></i>
          </span>
          <span class="mx-1" v-if="level.badge">
            1 <i class="fas fa-award"></i>
          </span>
          <span class="mx-1" v-if="level.item">
            1 <i class="fas fa-store"></i>
          </span>
        </div>
        <div v-if="edit" class="has-text-right mt-2">
          <button
            class="button is-dark"
            @click="showRewards"
            v-if="level.xp > 0"
            v-tippy
            :content="trans.get('menu.rewards')"
          >
            <i class="fas fa-treasure-chest"></i>
          </button>
          <button
            class="button is-primary"
            @click="update"
            v-tippy
            :content="trans.get('general.save')"
          >
            <i class="fas fa-save"></i>
          </button>
          <button
            class="button is-danger"
            v-tippy
            :content="trans.get('general.delete')"
            @click="remove"
            v-if="last"
          >
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </div>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("menu.rewards") }} ({{ trans.get('levels.level') }} {{ level.number }})</p>
        </header>
        <section class="modal-card-body">
          <label class="label">{{ trans.get("students.gold") }} <i class="fas fa-coins colored"></i></label>
          <div class="field is-horizontal">
            <div class="field-body">
              <div class="field is-narrow">
                <div class="control">
                    <input
                      type="number"
                      v-model="level.gold"
                      value="0"
                      class="input"
                    />
                </div>
              </div>
            </div>
          </div>
          <label class="label mt-3">{{ trans.get("menu.pets") }}</label>
          <div class="control">
            <label class="radio">
              <input
                type="radio"
                v-model="level.pet"
                :value="null"
                name="pet"
              />
              <i class="fas fa-empty-set fs-2"></i>
            </label>
            <label class="radio" v-for="pet in pets" :key="'pet-' + pet.id">
              <input
                type="radio"
                :value="pet.id"
                v-model="level.pet"
                name="pet"
              />
              <img
                class="rounded"
                :src="pet.image"
                width="45px"
                v-tippy
                :content="pet.name"
              />
            </label>
          </div>
          <label class="label mt-3">{{ trans.get("menu.shop") }}</label>
          <div class="control">
            <label class="radio">
              <input
                type="radio"
                name="item"
                v-model="level.item"
                :value="null"
              />
              <i class="fas fa-empty-set fs-2"></i>
            </label>
            <label class="radio" v-for="item in items" :key="'item-' + item.id">
              <input
                type="radio"
                name="item"
                :value="item.id"
                v-model="level.item"
              />
              <img class="rounded" :src="item.icon" width="45px" />
            </label>
          </div>

          <label class="label mt-3">{{ trans.get("menu.badges") }}</label>
          <div class="field is-horizontal">
            <div class="field-body">
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                    <select v-model="level.badge">
                      <option :value="null">∅</option>
                      <option
                        v-for="badge in badges"
                        :key="'badge-' + badge.id"
                        :value="badge.id"
                      >
                        {{ badge.title }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <label class="label mt-3">{{ trans.get("menu.cards") }}</label>
          <div class="field is-horizontal">
            <div class="field-body">
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                    <select v-model="level.card">
                      <option :value="null">∅</option>
                      <option
                        v-for="card in cards"
                        :key="'card-' + card.id"
                        :value="card.id"
                      >
                        {{ trans.get(card.title) }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <label class="label mt-3">{{ trans.get("menu.collections") }}</label>
          <div class="field is-horizontal">
            <div class="field-body">
              <div class="field is-narrow">
                <div class="control">
                  <div class="select is-fullwidth">
                    <select v-model="level.collectible">
                      <option :value="null">∅</option>
                      <optgroup
                        v-for="collection in collections"
                        :key="'collection-' + collection.id"
                        :label="collection.name"
                      >
                        <option
                          v-for="collectible in collection.collectionables"
                          :key="'collectible-' + collectible.id"
                          :value="collectible.id"
                        >
                          {{ trans.get(collectible.name) }}
                        </option>
                      </optgroup>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isModalActive = false">
            {{ trans.get("general.close") }}
          </button>
          <button
            class="button is-success"
            :class="{ 'is-loading': isLoading }"
            type="button"
            @click="sendRewards"
          >
            <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
          </button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  // props: ["level", "last", "code", "edit", "resize"],
  props: {
    userxp: Number,
    level: Object,
    last: Boolean,
    code: String,
    edit: Boolean,
    resize: {
      type: Boolean,
      default: false,
    },
  },
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if (this.level) {
      this.prevImage = this.level.imagelvl;
    }
  },
  data: function () {
    return {
      csrfToken: null,
      prevImage: null,
      image: null,
      isModalActive: false,
      isLoading: false,
      pets: null,
      items: null,
      cards: null,
      badges: null,
      collections: null,
    };
  },
  methods: {
    sendRewards: function () {
      this.isLoading = true;
      axios
        .patch("/classroom/levels/reward/" + this.level.id, {
          pet: this.level.pet,
          badge: this.level.badge,
          item: this.level.item,
          card: this.level.card,
          collectible: this.level.collectible,
          gold: this.level.gold,
        })
        .then((response) => {
          this.isModalActive = false;
          this.isLoading = false;
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
        });
    },
    showRewards: function () {
      axios
        .post("/classroom/" + this.code + "/levels/getRewards")
        .then((response) => {
          this.pets = response.data.pets;
          this.items = response.data.items;
          this.cards = response.data.cards;
          this.badges = response.data.badges;
          this.collections = response.data.collections;
          this.isModalActive = true;
        });
    },
    getValue: function () {
      if (!this.level.nextlvl) return 100;
      return (this.userxp * 100) / this.level.nextlvl;
    },
    update: function () {
      this.image.generateBlob(
        (blob) => {
          // form data
          var formData = new FormData();
          if (blob) formData.append("logo", blob, "logo.png");
          formData.append("id", this.level.id);
          formData.append("title", this.level.title ? this.level.title : "");
          formData.append(
            "description",
            this.level.description ? this.level.description : ""
          );
          formData.append("xp", this.level.xp);
          formData.append("_method", "patch");
          axios
            .post("/classroom/levels/" + this.level.id, formData, {
              headers: {
                "content-type": "multipart/form-data",
              },
            })
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });
            });
        },
        "image/png",
        0.8
      );
    },
    getStyle() {
      if (this.resize) return "zoom: 60%;";
    },
    remove: function () {
      axios.delete("/classroom/level/" + this.level.id).then((response) => {
        this.$parent.levels.pop();
        this.$parent.$forceUpdate();
      });
    },
  },
};
</script>
<style>
.min-width {
  min-width: 400px;
}
.progress-wrapper .progress-value {
  color: black !important;
}
</style>