<template>
<div class="has-padding-2 is-flex flex-wrap justify-content-center">
  <show-card v-for="card in this.orderedCards" :code="code" :admin="'1'" :assign="student" :card="card" v-bind:key="card.id"></show-card>
</div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['cards', 'code', 'student'],
        mounted() {
            this.cardsJson = JSON.parse(this.cards)
        },
        data: function() {
            return {
                    custom: 0,
                    sortKey: 'type',
                    cardsJson: [],
            }
        },
        methods: {
                 
        },
        computed: {
          orderedCards: function () {
              return _.orderBy(this.cardsJson, this.sortKey, 'asc')
          }
        }     
  }
</script>