<template>
  <div>
    <form @submit.prevent="send">
      <section class="has-padding-x-3">
        <h1 class="is-size-2">
          <i class="fal fa-cog faa-spin animated faa-slow"></i>
          {{ trans.get('profile.profile') }}
        </h1>

        <div class="has-margin-y-4">
          <label for="name" class="has-margin-y-2">{{trans.get('profile.name') }}</label>
          <input
            id="name"
            type="text"
            class="input has-margin-y-2 is-info"
            minlength="2"
            name="name"
            required
            autocomplete="name"
            autofocus
            v-model="name"
          />
        </div>

        <div class="has-margin-y-4">
          <label for="new-password" class="has-margin-y-2">{{trans.get('profile.new_password') }}</label>
          <input
            type="password"
            class="input has-margin-y-2 is-info"
            name="password"
            ref="new_password"
            minlength="8"
            v-model="password"
            autocomplete="new-password"
          />
        </div>

        <div class="has-margin-y-4">
          <label
            for="password_confirmation"
            class="has-margin-y-2"
            v-if="password.length"
          >{{trans.get('profile.confirm_new_password') }}</label>
          <input
            type="password"
            ref="password_confirm"
            minlength="8"
            class="input has-margin-y-2 is-info"
            name="password_confirmation"
            autocomplete="new-password"
            v-if="password.length"
            v-model="password_confirm"
          />
        </div>

        <div class="has-margin-top-4">
          <label for="new-password" class="has-margin-y-2">E-mail</label>
          <input
            type="email"
            class="input has-margin-y-2 is-info"
            v-model="email"
            @input="email_change = true"
          />
        </div>
        <small>If you change the e-mail you'll be logged out and you'll need to confirm the new one.</small>

        <div class="has-margin-y-4">
          <label
            for="current-password"
            class="has-margin-y-2"
            v-if="password.length || email_change"
          >{{trans.get('profile.current_password') }}</label>
          <input
            type="password"
            class="input has-margin-y-2 is-info"
            name="current_password"
            required
            autocomplete="current-password"
            v-model="current_password"
            v-if="password.length || email_change"
          />
        </div>

        <div class="has-margin-y-4 form-group">
          <label for="language" class="has-margin-y-2">{{trans.get('profile.language') }}</label>
          <select v-model="user_lang" class="form-control input has-margin-y-2 is-info" id="locale">
            <option
              :value="code"
              v-for="(language, code) in lang"
              v-bind:key="language"
            >{{ language }}</option>
          </select>
        </div>
        <button
          class="button is-dark"
          v-if="user.is_student == 1"
          @click.prevent="promote"
        >I want to create my own classrooms</button>

        <div
          class="is-flex has-padding-x-4 has-padding-y-4"
          style="position: fixed; bottom: 0; right: 0;"
        >
          <button class="button is-link">{{trans.get('profile.edit') }}</button>
        </div>
      </section>
    </form>
  </div>
</template>

<script>
export default {
  props: ["user", "lang"],
  mounted() {
    this.name = this.user.name;
    this.user_lang = this.user.locale;
    this.email = this.user.email;
  },
  data: function () {
    return {
      name: "",
      current_password: "",
      password: "",
      password_confirm: "",
      user_lang: "",
      email_change: false,
      email: "",
      _method: "patch",
    };
  },
  methods: {
    promote: function () {
      axios.get("/profile/promote").then((response) => {
        location.href = "/classroom";
      });
    },
    axiosSend: function () {
      axios
        .patch("/profile/update", this.$data)
        .then((response) => {
          this.$toasted.show(this.trans.get("profile.update_success"), {
            position: "top-center",
            duration: 3000,
            iconPack: "fontawesome",
            icon: "check",
            type: "success",
          });
          location.reload();
        })
        .catch((error) => {
          this.$toasted.show(this.trans.get("profile.incorrect_password"), {
            position: "top-center",
            duration: 3000,
            iconPack: "fontawesome",
            icon: "times",
            type: "error",
          });
        });
    },
    send: function () {
      if (this.password != this.password_confirm) {
        this.$refs.new_password.classList.add("is-danger");
        this.$refs.password_confirm.classList.add("is-danger");
        return false;
      }
      if (this.email_change) {
        this.$buefy.dialog.prompt({
          message: `Please repeat the e-mail`,
          inputAttrs: {
            placeholder: "",
          },
          trapFocus: true,
          onConfirm: (value) => {
            if (value == this.email) this.axiosSend();
            else {
              this.$toasted.show("The e-mail verification failed", {
                position: "top-center",
                duration: 3000,
                iconPack: "fontawesome",
                icon: "times",
                type: "error",
              });
            }
          },
        });
      } else this.axiosSend();
    },
  },
};
</script>