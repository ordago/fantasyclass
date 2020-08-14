<template>
<div>
  <iframe frameborder="0" class="map-iframe" 
  v-bind:src="getURLRefactoring(map.url)"
  type="text/html" allowscriptaccess="always" allowfullscreen="true" scrolling="yes" allownetworking="all"></iframe>
</div>
</template>

<script>
import Utils from "../../utils.js";

export default {
  props: ["map"],
  mounted: function() {},
  data: function() {
    return {};
  },
  methods: {
    getURLRefactoring(url) {
      return Utils.getURLRefactoring(url);
    },
  }
};
</script>
