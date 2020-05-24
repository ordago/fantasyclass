<template>
            <div class="w-100">
                <div class="field w-100">
                    <label class="label">Name *</label>
                    <div class="control">
                        <input class="input" type="text" placeholder="">
                    </div>
                </div>
                <div class="field w-100">
                    <label class="label">Description</label>
                    <div class="control">
                        <input class="input" type="text" placeholder="This is for info for you. E.g. Trigonometry test">
                    </div>
                </div>
                <div class="w-100">
                    <b-field label="When it will be visible?">
                    <b-datetimepicker v-model="datetime"
                        placeholder="Click to select..."
                        icon-pack="fa"
                        >
                        <template slot="left">
                            <button class="button is-primary"
                                @click="datetime = new Date()">
                                <b-icon icon="clock"></b-icon>
                                <span>Now</span>
                            </button>
                        </template>
                        <template slot="right">
                            <button class="button is-danger"
                                @click="datetime = null">
                                <b-icon icon="close"></b-icon>
                                <span>Clear</span>
                            </button>
                        </template>
                    </b-datetimepicker>
                    </b-field>
                </div>
                <div class="field w-100 has-padding-top-3">
                    <label class="label">Description</label>
                    <div class="control" data-app>
                            <el-tiptap
                                v-model="content"
                                :extensions="extensions"
                                placeholder="Write there some fun stuff!"
                                />
                    </div>
                </div>
            </div>
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
            props: ['challengeGroup'],
            mounted: function() {
               
            },
            data: function() {
                return {
                    challenges: [],
                    addChallenge: false,
                    datetime: new Date(),
                     extensions: [
                         new Doc(),
                            new Text(),
                            new History(),
                            new Paragraph(),
                            new Heading({ level: 5 }),
                            new Bold({ bubble: true, menubar: false }), // render command-button in bubble menu.
                            new Underline({ bubble: true, menubar: false }), // render command-button in bubble menu but not in menubar.
                            new Italic({ bubble: true, menubar: false }),
                            new Strike({ bubble: true, menubar: false }),
                            new ListItem(),
                            new BulletList(),
                            new OrderedList(),
                            new Link({ bubble: true, menubar: false }),
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
                                new FontType({ bubble: true, menubar: false }),
                                new FontSize({ bubble: true, menubar: false }),
                                new TextColor({ bubble: true, menubar: false }),
                                new TextHighlight({ bubble: true, menubar: false }),
                                new FormatClear({ bubble: true, menubar: false }),
                                new Print(),
                                new Fullscreen(),
                                new Preview(),
                            ],
                            // editor's content
                            content: ``,
                    
                }
            },
            methods: {
                
            },
         

            computed: {
                buttonAddChallege() {
                    return  this.addChallenge ? this.trans.get('general.cancel') : "<i class='far fa-plus has-padding-right-2'></i>" + this.trans.get('challenges.add')  
                },
            },
    }
</script>
