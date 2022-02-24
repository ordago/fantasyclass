<template>
  <div class="p-2">
    <h2 v-if="this.is_game_over">{{ this.game_over_msg }}</h2>
    <div class="invalid-word">{{ this.invalidMsg }}</div>
    <LetterGrid v-bind:letterArray="this.letterArray" ref="letterGrid" />
    <Keyboard
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
  </div>
</template>

<script>
import LetterGrid from "./components/LetterGrid";
import Keyboard from "./components/Keyboard";

export default {
  name: "App",
  props: ["availableWords"],
  components: {
    LetterGrid,
    Keyboard,
  },
  data() {
    // eslint-disable-next-line prettier/prettier
    let word_list = ["aaaaa"];
    let three_words = word_list.sort(() => 0.5 - Math.random()).slice(0, 3);
    let first_word = three_words[0];

    return {
      letterArray: [
        [
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
        ],
        [
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
        ],
        [
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
        ],
        [
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
        ],
        [
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
        ],
        [
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
          { letter: null, state: null },
        ],
      ],
      words: word_list,
      word: first_word,
      rightSpot: [],
      rightLetter: [],
      greenKey: [],
      yellowKey: [],
      grayKey: [],
      game_over_msg: "",
      is_game_over: false,
      difficulty: "Easy",
      round: 0,
      is_round_over: false,
      showKeyboard: false,
      triesCount: 0,
      invalidMsg: "",
      appearances: 0,
      rightAppearances: 0,
      yellowAppearances: 0,
    };
  },
  mounted() {
    // Accept the current word
    this.availableWords.push(this.word);
    this.startGame();
  },
  methods: {
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
      this.invalidMsg = "";
      if (word === this.word) {
        for (let i = 0; i < this.word.length; i++) {
          this.letterArray[row][i].state = "correct";
        }
        this.showKeyboard = false;

        this.triesCount += row + 1;
      } else {
        let answerLetters = this.word.split("");
        console.log(answerLetters);
        this.letterArray[row].forEach((tile, i) => {
          console.log(i);
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
            this.grayKey.push(tile.letter);
          }
        });
      }

      if (row === 5 && word !== this.word) {
        this.game_over_msg =
          "Tough Scene. You didn't get the word: " + this.word.toUpperCase();
        this.is_game_over = true;
        this.showKeyboard = false;
      }
    },
    invalidWord(word) {
      this.invalidMsg = word.toUpperCase() + " is not a valid word.";
      setTimeout(() => (this.invalidMsg = ""), 2500);
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