<template>
  <div class="p-2">
    <div class="buttons">
      <div class="button" @click="isModalActive = true">__ Añade wordle</div>
    </div>
    <div>
      <div
        class="columns m-1 p-2 border rounded"
        :key="'wordles-' + obj.id"
        v-for="obj in wordlesReactive"
      >
        <div class="column is-narrow">
          <i class="fad fa-w fs-2"></i>
          <span v-if="obj.dictionary == 0">🇪🇦</span>
          <span v-else-if="obj.dictionary == 1">ca</span>
          <span v-else>🇬🇧</span>
        </div>
        <div class="column is-narrow">
          <button class="tag is-success" @click="addWord(obj.id)">
            __ Add word
          </button>
        </div>
        <div v-if="obj.words && obj.words.length" class="column is-narrow">
          <input
            type="radio"
            name="wordle"
            @input="select(obj.id)"
            :id="`w-${obj.id}`"
            :value="'' + obj.id"
            v-model="active"
          />
          <label :for="`w-${obj.id}`">__ Activo</label>
        </div>
        <div class="column">
          <div v-if="obj.words && obj.words.length">
            <span
              content="t"
              tabindex="0"
              v-for="word in obj.words"
              :key="`w-${word.id}`"
              class="tag is-dark is-medium mr-2 my-1"
            >
              {{ word.word }}
              <small @click="deleteWord(word.id)">
                <i
                  class="
                    fas
                    fa-trash-alt
                    has-background-danger
                    rounded
                    pointer
                    p-2
                    ml-3
                  "
                  aria-hidden="true"
                ></i>
              </small>
            </span>
          </div>
          <div v-else>__ Sin palabras</div>
        </div>
      </div>
    </div>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addWordle">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              <i class="fak fa-collection mr-2"></i
              >{{ trans.get("wordle.new_wordle") }}
            </p>
          </header>
          <section class="modal-card-body">
            <div class="columns">
              <div class="column">
                <b-field>
                  <template slot="label">
                    {{ trans.get("collections.xp") }}
                    <i class="fas fa-fist-raised colored"></i>
                  </template>
                  <b-input
                    v-model="wordle.xp"
                    required
                    type="number"
                    step="0.1"
                  ></b-input>
                </b-field>
              </div>
              <div class="column">
                <b-field>
                  <template slot="label">
                    {{ trans.get("collections.gold") }}
                    <i class="fas fa-coins colored"></i>
                  </template>
                  <b-input
                    v-model="wordle.gold"
                    required
                    type="number"
                    step="0.1"
                  ></b-input>
                </b-field>
              </div>
            </div>
            <div>
              <div class="select">
                <select v-model="wordle.dictionary">
                  <option :value="0">Castellano</option>
                  <option :value="1">Català</option>
                  <option :value="2">English</option>
                </select>
              </div>
            </div>
            <div class="mt-2">
              <div class="select">
                <select v-model="wordle.type">
                  <option :value="0">__ Acertar 1 o varias palabras</option>
                  <option :value="1">
                    _ Acertar 1 palabra aleatoria de un grupo de palabras
                  </option>
                </select>
              </div>
            </div>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isModalActive = false">
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-primary">
              <i class="fas fa-save mr-1"></i> {{ trans.get("general.save") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
import InputEmoji from "../InputEmoji.vue";
// import Utils from "../../utils.js";

export default {
  components: { InputEmoji },
  props: ["code", "wordles", "active"],
  mounted() {
    this.wordlesReactive = _.orderBy(this.wordles, "id", "desc");
  },
  data: function () {
    return {
      isModalActive: false,
      wordlesReactive: null,
      wordle: {
        type: 0,
        xp: 20,
        gold: 50,
        dictionary: 0,
      },
    };
  },
  methods: {
    select(wordle) {
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "active_wordle",
        action: "update",
        value: wordle,
      });
    },
    deleteWord(word) {
      axios
        .delete(`/classroom/${this.code}/games/wordle/word/${word}`)
        .then((response) => {
          this.wordlesReactive = _.orderBy(response.data, "id", "desc");
          this.$forceUpdate();
        });
    },
    addWordle() {
      axios
        .post(`/classroom/${this.code}/games/wordle`, this.wordle)
        .then((response) => {
          this.wordlesReactive = _.orderBy(response.data, "id", "desc");
          this.isModalActive = false;
          this.$forceUpdate();
        });
    },
    addWord(wordle) {
      this.$buefy.dialog.prompt({
        message: this.trans.get("wordle.word"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        inputAttrs: {
          placeholder: this.trans.get("wordle.word"),
          minlength: 4,
          maxlength: 6,
        },
        trapFocus: true,
        onConfirm: (value) => {
          axios
            .post(`/classroom/${this.code}/games/wordle/word`, {
              word: value,
              wordle: wordle,
            })
            .then((response) => {
              this.wordlesReactive = _.orderBy(response.data, "id", "desc");
              this.$forceUpdate();
            });
        },
      });
    },
  },
};
</script>