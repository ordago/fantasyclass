<template>
      <section class="m-2" v-if="data.length">

        <div class="text-right">
          <download-excel style="display:inline"
              :data   = "data"
              :fields   = "json_fields"              
              >
              <b-button type="is-success"><i class="fas fa-file-spreadsheet"></i></b-button>
          </download-excel>
        </div>
        <b-table
            :data="data"
            :default-sort="['hp', 'desc']"
            icon-pack="fas"
            sort-icon="arrow-up"
            >

            <template slot-scope="props">

                <b-table-column field="icon" label="Icon" centered>
                    <span class="tag" v-bind:class="[ props.row.xp + props.row.hp + props.row.gold >= 0 ? 'is-success' : 'is-danger']">
                      <i :class="props.row.icon"></i>
                    </span>
                </b-table-column>

                <b-table-column field="name" label="First Name" sortable>
                    {{ props.row.name }}
                </b-table-column>
                
                <b-table-column field="custom_text" label="Custom text" sortable>
                    {{ props.row.custom_text }}
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
                        <b-button type="is-info is-small"><i class="fas fa-edit"></i></b-button>
                        <b-button type="is-danger is-small"><i class="fas fa-trash-alt"></i></b-button>
                </b-table-column>
                
            </template>
        </b-table>
    </section>
</template>

<script>

  export default {
        props: ['behaviours'],
        created() {
          this.data = JSON.parse(this.behaviours)
        },
        data: function() {
            return {
                data: [],
                json_fields: {
                  'Icon': 'icon',
                  'Name': 'name',
                  'Custom text': 'custom_text',
                  'HP': 'hp',
                  'XP': 'xp',
                  'Gold': 'gold',
                  },
                sortIcon: 'arrow-down',
                sortIconSize: 'is-small',
            }
        },
        methods: {

        },
      }
</script>