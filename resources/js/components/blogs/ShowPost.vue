<template>
  <div class="box card-shadow-s mb-3 has-background-story">
    <section class="media">
      <div class="media-content is-relative">
        <div
          class="challenge-category has-background-light"
        >
          <i class="fad fa-file-alt"></i>
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
              {{ post.date.split(":00")[0] }}</span
            >
          </h1>

          <div v-html="getContent(post.content)"></div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Utils from "../../utils.js";

// const InputEmoji = () => import("../utils/InputEmoji.vue");

export default {
  props: ["post"],
  created: function () {},
  data: function () {
    return {};
  },
  components: {},
  methods: {
    getContent(content) {
      return Utils.replaceSpecial(content);
    },
  },
  computed: {},
};
</script>
