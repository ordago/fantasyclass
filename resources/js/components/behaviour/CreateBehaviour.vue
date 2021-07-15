<template>
  <div class="container p-3">
    <form
      method="post"
      :action="'/classroom/' + this.code + '/behaviours'"
      enctype="multipart/form-data"
    >
      <input :value="csrfToken" type="hidden" name="_token" />

      <div class="field has-addons">
        <p class="control">
          <IconSelectorPro v-model="icon"></IconSelectorPro>
        </p>
        <p class="control">
          <input
            v-model="icon"
            name="icon"
            class="input"
            required
            :placeholder="trans.get('behaviours.icon_select')"
            type="text"
          />
        </p>
      </div>
      <div class="form-group" style="margin-top: -10px">
        <label
          ><small
            >{{ trans.get("behaviours.fontawesome") }}
            <a href="https://fontawesome.com/icons?d=gallery" target="_blank"
              >FontAwesome</a
            ></small
          ></label
        >
      </div>

      <div class="mt-4">
        <label for="name"
          ><span class="help is-danger is-inline">* </span>
          {{ trans.get("behaviours.name") }}
          <small class="font-italic"
            >({{ trans.get("behaviours.name_info") }})</small
          ></label
        >
        <input
          type="text"
          id="name"
          v-model="name"
          name="name"
          required
          class="input my-3"
        />
      </div>
      <div class="mt-2">
        <label for="custom_text"
          >{{ trans.get("behaviours.custom_text") }}
          <small class="font-italic"
            >({{ trans.get("behaviours.custom_text_info") }})</small
          ></label
        >
        <input
          type="text"
          id="custom_text"
          v-model="custom_text"
          name="custom_text"
          class="input"
          placeholder=""
        />
      </div>
      <div class="mt-3">
        <label
          >{{ trans.get("behaviours.attributes") }}
          <small class="font-italic"
            >({{ trans.get("behaviours.attributes_info") }})</small
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
          class="button is-primary"
          @click="update"
          v-if="behaviour"
          type="button"
        >
          <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
        </button>
        <button class="button is-success" type="submit" v-if="!behaviour">
          {{ trans.get("behaviours.create") }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
const IconSelectorPro = () => import("../utils/IconSelectorPro.vue");

export default {
  props: ["code", "behaviour"],
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    if (this.behaviour) {
      this.name = this.trans.get(this.behaviour.name);
      this.custom_text = this.trans.get(this.behaviour.custom_text);
      this.hp = this.behaviour.hp;
      this.xp = this.behaviour.xp;
      this.gold = this.behaviour.gold;
      this.icon = this.behaviour.icon;
      this.id = this.behaviour.id;
    }
  },
  data: function () {
    return {
      icon: null,
      csrfToken: null,
      name: null,
      custom_text: null,
      xp: 0,
      hp: 0,
      gold: 0,
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

    update: function () {
      axios
        .patch("/classroom/behaviours/" + this.id, this.$data)
        .then((response) => {
          this.$toast(response.data.message, { type: response.data.type });
        });
    },
  },
};
</script>