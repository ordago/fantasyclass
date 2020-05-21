<template>
    <div class="container has-padding-3">
      <form method="post" :action="'/classroom/' + this.code + '/behaviours'" enctype="multipart/form-data">
        <input :value="csrfToken" type="hidden" name="_token"/>

        <div class="field has-addons">
          <p class="control">
                <vfa-picker is-both="false" v-bind.sync="category">
                      <template v-slot:activator="{ on }">
                        <button class="button is-link" type="button" @click="on">
                          <i :class="'fas fa-image'" v-if="!fullIcon"></i>
                          <i :class="fullIcon" v-if="fullIcon"></i>
                          <i class="fas fa-caret-down ml-1"></i>
                        </button>
                      </template>
                        <template v-slot:icon="{ icon, picked }">
                          <div @click="parent(icon); picked(icon);fullIcon = parent(icon) + ' fa-' + icon.class" :title="icon.label">
                            <span :class="[parent(icon), `fa-${icon.class}`, 'vfa-icon-preview']" />
                          </div>
                        </template>
              </vfa-picker>
          </p>
          <p class="control">
                <input v-model="fullIcon" name="icon" class="input" required :placeholder="trans.get('behaviours.icon_select')" type="text" />
          </p>
        </div>
        <div class="form-group" style="margin-top: -10px;">
          <label><small>{{ trans.get('behaviours.fontawesome') }} <a href="https://fontawesome.com/icons?d=gallery" target="_blank">FontAwesome</a></small></label>
        </div>

        <div class="has-margin-top-4">
          <label for="name"><span class="help is-danger is-inline">* </span> {{ trans.get('behaviours.name') }} <small class="font-italic">({{ trans.get('behaviours.name_info') }})</small></label>
          <input type="text" id="name" name="name" required class="input has-margin-y-3">
        </div>
        <div class="has-margin-top-2">
          <label for="custom_text">{{ trans.get('behaviours.custom_text') }} <small class="font-italic">({{ trans.get('behaviours.custom_text_info') }})</small></label>
          <input type="text" id="custom_text" name="custom_text" class="input" placeholder="">
        </div>
        <div class="has-margin-top-3">
          <label>{{ trans.get('behaviours.attributes') }} <small class="font-italic">({{ trans.get('behaviours.attributes_info') }})</small></label>
          <div class="columns has-margin-y-1">
            <div class="column">
              <div class="field has-addons">
                <p class="control">
                    <span class="button is-static" v-bind:class="{ 'hp_up': hp>0, 'hp_down': hp<0 }"><i class="fas fa-heart colored"></i></span>
                </p>
                <p class="control is-expanded">
                    <input type="number" name="hp" class="input" v-model="hp" required>
                </p>
             </div>
            </div>
            <div class="column">
              <div class="field has-addons">
                <p class="control">
                    <span class="button is-static" v-bind:class="{ 'hp_up': xp>0, 'hp_down': xp<0 }"><i class="fas fa-fist-raised colored"></i></span>
                </p>
                <p class="control is-expanded">
                    <input type="number" name="xp" class="input" v-model="xp" required>
                </p>
             </div>
            </div>
            <div class="column">
              <div class="field has-addons">
                <p class="control">
                    <span class="button is-static"  v-bind:class="{ 'hp_up': gold>0, 'hp_down': gold<0 }"><i class="fas fa-coins colored"></i></span>
                </p>
                <p class="control is-expanded">
                    <input type="number" name="gold" class="input" v-model="gold" required>
                </p>
             </div>
            </div>
          </div>
        </div>            
        <div>
          <button class="button is-success" type="submit">{{ trans.get('behaviours.create') }}</button>
        </div>
      </form>
  </div>
</template>

<script>
import VueFontAwesomePicker from "vfa-picker";

Vue.use(VueFontAwesomePicker);

  export default {
        props: ['code'],
        created() {
          this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        },
        data: function() {
            return {
                icon: null,
                    category: {
                    class: undefined,
                    unicode: undefined
                },
                csrfToken: null,
                fullIcon: null,
                xp: 0,
                hp: 0,
                gold: 0,
            }
        },
        methods: {
            formSubmit: function(e) {  
              console.log('send')
              e.preventDefault()
            },
             parent(icon) {
                if (icon.styles.indexOf("regular") > -1) {
                  return "fa";
                } else if (icon.styles.indexOf("solid") > -1) {
                  return "fas";
                } else if (icon.styles.indexOf("brands") > -1) {
                  return "fab";
                }
                return "";
              }
        },
      }
</script>