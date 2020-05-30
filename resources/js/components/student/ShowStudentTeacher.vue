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

            <b-tab-item label="Behaviours" v-if="student.behaviours.length">
                <!-- <div v-for="behaviour in student.behaviours" v-bind:key="behaviour.id">

                </div> -->
                <apexchart width="300" type="donut" :options="{
                    labels: labels,  colors: colors
                    }" :series="series">
                </apexchart>

                <div class="columns">
                    <div class="column">
                        <i class="fal fa-calendar-day"></i> <input type="date" class="input is-rounded " v-model="dateStart">
                    </div>
                    <div class="column">
                        <i class="fal fa-calendar-day"></i> <input type="date" class="input is-rounded " v-model="dateEnd">
                    </div>
                </div>
            <b-table v-if="student.behaviours.length"
                :data="filteredEntries"
                default-sort="created_at"
                default-sort-direction="desc"
                icon-pack="fas"
                sort-icon="arrow-up"
                >

            <template slot-scope="props">

                <b-table-column field="icon" label="Icon" centered>
                    <span class="tag" v-bind:class="[ props.row.xp + props.row.hp + props.row.gold >= 0 ? 'is-success' : 'is-danger']">
                      <i :class="props.row.icon"></i>
                    </span>
                </b-table-column>

                <b-table-column field="name" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>
                
                <b-table-column field="created_at" label="Created at" sortable>
                    {{ new Date(props.row.pivot.created_at).toLocaleDateString() }}
                </b-table-column>

                <b-table-column field="hp" label="Health Points" sortable centered>
                    <i class="fas fa-heart"></i>
                    {{ props.row.hp }}
                </b-table-column>

                <b-table-column field="name" label="Experience" sortable centered>
                    <i class="fas fa-fist-raised"></i>
                    {{ props.row.xp }}
                </b-table-column>

                <b-table-column field="name" label="Gold" sortable centered>
                    <i class="fas fa-coins"></i>
                    {{ props.row.gold }}
                </b-table-column>

                <b-table-column field="name" label="Settings" centered>
                        <b-button type="is-danger is-small" @click="confirmDelete(props.row.id)"><i class="fas fa-trash-alt"></i></b-button>
                </b-table-column>
                
            </template>
        </b-table>
            </b-tab-item>


            <b-tab-item label="Challenges">
               
            </b-tab-item>
            
            <b-tab-item label="Inventory">
               
            </b-tab-item>

            <b-tab-item label="Log" v-if="student.log_entries.length">
                <!-- <div v-for="behaviour in student.behaviours" v-bind:key="behaviour.id">

                </div> -->
                <div class="columns">
                    <div class="column">
                        <i class="fal fa-calendar-day"></i> <input type="date" class="input is-rounded " v-model="dateStart">
                    </div>
                    <div class="column">
                        <i class="fal fa-calendar-day"></i> <input type="date" class="input is-rounded " v-model="dateEnd">
                    </div>
                </div>
                <b-table v-if="student.log_entries.length"
                :data="filteredLogEntries"
                    default-sort="created_at"
                    default-sort-direction="desc"
                    icon-pack="fas"
                    sort-icon="arrow-up"
                    >

                <template slot-scope="props">

                    <b-table-column field="type" label="Type" centered>
                        <span class="tag" v-bind:class="[ props.row.value >= 0 ? 'is-success' : 'is-danger']">

                        <span v-if="props.row.type=='xp'">
                            ✊
                        </span>
                        <span v-if="props.row.type=='gold'">
                            💰
                        </span>
                        <span v-if="props.row.type=='heart'">
                            ❤️
                        </span>
                        </span>
                    </b-table-column>

                    <b-table-column field="value" label="value" sortable>
                        {{ props.row.value }}
                    </b-table-column>
                    
                    <b-table-column field="created_at" label="Created at" sortable>
                        {{ new Date(props.row.created_at).toLocaleDateString() }}
                    </b-table-column>

                    <b-table-column field="name" label="Settings" centered>
                            <b-button type="is-danger is-small" @click="confirmDelete(props.row.id)"><i class="fas fa-trash-alt"></i></b-button>
                    </b-table-column>
                    
                </template>
            </b-table>
            </b-tab-item> 

        </b-tabs>
    </div>
</div>
</template>

<script>
  import Utils from "../../utils.js";

  export default {
        props: ['student', 'classroom', 'chart'],
        mounted() {
            let colorsOK = ['#c8e6c9', '#a5d6a7', '#81c784', '#66bb6a', '#4caf50', '#43a047', '#388e3c', '#2e7d32', '#1b5e20', '#003300', '#002200', '#001100', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000'];
            let colorsKO = ['#ffccbc', '#ffab91', '#ff8a65', '#ff7043', '#ff5722', '#f4511e', '#e64a19', '#d84315', '#bf360c', '#570000', '#370000', '#170000', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000'];
            
            this.chart.forEach(element => {
                this.series.push(element.count)
                this.labels.push("" + element.name)
                if(element.total >=0){
                    this.colors.push(colorsOK[0])
                    colorsOK.shift()
                } else {
                    this.colors.push(colorsKO[0])
                    colorsKO.shift()
                }
            });
           
        },
        data: function() {
            return {
                activeTab: 0,
                dateStart: null,
                dateEnd: null,
                series: [],
                labels: [],
                colors: [],
            }
        },
        methods: {
             
            },
        computed: {
            filteredEntries(){
                this.series = []
                return this.student.behaviours.filter(entry => {
                    if((entry.pivot.created_at >= this.dateStart || !this.dateStart) && (entry.pivot.created_at <= this.dateEnd || !this.dateEnd)) {
                        // this.series.push(entry.name)
                        // this.series.push(entry.name)
                        return true 
                    }
                    return false
                });
            },
            filteredLogEntries(){
                return this.student.log_entries.filter(entry => {
                    return (entry.created_at >= this.dateStart || !this.dateStart) && (entry.created_at <= this.dateEnd || !this.dateEnd) 
                });
            }
        }
  }
</script>
