<template>
    <div class="card rounded card-shadow-s">
      <span
        class="level-top rounded has-padding-4 has-background-light"
        v-if="student.level"
      >{{ student.level.number }}</span>

      <div
        class="card-image card-shadow-s rounded-top char-bg"
        :style="'background-color:' + theme.color + ';background-image: url(/img/bg/thumb_' + theme.name + ');'"
      >
        <div class="character-container character character-small is-relative">
          <img
            :src="'/img/character/' + element.src"
            :class="element.classes"
            v-for="element in student.equipment"
            v-bind:key="element.id"
          />
        </div>
      </div>
      <div class="card-content">
        <div class="media has-margin-bottom-0">
          <div class="media-left">
            <figure class="image is-48x48">
              <img :src="student.avatar" class="rounded" alt />
            </figure>
          </div>
          <div class="is-flex has-all-centered h-100">
            <p class="title is-4">{{ student.name }}</p>
          </div>
        </div>
        <div class="content has-margin-top-3">
          <div class="is-flex has-all-centered">
            <div class="w-100 is-relative">
              <div class="attribute-info has-all-centered">
                <img src="/img/bg-hp.png" width="40px" />
                <i class="fas fa-heart colored is-absolute" style="left: 10px"></i>
                </div>
              <div
                class="score has-padding-3 centered-attribute has-margin-1 has-margin-y-4 has-all-centered"
                style="border: none"
              >
                <span
                  class="attribute has-background-white-ter has-padding-y-3 rounded"
                  style="width:100%;border: 1px solid black"
                >
                  <span class="has-text-grey-light" :class="{ 'has-text-white-ter' : student.hp>=30 }">{{ student.hp }}</span>
                </span>
                <span
                  class="attribute has-background-danger has-padding-y-3 rounded-left"
                  v-bind:class="{ rounded: student.hp==100 }"
                  :style="'width: ' + student.hp + '%'"
                >
                  <span v-if="student.hp > 0" :class="{ 'has-text-danger' : student.hp<30 }">{{ student.hp }}</span>
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
                class="score has-padding-3 centered-attribute has-margin-1 has-margin-y-4 has-all-centered"
                style="border: none"
              >
                <span
                  class="attribute has-background-dark has-padding-y-3 rounded"
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
                class="score has-padding-3 centered-attribute has-margin-1 has-margin-y-4 has-all-centered"
                
              >
                <span
                  class="attribute has-background-warning has-padding-y-3 rounded"
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
  props: ["student", "theme"],
  mounted() {},
  data: function() {
    return {};
  },
  methods: {},
  computed: {}
};
</script>
