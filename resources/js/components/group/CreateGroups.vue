<template>
<div>
    <form @submit.prevent="createGroups" method="post" action="" v-if="!groups.length">
        <input :value="csrfToken" type="hidden" name="_token"/>
        <div class="has-padding-4">
            <div>
                <span>
                    How many groups do you want?
                </span> 
                <input type="number" class="input" v-model="groupsNumber">
            </div>
            <button class="button is-primary has-margin-top-3">Create</button>
        </div>
    </form>
    <div v-if="groups.length">
        <div v-for="group in groups" v-bind:key="group.id">
            
        </div>
    </div>
</div>
</template>

<script>
  export default {
        props: ['groups', 'code'],
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data: function() {
            return {
                csrfToken: null,
                groupsNumber: 5,
            }
        },
        methods: {
            createGroups() {
                axios.post('/classroom/' + this.code +'/groups/create', { groupsNumber: this.groupsNumber })
                    .then(response => {
                        location.reload()
                    })
           }
        }
    }
</script>
