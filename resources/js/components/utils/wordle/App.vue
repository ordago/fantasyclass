<template>
  <div class="p-2">
    <div @click="isModalActive = true" class="top-right fs-2 cursor-pointer" style="right: 10px;">
      <span class="is-hidden-mobile">{{ trans.get("wordle.how_play") }}</span> <i class="fa-solid fa-circle-question"></i>
    </div>
    <div
      class="has-text-centered p-2 fs-2"
      v-if="words && reward && reward.length"
    >
      {{ words.length }} <i class="fas fa-w"></i>: {{ reward[0] }}
      <i class="fas fa-fist-raised colored"></i> {{ reward[1] }}
      <i class="fas fa-coins colored"></i>
    </div>

    <LetterGrid
      :row="word.length"
      v-if="this.letterArray.length"
      v-bind:letterArray="this.letterArray"
      ref="letterGrid"
    />
    <Keyboard
      :current-row="currentRow"
      :row-num="word.length"
      style="max-width: 400px; margin: 0 auto"
      @fill-tile="fillTile"
      @backspace="backspace"
      @check-word="checkWord"
      @invalid-word="invalidWord"
      :availableWords="availableWords"
      v-if="showKeyboard"
      v-bind:greenKey="this.greenKey"
      v-bind:yellowKey="this.yellowKey"
      v-bind:grayKey="this.grayKey"
      ref="keyboardRef"
    />
    <div class="has-text-centered" v-if="!showKeyboard">
      <button class="button" @click="reloadPage()">
        {{ trans.get("notifications.go_to") }}
        {{ trans.get("general.classroom") }}
      </button>
    </div>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              <i class="fas fa-w mr-2"></i
              >{{ trans.get("wordle.how_play") }}
            </p>
          </header>
          <section class="modal-card-body">
            <p>{{ trans.get('wordle.info_general') }}</p>
            <div class="my-1 is-flex is-center-vertically">
              <img src="/img/wordlefc/green.png" class="mr-2" alt="green key" width="30px"> {{ trans.get('wordle.info_green') }}
            </div>
            <div class="my-1 is-flex is-center-vertically">
              <img src="/img/wordlefc/yellow.png" class="mr-2" alt="yellow key" width="30px"> {{ trans.get('wordle.info_yellow') }}
            </div>
            <div class="my-1 is-flex is-center-vertically">
              <img src="/img/wordlefc/gray.png" class="mr-2" alt="gray key" width="30px"> {{ trans.get('wordle.info_yellow') }}
            </div>
            <p class="mt-2">{{ trans.get('wordle.info_end') }}</p>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isModalActive = false">
              {{ trans.get("general.close") }}
            </button>
          </footer>
        </div>
    </b-modal>
  </div>
</template>

<script>
import LetterGrid from "./components/LetterGrid";
import Keyboard from "./components/Keyboard";
import confetti from "canvas-confetti";

export default {
  name: "App",
  props: ["code", "availableWords"],
  components: {
    LetterGrid,
    Keyboard,
  },
  data() {
    return {
      isModalActive: false,
      currentRow: 0,
      letterArray: [],
      words: [],
      wordId: null,
      word: null,
      greenKey: [],
      yellowKey: [],
      grayKey: [],
      game_over_msg: "",
      is_game_over: false,
      round: 0,
      is_round_over: false,
      showKeyboard: false,
      triesCount: 0,
      invalidMsg: "",
      appearances: 0,
      reward: [],
      rightAppearances: 0,
      yellowAppearances: 0,
      messages: [
        this.trans.get("wordle.genius"),
        this.trans.get("wordle.magnificent"),
        this.trans.get("wordle.impressive"),
        this.trans.get("wordle.splendid"),
        this.trans.get("wordle.great"),
        this.trans.get("wordle.phew"),
      ],
    };
  },

  mounted() {
    axios.get(`/classroom/${this.code}/games/wordle/load`).then((response) => {
      this.words = response.data.words;
      this.wordId = this.words[0].id;
      this.word = this.words[0].word;
      this.reward = response.data.reward;
      this.createLetterArray(this.word.length);
      if (response.data.attempt) {
        this.letterArray = JSON.parse(response.data.attempt);
        for (let i = 1; i < this.letterArray.length; i++) {
          if (!this.letterArray[i][0].letter) {
            this.currentRow = i;
            break;
          }
          for(let j = 0; j < this.letterArray[i].length; j++) {
            // TODO Highlight keyboard keys
          }
        }
      }

      // Accept the current word
      this.availableWords.push(this.word);

      this.startGame();
    });
  },
  methods: {
    reloadPage() {
      location.reload();
    },
    createLetterArray(dimensions) {
      for (let i = 0; i < 6; i++) {
        let row = [];
        for (let j = 0; j < dimensions; j++) {
          row.push({ letter: null, state: null });
        }
        this.letterArray.push(row);
      }
      this.$forceUpdate();
    },
    startGame() {
      this.round++;
      this.showKeyboard = true;
    },
    fillTile(button, row) {
      if (!this.is_game_over && !this.is_round_over) {
        var i = 0;

        for (let obj of this.letterArray[row]) {
          if (!obj.letter) {
            obj.letter = button;
            break;
          }
        }
        this.$refs.letterGrid.$forceUpdate();
      }
    },
    backspace(row) {
      for (let tile of this.letterArray[row].reverse()) {
        if (tile.letter) {
          tile.letter = "";
          break;
        }
      }
      this.letterArray[row].reverse();
    },
    checkWord(word, row) {
      if (word === this.word) {
        for (let i = 0; i < this.word.length; i++) {
          this.letterArray[row][i].state = "correct";
        }
        this.showKeyboard = false;
        confetti({
          particleCount: 200,
          spread: 100,
          origin: { y: 1.0 },
        });

        this.$toast.success(this.messages[row], {
          position: "top-center",
          timeout: 10000,
          closeButton: false,
          closeOnClick: false,
          showCloseButtonOnHover: false,
          hideProgressBar: true,
          icon: false,
          rtl: false,
        });
        this.sendState(2);
      } else {
        let answerLetters = this.word.split("");
        this.letterArray[row].forEach((tile, i) => {
          if (answerLetters[i] === tile.letter) {
            tile.state = "correct";
            answerLetters[i] = null;
            if (!this.greenKey.includes(tile.letter)) {
              this.greenKey.push(tile.letter);
              if (this.yellowKey.includes(tile.letter))
                this.yellowKey.splice(this.yellowKey.indexOf(tile.letter), 1);
            }
          }
        });

        this.letterArray[row].forEach((tile) => {
          if (!tile.state && answerLetters.includes(tile.letter)) {
            tile.state = "present";
            answerLetters[answerLetters.indexOf(tile.letter)] = null;
            if (
              !this.greenKey.includes(tile.letter) &&
              !this.yellowKey.includes(tile.letter)
            ) {
              this.yellowKey.push(tile.letter);
            }
          }
        });
        this.letterArray[row].forEach((tile) => {
          if (!tile.state) {
            tile.state = "absent";
            if (
              !this.greenKey.includes(tile.letter) &&
              !this.yellowKey.includes(tile.letter)
            ) {
              this.grayKey.push(tile.letter);
            }
          }
        });
        if (row === 5 && word !== this.word) {
          this.sendState(1);
          this.$toast.error(
            this.trans.get("wordle.gameover") + this.word.toUpperCase(),
            {
              position: "top-center",
              timeout: 10000,
              closeOnClick: false,
              showCloseButtonOnHover: false,
              hideProgressBar: true,
              icon: true,
              rtl: false,
            }
          );

          this.is_game_over = true;
          this.showKeyboard = false;
          setTimeout(() => location.reload(), 5000);
        } else {
          this.sendState(0);
        }
      }
    },
    sendState(state) {
      axios.post(`/classroom/${this.code}/games/wordle/state`, {
        word: this.wordId,
        progress: this.letterArray,
        state: state,
      });
    },
    invalidWord(word) {
      this.$toast.error(
        word.toUpperCase() + this.trans.get("wordle.incorrect"),
        {
          position: "top-center",
          timeout: 2000,
          closeOnClick: true,
          showCloseButtonOnHover: false,
          hideProgressBar: true,
          closeButton: "button",
          icon: true,
          rtl: false,
        }
      );
    },
    nextRound() {
      //   this.is_round_over = false;
      //   this.round++;
      //   this.word = this.words[this.round - 1];
      //   this.letterArray = [[], [], [], [], [], []];
      //   this.$refs.keyboardRef.reset();
      //   this.rightSpot = [];
      //   this.rightLetter = [];
      //   this.greenKey = [];
      //   this.yellowKey = [];
      //   this.grayKey = [];
    },
  },
};
</script>

<style>
.correct,
.present,
.absent {
  color: #fff !important;
}

.correct {
  background-color: #6aaa64 !important;
}

.present {
  background-color: #c9b458 !important;
}

.absent {
  background-color: #787c7e !important;
}
/* #app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
  margin: 0 auto;
}
h1 {
  color: white;
}
h2 {
  color: rgb(97, 112, 174);
}
button {
  padding: 10px;
  font-family: Avenir, Helvetica, Arial, sans-serif;
  border: none;
  border-radius: 5px;
  background-color: white;
}
button:hover {
  background-color: rgb(12, 164, 30);
  color: white;
  cursor: pointer;
}
.invalid-word {
  color: red;
} */
</style>