<template>
    <el-tiptap
            v-model="$parent.content"
            :extensions="extensions"
            placeholder="Write here some fun stuff!"
        />
</template>

<script>

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
  Table ,
  TableHeader,
  TableCell,
  TableRow,
  FormatClear,
  TextColor,
  TextHighlight,
  Preview,
  Print,
  Fullscreen,
  FontType,
  FontSize
} from 'element-tiptap';



  export default {
        created() {

        },
        data: function() {
            return {
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
                        new Image(),
                        new CodeBlock(),
                        new Blockquote(),
                        new TextAlign(),
                        new Indent(),
                        new LineHeight(),
                        new HorizontalRule(),
                        new Table (),
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
                        new Preview(),
                    ],
                   
            }
        },
        methods: {
            
        },
      }
</script>