<template>
  <div class="p-2">
    <div class="buttons">
      <div class="button" @click="isModalActive = true">
        {{ trans.get("wordle.new_wordle") }}
      </div>
      <div class="button is-danger" @click="removeActive()">
        {{ trans.get("wordle.remove_active") }}
      </div>
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
          <span
            >{{ obj.xp }} <i class="fas fa-fist-raised"></i> / {{ obj.gold }}
            <i class="fas fa-coins"></i
          ></span>
          <span class="tag is-dark cursor-pointer" @click="showResults(obj.id)"
            >{{ trans.get('wordle.results') }}</span
          >
        </div>
        <div class="column is-narrow" v-if="obj.words && obj.words.length != 1">
          <button class="tag is-success" @click="addWord(obj.id)">
            {{ trans.get("wordle.new_word") }}
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
          <label :for="`w-${obj.id}`">{{ trans.get("wordle.active") }}</label>
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
          <div v-else>{{ trans.get("wordle.without_words") }}</div>
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
            <div class="mt-2" style="display: none">
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
    <b-modal
      :active.sync="isInfoModal"
      v-if="isInfoModal"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">WordleFC Info</p>
        </header>
        <section class="modal-card-body is-relative content">
          <div v-for="word in info" :key="'wordi-' + word.id">
            <h1>{{ word.word }}</h1>
            <div
              class="columns is-multiline is-variable is-relative is-1 p-2 pt-3"
            >
              <div
                class="
                  column
                  py-2
                  is-6-tablet is-12-mobile is-4-desktop is-3-fullhd
                "
                v-for="student in word.student"
                v-bind:key="student.id"
              >
                <h3
                  class="rounded p-2"
                  :class="{
                    'correct': student.pivot.state == 2,
                    'has-background-danger has-text-light': student.pivot.state == 1,
                    'has-background-grey-lighter': student.pivot.state == 0,
                  }"
                >
                  {{ student.name }}
                </h3>
                <div v-for="index in 6" :key="index">
                  <div
                    class=""
                    v-if="showRow(student.pivot.word_progress, index)"
                    v-html="getRow(student.pivot.word_progress, index)"
                  >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow is-12-mobile is-flex has-all-centered">
            <button class="button" type="button" @click="isInfoModal = false">
              {{ trans.get("general.close") }}
            </button>
          </div>
        </footer>
      </div>
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
      isInfoModal: false,
      isModalActive: false,
      wordlesReactive: null,
      info: [],
      wordle: {
        type: 0,
        xp: 20,
        gold: 50,
        dictionary: 0,
      },
    };
  },
  methods: {
    showRow(info, index) {
      let progress = JSON.parse(info);
      return progress[index - 1][0].letter ? true : false;
    },
    getRow(info, index) {
      let progress = JSON.parse(info);
      let row = "";

      progress[index - 1].forEach((element) => {
        let color = "absent";
        if (element.state == "present") color = "present";
        else if (element.state == "correct") color = "correct";

        row += `<span style="display: inline-block; width: 40px" class=' has-text-centered py-2 rounded border ${color}'>`;
        row += element.letter;
        row += "</span>";
      });
      return row;
    },
    showResults(wordle) {
      axios
        .post(`/classroom/games/wordle`, { wordle: wordle })
        .then((response) => {
          console.log(response.data);
          this.info = response.data;
          this.isInfoModal = true;
        });
    },
    removeActive() {
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "active_wordle",
        action: "remove",
      });
      this.active = null;
    },
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
        message: this.trans.get("wordle.word_info"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        inputAttrs: {
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