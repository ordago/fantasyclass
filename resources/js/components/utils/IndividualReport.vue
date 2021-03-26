<template>
  <div class="p-2">
    <div class="" style="width: auto">
      <section class="is-relative content scroll-y" id="print">
        <button class="button is-dark noprint" @click="print">
          <i class="fas fa-print"></i>
        </button>
        <h1 class="is-size-1 mt-1">{{ student.name }}</h1>
        <h3 class="is-size-4">{{ trans.get("menu.evaluation") }}</h3>

        <report
          :individual="true"
          :classroom="classroom"
          :admin="true"
          :grades="student.evaluation"
          :settings="student.classSettings"
        ></report>
        <table class="grades has-background-light">
          <th>{{ trans.get("evaluation.description") }}</th>
          <th>{{ trans.get("evaluation.grade_number") }}</th>
          <th>{{ trans.get("evaluation.tags") }}</th>
          <th>{{ trans.get("evaluation.feedback") }}</th>
          <tr v-for="(grade, index) in student.grades" :key="index">
            <td>{{ grade.description }}</td>
            <td>
              <span
                v-if="
                  student.classSettings.eval_type != 1 &&
                  student.classSettings.eval_type != 2
                "
              >
                <span
                  v-if="grade.type == 1 && grade.rubric_id"
                  class="cursor-pointer"
                  @click="loadRubric(grade.rubric_id)"
                >
                  <span
                    class="tag is-size-6"
                    :class="{
                      'is-success':
                        grade.pivot.grade >= student.classSettings.eval_max / 2,
                      'is-danger':
                        grade.pivot.grade < student.classSettings.eval_max / 2,
                    }"
                    ><i class="fas fa-external-link-alt mr-2"></i>
                    {{ grade.pivot.grade }}</span
                  >
                </span>

                <span
                  v-else
                  class="tag is-size-6"
                  :class="{
                    'is-success':
                      grade.pivot.grade >= student.classSettings.eval_max / 2,
                    'is-danger':
                      grade.pivot.grade < student.classSettings.eval_max / 2,
                  }"
                  >{{ grade.pivot.grade }}</span
                >
              </span>

              <span v-if="student.classSettings.eval_type == 1">
                <i
                  :class="'fas ' + getEmoji(grade.pivot.grade) + ' rateEmoji'"
                ></i>
              </span>
              <span
                v-if="student.classSettings.eval_type == 2"
                class="tag"
                :class="{
                  'is-success':
                    grade.pivot.grade >= student.classSettings.eval_max / 2,
                  'is-danger':
                    grade.pivot.grade < student.classSettings.eval_max / 2,
                }"
              >
                <i :class="'fas ' + getPassFail(grade.pivot.grade)"></i>
              </span>
            </td>
            <td>
              <span
                v-for="(tag, index) in grade.tags"
                class="tag is-dark cursor-default mx-1"
                v-tippy
                :content="
                  tag.description +
                  ' (' +
                  trans.get('evaluation.weight') +
                  ': ' +
                  tag.pivot.weight +
                  ')'
                "
                :key="index"
                >{{ tag.short }}</span
              >
            </td>
            <td>{{ grade.pivot.feedback }}</td>
          </tr>
        </table>
        <h3 class="is-size-4" v-if="student.badges && student.badges.length">
          {{ trans.get("menu.badges") }}
        </h3>
        <div class="is-flex">
          <ShowBadge
            v-for="badge in student.badges"
            :key="badge.id"
            :student="student"
            :badge="badge"
            :admin="false"
          ></ShowBadge>
        </div>
        <div v-if="student.behaviours && student.behaviours.length">
          <div class="page-break"></div>
          <h3 class="is-size-4">{{ trans.get("menu.behaviours") }} {{ student.name }}</h3>
          <show-data
            :info="student.behaviours"
            :admin="false"
            type="behaviours"
          >
          </show-data>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
// import Utils from "../../utils.js";
import ShowBadge from "../badge/ShowBadge.vue";

export default {
  props: ["student", "classroom"],
  created() {},
  data: function () {
    return {};
  },
  methods: {},
  components: {
    ShowBadge,
  },
};
</script>
<style>
body {
  /* overflow: auto !important; */
  height: auto !important;
  -webkit-print-color-adjust: exact;
}
.page-break {
  display: none;
}
@media print {
  .page-break {
    display: block;
    page-break-before: always;
    margin-bottom: 10px;
  }
  body, .has-background-white-ter {
    background-color: white!important;
  }
}
</style>