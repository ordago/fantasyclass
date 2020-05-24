<template>
<div class="columns">
    <div class="column is-narrow" style="min-width: 25%">
        <article class="panel is-info has-padding-bottom-4">
            <p class="panel-heading has-text-centered">
                {{ trans.get('menu.challenges') }}
            </p>
            <p class="has-padding-2 has-text-centered has-margin-2">
                    <button class="button" @click="activeAddGroup=!activeAddGroup"><i class="far fa-plus has-padding-right-2"></i> Add group</button>
            </p>

            <!-- <div class="panel-block">
                <p class="control has-icons-left">
                <input class="input is-info" type="text" placeholder="Search">
                <span class="icon is-left">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </span>
                </p>
            </div> -->
            <div class="panel-block is-flex is-flex-column" style="align-items: flex-start;" v-for="challenge in challenges" v-bind:key="challenge.id">
                <a style="panel-block">
                    <span class="panel-icon">
                    <i :class="challenge.icon" aria-hidden="true"></i>
                    </span>
                    <span :title="challenge.name">{{ challenge.name.length > 30 ? challenge.name.substring(0, 30) + "..." : challenge.name }}</span>
                </a>
                <a class="has-padding-left-4 has-padding-top-3" v-for="challengeChild in challenge.children" v-bind:key="challengeChild.id">
                    <span class="panel-icon">
                    <i :class="challengeChild.icon" aria-hidden="true"></i>
                    </span>
                    <span :title="challengeChild.name">{{ challengeChild.name.length > 30 ? challengeChild.name.substring(0, 30) + "..." : challengeChild.name }}</span>
                </a>
            </div>
        </article>
    </div>
    <div class="column">
        <create-challenge :code="code" v-if="activeAddGroup"></create-challenge>
    </div>
</div>
</template>
<script>

import createChallenge from './CreateChallenge.vue';

    export default {
            props: ['code', 'challenges'],
            mounted: function() {
               
            },
            data: function() {
                return {
                   activeAddGroup: false,
                }
            },
            methods: {
                refresh: function(elem){
                    if(elem.challenge_id) {
                        let challenge = this.challenges.filter(
                            function(data){ return data.id == elem.challenge_id }
                        );
                        challenge[0].children.push(elem)
                    } else this.challenges.push(elem)
                    this.$forceUpdate()
                }
            },
            components: {
                createChallenge,
            }
    }
</script>
