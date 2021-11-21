<template>
       <section class="p-3">
         <b-tabs v-model="activeTab" size="is-small">
            <b-tab-item :label="trans.get('classroom.name_and_goals')" icon="scroll" icon-pack="far">         
                <h1 class="is-size-2 mt-4"><i class="fal fa-cog faa-spin animated faa-slow"></i> {{ trans.get('classroom.prepare') }}</h1>
                <div class="my-4">
                    <label for="wizardName" class="my-2"><span class="has-text-danger"><i class="far fa-asterisk mr-1"></i></span>{{ trans.get('classroom.wizard_name') }} <small><i>{{ trans.get('classroom.wizard_name_example') }}</i></small></label>
                    <input type="text" name="name" v-model="classForm.name" required minlength="2" class="input my-2">
                </div>
                <div class="my-4">
                    <label for="adventureName" class="my-4"><span class="has-text-danger"><i class="far fa-asterisk mr-1"></i></span>{{ trans.get('classroom.adventure_name') }} <small><i>{{ trans.get('classroom.adventure_name_example') }}</i></small></label>
                    <input type="text" v-model="classForm.adventure_name" required minlength="3" value="FantasyClass" class="input my-2" name="adventureName" id='adventureName'>
                </div>
                <div class="my-4">
                    {{ trans.get('classroom.goal_type') }} <small><i>{{ trans.get('classroom.goal_type_example') }}</i></small>
                </div>
                <div class="field has-addons" data-toggle="buttons" style="width: 100%; overflow-x: auto">
                    <p class="control" v-for="(goal, index) in goalsJson" v-bind:key="goal.id">
                        <label class="button" @click="selectGoal(goal.id)" :class="{ 'is-success is-selected': goal.id == classForm.goal_type }">
                            <input type="radio" v-model="classForm.goal_type" name="goalType" class="hide-radios" :checked="index == classForm.goal_type"  :value="goal.id"  autocomplete="off"><i :class="goal.icon + ' colored'" :style="'color: ' + goal.color"></i>
                        </label>
                    </p>
                </div>
                <div class="field" v-if="!classroom">
                  <b-switch v-model="isFilled" name="filled">
                      {{ getFilledText() }}
                  </b-switch>
                </div>
           </b-tab-item>

            <b-tab-item :label="trans.get('classroom.theme')" icon="palette" icon-pack="far">
            <h1 class="is-size-2 mt-4">{{ trans.get('classroom.theme') }}</h1>
            <h6 class="my-3">{{ trans.get('classroom.theme_text') }}</h6>
            <div class="">
            <b-tabs class="w-100" type="is-toggle-rounded">
            <b-tab-item label="Base themes">
              <div class="themes p-2 mt-2">
              <label v-for="(theme) in themesJson" v-bind:key="theme.id">
                      <input @click="classForm.bg_image=null" type="radio" v-model="classForm.bg_theme" name="bgtheme" class="hide-radios"  :value="theme.id">
                        <div class="theme bg_color_theme" :style="'background-color:' + theme.color">
                          <img :src="'/img/bg/base/thumb_' + theme.name" :class="{ 'selected2' : theme.id == classForm.bg_theme || classForm.bg_image && classForm.bg_image.includes('/img/bg/base/thumb_' + theme.name ) }">                      
                        </div>
                </label>
                <div class="my-3"><a href="https://www.freepik.es/fotos-vectores-gratis/fondo">Vector de fondo creado por freepik - www.freepik.es</a></div>                  
                </div>
            </b-tab-item>
            <input type="hidden" v-model="classForm.bg_image" name="background">
            <b-tab-item v-for="(themePack, index) in imgThemes" :key="index" :label="themePack.name">
              <div class="themes p-2 mt-2">
                <img class="m-2" :src="'/img/bg/' + themePack.name + '/' + img" v-for="(img, index) in themePack.images" :key="index" :class=" { 'selected2' : classForm.bg_image && classForm.bg_image.includes(themePack.name + '/' + img ) }" @click="selectImg">
                </div>
            </b-tab-item>
            </b-tabs>
            </div>
            </b-tab-item>

            <b-tab-item :label="trans.get('classroom.char_theme')" icon="mask" icon-pack="far">
                <h1 class="is-size-2 my-4"><i class="fal fa-ghost faa-float animated"></i> {{ trans.get('classroom.char_theme') }}</h1>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" checked value="7">
                    <img src="/img/character/themes-preview/fantasy.png" class="themePreview">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" checked value="12">
                    <img src="/img/character/themes-preview/koi.png" alt="koi" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/soyjujo_juanjo'><i class='fab fa-twitter'></i> @soyjujo_juanjo</a>">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" checked value="13">
                    <img src="/img/character/themes-preview/gladiators.png" alt="gladiators" class="themePreview">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" checked value="10">
                    <img src="/img/character/themes-preview/food.png" class="themePreview">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="11">
                    <img src="/img/character/themes-preview/hp.png" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/Framiq'><i class='fab fa-twitter'></i> @Framiq</a>">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="1">
                    <img src="/img/character/themes-preview/medieval-fantasy.png" class="themePreview">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="9">
                    <img src="/img/character/themes-preview/space.png" class="themePreview">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="2">
                    <img src="/img/character/themes-preview/robots.png" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/ideemaestramari'><i class='fab fa-twitter'></i> @ideemaestramari</a>">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="3">
                    <img src="/img/character/themes-preview/superheros.png" class="themePreview">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="4">
                    <img src="/img/character/themes-preview/pirateanimals.png" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://twitter.com/ideemaestramari'><i class='fab fa-twitter'></i> @ideemaestramari</a>">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="6">
                    <img src="/img/character/themes-preview/aquatic.png" class="themePreview" v-tippy="{interactive: true}" content="<a class='text-light' href='https://www.instagram.com/kieanwong.art/'><i class='fab fa-instagram'></i> @kieanwong.art</a>">
                </label>
                <label>
                    <input v-model="classForm.character_theme" type="radio" name="charTheme" class="hide-radios" value="0">
                    <img @click="notify" src="/img/character/themes-preview/custom.png" class="themePreview" v-tippy :content="trans.get('classroom.custom_theme')">
                </label>

            </b-tab-item>

            <b-tab-item label="+ Info" icon="info" icon-pack="far">
                <div class="mt-4">
                <h1 class="is-size-2 has-text-centered"><i class="fal fa-laugh-beam  faa-wrench animated"></i> {{ trans.get('classroom.finish_title') }}</h1>
                <h4 class="is-size-4 my-3 has-text-centered">{{ trans.get('classroom.info_wizard_0') }}</h4>
                <ol class="p-4 pl-5">
                    <li class="is-size-5 m-3">{{ trans.get('classroom.info_wizard_1') }} <i class="fal fa-users"></i></li>
                    <li class="is-size-5 m-3">{{ trans.get('classroom.info_wizard_2') }} <i class="fal fa-tasks"></i></li>
                    <li class="is-size-5 m-3">{{ trans.get('classroom.info_wizard_3') }} <i class="fal fa-treasure-chest"></i></li>
                    <li class="is-size-5 m-3">{{ trans.get('classroom.info_wizard_4') }} <i class="fal fa-hands-helping"></i></li>
                    <li class="is-size-5 m-3">{{ trans.get('classroom.info_wizard_5') }} <i class="fal fa-swords"></i></li>
                </ol>
                </div>
            </b-tab-item>
        </b-tabs>
        <div class="px-1" style="position: fixed; bottom: 0; left: 0;width: 100%">
            <div class="buttons">
              <div class="mb-1 buttons has-addons">
                  <button type="button" class="button" v-if="activeTab>0" @click="activeTab--"><i class="fas fa-chevron-left"></i></button>
                  <button type="button" class="button is-info is-selected" @click="activeTab++" v-if="activeTab<3"><i class="fas fa-chevron-right"></i></button>
              </div>
              <div class="mb-1 has-text-right left-auto" v-if="classroom">
                  <button class="button ml-4 is-danger" @click.prevent="confirmDelete">
                      <i class="fas fa-trash"></i>
                      <span class="mx-3 is-hidden-mobile">
                      {{ trans.get('general.delete') }}
                      <i class="fas fa-radiation-alt"></i>
                      <i class="fas fa-exclamation-triangle"></i>
                      </span>
                  </button>
                  <button :disabled="(classForm.name == '' || classForm.name.length < 3) || (classForm.adventure_name == '' || classForm.adventure_name.length < 3)" class="button is-link"><i class="fas fa-edit mr-2"></i> {{ trans.get('classroom.edit') }}</button>
              </div>
              <button :disabled="(classForm.name == '' || classForm.name.length < 3)|| (classForm.adventure_name == '' || classForm.adventure_name.length < 3)" class="button is-success mb-3 left-auto" v-else>{{ trans.get('classroom.end_wizard') }}</button>
            </div>
        </div>
    </section>
</template>

<script>
export default {
  props: ["goals", "themes", "classroom"],
  mounted: function () {
    axios.get("/utils/get/themes").then((response) => {
      this.imgThemes = response.data;
      this.goalsJson = JSON.parse(this.goals);
      this.themesJson = JSON.parse(this.themes);
      if (this.classroom) {
        this.classForm.name = this.classroom.name;
        this.classForm.adventure_name = this.classroom.adventure_name;
        this.classForm.goal_type = this.classroom.goal_type;
        if (!this.classroom.background) {
          this.classForm.bg_theme = this.classroom.theme.id;
          this.classForm.bg_image = null;
        } else {
          this.classForm.bg_image = this.classroom.background;
          this.classForm.bg_theme = null;
        }
        this.classForm.character_theme = this.classroom.character_theme;
      }
    });
  },
  data: function () {
    return {
      isFilled: true,
      activeTab: 0,
      goalsJson: [],
      themesJson: [],
      imgThemes: null,
      goalSelected: 1,
      classForm: {
        name: "",
        adventure_name: "FantasyClass",
        goal_type: 1,
        bg_theme: 1,
        bg_image: "",
        character_theme: 7,
      },
    };
  },
  methods: {
    selectImg(e) {
      document.querySelectorAll(".themes img ").forEach(function (imgSelector) {
        imgSelector.classList.remove("selected");
      });

      this.classForm.bg_theme = null;
      document
        .querySelectorAll("input[name=bgtheme]")
        .forEach(function (inputImg) {
          inputImg.checked = false;
        });

      let img = e.target;

      img.classList.add("selected");
      this.classForm.bg_image = img.src;
    },
    selectTheme(e) {
      let img = e.target;
      document.querySelectorAll(".themes img ").forEach(function (imgSelector) {
        imgSelector.classList.remove("selected");
      });
      document
        .querySelectorAll("input[name=bgtheme]")
        .forEach(function (inputImg) {
          inputImg.checked = false;
        });
      img.classList.add("selected");
    },
    getFilledText() {
      if (this.isFilled) {
        return this.trans.get("classroom.class_filled_ok");
      }
      return this.trans.get("classroom.class_filled_ko");
    },
    notify: function (id) {
      this.$toast(this.trans.get("classroom.create_info"));
    },
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