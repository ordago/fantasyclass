<template>
    <div class="w-100 content">
        <button class="button is-dark noprint" @click="print">
            <i class="fas fa-print"></i>
        </button>
        <button class="button is-dark noprint" @click="exportReport" formtarget="_blank">
            <i class="fas fa-file-excel"></i>
        </button>
        <table class="grades has-background-light mt-3" id="evaluationReport">
            <th>{{ trans.get('evaluation.student') }}</th>
            <th v-for="(tag,index) in grades[0].grades" :key="index + '-' + tag.id">
                {{ tag.name }}
                <br />
                ({{ tag.percent }} %)
            </th>
            <th>Total</th>
            <tbody>
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
            </tbody>
        </table>
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
            exportReport: function () {
                const table = document.getElementById('evaluationReport');
                const columns = table.getElementsByTagName("th");
                const rows = table.getElementsByTagName("tr");
                var headings = [];
                var elements = new Array();

                for (var n = 0; n < columns.length; n++) {
                    var innerHtml = columns[n].innerHTML;
                    // Remove Html Tags
                    var header = innerHtml.replace(/(<([^>]+)>)/gi, "");

                    // Remove break lines
                    header = header.replace(/(\r\n|\n|\r)/gm, "");

                    // Remove whitespaces
                    header = header.replace(/\s{2,}/g, "");
                    headings.push(header.trim());
                }

                for (var n = 0; n < rows.length; n++) {
                    var values = [];
                    var row = rows[n];
                    var cells = row.cells;
                    for (var cont = 0; cont < cells.length; cont++) {
                        var innerHtml = cells[cont].innerHTML;
                        // Remove Html Tags
                        var value = innerHtml.replace(/(<([^>]+)>)/gi, "");

                        // Remove break lines
                        value = value.replace(/(\r\n|\n|\r)/gm, "");

                        values.push(value.trim());
                    }

                    elements.push(values);
                }

                axios
                    .post('/classroom/evaluation/exportEvaluationReport/', {
                        headings: headings,
                        values: elements
                    }, {
                        responseType: 'blob'
                    }).then((response) => {
                        const blob = new Blob([response.data], { type: response.data.type });
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);

                        const contentDisposition = response.headers['content-disposition'];
                        let fileName = 'unknown';
                        if (contentDisposition) {
                            const fileNameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            const matches = fileNameRegex.exec(contentDisposition);
                            if (matches != null && matches[1]) {
                                fileName = matches[1].replace(/['"]/g, '');
                            }
                        }

                        link.download = fileName;
                        link.click();
                        URL.revokeObjectURL(link.href);
                    });
            }
        },
    };
</script>
