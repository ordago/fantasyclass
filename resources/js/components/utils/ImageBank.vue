<template>
  <div>
    <button class="button is-info" @click="isModalActive=true">Select 📷 from image bank</button>

    <b-modal :active.sync="isModalActive" has-modal-card full-screen :can-cancel="false">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">Select image</p>
        </header>
        <section class="modal-card-body is-relative">
          <div class="columns is-multiline" v-if="images">
            <img
              width="75px"
              @click="updateAvatar(image)"
              v-for="image in images"
              :key="image"
              :src="image"
            />
          </div>
          <div class="columns is-multiline" v-else>
            <div
              class="column img-categories has-padding-4 has-margin-2 is-flex has-all-centered rounded"
              v-for="category in categories"
              :key="category"
              @click="populate(category)"
            >
              <h4 style="display:inline-block">{{ category }}</h4>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot columns is-multiline" style="overflow-x: auto">
          <div class="column is-narrow">
            <button class="button" type="button" @click="isModalActive=false">Close</button>
            <button class="button is-link" @click="images=null" v-if="images != null">
              <i class="far fa-arrow-left"></i>
            </button>
          </div>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["code", "admin", "student"],
  created() {
    axios.get("/classroom/utils/icon-packs").then((response) => {
      this.categories = response.data;
    });
  },
  data() {
    return {
      categories: null,
      images: null,
      isModalActive: false,
    };
  },

  mounted() {},

  methods: {
    updateAvatar: function (image) {
      let formData = new FormData();
      formData.append("url", image);
      if (this.admin) {
        formData.append("student_id", this.student.id);
      }
      axios
        .post("/classroom/" + this.code + "/setting/updateavatar", formData)
        .then((response) => {
          location.reload()
        });
    },
    populate: function (cat) {
      axios.get("/classroom/utils/icon-packs/" + cat).then((response) => {
        this.images = response.data;
        this.$forceUpdate();
      });
    },
  },
};
</script>