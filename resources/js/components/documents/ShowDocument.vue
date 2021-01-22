<template>
  <div
    class="is-flex is-flex-direction-column my-0 py-0 document"
    :class="{ 'has-text-grey-light': document.visible == 0 }"
  >
    <div
      class="py-1 mt-1"
      :style="'margin-left: ' + document.indentation * 20 + 'px'"
    >
      <span v-if="document.type == 0">
        <h4 class="is-size-4">{{ document.name }}</h4>
      </span>
      <span v-else-if="document.type == 3">
         <i class="fas fa-book"></i> <a @click.prevent="modal=true" href="#">{{ document.name }}</a>
      </span>
      <span v-else>
        <i class="fas mr-1" :class="getIcon()"></i> <a :href="document.url" :class="{ 'has-text-grey-light': document.visible == 0 }" target="_blank">{{ document.name }}</a> 
        <small style="font-size: 0.6em" class="is-italic">{{ document.size }} MB</small>
      </span>
    </div>
    <div
      :style="'margin-left: ' + document.indentation * 20 + 'px'"
      class="py-1 is-italic"
      v-if="document.description"
    >
      <small>{{ document.description }}</small>
    </div>
    <div class="px-2 py-1 document-properties">
      <small>
        <i
          class="mx-1 cursor-pointer fas fa-arrow-left"
          @click="changeIndentation(-1)"
          v-if="document.indentation != 0"
        ></i>
        <i
          class="mx-1 cursor-pointer fas fa-arrow-right"
          @click="changeIndentation(1)"
        ></i>
        <i
          class="mx-1 cursor-pointer fas"
          @click="changeVisibility()"
          :class="{
            'fa-eye': document.visible == 0,
            'fa-eye-slash': document.visible == 1,
          }"
        ></i>
        <i
          @click="edit()"
          class="mx-1 cursor-pointer fas fa-edit"
        ></i>
        <i
          @click="confirmDelete()"
          class="mx-1 cursor-pointer fas fa-times"
        ></i>
      </small>
    </div>
     <b-modal :active.sync="modal" has-modal-card full-screen>
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ document.name }}</p>
        </header>
        <section class="modal-card-body content" v-html="textHTML">
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="modal = false">
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>
<script>

import Utils from '../../utils.js';

export default {
  props: ["document", "admin", "code"],
  created: function () {
  },
  data: function () {
    return {
      modal: false,
    };
  },
  components: {},
  methods: {
    edit() {
      this.$parent.$parent.document = this.document;
      this.$parent.$parent.modal = true;
    },
    getIcon() {
      if(this.document.type == 1)
        return 'fa-globe';
      else {
        switch (this.document.type_document) {
          case "application/pdf":
            return 'fa-file-pdf';
            break;
          case "image/jpeg":
          case "image/png":
          case "image/svg":
          case "image/gif":
            return "fa-file-image"
            break;
          case "application/msword":
          case "application/vnd.oasis.opendocument.text":
          case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
            return "fa-file-word"
            break;
          case "application/vnd.ms-powerpoint":
          case "application/vnd.oasis.opendocument.presentation":
          case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
            return "fa-file-powerpoint"
            break;
          case "application/vnd.ms-excel":
          case "application/vnd.oasis.opendocument.spreadsheet":
          case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
            return "fa-file-excel"
            break;
          case "application/zip":
          case "application/x-rar":
          case "application/x-rar-compressed":
            return "fa-file-archive"
            break;
          case "video/mp4":
          case "video/x-msvideo":
          case "video/mpeg":
            return "fa-file-video"
            break;
          case "audio/mp4":
            case "audio/mpeg":
              return "fa-file-audio"
            break;
          case "text/plain":
              return 'fa-file-alt'
            break;
          default:
            return 'fa-file';
            break;
        }
      }
      // {'fa-globe': document.type == 1, 'fa-file' : document.type == 2}
    },
    changeProp(prop, value) {
      axios.patch("/classroom/" + this.code + "/document", {
        prop: prop,
        value: value,
        id: this.document.id,
      });
    },
    confirmDelete() {
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
          axios
            .delete("/classroom/document/" + this.document.id)
            .then((response) => {
              if (response.data === 1) {
                this.$parent.$parent.$parent.getDocuments(
                  this.document.document_category_id
                );
              }
            });
        },
      });
    },
    changeVisibility() {
      let visible = 0;
      if (this.document.visible == 0) {
        visible = 1;
      }
      this.document.visible = visible;
      this.changeProp("visible", visible);
      this.$forceUpdate();
    },
    changeIndentation(num) {
      this.document.indentation += num;
      this.changeProp("indentation", this.document.indentation);
    },
  },
  computed: {
    textHTML() {
      return Utils.replaceSpecial(this.document.text);
    }
  },
};
</script>
<style>
.document:hover .document-properties {
  display: initial;
}
.document-properties {
  display: none;
}
</style>
