<template>
  <div class="p-2">
    <create-roles v-if="!roles.length"></create-roles>
    <div v-else>
      <div>
        <button class="button is-primary" @click="showAssign">
          {{ trans.get("roles.assign") }}
        </button>
        <button class="button is-danger" @click="removeAssign">
          {{ trans.get("roles.delete") }}
        </button>
        <button
          class="button is-info ml-1"
          v-if="roles.length < 16"
          @click.prevent="importDefault"
        >
          {{ trans.get("roles.import_default") }}
        </button>
        <import-from-class :code="code" import-type="roles"></import-from-class>
      </div>
      <div class="columns is-multiline is-variable mt-3">
        <show-role
          v-for="role in roles"
          :key="role.id"
          :code="code"
          :edit="true"
          :role="role"
        ></show-role>
        <button class="button mx-3 my-2" @click="addRole">
          <i class="fas fa-plus mr-2"></i> {{ trans.get("roles.add") }}
        </button>
      </div>
      <b-modal
        :active.sync="isAssignModalActive"
        has-modal-card
        full-screen
        :can-cancel="false"
      >
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">{{ trans.get("roles.assign") }}</p>
          </header>
          <section class="modal-card-body is-relative">
            <article class="message is-warning" v-if="groups && groups.length">
              <div class="message-body">
                {{ trans.get("roles.type_info") }}
                <br /><b-switch
                  v-model="typeMode"
                  class="mt-2"
                  @input="toggleMode"
                  passive-type="is-primary"
                  type="is-info"
                >
                  {{
                    typeMode
                      ? trans.get("roles.type_group")
                      : trans.get("roles.type_class")
                  }}
                </b-switch>
              </div>
            </article>
            <div v-if="!typeMode">
              <button class="button is-dark" @click="randomAssign">
                <i class="fas fa-random mr-2"></i
                >{{ trans.get("groups.random") }}
              </button>
              <div
                class="columns my-1"
                v-for="role in roles"
                :key="'ra-' + role.id"
              >
                <div
                  class="
                    column
                    is-narrow
                    py-0
                    card-shadow-s
                    rounded-left
                    has-background-light
                  "
                >
                  <figure class="image is-128x128">
                    <img
                      class="p-2 card-shadow-s is-full-rounded"
                      :src="role.image"
                    />
                  </figure>
                </div>
                <div
                  class="column card-shadow-s rounded-left has-background-light"
                >
                  <div class="select">
                    <!-- <select v-model="rolesAssign[role.id]"> -->
                    <select
                      v-model="rolesAssign[role.id]"
                      @input="selectValue(role.id, $event.target.value)"
                    >
                      <option></option>
                      <option
                        v-for="(student, index) in students"
                        :key="index + '-' + student.id"
                        :value="student.id"
                      >
                        {{ student.name }}
                      </option>
                    </select>
                  </div>
                  <div>
                    <h2 class="is-size-4 my-1">{{ role.title }}</h2>
                    <p class="mt-1">{{ role.description }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="columns is-multiline is-variable is-1 my-2" v-else>
              <div
                class="
                  column
                  p-2
                  content
                  is-6-tablet is-12-mobile is-6-desktop is-4-fullhd
                "
                v-for="group in groups"
                v-bind:key="'g-' + group.id"
                ref="wrapper"
              >
                <div class="card rounded p-2">
                  <h2>
                    <img
                      :src="group.logo"
                      class="is-relative is-full-rounded border"
                      style="top: 5px; left: 2px"
                      :class="{
                        'has-background-dark':
                          group.logo == '/img/no_group_avatar.png',
                      }"
                      width="30px"
                    />
                    {{ group.name }}
                  </h2>
                  <button class="button is-dark" @click="randomGAssign(group)">
                    <i class="fas fa-random mr-2"></i
                    >{{ trans.get("groups.random") }}
                  </button>
                  <div>
                    <div
                      class="columns my-1 mx-0"
                      v-for="role in roles"
                      :key="'ra-' + role.id"
                    >
                      <div
                        class="
                          column
                          is-narrow
                          py-0
                          card-shadow-s
                          rounded-left
                          has-background-light
                        "
                      >
                        <figure class="image is-128x128">
                          <img
                            class="p-2 card-shadow-s is-full-rounded"
                            :src="role.image"
                          />
                        </figure>
                      </div>
                      <div
                        class="
                          column
                          card-shadow-s
                          rounded-left
                          has-background-light
                        "
                      >
                        <div class="select">
                          <!-- <select v-model="rolesAssign[role.id]"> -->
                          <select
                            v-if="Object.keys(rolesAssign).length"
                            v-model="rolesAssign[group.id][role.id]"
                            @input="
                              selectValueG(
                                group.id,
                                role.id,
                                $event.target.value
                              )
                            "
                          >
                            <option></option>
                            <option
                              v-for="(student, index) in group.students"
                              :key="index + '-' + student.id"
                              :value="student.id"
                            >
                              {{ student.name }}
                            </option>
                          </select>
                        </div>
                        <div>
                          <h2 class="is-size-4 my-1">{{ role.title }}</h2>
                          <p class="mt-1">{{ role.description }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <footer
            class="modal-card-foot columns is-multiline"
            style="overflow-x: auto"
          >
            <div class="column is-narrow is-12-mobile is-flex has-all-centered">
              <button
                class="button"
                type="button"
                @click="isAssignModalActive = false"
              >
                {{ trans.get("general.close") }}
              </button>
              <button class="button is-success" @click="accept(false)">
                <i class="fas fa-save mr-2"></i>
                {{ trans.get("general.save") }}
              </button>
              <button class="button is-success" @click="accept(true)">
                <i class="fas fa-save mr-1"></i
                ><i class="fas fa-paper-plane mr-2"></i>
                {{ trans.get("general.save_notify") }}
              </button>
            </div>
          </footer>
        </div>
      </b-modal>
    </div>
    <!-- <show-role
        v-for="role in roles"
        :key="role.id"
        :code="code"
        :edit="false"
        :role="role"
      ></show-role> -->
  </div>
</template>

<script>
const ImportFromClass = () => import("../utils/ImportFromClass.vue");

export default {
  props: ["roles", "code"],
  created() {},
  data: function () {
    return {
      isAssignModalActive: false,
      students: [],
      rolesAssign: {},
      typeMode: false,
      groups: [],
    };
  },
  methods: {
    importDefault() {
      axios
        .get("/classroom/" + this.code + "/roles/default")
        .then((response) => {
          location.reload();
        });
    },
    toggleMode() {
      axios.patch("/classroom/" + this.code + "/setting", {
        _method: "patch",
        prop: "role_assign",
        action: "update",
        value: this.typeMode ? "group" : "classroom",
      });
      this.rolesAssign = {};
      this.removeAssign();
      this.showAssign();
      this.$forceUpdate();
    },
    selectValueG(group, id, value) {
      this.rolesAssign[group][id] = parseInt(value);
      this.$forceUpdate();
    },
    selectValue(id, value) {
      this.rolesAssign[id] = parseInt(value);
      this.$forceUpdate();
    },
    removeAssign() {
      axios.delete(`/classroom/${this.code}/roles/remove`).then((response) => {
        this.$toast(this.trans.get("success_error.update_success"), {
          type: "success",
        });
      });
    },
    accept(notify) {
      axios
        .post(`/classroom/${this.code}/roles/accept`, {
          roles: this.rolesAssign,
        })
        .then((response) => {
          if (notify) {
            if (!this.typeMode) {
              Object.keys(this.rolesAssign).forEach((value) => {
                if (value) {
                  var index = this.roles.findIndex(function (item) {
                    return item.id == value;
                  });
                  axios
                    .post("/classroom/" + this.code + "/push", {
                      message:
                        this.trans.get("roles.assign_notify") +
                        " " +
                        this.roles[index].title,
                      id: this.rolesAssign[value],
                    })
                    .then((response) => {});
                }
              });
            } else {
              Object.keys(this.rolesAssign).forEach((group) => {
                Object.keys(this.rolesAssign[group]).forEach((value) => {
                  if (value) {
                    var index = this.roles.findIndex(function (item) {
                      return item.id == value;
                    });
                    axios
                      .post("/classroom/" + this.code + "/push", {
                        message:
                          this.trans.get("roles.assign_notify") +
                          " " +
                          this.roles[index].title,
                        id: this.rolesAssign[group][value],
                      })
                      .then((response) => {});
                  }
                });
              });
            }
          }
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
          this.isAssignModalActive = false;
        });
    },
    randomGAssign(group) {
      // this.groups.forEach((group) => {
      this.rolesAssign[group.id] = {};
      var studentsRand = _.shuffle(group.students);
      _.shuffle(this.roles).forEach((role) => {
        if (studentsRand.length)
          this.rolesAssign[group.id][role.id] = studentsRand.shift().id;
      });
      // });
      this.$forceUpdate();
    },
    randomAssign() {
      var studentsRand = _.shuffle(this.students);
      this.rolesAssign = {};
      _.shuffle(this.roles).forEach((role) => {
        if (studentsRand.length)
          this.rolesAssign[role.id] = studentsRand.shift().id;
      });
      this.$forceUpdate();
    },
    showAssign() {
      axios.get(`/classroom/${this.code}/roles/info`).then((response) => {
        this.typeMode = response.data.type == "classroom" ? false : true;
        this.students = response.data.students;
        this.groups = response.data.groups;
        if (Object.keys(response.data.roles).length) {
          this.rolesAssign = response.data.roles;
        } else {
          this.rolesAssign = {};
          if (this.typeMode) {
            this.groups.forEach((element) => {
              this.rolesAssign[element.id] = {};
            });
          }
        }

        this.isAssignModalActive = true;
      });
    },
    addRole() {
      axios.post(`/classroom/${this.code}/role/add`).then((response) => {
        this.roles.push(response.data);
        this.$forceUpdate();
      });
    },
  },
  components: {
    ImportFromClass,
  },
};
</script>