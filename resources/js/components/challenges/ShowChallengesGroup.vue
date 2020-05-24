<template>
<div class="columns">
    <div class="column is-narrow" style="min-width: 400px">
        <article class="panel is-info has-padding-bottom-4">
        <p class="panel-heading is-flex has-space-between align-items-center has-padding-3">
                <span>{{ trans.get('menu.challenges') }}</span>
                <button class="button" @click="activeAddGroup=!activeAddGroup" v-html="buttonAddGroup"></button>
            </p>
            
            <div class="panel-block has-padding-y-4 is-flex is-flex-column" style="align-items: flex-start;" v-for="challenge in challenges" v-bind:key="challenge.id">
                <div class="w-100 is-fullwidth cursor-pointer is-flex has-space-between"  @click="activeGroup=challenge">
                    <span>
                        <span class="panel-icon">
                        <i :class="challenge.icon" aria-hidden="true"></i>
                        </span>
                        <span :title="challenge.name">{{ challenge.name.length > 30 ? challenge.name.substring(0, 30) + "..." : challenge.name }}</span>
                    </span>
                    <span><i class="fal fa-angle-right"></i></span>
                </div>
                <div @click="activeGroup=challengeChild" class="is-flex has-space-between w-100 is-fullwidth cursor-pointer has-padding-left-4 has-padding-top-4" v-for="challengeChild in challenge.children" v-bind:key="challengeChild.id">
                    <span>
                        <span class="panel-icon">
                        <i :class="challengeChild.icon" aria-hidden="true"></i>
                        </span>
                        <span :title="challengeChild.name">{{ challengeChild.name.length > 30 ? challengeChild.name.substring(0, 30) + "..." : challengeChild.name }}</span>
                    </span>
                    <span><i class="fal fa-angle-right"></i></span>
                </div>
            </div>
        </article>
    </div>
    <div class="column has-padding-left-0-desktop">
        <create-challenge-group :code="code" v-if="activeAddGroup"></create-challenge-group>
        <show-challenges :challengeGroup="activeGroup" v-if="activeGroup"></show-challenges>
    </div>
</div>
</template>
<script>

import createChallengeGroup from './CreateChallengeGroup.vue';
import showChallenges from './ShowChallenges.vue';

    export default {
            props: ['code', 'challenges'],
            mounted: function() {
               
            },
            data: function() {
                return {
                   activeAddGroup: false,
                   activeGroup: false,
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
                createChallengeGroup,
                showChallenges,
            },
            computed: {
                buttonAddGroup() {
                    return  this.activeAddGroup ? this.trans.get('general.cancel') : "<i class='far fa-plus has-padding-right-2'></i>" + this.trans.get('challenges.add_group')  
                },
            }
    }
</script>
