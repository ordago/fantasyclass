<template>
  <div class="m-0">
    <div class="">
      <div
        class="column py-2 px-0 w-100"
        v-for="group in groups"
        v-bind:key="group.id"
      >
        <div class="card rounded card-shadow-s w-100">
          <div
            class="p-4"
          >
            <h1 class="is-size-2 mb-4">{{ group.name }}</h1>
            <div class="">
            <div class="columns is-multiline is-variable is-1 my-2">
              <div
                class="column py-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
                v-for="student in getStudents(group.id)"
                v-bind:key="student.id"
              >               
                <show-student-teacher :behaviours="behaviours" :behaviourshidden="behaviourshidden" :student="student" :classroom="classroom"></show-student-teacher>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["students", "classroom", "groups", "behaviours", "behaviourshidden"],
  created() {
  },
  data: function () {
    return { 
    };
  },
  methods: {
    getStudents: function(group) {
        return this.students.filter(student => student.groups.length && student.groups[0].id === group);
    }
  },
  computed: {},
};
</script>
