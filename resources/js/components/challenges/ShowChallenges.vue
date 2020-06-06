<template>
<div class="has-padding-left-0-desktop">
    <div class="panel has-padding-left-0-desktop">
        <p class="panel-heading is-flex has-space-between align-items-center has-padding-3">
                <span class="has-padding-left-3"> {{ challengegroup.name }}</span>
                <button class="button" @click="addChallenge=!addChallenge" v-html="buttonAddChallege"></button>
        </p>
        <div class="panel-block" v-if="!addChallenge&&challenges.length > 0">
            <p class="control has-icons-left">
            <input class="input" type="text" v-model="search" placeholder="Search" >
            <span class="icon is-left">
                <i class="fas fa-search" aria-hidden="true"></i>
            </span>
            </p>
        </div>
        
        <div class="panel-block" v-if="addChallenge">
           <create-challenges :edit="challengeEdit" :iconPrev="icon" :code="code" :challengegroup="challengegroup.id"></create-challenges>
        </div>

        <div class="panel-block" v-if="challenges.length == 0 && !addChallenge">
            <h3 class="is-size-3 has-padding-4 w-100 has-text-centered">
                <i class="fal fa-smile-wink"></i> {{ trans.get('challenges.empty') }}
            </h3>
        </div>
        
        <div class="panel-block is-block has-padding-3" v-if="challenges.length > 0 && !addChallenge">
            <div v-for="challenge in filteredList" v-bind:key="challenge.id" class="box has-margin-bottom-3">
                <section class="media">
                    <div class="media-content">
                    <div class="content">
                        <h1><i v-if="challenge.is_conquer&&challenge.icon" class="is-size-4" :style="'color:' + challenge.color" :class="challenge.icon + ' colored'"></i>{{ challenge.title }} <span class="tag is-light">{{ challenge.datetime }}</span></h1>
                        <p>
                            <small>
                                {{ challenge.description }}
                            </small>
                        </p>
                        <p>
                            <small v-if="challenge.xp!=0"><i class="fas fa-fist-raised colored"></i> {{ challenge.xp }} </small>
                            <small v-if="challenge.hp!=0"><i class="fas fa-heart colored"></i> {{ challenge.hp }} </small>
                            <small v-if="challenge.gold!=0"><i class="fas fa-coins colored"></i> {{ challenge.gold }} </small>
                            <small v-if="challenge.cards!=0"><i class="fas fa-club colored"></i> {{ challenge.cards }} </small>
                        </p>
                        <div v-html="challenge.content" class="el-tiptap-editor__content">
                        </div>
                        <div class="has-padding-3 has-text-right">
                            <button v-if="challenge.is_conquer" class="button is-success is-outlined" @click="showModal(challenge.id)">
                                <span class="icon is-small">
                                <i class="fas fa-edit"></i>
                                </span>
                                <span>Mark</span>
                            </button>
                            <button class="button is-dark is-outlined" @click="challengeEdit=challenge;addChallenge=true">
                                <span class="icon is-small">
                                <i class="fas fa-edit"></i>
                                </span>
                                <span>Edit</span>
                            </button>
                              <button class="button is-danger is-outlined" @click="confirmDelete(challenge.id)">
                                <span class="icon is-small">
                                <i class="fas fa-trash-alt"></i>
                                </span>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
                </section>
            </div>
        </div>
    </div>
      <b-modal :active.sync="isModalActive" width="95%" scroll="keep">
            <div class="has-padding-5 has-background-light">
                <h1 class="is-size-1">Fill with students or groups</H1>
            </div>
        </b-modal>
</div>
</template>
<script>

    export default {
            props: ['challengegroup', 'challenges', 'code', 'icon'],
            created: function() {
                
            },
            data: function() {
                return {
                    addChallenge: false,
                    search: '',
                    challengeEdit: null,
                    isModalActive: false,
                }
            },
            methods: {

                confirmDelete(id) {
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
                            axios.delete('/classroom/' + this.code + '/challenges/' + id)
                            .then(response => {
                              if(response.data === 1) {
                                this.$parent.getChallenges(this.challengegroup.id)
                              }
                          })
                        }
                    })
                },
                showModal(challenge) {
                    console.log(challenge)
                    this.isModalActive = true
                },

            },
            components: {
            },
            computed: {
                buttonAddChallege() {
                    return  this.addChallenge ? this.trans.get('general.cancel') : "<i class='far fa-plus has-padding-right-2'></i>" + this.trans.get('challenges.add')  
                },
                filteredList: function() {
                    return this.orderedChallenges.filter(challenge => {
                        return challenge.title.toLowerCase().includes(this.search.toLowerCase())
                    })
                },
                orderedChallenges: function () {
                    return _.orderBy(this.challenges, 'datetime', 'desc')
                }
            },
    }
</script>
