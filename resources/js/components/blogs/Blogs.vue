<template>
  <div class="p-1 m-1">
    <article class="message is-dark" v-if="!blogs.length">
      <div class="message-body">{{ trans.get("blog.blog_empty") }}</div>
    </article>
    <div>
      <button
        class="button is-primary"
        v-if="!blogSelected"
        @click="createBlog"
      >
        {{ trans.get("blog.new_blog") }}
      </button>
      <span
        @click="toggleBlog(blog.id)"
        v-for="blog in orderedBlogs"
        :key="blog.id"
      >
        <div
          v-if="!blogSelected || blogSelected == blog.id"
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
        v-if="!stories.length && !admin"
      >
        <i class="fad fa-trash-alt"></i> {{ trans.get("general.delete") }}
      </button>
      <article class="message is-link" v-if="!stories.length">
        <div class="message-body">
          {{ trans.get("blog.empty_posts") }}
          <a href="#" @click.prevent="writePost">{{
            trans.get("blog.write_post")
          }}</a>
        </div>
      </article>
      <button v-else class="button is-link my-2" @click.prevent="writePost">
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
  props: ["blogs", "code", "admin", "student"],
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
    toggleBlog(id) {
      if (!this.blogSelected) {
        this.load(id);
      } else this.blogSelected = null;
    },
    createBlog() {
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