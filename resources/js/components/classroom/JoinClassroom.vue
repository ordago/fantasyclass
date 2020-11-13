<template>
  <a @click="promptCode" class="is-rounded text-center pointer">
    <i class="fal fa-user mr-2"></i>
    {{ trans.get('classroom.join') }}
  </a>
</template>

<script>
import Utils from "../../utils.js";
import { TYPE } from "vue-toastification";

export default {
  mounted: function () {},
  data: function () {
    return {};
  },
  methods: {
    promptCode() {
      this.$buefy.dialog.prompt({
        message: this.trans.get('classroom.code'),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get('general.cancel'),
        inputAttrs: {
          placeholder: this.trans.get('classroom.placeholder_code'),
          maxlength: 10,
        },
        trapFocus: true,
        onConfirm: (value) => {
          axios
            .get(`/classroom/join/${value}`)
            .then((response) => {
              location.reload()
            })
            .catch((error) => {
              Utils.toast(this, this.trans.get('classroom.code_invalid'), TYPE.ERROR);
            });
        },
      });
    },
  },
};
</script>
