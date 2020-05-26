<template>
            <div class="w-100">
                <div class="field w-100">
                    <label class="label">Title *</label>
                    <div class="control">
                        <input class="input" type="text" v-model="challenge.title" placeholder="">
                    </div>
                </div>
                <div class="field w-100">
                    <label class="label">Description</label>
                    <div class="control">
                        <input class="input" v-model="challenge.description" type="text" placeholder="This is for info for you. E.g. Trigonometry test">
                    </div>
                </div>
                 <b-field label="Password">
                    <b-input type="password"
                        icon-pack="fas"
                        placeholder="Don't abuse of this :D"
                        v-model="challenge.password"
                        password-reveal>
                    </b-input>
                </b-field>
                
                        <!-- :date-formatter="(date) =>  moment(date).locale(lang).format('YYYY-MM-DD')" -->
                <div class="w-100">
                    <b-field label="When it will be visible?">
                    <b-datetimepicker v-model="datepicker"
                        placeholder="Click to select..."
                        icon-pack="fa"
                        >
                        <template slot="left">
                            <button class="button is-primary"
                                @click="datetime = new Date()">
                                <b-icon icon="clock"></b-icon>
                                <span>Now</span>
                            </button>
                        </template>
                        <template slot="right">
                            <button class="button is-danger"
                                @click="datetime = null">
                                <b-icon icon="close"></b-icon>
                                <span>Clear</span>
                            </button>
                        </template>
                    </b-datetimepicker>
                    </b-field>
                </div>
                <div class="field w-100 has-padding-top-3">
                    <label class="label">Content</label>
                    <div class="control content" data-app>
                        <editor></editor>
                    </div>
                </div>
                <div class="field">
                    <b-switch 
                        type="is-info"
                        v-model="challenge.is_conquer">
                        Is a conquer challenge?</b-switch>
                </div>
                <div v-if="challenge.is_conquer" class="has-padding-4 has-border rounded">
                    <div class="field w-100 has-padding-top-3">
                        <label class="label">Icon</label>
                        <div class="field has-addons">
                            <p class="control">
                                <icon-selector></icon-selector>
                            </p>
                            <p class="control is-expanded">
                                <input v-model="icon" ref="icon" name="icon" class="input" required :placeholder="trans.get('behaviours.icon_select')" type="text" />
                            </p>
                        </div>
                    </div>
                    <label class="label">Rewards</label>
                    <div class="columns">
                        <div class="column">
                            <div class="field has-addons">
                                <p class="control">
                                    <span class="button is-static"><i class="fas fa-fist-raised colored"></i></span>
                                </p>
                                <p class="control is-expanded">
                                    <input type="number" name="xp" class="input" v-model="challenge.xp" required>
                                </p>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field has-addons">
                                <p class="control">
                                    <span class="button is-static" ><i class="fas fa-heart colored"></i></span>
                                </p>
                                <p class="control is-expanded">
                                    <input type="number" name="hp" class="input" v-model="challenge.hp" required>
                                </p>
                            </div>
                        </div>
                        </div>
                        <div class="columns">
                        <div class="column">
                            <div class="field has-addons">
                                <p class="control">
                                    <span class="button is-static"><i class="fas fa-coins colored"></i></span>
                                </p>
                                <p class="control is-expanded">
                                    <input type="number" name="gold" class="input" v-model="challenge.gold" required>
                                </p>
                            </div>
                        </div>
                      
                        <div class="column">
                            <div class="field has-addons">
                                <p class="control">
                                    <span class="button is-static"><i class="fas fa-club colored"></i></span>
                                </p>
                                <p class="control is-expanded">
                                    <input type="number" name="cards" class="input" v-model="challenge.cards" required>
                                </p>
                            </div>
                        </div>
                        </div>
                        <div class="field">
                            <b-switch 
                                type="is-info"
                                v-model="challenge.auto_assign">
                                Auto-assign cards?</b-switch>
                        </div>
                        <div class="field">
                            <b-switch 
                                type="is-info"
                                v-model="challenge.optional">
                                Optional</b-switch>
                        </div>
                    </div>
                    <b-button @click="createChallenge">Click Me</b-button>

        </div>
</template>
<script>
    export default {
            props: ['challengegroup', 'code'],
            mounted: function() {
                
            },
            data: function() {
                return {
                    icon: null,
                    content: ``,
                    datepicker: new Date(),
                    challenge: {
                        icon: null,
                        datetime: new Date(),
                        description: null,
                        title: null,
                        content: ``,
                        is_conquer: false,
                        xp: 0,
                        hp: 0,
                        gold: 0,
                        cards: 0,
                        auto_assign: 0,
                        optional: false,
                        password: null,
                        challenge_group_id: null,
                        lang: "es"

                    },
                }
            },
            methods: {
                createChallenge() {
                    this.challenge.icon = this.icon
                    this.challenge.content = this.content
                    this.challenge.challenge_group_id = this.challengegroup
                    let date = this.datepicker
                    this.challenge.datetime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes()
                    axios.post('/classroom/'+ this.code + '/challenges', this.challenge)
                            .then(response => {
                              this.$toasted.show(response.data.message, { 
                                            position: "top-center",
                                            duration: 3000, 
                                            iconPack: 'fontawesome',
                                            icon: response.data.icon,
                                            type: response.data.type,
                                })
                            if(response.data.type == 'success') {
                                this.$parent.$parent.challenges.push(response.data.challenge)
                                this.$parent.addChallenge = false
                            }
                    });
                    this.$parent.$parent.$forceUpdate()
                },
                  dateFormatter(dt){
                        return dt.toLocaleDateString('es-ES', dateoptions);
                    }
            },
            components: {
            },

            computed: {
    
            },
    }
</script>
