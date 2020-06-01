<template>
    <div class="column box has-padding-4 has-margin-3">
        <label>Group Name</label>
        <input type="text" class="input" v-model="group.name">
        <button class="button is-dark has-margin-3">Edit</button>
</div>
</template>

<script>
  export default {
        props: ['group'],
        mounted() {
            console.log(this.group)
        },
        data: function() {
            return {
            }
        },
          components: {
            
        },
        methods: {
            
        }
    }
</script>
