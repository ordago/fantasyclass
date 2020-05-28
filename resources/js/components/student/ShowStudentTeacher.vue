<template>
<div class="columns">
    <div class="column is-narrow">
         <div class="card rounded card-shadow-s">
                <span class="level-top rounded has-padding-4 has-background-light" v-if="student.level">
                    {{ student.level.number }}
                </span>

                <div class="card-image card-shadow-s rounded-top char-bg" :style="'background-color:' + classroom.theme.color + ';background-image: url(/img/bg/thumb_' + classroom.theme.name + ');'">
                    <div class="character-container character character-small is-relative">
                        <img :src="'/img/character/' + element.src" :class="element.classes" v-for="element in student.equipment" v-bind:key="element.id">
                    </div>  
                </div>
                <div class="card-content">
                    <div class="media has-margin-bottom-0">
                    <div class="media-left">
                        <figure class="image is-48x48">
                            <img src="/img/no_avatar.png" class="rounded" alt="">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4">{{ student.name }}</p>
                        <!-- <p class="subtitle is-6"><small>0 <i class="fas fa-heart"></i></small> <small>0 <i class="fas fa-fist-raised"></i></small> <small>0 <i class="fas fa-coins   "></i></small></p> -->
                        <p class="subtitle is-6"><small>@{{ student.username }}</small></p>
                    </div>
                    </div>
                    <div class="score has-padding-3 has-margin-1 has-margin-top-3 has-background-danger">
                            <span>
                                <i class="fas fa-heart colored"></i>
                            </span> {{ student.hp }}
                    </div>
                    <div class="score has-padding-3 has-margin-1">
                            <span>
                                <i class="fas fa-fist-raised colored"></i>
                            </span> {{ student.xp }}
                    </div>
                    <div class="gold has-padding-3 has-margin-1">
                            <span>
                                <i class="fas fa-coins colored"></i>
                            </span> {{ student.gold }}
                    </div>

                </div>
        </div>
    </div>
    <div class="column">
            <b-tabs v-model="activeTab">
            <b-tab-item label="Information">
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                        <p class="control">
                            <input class="input" type="text" v-model="student.name">
                        </p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Username</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                        <p class="control">
                            <input class="input is-static" disabled type="text"  v-model="student.username">
                        </p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Password</label>
                    </div>
                    <div class="field-body">
                        <b-field class="is-static">
                        <b-input type="password"
                            placeholder=""
                            icon-pack="fas"
                            disabled=""
                            v-model="student.password_plain"
                            password-reveal>
                        </b-input>
                    </b-field>
                    </div>
                </div>


               
            </b-tab-item>

            <b-tab-item label="Behaviours">
               
            </b-tab-item>

            <b-tab-item label="Challenges">
               
            </b-tab-item>
            
            <b-tab-item label="Log">
               
            </b-tab-item>

        </b-tabs>
    </div>
</div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['student', 'classroom'],
        mounted() {
           
        },
        data: function() {
            return {
                activeTab: 0,
            }
        },
        methods: {
             
            },
            computed: {
            
            }
        }
</script>
