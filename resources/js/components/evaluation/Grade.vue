<template>
  <div class="w-100 p-2 content">
    <form @submit.prevent="save">
      <div v-for="student in students" :key="student.id">
        <div class="column is-flex align-items-center is-size-4">
          {{ student.name }}
        </div>

        <div class="columns">
          <div v-if="evaluable.type == 1" class="column is-narrow">
            <button class="button is-info" @click.prevent="loadRubric(student)">
              Rubric
            </button>
          </div>
          <div class="column is-narrow">
            <div class="field">
              <div class="control">
                <input
                  v-model="student.grade"
                  class="input"
                  step="0.01"
                  type="number"
                  min="0"
                  :max="settings.eval_max"
                  placeholder="Grade"
                />
              </div>
            </div>
          </div>
          <div class="column">
            <textarea
              v-model="student.feedback"
              class="input"
              placeholder="Feedback"
            ></textarea>
          </div>
          <hr style="background-color: black" />
        </div>
      </div>
      <button class="button is-primary mt-4">
        <i class="fas fa-save mr-3"></i>
        {{ trans.get("general.save") }}
      </button>
    </form>
    <b-loading
      :is-full-page="true"
      :active.sync="isLoading"
      :can-cancel="true"
    ></b-loading>

    <b-modal
      :active.sync="showRubric"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
      full-screen
      v-if="studentActive != null"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ studentActive.name }}</p>
        </header>
        <section class="modal-card-body">
          <div
            class="div_rounded rubricRow marginRadius"
            v-for="rubricRow in rubric.rows"
            :key="rubricRow.id"
          >
            <h2 class="description">{{ rubricRow.description }}</h2>
            <div class="rubricSubitems">
              <div
                class="rubricSubitem marginRadius"
                v-for="item in rubricRow.items"
                :key="item.id"
                :row="'row' + rubricRow.id"
                :item="'item' + item.id"
                @click="selectItem($event.target, rubricRow.id, item)"
              >
                <div class="rubricDetails">{{ item.description }}</div>
                <div class="rubricScore">{{ item.points }}</div>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button
            class="button"
            type="button"
            @click="
              studentActive = null;
              showRubric = false;
            "
          >
            Close
          </button>
          <input
            type="number"
            v-model="grade"
            class="input mr-3"
            style="width: 100px"
          />
          <button class="button is-primary" @click="gradeRubric">Grade</button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>
<script>
    export default {
        props: ["classroom", "evaluable", "students", "rubric", "settings"],
        created: function () { },
        data: function () {
            return {
                showRubric: false,
                studentActive: null,
                grade: null,
                rowsSelected: [],
                isLoading: false
            };
        },
        methods: {
            selectItem: function (target, row, item) {
                let element = document.querySelector("[item=item" + item.id + "]");
                document
                    .querySelectorAll("[row=row" + row + "]")
                    .forEach(function (rowItem) {
                        rowItem.classList.remove("selectedSubItem");
                    });

                element.classList.add("selectedSubItem");
                this.recalculate();
            },
            recalculate: function () {
                let total = 0;
                let totalSelected = 0;
                let totalOptional = 0;

                document
                    .querySelectorAll(
                        ".rubricSubitems:not([data-info=data-optional]) .rubricSubitem.selectedSubItem"
                    )
                    .forEach(function (rowItem) {
                        totalSelected += parseFloat(
                            rowItem.querySelector(".rubricScore").innerHTML
                        );
                    });

                document
                    .querySelectorAll(".rubricSubitems:not([data-info=data-optional])")
                    .forEach(function (row) {
                        var max = 0;
                        row.querySelectorAll(".rubricSubitem").forEach((item) => {
                            let score = parseFloat(
                                item.querySelector(".rubricScore").innerHTML
                            );
                            if (score > max) max = score;
                        });
                        total += max;
                    });

                // TODO optional rows
                // $('.rubricSubitems[data-info=data-optional]').find('.rubricSubitem.selectedSubItem').each(function(index){
                //     totalOptional += parseFloat($(this).find('.rubricScore').html());
                // });

      this.grade = Math.min(
        this.settings.eval_max,
        Math.round(
          ((totalSelected / total) * this.settings.eval_max + totalOptional) *
            100
        ) / 100
      );
    },
    loadRubric: function (student) {
      this.isLoading = true;
      this.grade = null;
      this.showRubric = true;
      this.studentActive = student;

      axios
        .post("/classroom/evaluation/student/rubric", {
          student: student.id,
          rubric: this.rubric.id,
          evaluable: this.evaluable.id,
        })
        .then((response) => {
          this.isLoading = false;
          response.data.forEach((row) => {
            document
              .querySelector("[row=row" + row[0] + "][item=item" + row[1] + "]")
              .classList.add("selectedSubItem");
            this.recalculate();
          });
        });
    },
    gradeRubric: function () {
      var elem = this;
      document.querySelectorAll(".selectedSubItem").forEach(function (item) {
        elem.rowsSelected.push([
          item.getAttribute("row").replace("row", ""),
          item.getAttribute("item").replace("item", ""),
        ]);
      });
      axios
        .post(
          "/classroom/evaluation/" + this.evaluable.id + "/evaluate/rubric",
          {
            student: this.studentActive.id,
            rows: this.rowsSelected,
            evaluable: this.evaluable.id,
          }
        )
        .then((response) => {
          this.studentActive.grade = this.grade;
          this.studentActive = null;
          this.showRubric = false;
          this.rowsSelected = [];
        });
    },
    save: function () {
      axios
        .post("/classroom/evaluation/" + this.evaluable.id + "/evaluate", {
          grades: this.students,
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
        });
    },
  },
  components: {},
};
</script>
