<template>
    <div class="container">
      <form method="post" :action="'/classroom/' + this.code + '/maps'" enctype="multipart/form-data">
        <input :value="csrfToken" type="hidden" name="_token"/>

        <div class="mt-4">
          <label for="name"><span class="help is-danger is-inline">* </span> {{ trans.get('maps.name') }}</label>
          <input type="text" id="name" v-model="name" name="name" required class="input my-3">
        </div>
        <div class="my-2">
          <label for="url"><span class="help is-danger is-inline">* </span> {{ trans.get('maps.url') }} <small class="font-italic">({{ trans.get('maps.url_info') }})</small></label>
          <input type="url" v-model="url" name="url" class="input" required placeholder="">
        </div>
        <div>
          <button class="button is-link" @click="update" v-if="map" type="button">{{ trans.get('general.edit') }}</button>
          <button class="button is-success" type="submit" v-if="!map">{{ trans.get('maps.create') }}</button>
        </div>
      </form>
  </div>
</template>

<script>

  export default {
        props: ['code', 'map'],
        created() {
          this.csrfToken = document.querySelector('meta[name="csrf-token"]').content

           if(this.map) {
            this.name = this.map.name
            this.url = this.map.url
            this.id = this.map.id
          }
        },
        data: function() {
            return {
                csrfToken: null,
                name: null,
                url: null,
            }
        },
        methods: {
            formSubmit: function(e) {  
              e.preventDefault()
            },
            
              update: function() {
                  this.icon = this.fullIcon
                  axios.patch('/classroom/maps/' + this.id, this.$data)
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