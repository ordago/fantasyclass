<template>
       <section class="has-padding-x-3">
         <b-tabs v-model="activeTab" size="is-small">
            <b-tab-item :label="trans.get('classroom.preferences')" icon="scroll" icon-pack="far">        

                <h1 class="is-size-2"><i class="fal fa-cog faa-spin animated faa-slow"></i> {{ trans.get('preferences.preferences') }}</h1>

                <div class="has-margin-y-4">
                    <label for="name" class="has-margin-y-2">{{ trans.get('preferences.name') }}</label>
                    <input type="text" name="name" v-model="classForm.name" required minlength="2" class="input has-margin-y-2">
                </div>

                <div class="has-margin-y-4">
                    <label for="password" class="has-margin-y-4">{{ trans.get('preferences.password') }}</label>
                    <input type="text" v-model="classForm.adventure_name" required minlength="3" value="FantasyClass" class="input has-margin-y-2" name="adventureName" id='adventureName'></input>
                </div>

                <div class="has-margin-y-4">
                    <label for="confirmPassword" class="has-margin-y-4">{{ trans.get('preferences.confirm_password') }}</label>
                    <input type="text" v-model="classForm.adventure_name" required minlength="3" value="FantasyClass" class="input has-margin-y-2" name="adventureName" id='adventureName'></input>
                </div>

                <div class="has-margin-y-4">
                    <label for="adventureName" class="has-margin-y-4">{{ trans.get('preferences.language') }}</label>
                    <input type="text" v-model="classForm.adventure_name" required minlength="3" value="FantasyClass" class="input has-margin-y-2" name="adventureName" id='adventureName'></input>
                </div>

                
           </b-tab-item>

        </b-tabs>

        <div class="is-flex has-padding-x-4" style="justify-content: space-between; position: fixed; bottom: 0; left: 0;width: 100%">
            <button class="button is-link" v-if="classroom">{{ trans.get('classroom.edit') }}</button>
            <button class="button is-success" v-if="!classroom">{{ trans.get('classroom.end_wizard') }}</button>
        </div>
    </section>
</template>

<script>
    export default {
            props: ['goals', 'themes', 'classroom'],
            mounted: function() {
                this.goalsJson = JSON.parse(this.goals)
                this.themesJson = JSON.parse(this.themes)
                if(this.classroom) {
                    this.classForm.name = this.classroom.name
                    this.classForm.adventure_name = this.classroom.adventure_name
                    this.classForm.goal_type = this.classroom.goal_type
                    this.classForm.bg_theme = this.classroom.theme.id
                    this.classForm.character_theme = this.classroom.character_theme
                }
            },
            data: function() {
                return {
                    activeTab: 0,
                    goalsJson: [],
                    themesJson: [],
                    goalSelected: 1,
                    classForm: {
                        name: '',
                        adventure_name: 'FantasyClass',
                        goal_type: 1,
                        bg_theme: 1,
                        character_theme: 1,
                    }
                }
            },
            methods: {
                selectGoal: function(id) {
                    this.goalSelected = id
                },
            },
    }
</script>
