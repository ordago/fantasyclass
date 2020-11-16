<template>
    <div class="panel is-primary pl-0">
        <p class="panel-heading is-flex has-space-between align-items-center p-3">
            <span>
                <i :class="evaluablegroup.icon"></i>
                <span class="pl-3">{{ evaluablegroup.name }}</span>
                <button style="font-size: 0.5em"
                        class="button is-danger"
                        @click="deleteEvaluationGroup(evaluablegroup.id)"
                        v-if="((evaluablegroup.hasOwnProperty('children') && evaluablegroup.children.length == 0) || !evaluablegroup.hasOwnProperty('children')) && evaluationlines !== null && evaluationlines.length == 0 && evaluablegroup.id !== 1">
                    <i class="fas fa-trash"></i>
                </button>
            </span>
            <span>
                <button class="button is-link" @click="isTagModalActive = true">
                    <i class="mr-2 fas fa-tag"></i>
                    {{ trans.get("evaluation.add_tag") }}
                </button>
                <button class="button is-link"
                        v-if="tagsReactive !== null && tagsReactive.length"
                        @click="isLineModalActive = true">
                    {{ trans.get("evaluation.evaluation_line") }}
                </button>
            </span>
        </p>
        <div class="my-3">
            <span class="tag is-dark is-medium mr-2"
                  v-for="(tag, index) in tagsReactive"
                  :key="tag.id"
                  v-tippy
                  :content="tag.description">
                <i class="fas fa-tag mr-2"></i>
                {{ tag.short }} ({{ tag.percent }}%)
                <small>
                    <i class="fas fa-edit has-background-info rounded pointer p-2 ml-3"
                       @click="showEditTag(tag)"></i>
                </small>
                <small @click="deleteTag(tag.id, index)">
                    <i class="fas fa-trash-alt has-background-danger rounded pointer p-2 ml-3"></i>
                </small>
            </span>
        </div>
        <div class="m-3">
            <b-table v-if="linesReactive !== null && linesReactive.length"
                     :data="linesReactive"
                     icon-pack="fas"
                     cell-class="align-right"
                     sort-icon="arrow-up">
                <template slot-scope="props">
                    <b-table-column field="description"
                                    :label="trans.get('evaluation.description')"
                                    sortable>{{ props.row.description }}</b-table-column>

                    <b-table-column field="tags"
                                    :label="trans.get('evaluation.tags')"
                                    sortable>
                        <span class="tag is-dark mr-2"
                              v-for="tag in props.row.tags"
                              :key="tag.id"
                              v-tippy
                              :content="
                trans.get('evaluation.weight') + ': ' + tag.pivot.weight
              ">{{ tag.short }}</span>
                    </b-table-column>

                    <b-table-column field="settings"
                                    :label="trans.get('menu.settings')"
                                    centered
                                    class="w-100 is-flex has-all-centered">
                        <a :href="'/classroom/evaluation/' + props.row.id + '/grade'"
                           class="button is-dark is-small mr-3">
                            <i class="fad fa-pencil"></i> {{ trans.get("evaluation.grade") }}
                        </a>
                        <b-button v-tippy
                                  :content="trans.get('general.delete')"
                                  type="is-danger is-small"
                                  @click="deleteLine(props.row.id)">
                            <i class="fas fa-trash-alt"></i>
                        </b-button>
                    </b-table-column>
                </template>
            </b-table>
        </div>

        <b-modal :active.sync="isTagModalActive"
                 has-modal-card
                 trap-focus
                 :destroy-on-hide="false"
                 aria-role="dialog"
                 aria-modal>
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
                            <b-input v-model="tag.percent" type="number" step="0.01" required></b-input>
                        </b-field>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button"
                                type="button"
                                @click="(isTagModalActive = false)">
                            Close
                        </button>
                        <button class="button is-primary" v-if="!tag.classroom_id">
                            {{ trans.get("evaluation.add") }}
                        </button>
                        <button class="button is-primary"
                                v-if="tag.classroom_id"
                                @click.prevent="editTag">
                            {{ trans.get("general.edit") }}
                        </button>
                    </footer>
                </div>
            </form>
        </b-modal>
        <b-modal :active.sync="isLineModalActive"
                 has-modal-card
                 trap-focus
                 :destroy-on-hide="false"
                 aria-role="dialog"
                 aria-modal>
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
                                <b-taginput v-model="line.tags"
                                            :data="filteredTags"
                                            autocomplete
                                            ref="taginput"
                                            id="taginput"
                                            icon="tag"
                                            @input="setWeight"
                                            :placeholder="trans.get('evaluation.add')"
                                            icon-pack="fa"
                                            @typing="getFilteredTags">
                                    <template slot-scope="props">
                                        <strong>{{ props.option.short }}</strong>
                                        : {{ props.option.description }}
                                    </template>
                                    <template slot="empty">
                                        There are no items
                                    </template>
                                    <template slot="selected" slot-scope="props">
                                        <b-tag v-for="(tag, index) in props.tags"
                                               :key="index"
                                               rounded
                                               :tabstop="false"
                                               ellipsis
                                               closable
                                               if="taginput"
                                               @close="$refs.taginput.removeTag(index, $event)">{{ tag.short }}</b-tag>
                                    </template>
                                </b-taginput>
                            </b-field>
                        </section>
                        <b-field class="mt-3"
                                 :label="trans.get('evaluation.description')">
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
                        <b-field v-if="line.type == 1"
                                 :label="trans.get('evaluation.rubric')">
                            <a v-if="rubrics === null || (rubrics !== null && !rubrics.length)"
                               :href="'/classroom/' + code + '/rubrics'"
                               class="button is-warning">
                                <i class="mr-2 fas fa-tasks-alt"></i>
                                {{ trans.get("evaluation.rubric_management") }}
                            </a>
                            <b-select v-if="rubrics !== null && rubrics.length" v-model="line.rubric" expanded>
                                <option v-for="rubric in rubrics"
                                        :key="rubric.id"
                                        :value="rubric.id">
                                    {{ rubric.name }}
                                </option>
                            </b-select>
                        </b-field>
                        <p v-if="line.type == 1 && (rubrics === null || (rubrics !== null && !rubrics.length))">
                            {{ trans.get("evaluation.rubric_empty") }}
                        </p>

                        <div v-if="line.tags && line.tags.length">
                            <details>
                                <summary class="is-size-6">
                                    <i class="fas fa-gear"></i>
                                    {{ trans.get("evaluation.advanced") }}
                                </summary>
                                <h3>{{ trans.get("evaluation.weight_info") }}</h3>
                                <div class="is-block w-100 my-2"
                                     v-for="tag in line.tags"
                                     :key="tag.id">
                                    <b-field>
                                        <b-field grouped class="is-flex has-all-centered">
                                            <p class="control">{{ tag.short }}</p>
                                            <b-numberinput step="0.01"
                                                           v-model="line.weights[tag.id]" />
                                        </b-field>
                                    </b-field>
                                </div>
                            </details>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button"
                                type="button"
                                @click="isLineModalActive = false">
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
        props: ["code", "evaluablegroup"],
        created: function () {
            this.tagsReactive = this.tags;
            this.filteredTags = this.tags;
            this.linesReactive = this.evaluationlines;
            this.getEvaluablesGroupByClass(this.evaluablegroup.id);
        },
        data: function () {
            return {
                isTagModalActive: false,
                isLineModalActive: false,
                isGradeModalActive: false,
                isPrefsModalActive: false,
                linesReactive: [],
                tagsReactive: [],
                evaluables: [],
                evaluationlines: [],
                rubrics: [],
                settings: null,
                tags: [],
                tag: {
                    short: "",
                    description: "",
                    percent: 0,
                    evaluables_group_id: this.$parent.activeGroup.id
                },
                line: {
                    id: null,
                    tags: [],
                    description: "",
                    weights: {},
                    type: 0,
                    rubric: null,
                    evaluables_group_id: this.$parent.activeGroup.id
                }
            };
        },
        methods: {
            deleteEvaluationGroup(id) {
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
                        axios.delete("/classroom/evaluation/group/" + id).then((response) => {
                            location.reload();
                        });
                    }
                });
            },
            getEvaluablesGroupByClass(id) {
                axios
                    .post("/classroom/" + this.code + "/evaluation/get", { id: id })
                    .then((response) => {
                        this.evaluables = response.data.evaluables;
                        this.evaluationlines = response.data.evaluationlines;
                        this.rubrics = response.data.rubrics;
                        this.settings = response.data.settings;
                        this.tags = response.data.tags;

                        this.tagsReactive = this.tags;
                        this.filteredTags = this.tags;
                        this.linesReactive = this.evaluationlines;
                    });
            },

            updatePrefs() {
                axios.patch("/classroom/" + this.code + "/setting", {
                    _method: "patch",
                    prop: "eval_visible",
                    value: this.settings.eval_visible,
                    action: "update",
                });
                axios.patch("/classroom/" + this.code + "/setting", {
                    _method: "patch",
                    prop: "eval_type",
                    value: this.settings.eval_type,
                    action: "update",
                });
                axios.patch("/classroom/" + this.code + "/setting", {
                    _method: "patch",
                    prop: "eval_max",
                    value: this.settings.eval_max,
                    action: "update",
                });
                this.isPrefsModalActive = false;
            },

            setWeight(elems) {
                elems.forEach((element) => {
                    this.line.weights[element.id] = 1;
                });
            },

            addLine() {
                if (this.line.tags.length) {
                    axios
                        .post("/classroom/" + this.code + "/evaluation", this.line)
                        .then((response) => {
                            if (response.data.hasOwnProperty('id') === true) {
                                this.isLineModalActive = false;
                                this.linesReactive.push(response.data);

                                // Refrescamos el PopUp
                                this.line.id = null;
                                this.line.tags = [];
                                this.line.description = "";
                                this.line.weights = {};
                                this.line.type = 0;
                                this.line.rubric = null;
                            }
                        });
                } else {
                    this.$refs.taginput.newTag = "";
                    this.$toasted.show(this.trans.get("success_error.taginput"), {
                        position: "top-center",
                        duration: 3000,
                        iconPack: "fontawesome",
                        icon: "times",
                        type: "error"
                    });
                }
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
                        axios.delete("/classroom/evaluation/" + id).then((response) => {
                            var index = this.linesReactive.findIndex(function (item, i) {
                                return item.id === id;
                            });
                            this.linesReactive.splice(index, 1);
                        });
                    }
                });
            },

            addTag() {
                debugger;
                axios
                    .post("/classroom/" + this.code + "/tag", this.tag)
                    .then((response) => {
                        this.isTagModalActive = false;
                        this.tagsReactive.push(response.data);

                        // Refrescamos el PopUp
                        this.tag.short = "";
                        this.tag.description = "";
                        this.tag.percent = 0;
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
            editTag() {
                axios
                    .patch("/classroom/" + this.code + "/tag", this.tag)
                    .then((response) => {
                        this.isTagModalActive = false;
                    });
            },
            getFilteredTags(text) {
                this.filteredTags = this.tagsReactive.filter((option) => {
                    return option.short.toString().toLowerCase().indexOf(text.toLowerCase()) >= 0;
                });
                this.$forceUpdate();
            },
            showEditTag(tag) {
                this.tag = tag;
                this.isTagModalActive = true;
            }
        }
    };
</script>
