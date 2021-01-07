<template>
  <b-modal
    has-modal-card
    full-screen
    :active.sync="isModalActive"
    :can-cancel="false"
  >
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ trans.get("pets.image") }}</p>
      </header>
      <section class="modal-card-body is-relative">
        <div v-if="images && images.length">
          <details v-for="(pack, index) in images" :key="index" class="my-3">
            <summary><h1 class="is-inline-block is-size-1 cursor-pointer">{{ trans.get('skills.' + pack.name) }}</h1></summary>
            <div class="columns is-multiline my-2">
              <img
                width="60px"
                class="cursor-pointer m-1 rounded"
                @click="clickImage"
                v-for="image in pack.images"
                :key="image"
                :src="'/img/skills/' + pack.name + '/' + image"
              />
            </div>
          </details>
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
            @click="$parent.isImageModalActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
        </div>
      </footer>
    </div>
  </b-modal>
</template>

<script>
// import Utils from "../../utils.js";

export default {
  props: {
    code: String,
  },
  created() {
    axios.get("/classroom/" + this.code + "/skills/get").then((response) => {
      // this.imagesCustom = response.data[1];
      this.images = response.data;

      this.isModalActive = true;
      this.$parent.isLoading = false;
    });
  },
  data: function () {
    return {
      customUpload: false,
      isModalActive: false,
      images: null,
      imagesCustom: [],
      image: null,
      imageUpload: null,
    };
  },
  methods: {
    clickImage(e) {
      this.image = e.target.src;
      this.updateValue();
      this.$parent.isImageModalActive = false;
    },
    updateValue: function () {
      this.$emit("input", this.image);
    },
  },
};
</script>