<template>
  <div>
    <button class="button is-info" @click="loadIcons">
      {{ trans.get("students.select_image") }}
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
        <section class="modal-card-body is-relative">
          <div v-if="custom && custom.length" class="my-2">
            <span v-for="(image, index) in custom" :key="index">
              <img
                @contextmenu.prevent=""
                @click="
                  updateAvatar(
                    '/storage/avatars/' + image.uuid + '/' + image.file_name
                  )
                "
                :src="'/storage/avatars/' + image.uuid + '/' + image.file_name"
                width="81px"
                class="m-2 cursor-pointer"
              />
            </span>
          </div>
          <div class="mb-3" v-if="custom && custom.length && licenses != ''">
            {{ licenses }}
          </div>
          <hr v-if="categories && categories.length" />
          <div class="columns is-multiline" v-if="images">
            <img
              @contextmenu.prevent=""
              width="75px"
              @click="updateAvatar(image)"
              v-for="image in images"
              :key="image"
              :src="image"
            />
          </div>
          <div class="columns is-multiline" v-else>
            <div
              class="column img-categories p-4 m-2 is-flex has-all-centered rounded"
              v-for="category in categories"
              :key="category"
              @click="populate(category)"
            >
              <h4 style="display: inline-block">{{ category }}</h4>
            </div>
          </div>
          <div class="my-3" v-if="categories && categories.length">
            Icons made by
            <a href="http://www.freepik.com" title="Freepik">Freepik</a> from
            <a href="https://www.flaticon.com/" title="Flaticon"
              >www.flaticon.com</a
            >
            is licensed by
            <a
              href="http://creativecommons.org/licenses/by/3.0/"
              title="Creative Commons BY 3.0"
              target="_blank"
              >CC 3.0 BY</a
            >
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
            <button
              class="button is-link"
              @click="images = null"
              v-if="images != null"
            >
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

  created() {},
  data() {
    return {
      custom: null,
      categories: null,
      images: null,
      isModalActive: false,
      licenses: "",
    };
  },

  mounted() {},

  methods: {
    loadIcons() {
      axios
        .get("/classroom/" + this.code + "/utils/icon-packs")
        .then((response) => {
          this.custom = response.data[0];
          this.categories = response.data[1];
          this.licenses = response.data[2];
          this.isModalActive = true;
        });
    },
    updateAvatar: function (image) {
      let formData = new FormData();
      formData.append("url", image);
      if (this.admin) {
        formData.append("student_id", this.student.id);
      }
      axios
        .post("/classroom/" + this.code + "/setting/updateavatar", formData)
        .then((response) => {
          location.reload();
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