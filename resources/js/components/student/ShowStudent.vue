<template>
  <div class="card rounded card-shadow-s" style="overflow: visible;">
    <show-character :show-skills="showSkills" :student="student" :classroom="classroom"></show-character>
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
        
        <hp class="mb-3" :hp="student.hp" :size="2" :icon="true"></hp>
        
        <div class="is-flex is-relative has-all-centered">
          <div class="w-100 is-realative">
            <div class="attribute-info attribute-info-props has-all-centered">
              <img src="/img/bg-xp.png" width="40px" />
              <i class="fas fa-fist-raised colored is-absolute" style="left: 13px"></i>
            </div>
            <div
              class="score p-2 centered-attribute m-1 my-4 has-all-centered"
              style="border: none"
            >
              <span
                class="attribute has-background-dark py-2 rounded border"
              >
                <span class="has-text-light">{{ student.xp }}</span>
              </span>
            </div>
          </div>
        </div>
        <div class="is-flex is-relative has-all-centered">
          <div class="w-100 is-realative">
            <div class="attribute-info attribute-info-props has-all-centered">
              <img src="/img/bg-gold.png" width="40px" />
              <i class="fas fa-coins colored is-absolute" style="left: 10px"></i>
            </div>
            <div
              class="score p-2 centered-attribute m-1 my-4 has-all-centered"
            >
              <span
                class="attribute has-background-warning py-2 rounded border"
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
  props: {
    student: {},
    theme: {},
    characterTheme: {},
    showSkills: {
      type: Boolean,
      default: false,
    }
  },
  created() {
    this.classroom = { background: this.theme, character_theme: this.characterTheme }
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
