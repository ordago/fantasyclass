<template>
                <vfa-picker is-both="false">
                      <template v-slot:activator="{ on }">
                        <button class="button is-link fullIcon" type="button" @click="on">
                          <span ref="iconPreview">
                            <i :class="'fas fa-image'" v-show="!$parent.$data.icon"></i>
                            <i :class="$parent.$data.icon" v-if="$parent.$data.icon"></i>
                          </span>
                          <i class="fas fa-caret-down ml-1"></i>
                        </button>
                      </template>
                        <template v-slot:icon="{ icon, picked }">
                          <div @click="parentIcon(icon); picked(icon);$parent.$data.icon = parentIcon(icon) + ' fa-' + icon.class;updateIcon();" :title="icon.label">
                            <span :class="[parentIcon(icon), `fa-${icon.class}`, 'vfa-icon-preview']" />
                          </div>
                        </template>
              </vfa-picker>
</template>

<script>
import VueFontAwesomePicker from "vfa-picker";

Vue.use(VueFontAwesomePicker);

  export default {
        created() {

        },
        data: function() {
            return {
                csrfToken: null,
            }
        },
        methods: {
            
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
                  this.$refs.iconPreview.innerHTML = "<i class='"+this.$parent.$data.icon+"'></i>"
              },
              update: function() {
                  

            }
        },
      }
</script>