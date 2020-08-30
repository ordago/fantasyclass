<template>
  <div class="w-100 content">
    <table>
      <th>Student name</th>
      <th v-for="(tag,index) in grades[0].grades" :key="index + '-' + tag.id">
        {{ tag.name }}
        <br />
        ({{ tag.percent }} %)
      </th>
      <th>Total</th>
      <tr v-for="student in grades" :key="student.student_id">
        <td>{{ student.name }}</td>
        <td v-for="grade in student.grades" :key="grade.id">{{ grade.grade }}</td>
        <td>{{ finalGrade(student) }} / {{ settings.eval_max }}</td>
      </tr>
    </table>
    <button class="button is-dark noprint" @click="print"><i class="fas fa-print"></i></button>
  </div>
</template>
<script>
export default {
  props: ["classroom", "grades", "settings"],
  created: function () {},
  data: function () {
    return {};
  },
  methods: {
    finalGrade: function (student) {
      let finalGrade = 0;
      student.grades.forEach((grade) => {
        finalGrade += (grade.grade * grade.percent) / 100;
      });
      return finalGrade;
    },
  },
};
</script>
<style lang="scss" scoped>
th {
  background-color: black;
  color: white !important;
  text-align: center !important;
  vertical-align: middle !important;
}
td {
  text-align: center !important;
}
@media print {
   .noprint {
      visibility: hidden;
   }
}
</style>