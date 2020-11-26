<template>
  <div class="box card-shadow-s mb-3">
    <h1>{{ question.name }}</h1>
    <div class="mt-2" v-if="question.type == 1">
      <span v-for="(option, index) in question.options" :key="index">
        <span class="tag p-2 mr-1" :class="{ 'is-success': option.answer.id == question.options[0].correctAnswer }" v-if="option.answer">{{ option.answer.text }}</span>
      </span>
    </div>
    <div class="mt-2" v-else-if="question.type == 2">
      <span v-for="(option, index) in question.options" :key="index">
        <span class="tag p-2 mr-1 is-success">{{ option.answer }}</span>
      </span>
    </div>
  </div>
</template>
<script>
import confetti from "canvas-confetti";
import Utils from "../../utils.js";

export default {
  props: [
    "code",
    "question",
  ],
  created: function () {
  },
  data: function () {
    return {
    };
  },
  components: {
  
  },
  methods: {

  },
};
</script>
