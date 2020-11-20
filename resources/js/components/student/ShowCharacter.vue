<template>
  <span class="rounded">
    <span
      class="level-top rounded p-4 has-background-light"
      v-if="student.level"
    >
      {{ student.level.number }}
    </span>
    <show-level
      class="level-hidden"
      style
      :level="student.level"
      :edit="false"
    ></show-level>
    <span
      v-if="student.grouplogo"
      v-tippy="{ arrow: true }"
      :content="'<i class=\'fas fa-users\'></i> ' + student.groups[0].name"
      class="top-right custom group-logo is-full-rounded"
    >
      <img :src="student.grouplogo" class="is-full-rounded" />
    </span>
    <div
      class="card-image card-shadow-s rounded-top char-bg"
      :style="
        'background-color:' +
        classroom.theme.color +
        ';background-image: url(/img/bg/thumb_' +
        classroom.theme.name +
        ');'
      "
    >
      <span
        v-if="student.boost"
        class="boost-right outer_glow_dark"
        v-tippy
        :content="
          '<i class=\'fas fa-heart colored\'></i>' +
          student.boost.hp +
          '% | <i class=\'fas fa-fist-raised colored\'></i>' +
          student.boost.xp +
          '% | <i class=\'fas fa-coins colored\'></i>' +
          student.boost.gold +
          '%'
        "
      >
        <i class="fas fa-arrow-alt-square-up"></i>
      </span>
      <div
        v-if="
          classroom.character_theme != 0 && classroom.character_theme != null
        "
        class="character-container character character-small is-relative"
      >
        <img
          :src="'/img/character/' + element.src"
          :class="element.classes"
          v-for="element in student.equipment"
          v-bind:key="element.id"
        />
      </div>
      <div v-else class="is-flex has-all-centered py-3">
        <img
          :src="student.avatar"
          width="128px"
          height="128px"
          class="rounded"
          alt
        />
      </div>
      <div v-if="student.pets && student.pets.length">
        <img
          v-tippy="{
            theme: 'light bordered',
            placement: 'bottom',
            arrow: true,
          }"
          :content="petMessage(student.pets[0])"
          :src="'/img/pets/' + student.pets[0].image"
          class="pet-character"
        />
      </div>
    </div>
  </span>
</template>

<script>
export default {
  props: ["student", "classroom"],
  created() {
    if(!this.student.grouplogo && this.student.grouplogopublic)
      this.student.grouplogo = this.student.grouplogopublic
  },
  data: function () {
    return {};
  },
  methods: {
    petMessage(pet) {
      let name = pet.name ? '<strong>' + pet.name + ":</strong> " : "";

      name +=
        pet.hp_boost +
        "% <i class='fas fa-heart colored'></i> |" +
        pet.xp_boost +
        "% <i class='fas fa-fist-raised colored'></i> |" +
        pet.gold_boost +
        "% <i class='fas fa-coins colored'></i>";

      return name;
    },
  },
};
</script>
<style>

@keyframes hmovement {
    0% {
        transform: translateX(0px)
    }

    20% {
        transform: translateX(8px);
    }

    40% {
        transform: translateX(8px) scale(-1, 1)
    }

    60% {
        transform: translateX(-8px) scale(-1, 1)
    }

    80% {
        transform: translateX(-8px)
    }
}

.pet-character:hover {
  animation: none;
}
.pet-character {
  position: absolute;
  bottom: 5px;
  left: 50%;
  animation-name: hmovement;
  animation-duration: 10s;
  animation-iteration-count: infinite;
}

</style>
