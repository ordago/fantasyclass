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
              <IconSelector></IconSelector>
            </p>
            <p class="control is-expanded">
              <input
                v-model="icon"
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
              v-model="challengeInfo.name"
              name="name"
              required
              class="input my-3"
            />
          </div>
          <div class="mt-3" v-if="$parent.challengesgroup.length">
            <label for="name">{{ trans.get("challenges.parent") }}</label>
            <div class="field">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="challengeInfo.challenges_group_id">
                    <option value="0"></option>
                    <option
                      :value="challenge.id"
                      v-for="challenge in $parent.challengesgroup"
                      v-bind:key="challenge.id"
                    >
                      {{ challenge.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-3">
            <button
              class="button is-link"
              @click="update"
              v-if="challenge"
              type="button"
            >
              {{ trans.get("challenges.edit") }}
            </button>
            <button class="button is-success" type="submit" v-if="!challenge">
              {{ trans.get("challenges.create") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
const IconSelector = () => import("../utils/IconSelector.vue");

export default {
  props: ["code", "challenge", "editgroup"],
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if (this.editgroup) this.challengeInfo = this.editgroup;
  },
  data: function () {
    return {
      csrfToken: null,
      challengeInfo: {
        challenges_group_id: null,
        id: null,
        icon: this.icon,
        name: null,
      },
      icon: null,
    };
  },
  components: {
    IconSelector,
  },
  methods: {
    formSubmit: function (e) {
      this.challengeInfo.icon = this.icon;
      axios
        .post(
          "/classroom/" + this.code + "/challenges/group",
          this.$data.challengeInfo
        )
        .then((response) => {
          this.$toast(response.data.message, { type: response.data.type });
          if (response.data.challenge) {
            this.$parent.refresh(response.data.challenge);
          }
        });
      this.$parent.activeAddGroup = false;
      this.$parent.$forceUpdate();
    },
    update: function () {},
  },
};
</script>