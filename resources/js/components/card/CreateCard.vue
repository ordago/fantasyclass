<template>
    <div class="container bg-light h-100 w-100">
        <form method="post" @submit="formSubmit" :action="'/classroom/' + this.code + '/cards'" enctype="multipart/form-data">
            <input :value="csrfToken" type="hidden" name="_token"/>
            <input v-model="width" name="width" type="hidden"/>
            <input v-model="margin_top" name="marginTop" type="hidden"/>
            <input v-model="margin_left" name="marginLeft" type="hidden"/>

            <div class="d-flex pt-3">
              <!-- CARD -->
              <div class="flex1">
              <div class="cardContainer" id="customCard" name="card" :style="'background-color: '+ background +';'">
                <div class="lvlTopLeft" id="lvl" v-if="min_lvl>0">
                  <img src="/img/cardgen/lvl.png" class="levelCard">
                  <span class="numberLvl">{{ this.min_lvl }}</span>
                </div>
                <img :src="'/img/cardgen/type_'+type+'.png'" v-if="!fullscreen" class="typeCard" id="circleType">
                <div>
                  <h3 class="title editable_card">
                    <svg viewBox="0 0 500 150">
                        <path id="curve" d="m 3.2938789,150.87387 c 5.55773,-3.11588 91.0078161,-49.44517 248.1526411,-48.83221 154.64384,0.61296 237.31506,46.12499 243.28962,49.54732"></path>
                        <text width="250px">
                          <textPath xlink:href="#curve" startOffset="50%" text-anchor="middle" >
                            {{ this.title }}
                          </textPath>
                        </text>
                      </svg>
                  </h3>
                </div>
                <img :src="'/img/cardgen/ribbon-'+ type +'.png'" class="ribbon" id="ribbonType" v-if="!fullscreen">
                <img :src="'/img/cardgen/only_back_'+ type_bg +'.png'" class="background" v-if="!special && !fullscreen">
                <img :src="'/img/cardgen/only_back_'+ type_bg +'_gold.png'" class="background" v-if="special && !fullscreen">
                <!-- Text -->
                <p class="content text_shadow editable_card">
                    {{ this.description }}
                    </p>
                <!-- back image -->
                <div class="hiding-parent">
                  <img name="image" :src="src" :width="width + 'px'" :style="'border-radius: '+ radius/2 +'%;margin-top: '+ margin_top +'px; margin-left: ' + margin_left + 'px;'" class="image back">
                </div>
                <div class="xp_modify modifiers" v-if="xp!=0">
                  <img src="/img/cardgen/xp_modify.png" class="">
                  <span id="xp_modify_span">{{ xp }}</span>
                </div>

                <div class="hp_modify modifiers" v-if="hp!=0">
                  <img src="/img/cardgen/hp_modify.png" class="">
                  <span id="hp_modify_span">{{ hp }}</span>
                </div>

                <div class="gold_modify modifiers" v-if="gold!=0">
                  <img src="/img/cardgen/gold_modify.png" class="">
                  <span id="gold_modify_span">{{ gold }}</span>
                </div>
              </div>
              <p>
                *<strong>Bold</strong>* // ^<em>Italic</em>^ // _ <u>Underline</u> _ // [BR]
              </p>
            </div>
              <!-- END CARD -->

              <div class="properties" id="propertiesCard">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary" @click="width=width+5"><i class="fas fa-search-plus"></i></button>
                    <button type="button" class="btn btn-primary" @click="width=width-5"><i class="fas fa-search-minus"></i></button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary" @click="margin_top=margin_top+5"><i class="fas fa-arrow-down"></i></button>
                    <button type="button" class="btn btn-primary" @click="margin_top=margin_top-5"><i class="fas fa-arrow-up"></i></button>
                    <button type="button" class="btn btn-primary" @click="margin_left=margin_left-5"><i class="fas fa-arrow-left"></i></button>
                    <button type="button" class="btn btn-primary" @click="margin_left=margin_left+5"><i class="fas fa-arrow-right"></i></button>
                    <button type="button" class="btn btn-primary" @click="margin_top=0;margin_left=0;width=250;"><i class="fas fa-undo"></i></button>
                  </div>
                  <br>
                  <label v-if="!card" for="file-upload" style="display: block;" class="btn btn-primary mt-2">
                    <i class="fa fa-cloud-upload"></i> {{ trans.get('cards.custom_image') }}
                  </label>
                  <input v-if="!card" type="file" accept="image/*" id="file-upload" name="image" style="display:none" class="my-2 p-3 border border-secondary rounded" @change="getImage">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="title">{{ trans.get('cards.title') }}</label>
                    </div>
                    <input type="text" v-model="title" name="title" id="title" :placeholder="trans.get('cards.title')" class="form-control">
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="description">{{ trans.get('cards.description') }}</label>
                    </div>
                    <input type="text" v-model="description" name="description" id="description" :placeholder="trans.get('cards.description')" class="form-control">
                  </div>
                  <div class="input-group mb-3 hide-radios">
                        <label>
                            <input type="radio" v-model="type_bg" checked name="bgType" value="0">
                            <img src="/img/cardgen/only_back_0_prev.png" v-tippy content="By <i class='fab fa-twitter'></i> @soyjujo_juanjo">
                        </label>
                        <label class="ml-1">
                            <input type="radio" v-model="type_bg" name="bgType" value="1">
                            <img src="/img/cardgen/only_back_1_prev.png" v-tippy content="By <i class='fab fa-twitter'></i> @soyjujo_juanjo">
                        </label>
                        <label class="ml-1">
                            <input type="radio" v-model="type_bg" name="bgType" value="2">
                            <img src="/img/cardgen/only_back_2_prev.png" v-tippy content="By <i class='fab fa-twitter'></i> @soyjujo_juanjo">
                        </label>
                        <label class="ml-1">
                            <input type="radio" v-model="type_bg" name="bgType" value="3">
                            <img src="/img/cardgen/only_back_3_prev.png" v-tippy content="By <i class='fab fa-twitter'></i> @soyjujo_juanjo">
                        </label>
                        <label class="ml-1">
                            <input type="radio" v-model="type_bg" name="bgType" value="4">
                            <img src="/img/cardgen/only_back_4_prev.png" v-tippy content="By <i class='fab fa-twitter'></i> @soyjujo_juanjo">
                        </label>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="colorText">{{ trans.get('cards.background_color') }}</label>
                    </div>
                    <input type="color" name="background" v-model="background" class="form-control">
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="radiusImg">Radius <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.radius_help')"></i></label>
                    </div>
                    <input type="number" required name="radius" v-model="radius" id="radiusImg" min="0" value="0" max="100" class="form-control">
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="minLvl">{{ trans.get('cards.min_lvl') }} <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.min_lvl_help')"></i></label>
                    </div>
                    <input type="number" v-model="min_lvl" name="minLvl" required min="0" value="0" class="form-control">
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="typeSelect">{{ trans.get('cards.type') }} <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.type_help')"></i></label>
                    </div>
                    <select v-model="type" class="form-control col-9" name="type">
                      <option value="1">{{ trans.get('settings.common') }}</option>
                      <option value="2">{{ trans.get('settings.rare') }}</option>
                      <option value="3">{{ trans.get('settings.epic') }}</option>
                      <option value="4">{{ trans.get('settings.legendary') }}</option>
                    </select>
                  </div>
                  <div class="input-group mb-3">
                     <input type="checkbox" v-model="special" value="1" id="checkspecial" class="cbx" name="special" style="display:none">
                     <label style="width: 40px" for="checkspecial" class="toggle"><span></span></label>
                   <label for="checkspecial" class="col-9 col-form-label">{{ trans.get('cards.special') }} <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.special_help')"></i></label>
                  </div>
                  <div class="input-group mb-3">
                    <input type="checkbox" name="fullscreen" value="1" v-model="fullscreen" id="fullscreenCard" class="cbx" style="display:none">
                    <label style="width: 40px" for="fullscreenCard" class="toggle"><span></span></label>
                    <label for="fullscreenCard" class="col-9 col-form-label"><i class="fas fa-expand"></i> Fullscreen <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.fullscreen_help')"></i></label>
                  </div>
              </div>
              <div class="properties2" id="properties2Card">
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="xp_modify"><i class="fas fa-fist-raised colored"></i> <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.xp_help')"></i></label>
                    </div>
                    <input type="number" required v-model="xp" name="xp"  value="0" class="form-control">
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="gold_modify"><i class="fas fa-coins colored"></i> <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.gold_help')"></i></label>
                    </div>
                    <input type="number" required v-model="gold" name="gold" class="form-control">
                  </div>

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="hp_modify"><i class="fas fa-heart colored"></i> <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.hp_help')"></i></label>
                    </div>
                    <input type="number" required v-model="hp" name="hp" class="form-control col-11">
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="slot_modify"><i class="fas fa-club colored"></i> <i class="fas fa-question-circle ml-2" v-tippy :content="trans.get('cards.slot_help')"></i></label>
                    </div>
                    <input type="number" required id="slot_modify" v-model="slot" name="slot" value="0" class="form-control">
                  </div>
                </div>
        
                    <button class="btn btn-primary" @click="updateCard" v-if="card" type="button">{{ trans.get('cards.edit_card') }}</button>
                    <button class="btn btn-success" v-if="!card">{{ trans.get('cards.create_card') }}</button>

            </div>
          </div>
        </form>
    </div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['code', 'card'],
        created() {
          this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
          if(this.card) {
            let cardJson = JSON.parse(this.card);
            this.id = cardJson.id
            this.width = cardJson.width
            this.margin_top = cardJson.margin_top
            this.margin_left = cardJson.margin_left
            this.type = cardJson.type
            this.type_bg = cardJson.type_bg
            this.radius = cardJson.radius
            this.xp = cardJson.xp
            this.hp = cardJson.hp
            this.gold = cardJson.gold
            this.min_lvl = cardJson.min_lvl
            this.special = cardJson.special
            this.fullscreen = cardJson.fullscreen
            this.slot = cardJson.slot
            this.title = cardJson.title
            this.description = cardJson.description
            this.src = cardJson.src
            this.background = cardJson.background
          }
        },
        data: function() {
            return {
                id: -1,
                width: 250,
                margin_top: 0,
                margin_left: 0,
                type: 1,
                type_bg: 0,
                radius: 0,
                xp: 0,
                hp: 0,
                gold: 0,
                min_lvl: 0,
                special: false,
                fullscreen: false,
                slot: 0,
                title: '',
                description: '',
                src: '/img/cards/card_bg.png',
                background: '#000000',
                csrfToken: null,
            }
        },
        methods: {
            formSubmit: function(e) {
                
               if(this.title == '' && this.content == '' && !this.fullscreen) {
                 if(confirm(this.trans.get("cards.confirm_empty"))) {
                   return true
                 } else e.preventDefault()
               }
              
            },
            getImage: function(e) {
                let imageU = e.target.files[0]
                if(imageU.size > 10000000) {
                    e.target.value = ''
                    this.$toasted.show("File size error. Max file size 10MB", { 
                                        position: "top-center",
                                        duration: 3000, 
                                        iconPack: 'fontawesome',
                                        type: 'error',
                                       
                    })
                } else {
                    let reader = new FileReader()
                    reader.readAsDataURL(imageU)
                    reader.onload = e => {
                        this.src = e.target.result
                    }
                }
            },
            updateCard: function() {
              axios.patch('/classroom/'+ this.code + '/cards/' + this.id, this.$data)
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
        }
    }
</script>
