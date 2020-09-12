<template>
    <div class="container has-padding-3">
      <form method="post" :action="'/classroom/' + this.code + '/badges'" enctype="multipart/form-data">
        <input :value="csrfToken" type="hidden" name="_token"/>

        <div class="field has-addons">
          <p class="control">
                <IconSelector></IconSelector>
          </p>
          <p class="control">
                <input v-model="icon" name="icon" class="input" required :placeholder="trans.get('badges.icon_select')" type="text" />
          </p>
        </div>
        <div class="form-group" style="margin-top: -10px;">
          <label><small>{{ trans.get('badges.fontawesome') }} <a href="https://fontawesome.com/icons?d=gallery" target="_blank">FontAwesome</a></small></label>
        </div>

        <div class="has-margin-top-4">
          <label for="name"><span class="help is-danger is-inline">* </span> {{ trans.get('badges.title') }}</label>
          <input type="text" id="title" v-model="title" name="title" required class="input has-margin-y-3">
        </div>
        <div class="has-margin-top-2">
          <label for="custom_text">{{ trans.get('badges.description') }}</label>
          <input type="text" v-model="description" name="description" class="input" placeholder="">
        </div>
        <div class="has-margin-top-3">
          <label>{{ trans.get('badges.attributes') }} <small class="font-italic">({{ trans.get('badges.attributes_info') }})</small></label>
          <div class="columns has-margin-y-1">
            <div class="column">
              <div class="field has-addons">
                <p class="control">
                    <span class="button is-static" v-bind:class="{ 'has-background-success': hp>0, 'has-background-danger': hp<0 }"><i class="fas fa-heart colored"></i></span>
                </p>
                <p class="control is-expanded">
                    <input type="number" name="hp" class="input" v-model="hp" required>
                </p>
             </div>
            </div>
            <div class="column">
              <div class="field has-addons">
                <p class="control">
                    <span class="button is-static" v-bind:class="{ 'has-background-success': xp>0, 'has-background-danger': xp<0 }"><i class="fas fa-fist-raised colored"></i></span>
                </p>
                <p class="control is-expanded">
                    <input type="number" name="xp" class="input" v-model="xp" required>
                </p>
             </div>
            </div>
            <div class="column">
              <div class="field has-addons">
                <p class="control">
                    <span class="button is-static"  v-bind:class="{ 'has-background-success': gold>0, 'has-background-danger': gold<0 }"><i class="fas fa-coins colored"></i></span>
                </p>
                <p class="control is-expanded">
                    <input type="number" name="gold" class="input" v-model="gold" required>
                </p>
             </div>
            </div>
          </div>
        </div>            
        <div>

          <button class="button is-link" @click="update" v-if="badge" type="button">{{ trans.get('badges.edit') }}</button>
          <button class="button is-success" type="submit" v-if="!badge">{{ trans.get('badges.create') }}</button>
        </div>
      </form>
  </div>
</template>

<script>

const IconSelector = () => import("../utils/IconSelector.vue");

  export default {
        props: ['code', 'badge'],
        created() {
          this.csrfToken = document.querySelector('meta[name="csrf-token"]').content

           if(this.badge) {
            this.title = this.trans.get(this.badge.title)
            this.description = this.trans.get(this.badge.description)
            this.hp = this.badge.hp
            this.xp = this.badge.xp
            this.gold = this.badge.gold
            this.icon = this.badge.icon
            this.id = this.badge.id
          }
        },
        data: function() {
            return {
                icon: null,
                csrfToken: null,
                title: null,
                description: null,
                xp: 0,
                hp: 0,
                gold: 0,
                id: null,
            }
        },
        components: {
          IconSelector
        },
        methods: {
            formSubmit: function(e) {  
              e.preventDefault()
            },
            
              update: function() {
                  axios.patch('/classroom/badges/' + this.id, this.$data)
                  .then(response => {
                              this.$toasted.show(response.data.message, { 
                                            position: "top-center",
                                            duration: 3000, 
                                            iconPack: 'fontawesome',
                                            icon: response.data.icon,
                                            type: response.data.type,
                                          
                                })
                    });

            }
        },
      }
</script>