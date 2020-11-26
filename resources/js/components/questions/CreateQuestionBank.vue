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

          <div class="mt-3">
            <label for="title"
              ><span class="help is-danger is-inline">* </span>
              {{ trans.get("challenges.name") }}</label
            >
            <input
              type="text"
              v-model="questionBank.title"
              name="title"
              id="title"
              required
              minlength="3"
              class="input my-3"
            />
          </div>
          <div class="mt-3">
            <button
              class="button is-link"
              @click="update"
              v-if="editBank"
              type="button"
            >
              {{ trans.get("challenges.edit") }}
            </button>
            <button class="button is-success" type="submit" v-if="!editBank">
              {{ trans.get("challenges.create") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ["code", "editBank"],
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if (this.editBank) this.questionBank = this.editBank;
  },
  data: function () {
    return {
      csrfToken: null,
      questionBank: {
        id: null,
        title: null,
      },
      icon: null,
    };
  },
  components: {
  },
  methods: {
    formSubmit: function (e) {
      axios
        .post(
          "/classroom/" + this.code + "/questions",
          this.$data.questionBank
        )
        .then((response) => {
          // this.$toast(response.data.message, { type: response.data.type });
          // if (response.data.challenge) {
          //   this.$parent.refresh(response.data.challenge);
          // }
        });
      this.$parent.activeAddBank = false;
      this.$parent.$forceUpdate();
    },
    update: function () {},
  },
};
</script>