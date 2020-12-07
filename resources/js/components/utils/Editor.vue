<template>
  <div class="content">
    <div class="tag is-warning my-2">
      %HP% <i class="fas fa-heart colored"></i>
      <i class="fal fa-ellipsis-v mx-3"></i> %XP%
      <i class="fas fa-fist-raised colored"></i>
      <i class="fal fa-ellipsis-v mx-3"></i> %GOLD%
      <i class="fas fa-coins colored"></i>
    </div>

    <el-tiptap
      :extensions="extensions"
      :height="height"
      placeholder="Write here some fun stuff!"
      v-model="content"
      @onUpdate="updateValue()"
    />
  </div>
</template>

<script>
import Vue from "vue";

import ElementUI from "element-ui";
import { ElementTiptapPlugin } from "element-tiptap";

// import ElementUI's styles
import "element-ui/lib/theme-chalk/index.css";
// import this package's styles
import "element-tiptap/lib/index.css";
// use ElementUI's plugin
Vue.use(ElementUI);
// use this package's plugin
Vue.use(ElementTiptapPlugin, {
  /* plugin options */
});
// Now you register `'el-tiptap'` component globally.

import {
  // necessary extensions
  Doc,
  Text,
  Paragraph,
  Heading,
  Bold,
  Underline,
  Italic,
  Strike,
  ListItem,
  BulletList,
  OrderedList,
  Link,
  Image,
  Iframe,
  CodeBlock,
  Blockquote,
  TextAlign,
  Indent,
  LineHeight,
  HorizontalRule,
  HardBreak,
  History,
  Table,
  TableHeader,
  TableCell,
  TableRow,
  FormatClear,
  TextColor,
  TextHighlight,
  Print,
  Fullscreen,
  FontType,
  FontSize,
} from "element-tiptap";

export default {
  props: ["code", "height"],
  mounted() {
    this.content = this.$attrs.value; 
  },
  data: function () {
    return {
      content: ``,
      extensions: [
        new Doc(),
        new Text(),
        new History(),
        new Paragraph(),
        new Heading({ level: 5 }),
        new Bold(), // render command-button in bubble menu.
        new Underline(), // render command-button in bubble menu but not in menubar.
        new Italic(),
        new Strike(),
        new ListItem(),
        new BulletList(),
        new OrderedList(),
        new Link(),
        new Image({
          uploadRequest(file) {
            let formData = new FormData();
            formData.append("file", file);
            const request = axios.post("/classroom/challenges/image", formData);
            return request.then((result) => {
              return result.data;
            });
          },
        }),
        new CodeBlock(),
        new Blockquote(),
        new TextAlign(),
        new Indent(),
        new LineHeight(),
        new HorizontalRule(),
        new Table(),
        new TableHeader(),
        new TableCell(),
        new TableRow(),
        new FontType(),
        new FontSize(),
        new TextColor(),
        new TextHighlight(),
        new FormatClear(),
        new Print(),
        new Fullscreen(),
      ],
    };
  },
  methods: {
    sendImage() {},
    updateValue: function () {
      this.$emit("input", this.content);
    },
  },
  components: {
    ElementUI,
    ElementTiptapPlugin,
  },
};
</script>
<style>
.el-tiptap-editor > .el-tiptap-editor__content {
  background-color: #e7daa8;
}
</style>