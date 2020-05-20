<template>
<div>
    <div class="utilities rounded cardShadowS" id="utilities">
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
        <div class="flex-center floatR" v-if="studentsJson.length>0">
            <span class="mr-1 hideGrid pointer" v-tippy :content="trans.get('users_groups.change_layout')" @click="changeView"><i class="fas fa-th fs-1 colored" style="color:white"></i></span>
            <span><i class="fal fa-sort-numeric-down-alt mr-2"></i></span>
            <span ><i class="fas fa-user colored pointer mr-2" v-tippy :content="trans.get('users_groups.order_name')" v-bind:class="{ coloredGray: sortKey != 'name' }" @click="orderBy('name');" style="color: #eee;"  data-id="0"></i></span>
            <span ><i class="fas fa-heart colored pointer mr-2" v-tippy :content="trans.get('users_groups.order_hp')" v-bind:class="{ coloredGray: sortKey != 'hp' }" @click="orderBy('hp');"></i></span>
            <span ><i class="fas fa-fist-raised colored pointer mr-2" v-tippy :content="trans.get('users_groups.order_xp')" v-bind:class="{ coloredGray: sortKey != 'xp' }" @click="orderBy('xp');"></i></span>
            <span ><i class="fas fa-coins colored pointer mr-2" v-tippy :content="trans.get('users_groups.order_gold')" v-bind:class="{ coloredGray: sortKey != 'gold' }" @click="orderBy('gold');"></i></span>
            <input type="checkbox" id="toggleStdView" class="cbx" style="display:none"/>
            <label  style="width: 40px" for="toggleStdView" class="toggle"><span></span></label>
            <span><i class="fas fa-user ml-2 outer_glow"></i></span>
        </div>
    </div>
        <div class="grid has-margin-y-3" v-bind:class="[ this.viewGrid == 0 ? 'grid4g' : '', this.viewGrid == 1 ? 'grid3g' : '', this.viewGrid == 2 ? 'grid2g' : '']">
        <div v-for="student in orderedStudents" v-bind:key="student.id">
            <div class="box">
                <div class="card-header has-text-centered">
                    <div class="card-header-title">
                        <img src="/img/no_avatar.png" class="rounded" width="20%">
                        <h3 class="has-margin-2 has-margin-bottom-0">{{ student.name }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="centered-attribute has-padding-2 has-margin-top-4 has-margin-bottom-3">
                            <span class="attribute has-padding-y-2 bg-light rounded" style="width:100%;">10</span>
                            <span class="attribute bg-light has-padding-y-2 rounded" style="width:100%;"><span> </span><span v-if="student.hp<20">{{ student.hp }}</span></span>
                            <span class="attribute has-background-danger has-padding-y-2 rounded-left" v-bind:class="{ rounded: student.hp==100 }" :style="'width: ' + student.hp + '%'" v-if="student.hp>0"><i class="fas fa-heart"></i> <span v-if="student.hp>=20">{{ student.hp }}</span></span>
                        </div>
                        <div class="my-1 has-text-centered">
                            <button v-for="behaviour in mainBehavioursJson" v-tippy :content="behaviour.name + ' <small>(<i class=\'fas fa-heart colored\'></i> ' + behaviour.hp + ' <i class=\'fas fa-fist-raised colored\'></i> '+ behaviour.xp +' <i class=\'fas fa-coins colored\'></i> '+ behaviour.gold +')</small>'"
                                 class="button has-margin-1 is-light" v-bind:class="[ behaviour.xp + behaviour.hp + behaviour.gold >= 0 ? 'is-success' : 'is-danger']"  v-bind:key="behaviour.id">
                                    <i :class="behaviour.icon"></i>
                            </button>
                            <div class="button is-link is-light has-margin-1" @click="show2l=!show2l"><i class="fas fa-plus"></i></div>
                            <div v-if="show2l">
                                <button v-for="behaviour in otherBehavioursJson" v-tippy :content="behaviour.name + ' <small>(<i class=\'fas fa-heart colored\'></i> ' + behaviour.hp + ' <i class=\'fas fa-fist-raised colored\'></i> '+ behaviour.xp +' <i class=\'fas fa-coins colored\'></i> '+ behaviour.gold +')</small>'" 
                                    class="button has-margin-1 is-light" v-bind:class="[ behaviour.xp + behaviour.hp + behaviour.gold >= 0 ? 'is-success' : 'is-danger']" v-bind:key="behaviour.id">
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
                            <button type="submit" @click="updateProp(student.id, 'xp', 100)" class="button is-dark has-padding-x-2">+100</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', 50)" class="button is-dark has-padding-x-2">+50</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', 10)" class="button is-dark has-padding-x-2">+10</button>                            
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
                                <button type="submit" @click="updateProp(student.id, 'gold', 100)" class="button is-warning has-padding-x-2">+100</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', 50)" class="button is-warning has-padding-x-2">+50</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', 10)" class="button is-warning has-padding-x-2">+10</button>
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
        <div class="box is-flex is-all-centered">
            <div class="p-4">
                <a :href="'/classroom/' + code + '/students/add'">Add students (afegir imatge)</a>
            </div>
            </div>
        </div>
</div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['students', 'code', 'behaviours'],
        mounted() {
            this.studentsJson = JSON.parse(this.students)
            this.mainBehavioursJson = JSON.parse(this.behaviours).slice(0, this.numItems)
            this.otherBehavioursJson = JSON.parse(this.behaviours).slice(this.numItems)
            this.sortKey = $cookies.get('order') ?? 'name'
            this.viewGrid = $cookies.get('viewGrid') ?? 0
        },
        data: function() {
            return {
                    studentsJson: [],
                    behavioursJson: [],
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
                            if(prop == 'xp')
                                this.studentsJson.find(el => el.id === id).xp = response.data
                            else if(prop == 'gold')
                                this.studentsJson.find(el => el.id === id).gold = response.data
                            this.custom = 0
                        })
                }
            },
            computed: {
                orderedStudents: function () {
                    let order = 'desc'
                    if(this.sortKey == 'name')
                        order = 'asc'
                    return _.orderBy(this.studentsJson, this.sortKey, order)
                }
}     
        }
</script>
