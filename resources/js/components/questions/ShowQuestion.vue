<template>
  <div class="box card-shadow-s mb-3 is-relative">
    <h1 class="fs-1-2">
      <i
        class="fas is-light tag is-link"
        :class="{
          'fa-text': question.type == 2,
          'fa-list': question.type == 1,
        }"
      ></i>
      {{ question.name }}
    </h1>
    <div class="mt-2" v-if="question.type == 1">
      <span v-for="(option, index) in question.options" :key="index">
        <span
          class="tag is-light p-2 mr-1"
          :class="{
            'is-success': option.answer.id == question.options[0].correctAnswer,
            'is-danger': option.answer.id != question.options[0].correctAnswer,
          }"
          v-if="option.answer"
          >{{ option.answer.text }}</span
        >
      </span>
    </div>
    <div class="mt-2" v-else-if="question.type == 2">
      <span>{{ trans.get("questions.accepted") }}: </span>
      <span v-for="(option, index) in question.options" :key="index">
        <span class="tag p-4 pr-0 border rounded is-light mr-1 is-success">
          "{{ option.answer }}"
          <small
            v-tippy
            :content="trans.get('questions.case_sensitive')"
            class="
              border
              px-1
              rounded
              has-background-dark has-text-light
              mr-1
              is-dark
            "
            v-if="option.caseSensitive"
            ><i class="fal fa-font-case"></i>
          </small>
        </span>
      </span>
    </div>
    <div class="delete-button-right p-2">
      <small>
        <img :src="question.image" v-if="question.image" width="80px" v-tippy :content="'<img src=\'' + question.image + '\'>'">
        <button class="button" :class="{ 'is-info' : question.image, 'is-success': !question.image }" @click="isModalActive = true">
          <i class="fas fa-plus mr-1" v-if="!question.image"></i>
          <i class="fas fa-edit mr-1" v-else></i>
          <i class="far fa-image"></i>
        </button>
        <!-- <button
          class="button"
          v-on:click.prevent="clone(question)"
        >
          <i class="far fa-clone"></i>
        </button> -->
        <button class="button is-danger" v-on:click.prevent="deleteQuestion()">
          <i class="far fa-trash"></i>
        </button>
      </small>
    </div>
    <b-modal :active.sync="isModalActive" has-modal-card :can-cancel="false">
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            {{ trans.get("students.select_image_title") }}
          </p>
        </header>
        <section class="modal-card-body is-relative mb-2">
          <croppa
            v-model="image"
            :width="600"
            :height="300"
            accept="image/*"
            placeholder="📷 Image"
            :placeholder-font-size="16"
            canvas-color="transparent"
            :show-remove-button="true"
            remove-button-color="black"
            :show-loading="true"
            :loading-size="50"
            :initial-image="prevImage"
            class="rounded"
          ></croppa>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow">
            <button class="button" type="button" @click="isModalActive = false">
              {{ trans.get("general.close") }}
            </button>
            <button class="button is-success" type="button" @click="addImage">
              {{ trans.get("general.accept") }}
            </button>
          </div>
        </footer>
      </div>
    </b-modal>
  </div>
</template>
<script>
import confetti from "canvas-confetti";
import Utils from "../../utils.js";

export default {
  props: ["code", "question"],
  created: function () {
    if (this.question.image) this.prevImage = this.question.image;
  },
  data: function () {
    return {
      isModalActive: false,
      image: null,
      prevImage: null,
    };
  },
  methods: {
    clone(question) {
      // this.$parent.question = question;
      // this.$parent.modal = true;
    },

    addImage() {
      this.image.generateBlob(
        (blob) => {
          let formData = new FormData();
          if(blob)
            formData.append("image", blob, "question.png");
          formData.append("question_id", this.question.id);
          axios
            .post("/classroom/question/addImage", formData, {
              headers: {
                "content-type": "multipart/form-data",
              },
            })
            .then((response) => {
              this.question.image = response.data.image;
              this.prevImage = this.question.image;
              this.$forceUpdate();
              this.$toast(this.trans.get('success_error.update_success'), { type: "success" });
              this.isModalActive = false;
              // location.reload();
            });
        },
        "image/png",
        0.8
      );
    },
    deleteQuestion() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios
            .delete("/classroom/questions/" + this.question.id)
            .then((response) => {
              let bank = this.question.question_bank_id
                ? this.question.question_bank_id
                : "wc";
              this.$parent.$parent.getQuestions(bank);
            });
        },
      });
    },
  },
};
</script>
