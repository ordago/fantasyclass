<template>
  <div class="w-100 p-2 content">
    <div class="buttons">
      <button class="button is-link" @click="isTagModalActive = true">
        <i class="mr-2 fas fa-tag"></i>
        {{ trans.get("evaluation.add_tag") }}
      </button>
      <a
        :href="'/classroom/' + classroom.code + '/rubrics'"
        class="button is-warning"
      >
        <i class="mr-2 fas fa-tasks-alt"></i>
        {{ trans.get("evaluation.rubric_management") }}
      </a>
      <a
        :href="'/classroom/' + classroom.code + '/evaluation/report'"
        class="button is-primary"
      >
        <i class="mr-2 fas fa-file-chart-line"></i>
        {{ trans.get("evaluation.report") }}
      </a>
      <button class="button is-dark" @click="isPrefsModalActive = true">
        <i class="mr-2 fas fa-cog"></i>
        {{ trans.get("evaluation.config") }}
      </button>
    </div>
    <div class="my-3">
      <span
        class="tag is-dark is-medium mr-2 p-5"
        v-for="(tag, index) in tagsReactive"
        :key="tag.id"
        v-tippy
        :content="tag.description"
      >
        <i class="fas fa-tag mr-2"></i>
        {{ tag.short }} ({{ tag.percent }}%)
        <small>
          <i
            class="fas fa-edit has-background-info rounded pointer p-2 ml-3"
            @click="showEditTag(tag)"
          ></i>
        </small>
        <small @click="deleteTag(tag.id, index)">
          <i
            class="fas fa-trash-alt has-background-danger rounded pointer p-2 ml-3"
          ></i>
        </small>
      </span>
    </div>
    <div>
      <button
        class="button is-link"
        v-if="tagsReactive.length"
        @click="isLineModalActive = true"
      >
        {{ trans.get("evaluation.evaluation_line") }}
      </button>
    </div>
    <div class="m-3">
      <b-table
        v-if="linesReactive.length"
        :data="linesReactive"
        icon-pack="fas"
        cell-class="align-right"
        sort-icon="arrow-up"
      >
        <template slot-scope="props">
          <b-table-column
            field="description"
            :label="trans.get('evaluation.description')"
            sortable
            >{{ props.row.description }}</b-table-column
          >

          <b-table-column
            field="tags"
            :label="trans.get('evaluation.tags')"
            sortable
          >
            <span
              class="tag is-dark mr-2"
              v-for="tag in props.row.tags"
              :key="tag.id"
              v-tippy
              :content="
                trans.get('evaluation.weight') + ': ' + tag.pivot.weight
              "
              >{{ tag.short }}</span
            >
          </b-table-column>

          <b-table-column
            field="settings"
            :label="trans.get('menu.settings')"
            centered
            class="w-100 is-flex has-all-centered"
          >
            <a
              :href="'/classroom/evaluation/' + props.row.id + '/grade'"
              class="button is-dark is-small mr-3"
            >
              <i class="fad fa-pencil"></i> {{ trans.get("evaluation.grade") }}
            </a>
            <!-- <b-button
              v-tippy
              :content="trans.get('general.edit')"
              type="is-info is-small"
              @click="showEditLine(props.row)"
            >
              <i class="fas fa-edit"></i>
            </b-button>-->
            <b-button
              v-tippy
              :content="trans.get('general.delete')"
              type="is-danger is-small"
              @click="deleteLine(props.row.id)"
            >
              <i class="fas fa-trash-alt"></i>
            </b-button>
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
            <p class="modal-card-title" v-if="!tag.classroom_id">
              {{ trans.get("evaluation.add") }}
            </p>
            <p class="modal-card-title" v-if="tag.classroom_id">
              {{ trans.get("evaluation.edit") }}
            </p>
          </header>
          <section class="modal-card-body">
            <b-field :label="trans.get('evaluation.abbreviation')">
              <b-input v-model="tag.short" maxlength="15" required></b-input>
            </b-field>
            <b-field :label="trans.get('evaluation.full_description')">
              <b-input v-model="tag.description" required></b-input>
            </b-field>
            <b-field :label="trans.get('evaluation.percent')">
              <b-input
                v-model="tag.percent"
                type="number"
                step="0.01"
                required
              ></b-input>
            </b-field>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="
                (tag = { short: '', description: '', percent: 0 }),
                  (isTagModalActive = false)
              "
            >
              Close
            </button>
            <button class="button is-primary" v-if="!tag.classroom_id">
              {{ trans.get("evaluation.add") }}
            </button>
            <button
              class="button is-primary"
              v-if="tag.classroom_id"
              @click.prevent="editTag"
            >
              {{ trans.get("general.edit") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>
    <b-modal
      :active.sync="isPrefsModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="updatePrefs">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">{{ trans.get("evaluation.config") }}</p>
          </header>
          <section class="modal-card-body">
            <div class="field">
              <label class="label">{{ trans.get("evaluation.type") }}</label>
              <div class="control">
                <div class="select">
                  <select v-model="settings.eval_type" @input="$forceUpdate()">
                    <option value="0">
                      {{ trans.get("evaluation.number_grade") }}
                    </option>
                    <option value="1">
                      {{ trans.get("evaluation.emoji") }}
                    </option>
                    <option value="2">
                      {{ trans.get("evaluation.passfail") }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">{{
                trans.get("evaluation.max_grade")
              }}</label>
              <div class="control">
                <input
                  class="input"
                  type="number"
                  v-model="settings.eval_max"
                  placeholder="Text input"
                />
              </div>
            </div>
            <div class="field">
              <b-switch
                true-value="1"
                false-value="0"
                v-model="settings.eval_visible"
                >{{ trans.get("evaluation.visibility") }}</b-switch
              >
            </div>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="isPrefsModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-primary" @click="updatePrefs">
              {{ trans.get("general.update") }}
            </button>
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
            <p class="modal-card-title">
              {{ trans.get("evaluation.evaluation_line") }}
            </p>
          </header>
          <section class="modal-card-body">
            <section>
              <b-field :label="trans.get('evaluation.evaluation_tags')">
                <b-taginput
                  v-model="line.tags"
                  :data="filteredTags"
                  autocomplete
                  ref="taginput"
                  id="taginput"
                  icon="tag"
                  @input="setWeight"
                  :placeholder="trans.get('evaluation.add')"
                  icon-pack="fa"
                  @typing="getFilteredTags"
                >
                  <template slot-scope="props">
                    <strong>{{ props.option.short }}</strong>
                    : {{ props.option.description }}
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
                      if="taginput"
                      @close="$refs.taginput.removeTag(index, $event)"
                      >{{ tag.short }}</b-tag
                    >
                  </template>
                </b-taginput>
              </b-field>
            </section>
            <b-field class="mt-3" :label="trans.get('evaluation.description')">
              <b-input v-model="line.description" required></b-input>
            </b-field>
            <b-field :label="trans.get('evaluation.type')">
              <b-select v-model="line.type" expanded>
                <option value="0">{{ trans.get("evaluation.basic") }}</option>
                <option value="1">
                  {{ trans.get("evaluation.advanced_rubric") }}
                </option>
              </b-select>
            </b-field>
            <b-field
              v-if="line.type == 1"
              :label="trans.get('evaluation.rubric')"
            >
              <a
                v-if="!rubrics.length"
                :href="'/classroom/' + classroom.code + '/rubrics'"
                class="button is-warning"
              >
                <i class="mr-2 fas fa-tasks-alt"></i>
                {{ trans.get("evaluation.rubric_management") }}
              </a>
              <b-select v-if="rubrics.length" v-model="line.rubric" expanded>
                <option
                  v-for="rubric in rubrics"
                  :key="rubric.id"
                  :value="rubric.id"
                >
                  {{ rubric.name }}
                </option>
              </b-select>
            </b-field>
            <p v-if="line.type == 1 && !rubrics.length">
              {{ trans.get("evaluation.rubric_empty") }}
            </p>

            <div v-if="line.tags && line.tags.length">
              <details>
                <summary class="is-size-6">
                  <i class="fas fa-gear"></i>
                  {{ trans.get("evaluation.advanced") }}
                </summary>
                <h3>{{ trans.get("evaluation.weight_info") }}</h3>
                <div
                  class="is-block w-100 my-2"
                  v-for="tag in line.tags"
                  :key="tag.id"
                >
                  <b-field>
                    <b-field grouped class="is-flex has-all-centered">
                      <p class="control">{{ tag.short }}</p>
                      <b-numberinput
                        step="0.01"
                        v-model="line.weights[tag.id]"
                      />
                    </b-field>
                  </b-field>
                </div>
              </details>
            </div>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="isLineModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-primary">
              {{ trans.get("evaluation.evaluation_line") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: ["classroom", "tags", "rubrics", "lines", "settings"],
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
      isGradeModalActive: false,
      isPrefsModalActive: false,
      linesReactive: [],
      tag: {
        short: "",
        description: "",
        percent: 0,
      },
      line: {
        id: null,
        tags: [],
        description: "",
        weights: {},
        type: 0,
        rubric: null,
      },
    };
  },
  methods: {
    updatePrefs() {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "eval_visible",
        value: this.settings.eval_visible,
        action: "update",
      });
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "eval_type",
        value: this.settings.eval_type,
        action: "update",
      });
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "eval_max",
        value: this.settings.eval_max,
        action: "update",
      });
      this.isPrefsModalActive = false;
    },
    editTag() {
      axios
        .patch("/classroom/" + this.classroom.code + "/tag", this.tag)
        .then((response) => {
          this.isTagModalActive = false;
        });
    },
    showEditTag(tag) {
      this.tag = tag;
      this.isTagModalActive = true;
    },
    showEditLine(line) {
      // this.line.id = line.id;
      // this.line.description = line.description;
      // this.line.weights = line.weights;
      // this.line.type = line.type;
      // this.line.rubric = line.rubric;
      // // line.tags.forEach((element) => {
      // //   let tag = this.tagsReactive.find(function (item, i) {
      // //     return item.id === element.id;
      // //   });
      // //   this.line.tags.push(tag);
      // // });
      // this.isLineModalActive = true;
    },
    deleteLine(id) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios.delete("/classroom/evaline/" + id).then((response) => {
            var index = this.linesReactive.findIndex(function (item, i) {
              return item.id === id;
            });
            this.linesReactive.splice(index, 1);
          });
        },
      });
    },
    deleteTag(id, index) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios.delete("/classroom/tag/" + id).then((response) => {
            this.tagsReactive.splice(index, 1);
          });
        },
      });
    },
    setWeight(elems) {
      elems.forEach((element) => {
        this.line.weights[element.id] = 1;
      });
    },
    addLine() {
      if (this.line.tags.length) {
        axios
          .post("/classroom/" + this.classroom.code + "/evaline", this.line)
          .then((response) => {
            this.isLineModalActive = false;
            this.linesReactive.push(response.data);
          });
      } else {
        this.$refs.taginput.newTag = "";
        this.$toast(this.trans.get("success_error.taginput"), {
          type: "error",
        });
      }
    },
    addTag() {
      axios
        .post("/classroom/" + this.classroom.code + "/tag", this.tag)
        .then((response) => {
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
