<template>
  <div class="p-2">
    <h2 v-if="this.is_game_over">{{ this.game_over_msg }}</h2>
    <div class="invalid-word">{{ this.invalidMsg }}</div>
    <LetterGrid
      v-bind:letterArray="this.letterArray"
      v-bind:rightSpot="this.rightSpot"
      v-bind:rightLetter="this.rightLetter"
      ref="letterGrid"
    />
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
    let word_list = ["acaba"];
    let three_words = word_list.sort(() => 0.5 - Math.random()).slice(0, 3);
    let first_word = three_words[0];

    return {
        
      letterArray: [[], [], [], [], [], []],
      stateArray: [[], [], [], [], [], []],
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
    this.startGame();
  },
  methods: {
    startGame() {
      this.round++;
      //   this.$refs.stopwatchRef.start();
      this.showKeyboard = true;
    },
    fillTile(button, row) {
      if (!this.is_game_over && !this.is_round_over) {
        this.letterArray[row].push(button);
        this.$refs.letterGrid.$forceUpdate();
      }
    },
    backspace(row) {
      if (!this.is_game_over) {
        this.letterArray[row] = this.letterArray[row].slice(0, -1);
        this.$refs.letterGrid.$forceUpdate();
      }
    },
    checkYellowLetter(letter, word, position, row) {
      this.yellowAppearances = 0;
      for (let i = 0; i < word.length; i++) {
        if (letter == word[i]) {
          if (i != position) {
            let reg = new RegExp(word[i], "g");
            if ((word.match(reg) || []).length > 1) {
              console.log(
                "Detectada lletra " + letter + " no al lloc " + position
              );
              this.rightLetter.push(row + "" + i);
              break;
            }
            //       if(this.rightSpot.includes(row + "" + i)) {
            //           console.log("Ja està bé!")
            //       } else {
            //           console.log("No està bé!")
            //           this.rightLetter.push(row + "" + i);
            //           this.yellowAppearances++;
            //       }
          }
        }
      }
    },
    checkGreenLetter(letter, word, position, row) {
      for (let i = 0; i < word.length; i++) {
        if (letter == word[i]) {
          if (i == position) {
            // this.rightAppearances++;
            // this.rightAppearances[letter]++;
            console.log("Right " + letter);
            // right spot
            this.rightSpot.push(row + "" + i);
            this.greenKey.push(word[i].toUpperCase());

            // CHECK
            if (this.yellowKey.includes(word[i].toUpperCase())) {
              this.yellowKey = this.yellowKey.filter(function (f) {
                return f !== word[i].toUpperCase();
              });
            }
          }
        }
        // console.log(letter + " " + this.appearances);
      }
    },
    checkWord(word, row) {
      this.invalidMsg = "";
      if (word === this.word) {
        // this.is_round_over = true;
        for (let i = 0; i < this.word.length; i++) {
          // right spot
          this.rightSpot.push(row + "" + i);
          this.stateArray[row][i] = 2;
        }

        this.triesCount += row + 1;

        // if (this.round === 3) {
        //   this.is_game_over = true;
        //   this.game_over_msg =
        //     "Congratulations! You completed all 3 rounds in " +
        //     this.triesCount +
        //     " total tries!";
        //   //   this.$refs.stopwatchRef.stop();
        //   this.showKeyboard = false;
        // }
      } else {
        for (let i = 0; i < word.length; i++) {
          if (this.word.indexOf(word[i]) == -1) {
            this.stateArray[row][i] = 0;
            this.grayKey.push(word[i].toUpperCase());
          } else {
            if (this.word[i] == word[i]) {
              this.stateArray[row][i] = 2;
              this.greenKey.push(word[i].toUpperCase());
            }
          }
        }
        for (let i = 0; i < word.length; i++) {
            if (this.word[i] == word[i]) {
              this.stateArray[row][i] = 2;
              this.greenKey.push(word[i].toUpperCase());
            }
          }
        }

        // for (let i = 0; i < word.length; i++) {
        //   if (this.word.indexOf(word[i]) == -1) {
        //     this.grayKey.push(word[i].toUpperCase());
        //   } else {
        //     console.log("Checking " + word[i]);

        //     // this.checkGreenLetter(word[i], this.word, i, row);
        //     // this.checkYellowLetter(word[i], this.word, i, row);
        //   }
        // }
        // this.$forceUpdate();
        // this.$refs.letterGrid.$forceUpdate();

        // for (let i = 0; i < this.word.length; i++) {
        //   if (this.word[i] === word[i]) {
        //     // right spot
        //     this.rightSpot.push(row + "" + i);
        //     this.greenKey.push(word[i].toUpperCase());
        //     if (this.yellowKey.includes(word[i].toUpperCase())) {
        //       this.yellowKey = this.yellowKey.filter(function (f) {
        //         return f !== word[i].toUpperCase();
        //       });
        //     }
        //   } else {
        //     for (let j = 0; j < this.word.length; j++) {
        //       if (this.word[j] === word[i]) {
        //         // right letter
        //         console.log("Checking " + word[i]);
        //         console.log(this.greenKey);
        //         console.log(this.yellowKey);
        //         if (!this.greenKey.includes(word[i].toUpperCase())) {
        //           this.rightLetter.push(row + "" + i);
        //           console.log("Not find in greenkey");
        //           this.yellowKey.push(word[i].toUpperCase());
        //         } else {
        //         }
        //       }
        //     }
        //     if (
        //       !this.greenKey.includes(word[i].toUpperCase()) &&
        //       !this.yellowKey.includes(word[i].toUpperCase())
        //     ) {
        //       this.grayKey.push(word[i].toUpperCase());
        //     }
        //   }
        // }
    //   }
      if (row === 5 && word !== this.word) {
        this.game_over_msg =
          "Tough Scene. You didn't get the word: " + this.word.toUpperCase();
        this.is_game_over = true;
        // this.$refs.stopwatchRef.stop();
        this.showKeyboard = false;
      }
    },
    invalidWord(word) {
      this.invalidMsg = word.toUpperCase() + " is not a valid word.";
      setTimeout(() => (this.invalidMsg = ""), 2500);
    },
    nextRound() {
      this.is_round_over = false;
      this.round++;
      this.word = this.words[this.round - 1];
      this.letterArray = [[], [], [], [], [], []];
      this.$refs.keyboardRef.reset();
      this.rightSpot = [];
      this.rightLetter = [];
      this.greenKey = [];
      this.yellowKey = [];
      this.grayKey = [];
    },
  },
};
</script>

<style>
#app {
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
}
</style>