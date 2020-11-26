<template>
  <div class="columns p-2">
    <div class="column is-narrow pr-0" style="min-width: 400px">
      <article class="panel is-info">
        <p
          class="panel-heading is-flex has-space-between align-items-center p-3"
        >
          <span>{{ trans.get("challenges.categories") }}</span>
          <button
            class="button"
            @click="activeAddBank = !activeAddBank"
            v-html="buttonAddGroup"
          ></button>
        </p>
        <div
          class="panel-block is-flex is-flex-column p-0"
          style="align-items: flex-start"
        >
          <div
            @click="
              getQuestions();
              activeBank = {title: 'Without category'};
            "
            class="highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer pl-1 pr-4 py-3"
          >
            <span class="p-2">
              <span class="panel-icon">
                <i class="fad fa-books" style="color: #ccc"></i>
              </span>
              <span> Without category </span>
            </span>
            <span class="p-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
        </div>
        <div
          class="panel-block is-flex is-flex-column p-0"
          style="align-items: flex-start"
          v-for="questionB in banks"
          v-bind:key="questionB.id"
        >
          <div
            @click="
              getQuestions(questionB.id);
              activeBank = questionB;
            "
            class="highlight-arrow is-flex has-space-between w-100 is-fullwidth cursor-pointer pl-1 pr-4 py-3"
          >
            <span class="p-2">
              <span class="panel-icon">
                <i class="fad fa-books"></i>
              </span>
              <span :title="questionB.title">
                {{
                  questionB.title.length > 30
                    ? questionB.title.substring(0, 30) + "..."
                    : questionB.title
                }}
                <!-- <b-tag type="is-info is-light" class="has-small-font">{{ question.numquestions }}</b-tag> -->
              </span>
            </span>
            <span class="p-2 arrow rounded-right">
              <i class="fal fa-angle-right"></i>
            </span>
          </div>
        </div>
      </article>
    </div>
    <div class="column pr-0">
      <b-loading
        :is-full-page="true"
        :active.sync="isLoading"
        :can-cancel="false"
      ></b-loading>

      <CreateQuestionBank :code="code" edit-bank="" v-if="activeAddBank" />

      <ShowQuestions
        :code="code"
        :bank="activeBank"
        :questions="questions"
        v-if="!activeAddBank && activeBank && !isLoading"
      ></ShowQuestions>

    </div>
  </div>
</template>

<script>
// import Utils from "../../utils.js";
import CreateQuestionBank from "./CreateQuestionBank.vue";
import ShowQuestions from "./ShowQuestions.vue";

CreateQuestionBank;

export default {
  props: ["code", "banks"],
  created() {},
  data: function () {
    return {
      activeAddBank: false,
      activeBank: false,
      updated: false,
      questions: [],
      isLoading: false,
    };
  },
  methods: {
    getQuestions(bank = null) {
      if(!bank) {
        // That is whithout category, just for clarify
        bank = "wc";
      }
      axios
        .get("/classroom/" + this.code + "/questions/" + bank)
        .then((response) => {
          this.questions = response.data;
          console.log(response.data);
        });
    },
  },
  components: {
    CreateQuestionBank,
    ShowQuestions,
  },
  computed: {
    buttonAddGroup() {
      return this.activeAddBank
        ? this.trans.get("general.cancel")
        : "<i class='far fa-plus pr-2'></i>" +
            this.trans.get("challenges.add_category");
    },
  },
};
</script>