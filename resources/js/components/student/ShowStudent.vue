<template>
<div class="columns h-100 has-padding-right-0 has-margin-right-0" v-bind:class="{ 'has-bg-student': !admin }">
    <div class="column is-narrow">
         <div class="card rounded card-shadow-s" style="min-width: 275px">
                <span class="level-top rounded has-padding-4 has-background-light" v-if="student.level">
                    {{ student.level.number }}
                </span>
                <div class="card-image card-shadow-s rounded-top char-bg" :style="'background-color:' + classroom.theme.color + ';background-image: url(/img/bg/thumb_' + classroom.theme.name + ');'">
                    <div class="character-container character character-small is-relative">
                        <img :src="'/img/character/' + element.src" :class="element.classes" v-for="element in student.equipment" v-bind:key="element.id">
                    </div>  
                </div>
                <div class="card-content">
                    <div class="media has-margin-bottom-0 is-all-centered">
                    <div class="media-left">
                        <figure class="image is-48x48">
                            <img src="/img/no_avatar.png" class="rounded" alt="">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4">{{ student.name }}</p>
                        <p class="subtitle is-6"><small>@{{ student.username }}</small></p>
                    </div>
                    </div>
                
                    <div class="score has-padding-3 centered-attribute has-margin-1 has-margin-y-4 is-all-centered" style="border: none">
                            <span class="attribute has-background-white-ter	 has-padding-y-3 rounded" style="width:100%;"><span><i class="fas fa-heart colored has-text-grey-light" v-bind:class="{ invisible: student.hp>=30 }"></i></span> <span class="has-text-grey-light" v-show="student.hp<30">{{ student.hp }}</span></span>
                            <span class="attribute has-background-danger has-padding-y-3 rounded-left" v-bind:class="{ rounded: student.hp==100 }" :style="'width: ' + student.hp + '%'" v-if="student.hp>0"><i class="fas fa-heart colored" v-bind:class="{ invisible: student.hp<30 }"></i> <span v-if="student.hp>=30">{{ student.hp }}</span></span>
                        </div>
                    <div class="score has-padding-3 has-margin-1 has-margin-top-3">
                            <span>
                                <i class="fas fa-fist-raised colored"></i>
                            </span> {{ student.xp }}
                    </div>
                    <div class="gold has-padding-3 has-margin-1 has-margin-top-2">
                            <span>
                                <i class="fas fa-coins colored"></i>
                            </span> {{ student.gold }}
                    </div>

                </div>
        </div>
    </div>
    <div class="column">
            <b-tabs v-model="activeTab" :key="update">
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
                <div class="field is-horizontal" v-if="student.password_plain&&admin">
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
                <div class="has-padding-4">
                    <img @click="confirmChangeClass(charclass.id)" v-bind:class="{ selected: charclass.id == student.character_id }" class="has-padding-2 has-margin-2 rounded" :src="'/img/character/' + charclass.id + '.png'" v-for="charclass in classroom.character_theme.characters" v-bind:key="charclass.id">            
                </div>
            </b-tab-item>

            <b-tab-item label="Inventory" class="has-padding-0">
                <div class="columns is-multiline is-variable" v-if="admin">
                    <div v-for="item in items" class="column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd" v-bind:key="item.id">
                            <b-field>
                                <p class="control">
                                    <img :src="item.icon">
                                </p>
                                <b-numberinput min="0" icon-pack="fa" v-model="item.count" expanded controlsPosition="compact"/>
                            </b-field>
                    </div>
                </div>

                        <div class="inventory" id="inventory" v-if="!admin">
                            



                            <div class="inventory_item faa-parent animated-hover">
                                        <img src="data:image/png;base64,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" class="item" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-tippy-content="L'imprescindible en qualsevol apocalipsi" tabindex="0">
                                        <div class="number_items" data-type="0" data-id="83">2</div>
                        </div>
                                    <div class="inventory_item faa-parent animated-hover">
                                        <i class="fas fa-info-square faa-pulse faa-slow itemGroupInfo topLeft" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-tippy-content="<strong>20</strong> <i class='fas fa-heart colored'></i> Arrastra a <i class='fas fa-flask-potion'></i> para aplicarlo. No puede revivir a los muertos." tabindex="0"></i>
                        <img src="/img/character/amulets/hp_big.png" class="item" draggable="true" data-type="0" data-id="51">
                                        <div class="number_items" data-type="0" data-id="51">1</div>
                        </div>
                                    <div class="inventory_item faa-parent animated-hover">
                                        <img src="data:image/png;base64,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" class="item" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-tippy-content="Una mascareta, però és de les roinetes i no protegeix ..." tabindex="0">
                                        <div class="number_items" data-type="0" data-id="82">1</div>
                        </div>
                                    <div class="inventory_item faa-parent animated-hover">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH5AMOERsj8MuNeAAAASZJREFUeNrtmTEOAUEYRpGtdCqVQiGhYRsV7V7BPZQSlQs4gBtsohTFVhIqzVJJnMABdJJRzxSzNjt2ZjLvdb+VxZf5Xn40GgAAABAqTQP3EBZe0xit0E8AAeCAip3e7Y/a6/E4kebpIHLKCVSAAAInUjt/fX6kJ+T3TJpft1w7dycxJ4AACMCvPaCUA1RUB5zSgzT3O29pHvXa0rxML1b3AipAAOwB1VhvVtrryXCuPCI7YbuYqU4QdTqBChAAe4D+9wB1L1D54fu90DnB9p5ABQgABxQiDNzDWSdQAQLAAdax6gQqQAA4wDlqdQIVIAAc4Dx/dQIVIAAc4B1GnUAFCCBwIg/fs+St7HHWOkH9L5ITQAAE4P0eUGpPKPrMVIAAAAAC5gsTLU72YMgJYQAAAABJRU5ErkJggg==" class="item" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" data-tippy-content="Mai es sap quan els zombies apareixeran per la porta ..." tabindex="0">
                                        <div class="number_items" data-type="0" data-id="84">1</div>
                        </div>
                                    <div class="inventory_item faa-parent animated-hover">
                        <img src="data:image/png;base64,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" class="item" draggable="true" data-type="0" data-id="91">
                                        <div class="number_items" data-type="0" data-id="91">1</div>
                        </div>
                                    <div class="inventory_item">
                        </div>
                                <div>
                        <div class="inventory_item inv_item_armor">
                                    <img src="/img/character/superheros/sh2_legs.png" width="48px" height="48px">
                                </div>
                                    <div class="inventory_item inv_item_armor_bronce">
                                    <img src="/img/character/superheros/sh2_eq1_body.png" width="48px" height="48px" data-html="true" data-toggle="popover" data-placement="top" data-trigger="hover" data-tippy-content="<i class='fas fa-fist-raised colored'></i>10% <br>" tabindex="0">
                                </div>
                                    <div class="inventory_item inv_item_armor_silver">
                                    <img src="/img/character/superheros/sh2_eq2_head.png" width="48px" height="48px" data-html="true" data-toggle="popover" data-placement="top" data-trigger="hover" data-tippy-content="<i class='fas fa-heart colored'></i>10% <br><i class='fas fa-fist-raised colored'></i>10% <br><i class='fas fa-coins colored'></i>10% " tabindex="0">
                                </div>
                                    <div class="inventory_item inv_item_armor_gold">
                                    <img src="/img/character/superheros/sh2_eq3_arms.png" width="48px" height="48px" data-html="true" data-toggle="popover" data-placement="top" data-trigger="hover" data-tippy-content="<i class='fas fa-heart colored'></i>10% <br><i class='fas fa-fist-raised colored'></i>20% <br><i class='fas fa-coins colored'></i>15% " tabindex="0">
                                </div>
                                        </div>
                                        <br style="clear:both;line-height:0">
                    </div>
            </b-tab-item>

            <b-tab-item label="Behaviours" v-if="student.behaviours.length">
                <div class="is-flex justify-content-center">
                    <apexchart v-if="series.length" width="450" type="donut" :options="{
                        labels: labels,  colors: colors
                        }" :series="series">
                    </apexchart>
                </div>

                <div class="columns">
                    <div class="column">
                        <input type="date" class="input is-rounded " v-model="dateStart">
                    </div>
                    <div class="column">
                        <input type="date" class="input is-rounded " v-model="dateEnd">
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

                        <b-table-column field="name" label="Settings" v-if="admin" centered>
                                <b-button type="is-danger is-small" @click="confirmDelete(props.row.id)"><i class="fas fa-trash-alt"></i></b-button>
                        </b-table-column>
                        
                    </template>
                </b-table>
            </b-tab-item>


            <b-tab-item label="Challenges">
               
            </b-tab-item>
            
            

            <b-tab-item label="Log" v-if="student.log_entries.length">
                <div class="columns">
                    <div class="column">
                        <input type="date" class="input is-rounded " v-model="dateStart">
                    </div>
                    <div class="column">
                        <input type="date" class="input is-rounded " v-model="dateEnd">
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

                    <b-table-column field="name" label="Settings" v-if="admin" centered>
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
        props: ['student', 'classroom', 'chart', 'admin', 'items'],
        mounted() {     
            if(!this.admin)
                this.activeTab = 1     
        },
        data: function() {
            return {
                activeTab: 0,
                dateStart: null,
                dateEnd: null,
                series: [],
                labels: [],
                colors: [],
                update: 0,
            }
        },
        methods: {
            confirmChangeClass(subclass) {
                this.$buefy.dialog.confirm({
                    title: 'Class change',
                    message: 'Basic equipment will be assigned, this action can\'t be undone.',
                    confirmText: 'Change class',
                    type: 'is-warning',
                    iconPack: 'fa',
                    hasIcon: true,
                    onConfirm: () => {
                        axios.post('/classroom/'+ this.classroom.code +'/student/changecharacter', {'id': this.student.id ,'character_id': subclass})
                            .then(response => {
                                location.reload()
                            })
                    }
                })
            },
            forceRerender() {
                this.update += 1;  
            },
             
            },
        computed: {
            filteredEntries(){
                return this.student.behaviours.filter(entry => {
                return (entry.pivot.created_at >= this.dateStart || !this.dateStart) && (entry.pivot.created_at <= this.dateEnd || !this.dateEnd)
                });
            },
            filteredLogEntries(){
                return this.student.log_entries.filter(entry => {
                    return (entry.created_at >= this.dateStart || !this.dateStart) && (entry.created_at <= this.dateEnd || !this.dateEnd) 
                });
            },
            groupedData() {
                let array =  _.groupBy(this.filteredEntries, "id")
                return array;
            }

        },
        watch: {
            groupedData:  {
                immediate: true,
                handler() {
                 let colorsOK = ['#c8e6c9', '#a5d6a7', '#81c784', '#66bb6a', '#4caf50', '#43a047', '#388e3c', '#2e7d32', '#1b5e20', '#003300', '#002200', '#001100', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000'];
                let colorsKO = ['#ffccbc', '#ffab91', '#ff8a65', '#ff7043', '#ff5722', '#f4511e', '#e64a19', '#d84315', '#bf360c', '#570000', '#370000', '#170000', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000', '#000000'];
                this.series = this.labels = []
                let data = this.groupedData
                let propes = []
                for (let property1 in data) {
                    propes.push(data[property1]);
                }
                this.labels = []
                 this.series = []
                 this.colors = []
                propes.forEach(element => {
                    let behaviour = element[0]
                    this.series.push(element.length)
                    this.labels.push("<i class='"+ behaviour.icon + "'></i> " + behaviour.name)
                    if((behaviour.xp + behaviour.hp + behaviour.gold) >=0){
                        this.colors.push(colorsOK[0])
                        colorsOK.shift()
                    } else {
                        this.colors.push(colorsKO[0])
                        colorsKO.shift()
                    }
                })
                }
            }
        }
  }
</script>
