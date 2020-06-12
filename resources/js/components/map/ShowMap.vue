<template>
        <div class="has-padding-4">
            <div>
                <input type="number" class="input" name="levels" value="10">
            </div>
            <button class="button is-primary has-margin-top-3">Create</button>
        </div>
</template>

<script>
export default {
  props: ["map", "code"],
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  },
  data: function() {
    return {
      csrfToken: null,
    };
  },
};
</script>
