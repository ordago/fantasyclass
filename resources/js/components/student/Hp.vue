<template>
  <div class="is-flex has-all-centered">
    <div class="w-100 is-relative">
      <div class="attribute-info has-all-centered" v-if="icon">
        <img src="/img/bg-hp.png" width="40px" />
        <i class="fas fa-heart colored is-absolute" style="left: 10px"></i>
      </div>
      <div class="score p-2 centered-attribute m-1 mt-3 has-all-centered">
        <span
          :class="'attribute has-background-white-ter border rounded py-' + size"
        >
          <span>
            <i
              class="fas fa-heart has-text-grey-light"
              :class="{ 'has-text-white-ter': icon }"
            ></i>
          </span>
          <span class="has-text-grey-light" v-if="hp < 20">{{ Math.round(hp) }}</span>
        </span>
        <span
          :class="'attribute has-background-danger rounded py-' + size"
          :style="'width: ' + hp + '%'"
        >
          <i
            class="fas fa-heart"
            v-if="hp > 0"
            v-bind:class="{ 'has-text-danger': hp < 52 || icon }"
          ></i>
          <span v-if="hp >= 20">{{ Math.round(hp) }}</span>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
// import Utils from "../../utils.js";

export default {
  props: {
    hp: Number,
    icon: {
      type: Boolean,
      default: false,
    },
    size: {
      type: Number,
      default: 1,
    },
  },
  created() {},
  data: function () {
    return {};
  },
  methods: {},
};
</script>