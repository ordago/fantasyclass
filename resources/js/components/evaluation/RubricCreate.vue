<template>
  <form @submit.prevent="createRubric" class="p-3">
    <div class="field">
      <label class="label">{{ trans.get('evaluation.name') }}</label>
      <div class="control">
        <input class="input" required minlength="3" type="text" v-model="rubric.name" />
      </div>
    </div>
    <div class="field">
      <label class="label">{{ trans.get('evaluation.rows') }}</label>
      <div class="control">
        <div v-for="(row, index) in rubric.rows" :key="index" class="rubric-row my-2">
          <div class="description">
            <textarea
              style="height:100%"
              v-model="row.description"
              :placeholder="trans.get('evaluation.general_description')"
              required
            ></textarea>
          </div>
          <div
            class="button is-success mx-2"
            v-tippy
            :content="trans.get('evaluation.add_column')"
            @click="addColumn(index)"
            tabindex="0"
          >
            <i class="fas fa-plus"></i>
          </div>
          <div class="subItems">
            <div class="subItem" v-for="(column, indexCol) in row.items" :key="indexCol">
              <div class="message mb-1 is-flex has-all-centered">
                <textarea
                  required
                  class="rich-editor-container rounded p-4"
                  :ref="'textarea' + index + indexCol"
                  @keypress.enter.prevent
                  @click="handleEditorClick('textarea' + index + indexCol)"
                  v-model="column.description"
                ></textarea>
                <emoji-picker
                  @emoji:picked="handleEmojiPicked($event, 'textarea' + index + indexCol)"
                  :data="data"
                />
              </div>
              <div id="container"></div>
              <div class="pointsItem">
                <input type="number" v-model="column.points" value="0" style="width: 4em;" min="0" />
                {{ trans.get('evaluation.points') }}
              </div>
              <div
                class="button is-danger delSubItem"
                v-if="!rubricEdit"
                @click="delSubItem(index, indexCol)"
              >
                <i class="far fa-trash-alt"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button class="button is-primary" @click.prevent="addRow">{{ trans.get('evaluation.add_row') }}</button>
    <button
      class="button is-info"
      @click.prevent="back"
      type="submit"
    >{{ trans.get('general.cancel') }}</button>
    <button
      class="button is-success"
      v-if="rubric.rows.length && !this.rubricEdit"
      type="submit"
    >{{ trans.get('evaluation.create_rubric') }}</button>
    <button
      class="button is-info"
      v-if="this.rubricEdit"
      type="submit"
    >{{ trans.get('evaluation.edit_rubric') }}</button>
  </form>
</template>

<script>
import EmojiPicker from "@zaichaopan/emoji-picker";
Vue.use(EmojiPicker);
import data from "@zaichaopan/emoji-picker/data/emojis.json";

export default {
  props: ["classroom", "rubricEdit"],
  created() {
    if (this.rubricEdit) this.rubric = this.rubricEdit;
  },
  data: function () {
    return {
      rubric: {
        name: "",
        rows: [],
      },
      data: data,
    };
  },
  methods: {
    delSubItem(index, indexCol) {
      this.rubric.rows[index].items.splice(indexCol, 1);
      if (this.rubric.rows[index].items.length == 0)
        this.rubric.rows.splice(index, 1);
    },
    addColumn(index) {
      let row = this.rubric.rows[index];
      let points =
        this.rubric.rows[index].items[this.rubric.rows[index].items.length - 1]
          .points + 1;
      row.items.push({ points: points, description: "" });
      this.$forceUpdate();
    },
    addRow() {
      let row = {
        description: "",
        optional: false,
        items: [{ points: 0, description: "" }],
      };
      this.rubric.rows.push(row);
    },
    back() {
      window.history.back();
    },
    createRubric() {
      if (this.rubricEdit) {
        axios
          .patch(
            "/classroom/" + this.classroom.code + "/rubric/" + this.rubric.id,
            {
              rubric: this.rubric,
              _method: "patch",
            }
          )
          .then((response) => {
            window.location.href =
              "/classroom/" + this.classroom.code + "/rubrics";
          });
      } else {
        axios
          .post("/classroom/" + this.classroom.code + "/rubric", {
            rubric: this.rubric,
          })
          .then((response) => {
            window.location.href =
              "/classroom/" + this.classroom.code + "/rubrics";
          });
      }
    },
    handleEmojiPicked(emoji, text) {
      const event = new Event("input");
      this.$refs[text][0].value += emoji;
      this.$refs[text][0].dispatchEvent(event);
    },
    handleEditorClick(text) {
      this.focusEditor(text);
    },
    focusEditor(text) {
      this.$refs[text][0].focus();
    },
  },
};
</script>
<style lang="scss">
.emoji-dropdown .emoji-preview,
.emoji-dropdown .title {
  display: none !important;
}
.message {
  position: relative;
  display: flex;
  width: 100%;
  // z-index: 10;
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
    // z-index: 12;
  }
  [contenteditable="true"]:empty:before {
    content: attr(placeholder);
    color: grey;
  }
}
.emoji-dropdown {
  z-index: 20 !important;
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