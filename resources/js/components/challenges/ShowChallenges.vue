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
           <create-challenges :code="code" :challengegroup="challengegroup.id"></create-challenges>
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
                        <p>
                            <strong>{{ challenge.title }}</strong> <span class="tag is-light">{{ challenge.datetime }}</span>
                        </p>
                        <div v-html="challenge.content">
                        </div>
                    </div>
                    <nav class="level is-mobile">
                        <div class="level-left">
                        <a class="level-item" aria-label="reply">
                            <span class="icon is-small">
                            <i class="fas fa-reply" aria-hidden="true"></i>
                            </span>
                        </a>
                        <a class="level-item" aria-label="retweet">
                            <span class="icon is-small">
                            <i class="fas fa-retweet" aria-hidden="true"></i>
                            </span>
                        </a>
                        <a class="level-item" aria-label="like">
                            <span class="icon is-small">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                            </span>
                        </a>
                        </div>
                    </nav>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</template>
<script>

    export default {
            props: ['challengegroup', 'challenges', 'code'],
            created: function() {
                
            },
            data: function() {
                return {
                    addChallenge: false,
                    search: '',
                }
            },
            methods: {
                
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
