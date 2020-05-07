<template>
  <div class="p-2 m-0 pt-1">
<b-input v-model="query" type="text" :placeholder="trans.get('__JSON__.I love programming')"></b-input>
    <b-card no-body>
      <b-tabs v-model="tabIndex" small card>
        <b-tab title="General">I'm the first fading tab</b-tab>
        <b-tab title="Edit profile">
          I'm the second tab
          <b-card>I'm the card in tab</b-card>
        </b-tab>
        <b-tab title="Premium Plan" disabled>Sibzamini!</b-tab>
        <b-tab title="Info">I'm the last tab</b-tab>
      </b-tabs>
        <div class="">
          <b-button-group class="mt-2">
            <b-button @click="tabIndex--">Previous</b-button>
            <b-button @click="tabIndex++">Next</b-button>
          </b-button-group>
        </div>
    </b-card>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        tabIndex: 1
      }
    }
  }
</script>