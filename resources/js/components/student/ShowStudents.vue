<template>
<div>
    <div class="utilities rounded card-shadow-s" id="utilities">
        <div class="tools rounded-left">
            <i class="fal fa-tools"></i>
        </div>
        <span class="link outer_glow" data-action='randomEvent'><i class="fad fa-scroll-old outer_glow" style="font-size:2em;"></i></span>
        <!--<span class="link outer_glow"><i class="fad fa-chart-pie" style="font-size:2em;"></i></span>
        <span class="link outer_glow"><a style="font-size: 2em;" href="utils/attendance.php"><i class="fad fa-calendar-check"></i></a></span>
        <span class="link outer_glow"><i class="fad fa-poll-people" style="font-size: 2em;"></i></span>
        <span class="link outer_glow" ><i class="fad fa-microphone outer_glow" style="font-size:2em;"></i></span>
        <span class="link outer_glow"><i class="fad fa-dice" style="font-size:2em;" onclick="rollTheDice()"></i></span>
        <span class="link outer_glow" data-action='randomStudent'><i class="fad fa-user outer_glow" style="font-size:2em;" ></i></span>
        <span class="link outer_glow" data-action='randomGroup'><i class="fad fa-users outer_glow" style="font-size:2em;"></i></span>
        <span class="link outer_glow" data-action='showClassCode'><i class="fad fa-qrcode outer_glow" style="font-size:2em;"></i></span>
        <span class="link outer_glow" data-action='music'><i class="fad fa-music outer_glow" style="font-size:2em;"></i></span>
        <a href="random.php?class=" target="_blank"><i class="fad fa-random outer_glow" style="font-size:2em;"></i></a>
        <a href="utils/questions.php" class="link outer_glow"><i class="fad fa-question-square" style="font-size:2em;"></i></a>
        -->
        <div class="flex-center float-right" v-if="students.length>0">
            <!-- <span class="mr-1 hideGrid pointer" v-tippy :content="trans.get('users_groups.change_layout')" @click="changeView"><i class="fas fa-th fs-1 colored" style="color:white"></i></span> -->
            <span><i class="fal fa-sort-numeric-down-alt has-margin-right-3"></i></span>
            <span v-tippy :content="trans.get('users_groups.order_name')" v-bind:class="{ coloredGray: sortKey != 'name' }" @click="orderBy('name');" style="color: #eee;"  data-id="0" class="colored"><i class="fas fa-user pointer has-margin-right-3" ></i></span>
            <span v-tippy :content="trans.get('users_groups.order_hp')" v-bind:class="{ coloredGray: sortKey != 'hp' }" @click="orderBy('hp');" class="colored"><i class="fas fa-heart pointer has-margin-right-3" ></i></span>
            <span v-tippy :content="trans.get('users_groups.order_xp')" v-bind:class="{ coloredGray: sortKey != 'xp' }" @click="orderBy('xp');" class="colored"><i class="fas fa-fist-raised pointer has-margin-right-3" ></i></span>
            <span v-tippy :content="trans.get('users_groups.order_gold')" v-bind:class="{ coloredGray: sortKey != 'gold' }" @click="orderBy('gold');" class="colored"><i class="fas fa-coins pointer has-margin-right-3" ></i></span>
            <!-- <input type="checkbox" id="toggleStdView" class="cbx" style="display:none"/>
            <label  style="width: 40px" for="toggleStdView" class="toggle"><span></span></label>
            <span><i class="fas fa-user ml-2 outer_glow"></i></span> -->
        </div>
    </div>
    <div class="columns is-multiline is-variable is-1 has-margin-y-2">
        <div class="column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd " v-for="student in orderedStudents" v-bind:key="student.id">
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
                    <div class="media-content cursor-pointer" @click="redirect(student.id)">
                        <p class="title is-4">{{ student.name }}</p>
                        <!-- <p class="subtitle is-6"><small>0 <i class="fas fa-heart"></i></small> <small>0 <i class="fas fa-fist-raised"></i></small> <small>0 <i class="fas fa-coins   "></i></small></p> -->
                        <p class="subtitle is-6"><small>@{{ student.username }}</small></p>
                    </div>
                    </div>

                    <div class="content">
                       <div>
                        <div class="centered-attribute has-padding-2 has-margin-top-4 has-margin-bottom-3">
                            <span class="attribute has-background-white-ter	 has-padding-y-2 rounded" style="width:100%;"><span><i class="fas fa-heart has-text-grey-light"></i></span> <span class="has-text-grey-light" v-if="student.hp<20">{{ student.hp }}</span></span>
                            <span class="attribute has-background-danger has-padding-y-2 rounded-left" v-bind:class="{ rounded: student.hp==100 }" :style="'width: ' + student.hp + '%'" v-if="student.hp>0"><i class="fas fa-heart" v-bind:class="{ 'has-text-danger': student.hp<52 }"></i> <span v-if="student.hp>=20">{{ student.hp }}</span></span>
                        </div>
                        <div class="my-1 has-text-centered">
                            <div class="w-100 is-flex is-all-centered">
                                <button v-for="behaviour in mainBehavioursJson" v-tippy :content="behaviour.name + ' <small>(<i class=\'fas fa-heart colored\'></i> ' + behaviour.hp + ' <i class=\'fas fa-fist-raised colored\'></i> '+ behaviour.xp +' <i class=\'fas fa-coins colored\'></i> '+ behaviour.gold +')</small>'"
                                    class="button has-margin-1 has-padding-x-4 is-light" @click="addBehaviour(student.id, behaviour.id)" v-bind:class="[ behaviour.xp + behaviour.hp + behaviour.gold >= 0 ? 'is-success' : 'is-danger']"  v-bind:key="behaviour.id">
                                        <i :class="behaviour.icon"></i>
                                </button>
                                <div class="button is-link is-light has-margin-1 has-padding-x-4" @click="show2l=!show2l" v-if="otherBehavioursJson.length"><i class="fas fa-plus"></i></div>
                                <a :href="'/classroom/' + classroom.code + '/behaviours/create'" class="button is-link is-light has-margin-1 has-padding-x-4" v-tippy :content="trans.get('users_groups.add_behaviours')" v-if="mainBehavioursJson.length == 0"><i class="fas fa-plus"></i></a>
                            </div>
                            <div v-if="show2l">
                                <button v-for="behaviour in otherBehavioursJson" v-tippy :content="behaviour.name + ' <small>(<i class=\'fas fa-heart colored\'></i> ' + behaviour.hp + ' <i class=\'fas fa-fist-raised colored\'></i> '+ behaviour.xp +' <i class=\'fas fa-coins colored\'></i> '+ behaviour.gold +')</small>'" 
                                    class="button has-margin-1 is-light has-padding-x-4" v-bind:class="[ behaviour.xp + behaviour.hp + behaviour.gold >= 0 ? 'is-success' : 'is-danger']" v-bind:key="behaviour.id">
                                    <i :class="behaviour.icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="score has-padding-3 has-margin-1">
                            <span>
                                <i class="fas fa-fist-raised colored"></i>
                            </span> {{ student.xp }}
                        </div>
                        <div class="has-margin-y-2 has-text-centered">
                            <button type="submit" @click="updateProp(student.id, 'xp', 100)" class="button is-dark has-padding-x-3">100</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', 50)" class="button is-dark has-padding-x-3">50</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', 10)" class="button is-dark has-padding-x-3">10</button>                            
                            <tippy 
                                interactive 
                                :animate-fill="false" 
                                theme="light"
                                placement="bottom" 
                                animation="fade" 
                                trigger="click" 
                                style="display:inline-block"
                                arrow>
                            <template v-slot:trigger>
                                <button type="submit" class="button is-primary has-padding-x-3"><i class="fas fa-hashtag"></i></button>
                            </template>
                            <span>
                                <div class="is-flex">
                                    <input type="number" v-model="custom" class="input has-margin-right-1">
                                    <button @click="updateProp(student.id, 'xp', custom)" class="button is-primary is-inline">{{trans.get('users_groups.apply')}}</button>
                                </div>
                            </span>
                            </tippy>
                            <button type="submit" @click="updateProp(student.id, 'xp', -10)" class="button is-dark is-outlined has-padding-x-2">-10</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', -50)" class="button is-dark is-outlined has-padding-x-2">-50</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', -100)" class="button is-dark is-outlined has-padding-x-2">-100</button>
                        </div>
                        <div class="gold has-padding-3 has-margin-y-1">
                            <i class="fas fa-coins colored"></i> {{ student.gold }}
                        </div>
                        <div class="has-margin-y-2 has-text-centered">
                            <div class="">
                                <button type="submit" @click="updateProp(student.id, 'gold', 100)" class="button is-warning has-padding-x-3">100</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', 50)" class="button is-warning has-padding-x-3">50</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', 10)" class="button is-warning has-padding-x-3">10</button>
                                <tippy 
                                    interactive 
                                    :animate-fill="false" 
                                    theme="light"
                                    placement="bottom" 
                                    animation="fade" 
                                    trigger="click" 
                                    style="display:inline-block"
                                    arrow>
                                <template v-slot:trigger>
                                    <button type="submit" class="button is-primary has-padding-x-3"><i class="fas fa-hashtag"></i></button>
                                </template>

                                <span>
                                    <div class="is-flex">
                                        <input type="number" v-model="custom" class="input has-margin-right-1">
                                        <button @click="updateProp(student.id, 'gold', custom)" class="button is-primary col-4 pl-1">{{trans.get('users_groups.apply')}}</button>
                                    </div>
                                </span>
                                </tippy>
                                <button type="submit" @click="updateProp(student.id, 'gold', -10)" class="button is-dark is-outlined has-padding-x-2">-10</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', -50)" class="button is-dark is-outlined has-padding-x-2">-50</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', -100)" class="button is-dark is-outlined has-padding-x-2">-100</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column is-12-mobile is-4-tablet is-3-desktop">
            <div class="box card-shadow-s is-flex is-all-centered">
                <a :href="'/classroom/' + classroom.code + '/students/add'">Add students (afegir imatge)</a>
            </div>
            </div>
    </div>
</div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['students', 'classroom'],
        mounted() {
            this.mainBehavioursJson = this.classroom.behaviours.slice(0, this.numItems)
            this.otherBehavioursJson = this.classroom.behaviours.slice(this.numItems)
            this.sortKey = $cookies.get('order') ?? 'name'
            this.viewGrid = $cookies.get('viewGrid') ?? 0
        },
        data: function() {
            return {
                    mainBehavioursJson: [],
                    otherBehavioursJson: [],
                    sortKey: '',
                    viewGrid: '',
                    buttons: '',
                    custom: 0,
                    numItems: 5,
                    show2l: false,

            }
        },
        methods: {
              orderBy: function(sorKey) {
                    this.$cookies.set('order', sorKey , Infinity)
                    this.sortKey = sorKey
                },
                updateSlice() {
                    this.numItems--
                    this.mainBehavioursJson = JSON.parse(this.behaviours).slice(0, this.numItems)
                    this.otherBehavioursJson = JSON.parse(this.behaviours).slice(this.numItems)
                },
                changeView: function() {
                    this.viewGrid = (this.viewGrid + 1) % 3
                    this.$cookies.set('viewGrid', this.viewGrid , Infinity)
                },
                updateProp: function(id, prop, value) {
                    let options = {'id': id, 'prop': prop, 'value': value}
                    axios.post('/classroom/students/update', options)
                        .then(response => {
                            if(prop == 'xp') {
                                let student = this.students.find(el => el.id === id);
                                student.xp = response.data.xp
                                student.level = response.data.level
                            }
                            else if(prop == 'gold')
                                this.students.find(el => el.id === id).gold = response.data
                            this.custom = 0
                            this.$forceUpdate()
                            })
                },
                addBehaviour: function(id, behaviour) {
                    let options = {'id': id, 'behaviour': behaviour}
                    axios.post('/classroom/students/behaviour', options)
                        .then(response => {              
                                let student = this.students.find(el => el.id === id)
                                student.hp = response.data.hp
                                student.xp = response.data.xp.xp
                                student.gold = response.data.gold
                                student.level = response.data.xp.level
                                this.$forceUpdate()
                        })
                },
                redirect(id) {
                    window.location.href = '/classroom/' + this.classroom.code + '/student/' + id
                }
            },
            computed: {
                orderedStudents: function () {
                    let order = 'desc'
                    if(this.sortKey == 'name')
                        order = 'asc'
                    return _.orderBy(this.students, this.sortKey, order)
                }
}     
        }
</script>
