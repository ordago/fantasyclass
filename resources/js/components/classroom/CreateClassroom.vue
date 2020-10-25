<template>
       <section class="has-padding-x-3">
         <b-tabs v-model="activeTab" size="is-small">
            <b-tab-item :label="trans.get('classroom.name_and_goals')" icon="scroll" icon-pack="far">         
                <h1 class="is-size-2"><i class="fal fa-cog faa-spin animated faa-slow"></i> {{ trans.get('classroom.prepare') }}</h1>
                <div class="has-margin-y-4">
                    <label for="wizardName" class="has-margin-y-2">{{ trans.get('classroom.wizard_name') }} <small><i>{{ trans.get('classroom.wizard_name_example') }}</i></small></label>
                    <input type="text" name="name" v-model="classForm.name" required minlength="2" class="input has-margin-y-2">
                </div>
                <div class="has-margin-y-4">
                    <label for="adventureName" class="has-margin-y-4">{{ trans.get('classroom.adventure_name') }} <small><i>{{ trans.get('classroom.adventure_name_example') }}</i></small></label>
                    <input type="text" v-model="classForm.adventure_name" required minlength="3" value="FantasyClass" class="input has-margin-y-2" name="adventureName" id='adventureName'></input>
                </div>
                <div class="has-margin-y-4">
                    {{ trans.get('classroom.goal_type') }} <small><i>{{ trans.get('classroom.goal_type_example') }}</i></small>
                </div>
                <div class="field has-addons" data-toggle="buttons" style="width: 100%; overflow-x: auto">
                    <p class="control" v-for="(goal, index) in goalsJson" v-bind:key="goal.id">
                        <label class="button" @click="selectGoal(goal.id)" :class="{ 'is-success is-selected': goal.id == classForm.goal_type }">
                            <input type="radio" v-model="classForm.goal_type" name="goalType" class="hide-radios" :checked="index == classForm.goal_type"  :value="goal.id"  autocomplete="off"><i :class="goal.icon + ' colored'" :style="'color: ' + goal.color"></i>
                        </label>
                    </p>
            </div>
           </b-tab-item>

            <b-tab-item :label="trans.get('classroom.theme')" icon="palette" icon-pack="far">
            <h1 class="is-size-2">{{ trans.get('classroom.theme') }}</h1>
            <h6 class="has-margin-y-3">{{ trans.get('classroom.theme_text') }}</h6>
            <div class="themes">
                <label v-for="(theme, index) in themesJson" v-bind:key="theme.id">
                      <input type="radio" v-model="classForm.bg_theme" name="bgtheme" class="hide-radios" :checked="index === 0" :value="theme.id">
                        <div class="theme bg_color_theme" :style="'background-color:' + theme.color">
                          <img :src="'/img/bg/thumb_' + theme.name" v-if="theme.type == 1">                      
                          <img src="/img/bg/empty.png" v-else> 
                        </div>
                </label>
                <div class="my-3"><a href="https://www.freepik.es/fotos-vectores-gratis/fondo">Vector de fondo creado por freepik - www.freepik.es</a></div>                  
            </div>
            </b-tab-item>

            <b-tab-item :label="trans.get('classroom.char_theme')" icon="mask" icon-pack="far">
                <h1 class="is-size-2 has-margin-bottom-4"><i class="fal fa-ghost faa-float animated"></i> {{ trans.get('classroom.char_theme') }}</h1>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" checked value="1">
                    <img  src="/img/character/themes-preview/medieval-fantasy.png" class="themePreview">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="2">
                    <img  src="/img/character/themes-preview/robots.png" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/ideemaestramari'><i class='fab fa-twitter'></i> @ideemaestramari</a>">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="3">
                    <img  src="/img/character/themes-preview/superheros.png" class="themePreview">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="4">
                    <img  src="/img/character/themes-preview/pirateanimals.png" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/ideemaestramari'><i class='fab fa-twitter'></i> @ideemaestramari</a>">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="0">
                    <img  src="/img/character/themes-preview/custom.png" class="themePreview" v-tippy :content="trans.get('classroom.custom_theme')">
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
        <div class="has-padding-x-4 columns" style="justify-content: space-between; position: fixed; bottom: 0; left: 0;width: 100%">
            <div class="column has-margin-0 buttons has-addons">
                <button type="button" class="button" v-if="activeTab>0" @click="activeTab--"><i class="fas fa-chevron-left"></i></button>
                <button type="button" class="button is-info is-selected" @click="activeTab++" v-if="activeTab<3"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="column has-margin-0 has-text-right" v-if="classroom">
                <button class="button has-margin-left-4 is-danger" @click.prevent="confirmDelete">
                    <i class="fas fa-trash"></i>
                    <span class="has-margin-x-3">
                    {{ trans.get('general.delete') }}
                    <i class="fas fa-radiation-alt"></i>
                    <i class="fas fa-exclamation-triangle"></i>
                    </span>
                </button>
                <button class="button is-link"><i class="fas fa-edit has-margin-right-2"></i> {{ trans.get('classroom.edit') }}</button>
            </div>
            <button class="button is-success" v-else>{{ trans.get('classroom.end_wizard') }}</button>
        </div>
    </section>
</template>

<script>
export default {
  props: ["goals", "themes", "classroom"],
  mounted: function () {
    this.goalsJson = JSON.parse(this.goals);
    this.themesJson = JSON.parse(this.themes);
    if (this.classroom) {
      this.classForm.name = this.classroom.name;
      this.classForm.adventure_name = this.classroom.adventure_name;
      this.classForm.goal_type = this.classroom.goal_type;
      this.classForm.bg_theme = this.classroom.theme.id;
      this.classForm.character_theme = this.classroom.character_theme;
    }
  },
  data: function () {
    return {
      activeTab: 0,
      goalsJson: [],
      themesJson: [],
      goalSelected: 1,
      classForm: {
        name: "",
        adventure_name: "FantasyClass",
        goal_type: 1,
        bg_theme: 1,
        character_theme: 1,
      },
    };
  },
  methods: {
    selectGoal: function (id) {
      this.goalSelected = id;
    },
    confirmDelete() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete_class"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios.delete("/classroom/" + this.classroom.code).then((response) => {
            location.href = response.data;
          });
        },
      });
    },
  },
};
</script>
