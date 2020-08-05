<template>
  <div class="w-100 content">
    <!-- <b-modal
      :active.sync="isTagModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addTag">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">Add tag</p>
          </header>
          <section class="modal-card-body">
            <b-field label="Abbreviation">
              <b-input v-model="tag.short" maxlength="15" required></b-input>
            </b-field>
            <b-field label="Full description">
              <b-input v-model="tag.description" required></b-input>
            </b-field>
            <b-field label="% of the final grade">
              <b-input v-model="tag.percent" type="number" required></b-input>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isTagModalActive=false">Close</button>
            <button class="button is-primary">Add</button>
          </footer>
        </div>
      </form>
    </b-modal> -->
  </div>
</template>
<script>
export default {
  props: ["classroom", "tags", "rubrics", "lines"],
  created: function () {},
  data: function () {
    return {};
  },
  methods: {},
  components: {},
};
</script>
