<template>
  <div class="has-margin-3 cursor-pointer" @click="open=true" v-if="countCards">
    <i class="fad fa-bell" style="font-size: 1.25em;"></i>
    <span class="tag is-danger" style="font-size: 0.7em;" v-html="countCards"></span>

    <b-sidebar
      type="is-light"
      :fullheight="fullheight"
      :fullwidth="false"
      :overlay="overlay"
      :right="true"
      :open.sync="open"
      icon-pack="fa"
      mobile="fullwidth"
    >
      <div class="close-button" @click="open=false">
        <button class="button is-dark">x</button>
      </div>
      <div>
        <div v-for="(line, index) in pending" :key="index">
          <div class="columns has-all-centered" v-for="(card, index) in line.cards" :key="index">
            <div class="column is-narrow">
              <show-card style="zoom: .75" :card="card" admin="false"></show-card>
            </div>
            <div class="column is-narrow is-flex has-all-centered">
              <h4 class="is-size-4">{{ line.student.name }}</h4>
            </div>
            <div class="column is-flex is-narrow has-all-centered">
              <button
                class="button is-success"
                @click="setCard(card.id, line.student.id, card.pivot.marked, true)"
                v-text="getText(card.pivot.marked)"
              ></button>
              <button
                class="button is-danger has-margin-left-2"
                @click="setCard(card.id, line.student.id, card.pivot.marked, false)"
              >Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </b-sidebar>
  </div>
</template>
<script>
export default {
  props: ["pending"],
  mounted() {},
  data: function() {
    return {
      open: false,
      overlay: true,
      fullheight: true,
      fullwidth: false
    };
  },
  methods: {
    getText(type) {
      if (type == 1) {
        return "Use";
      } else {
        return "Delete";
      }
    },
    setCard(id, student, type, action) {
      axios
        .post("/classroom/card/usedelete/" + id, {
          student: student,
          action: action,
          type: type
        })
        .then(response => {
          this.$toasted.show(response.data.message, {
            position: "top-center",
            duration: 3000,
            iconPack: "fontawesome",
            icon: response.data.icon,
            type: response.data.type
          });
          if(action)
            location.reload()
        });
    }
  },
  computed: {
    countCards() {
      let count = 0;
      this.pending.forEach(element => {
        count += _.size(element.cards);
      });
      return count;
    }
  }
};
</script>