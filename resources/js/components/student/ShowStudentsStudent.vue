<template>
    <div class="columns is-multiline is-variable is-1 p-2 pt-3">
        <div class="column py-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd " v-for="student in orderedStudents" v-bind:key="student.id">
            <show-student :character-theme="characterTheme" :student="student" :theme="theme"></show-student>
        </div>
    </div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['students', 'theme', 'characterTheme'],
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
