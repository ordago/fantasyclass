<template>
  <div class="">
    <ShowChallenge
      v-if="object.etype == 'challenges'"
      class="mb-3"
      :code="code"
      :challenge="object"
      :admin="false"
      :full="true"
      :prev-rating="object.rated"
    ></ShowChallenge>
  </div>
</template>

<script>
// import Utils from "../../utils.js";
import ShowChallenge from "../challenges/ShowChallenge.vue";
import confetti from "canvas-confetti";

export default {
  props: ["code", "object"],
  created() {},
  mounted() {
    if (this.object.get) {
      this.$buefy.dialog.alert({
        title: "Owww yeaahhhh 👏👏",
        message: this.getMessage(),
        type: "is-success",
        ariaRole: "alertdialog",
        ariaModal: true,
      });
      confetti({
        particleCount: 200,
        spread: 100,
        origin: { y: 1.0 },
      });
    }
  },
  data: function () {
    return {};
  },
  methods: {
    getMessage() {
      let message = '<div class="has-text-centered">';
      switch (this.object.etype) {
        case 'challenges':
          message += this.trans.get('utils.get_challenge');
          break;
        default:
          break;
      }
      message += '</div>';
      return message;
    },
  },
  components: {
    ShowChallenge,
  },
};
</script>