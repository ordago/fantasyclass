<template>
       <section>
         <b-tabs v-model="activeTab">
            <b-tab-item :label="trans.get('classroom.name_and_goals')" icon="" class="">
            
                    <h1 class="is-size-2"><i class="fal fa-cog faa-spin animated faa-slow"></i> {{ trans.get('classroom.prepare') }}</h1>
                    <div class="has-margin-y-4">
                        <label for="wizardName" class="has-margin-y-2">{{ trans.get('classroom.wizard_name') }} <small><i>{{ trans.get('classroom.wizard_name_example') }}</i></small></label>
                        <input type="text" name="name" class="input has-margin-y-2">
                        <span class="help is-danger" role="alert">
                            {{ trans.get('Error') }}
                        </span>
                    </div>
                    <div class="has-margin-y-4">
                        <label for="adventureName" class="has-margin-y-4">{{ trans.get('classroom.adventure_name') }} <small><i>{{ trans.get('classroom.adventure_name_example') }}</i></small></label>
                        <input type="text" value="FantasyClass" class="input has-margin-y-2" name="adventureName" id='adventureName'></input>
                        <span class="help is-danger" role="alert">
                            {{ trans.get('Error') }}
                        </span>
                    </div>
                    <div class="has-margin-y-4">
                        {{ trans.get('classroom.goal_type') }} <small><i>{{ trans.get('classroom.goal_type_example') }}</i></small>
                    </div>
           </b-tab-item>

            <b-tab-item :label="trans.get('menu.levels')">
                
            </b-tab-item>

            <b-tab-item :label="trans.get('classroom.theme')">
                
            </b-tab-item>

            <b-tab-item :label="trans.get('classroom.char_theme')">
                
            </b-tab-item>

            <b-tab-item label="+ Info">
                
            </b-tab-item>
        </b-tabs>
    </section>
</template>

<script>
    export default {
            data: function() {
                return {

                }
            },
            methods: {
            
            },
    }
</script>
