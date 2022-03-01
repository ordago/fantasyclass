<template>
  <div>
    <Keypress key-event="keydown" @success="write" />
    <div :class="keyboardClass"></div>
  </div>
</template>

<script>
import Keyboard from "simple-keyboard";
import "simple-keyboard/build/css/index.css";

export default {
  name: "SimpleKeyboard",
  props: {
    keyboardClass: {
      default: "simple-keyboard",
      type: String,
    },
    input: {
      type: String,
    },
    rowNum: {
      type: Number,
    },
    currentRow: {
      type: Number,
    },
    availableWords: Array,
    greenKey: Array,
    yellowKey: Array,
    grayKey: Array,
  },
  watch: {
    greenKey: {
      deep: true,
      handler: function (newValue) {
        this.keyboard.setOptions({
          buttonTheme: [
            {
              class: "hg-green",
              buttons: newValue.join(" ").toUpperCase(),
            },
            {
              class: "hg-yellow",
              buttons: this.yellowKey.join(" ").toUpperCase(),
            },
            {
              class: "hg-gray",
              buttons: this.grayKey.join(" ").toUpperCase(),
            },
          ],
        });
      },
    },
    yellowKey: {
      deep: true,
      handler: function (newValue) {
        this.keyboard.setOptions({
          buttonTheme: [
            {
              class: "hg-green",
              buttons: this.greenKey.join(" ").toUpperCase(),
            },
            {
              class: "hg-yellow",
              buttons: newValue.join(" ").toUpperCase(),
            },
            {
              class: "hg-gray",
              buttons: this.grayKey.join(" ").toUpperCase(),
            },
          ],
        });
      },
    },
    grayKey: {
      deep: true,
      handler: function (newValue) {
        this.keyboard.setOptions({
          buttonTheme: [
            {
              class: "hg-yellow",
              buttons: this.yellowKey.join(" ").toUpperCase(),
            },
            {
              class: "hg-green",
              buttons: this.greenKey.join(" ").toUpperCase(),
            },
            {
              class: "hg-gray",
              buttons: newValue.join(" ").toUpperCase(),
            },
          ],
        });
      },
    },
  },
  data: () => ({
    keyboard: null,
    word: "",
    row: 0,
  }),
  mounted() {
    this.row = this.currentRow
    this.keyboard = new Keyboard(this.keyboardClass, {
      onChange: this.onChange,
      onKeyPress: this.onKeyPress,
      theme: "hg-theme-default hg-layout-default myTheme",
      layout: {
        default: [
          "Q W E R T Y U I O P",
          "A S D F G H J K L Ç Ñ",
          "{bksp} Z X C V B N M {enter}",
        ],
      },
      display: {
        "{bksp}": "back",
        "{enter}": "enter",
      },
      buttonTheme: [
        {
          class: "hg-green",
          buttons: this.greenKey.join(" ").toUpperCase(),
        },
      ],
    });
  },
  components: {
    Keypress: () => import("vue-keypress"),
  },
  methods: {
    backspace: function (event) {
      if (event.event.keyCode == 8) this.write(event);
    },
    write: function (event) {
      let key = event.event.key;
      switch (event.event.keyCode) {
        case 13:
          key = "{enter}";
          break;
        case 8:
          key = "{bksp}";
          break;
      }
      this.onKeyPress(key);
    },
    onKeyPress(button) {
      //   this.$emit("onKeyPress", button);

      this.$parent.$refs.letterGrid.$forceUpdate();
      var letters = /^[a-zA-ZçÇñÑ]+$/;
      if (this.word.length < this.rowNum && button.length == 1 && button.match(letters)) {
        this.$emit("fill-tile", button, this.row);
        this.word += button;
      }

      if (button === "{bksp}") {
        this.word = this.word.substring(0, this.word.length - 1);
        this.$emit("backspace", this.row);
      }

      if (button === "{enter}" && this.word.length === this.rowNum) {
        if (
          !this.availableWords.find(
            (element) => element == this.word.toLowerCase()
          )
        ) {
          this.$emit("invalid-word", this.word.toLowerCase());
        } else {
          this.$emit("check-word", this.word.toLowerCase(), this.row);
          this.word = "";
          this.row += 1;
        }

        // axios
        //   .get(`https://api.dictionaryapi.dev/api/v2/entries/en/${this.word}`)
        //   .then(() => {
        //     this.$emit("check-word", this.word.toLowerCase(), this.row);
        //     this.word = "";
        //     this.row += 1;
        //   })
        //   .catch(() => {
        //     console.log("faile");
        //     this.$emit("invalid-word", this.word.toLowerCase());
        //   });
      }
    },
    reset() {
      this.word = "";
      this.row = 0;
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.simple-keyboard.hg-layout-default .hg-button.hg-green {
  background: green;
  color: white;
}
.simple-keyboard.hg-layout-default .hg-button.hg-yellow {
  background: #b59f3a;
  color: white;
}
.simple-keyboard.hg-layout-default .hg-button.hg-gray {
  background: rgb(50, 50, 50);
  color: white;
}
</style>