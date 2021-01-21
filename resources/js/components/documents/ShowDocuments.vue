<template>
  <div class="pl-0">
    <div class="panel is-primary pl-0">
      <p class="panel-heading is-flex has-space-between align-items-center p-3">
        <span>
          <i :class="documentgroup.icon"></i>
          <span class="pl-3">{{ documentgroup.name }}</span>
          <!-- <button style="font-size: .5em" class="button is-info"><i class="fas fa-edit"></i></button> -->
          <button
            style="font-size: 0.5em"
            class="button is-danger"
            @click="deleteDocumentGroup(documentgroup.id)"
            v-if="documentsMutable.length == 0 && !$parent.isLoading"
          >
            <i class="fas fa-trash"></i>
          </button>
        </span>
        <span>
          <button class="button" @click="modal = true">
            <span class="is-hidden-mobile">{{
              trans.get("documents.add")
            }}</span>
          </button>
        </span>
      </p>
      <div class="panel-block" v-if="documentsMutable.length == 0">
        <h3 class="is-size-3 p-4 w-100 has-text-centered">
          <i class="fal fa-smile-wink"></i>
          {{ trans.get("documents.empty") }}
        </h3>
      </div>

      <div class="panel-block is-block p-3" v-if="documentsMutable.length > 0">
        <draggable
          handle=".handle"
          v-model="documentsMutable"
          @start="drag = true"
          @end="finishDrop"
        >
          <div
            class="columns my-0 py-0 panel-block"
            v-for="document in documentsMutable"
            v-bind:key="document.id"
          >
            <div class="column is-narrow my-0 py-1">
              <i
                class="far fa-arrows-v handle mr-2 cursor-move"
                v-if="documentsMutable.length > 1"
              ></i>
            </div>
            <div class="column my-0 py-1">
              <ShowDocument
                class="mb-3"
                :code="code"
                :document="document"
                :admin="true"
              ></ShowDocument>
            </div>
          </div>
        </draggable>
      </div>
    </div>
    <b-modal :active.sync="modal" has-modal-card full-screen>
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("documents.new") }}</p>
        </header>
        <section class="modal-card-body">
          <b-field :label="trans.get('documents.name')">
            <b-input required v-model="document.name"></b-input>
          </b-field>
          <b-field :label="trans.get('documents.description')">
            <b-input v-model="document.description"></b-input>
          </b-field>
          <template>
            <b-tabs v-model="document.type" type="is-toggle" expanded>
              <b-tab-item
                :label="trans.get('documents.label')"
                icon-pack="fad"
                icon="font-case"
              ></b-tab-item>
              <b-tab-item
                :label="trans.get('documents.url')"
                icon-pack="fad"
                icon="window"
                class="p-2"
              >
                <b-field :label="trans.get('documents.url')">
                  <b-input type="url" required v-model="document.url"></b-input>
                </b-field>
              </b-tab-item>
              <b-tab-item
                :label="trans.get('documents.upload')"
                icon-pack="fad"
                icon="upload"
              >
                <div v-if="file" class="m-2 p-2">
                  <span class="tag is-primary">
                    {{ file.name }}
                    <button
                      class="delete is-small"
                      type="button"
                      @click="file = null"
                    ></button>
                  </span>
                </div>
                <b-upload
                  v-else
                  @input="onChange"
                  class="mt-2"
                  expanded
                  drag-drop
                >
                  <section class="section">
                    <div class="content has-text-centered">
                      <p>
                        <b-icon icon="upload" size="is-large"> </b-icon>
                      </p>
                      <p>{{ trans.get("students.dnd") }}</p>
                    </div>
                  </section>
                </b-upload>
              </b-tab-item>
              <b-tab-item
                :label="trans.get('documents.text')"
                icon-pack="fad"
                icon="align-justify"
                class="p-2"
              >
                <b-field :label="trans.get('documents.content')">
                  <Editor
                    v-model="document.text"
                    height="50vh"
                    :code="code"
                  ></Editor>
                </b-field>
              </b-tab-item>
            </b-tabs>
          </template>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="modal = false">
            {{ trans.get("general.close") }}
          </button>
          <button
            class="button is-primary"
            @click="addDocument"
            :disabled="document.name == ''"
          >
            {{ trans.get("general.add") }}
          </button>
          <!-- <button
            class="button is-link"
            @click="editPost"
            v-else
            :disabled="title == '' || content == null"
          >
            {{ trans.get("general.edit") }}
          </button> -->
        </footer>
      </div>
    </b-modal>
  </div>
</template>
<script>
import Editor from "../utils/Editor.vue";
import ShowDocument from "./ShowDocument.vue";
import draggable from "vuedraggable";

export default {
  props: ["documentgroup", "documents", "code"],
  created: function () {
    this.documentsMutable = this.documents;
  },
  data: function () {
    return {
      challengeEdit: null,
      isModalActive: false,
      students: null,
      groups: null,
      currentChallenge: null,
      mark: null,
      modal: false,
      documentsMutable: null,
      file: null,
      document: {
        name: "",
        description: "",
        type: 0,
        type_document: "",
        url: "",
        size: 0,
        text: "",
        document_category_id: this.documentgroup.id,
        indentation: 0,
        order: this.documents.length,
        visible: 1,
      },
    };
  },
  methods: {
    onChange(ev) {
      if (ev.size > 10000000)
        this.$toast(this.trans.get("success_error.max_size") + ": 10MB", {
          type: "error",
        });
      else this.file = ev;
    },
    finishDrop() {
      axios
        .post("/classroom/" + this.code + "/docmgr/documents/order", {
          documents: this.documentsMutable,
        })
        .then((response) => {});
    },
    addDocument() {
      var formData = new FormData();
      if (this.file) formData.append("file", this.file);
      formData.append("document", JSON.stringify(this.document));
      axios
        .post("/classroom/" + this.code + "/docmgr/document", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.$toast(response.data.message, { type: response.data.type });
          this.$parent.getDocuments(this.documentgroup.id);
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status == 422) {
              this.$toast(this.trans.get("success_error.file_tyle"), {
                type: "error",
              });
            }
          }
        });
    },
    deleteDocumentGroup(id) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios.delete("/classroom/documents/group/" + id).then((response) => {
            location.reload();
          });
        },
      });
    },
  },
  components: {
    ShowDocument,
    draggable,
    Editor,
  },
  computed: {},
  updated: function () {},
};
</script>