<template>
  <div
    v-if="role"
    :class="{
      'column is-6-tablet is-12-mobile is-3-desktop mb-0 is-flex has-all-centered':
        edit,
      column: !edit,
    }"
    class="role"
    :style="getStyle()"
  >
    <div
      :class="{ 'min-width': !edit }"
      class="columns w-100 is-variable is-0 py-2"
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
          <label class="cursor-pointer" :for="'file' + role.id">
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
              @contextmenu.prevent=""
              class="p-2 card-shadow-s is-full-rounded"
              :src="prevImage"
            />
          </label>
        </figure>
      </div>
      <div
        v-if="!edit && (role.title || role.description)"
        class="
          column
          content
          card
          p-4
          rounded-right
          card-shadow-s
          has-text-left
        "
      >
        <h2>{{ role.title }}</h2>
        <p>{{ role.description }}</p>
      </div>
      <div
        v-if="edit"
        class="column content card p-4 rounded-right card-shadow-s"
      >
        <p class="my-2">
          {{ trans.get("roles.title") }} <span class="has-text-danger">*</span>
        </p>
        <input v-model="role.title" type="text" class="input w-100" />
        <p class="my-2">{{ trans.get("levels.description") }}</p>
        <p>
          <textarea
            class="input"
            rows="20"
            style="height: 100px"
            v-model="role.description"
          ></textarea>
        </p>
        <div class="has-text-right mt-2">
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
          >
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    role: Object,
    code: String,
    edit: Boolean,
    resize: {
      type: Boolean,
      default: false,
    },
  },
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if (this.role) {
      this.prevImage = this.role.image;
    }
  },
  data: function () {
    return {
      csrfToken: null,
      prevImage: null,
      image: null,
    };
  },
  methods: {
    update: function () {
      this.image.generateBlob(
        (blob) => {
          // form data
          var formData = new FormData();
          if (blob) formData.append("logo", blob, "logo.png");
          formData.append("id", this.role.id);
          formData.append("title", this.role.title ? this.role.title : "");
          formData.append(
            "description",
            this.role.description ? this.role.description : ""
          );
          formData.append("_method", "patch");
          axios
            .post("/classroom/role/" + this.role.id, formData, {
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
          axios.delete("/classroom/role/" + this.role.id).then((response) => {
            // this.$parent.roles.pop();
            var roleId = this.role.id;
            var index = this.$parent.roles.findIndex(function (item, i) {
              return item.id === roleId;
            });
            if (response.data === 1) {
              this.$parent.roles.splice(index, 1);
            }

            this.$parent.$forceUpdate();
          });
        },
      });
    },
  },
};
</script>
<style>
.min-width {
  min-width: 400px;
}
.role:hover .hidden {
  display: initial;
}
.role {
  max-width: 500px;
}
</style>