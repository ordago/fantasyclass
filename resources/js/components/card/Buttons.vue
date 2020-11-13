<template>
  <div class="buttons">
    <button @click.prevent="pay" class="button">{{ trans.get("cards.pay") }}</button>
    <button class="button">{{ trans.get("general.close") }}</button>
  </div>
</template>

<script>
import Utils from "../../utils.js";

export default {
  props: [],
  created() {
    axios.get('/')
  },
  data: function () {
    return {};
  },
  methods: {
    pay() {
      axios.post("/classroom/students/update", {action: "pay"})
      .then(response => {
        if(response.data.type == "error")
            this.$toast(response.data.message, { type: response.data.type });
        else location.reload();
      })
    },
  },
};
</script>
