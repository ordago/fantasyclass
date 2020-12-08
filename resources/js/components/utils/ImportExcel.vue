<template>
  <span>
    <button class="button is-success mb-3" @click="showExcel = true">
      <i class="fad fa-file-spreadsheet"></i>
      <span class="is-hidden-mobile ml-2">{{ trans.get("students.excel") }}</span>
    </button>
    <b-modal :active.sync="showExcel">
      <div class="is-flex is-flex-direction-column p-4 rounded has-all-centered has-background-light">
        <div class="mb-2">
          <a :href="getTemplate()" download v-if="showExcel"
            ><i class="fas fa-download mr-2"></i>
            {{ trans.get("students.excel_template") }}</a
          >
        </div>
        <b-field v-if="showExcel">
          <b-upload @input="onChange" drag-drop>
            <section class="section">
              <div class="content has-text-centered">
                <p>
                  <b-icon icon="upload" size="is-large"> </b-icon>
                </p>
                <p>{{ trans.get("students.dnd") }}</p>
              </div>
            </section>
          </b-upload>
        </b-field>
        <!-- <input type="file" @change="onChange"/> -->
        <xlsx-read :file="file">
          <xlsx-json @parsed="importExcel"> </xlsx-json>
        </xlsx-read>
      </div>
    </b-modal>
  </span>
</template>

<script>
import { XlsxRead, XlsxJson } from "vue-xlsx";

export default {
  components: {
    XlsxRead,
    XlsxJson,
  },
  props: ["type"],
  data() {
    return {
      file: null,
      showExcel: false,
    };
  },
  methods: {
    getTemplate() {
      switch(this.type) {
        case 'addstudent':
          return "/templates/students.xlsx";
        break;
        case 'importTest':
          return "/templates/test.xlsx";
          break;
      }
    },
    onChange(event) {
      this.file = event ? event : null;
      this.showExcel = false;
    },
    importExcel(data) {
      if (this.type == "addstudent") {
        this.$parent.addFromExcel(data);
      } else if (this.type == "importTest") {
        this.$parent.addFromExcel(data);
      }
    },
  },
};
</script>