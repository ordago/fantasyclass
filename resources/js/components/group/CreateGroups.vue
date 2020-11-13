<template>
  <div class="content p-2">
    <form
      @submit.prevent="createGroups()"
      method="post"
      action
      v-if="!groups.length"
    >
      <input :value="csrfToken" type="hidden" name="_token" />
      <div class="p-4">
        <div>
          <span class="my-2">{{ trans.get("groups.number_groups") }}</span>
          <input type="number" class="input mt-3" v-model="groupsNumber" />
        </div>
        <button class="button is-primary mt-3">
          {{ trans.get("groups.create") }}
        </button>
      </div>
    </form>
    <div v-if="groups.length">
      <button class="button is-link" @click="createGroups(1)">
        {{ trans.get("groups.new_group") }}
      </button>
      <button class="button is-primary" @click="editGroups = !editGroups">
        {{ trans.get("groups.edit_groups") }}
      </button>
      <drag-drop
        v-if="!editGroups"
        :dropzones="dropGroups"
        :dropzonesTitle="'Groups'"
        :originalData="students"
        :originalTitle="'Students'"
        :inPlace="true"
        class="mt-3"
        ref="dnditems"
        @save="save"
        @cancel="cancel"
      >
        <template #dd-card="{ cardData }">
          <custom-card :data="cardData" />
        </template>
      </drag-drop>

      <div v-else>
        <div class="m-3 columns is-multiline is-variable">
          <div
            class="column is-6-tablet is-12-mobile is-3-desktop"
            v-for="group in dropGroups"
            v-bind:key="group.id"
          >
            <edit-group :group="group" :code="code"></edit-group>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DragDrop from "vue-drag-n-drop";
import CustomCard from "./CustomCard.vue";

export default {
  props: ["groups", "code", "students"],
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let itemsDelete = [];
    this.groups.forEach((element) => {
      let children = [];
      this.students.forEach((std) => {
        std.groups.forEach((group) => {
          if (group.id == element.id) {
            children.push(std);
            itemsDelete.push(std.id);
          }
        });
      });
      this.dropGroups.push({
        id: element.id,
        name: element.name,
        logo: element.logo,
        children: children,
      });
    });
    itemsDelete.forEach((element) => {
      var index = this.$refs.dnditems.items.findIndex(function (item) {
        return item.id === element;
      });
      this.$refs.dnditems.items.splice(index, 1);
    });
  },
  data: function () {
    return {
      csrfToken: null,
      groupsNumber: 5,
      dropGroups: [],
      editGroups: false,
    };
  },
  components: {
    DragDrop,
    CustomCard,
  },
  methods: {
    createGroups(groupsNumber = null) {
      if (!groupsNumber) groupsNumber = this.groupsNumber;
      axios
        .post("/classroom/" + this.code + "/groups/create", {
          groupsNumber: groupsNumber,
        })
        .then((response) => {
          location.reload();
        });
    },
    save() {
      axios
        .patch("/classroom/" + this.code + "/groups/students", {
          _method: "patch",
          dropGroups: this.dropGroups,
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
        });
    },
    cancel() {
      location.reload();
    },
  },
};
</script>
