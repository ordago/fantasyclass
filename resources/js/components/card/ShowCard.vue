<template>
  <div class="has-margin-2">
    <div class="cardContainer cardFunction " data-id="1" group-id="" :style="'background-color:'+ card.background + ';'">
      <div class="lvlTopLeft" v-if="card.min_lvl">
          <img src="/img/cardgen/lvl.png" class="levelCard">
          <span class="numberLvl">{{ card.min_lvl }}</span>
        </div>
      <img :src="'/img/cardgen/type_' + card.type + '.png'"  v-if="!card.fullscreen" class="typeCard">
      <div>
        <h3 class="title textShadow">
          <svg viewBox="0 0 500 500">
              <path id="curve" d="m 3.2938789,150.87387 c 5.55773,-3.11588 91.0078161,-49.44517 248.1526411,-48.83221 154.64384,0.61296 237.31506,46.12499 243.28962,49.54732"></path>
              <text width="250px">
                <textPath xlink:href="#curve" startOffset="50%" text-anchor="middle">
                  {{ trans.get(card.title) }}</textPath>
              </text>
            </svg>
          </h3>
      </div>
      <img :src="'/img/cardgen/ribbon-' + card.type + '.png'" class="ribbon" v-if="!card.fullscreen">
      <img :src="'/img/cardgen/only_back_'+ card.type_bg +'.png'" class="background" v-if="!card.special && !card.fullscreen">
      <img :src="'/img/cardgen/only_back_'+ card.type_bg +'_gold.png'" class="background" v-if="card.special  && !card.fullscreen">

      <div class="content text_shadow">{{ card.description }}</div>
    
      <div class="hiding-parent">
        <img :src="card.src" :style="'margin-left: '+ card.margin_left + 'px;margin-top:'+ card.margin_top +'px;width:'+card.width+'px;border-radius:'+ card.radius +'px'" class="back">
      </div>
      <div class="xp_modify modifiers" v-if="card.xp!=0">
        <img src="/img/cardgen/xp_modify.png" class="">
        <span>{{ card.xp }}</span>
      </div>
      <div class="hp_modify modifiers" v-if="card.hp!=0">
        <img src="/img/cardgen/hp_modify.png" class="">
        <span>{{ card.hp }}</span>
      </div>
      <div class="gold_modify modifiers" v-if="card.gold!=0">
        <img src="/img/cardgen/gold_modify.png">
        <span>{{ card.gold }}</span>
      </div>
    </div>
    <div style="text-align:center;" v-if="this.admin==1">
        <a :href="'/classroom/' + code + '/cards/' + card.id" type="submit" class="button is-dark"><i class="fas fa-edit"></i></a>
        <button type="submit" @click="confirmDelete" class="button is-danger"><i class="fas fa-trash-alt"></i></button>
        <button type="submit" disabled class="button is-primary"><i class="fas fa-share-alt"></i></button>
      </div>
  </div>
</template>

<script>
  export default {
        props: ['card', 'admin', 'code'],
        mounted() {
          
        },
        data: function() {
            return {
            }
        },
        methods: {
          confirmDelete() {
                this.$buefy.dialog.confirm({
                    title: this.trans.get('general.delete'),
                    message: this.trans.get('general.confirm_delete'),
                    confirmText: this.trans.get('general.delete'),
                    type: 'is-danger',
                    hasIcon: true,
                    icon: 'times-circle',
                    iconPack: 'fa',
                    ariaRole: 'alertdialog',
                    ariaModal: true,
                    onConfirm: () => {
                          axios.delete('/classroom/card/' + this.card.id)
                            .then(response => {
                              if(response.data === 1) {
                                this.$el.parentNode.removeChild(this.$el);
                              }
                          })
                    }
                }) 
          }

        },
            
  }
</script>
