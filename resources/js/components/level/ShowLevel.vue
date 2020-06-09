<template>
  <div
    class="column is-6-tablet is-12-mobile is-3-desktop has-margin-bottom-0 is-flex is-all-centered"
  >
    <input :value="levelJson.id" type="hidden" name="id" />
    <input :id="'file' + levelJson.id" type="file" style="display: none" @change="getImage" />

    <div class="columns w-100 is-variable is-0 has-padding-y-2">
      <div class="column is-narrow has-padding-y-0 card-shadow-s rounded-left">
        <figure class="image is-128x128">
          <label class="cursor-pointer" :for="'file' + levelJson.id">
            <img
              style="width: 128px; height: 128px"
              :src="image"
              class="has-padding-2 card-shadow-s is-full-rounded"
            />
          </label>
        </figure>
      </div>
      <div class="column card has-padding-4 rounded-right card-shadow-s">
        <p class="is-size-4">Level {{ levelJson.number }}</p>
        <p class="has-margin-y-2">
          <i class="fas fa-fist-raised colored"></i> Needed experience
        </p>
        <input type="number" v-model="levelJson.xp" class="input w-100" />
        <p class="has-margin-y-2">Title (optional)</p>
        <input v-model="levelJson.title" type="text" class="input w-100" />
        <p class="has-margin-y-2">Description (optional)</p>
        <h1 class="is-2">
          <textarea style="resize: none;" class="input" v-model="levelJson.description"></textarea>
        </h1>
        <div class="has-text-right has-margin-top-2">
          <button class="button is-dark" @click="update">
            <i class="fas fa-edit"></i>
          </button>
          <button class="button is-danger" @click="remove" v-if="last">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["level", "last", "code"],
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    this.levelJson = JSON.parse(this.level);
    this.image = this.levelJson.imagelvl;
    console.log(this.levelJson.imagelvl);
  },
  data: function() {
    return {
      csrfToken: null,
      levelJson: null,
      image: ""
    };
  },
  methods: {
    getImage: function(e) {
      let imageU = e.target.files[0];
      if (imageU.size > 10000000) {
        e.target.value = "";
        this.$toasted.show("File size error. Max file size 10MB", {
          position: "top-center",
          duration: 3000,
          iconPack: "fontawesome",
          type: "error"
        });
      } else {
        let reader = new FileReader();
        reader.readAsDataURL(imageU);
        reader.onload = e => {
          this.image = e.target.result;
        };
      }
    },
    update: function() {
      const config = {
        headers: {
          "content-type": "multipart/form-data"
        }
      };

      // form data
      let formData = new FormData();
      formData.append(
        "file",
        document.getElementById("file" + this.levelJson.id).files[0]
      );
      formData.append("id", this.levelJson.id);
      formData.append("title", this.levelJson.title);
      formData.append("description", this.levelJson.description);
      formData.append("_method", "patch");
      axios
        .post(
          "/classroom/" + this.code + "/levels/" + this.levelJson.id,
          formData,
          config
        )
        .then(response => {
          this.$toasted.show(response.data.message, {
            position: "top-center",
            duration: 3000,
            iconPack: "fontawesome",
            icon: response.data.icon,
            type: response.data.type
          });
        });
    },
    remove: function() {
      axios.delete("/classroom/level/" + this.levelJson.id).then(response => {
        //   if(response.data === 1) {
        //     this.data.splice(index, 1);
        location.reload();
        //   }
      });
    }
  }
};
</script>
