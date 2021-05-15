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
        <div>
          <button class="button" @click="customUpload = !customUpload">
            {{ trans.get("classroom.upload_pet") }}
          </button>
        </div>
        <div v-if="customUpload" class="mt-2">
          <croppa
            class="card-shadow-s"
            v-model="imageUpload"
            :width="162"
            :height="198"
            :quality="1"
            style="z-index: 15"
            accept="image/*"
            :zoom-speed="8"
            placeholder="Image"
            :placeholder-font-size="16"
            canvas-color="transparent"
            :show-remove-button="true"
            remove-button-color="black"
            :show-loading="true"
            :loading-size="50"
          ></croppa>
          <button @click="addPetToClass" class="button is-link">
            <i class="fas fa-upload mr-1"></i> {{ trans.get("general.send") }}
          </button>
        </div>
        <div v-if="imagesCustom.length">
          <span v-for="(image, index) in imagesCustom" :key="index">
            <img
              :src="'/storage/pets/' + image.uuid + '/' + image.file_name"
              @click="
                clickImage(
                  '/storage/pets/' + image.uuid + '/' + image.file_name
                )
              "
              width="81px"
              class="m-2 cursor-pointer"
            />
            <button
              @click="deleteImage(image.id)"
              style="margin-left: -20px"
              class="has-text-light has-background-danger"
            >
              <i class="fas fa-trash-alt"></i>
            </button>
          </span>
        </div>
        <hr />
        <div class="columns is-multiline" v-if="imagesCraft">
          <img
            width="75px"
            class="cursor-pointer"
            @click="clickImage('/img/pets/craft/' + image)"
            v-for="image in imagesCraft"
            :key="image"
            :src="'/img/pets/craft/' + image"
          />
        </div>
        <hr />
        Next pet images are from:
        <a href="https://github.com/HabitRPG/habitica"
          >https://github.com/HabitRPG/habitica</a
        >
        and are licensed under
        <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/"
          >CC-BY-NC-SA 3.0</a
        >
        <div class="columns is-multiline" v-if="images">
          <img
            width="75px"
            class="cursor-pointer"
            @click="clickImage('/img/pets/' + image)"
            v-for="image in images"
            :key="image"
            :src="'/img/pets/' + image"
          />
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
  props: ["code"],
  created() {
    axios.get("/classroom/" + this.code + "/pets/get").then((response) => {
      this.imagesCustom = response.data[1];
      this.images = response.data[0];
      this.imagesCraft = response.data[2];
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
      imagesCraft: [],
      image: null,
      imageUpload: null,
    };
  },
  methods: {
    deleteImage(id) {
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
            .delete("/classroom/" + this.code + "/removeMedia/" + id)
            .then((response) => {
              this.imagesCustom = response.data;
            });
        },
      });
    },
    addPetToClass() {
      this.imageUpload.generateBlob(
        (blob) => {
          if (blob != null) {
            let formData = new FormData();
            formData.append("image", blob, "pet.png");
            formData.append("collection", "pets");
            axios
              .post("/classroom/" + this.code + "/add2collection", formData)
              .then((response) => {
                this.customUpload = false;
                this.imagesCustom = response.data;
              });
          }
        },
        "image/png",
        0.8
      );
    },
    clickImage(image) {
      this.image = image;
      this.updateValue();
      this.$parent.isImageModalActive = false;
    },
    updateValue: function () {
      this.$emit("input", this.image);
    },
  },
};
</script>