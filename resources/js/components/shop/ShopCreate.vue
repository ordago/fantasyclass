<template>
  <div class="p-3">
    <div class="rounded">
      <croppa
        v-model="image"
        :width="60"
        :height="60"
        accept="image/*"
        placeholder="Image"
        :placeholder-font-size="16"
        canvas-color="transparent"
        :show-remove-button="true"
        remove-button-color="black"
        class="rounded"
        :show-loading="true"
        :loading-size="50"
        :initial-image="prevImage"
        :aspectRatio="1 / 1"
        :initialAspectRatio="1 / 1"
      ></croppa>
    </div>
    <button class="button is-info" @click="isModalActive = true"><i class="fad fa-images mr-1"></i> {{ trans.get('shop.load_gallery') }}</button>
    <div class="columns mt-2">
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div
                class="field has-addons"
                v-tippy
                :content="trans.get('shop.item_hp')"
              >
                <p class="control">
                  <a class="button is-static">
                    <i class="fas fa-heart colored"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="hp" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div
                class="field has-addons"
                v-tippy
                :content="trans.get('shop.item_xp')"
              >
                <p class="control">
                  <a class="button is-static">
                    <i class="fas fa-fist-raised colored"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="xp" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div
                class="field has-addons"
                v-tippy
                :content="trans.get('shop.item_slot')"
              >
                <p class="control">
                  <a class="button is-static">
                    <i class="fak fa-deck colored"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="slot" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div class="field has-addons">
                <p class="control">
                  <a class="button is-static">
                    {{ trans.get("shop.price") }}
                    <i class="fas fa-coins colored"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="price" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div
                class="field has-addons"
                v-tippy
                :content="trans.get('shop.min_level_info')"
              >
                <p class="control">
                  <a class="button is-static">{{
                    trans.get("shop.min_level")
                  }}</a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="min_lvl" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <textarea
          class="input"
          :placeholder="trans.get('shop.description')"
          v-model="description"
        ></textarea>
      </div>
    </div>
    <button class="button is-primary" v-if="!item" @click="createItem()">
      <i class="fas fa-plus"></i> {{ trans.get("general.create") }}
    </button>
    <button class="button is-link" v-if="item" @click="createItem()">
      <i class="fas fa-edit"></i> {{ trans.get("general.edit") }}
    </button>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            {{ trans.get("students.select_image_title") }}
          </p>
        </header>
        <section class="modal-card-body is-relative mb-2">
          <div class="columns is-multiline" v-if="images">
            <img
              width="60px"
              @click="updateImg(image)"
              v-for="image in images"
              :key="image"
              :src="image"
            />
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
          </div>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["code", "item"],
  mounted() {
    axios.get("/classroom/utils/get-shop").then((response) => {
      this.images = response.data;
    });
  },
  created() {
    if (this.item) {
      this.id = this.item.id;
      this.hp = this.item.hp ? this.item.hp : 0;
      this.xp = this.item.xp ? this.item.xp : 0;
      this.slot = this.item.slot ? this.item.slot : 0;
      this.min_lvl = this.item.min_lvl ? this.item.min_lvl : 0;
      this.price = this.item.price ? this.item.price : 0;
      this.description = this.item.description ? this.item.description : "";
      this.prevImage = this.item.icon;
    }
  },
  data: function () {
    return {
      images: [],
      image: {},
      hp: 0,
      xp: 0,
      slot: 0,
      min_lvl: 0,
      price: 0,
      description: "",
      prevImage: "",
      id: null,
      isModalActive: false,
    };
  },
  methods: {
    updateImg(img) {
      this.prevImage = img;
      this.isModalActive = false;
      this.image.refresh();
    },
    createItem() {
      this.image.generateBlob(
        (blob) => {
          if (blob != null) {
            let formData = new FormData();
            formData.append("icon", blob, "item.png");
            formData.append("hp", this.hp);
            formData.append("xp", this.xp);
            formData.append("slot", this.slot);
            formData.append("min_lvl", this.min_lvl);
            formData.append("price", this.price);
            formData.append("description", this.description);

            if (this.item) {
              formData.append("id", this.id);
              formData.append("_method", "patch");
            }
            axios
              .post("/classroom/" + this.code + "/shop", formData, {
                headers: {
                  "content-type": "multipart/form-data",
                },
              })
              .then((response) => {
                this.$toast(response.data.message, {
                  type: response.data.type,
                });
              });
          }
        },
        "image/png",
        0.8
      );
    },
  },
  computed: {},
};
</script>
