<template>
  <div>
    <div class="p-2" v-if="!selectedCollection">
      <button @click="isModalActive = true" class="button is-dark">
        __ Add collection
      </button>
      <div class="p-2">
        <div
          class="collection mx-1 cursor-pointer"
          v-for="collection in collectionsReactive"
          :key="collection.id"
          @click="selectedCollection = collection"
        >
          <img src="/img/cardgen/collections/back_small.png" @contextmenu.prevent="" />
          <h1 class="is-size-4 rounded border py-4">{{ collection.name }}</h1>
        </div>
      </div>
      <b-modal
        :active.sync="isModalActive"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-modal
      >
        <form @submit.prevent="addCollection">
          <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
              <p class="modal-card-title">
                <i class="fak fa-collection mr-2"></i
                >{{ trans.get("collection.new_collection") }}
              </p>
            </header>
            <section class="modal-card-body">
              <b-field :label="trans.get('collection.name')" class="mt-4">
                <b-input
                  v-model="collection.name"
                  maxlength="50"
                  required
                ></b-input>
              </b-field>
              <div class="columns">
                <div class="column">
                  <b-field>
                    <template slot="label">
                      {{ trans.get("collection.xp") }}
                      <i class="fas fa-fist-raised colored"></i>
                    </template>
                    <b-input
                      v-model="collection.xp"
                      required
                      type="number"
                      step="0.1"
                    ></b-input>
                  </b-field>
                </div>
                <div class="column">
                  <b-field>
                    <template slot="label">
                      {{ trans.get("collection.gold") }}
                      <i class="fas fa-coins colored"></i> %
                    </template>
                    <b-input
                      v-model="collection.gold"
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
                @click="isModalActive = false"
              >
                {{ trans.get("general.close") }}
              </button>
              <button class="button is-primary">
                {{ trans.get("general.add") }}
              </button>
              <!-- <button @click.prevent="sendEdit" v-else class="button is-link">
              {{ trans.get("general.edit") }}
            </button> -->
            </footer>
          </div>
        </form>
      </b-modal>
    </div>
    <div class="p-2" v-else>
      <button @click="selectedCollection = null" class="button is-info">
        <i class="fas fa-arrow-left"></i>
      </button>
      <button
        @click="isModalCollectionableActive = true"
        class="button is-dark"
      >
        __ Add collectionable
      </button>
      <h1 class="is-size-1">{{ selectedCollection.name }}</h1>
      <div class="p-2">
        <div
          class="collectionable mx-1 cursor-pointer"
          v-for="collectionable in selectedCollection.collectionables"
          :key="collectionable.id"
        >
          <img
            width="200px"
            class="top-collection"
            @contextmenu.prevent=""
            :src="getImageCollectionable(collectionable.type)"
          />
          <img
            width="200px"
            class="bg-collection"
            @contextmenu.prevent=""
            src="/img/cardgen/collections/bg.png"
          />
          <img
            width="200px"
            @contextmenu.prevent=""
            class="img-collection rounded"
            :src="collectionable.src"
          />
          <h1 class="is-size-6">
            {{ collectionable.name }}
          </h1>
        </div>
      </div>
      <b-modal
        :active.sync="isModalCollectionableActive"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-modal
      >
        <form @submit.prevent="addCollectionable">
          <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
              <p class="modal-card-title">
                <i class="fak fa-collection mr-2"></i
                >{{ trans.get("collection.new_collectionable") }}
              </p>
            </header>
            <section class="modal-card-body">
              <croppa
                class="card-shadow-s"
                v-model="image"
                :width="300"
                :height="300"
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
              ></croppa>
              <!-- :initial-image="prevImage" -->
              <b-field :label="trans.get('collection.name')" class="mt-4">
                <b-input
                  v-model="collectionable.name"
                  maxlength="50"
                  required
                ></b-input>
              </b-field>
              <b-field>
                <b-field :label="trans.get('collection.type')">
                  <b-select
                    v-model="collectionable.type"
                    placeholder="__Select a type"
                    required
                    expanded
                  >
                    <option value="1">__Earth</option>
                    <option value="2">__Wind</option>
                    <option value="3">__Water</option>
                    <option value="4">__Fire</option>
                  </b-select>
                </b-field>
              </b-field>
            </section>
            <footer class="modal-card-foot">
              <button
                class="button"
                type="button"
                @click="isModalCollectionableActive = false"
              >
                {{ trans.get("general.close") }}
              </button>
              <button class="button is-primary">
                {{ trans.get("general.add") }}
              </button>
              <!-- <button @click.prevent="sendEdit" v-else class="button is-link">
              {{ trans.get("general.edit") }}
            </button> -->
            </footer>
          </div>
        </form>
      </b-modal>
    </div>
  </div>
</template>

<script>
export default {
  props: ["code", "collections"],
  created() {
    this.collectionsReactive = this.collections;
  },
  data: function () {
    return {
      image: {},
      collectionsReactive: [],
      selectedCollection: null,
      isModalActive: false,
      isModalCollectionableActive: false,
      collection: {
        name: "",
        xp: 100,
        gold: 1000,
        type: 1,
      },
      collectionable: {
        name: "",
        type: 1,
      },
    };
  },
  methods: {
    getImageCollectionable(type) {
      switch (type) {
        case 1:
          return "/img/cardgen/collections/front-earth.png";
        case 2:
          return "/img/cardgen/collections/front-wind.png";
        case 3:
          return "/img/cardgen/collections/front-water.png";
        case 4:
          return "/img/cardgen/collections/front-fire.png";
      }
    },
    addCollection() {
      axios
        .post("/classroom/" + this.code + "/collections", {
          collection: this.collection,
        })
        .then((response) => {
          console.log(response.data);
          this.collectionsReactive = response.data;
          this.isModalActive = false;
          this.$forceUpdate();
        });
    },
    addCollectionable() {
      let formData = new FormData();
      formData.append("collection_id", this.selectedCollection.id);
      formData.append("name", this.collectionable.name);
      formData.append("type", this.collectionable.type);

      this.image.generateBlob(
        (blob) => {
          if (!blob) return false;

          formData.append("image", blob, "collectionable.png");

          axios
            .post("/classroom/" + this.code + "/collectionable", formData)
            .then((response) => {
              this.selectedCollection = response.data;
              this.isModalCollectionableActive = false;
              this.$forceUpdate();
            });
        },
        "image/png",
        0.8
      );
    },
  },
};
</script>
<style>
.collection {
  width: 200px;
  position: relative;
  display: inline-block;
}
.collection h1 {
  position: absolute;
  bottom: 20px;
  left: 0;
  margin: 0 10px;
  background-color: rgba(255, 255, 255, 0.8);
  width: 90%;
  text-align: center;
}
.collectionable {
  width: 200px;
  height: 280px;
  position: relative;
  display: inline-block;
}
.img-collection {
  width: 150px;
  position: absolute;
  z-index: 2;
  left: 25px;
  top: 45px;
   filter: drop-shadow(0rem 0rem 3px rgb(255, 255, 255));
}
.collectionable h1 {
  position: absolute;
  bottom: 30px;
  left: 0;
  margin: 0 10px;
  width: 90%;
  text-align: center;
  color: white;
  text-shadow: 1px 1px 1px black;
  z-index: 2;
}
.top-collection {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
}
.bg-collection {
  z-index: 0;
  position: absolute;
  top: 0;
  left: 0;
}
</style>
