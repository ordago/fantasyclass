<template>
  <div class="p-2">
    <create-levels v-if="!levels.length"></create-levels>
    <div class="columns is-multiline is-variable mt-3" v-else>
      <show-level
        v-for="(level, index) in levels"
        :key="level.id"
        :code="code"
        :edit="true"
        :last="index == levels.length - 1"
        :level="level"
      ></show-level>
      <button class="button mx-3 my-2" @click="addLevel"><i class="fas fa-plus mr-2"></i> {{ trans.get('levels.add') }}</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["levels", "code"],
  created() {
  },
  data: function () {
    return {
      newXp: 0,
    };
  },
  methods: {
    addLevel() {
      this.$buefy.dialog.prompt({
        message: this.trans.get("levels.add"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        inputAttrs: {
          placeholder: this.trans.get("levels.xp"),
          type: "number",
          min: this.levels[this.levels.length - 1].xp + 1,
        },
        trapFocus: true,
        onConfirm: (value) => {
          axios.post(`/classroom/${this.code}/level/add`, { xp: value }).then((response) => {
            this.levels.push(response.data);
            this.$forceUpdate();
          });
        },
      });
    },
  },
};
</script>