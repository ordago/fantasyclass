<template>
<div class="content">
    <form @submit.prevent="createGroups" method="post" action="" v-if="!groups.length">
        <input :value="csrfToken" type="hidden" name="_token"/>
        <div class="has-padding-4">
            <div>
                <span>
                    How many groups do you want?
                </span> 
                <input type="number" class="input" v-model="groupsNumber">
            </div>
            <button class="button is-primary has-margin-top-3">Create</button>
        </div>
    </form>
    <button class="button is-link has-margin-3">Create Group</button>
    <div v-if="groups.length">
            <button class="button is-primary" @click="editGroups=!editGroups">Edit Groups</button>
            <drag-drop
                v-if="!editGroups"
                :dropzones="dropGroups"
                :dropzonesTitle="'Groups'"
                :originalData="students"
                :originalTitle="'Students'"
                :inPlace="true"
                class="has-margin-top-3"
                ref="dnditems"
                @save="save"
                @cancel="cancel"
                >
                <template #dd-card="{ cardData }">
                    <custom-card
                    :data="cardData"
                    />
                </template>
            </drag-drop>

            <div v-else>
                <div class="columns has-margin-3">
                    <div v-for="group in dropGroups" v-bind:key="group.id">
                        <edit-group :group="group"></edit-group>
                    </div>
                </div>
            </div>
    </div>
</div>
</template>

<script>
import DragDrop from 'vue-drag-n-drop'
import CustomCard from './CustomCard.vue'

  export default {
        props: ['groups', 'code', 'students'],
        mounted() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
            let itemsDelete = [];
            this.groups.forEach(element => {
                let children = []
                this.students.forEach(std => {
                    std.groups.forEach(group => {
                        if(group.id == element.id) {
                            children.push(std)
                            itemsDelete.push(std.id)
                        }
                    });
                });
                this.dropGroups.push({
                    id: element.id,
                    name: element.name,
                    children: children
                })

            })
            itemsDelete.forEach(element => {
                    var index = this.$refs.dnditems.items.findIndex(
                        function(item){
                                return item.id === element
                });
                this.$refs.dnditems.items.splice(index, 1);
            });
        },
        data: function() {
            return {
                csrfToken: null,
                groupsNumber: 5,
                dropGroups: [
                ],
                editGroups: false,
            }
        },
          components: {
            DragDrop,
            CustomCard,
        },
        methods: {
            createGroups() {
                axios.post('/classroom/' + this.code +'/groups/create', { groupsNumber: this.groupsNumber })
                    .then(response => {
                        location.reload()
                    })
           },
           save() {
                axios.patch('/classroom/' + this.code +'/groups', { _method: 'patch', dropGroups: this.dropGroups })
                     .then(response => {
                        
                     })
           },
           cancel() {
               location.reload()
           }
        }
    }
</script>
