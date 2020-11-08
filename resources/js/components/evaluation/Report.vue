<template>
    <div class="w-100 content">
        <!--<download-excel style="display:inline" :data="jsonGrades">
          <b-button type="is-success m-2">
            <i class="fas fa-file-spreadsheet"></i>
          </b-button>
        </download-excel>-->
        <table class="grades has-background-light">
            <th>{{ trans.get('evaluation.student') }}</th>
            <th v-for="(tag,index) in grades[0].grades" :key="index + '-' + tag.id">
                {{ tag.name }}
                <br />
                ({{ tag.percent }} %)
            </th>
            <th>Total</th>
            <tr v-for="student in grades" :key="student.student_id">
                <td>{{ student.name }}</td>
                <td v-for="grade in student.grades" :key="grade.id">
                    <span v-if="admin || (settings.eval_type != 1 && settings.eval_type != 2)"><span :class="getGradeClass(getGrade(grade))" class="tag is-size-6">{{ getGrade(grade) }}</span></span>
                    <span v-if="settings.eval_type == 1">
                        <i :class="'fas ' + getEmoji(getGrade(grade)) + ' rateEmoji'"></i>
                    </span>
                    <span v-if="settings.eval_type == 2" class="tag" :class="getGradeClass(getGrade(grade))">
                        <i :class="'fas ' + getPassFail(getGrade(grade))"></i>
                    </span>
                </td>
                <td>
                    <span v-if="admin || (settings.eval_type != 1 && settings.eval_type != 2)">
                        <span :class="getGradeClass(finalGrade(student))" class="tag is-size-6">{{ finalGrade(student) }} / {{ settings.eval_max }}</span>
                    </span>
                    <span v-if="settings.eval_type == 1">
                        <i :class="'fas ' + getEmoji(finalGrade(student)) + ' rateEmoji'"></i>
                    </span>
                    <span v-if="settings.eval_type == 2" class="tag" :class="getGradeClass(finalGrade(student))">
                        <i :class="'fas ' + getPassFail(finalGrade(student))"></i>
                    </span>
                </td>
            </tr>
        </table>
        <button class="button is-dark noprint" @click="print">
            <i class="fas fa-print"></i>
        </button>
    </div>
</template>
<script>
    import Utils from "../../utils.js";

    export default {
        props: ["classroom", "grades", "settings", "admin"],
        created: function () {
        },
        data: function () {
            return {};
        },
        methods: {
            getGradeClass: function (grade) {
                return Utils.getGradeClass(grade, this.settings.eval_max);
            },
            getPassFail: function (grade) {
                return Utils.getPassFail(grade, this.settings.eval_max);
            },
            getEmoji: function (grade) {
                return Utils.getEmoji(grade, this.settings.eval_max);
            },
            getGrade: function (grade) {
                let totalGrades = 0;
                let totalWeight = 0;
                grade.evaluables.forEach(element => {
                    totalGrades += element.grade * element.pivot.weight
                    totalWeight += element.pivot.weight
                });
                if (totalGrades == 0) return 0;
                return (totalGrades / totalWeight).toFixed(2);
            },
            finalGrade: function (student) {
                let finalGrade = 0;
                student.grades.forEach((grade) => {
                    finalGrade += (this.getGrade(grade) * grade.percent) / 100;
                });
                return finalGrade.toFixed(2);
            },
        },
    };
</script>
