<template>
  <b-modal
    :active.sync="isModalActive"
    has-modal-card
    full-screen
    :can-cancel="false"
  >
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title"><i class="fas fa-user-secret"></i> Impostor</p>
      </header>
      <section class="modal-card-body is-relative">
        <article class="message is-info">
          <div class="message-body">
            {{ trans.get('utils.impostor_select') }}
          </div>
        </article>
        <div class="buttons mb-1">
          <button class="button is-primary" @click="generate">
            {{ trans.get('utils.impostor_generate') }}
          </button>
          <button class="button is-info" v-if="impostor" @click="apply">
            {{ trans.get('utils.impostor_apply') }}
          </button>
          <button class="button is-danger" v-if="impostor" @click="clear">
            {{ trans.get('utils.impostor_delete') }}
          </button>
        </div>
        <div v-if="showImpostor" class="hiddenName is-size-1 p-3">
          <div class="hideObj"></div>
          <h2 class="p-3" v-if="impostor">{{ impostor.name }}</h2>
        </div>
      </section>
      <footer
        class="modal-card-foot columns is-multiline"
        style="overflow-x: auto"
      >
        <div class="column is-narrow">
          <button
            class="button"
            type="button"
            @click="$parent.isImpostorActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
        </div>
      </footer>
    </div>
  </b-modal>
</template>

<script>
// import Utils from "../../utils.js";

export default {
  props: ["code", "students", "current"],
  mounted() {
    if(this.current != -1) {
      this.showImpostor = true;
      setTimeout(() => {
        this.impostor = this.current;
      }, 100);
    }
  },
  data: function () {
    return {
      isModalActive: true,
      impostor: null,
      studentsArray: [],
      showImpostor: false,
    };
  },
  methods: {
    clear() {
      this.showImpostor = false;
      this.impostor = null;
      axios.delete('/classroom/' + this.code + '/utils/impostor/clear');
    },
    apply() {
      axios
        .post("/classroom/" + this.code + "/utils/impostor", {
          id: this.impostor.id,
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
          this.$parent.isImpostorActive = false;
          axios
            .post("/classroom/" + this.code + "/push", {
              message: "🤫 " + this.trans.get('utils.impostor'),
              id: this.impostor.id,
            })
          axios
            .post("/classroom/" + this.code + "/push/all", {
              message: this.trans.get('utils.impostor_active'),
            })
        });
    },
    generate() {
      this.studentsArray = _.shuffle(this.students);
      this.showImpostor = true;
      setTimeout(() => {
        this.impostor = this.studentsArray[0];
      }, 100);
    },
  },
};
</script>