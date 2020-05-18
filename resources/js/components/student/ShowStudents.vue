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
        <div class="flexCenter floatR" v-if="studentsJson.length>0">
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
        <div class="grid  my-2" v-bind:class="[ this.viewGrid == 0 ? 'grid4g' : '', this.viewGrid == 1 ? 'grid3g' : '', this.viewGrid == 2 ? 'grid2g' : '']">
        <div v-for="student in orderedStudents" v-bind:key="student.id">
            <div class="rounded card">
                <div class="card-header text-center">
                    <img src="/img/no_avatar.png" class="rounded" width="20%">
                    <h3 class="mt-2 mb-0">{{ student.name }}</h3>
                </div>
                <div class="card-body p-2">
                    <div>
                        <div class="centeredAttribute p-2 my-3">
                            <span class="attribute py-2 bg-light rounded" style="width:100%;">10</span>
                            <span class="attribute bg-light py-2 rounded" style="width:100%;"><span> </span><span v-if="student.hp<20">{{ student.hp }}</span></span>
                            <span class="attribute bg-danger py-2 rounded-left" v-bind:class="{ rounded: student.hp==100 }" :style="'width: ' + student.hp + '%'" v-if="student.hp>0"><i class="fas fa-heart"></i> <span v-if="student.hp>=20">{{ student.hp }}</span></span>
                        </div>
                        <div class="score p-2 mt-1">
                            <span>
                                <i class="fas fa-fist-raised colored"></i>
                            </span> {{ student.xp }}
                        </div>
                        <div class="changeScore my-2">
                            <button type="submit" @click="updateProp(student.id, 'xp', 100)" class="btn btn-secondary px-2">+100</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', 50)" class="btn btn-secondary px-2">+50</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', 10)" class="btn btn-secondary px-2">+10</button>                            
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
                                <button type="submit" class="btn btn-primary"><i class="fas fa-hashtag"></i></button>
                            </template>
                            <span>
                                <div class="row px-3">
                                    <input type="number" v-model="custom" class="form-control col-8">
                                    <button @click="updateProp(student.id, 'xp', custom)" class="btn btn-primary col-4 pl-1">{{trans.get('users_groups.apply')}}</button>
                                </div>
                            </span>
                            </tippy>
                            <button type="submit" @click="updateProp(student.id, 'xp', -10)" class="btn btn-outline-secondary px-2">-10</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', -50)" class="btn btn-outline-secondary px-2">-50</button>
                            <button type="submit" @click="updateProp(student.id, 'xp', -100)" class="btn btn-outline-secondary px-2">-100</button>
                        </div>
                        <div class="gold p-2 my-1">
                            <i class="fas fa-coins colored"></i> {{ student.gold }}
                        </div>
                        <div class="changeGold my-2">
                            <div class="changeGold">
                                <button type="submit" @click="updateProp(student.id, 'gold', 100)" class="btn btn-warning px-2">+100</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', 50)" class="btn btn-warning px-2">+50</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', 10)" class="btn btn-warning px-2">+10</button>
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
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-hashtag"></i></button>
                                </template>

                                <span>
                                    <div class="row px-3">
                                        <input type="number" v-model="custom" class="form-control col-8">
                                        <button @click="updateProp(student.id, 'gold', custom)" class="btn btn-primary col-4 pl-1">{{trans.get('users_groups.apply')}}</button>
                                    </div>
                                </span>
                                </tippy>
                                <button type="submit" @click="updateProp(student.id, 'gold', -10)" class="btn btn-outline-secondary px-2">-10</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', -50)" class="btn btn-outline-secondary px-2">-50</button>
                                <button type="submit" @click="updateProp(student.id, 'gold', -100)" class="btn btn-outline-secondary px-2">-100</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded card h-100 d-flex align-items-center text-center">
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
        props: ['students', 'code'],
        mounted() {
            this.studentsJson = JSON.parse(this.students)
            this.sortKey = $cookies.get('order') ?? 'name'
            this.viewGrid = $cookies.get('viewGrid') ?? 0
        },
        data: function() {
            return {
                    studentsJson: [
                 
                    ],
                    sortKey: '',
                    viewGrid: '',
                    custom: 0,
            }
        },
        methods: {
              orderBy: function(sorKey) {
                    this.$cookies.set('order', sorKey , Infinity)
                    this.sortKey = sorKey
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
