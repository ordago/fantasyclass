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
                __ Los roles por defecto son roles de clase, si quieres hacer
                que los roles sean de grupo, lo puedes configurar aquí:
                <br /><b-switch
                  v-model="typeMode"
                  class="mt-2"
                  passive-type="is-primary"
                  type="is-info"
                >
                  {{ typeMode ? "__Roles de grupo" : "__Roles de classe" }}
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
              <button class="button is-success" @click="accept">
                <i class="fas fa-save mr-2"></i>
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
export default {
  props: ["roles", "code"],
  created() {},
  data: function () {
    return {
      isAssignModalActive: false,
      students: [],
      typeR: null,
      rolesAssign: {},
      typeMode: false,
      groups: [],
    };
  },
  methods: {
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
    accept() {
      axios
        .post(`/classroom/${this.code}/roles/accept`, {
          roles: this.rolesAssign,
        })
        .then((response) => {
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
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
          this.isAssignModalActive = false;
        });
    },
    randomAssign() {
      var studentsRand = _.shuffle(this.students);
      this.rolesAssign = {};
      this.roles.forEach((element) => {
        this.rolesAssign[element.id] = studentsRand.shift().id;
      });
      this.$forceUpdate();
    },
    showAssign() {
      axios.get(`/classroom/${this.code}/roles/info`).then((response) => {
        this.typeR = response.data.type;
        this.students = response.data.students;
        this.groups = response.data.groups;
        if (Object.keys(response.data.roles).length)
          this.rolesAssign = response.data.roles;
        else this.rolesAssign = {};
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
};
</script>