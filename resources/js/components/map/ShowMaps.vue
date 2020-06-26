<template>
      <section class="has-padding-2">

        <div class="columns has-margin-bottom-0">
            <div class="column is-narrow">
                <a :href="'/classroom/' + this.code + '/maps/create'" class="button is-link">{{ trans.get('maps.add') }}</a>
            </div>
            <div class="column is-hidden-mobile">
            </div>
            <div class="column is-narrow" v-if="data.length">
                <download-excel style="display:inline"
                    :data   = "data"
                    :fields   = "json_fields"              
                    >
                    <b-button type="is-success has-margin-2"><i class="fas fa-file-spreadsheet"></i></b-button>
                </download-excel>
            </div>
        </div>
        <div class="container">
        <b-table v-if="data.length"
            :data="data"
            :default-sort="['hp', 'desc']"
            icon-pack="fas"
            sort-icon="arrow-up"
            :row-class="(row, index) => row.id == mapSelected && 'is-info'"
            >

            <template slot-scope="props">
                <b-table-column field="name" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>
               <!--
                <b-table-column field="url" label="Url" sortable>
                    {{ props.row.url }}
                </b-table-column>
-->
                <b-table-column field="settings" label="Settings" centered>
                    <b-button type="is-success is-small" @click="mapFullScreen(props.row.name, getURLRefactoring(props.row.url))"><i class="fas fa-map"></i></b-button>
                    <b-button type="is-primary is-small" v-if="props.row.id != mapSelected" @click="confirmActive(props.row.id)"><i class="fas fa-home"></i></b-button>
                    <i class="fa fa-ellipsis-v fas fa-lg"></i>
                    <a :href="'/classroom/' + code + '/maps/' + props.row.id" class="button is-info is-small"><i class="fas fa-edit"></i></a>
                    <b-button type="is-danger is-small" @click="confirmDelete(props.row.id)"><i class="fas fa-trash-alt"></i></b-button>
                </b-table-column>
                
            </template>
        </b-table>
        </div>
         <b-modal :active.sync="isComponentModalActive"
            has-modal-card full-screen :can-cancel="false">
            <modal-form v-bind="formProps"></modal-form>
        </b-modal>
    </section>
</template>

<script>
import Utils from "../../utils.js";

    const ModalForm = {
        props: ['name', 'url'],
        template: `
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">{{ name }}</p>
                </header>
                <section class="modal-card-body">
                    <div>
                    <iframe frameborder="0" class="map-iframe" 
                    v-bind:src="url"
                    type="text/html" allowscriptaccess="always" allowfullscreen="true" scrolling="yes" allownetworking="all"></iframe>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button" type="button" @click="$parent.close()">Close</button>
                </footer>
            </div>
        `
    }

  export default {
        props: ['maps', 'code', 'activeMap'],
        components: {
            ModalForm
        },      
        created() {
                this.data = JSON.parse(this.maps)
                this.mapSelected = this.activeMap
        },
        data: function() {
            return {
                data: [],
                isComponentModalActive: false,
                formProps: {
                    url: 'url',
                    name: 'name'
                },
                mapSelected: null,
                json_fields: {
                  'Name': 'name',
                  'Url': 'url',
                  
                },
                sortIcon: 'arrow-down',
                sortIconSize: 'is-small',
            }
        },
        methods: {
            getURLRefactoring(url) {
                return Utils.getURLRefactoring(url);
            },
            mapFullScreen(name, url){
                this.isComponentModalActive = true;
                this.formProps.name = name;
                this.formProps.url = url;
            },
            confirmDelete(mapId) {
                this.$buefy.dialog.confirm({
                    title: this.trans.get('general.delete'),
                    message: this.trans.get('general.confirm_delete'),
                    confirmText: this.trans.get('general.delete'),
                    type: 'is-danger',
                    hasIcon: true,
                    icon: 'times-circle',
                    iconPack: 'fa',
                    ariaRole: 'alertdialog',
                    ariaModal: true,
                    onConfirm: () => {
                        var index = this.data.findIndex(
                            function(item, i){
                                            return item.id === mapId
                            });
                          axios.delete('/classroom/maps/' + mapId)
                            .then(response => {
                                  if(response.data === 1) {
                                    this.data.splice(index, 1);
                              }
                          })
                    }
                }) 
            },
            confirmActive(mapId) {
                this.$buefy.dialog.confirm({
                    title: this.trans.get('map.active'),
                    message: this.trans.get('map.confirm_active'),
                    confirmText: this.trans.get('map.active'),
                    type: 'is-info',
                    hasIcon: true,
                    icon: 'times-circle',
                    iconPack: 'fa',
                    ariaRole: 'dialog',
                    ariaModal: true,
                    onConfirm: () => {
                        axios.patch("/classroom/" + this.code + "/setting", {
                            _method: "patch",
                            prop: 'active_map',
                            value: mapId,
                            action: "update"
                        })
                        this.mapSelected = mapId
                    }
                }) 
            },
      }
    }
</script>

<style>
  tr.is-info {
      background: #167df0;
      color: #fff;
  }
</style>