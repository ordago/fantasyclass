<template>
  <b-modal
    has-modal-card
    full-screen
    :can-cancel="false"
  >
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ trans.get("pets.image") }}</p>
      </header>
      <section class="modal-card-body is-relative">
        All pet images are from:
        <a href="https://github.com/HabitRPG/habitica"
          >https://github.com/HabitRPG/habitica</a
        >
        and are licensed under
        <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/"
          >CC-BY-NC-SA 3.0</a
        >
        <div class="columns is-multiline" v-if="images">
          <img
            width="75px"
            @click="
              pet.image = image;
              isImageModalActive = false;
            "
            v-for="image in images"
            :key="image"
            :src="'/img/pets/' + image"
          />
        </div>
      </section>
      <footer
        class="modal-card-foot columns is-multiline"
        style="overflow-x: auto"
      >
        <div class="column is-narrow">
          <button
            class="button"
            type="button"
            @click="isImageModalActive = false"
          >
            {{ trans.get("general.close") }}
          </button>
        </div>
      </footer>
    </div>
  </b-modal>
</template>

<script>
// import Utils from "../../utils.js";

export default {
  props: ["code"],
  created() {},
  data: function () {
    return {
      image: null,
    };
  },
  methods: {
    updateValue: function () {
      this.$emit("input", this.image);
    },
  },
};
</script>