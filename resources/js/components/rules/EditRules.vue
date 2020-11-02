<template>
  <div class="w-100 content">
    <div class="buttons">
        <button @click="getRules('en')" class="button is-primary">
          Import default (EN)
        </button>
        <button @click="getRules('es')" class="button is-link">
          Importa por defecto (ES)
        </button>
        <button @click="getRules('ca')" class="button is-info">
          Importa per defecte (CA)
        </button>
    </div>
    <Editor height="70vh" :code="code"></Editor>
    <div>
      <button class="button is-primary mt-4" @click="saveRules">
        <i class="fas fa-save mr-2"></i>
        {{ trans.get("general.save") }}
      </button>
    </div>
  </div>
</template>
<script>
const Editor = () => import("../utils/Editor.vue");

export default {
  props: ["code", "rules"],
  mounted: function () {
    if (this.rules) {
      this.content = this.rules.content;
    }
  },
  data: function () {
    return {
      content: ``,
    };
  },
  methods: {
    saveRules() {
      axios
        .patch("/classroom/" + this.code + "/rules", {
          content: this.content,
          _method: "patch",
        })
        .then((response) => {
          this.$toasted.show(this.trans.get("success_error.update_success"), {
            position: "top-center",
            duration: 3000,
            iconPack: "fontawesome",
            icon: "check",
            type: "success",
          });
        });
    },
    getRules(lang) {
      axios
        .post("/classroom/default/rules", { lang: lang })
        .then((response) => {
          this.content = response.data;
        });
    },
  },
  components: {
    Editor,
  },

  computed: {},
};
</script>
