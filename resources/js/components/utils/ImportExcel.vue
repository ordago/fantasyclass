<template>
  <div>
    <h3>Import XLSX</h3>
    <input type="file" @change="onChange" />
    <xlsx-read :file="file">
      <xlsx-json @parsed="test">
      </xlsx-json>
    </xlsx-read>
  </div>
</template>

<script>
import { XlsxRead, XlsxJson } from "vue-xlsx"

export default {
  components: {
    XlsxRead,
    XlsxJson
  },
  props: ['type'],
  data() {
    return {
      file: null
    };
  },
  methods: {
    onChange(event) {
      this.file = event.target.files ? event.target.files[0] : null;
    },
    test(data) {
        if(this.type == 'addstudent') {
            this.$parent.addFromExcel(data);
        }

    }
  }
};
</script>