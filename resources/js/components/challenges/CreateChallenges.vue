<template>
    <div class="w-100">
        <form action="#" method="post" @submit.prevent="createChallenge">

                <div class="field w-100">
                    <label class="label">Title *</label>
                    <div class="control">
                        <input class="input" type="text" v-model="challenge.title" required placeholder="">
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
                <div class="w-100">
                    <b-field label="When it will be visible?">
                    <b-datetimepicker v-model="datepicker"
                        placeholder="Click to select..."
                        icon-pack="fa"
                        horizontal-time-picker
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
                        <editor :code="code"></editor>
                    </div>
                </div>
                <div class="field">
                    <b-switch 
                        type="is-info"
                        v-model="challenge.is_conquer"
                        true-value="1"
                        false-value="0"
                        >
                        Is a conquer challenge?</b-switch>
                </div>
                <div v-if="challenge.is_conquer==1" class="has-padding-4 has-border rounded">
                    <div class="field w-100 has-padding-top-3">
                        <label class="label">Icon</label>
                        <div class="field has-addons">
                            <p class="control">
                                <icon-selector></icon-selector>
                            </p>
                            <p class="control is-expanded">
                                <input v-model="challenge.icon" ref="icon" name="icon" class="input" required :placeholder="trans.get('behaviours.icon_select')" type="text" />
                            </p>
                            <p class="control">
                                <input v-model="challenge.color"  name="color" class="input" type="color" style="padding:0;min-width: 50px;" />
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
                                v-model="challenge.optional"
                                true-value="1"
                                false-value="0"
                                >
                                Optional</b-switch>
                        </div>
                    </div>
                    <button type="submit" v-if="!edit" class="button is-primary">{{ trans.get('challenges.create_challenge') }}</button>
                    <button type="submit" v-else class="button is-info">{{ trans.get('challenges.edit_challenge') }}</button>
        </form>
    </div>
</template>
<script>
    export default {
            props: ['challengegroup', 'code', 'icon', 'edit'],
            mounted: function() {
                    this.challenge.icon = this.icon.icon
                    this.challenge.color = this.icon.color
                    if(this.edit) {
                        this.challenge = this.edit
                        this.content = this.edit.content
                    }
            },
            data: function() {
                return {
                    content: ``,
                    datepicker: new Date(),
                    challenge: {
                        icon: null,
                        color: null,
                        datetime: new Date(),
                        description: null,
                        title: null,
                        content: ``,
                        is_conquer: 0,
                        xp: 0,
                        hp: 0,
                        gold: 0,
                        cards: 0,
                        auto_assign: 0,
                        optional: 0,
                        password: null,
                        challenges_group_id: null,
                        _method: 'post',
                    },
                }
            },
            methods: {
                createChallenge() {
               
                    this.challenge.content = this.content
                    this.challenge.challenges_group_id = this.challengegroup
                    let date = this.datepicker
                    this.challenge.datetime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes()
                    let route;

                    if(this.edit) {
                        this.challenge._method = 'patch'
                        route = '/classroom/'+ this.code + '/challenges/' + this.challenge.id
                    } else {
                        route = '/classroom/'+ this.code + '/challenges';
                    }
                    
                    axios.post(route, this.challenge)
                            .then(response => {
                              this.$toasted.show(response.data.message, { 
                                            position: "top-center",
                                            duration: 3000, 
                                            iconPack: 'fontawesome',
                                            icon: response.data.icon,
                                            type: response.data.type,
                                })
                                if(response.data.type == 'success') {
                                    this.$parent.addChallenge = false
                                    this.$parent.$parent.getChallenges(this.challenge.challenges_group_id)
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
