<template>
  <div class="message has-margin-top-4 has-margin-bottom-1 is-flex has-all-centered">
        <div contenteditable="true"
             class="rich-editor-container rounded has-padding-4"
             ref="textarea"
             autofocus="false"
             @keypress.enter.prevent
             @input="updateBody($event.target.innerHTML)"
             @click="handleEditorClick"
             :placeholder="trans.get('general.type_message')">
        </div>
        <button class="button is-link" @click="$parent.sendComment();$refs.textarea.innerHTML=''" v-if="$parent.comment.length"><i class="fas fa-comment"></i></button>
        <div class="message-emoji">
            <emoji-picker @emoji:picked="handleEmojiPicked"
                          :data="data" />
        </div>
    </div>
</template>

<script>
import EmojiPicker from '@zaichaopan/emoji-picker';

Vue.use(EmojiPicker);

import data from "@zaichaopan/emoji-picker/data/emojis.json";

export default {
  data() {
    return {
      data: data,
      body: ""
    };
  },
  methods: {
    updateBody(text) {
      this.body = text;
      this.$parent.comment = text
    },
    handleEmojiPicked(emoji) {
      this.$refs.textarea.innerHTML = `${
        this.$refs.textarea.innerHTML
      } ${emoji}`;
      this.updateBody(this.$refs.textarea.innerHTML);
    },
    handleEditorClick() {
      this.focusEditor();
    },
    focusEditor() {
      this.$refs.textarea.focus();
    }
  },
  mounted() {
    this.focusEditor();
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.emoji-picker .emoji-dropdown {
  z-index: 100;
}
.emoji-dropdown .emoji-preview, .emoji-dropdown .title {
  display: none!important;
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
    right: 50px;
    top: 9px;
  }
  [contenteditable="true"]:empty:before {
    content: attr(placeholder);
    color: grey;
  }
}
</style>
