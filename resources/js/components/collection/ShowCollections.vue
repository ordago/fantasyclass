<template>
  <div>
    <div class="p-2" v-if="!selectedCollection">
      <button
        @click="
          isEditing = false;
          collection = {};
          isModalActive = true;
        "
        class="button is-dark"
      >
        __ Add collection
      </button>
      <div class="p-2">
        <div
          class="collection-container"
          v-for="collection in collectionsReactive"
          :key="collection.id"
        >
          <div class="collection mx-1 cursor-pointer" @click="selectedCollection = collection">
            <img
              src="/img/cardgen/collections/back_small.png"
              @contextmenu.prevent=""
            />
            <h1 class="is-size-4 rounded border py-4">{{ collection.name }}</h1>
          </div>
          <div style="text-align: center">
            <button
              type="submit"
              @click="editCollection(collection)"
              v-tippy
              :content="trans.get('general.edit')"
              class="button is-dark"
            >
              <i class="fas fa-edit"></i>
            </button>
            <button
              type="submit"
              @click="confirmDeleteCollection(collection)"
              v-tippy
              :content="trans.get('general.delete')"
              class="button is-danger"
            >
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
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
              <button class="button is-primary" v-if="!isEditing">
                {{ trans.get("general.add") }}
              </button>
              <button class="button is-info" v-else>
                {{ trans.get("general.edit") }}
              </button>
            </footer>
          </div>
        </form>
      </b-modal>
    </div>
    <div class="p-2" v-else>
      <button @click="selectedCollection = null" class="button is-info">
        <i class="fas fa-arrow-left"></i>
      </button>
      <button @click="showAddCollectionable()" class="button is-dark">
        __ Add collectionable
      </button>
      <h1 class="is-size-1">{{ selectedCollection.name }}</h1>
      <div class="p-2 has-text-centered">
        <div
          v-for="collectionable in selectedCollection.collectionables"
          :key="collectionable.id"
          class="collectionable-container m-1"
        >
          <div class="collectionable">
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
          <div style="text-align: center">
            <button
              type="submit"
              @click="edit(collectionable)"
              v-tippy
              :content="trans.get('general.edit')"
              class="button is-dark"
            >
              <i class="fas fa-edit"></i>
            </button>
            <button
              type="submit"
              @click="confirmDelete(collectionable)"
              v-tippy
              :content="trans.get('general.delete')"
              class="button is-danger"
            >
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
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
                :initial-image="collectionable.src"
              ></croppa>
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
                @click="
                  isModalCollectionableActive = false;
                  isEditing = false;
                "
              >
                {{ trans.get("general.close") }}
              </button>
              <button class="button is-primary" v-if="!isEditing">
                {{ trans.get("general.add") }}
              </button>
              <button class="button is-info" v-else>
                {{ trans.get("general.edit") }}
              </button>
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
      isEditing: false,
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
        src: null,
      },
    };
  },
  methods: {
    showAddCollectionable() {
      if (this.image && Object.keys(this.image).length) {
        this.collectionable = {};
        this.image.refresh();
      }
      this.isModalCollectionableActive = true;
    },
    confirmDelete(collectionable) {
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
          axios
            .delete("/classroom/collectionable/" + collectionable.id)
            .then((response) => {
              if (response.data === 1) {
                var index = this.selectedCollection.collectionables.findIndex(
                  function (item, i) {
                    return item.id === collectionable.id;
                  }
                );
                this.selectedCollection.collectionables.splice(index, 1);
              }
            });
        },
      });
    },
    edit(collectionable) {
      this.collectionable = collectionable;
      if (this.image && Object.keys(this.image).length) {
        this.image.refresh();
      }
      this.isEditing = true;
      this.isModalCollectionableActive = true;
    },
    confirmDeleteCollection(collection) {
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
          axios
            .delete("/classroom/collections/" + collection.id)
            .then((response) => {
              if (response.data === 1) {
                var index = this.collectionsReactive.findIndex(
                  function (item, i) {
                    return item.id === collection.id;
                  }
                );
                this.collectionsReactive.splice(index, 1);
              }
            });
        },
      });
    },
    editCollection(collection) {
      this.collection = collection;
      this.isEditing = true;
      this.isModalActive = true;
    },
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
      let url = "/classroom/" + this.code + "/collections";
      if(this.isEditing)
        url += "/edit"
      axios
        .post(url, {
          collection: this.collection,
        })
        .then((response) => {
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
      if (this.isEditing) formData.append("id", this.collectionable.id);

      this.image.generateBlob(
        (blob) => {
          if (!blob) return false;

          formData.append("image", blob, "collectionable.png");
          let url = "/classroom/" + this.code + "/collectionable";
          if (this.isEditing)
            url = "/classroom/" + this.code + "/collectionable/edit";
          axios.post(url, formData).then((response) => {
            this.selectedCollection = response.data;
            this.isModalCollectionableActive = false;
            this.$forceUpdate();
            if (this.isEditing)
              this.$toast(this.trans.get("success_error.update_success"), {
                type: "success",
              });
            else
              this.$toast(this.trans.get("success_error.add_success"), {
                type: "success",
              });
            this.isEditing = false;
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
.collection-container {
  width: 200px;
  display: inline-block;
}
.collectionable-container {
  width: 200px;
  display: inline-block;
}
.collectionable {
  width: 200px;
  height: 280px;
  position: relative;
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
