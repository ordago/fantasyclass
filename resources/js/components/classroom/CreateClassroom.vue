<template>
       <section>
         <b-tabs v-model="activeTab" >
            <b-tab-item :label="trans.get('classroom.name_and_goals')" icon="scroll" icon-pack="far">         
                <h1 class="is-size-2"><i class="fal fa-cog faa-spin animated faa-slow"></i> {{ trans.get('classroom.prepare') }}</h1>
                <div class="has-margin-y-4">
                    <label for="wizardName" class="has-margin-y-2">{{ trans.get('classroom.wizard_name') }} <small><i>{{ trans.get('classroom.wizard_name_example') }}</i></small></label>
                    <input type="text" name="name" required class="input has-margin-y-2">
                    <span class="help is-danger" role="alert">
                        {{ trans.get('Error') }}
                    </span>
                </div>
                <div class="has-margin-y-4">
                    <label for="adventureName" class="has-margin-y-4">{{ trans.get('classroom.adventure_name') }} <small><i>{{ trans.get('classroom.adventure_name_example') }}</i></small></label>
                    <input type="text" required value="FantasyClass" class="input has-margin-y-2" name="adventureName" id='adventureName'></input>
                    <span class="help is-danger" role="alert">
                        {{ trans.get('Error') }}
                    </span>
                </div>
                <div class="has-margin-y-4">
                    {{ trans.get('classroom.goal_type') }} <small><i>{{ trans.get('classroom.goal_type_example') }}</i></small>
                </div>
                <div class="field has-addons" data-toggle="buttons" style="width: 100%; overflow-x: auto">
                    <p class="control" v-for="(goal, index) in goalsJson" v-bind:key="goal.id">
                        <label class="button" @click="selectGoal(goal.id)" :class="{ 'is-success is-selected': goal.id == goalSelected }">
                            <input type="radio" name="goalType" class="hide-radios" :checked="index === 0"  :value="goal.id"   autocomplete="off"><i :class="goal.icon + ' colored'" :style="'color: ' + goal.color"></i>
                        </label>
                    </p>
            </div>
           </b-tab-item>

            <b-tab-item :label="trans.get('menu.levels')" icon="trophy" icon-pack="far">
                <h1 class="is-size-2">{{ trans.get('menu.levels') }}</h1>
                <h6 class="has-margin-top-4">{{ trans.get('classroom.levels_text') }} <i class="fas fa-smile-beam colored"></i></h6>
                <h1 class="has-margin-top-4 notification is-danger">WIP. First create levels</h1>
                <!--<iframe src="utils/lvlBank.php" style="width:100%; height: 50vh;"></iframe>-->
            </b-tab-item>

            <b-tab-item :label="trans.get('classroom.theme')" icon="palette" icon-pack="far">
            <h1 class="is-size-2">{{ trans.get('classroom.theme') }}</h1>
            <h6 class="has-margin-y-3">{{ trans.get('classroom.theme_text') }}</h6>
            <div class="themes">
                <label v-for="(theme, index) in themesJson" v-bind:key="theme.id">
                      <input type="radio" name="bgtheme" class="hide-radios" :checked="index === 0" :value="theme.id">
                        <div class="theme bg_color_theme" :style="'background-color:' + theme.color">
                          <img :src="'/img/bg/' + theme.name" v-if="theme.type == 1">                      
                          <img src="/img/bg/empty.png" v-else> 
                        </div>
                </label>                  
            </div>
            </b-tab-item>

            <b-tab-item :label="trans.get('classroom.char_theme')" icon="mask" icon-pack="far">
                <h1 class="is-size-2"><i class="fal fa-ghost faa-float animated"></i> {{ trans.get('classroom.char_theme') }}</h1>
                <label>
                    <input type="radio" name="charTheme" class="hide-radios" checked value="1">
                    <img  src="/img/character/themes-preview/medieval-fantasy.png" class="themePreview">
                </label>
                <label>
                    <input type="radio" disabled name="charTheme" class="hide-radios" value="2">
                    <img  src="/img/character/themes-preview/robots.png" class="themePreview disabled" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/ideemaestramari'><i class='fab fa-twitter'></i> @ideemaestramari</a>">
                </label>
                <label>
                    <input type="radio" disabled name="charTheme" class="hide-radios" value="3">
                    <img  src="/img/character/themes-preview/superheros.png" class="themePreview disabled">
                </label>
                <label>
                    <input type="radio" disabled name="charTheme" class="hide-radios" value="4">
                    <img  src="/img/character/themes-preview/pirateanimals.png" class="themePreview disabled" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/ideemaestramari'><i class='fab fa-twitter'></i> @ideemaestramari</a>">
                </label>
                <label>
                    <input type="radio" disabled name="charTheme" class="hide-radios" value="0">
                    <img  src="/img/character/themes-preview/custom.png" class="themePreview disabled" v-tippy :content="trans.get('classroom.custom_theme')">
                </label>

            </b-tab-item>

            <b-tab-item label="+ Info" icon="info" icon-pack="far">
                <div>
                <h1 class="is-size-2 has-text-centered"><i class="fal fa-laugh-beam  faa-wrench animated"></i> {{ trans.get('classroom.finish_title') }}</h1>
                <h4 class="is-size-4 has-margin-y-3 has-text-centered">{{ trans.get('classroom.info_wizard_0') }}</h4>
                <ol class="has-margin-6 has-margin-left-8">
                    <li class="is-size-5 has-margin-3">{{ trans.get('classroom.info_wizard_1') }} <i class="fal fa-users"></i></li>
                    <li class="is-size-5 has-margin-3">{{ trans.get('classroom.info_wizard_2') }} <i class="fal fa-tasks"></i></li>
                    <li class="is-size-5 has-margin-3">{{ trans.get('classroom.info_wizard_3') }} <i class="fal fa-treasure-chest"></i></li>
                    <li class="is-size-5 has-margin-3">{{ trans.get('classroom.info_wizard_4') }} <i class="fal fa-hands-helping"></i></li>
                    <li class="is-size-5 has-margin-3">{{ trans.get('classroom.info_wizard_5') }} <i class="fal fa-swords"></i></li>
                </ol>
                </div>
            </b-tab-item>
        </b-tabs>
        <div class="is-flex has-padding-x-4" style="position: fixed; bottom: 0; left: 0;width: 100%">
            <div class="buttons has-addons">
                <button type="button" class="button" v-if="activeTab>0" @click="activeTab--"><i class="fas fa-chevron-left"></i></button>
                <button type="button" class="button is-info is-selected" @click="activeTab++" v-if="activeTab<4"><i class="fas fa-chevron-right"></i></button>
            </div>
            <button class="button is-success">{{ trans.get('classroom.end_wizard') }}</button>
        </div>
    </section>
</template>

<script>
    export default {
            props: ['goals', 'themes'],
            mounted: function() {
                this.goalsJson = JSON.parse(this.goals)
                this.themesJson = JSON.parse(this.themes)
            },
            data: function() {
                return {
                    activeTab: 0,
                    goalsJson: [],
                    themesJson: [],
                    goalSelected: 1,
                }
            },
            methods: {
                selectGoal: function(id) {
                    this.goalSelected = id
                },
            },
    }
</script>
