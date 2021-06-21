<template>
  <div class="columns p-2">
    <div class="column is-narrow pr-0" style="min-width: 400px">
      <article class="panel is-sticky-panel is-info">
        <p
          class="panel-heading is-flex has-space-between align-items-center p-3"
        >
          <span>{{ trans.get("evaluation.evaluations") }}</span>
          <button
            class="button"
            @click="activeAddGroup = !activeAddGroup"
            v-html="buttonAddGroup"
          ></button>
        </p>

        <div
          class="panel-block is-flex is-flex-column p-0"
          style="align-items: flex-start"
        >
          <div
            @click="activeGroup = -1"
            class="
              highlight-arrow
              is-flex
              has-space-between
              w-100
              is-fullwidth
              cursor-pointer
              pl-1
              pr-4
              py-3
            "
          >
            <span class="p-2">
              <span class="panel-icon">
                <i class="fas fa-chart-line" aria-hidden="true"></i>
              </span>
              <span :title="trans.get('evaluation.first')"> {{trans.get('evaluation.first')}} </span>
            </span>
            <span class="p-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
        </div>
        <div
          class="panel-block is-flex is-flex-column p-0"
          style="align-items: flex-start"
          v-for="evaluableGroup in evaluablesgroup"
          v-bind:key="evaluableGroup.id"
        >
          <div
            @click="activeGroup = evaluableGroup"
            class="
              highlight-arrow
              is-flex
              has-space-between
              w-100
              is-fullwidth
              cursor-pointer
              pl-1
              pr-4
              py-3
            "
          >
            <span class="p-2">
              <span class="panel-icon">
                <i :class="evaluableGroup.icon" aria-hidden="true"></i>
              </span>
              <span :title="evaluableGroup.name">
                {{
                  evaluableGroup.name.length > 30
                    ? evaluableGroup.name.substring(0, 30) + "..."
                    : evaluableGroup.name
                }}
              </span>
            </span>
            <span class="p-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
        </div>
      </article>
    </div>
    <div class="column pr-0">
      <b-loading
        :is-full-page="true"
        :active.sync="isLoading"
        :can-cancel="false"
      ></b-loading>
      <CreateEvaluationGroup
        :code="code"
        v-if="activeAddGroup"
        key
      ></CreateEvaluationGroup>
      <TagManagement
        ref="tags"
        :code="code"
        :evaluablegroup="activeGroup"
        :key="activeGroup.id"
        v-if="!activeAddGroup && activeGroup"
      ></TagManagement>
    </div>
  </div>
</template>
<script>
import CreateEvaluationGroup from "./CreateEvaluationGroup.vue";
import TagManagement from "./TagManagement.vue";

export default {
  props: ["code", "evaluablesgroup"],
  data: function () {
    return {
      activeAddGroup: false,
      activeGroup: -1,
      updated: false,
      evaluables: [],
      evaluationlines: [],
      rubrics: [],
      settings: null,
      tags: [],
      isLoading: false,
    };
  },
  methods: {
    refresh: function (elem) {
      this.evaluablesgroup.push(elem);
      this.activeGroup = elem;
      this.$forceUpdate();
    },
  },
  components: {
    CreateEvaluationGroup,
    TagManagement,
  },
  computed: {
    buttonAddGroup() {
      return this.activeAddGroup
        ? this.trans.get("general.cancel")
        : "<i class='far fa-plus pr-2'></i>" +
            this.trans.get("evaluation.add_evaluation");
    },
  },
};
</script>
