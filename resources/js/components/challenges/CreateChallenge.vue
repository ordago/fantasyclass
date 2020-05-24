<template>
    <div class="container has-padding-3">
      <form method="post" @submit.prevent="formSubmit" :action="'/classroom/' + this.code + '/challenge'">
        <input :value="csrfToken" type="hidden" name="_token"/>

      <div class="has-margin-y-3">
              <label for="name"><span class="help is-danger is-inline">* </span> {{ trans.get('challenges.icon') }}</label>
      </div>
        <div class="field has-addons">
          <p class="control">
                <vfa-picker is-both="false">
                      <template v-slot:activator="{ on }">
                        <button class="button is-link fullIcon" type="button" @click="on">
                          <span id="iconPreview">
                            <i :class="'fas fa-image'" v-show="!challengeInfo.icon"></i>
                            <i :class="challengeInfo.icon" v-if="challengeInfo.icon"></i>
                          </span>
                          <i class="fas fa-caret-down ml-1"></i>
                        </button>
                      </template>
                        <template v-slot:icon="{ icon, picked }">
                          <div @click="parentIcon(icon); picked(icon);challengeInfo.icon = parentIcon(icon) + ' fa-' + icon.class;updateIcon();" :title="icon.label">
                            <span :class="[parentIcon(icon), `fa-${icon.class}`, 'vfa-icon-preview']" />
                          </div>
                        </template>
              </vfa-picker>
          </p>
          <p class="control is-expanded">
                <input v-model="challengeInfo.icon" name="icon" class="input" required :placeholder="trans.get('behaviours.icon_select')" type="text" />
          </p>
        </div>
        <div class="form-group" style="margin-top: -10px;">
          <label><small>{{ trans.get('behaviours.fontawesome') }} <a href="https://fontawesome.com/icons?d=gallery" target="_blank">FontAwesome</a></small></label>
        </div>

        <div class="has-margin-top-3">
          <label for="name"><span class="help is-danger is-inline">* </span> {{ trans.get('challenges.name') }}</label>
          <input type="text" id="name" v-model="challengeInfo.name" name="name" required class="input has-margin-y-3">
        </div>         
        <div class="has-margin-top-3">
            <label for="name"><span class="help is-danger is-inline">* </span> {{ trans.get('challenges.parent') }}</label>
            <div class="field">
              <div class="control">
                <div class="select is-fullwidth">
                  <select v-model="challengeInfo.challenge_id">
                      <option value="0"></option>
                      <option :value="challenge.id" v-for="challenge in $parent.challenges" v-bind:key="challenge.id">{{ challenge.name }}</option>
                  </select>  
                </div>
              </div>
            </div>
          </div>
          <div class="has-margin-top-3">
          <button class="button is-link" @click="update" v-if="challenge" type="button">{{ trans.get('challenges.edit') }}</button>
          <button class="button is-success" type="submit" v-if="!challenge">{{ trans.get('challenges.create') }}</button>
        </div>
      </form>
  </div>
</template>

<script>
import VueFontAwesomePicker from "vfa-picker";

Vue.use(VueFontAwesomePicker);

  export default {
        props: ['code', 'challenge'],
        created() {
          this.csrfToken = document.querySelector('meta[name="csrf-token"]').content

        },
        data: function() {
            return {
                csrfToken: null,
                challengeInfo: {
                  challenge_id: null,
                  id: null,
                  icon: null,
                  name: null,
                }
            }
        },
        methods: {
            formSubmit: function(e) {  
              axios.post('/classroom/'+ this.code + '/challenges', this.$data.challengeInfo)
                  .then(response => {
                              this.$toasted.show(response.data.message, { 
                                            position: "top-center",
                                            duration: 3000, 
                                            iconPack: 'fontawesome',
                                            icon: response.data.icon,
                                            type: response.data.type,
                                })
                        if(response.data.challenge) {
                          this.$parent.refresh(response.data.challenge)
                        }
                    });
            },
             parentIcon(iconSelected) {

                if (iconSelected.styles.indexOf("regular") > -1) {
                  return "fa";
                } else if (iconSelected.styles.indexOf("solid") > -1) {
                  return "fas";
                } else if (iconSelected.styles.indexOf("brands") > -1) {
                  return "fab";
                }
                return "";
              },
              updateIcon: function() {
                  document.getElementById('iconPreview').innerHTML = "<i class='"+this.challengeInfo.icon+"'></i>"
              },
              update: function() {
                  

            }
        },
      }
</script>