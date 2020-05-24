<template>
<div class="has-padding-left-0-desktop">
    <div class="panel has-padding-left-0-desktop">
        <p class="panel-heading is-flex has-space-between align-items-center has-padding-3">
                <span class="has-padding-left-3"> {{ challengeGroup.name }}</span>
                <button class="button" @click="addChallenge=!addChallenge" v-html="buttonAddChallege"></button>
        </p>
        <div class="panel-block" v-if="challenges.length > 0">
            <p class="control has-icons-left">
            <input class="input" type="text" placeholder="Search"  disabled>
            <span class="icon is-left">
                <i class="fas fa-search" aria-hidden="true"></i>
            </span>
            </p>
        </div>
        <div class="panel-block" v-if="addChallenge">
            Add challenge
        </div>
        <div class="panel-block" v-if="challenges.length == 0 && !addChallenge">
            <h3 class="is-size-3 has-padding-4 w-100 has-text-centered">
                <i class="fal fa-smile-wink"></i> {{ trans.get('challenges.empty') }}
            </h3>
        </div>
        <div class="panel-block" v-if="challenges.length > 0 && !addChallenge">
            
        </div>
    </div>
</div>
</template>
<script>

    export default {
            props: ['challengeGroup'],
            mounted: function() {
               
            },
            data: function() {
                return {
                    challenges: [],
                    addChallenge: false,
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
            },
    }
</script>
