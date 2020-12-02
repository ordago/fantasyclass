<template>
  <div class="p-2">
    <div v-if="!banks.length">
        <a :href="'/classroom/' + classroom.code + '/questions'">You need to create a question bank first</a>
    </div> 
    <div v-else>
      <button class="button is-primary">Create new villain</button>
      <div class="p-2">
        <button class="button is-primary">Start new battle!</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["banks", "classroom"],
  mounted() {},
  data: function () {
    return {};
  },
  methods: {},
};
</script>
