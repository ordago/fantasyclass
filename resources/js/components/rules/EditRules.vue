<template>
  <div class="w-100 content">
    <div class="columns">
      <div class="column is-narrow">
        <button @click="getRules('en')" class="button is-primary">Import default (EN)</button>
      </div>
      <div class="column is-narrow">
        <button @click="getRules('es')" class="button is-link">Importa por defecto (ES)</button>
      </div>
      <div class="column is-narrow">
        <button @click="getRules('ca')" class="button is-info">Importa per defecte (CA)</button>
      </div>
    </div>
    <Editor style="max-height: 70vh" :code="code"></Editor>
    <div>
      <button class="button is-primary has-margin-top-4" @click="saveRules">
        <i class="fas fa-save has-margin-right-2"></i>
        {{ trans.get('general.save') }}
      </button>
    </div>
  </div>
</template>
<script>
const Editor = () => import("../utils/Editor.vue");

export default {
  props: ["code", "rules"],
  mounted: function() {
    if (this.rules) {
      this.content = this.rules.content;
    }
  },
  data: function() {
    return {
      content: ``
    };
  },
  methods: {
    saveRules() {
      axios
        .patch("/classroom/" + this.code + "/rules", {
          content: this.content,
          _method: "patch"
        })
        .then(response => {
          this.$toasted.show(this.trans.get('success_error.update_success'), {
            position: "top-center",
            duration: 3000,
            iconPack: "fontawesome",
            icon: 'check',
            type: 'success',
          });
        });
    },
    getRules(lang) {
      axios.post("/classroom/default/rules", { lang: lang }).then(response => {
        this.content = response.data;
      });
    }
  },
  components: {
    Editor
  },

  computed: {}
};
</script>
