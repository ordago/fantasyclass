<template>
<div>
    <b-tabs v-model="activeTab">
        <b-tab-item label="Items" icon-pack="fa" class="has-padding-x-4">

            <div class="field">
                <b-switch :value="true"
                type="is-success"
                v-model="items_visibility"
                passive-type="is-danger"
                @input="toggleVisibility('items_visibility')"
                >
                Visibility
                </b-switch>
            </div>

            <div v-for="item in items" class="columns is-multiline is-variable is-1 is-all-centered has-padding-3" style="border-bottom: 1px dashed #999" v-bind:key="item.id">
                <div class="column is-narrow">
                    <img :src="item.icon" width="48px">
                </div>
                <div class="column is-narrow">
                    <div class="field is-horizontal">
                        <div class="field-body">
                            <div class="field is-expanded">
                            <div class="field has-addons">
                                <p class="control">
                                <a class="button is-static">
                                    <i class="fas fa-heart colored"></i>
                                </a>
                                </p>
                                <p class="control is-expanded">
                                     <input type="number" class="input" v-model="item.hp">
                                </p>
                            </div>
                            </div>
                        </div>
                        </div>
                </div>
                <div class="column is-narrow">
                    <div class="field is-horizontal">
                        <div class="field-body">
                            <div class="field is-expanded">
                            <div class="field has-addons">
                                <p class="control">
                                <a class="button is-static">
                                    <i class="fas fa-fist-raised colored"></i>
                                </a>
                                </p>
                                <p class="control is-expanded">
                                     <input type="number" class="input" v-model="item.xp">
                                </p>
                            </div>
                            </div>
                        </div>
                        </div>
                </div>
                <div class="column is-narrow">
                    <div class="field is-horizontal">
                        <div class="field-body">
                            <div class="field is-expanded">
                            <div class="field has-addons">
                                <p class="control">
                                <a class="button is-static">
                                    Price <i class="fas fa-coins colored"></i>
                                </a>
                                </p>
                                <p class="control is-expanded">
                                     <input type="number" class="input" v-model="item.price">
                                </p>
                            </div>
                            </div>
                        </div>
                        </div>
                </div>

                <div class="column is-narrow">
                     <div class="field">
                        <b-switch v-model="item.for_sale"
                        true-value="1"
                        false-value="0"
                        >
                            For sale?
                        </b-switch>
                    </div>    
                </div>
                <div class="column is-narrow">
                    <textarea class="input" placeholder="Description" v-model="item.description"></textarea>
                </div>
                <!-- <div class="column is-narrow is-all-centered">
                    <b-field>
                        <p class="control">
                            Min level
                        </p>
                        <b-numberinput @input="null" min="0" icon-pack="fa" v-model="item.min_lvl" controlsPosition="compact"/>
                    </b-field>
                </div> -->
            </div>
            
        </b-tab-item>

        <b-tab-item label="Equipment 1" icon-pack="fa" class="has-padding-x-4">
             <div class="field">
                <b-switch :value="true"
                type="is-success"
                v-model="equipment_1_visibility"
                passive-type="is-danger"
                @input="toggleVisibility('equipment_1_visibility')"
                >
                Visibility
                </b-switch>
            </div>
        </b-tab-item>

        <b-tab-item label="Equipment 2"  icon-pack="fa" class="has-padding-x-4">
            <div class="field">
                            <b-switch :value="true"
                            type="is-success"
                            v-model="equipment_2_visibility"
                            passive-type="is-danger"
                            @input="toggleVisibility('equipment_2_visibility')"
                            >
                            Visibility
                            </b-switch>
            </div>        
        </b-tab-item>

        <b-tab-item label="Equipment 3"  icon-pack="fa" class="has-padding-x-4">
            <div class="field">
                <b-switch :value="true"
                type="is-success"
                v-model="equipment_3_visibility"
                passive-type="is-danger"
                @input="toggleVisibility('equipment_3_visibility')"
                >
                Visibility
                </b-switch>
            </div>
        </b-tab-item>

    </b-tabs>
</div>
</template>

<script>

  export default {
        props: ['items', 'config', 'code'],
        mounted() {     
        
        },
        data: function() {
            return {
               activeTab: 0,
               items_visibility: this.config.items_visibility,
               equipment_1_visibility: this.config.equipment_1_visibility ? true : false,
               equipment_2_visibility: this.config.equipment_2_visibility ? true : false,
               equipment_3_visibility: this.config.equipment_3_visibility ? true : false,
            }
        },
        methods: {
            toggleVisibility(prop) {
                axios.patch('/classroom/' + this.code + '/setting', {'_method': 'patch', 'prop': prop, 'action': 'toggle' })
                    .then(response => {
                    
                    })
            },
        },
        computed: {
                    visibilityItems() {
                                        if(this.items_visibility) return "<i class='fas fa-eye-slash'></i> <span class='has-padding-left-2'>Make invisible</span>";
                                        return "<i class='fas fa-eye'></i> <span class='has-padding-left-2'>Make visible</span>"
                    },
                    visibilityEq1() {
                                        if(this.equipment_1_visibility) return "<i class='fas fa-eye-slash'></i> <span class='has-padding-left-2'>Make invisible</span>";
                                        return "<i class='fas fa-eye'></i> <span class='has-padding-left-2'>Make visible</span>"
                    },
                    visibilityEq2() {
                                        if(this.equipment_2_visibility) return "<i class='fas fa-eye-slash'></i> <span class='has-padding-left-2'>Make invisible</span>";
                                        return "<i class='fas fa-eye'></i> <span class='has-padding-left-2'>Make visible</span>"
                    },
                    visibilityEq3() {
                                        if(this.equipment_3_visibility) return "<i class='fas fa-eye-slash'></i> <span class='has-padding-left-2'>Make invisible</span>";
                                        return "<i class='fas fa-eye'></i> <span class='has-padding-left-2'>Make visible</span>"
                    },
                    getIconItem() {
                        return this.items_visibility ? 'eye-slash' : 'eye'
                    }

        },
         watch: {
            // $props: {
            // handler() {
            //     this.parseData();
            // },
            // deep: true,
            // immediate: true,
        // }
    }
  }
</script>
