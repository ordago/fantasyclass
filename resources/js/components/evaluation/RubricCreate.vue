<template>
  <form @submit.prevent="createRubric" class="has-padding-3">
    <div class="field">
      <label class="label">Name</label>
      <div class="control">
        <input class="input" type="text" v-model="rubric.name" />
      </div>
    </div>
    <div class="field">
      <label class="label">Name</label>
      <div class="control">
        <div class="rubric-row m-1">
          <div class="p-2">
            <input
              type="checkbox"
              data-toggle="popover"
              data-placement="top"
              data-trigger="hover"
              data-tippy-content="Opcional (serveix per a donar punts extra o penalitzacions)"
            />
          </div>
          <div class="description">
            <textarea style="height:100%" placeholder="Descripció general"></textarea>
          </div>
          <div
            class="button is-success addRubricItem"
            data-toggle="popover"
            data-placement="right"
            data-trigger="hover"
            data-tippy-content="Afegir element a la fila"
            onclick="addItem(this)"
            tabindex="0"
          >
            <i class="fas fa-plus"></i>
          </div>
          <div class="subItems">
            <div class="subItem">
              <div class="message has-margin-top-4 has-margin-bottom-1 is-flex has-all-centered">
                <textarea
                  class="rich-editor-container rounded has-padding-4"
                  ref="textarea1"
                  @keypress.enter.prevent
                  @click="handleEditorClick('textarea1')"
                  placeholder="Type a message..."
                >
                </textarea>
                  <emoji-picker @emoji:picked="handleEmojiPicked($event, 'textarea1')" :data="data" />
            
              </div>
              <div id="container"></div>
              <div class="pointsItem">
                <input type="number" value="0" style="width: 4em;" min="0" /> Punts
              </div>
              <div class="button is-danger delSubItem" onclick="delSubItem(this)">
                <i class="far fa-trash-alt"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import EmojiPicker from "@zaichaopan/emoji-picker";
Vue.use(EmojiPicker);
import data from "@zaichaopan/emoji-picker/data/emojis.json";

export default {
  props: ["classroom"],
  mounted() {},
  data: function() {
    return {
      rubric: {
        name: "",
        rows: []
      },
      data: data
    };
  },
  methods: {
    createRubric() {},
    handleEmojiPicked(emoji, text) {
      console.log(emoji)
      console.log(this.$refs[text].value)
      // this.$refs[text].value = `${this.$refs[text].value} ${emoji}`;
      this.$refs[text].value += emoji;
    },
    handleEditorClick(text) {
      this.focusEditor(text);
    },
    focusEditor(text) {
      this.$refs[text].focus();
    }
  }
};
</script>
<style scoped lang="scss">
.emoji-dropdown .emoji-preview,
.emoji-dropdown .title {
  display: none !important;
}
.message {
  position: relative;
  display: flex;
  width: 100%;
  .rich-editor-container {
    width: 100%;
    border: 1px solid #ddd;
    padding: 5px 40px 5px 15px;
    &:focus {
      outline: none;
    }
  }
  .message-emoji {
    position: absolute;
    right: 9px;
    top: 9px;
  }
  [contenteditable="true"]:empty:before {
    content: attr(placeholder);
    color: grey;
  }
}
.rubric-rows {
  display: block;
  position: relative;
  background-color: #efefef;
  padding: 30px;
  border-radius: 5px;
  margin: 10px auto 10px auto;
  border: 1px solid #757575;
}
.rubric-row {
  display: flex;
  overflow-x: auto;
  overflow-y: visible;
  width: 100%;
}
.addRubricItem {
  margin: 0 0 0 10px;
}
.subItem {
  background-color: white;
  padding: 10px;
  margin: 0 4px 0 4px;
  border: 1px solid #aaa;
  border-radius: 10px;
  position: relative;
  overflow: visible;
}
.subItems {
  display: flex;
}
.delSubItem {
  position: absolute;
  bottom: -1px;
  right: 0;
}
.input p,
input {
  padding: 7px;
  border: 1px solid #aaa;
  border-radius: 5px;
}
</style>