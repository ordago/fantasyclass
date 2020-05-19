<template>
    <div class="container bg-light h-100 w-100">
      <form method="post" :action="'/classroom/' + this.code + '/behaviours'" enctype="multipart/form-data">
        <input :value="csrfToken" type="hidden" name="_token"/>
        <div class="form-group mt-2">
        <label for="inputAddress"><span class="text-danger">* </span> {{ trans.get('behaviours.icon') }}</label>

        <vfa-picker is-both="false" v-bind.sync="category">
            <template v-slot:activator="{ on }">
              <div class="row ml-1">
              <button class="btn btn-secondary" type="button" @click="on">
                <i :class="'fas fa-image'" v-if="!fullIcon"></i>
                <i :class="fullIcon" v-if="fullIcon"></i>
                <i class="fas fa-caret-down ml-1"></i>
              </button>
              <input v-model="fullIcon" name="icon" class="form-control col-4 mx-2" required :placeholder="trans.get('behaviours.icon_select')" type="text" />
              </div>
            </template>
              <template v-slot:icon="{ icon, picked }">
                <div @click="parent(icon); picked(icon);fullIcon = parent(icon) + ' fa-' + icon.class" :title="icon.label">
                  <span :class="[parent(icon), `fa-${icon.class}`, 'vfa-icon-preview']" />
                </div>
              </template>
          </vfa-picker>
        </div>
        <div class="form-group" style="margin-top: -10px;">
          <label><small>{{ trans.get('behaviours.fontawesome') }} <a href="https://fontawesome.com/icons?d=gallery" target="_blank">FontAwesome</a></small></label>
        </div>
        <div class="form-group">
          <label for="name"><span class="text-danger">* </span>{{ trans.get('behaviours.name') }} <small class="font-italic">({{ trans.get('behaviours.name_info') }})</small></label>
          <input type="text" id="name" name="name" required class="form-control" placeholder="">
        </div>
        <div class="form-group">
          <label for="custom_text">{{ trans.get('behaviours.custom_text') }} <small class="font-italic">({{ trans.get('behaviours.custom_text_info') }})</small></label>
          <input type="text" id="custom_text" name="custom_text" class="form-control" placeholder="">
        </div>

        <label>{{ trans.get('behaviours.attributes') }} <small class="font-italic">({{ trans.get('behaviours.attributes_info') }})</small></label>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" v-bind:class="{ 'hp_up': hp+xp+gold >= 0, 'hp_down': hp+xp+gold < 0 }"><i class="fas fa-heart colored"></i></span>
              </div>
              <input type="number" name="hp" class="form-control" v-model="hp" required>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"  v-bind:class="{ 'hp_up': xp>0, 'hp_down': xp<0 }"><i class="fas fa-fist-raised colored"></i></span>
              </div>
              <input type="number" name="xp" class="form-control" v-model="xp" required>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"  v-bind:class="{ 'bg-success': gold>0, 'bg-danger': gold<0 }"><i class='fas fa-coins colored'></i></span>
              </div>
              <input type="number" name="gold" class="form-control" v-model="gold" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-success" type="submit">{{ trans.get('behaviours.create') }}</button>
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