<template>
<div>
    <div class="columns is-multiline is-variable is-1 has-margin-y-2">
        <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd " v-for="student in orderedStudents" v-bind:key="student.id">
            <show-student :student="student" :theme="theme"></show-student>
        </div>
    </div>
</div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['students', 'theme'],
        mounted() {

        },
        data: function() {
            return {
                sortKey: 'xp',
            }
        },
        methods: {
            },
            computed: {
                orderedStudents: function () {
                    let order = 'desc'
                    if(this.sortKey == 'name')
                        order = 'asc'
                    return _.orderBy(this.students, this.sortKey, order)
                }
}     
        }
</script>
