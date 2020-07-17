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
        <div v-for="(row, index) in rubric.rows" :key="index" class="rubric-row has-margin-y-2">
          <div class="has-padding-2">
            <input
              type="checkbox"
              data-toggle="popover"
              data-placement="top"
              data-trigger="hover"
              data-tippy-content="Opcional (serveix per a donar punts extra o penalitzacions)"
            />
          </div>
          <div class="description">
            <textarea
              style="height:100%"
              v-model="row.description"
              placeholder="Descripció general"
            ></textarea>
          </div>
          <div
            class="button is-success addRubricItem"
            data-toggle="popover"
            data-placement="right"
            data-trigger="hover"
            data-tippy-content="Afegir element a la fila"
            @click="addColumn(index)"
            tabindex="0"
          >
            <i class="fas fa-plus"></i>
          </div>
          <div class="subItems">
            <div class="subItem" v-for="(column, indexCol) in row.columns" :key="indexCol">
              <div class="message has-margin-bottom-1 is-flex has-all-centered">
                <textarea
                  class="rich-editor-container rounded has-padding-4"
                  :ref="'textarea' + index + indexCol"
                  @keypress.enter.prevent
                  @click="handleEditorClick('textarea' + index + indexCol)"
                  v-model="column.description"
                ></textarea>
                <emoji-picker @emoji:picked="handleEmojiPicked($event, 'textarea' + index + indexCol)" :data="data" />
              </div>
              <div id="container"></div>
              <div class="pointsItem">
                <input type="number" v-model="column.points" value="0" style="width: 4em;" min="0" /> Punts
              </div>
              <div class="button is-danger delSubItem" @click="delSubItem(index, indexCol)">
                <i class="far fa-trash-alt"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button class="button is-primary" @click="addRow">Add row</button>
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
    delSubItem(index, indexCol) {

      console.log(this.rubric.rows[index].columns[indexCol].points)
      this.rubric.rows[index].columns.splice(indexCol, 1)
    },
    addColumn(index) {
      let row = this.rubric.rows[index];
      let points = this.rubric.rows[index].columns[this.rubric.rows[index].columns.length - 1].points + 1
      row.columns.push({ points: points, description: "" })
      this.$forceUpdate()
    },
    addRow() {
      let row = {
        description: "",
        opctional: false,
        columns: [{ points: 0, description: "" }]
      };
      this.rubric.rows.push(row);
    },
    createRubric() {},
    handleEmojiPicked(emoji, text) {
      this.$refs[text][0].value += emoji;
    },
    handleEditorClick(text) {
      console.log(text)
      this.focusEditor(text);
    },
    focusEditor(text) {
      this.$refs[text][0].focus();
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
  z-index: 10;
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
       z-index: 12;

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
  overflow: visible;
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