<template>
  <div class="p-1 m-1">
    <div>
      <span
        @click="toggleBlog(blogp.id, 2)"
        v-for="blogp in blogsp"
        :key="blogp.id"
      >
        <div
          v-if="!blogSelected || blogSelected == blogp.id"
          class="card rounded p-5 my-2 cursor-pointer"
        >
          <span class="p-1"><i class="fad fa-users-class"></i></span>
          <span class="p-2"
            ><i class="fad fa-feather-alt" v-if="!blogSelected"></i
            ><i class="fad fa-arrow-left" v-if="blogSelected"></i
          ></span>
          {{ blogp.name }}
        </div>
      </span>
    </div>
    <article class="message is-dark" v-if="!blogs.length">
      <div class="message-body">{{ trans.get("blog.blog_empty") }}</div>
    </article>
    <div>
      <button
        class="button is-primary"
        v-if="!blogSelected"
        @click="createBlog(0)"
      >
        {{ trans.get("blog.new_blog") }}
      </button>
      <button
        class="button is-secondary"
        v-if="!blogSelected"
        @click="createBlog(1)"
      >
        <i class="fas fa-users"></i> {{ trans.get("blog.new_blog_g") }}
      </button>
      <span
        @click="toggleBlog(blog.id)"
        v-for="blog in student.groups[0].blogs"
        :key="'gb-' + blog.id"
      >
        <div
          v-if="(!blogSelected || blogSelected == blog.id)"
          class="card rounded p-5 my-2 cursor-pointer"
        >
          <span class="p-2"
            ><i class="fad fa-feather-alt" v-if="!blogSelected"></i
            ><i class="fad fa-arrow-left" v-if="blogSelected"></i
          ></span>
          <i class="fas fa-users"></i> {{ blog.name }}
        </div>
      </span>
      <span
        @click="toggleBlog(blog.id)"
        v-for="blog in orderedBlogs"
        :key="blog.id"
      >
        <div
          v-if="(!blogSelected || blogSelected == blog.id) && blog.public != 1"
          class="card rounded p-5 my-2 cursor-pointer"
        >
          <span class="p-2"
            ><i class="fad fa-feather-alt" v-if="!blogSelected"></i
            ><i class="fad fa-arrow-left" v-if="blogSelected"></i
          ></span>
          {{ blog.name }}
        </div>
      </span>
    </div>
    <div class="" v-if="blogSelected">
      <button
        class="button is-danger mb-2"
        @click="deleteBlog"
        v-if="!stories.length && !admin && type != 2"
      >
        <i class="fad fa-trash-alt"></i> {{ trans.get("general.delete") }}
      </button>
      <article class="message is-link mb-2" v-if="type == 2">
        <div class="message-body">
          {{ trans.get("blog.class_blog") }}
        </div>
      </article>
      <article class="message is-link mb-2" v-else-if="!stories.length">
        <div class="message-body">
          {{ trans.get("blog.empty_posts") }}.
          {{ trans.get("blog.write_post") }}
        </div>
      </article>
      <button class="button is-link mt-0 mb-2" @click.prevent="writePost">
        {{ trans.get("blog.write_post") }}
      </button>
      <div v-if="stories.length && blogSelected">
        <ShowPost
          v-for="post in stories"
          :code="code"
          :post="post"
          :key="post.id"
          :admin="admin"
        >
        </ShowPost>
      </div>
    </div>
    <b-modal :active.sync="modal" has-modal-card full-screen>
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("blog.write_post") }}</p>
        </header>
        <section class="modal-card-body">
          <b-field :label="trans.get('blog.title')">
            <b-input v-model="title"></b-input>
          </b-field>
          <b-field :label="trans.get('blog.content')">
            <Editor
              v-model="content"
              v-if="editor"
              height="60vh"
              :code="code"
            ></Editor>
          </b-field>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="modal = false">
            {{ trans.get("general.close") }}
          </button>
          <button
            class="button is-primary"
            @click="sendPost"
            :disabled="title == '' || content == ''"
            v-if="!edit"
          >
            {{ trans.get("general.add") }}
          </button>
          <button
            class="button is-link"
            @click="editPost"
            v-else
            :disabled="title == '' || content == null"
          >
            {{ trans.get("general.edit") }}
          </button>
        </footer>
      </div>
    </b-modal>
    <b-loading
      :is-full-page="true"
      :active.sync="isLoading"
      :can-cancel="false"
    ></b-loading>
  </div>
</template>
<script>
const ShowPost = () => import("./ShowPost.vue");
const Editor = () => import("../utils/Editor.vue");

export default {
  props: ["blogs", "code", "admin", "student", "blogsp"],
  components: {
    ShowPost,
    Editor,
  },
  mounted: function () {
    this.editor = true;
  },
  data: function () {
    return {
      isLoading: false,
      editor: false,
      edit: null,
      content: ``,
      blogSelected: null,
      stories: [],
      modal: false,
      type: 0,
      title: "",
    };
  },
  methods: {
    editPost() {
      let student = null;
      if (this.admin) student = this.student.id;
      axios
        .patch("/classroom/" + this.code + "/post", {
          id: this.edit,
          content: this.content,
          title: this.title,
          student: student,
        })
        .then((response) => {
          this.modal = false;
          this.load(this.blogSelected);
        });
    },
    deleteBlog(index) {
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
            .delete("/classroom/" + this.code + "/blog/" + this.blogSelected)
            .then((response) => {
              this.blogs = response.data;
              this.blogSelected = null;
            });
        },
      });
    },
    sendPost() {
      let student = null;
      if (this.admin) student = this.student.id;
      this.isLoading = true;
      axios
        .post("/classroom/" + this.code + "/post", {
          blog: this.blogSelected,
          content: this.content,
          title: this.title,
          student: student,
          is_teacher: this.admin ? 1 : 0,
          student_id: this.type == 2 ? this.student.id : null,
        })
        .then((response) => {
          this.modal = false;
          this.stories.unshift(response.data);
          this.isLoading = false;
        });
    },
    writePost() {
      (this.content = ``),
        (this.title = ""),
        (this.edit = null),
        (this.modal = true);
    },
    load(id) {
      let student = null;
      if (this.admin) student = this.student.id;
      this.isLoading = true;
      axios
        .post("/classroom/" + this.code + "/posts", {
          blog: id,
          student: student,
        })
        .then((response) => {
          this.stories = response.data;
          this.blogSelected = id;
          this.isLoading = false;
        });
    },
    toggleBlog(id, type = 0) {
      this.type = type;
      if (!this.blogSelected) {
        this.load(id);
      } else this.blogSelected = null;
    },
    createBlog(typeB) {
      let student = null;
      if (this.admin) student = this.student.id;
      this.$buefy.dialog.prompt({
        message: this.trans.get("blog.adventure_name"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        inputAttrs: {
          maxlength: 200,
        },
        trapFocus: true,
        onConfirm: (value) => {
          axios
            .post(`/classroom/${this.code}/blog`, {
              name: value,
              student: student,
              type: typeB,
            })
            .then((response) => {
              this.orderedBlogs.unshift(response.data);
              this.$forceUpdate();
            })
            .catch((error) => {
              Utils.toast(
                this,
                this.trans.get("success_error.error"),
                TYPE.ERROR
              );
            });
        },
      });
    },
  },
  computed: {
    orderedBlogs: function () {
      return _.orderBy(this.blogs, "id", "desc");
    },
  },
};
</script>