<template>
  <div>
    <a :href="'/classroom/' + classroom.code + '/rubric/create'" class="button is-link mb-3">{{ trans.get('evaluation.create_rubric') }}</a>
    <b-table v-if="rubrics.length"
            :data="rubrics"
            :default-sort="['name']"
            icon-pack="fas"
            cell-class="align-right"
            sort-icon="arrow-up"
            >

            <template slot-scope="props">
                <b-table-column field="name" :label="trans.get('maps.name')" sortable>
                    {{ props.row.name }}
                </b-table-column>
                
                <b-table-column field="settings" :label="trans.get('menu.settings')" centered class="w-100 is-flex has-all-centered">
                    <a v-tippy :content="trans.get('general.edit')" :href="'/classroom/' + classroom.code + '/rubric/' + props.row.id" class="button is-info is-small mr-3"><i class="fas fa-edit"></i></a>
                    <b-button v-tippy :content="trans.get('general.delete')" type="is-danger is-small" @click="confirmDelete(props.row.id)"><i class="fas fa-trash-alt"></i></b-button>
                </b-table-column>
                
            </template>
        </b-table>
        
  </div>
</template>

<script>
export default {
  props: ["rubrics", "classroom"],
  created() {
    
  },
  data: function() {
    return {
      
      }
  },
  methods: {
  }
};
</script>