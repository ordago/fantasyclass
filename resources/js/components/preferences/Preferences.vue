<template>
       <div>
            <!-- TODO -->
           <button class="btn btn-primary ml-4">Hello</button>
       </div>
</template>

<script>
    export default {
        mounted() {
            console.log('askdjf')
        }
            // props: ['goals', 'themes', 'classroom'],
            // mounted: function() {
            //     this.goalsJson = JSON.parse(this.goals)
            //     this.themesJson = JSON.parse(this.themes)
            //     if(this.classroom) {
            //         this.classForm.name = this.classroom.name
            //         this.classForm.adventure_name = this.classroom.adventure_name
            //         this.classForm.goal_type = this.classroom.goal_type
            //         this.classForm.bg_theme = this.classroom.theme.id
            //         this.classForm.character_theme = this.classroom.character_theme
            //     }
            // },
            // data: function() {
            //     return {
            //         activeTab: 0,
            //         goalsJson: [],
            //         themesJson: [],
            //         goalSelected: 1,
            //         classForm: {
            //             name: '',
            //             adventure_name: 'FantasyClass',
            //             goal_type: 1,
            //             bg_theme: 1,
            //             character_theme: 1,
            //         }
            //     }
            // },
            // methods: {
            //     selectGoal: function(id) {
            //         this.goalSelected = id
            //     },
            // },
    }
</script>
