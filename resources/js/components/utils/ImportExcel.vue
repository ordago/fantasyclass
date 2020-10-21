<template>
  <div>
    <button class="button is-success mb-3" @click="showExcel = !showExcel">
      <i class="fad fa-file-spreadsheet mr-2"></i> {{ trans.get('students.excel') }} 
    </button>
    <div class="mb-2"><a href="/templates/students.xlsx" download v-if="showExcel"><i class="fas fa-download mr-2"></i> {{ trans.get('students.excel_template') }}</a></div>
    <b-field v-if="showExcel">
      <b-upload @input="onChange" drag-drop>
        <section class="section">
          <div class="content has-text-centered">
            <p>
              <b-icon icon="upload" size="is-large"> </b-icon>
            </p>
            <p>{{ trans.get('students.dnd') }}</p>
          </div>
        </section>
      </b-upload>
    </b-field>
    <!-- <input type="file" @change="onChange"/> -->
    <xlsx-read :file="file">
      <xlsx-json @parsed="importExcel"> </xlsx-json>
    </xlsx-read>
  </div>
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
    onChange(event) {
      this.file = event ? event : null;
      this.showExcel = false;
    },
    importExcel(data) {
      if (this.type == "addstudent") {
        this.$parent.addFromExcel(data);
      }
    },
  },
};
</script>