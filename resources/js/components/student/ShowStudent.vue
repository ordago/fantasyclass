<template>
  <div class="card rounded card-shadow-s" style="overflow: visible;">
    <show-character :student="student" :classroom="classroom"></show-character>
    <div class="card-content">
      <div class="media mb-0">
        <div class="media-left" v-if="characterTheme">
          <figure class="image is-48x48">
            <img :src="student.avatar" class="rounded" alt />
          </figure>
        </div>
        <div class="media-content cursor-default">
          <p class="title is-4">{{ student.name }}</p>
          <p class="subtitle is-6">
            <small>@{{ student.username }}</small>
          </p>
        </div>
      </div>
      <div class="content mt-3">
        <div class="is-flex has-all-centered">
          <div class="w-100 is-relative">
            <div class="attribute-info has-all-centered">
              <img src="/img/bg-hp.png" width="40px" />
              <i class="fas fa-heart colored is-absolute" style="left: 10px"></i>
            </div>
            <div
              class="score p-3 centered-attribute m-1 my-4 has-all-centered"
              style="border: none"
            >
              <span
                class="attribute has-background-white-ter py-3 rounded"
                style="width:100%;border: 1px solid black"
              >
                <span
                  class="has-text-grey-light"
                  :class="{ 'has-text-white-ter' : student.hp>=30 }"
                >{{ student.hp }}</span>
              </span>
              <span
                class="attribute has-background-danger py-3 rounded-left"
                v-bind:class="{ rounded: student.hp==100 }"
                :style="'width: ' + student.hp + '%'"
              >
                <span
                  v-if="student.hp > 0"
                  :class="{ 'has-text-danger' : student.hp<30 }"
                >{{ student.hp }}</span>
              </span>
            </div>
          </div>
        </div>
        <div class="is-flex is-relative has-all-centered">
          <div class="w-100 is-realative">
            <div class="attribute-info has-all-centered">
              <img src="/img/bg-xp.png" width="40px" />
              <i class="fas fa-fist-raised colored is-absolute" style="left: 13px"></i>
            </div>
            <div
              class="score p-3 centered-attribute m-1 my-4 has-all-centered"
              style="border: none"
            >
              <span
                class="attribute has-background-dark py-3 rounded"
                style="width:100%;border: 1px solid black"
              >
                <span class="has-text-light">{{ student.xp }}</span>
              </span>
            </div>
          </div>
        </div>
        <div class="is-flex is-relative has-all-centered">
          <div class="w-100 is-realative">
            <div class="attribute-info has-all-centered">
              <img src="/img/bg-gold.png" width="40px" />
              <i class="fas fa-coins colored is-absolute" style="left: 10px"></i>
            </div>
            <div
              class="score p-3 centered-attribute m-1 my-4 has-all-centered"
            >
              <span
                class="attribute has-background-warning py-3 rounded"
                style="width:100%;border: 1px solid black"
              >
                <span class="has-text-dark">{{ student.gold }}</span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["student", "theme", "characterTheme"],
  created() {
    this.classroom = { theme: this.theme, character_theme: this.characterTheme }
    if(this.student.groups.length)
      this.student.grouplogo = this.student.groups[0].logo
  },
  data: function () {
    return {
      classroom: {},
    };
  },
  methods: {},
  computed: {},
};
</script>
