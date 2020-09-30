<template>
  <div
    v-if="level"
    :class="{ 'column is-6-tablet is-12-mobile is-3-desktop has-margin-bottom-0 is-flex has-all-centered' : edit, 'column': !edit}"
  >
    <input :value="level.id" type="hidden" name="id" />
    <input v-if="edit" :id="'file' + level.id" type="file" style="display: none" @change="getImage" />

    <div :class="{ 'min-width' : !edit }" class="columns w-100 is-variable is-0 has-padding-y-2">
      <div class="column is-narrow has-padding-y-0 card-shadow-s rounded-left has-background-light">
        <figure class="image is-128x128">
          <label class="cursor-pointer" :for="'file' + level.id">
            <img
              style="width: 128px; height: 128px"
              :src="image"
              class="has-padding-2 card-shadow-s is-full-rounded"
            />
          </label>
        </figure>
      </div>
      <div class="column content card has-padding-4 rounded-right card-shadow-s">
        <p class="is-size-4">{{ trans.get('levels.level') }} {{ level.number }}</p>
        <p class="has-margin-y-2" v-if="edit">
          <i class="fas fa-fist-raised colored"></i> {{ trans.get('levels.xp') }}
        </p>
        <h2 v-if="!edit">{{ level.title }}</h2>
        <p v-if="!edit">{{ level.description }}</p>
        <input type="number" v-if="edit" v-model="level.xp" class="input w-100" />
        <p class="has-margin-y-2" v-if="edit">{{ trans.get('levels.title') }}</p>
        <input v-model="level.title" v-if="edit" type="text" class="input w-100" />
        <p class="has-margin-y-2" v-if="edit">{{ trans.get('levels.description') }}</p>
        <p v-if="edit">
          <textarea style="resize: none;" class="input" v-model="level.description"></textarea>
        </p>
        <div v-if="edit" class="has-text-right has-margin-top-2">
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
  props: ["level", "last", "code", "edit"],
  created() { 
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if(this.level)
    this.image = this.level.imagelvl;
  },
  data: function() {
    return {
      csrfToken: null,
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
        document.getElementById("file" + this.level.id).files[0]
      );
      formData.append("id", this.level.id);
      formData.append("title", this.level.title ? this.level.title : '');
      formData.append("description", this.level.description ? this.level.description : '');
      formData.append("xp", this.level.xp);
      formData.append("_method", "patch");
      axios
        .post("/classroom/levels/" + this.level.id, formData, config)
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
      axios.delete("/classroom/level/" + this.level.id).then(response => {
        //   if(response.data === 1) {
        //     this.data.splice(index, 1);
        location.reload();
        //   }
      });
    }
  }
};
</script>
<style>

.min-width {
  min-width: 400px;
}

</style>