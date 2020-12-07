<template>
  <div class="w-100 p-2 content">
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
    <Editor v-if="editor" height="70vh" v-model="content" :code="code"></Editor>
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
    this.editor = true;
  },
  data: function () {
    return {
      editor: false,
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
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
        });
    },
    getRules(lang) {
      this.editor = false;
      axios
        .post("/classroom/default/rules", { lang: lang })
        .then((response) => {
          this.content = response.data;
          this.editor = true;
        });
    },
  },
  components: {
    Editor,
  },

  computed: {},
};
</script>
