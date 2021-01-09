<template>
  <div class="container p-3">
    <form @submit.prevent="createBadge">
      <input :value="csrfToken" type="hidden" name="_token" />
      <div class="columns mb-2">
        <div class="column is-narrow">
          <div
            class="personalBadge"
            v-if="type == 0"
            :style="{ 'background-image: url(\'/img/medal2.png\')': type == 0 }"
            v-tippy
            :content="'<h1>' + title + '</h1><h3>' + description + '</h3>'"
          >
            <i :class="icon"></i>
          </div>
          <div v-else>
            <croppa
              class="card-shadow-s"
              v-model="image"
              :width="80"
              :height="80"
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
            ></croppa>
          </div>
          <div class="column is-narrow">
            <b-switch v-model="type" true-value="1" false-value="0">
              Custom
            </b-switch>
          </div>
        </div>
      </div>

      <div class="field has-addons" v-if="type == 0">
        <p class="control">
          <IconSelectorPro v-model="icon"></IconSelectorPro>
        </p>
        <p class="control">
          <input
            v-model="icon"
            name="icon"
            class="input"
            :placeholder="trans.get('badges.icon_select')"
            type="text"
          />
        </p>
      </div>
      <div v-if="type == 0" class="form-group" style="margin-top: -10px">
        <label
          ><small
            >{{ trans.get("badges.fontawesome") }}
            <a href="https://fontawesome.com/icons?d=gallery" target="_blank"
              >FontAwesome</a
            ></small
          ></label
        >
      </div>

      <div class="mt-4">
        <label for="name"
          ><span class="help is-danger is-inline">* </span>
          {{ trans.get("badges.title") }}</label
        >
        <input
          type="text"
          id="title"
          v-model="title"
          name="title"
          required
          class="input my-3"
        />
      </div>
      <div class="mt-2">
        <label for="custom_text"
          ><span class="help is-danger is-inline">* </span>
          {{ trans.get("badges.description") }}</label
        >
        <input
          type="text"
          v-model="description"
          name="description"
          class="input"
          required
          placeholder=""
        />
      </div>
      <div class="mt-3">
        <label
          >{{ trans.get("badges.attributes") }}
          <small class="font-italic"
            >({{ trans.get("badges.attributes_info") }})</small
          ></label
        >
        <div class="columns my-1">
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span
                  class="button is-static"
                  v-bind:class="{
                    'has-background-success': hp > 0,
                    'has-background-danger': hp < 0,
                  }"
                  ><i class="fas fa-heart colored"></i
                ></span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="hp"
                  class="input"
                  v-model="hp"
                  required
                />
              </p>
            </div>
          </div>
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span
                  class="button is-static"
                  v-bind:class="{
                    'has-background-success': xp > 0,
                    'has-background-danger': xp < 0,
                  }"
                  ><i class="fas fa-fist-raised colored"></i
                ></span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="xp"
                  class="input"
                  v-model="xp"
                  required
                />
              </p>
            </div>
          </div>
          <div class="column">
            <div class="field has-addons">
              <p class="control">
                <span
                  class="button is-static"
                  v-bind:class="{
                    'has-background-success': gold > 0,
                    'has-background-danger': gold < 0,
                  }"
                  ><i class="fas fa-coins colored"></i
                ></span>
              </p>
              <p class="control is-expanded">
                <input
                  type="number"
                  name="gold"
                  class="input"
                  v-model="gold"
                  required
                />
              </p>
            </div>
          </div>
        </div>
      </div>
      <div>
        <button
          class="button is-link"
          @click="createBadge"
          v-if="badge"
          type="button"
        >
          {{ trans.get("badges.edit") }}
        </button>
        <button class="button is-success" type="submit" v-if="!badge">
          {{ trans.get("badges.create") }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
const IconSelectorPro = () => import("../utils/IconSelectorPro.vue");

export default {
  props: ["code", "badge"],
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    if (this.badge) {
      this.title = this.trans.get(this.badge.title);
      this.description = this.trans.get(this.badge.description);
      this.hp = this.badge.hp;
      this.type = this.badge.type;
      this.prevImage = this.badge.image;
      this.xp = this.badge.xp;
      this.gold = this.badge.gold;
      this.icon = this.badge.icon;
      this.id = this.badge.id;
    }
  },
  data: function () {
    return {
      icon: null,
      title: "",
      image: {},
      prevImage: "",
      description: "",
      xp: 0,
      hp: 0,
      gold: 0,
      type: 0,
      id: null,
    };
  },
  components: {
    IconSelectorPro,
  },
  methods: {
    formSubmit: function (e) {
      e.preventDefault();
    },
    sendInfo(formData) {
      axios.post('/classroom/' + this.code + '/badges', formData)
        .then(response => {
          this.$toast(response.data.message, { type: response.data.type });
          if(!this.badge)
            location.href = "/classroom/" + this.code + "/badges";
        });
    },
    createBadge() {
      let formData = new FormData();
      formData.append("title", this.title);
      formData.append("description", this.description);
      formData.append("type", this.type);
      formData.append("xp", this.xp);
      formData.append("hp", this.hp);
      formData.append("gold", this.gold);
      if (this.badge) {
        formData.append("id", this.badge.id);
        formData.append("_method", "patch");
      }
      if (this.type == 0) {
        formData.append("icon", this.icon);
        this.sendInfo(formData);
      } else {
        this.image.generateBlob(
          (blob) => {
            if (blob != null) {
                formData.append("image", blob, "badge.png");
            }
            this.sendInfo(formData);
          },
          "image/png",
          0.8
        );
      }
    },
  },
};
</script>