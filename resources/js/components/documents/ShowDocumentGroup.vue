<template>
  <div class="columns p-2">
    <div class="column is-narrow pr-0" style="min-width: 400px" v-if="documentGroupsMutable.length"> 
      <article class="panel is-sticky-panel is-info">
        <p
          class="panel-heading is-flex has-space-between align-items-center p-3"
        >
          <span>{{ trans.get("challenges.categories") }}</span>
          <button
            class="button"
            @click="activeAddGroup = !activeAddGroup"
            v-html="buttonAddGroup"
          ></button>
        </p>
        <draggable handle=".handle" v-model="documentGroupsMutable" @start="drag=true" @end="finishDrop">
          <div 
           class="panel-block is-flex is-flex-column p-0"
          style="align-items: flex-start"
          v-for="group in documentGroupsMutable" :key="group.id">
             <div
            @click="
              getDocuments(group.id);
              activeGroup = group;
            "
            class="highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer pl-1 pr-4 py-3"
          >
            <span class="p-2">
              <i class="far fa-arrows-v handle mr-2 cursor-move" v-if="documentGroupsMutable.length > 1"></i> 
              <span class="panel-icon">
                <i :class="group.icon" aria-hidden="true"></i>
              </span>
              <span :title="group.name">
                {{
                  group.name.length > 30
                    ? group.name.substring(0, 30) + "..."
                    : group.name
                }}
                <!-- <b-tag type="is-info is-light" class="has-small-font">{{ challenge.numChallenges }}</b-tag> -->
              </span>
            </span>
            <span class="p-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
          
          </div>
        </draggable>
        <!-- <div
          class="panel-block is-flex is-flex-column p-0"
          style="align-items: flex-start"
          v-for="group in documentGroupsMutable"
          v-bind:key="group.id"
        >
          <div
            @click="
              getDocuments(group.id);
              activeGroup = group;
            "
            class="highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer pl-1 pr-4 py-3"
          >
            <span class="p-2">
              <span class="panel-icon">
                <i :class="group.icon" aria-hidden="true"></i>
              </span>
              <span :title="group.name">
                {{
                  group.name.length > 30
                    ? group.name.substring(0, 30) + "..."
                    : group.name
                }}
              </span>
            </span>
            <span class="p-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
        </div> -->
      </article>
    </div>
    <div class="column pr-0">
      <b-loading
        :is-full-page="true"
        :active.sync="isLoading"
        :can-cancel="false"
      ></b-loading>
       
      <CreateDocumentCategory
        :code="code"
        v-if="activeAddGroup || !documentGroupsMutable.length"
      ></CreateDocumentCategory>
      <ShowDocuments
        :code="code"
        :documentgroup="activeGroup"
        :documents="documents"
        v-if="!activeAddGroup && activeGroup && !isLoading"
      ></ShowDocuments>
    </div>
  </div>
</template>
<script>
import CreateDocumentCategory from "./CreateDocumentCategory.vue";
import ShowDocuments from "./ShowDocuments.vue";

import draggable from 'vuedraggable'


export default {
  props: ["code", "documentgroups"],
  created: function () {
    this.documentGroupsMutable = this.documentgroups;
  },
  data: function () {
    return {
      activeAddGroup: false,
      activeGroup: false,
      updated: false,
      documents: [],
      isLoading: false,
      documentGroupsMutable: null,
    };
  },
  methods: {
    finishDrop (event) {
      axios.post('/classroom/' + this.code + '/docmgr/group/order', {groups: this.documentGroupsMutable})
      .then(response => {

      });
    },
    refresh: function (elem) {
      if (elem.challenges_group_id) {
        let challenge = this.documentGroupsMutable.filter(function (data) {
          return data.id == elem.challenges_group_id;
        });
        challenge[0].children.push(elem);
      } else this.documentGroupsMutable.push(elem);
      this.$forceUpdate();
    },
    getDocuments(id) {
      this.isLoading = true;
      axios
        .post("/classroom/" + this.code + "/documents/get", { id: id })
        .then((response) => {
          this.documents = response.data;
          this.isLoading = false;
        });
    },
  },
  components: {
    CreateDocumentCategory,
    ShowDocuments,
    draggable,
  },
  computed: {
    buttonAddGroup() {
      return this.activeAddGroup
        ? this.trans.get("general.cancel")
        : "<i class='far fa-plus pr-2'></i>" +
            this.trans.get("challenges.add_category");
    },
  },
};
</script>