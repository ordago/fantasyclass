<template>
  <tippy
    interactive
    :animate-fill="false"
    theme="light"
    placement="bottom"
    animation="fade"
    trigger="click"
    style="display: inline-block"
    arrow
  >
    <template v-slot:trigger>
      <button class="button is-success is-outlined">
        <i class="fas fa-file-import mr-2"></i>
        {{ trans.get("settings.import_from_class") }}
      </button>
    </template>
    <span>
      <div>{{ trans.get("settings.import_code") }}</div>
      <b-switch
        class="my-1"
        v-if="importType != 'levels'"
        v-model="deleteCurrent"
        :true-value="true"
        :false-value="false"
      >
        {{ trans.get("settings.delete_current") }}
      </b-switch>
      <div class="is-flex is-center-vertically">
        <input type="text" v-model="shareCode" class="input mr-1" />
        <button
          @click="importFromClass"
          :disabled="!shareCode"
          class="button is-primary is-inline ml-1"
        >
          {{ trans.get("general.import") }}
        </button>
      </div>
    </span>
  </tippy>
</template>

<script>
import Utils from "../../utils.js";
import { TYPE } from "vue-toastification";

export default {
  props: ["code", "importType"],
  created() {},
  data: function () {
    return {
      shareCode: "",
      deleteCurrent: true,
    };
  },
  methods: {
    importFromClass() {
      if (this.deleteCurrent)
        this.$buefy.dialog.confirm({
          title: this.trans.get("general.import"),
          message: this.trans.get("settings.import_alert"),
          confirmText: this.trans.get("general.import"),
          type: "is-warning",
          hasIcon: true,
          onConfirm: () => {
            axios
              .post("/classroom/" + this.code + "/settings/import", {
                shareCode: this.shareCode,
                type: this.importType,
                delete: this.deleteCurrent,
              })
              .then((response) => {
                location.reload();
              })
              .catch((error) => {
                Utils.toast(
                  this,
                  this.trans.get("classroom.code_invalid"),
                  TYPE.ERROR
                );
              });
          },
        });
      else
        axios
          .post("/classroom/" + this.code + "/settings/import", {
            shareCode: this.shareCode,
            type: this.importType,
            delete: this.deleteCurrent,
          })
          .then((response) => {
            location.reload();
          })
          .catch((error) => {
            Utils.toast(
              this,
              this.trans.get("classroom.code_invalid"),
              TYPE.ERROR
            );
          });
    },
  },
};
</script>