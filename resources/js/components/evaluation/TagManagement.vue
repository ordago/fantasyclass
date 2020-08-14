<template>
  <div class="w-100 content">
    <div>
      <button class="button is-link" @click="isTagModalActive=true">
        <i class="has-margin-right-2 fas fa-tag"></i> Add tag
      </button>
      <a :href="'/classroom/' + classroom.code + '/rubrics'" class="button is-warning">
        <i class="has-margin-right-2 fas fa-tasks-alt"></i> Rubric management
      </a>
      <button class="button is-dark" @click="isTagModalActive=true">
        <i class="has-margin-right-2 fas fa-cog"></i> Preferences
      </button>
      <button class="button is-primary" @click="isTagModalActive=true">
        <i class="has-margin-right-2 fas fa-file-chart-line"></i> Evaluation report
      </button>
    </div>
    <div class="has-margin-y-3">
      <span
        class="tag is-dark is-medium has-margin-right-2"
        v-for="(tag, index) in tagsReactive"
        :key="tag.id"
        v-tippy
        :content="tag.description"
      >
        <i class="fas fa-tag has-margin-right-2"></i>
        {{ tag.short }} ({{ tag.percent }}%)
        <small>
          <i
            class="fas fa-edit has-background-info rounded pointer has-padding-2 has-margin-left-3"
          ></i>
        </small>
        <small @click="deleteTag(tag.id, index)">
          <i
            class="fas fa-trash-alt has-background-danger rounded pointer has-padding-2 has-margin-left-3"
          ></i>
        </small>
      </span>
    </div>
    <div>
      <button
        class="button is-link"
        v-if="tagsReactive.length"
        @click="isLineModalActive=true"
      >Add evaluation line</button>
    </div>
    <div class="has-margin-3">
      <b-table v-if="linesReactive.length"
            :data="linesReactive"
            icon-pack="fas"
            cell-class="align-right"
            sort-icon="arrow-up"
            >
            <template slot-scope="props">
                <b-table-column field="Description" :label="trans.get('maps.name')" sortable>
                    {{ props.row.description }}
                </b-table-column>

                <b-table-column field="Tags" label="Url" sortable>
                    <span class="tag is-dark has-margin-right-2" v-for="tag in props.row.tags" :key="tag.id">{{ tag.short }}</span>
                </b-table-column>
                
                <b-table-column field="settings" :label="trans.get('menu.settings')" centered class="w-100 is-flex has-all-centered">
                    <b-button v-tippy :content="trans.get('maps.preview')" type="is-dark is-small has-margin-right-3">Grade</b-button>
                    <a v-tippy :content="trans.get('general.edit')" :href="'/classroom/' + classroom.code + '/maps/' + props.row.id" class="button is-info is-small has-margin-right-3"><i class="fas fa-edit"></i></a>
                    <b-button v-tippy :content="trans.get('general.delete')" type="is-danger is-small" @click="confirmDelete(props.row.id)"><i class="fas fa-trash-alt"></i></b-button>
                </b-table-column>
                
            </template>
        </b-table>
    </div>

    <b-modal
      :active.sync="isTagModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addTag">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">Add tag</p>
          </header>
          <section class="modal-card-body">
            <b-field label="Abbreviation">
              <b-input v-model="tag.short" maxlength="15" required></b-input>
            </b-field>
            <b-field label="Full description">
              <b-input v-model="tag.description" required></b-input>
            </b-field>
            <b-field label="% of the final grade">
              <b-input v-model="tag.percent" type="number" required></b-input>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isTagModalActive=false">Close</button>
            <button class="button is-primary">Add</button>
          </footer>
        </div>
      </form>
    </b-modal>
    <b-modal
      :active.sync="isLineModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="addLine">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">Add line</p>
          </header>
          <section class="modal-card-body">
            <section>
              <b-field label="Evaluation tags">
                <b-taginput
                  v-model="line.tags"
                  :data="filteredTags"
                  autocomplete
                  ref="taginput"
                  icon="tag"
                  @input="setWeight"
                  placeholder="Add a tag"
                  icon-pack="fa"
                  @typing="getFilteredTags"
                >
                  <template slot-scope="props">
                    <strong>{{props.option.short}}</strong>
                    : {{props.option.description}}
                  </template>
                  <template slot="empty">There are no items</template>
                  <template slot="selected" slot-scope="props">
                    <b-tag
                      v-for="(tag, index) in props.tags"
                      :key="index"
                      rounded
                      :tabstop="false"
                      ellipsis
                      closable
                      @close="$refs.taginput.removeTag(index, $event)"
                    >{{tag.short}}</b-tag>
                  </template>
                </b-taginput>
              </b-field>
            </section>
            <b-field label="Description">
              <b-input v-model="line.description" required></b-input>
            </b-field>
            <b-field label="Type">
              <b-select v-model="line.type" expanded>
                <option value="0">Simple</option>
                <option value="1">Advanced (rubric)</option>
              </b-select>
            </b-field>
            <b-field v-if="line.type == 1" label="Rubric">
              <b-select v-model="line.rubric" expanded>
                <option
                  v-for="rubric in rubrics"
                  :key="rubric.id"
                  :value="rubric.id"
                >{{ rubric.name }}</option>
              </b-select>
            </b-field>
            <div v-if="line.tags && line.tags.length">
              <details>
                <summary class="is-size-6">
                  <i class="fas fa-gear"></i> Advanced
                </summary>
                <h3>Weigth in the tag</h3>
                <div class="is-block w-100 has-margin-y-2" v-for="tag in line.tags" :key="tag.id">
                  <b-field>
                    <b-field grouped class="is-flex has-all-centered">
                      <p class="control">{{ tag.short }}</p>
                      <b-numberinput step="0.1" v-model="line.weights[tag.id]" />
                    </b-field>
                  </b-field>
                </div>
              </details>
            </div>
          </section>
          <footer class="modal-card-foot">
            <button class="button" type="button" @click="isLineModalActive=false">Close</button>
            <button class="button is-primary">Add</button>
          </footer>
        </div>
      </form>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: ["classroom", "tags", "rubrics", "lines"],
  created: function () {
    this.tagsReactive = this.tags;
    this.filteredTags = this.tags;
    this.linesReactive = this.lines;
  },
  data: function () {
    return {
      filteredTags: null,
      tagsReactive: null,
      isTagModalActive: false,
      isLineModalActive: false,
      linesReactive: [],
      tag: {
        short: "",
        description: "",
        percent: 0,
      },
      line: {
        tags: null,
        description: "",
        weights: {},
        type: 0,
        rubric: null,
      },
    };
  },
  methods: {
    deleteTag(id, index) {
      axios.delete("/classroom/tag/" + id).then((response) => {
        this.tagsReactive.splice(index, 1);
      });
    },
    setWeight(elems) {
      elems.forEach((element) => {
        this.line.weights[element.id] = 1;
      });
    },
    addLine() {
      if (this.line.tags) {
        axios
          .post("/classroom/" + this.classroom.code + "/evaline", this.line)
          .then((response) => {
            this.isLineModalActive = false;
            // this.tagsReactive.push(response.data);
          });
      }
    },
    addTag() {
      axios
        .post("/classroom/" + this.classroom.code + "/tag", this.tag)
        .then((response) => {
          console.log(response);
          this.isTagModalActive = false;
          this.tagsReactive.push(response.data);
        });
    },
    getFilteredTags(text) {
      this.filteredTags = this.tagsReactive.filter((option) => {
        return (
          option.short.toString().toLowerCase().indexOf(text.toLowerCase()) >= 0
        );
      });
    },
  },
  components: {},

  computed: {},
};
</script>
