<template>
  <span @click="clone" class="pointer">
    <i class="fas fa-clone"></i>
  </span>
</template>

<script>
export default {
  props: ["classroom"],
  mounted() {},
  data: function() {
    return {};
  },
  methods: {
    clone() {
      axios
        .get("/classroom/" + this.classroom.code + "/clone")
        .then(response => {
          location.reload();
        })
    }
  }
};
</script>