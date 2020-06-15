<template>
  <a @click="promptCode" class="is-rounded text-center pointer">
    <i class="fal fa-user mr-2"></i>
    {{ trans.get('classroom.join') }}
  </a>
</template>

<script>
export default {
  mounted: function() {},
  data: function() {
    return {};
  },
  methods: {
    promptCode() {
      this.$buefy.dialog.prompt({
        message: `Classroom code`,
        inputAttrs: {
          placeholder: "Just the code :)",
          maxlength: 10
        },
        trapFocus: true,
        onConfirm: value => {
          axios.get(`/classroom/join/${value}`)
          .then(response => {
              location.reload()
          })
        }
      });
    }
  }
};
</script>
