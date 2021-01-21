<template>
  <div class="pl-0-desktop">
    <div class="panel pl-0">
      <p class="panel-heading is-flex has-space-between align-items-center p-4">
        <span class="pl-3">Create </span>
      </p>
      <div class="p-4 panel-block">
        <form
          method="post"
          @submit.prevent="formSubmit"
          class="w-100"
          :action="'/classroom/' + this.code + '/challenge'"
        >
          <input :value="csrfToken" type="hidden" name="_token" />

          <div class="my-3">
            <label for="name"
              ><span class="help is-danger is-inline">* </span>
              {{ trans.get("challenges.icon") }}</label
            >
          </div>
          <div class="field has-addons">
            <p class="control">
              <IconSelectorPro v-model="documentCategory.icon"></IconSelectorPro>
            </p>
            <p class="control is-expanded">
              <input
                v-model="documentCategory.icon"
                ref="icon"
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
                <a
                  href="https://fontawesome.com/icons?d=gallery"
                  target="_blank"
                  >FontAwesome</a
                ></small
              ></label
            >
          </div>

          <div class="mt-3">
            <label for="name"
              ><span class="help is-danger is-inline">* </span>
              {{ trans.get("challenges.name") }}</label
            >
            <input
              type="text"
              id="name"
              v-model="documentCategory.name"
              name="name"
              required
              class="input my-3"
            />
          </div>
          <div class="mt-3">
            <!-- <button
              class="button is-link"
              @click="update"
              v-if="challenge"
              type="button"
            >
              {{ trans.get("challenges.edit") }}
            </button> -->
            <button class="button is-success" type="submit" v-if="!category">
              {{ trans.get("challenges.create") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
const IconSelectorPro = () => import("../utils/IconSelectorPro.vue");

export default {
  props: ["code", "category", "editgroup"],
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    // if (this.editgroup) this.documentCategory = this.editgroup;
  },
  data: function () {
    return {
      csrfToken: null,
      documentCategory: {
        icon: this.icon,
        name: null,
      },
    };
  },
  components: {
    IconSelectorPro,
  },
  methods: {
    formSubmit: function (e) {
      axios
        .post(
          "/classroom/" + this.code + "/docmgr/group",
          this.$data.documentCategory
        )
        .then((response) => {
          this.$toast(response.data.message, { type: response.data.type });
          if (response.data.category) {
            this.$parent.documentgroups.push(response.data.category);
            this.$parent.$forceUpdate();
          }
        });
      this.$parent.activeAddGroup = false;
    },
    update: function () {},
  },
};
</script>