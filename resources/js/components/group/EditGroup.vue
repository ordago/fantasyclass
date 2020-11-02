<template>
  <div class="box p-4 m-3">
    <figure class="image is-128x128">
      <label class="cursor-pointer">
        <croppa
          class="p-2 card-shadow-s is-full-rounded"
          v-model="image"
          :width="128"
          :height="128"
          :quality="1"
          accept="image/*"
          placeholder="Image"
          :placeholder-font-size="16"
          canvas-color="transparent"
          :show-remove-button="true"
          remove-button-color="black"
          :show-loading="true"
          :loading-size="50"
          :initial-image="prevImage"
        ></croppa>
      </label>
    </figure>
    <label>{{ trans.get('groups.group_name') }}</label>
    <input type="text" class="input" v-model="group.name" />
    <button class="button is-dark m-3" @click="edit">{{ trans.get('general.edit') }}</button>
    <button class="button is-danger m-3" @click="remove">{{ trans.get('general.delete') }}</button>
  </div>
</template>

<script>
export default {
  props: ["group", "code"],
  created() {
    this.prevImage = this.group.logo;
  },
  data: function() {
    return {
      image: null,
      prevImage: null
    };
  },
  components: {},
  methods: {
    remove() {
      axios.delete("/classroom/groups/" + this.group.id).then(response => {
        this.$toasted.show(this.trans.get("success_error.update_success"), {
          position: "top-center",
          duration: 3000,
          iconPack: "fontawesome",
          icon: "check",
          type: "success"
        });
        this.$destroy();
        location.reload();
        // this.$el.parentNode.removeChild(this.$el);
      });
    },
    edit() {
      this.image.generateBlob(
        blob => {
          // form data
          var formData = new FormData();
          if (blob) formData.append("logo", blob, "logo.png");
          formData.append("id", this.group.id);
          formData.append("name", this.group.name);
          formData.append("_method", "patch");
          axios
            .post("/classroom/" + this.code + "/groups/info", formData, {
              headers: {
                "content-type": "multipart/form-data"
              }
            })
            .then(response => {
              this.$toasted.show(
                this.trans.get("success_error.update_success"),
                {
                  position: "top-center",
                  duration: 3000,
                  iconPack: "fontawesome",
                  icon: "check",
                  type: "success"
                }
              );
            });
        },
        "image/png",
        0.8
      );
    }
  }
};
</script>
