<template>
  <div class="p-2">
    <create-roles v-if="!roles.length"></create-roles>
    <div class="columns is-multiline is-variable mt-3" v-else>
      <!-- <show-level
        v-for="(level, index) in levels"
        :key="level.id"
        :code="code"
        :edit="true"
        :last="index == levels.length - 1"
        :level="level"
      ></show-level> -->
      <!-- <button class="button mx-3 my-2" @click="addRole">
        <i class="fas fa-plus mr-2"></i> {{ trans.get("roles.add") }}
      </button> -->
    </div>
  </div>
</template>

<script>
export default {
  props: ["roles", "code"],
  created() {},
  data: function () {
    return {
    };
  },
  methods: {
  },
};
</script>