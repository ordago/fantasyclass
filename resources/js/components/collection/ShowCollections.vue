<template>
  <div>
    <div class="p-2" v-if="!selectedCollection">
      <button
        @click="
          isEditing = false;
          collection = {};
          isModalActive = true;
        "
        class="button is-success"
      >
        {{ trans.get("collections.add_collection") }}
      </button>
      <button class="button is-dark is-outlined" @click="getCollections">
        <i class="fak fa-collection mr-2"></i>
        {{ trans.get("collections.bank") }}
      </button>
      <div class="p-2 has-text-centered">
        <div
          class="collection-container mx-2"
          v-for="collection in collectionsReactive"
          :key="collection.id"
        >
          <div
            class="collection mx-1 cursor-pointer"
            @click="selectedCollection = collection"
          >
            <img
              src="/img/cardgen/collections/back_small.png"
              @contextmenu.prevent=""
            />
            <h1 class="is-size-4 rounded border py-4">{{ collection.name }}</h1>
          </div>
          <div style="text-align: center">
            <span
              class="button is-info cursor-default"
              v-tippy
              :content="getContent(collection)"
            >
              <i class="fas fa-info"></i>
            </span>
            <button
              @click="shareCollection(collection)"
              class="button is-success"
              v-tippy
              :content="trans.get('general.share')"
            >
              <i class="fas fa-share-alt"></i>
            </button>
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
                >{{ trans.get("collections.new_collection") }}
              </p>
            </header>
            <section class="modal-card-body">
              <b-field :label="trans.get('collections.name')" class="mt-4">
                <b-input
                  v-model="collection.name"
                  maxlength="50"
                  required
                ></b-input>
              </b-field>
              <div class="mb-3">
                <b-field expanded :label="trans.get('collections.reward')">
                </b-field>
              </div>
              <div class="columns">
                <div class="column">
                  <b-field>
                    <template slot="label">
                      {{ trans.get("collections.xp") }}
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
                      {{ trans.get("collections.gold") }}
                      <i class="fas fa-coins colored"></i>
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
              <button class="button is-primary" v-else>
                <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
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
        {{ trans.get("collections.add_collectionable") }}
      </button>
      <h1 class="is-size-1 has-text-centered mb-3">
        <i class="fak fa-collection mr-2"></i> {{ selectedCollection.name }}
      </h1>
      <div
        class="p-2 has-text-centered"
        v-if="
          selectedCollection.collectionables &&
          selectedCollection.collectionables.length
        "
      >
        <div
          v-for="collectionable in orderedCollectionables"
          :key="collectionable.id"
          class="collectionable-container m-1"
        >
          <show-collectionable
            :admin="true"
            :collectionable="collectionable"
          ></show-collectionable>
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
      <div class="p-2" v-else>
        <article class="message is-info">
          <div class="message-body">
            {{ trans.get("collections.empty") }}
          </div>
        </article>
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
                >{{ trans.get("collections.new_collectionable") }}
              </p>
            </header>
            <section class="modal-card-body">
              <div class="has-text-centered">
                <croppa
                  class="card-shadow-s"
                  v-model="image"
                  :width="150"
                  :height="150"
                  :quality="1"
                  :zoom-speed="8"
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
              </div>
              <b-field :label="trans.get('collections.name')" class="mt-4">
                <b-input
                  v-model="collectionable.name"
                  maxlength="20"
                  required
                ></b-input>
              </b-field>
              <b-field>
                <b-field :label="trans.get('collections.type')">
                  <b-select
                    v-model="collectionable.type"
                    :placeholder="trans.get('collections.select_type')"
                    required
                    expanded
                  >
                    <option value="1">
                      {{ trans.get("collections.earth") }}
                    </option>
                    <option value="2">
                      {{ trans.get("collections.wind") }}
                    </option>
                    <option value="3">
                      {{ trans.get("collections.water") }}
                    </option>
                    <option value="4">
                      {{ trans.get("collections.fire") }}
                    </option>
                  </b-select>
                </b-field>
              </b-field>
              <article class="message is-warning">
                <div class="message-body">
                  {{ trans.get("collections.type_info") }}
                </div>
              </article>
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
              <button
                class="button is-primary"
                :class="{ 'is-loading': isLoading }"
                v-if="!isEditing"
              >
                {{ trans.get("general.add") }}
              </button>
              <button class="button is-primary" v-else>
                <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
              </button>
            </footer>
          </div>
        </form>
      </b-modal>
    </div>
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
            <p class="modal-card-title">{{ trans.get("evaluation.config") }}</p>
          </header>
          <section class="modal-card-body" v-if="settings">
            <div class="field">
              <div class="field">
                <b-switch
                  true-value="1"
                  false-value="0"
                  v-model="settings.buy_collectionable"
                  >{{ trans.get("collections.buy_collection") }}</b-switch
                >
              </div>
            </div>

            <div class="field">
              <label class="label">{{
                trans.get("collections.buy_collectionable_count")
              }}</label>
              <div class="control">
                <input
                  class="input"
                  type="number"
                  min="1"
                  v-model="settings.buy_collectionable_count"
                />
              </div>
            </div>
            <div class="field">
              <label class="label"
                >{{ trans.get("collections.buy_collectionable_gold_pack") }}
                <i class="fas fa-coins colored"></i>
              </label>
              <div class="control">
                <input
                  class="input"
                  type="number"
                  v-model="settings.buy_collectionable_gold_pack"
                />
              </div>
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
    <b-modal
      :active.sync="isModalImportActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("general.import") }}</p>
        </header>
        <section class="modal-card-body">
          <div v-if="!collectionsb.length">
            {{ trans.get("collections.empty") }}
          </div>
          <div class="p-2 justify-content-center w-100" v-else>
            <div
              class="mb-2"
              v-for="collectionp in collectionsb"
              :key="collectionp.id"
            >
              <h4 class="is-size-4 is-flex is-center-vertically">
                {{ collectionp.name }} {{ collectionp.xp }}
                <small
                  ><i class="fas fa-fist-raised colored"></i> |
                  {{ collectionp.gold }} <i class="fas fa-coins colored"></i
                ></small>
                <button
                  @click="importPack(collectionp)"
                  class="button is-success ml-2"
                >
                  <i class="fas fa-file-import mr-2"></i>
                  {{ trans.get("general.import") }}
                </button>
              </h4>
              <div class="collectionable-container w-100">
                <show-collectionable
                  v-for="collectionable in collectionp.collectionables"
                  :key="'c-' + collectionable.id"
                  :collectionable="collectionable"
                  :admin="false"
                  :count="0"
                  class="collectionable-container"
                  style="zoom: 50%"
                ></show-collectionable>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isModalImportActive = false">
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
import ShowCollectionable from "./ShowCollectionable.vue";
export default {
  components: { ShowCollectionable },
  props: ["code", "collections", "settings"],
  created() {
    this.collectionsReactive = this.collections;
  },
  data: function () {
    return {
      image: {},
      collectionsb: [],
      collectionsReactive: [],
      selectedCollection: null,
      isPrefsModalActive: false,
      isModalActive: false,
      isModalImportActive: false,
      isEditing: false,
      isLoading: false,
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
  computed: {
    orderedCollectionables: function () {
      return _.orderBy(this.selectedCollection.collectionables, "type", "asc");
    },
  },
  methods: {
    importPack(collection) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.import") + " \"" + collection.name + "\"",
        message: this.trans.get("collections.import_alert"),
        confirmText: this.trans.get("general.import"),
        type: "is-warning",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post("/collections/import", { code: this.code, id: collection.id })
            .then((response) => {
              location.reload();
            });
        },
      });
    },
    getCollections() {
      axios.get("/collections/share/get").then((response) => {
        this.collectionsb = response.data;
        this.isModalImportActive = true;
      });
    },
    shareCollection(collection) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.share"),
        message: `${this.trans.get("collections.share_bank")}`,
        cancelText: this.trans.get("general.cancel"),
        confirmText: this.trans.get("general.accept"),
        type: "is-success",
        onConfirm: () => {
          axios
            .post("/collections/share", {
              code: this.code,
              id: collection.id,
            })
            .then((response) => {
              this.$toast(this.trans.get("success_error.add_success"), {
                type: "success",
              });
            });
        },
      });
    },
    updatePrefs() {
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "buy_collectionable",
        value: this.settings.buy_collectionable,
        action: "update",
      });
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "buy_collectionable_count",
        value: this.settings.buy_collectionable_count,
        action: "update",
      });
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "buy_collectionable_gold_pack",
        value: this.settings.buy_collectionable_gold_pack,
        action: "update",
      });
      this.isPrefsModalActive = false;
    },
    getContent(collection) {
      return (
        collection.xp +
        "<i class='fas fa-fist-raised colored'></i>, " +
        collection.gold +
        "<i class='fas fa-coins colored'></i>"
      );
    },
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
                var index = this.collectionsReactive.findIndex(function (
                  item,
                  i
                ) {
                  return item.id === collection.id;
                });
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
    addCollection() {
      let url = "/classroom/" + this.code + "/collections";
      if (this.isEditing) url += "/edit";
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
      this.isLoading = true;
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
            this.isLoading = false;
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
</style>
