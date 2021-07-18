<template>
  <div class="box card-shadow-s mb-3" :class="{'has-background-story' : !post.is_teacher, 'has-background-white-ter' : post.is_teacher }">
    <section class="media">
      <div class="media-content is-relative">
        <div class="challenge-category has-background-light">
          <i class="fad" :class="{ 'fa-file-alt' : !post.is_teacher, 'fa-user-graduate' : post.is_teacher }"></i>
        </div>
        <!-- <span
          @click="copyPermalink"
          v-if="admin"
          v-tippy
          :content="trans.get('challenges.permalink')"
          class="button top-right custom cursor-pointer"
          style="top: 0; right: 0"
        >
          <i class="fad fa-link"></i>
          <span class="ml-2 is-hidden-mobile">Permalink</span>
        </span> -->
        <div class="content">
          <h1 class="is-flex is-center-vertically">
            {{ post.title }}

            <span class="tag is-dark ml-2">
              {{ getDate(post.date) }}</span
            >
          </h1>

          <div v-html="getContent(post.content)"></div>
          <div class="mt-3">
            <span v-if="post.student" class="is-italic is-flex is-center-vertically"><img width="16px" height="16px" :src="post.student.avatar" class="mr-2"> {{ post.student.name }}</span>
          </div>
          <div class="mt-3">
            <small v-if="post.last_edit" class="is-italic">Edit: {{ post.last_edit }} {{ getDateFrom(post.updated_at) }}</small>
          </div>
        </div>
        <div class="has-text-right">
          <button class="button is-dark is-outlined" v-if="(!post.student_id && (!post.is_teacher || (admin && post.is_teacher))) || (post.student_id && (post.student_id == $parent.student.id || admin))" @click="editPost(post)">
            <i class="fad fa-edit"></i> {{ trans.get("general.edit") }}
          </button>
          <button class="button is-danger is-outlined" v-if="(!post.student_id && (!post.is_teacher || (admin && post.is_teacher))) || (post.student_id && (post.student_id == $parent.student.id || admin))" @click="deletePost(post.id)">
            <i class="fad fa-trash-alt"></i> {{ trans.get("general.delete") }}
          </button>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Utils from "../../utils.js";

// const InputEmoji = () => import("../utils/InputEmoji.vue");

export default {
  props: ["post" , "code", "admin"],
  created: function () {},
  mounted: function () {
  },
  data: function () {
    return {};
  },
  components: {},
  methods: {
    getDate(date) {
      return Utils.getDate(date);
    },
    getDateFrom(date) {
      return Utils.getDateFrom(this.post.updated_at, this.trans.locale);
    },
    editPost(post) {
      this.$parent.editor = false;
      this.$parent.edit = post.id
      this.$parent.content = post.content
      this.$parent.title = post.title
      this.$parent.modal = true
      this.$parent.editor = true;
    },
    deletePost(id) {
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
            .delete("/classroom/" + this.code + "/post/" + id)
            .then((response) => {
              this.$parent.load(this.$parent.$data.blogSelected);
            });
        },
      });
    },
    getContent(content) {
      return Utils.replaceSpecial(content);
    },
  },
  computed: {},
};
</script>
<style>
.name-student {
  position: absolute;
  top: 5px;
  right: 5px;
  width: 32px;
  height: 32px;
}
</style>
