<template>
  <span class="rounded">
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
      :style="getStyle()"
    >
      <span class="level-top rounded p-3" v-if="student.level" :class="{ 'level-top-ns' : !showSkills }">
        {{ student.level.number }}
      </span>
      <show-level
        class="level-hidden"
        style
        :level="student.level"
        :edit="false"
      ></show-level>
      <div v-if="showSkills" class="is-flex is-flex-direction-column skills">
        <span class="skill-container">
          <img
            src="/img/skills/t1/rpg-priest_active_12.png"
            class="skill-item"
            width="40px"
          />
        </span>
        <span class="skill-container">
          <img
            src="/img/skills/t1/rpg-rogue_active10.png"
            class="skill-item"
            width="40px"
          />
        </span>
        <span class="skill-container"> </span>
        <span class="skill-container"> </span>
      </div>

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
          classroom.character_theme != null && classroom.character_theme != 0
        "
        class="character-container character is-relative"
        :class="classroom.character_theme.classes"
      >
        <div :class="student.character.classes">
          <img
            :src="'/img/character/' + element.src"
            :class="element.classes"
            v-for="element in student.equipment"
            v-bind:key="element.id"
          />
        </div>
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
          width="81px"
          :content="petMessage(student.pets[0])"
          :src="student.pets[0].image"
          class="pet-character"
        />
      </div>
    </div>
  </span>
</template>

<script>
export default {
  props: {
    student: null,
    classroom: null,
    showSkills: {
      type: Boolean,
      default: true,
    },
  },
  created() {
    if (!this.student.grouplogo && this.student.grouplogopublic)
      this.student.grouplogo = this.student.grouplogopublic;
  },
  data: function () {
    return {};
  },
  methods: {
    getStyle() {
      return (
        "background-position-x: left; background-position-y: bottom;background-image: url(" +
        this.classroom.background +
        ");"
      );
    },
    petMessage(pet) {
      let name = pet.name ? "<strong>" + pet.name + ":</strong> " : "";

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
    transform: translateX(0px);
  }

  20% {
    transform: translateX(8px);
  }

  40% {
    transform: translateX(8px) scale(-1, 1);
  }

  60% {
    transform: translateX(-8px) scale(-1, 1);
  }

  80% {
    transform: translateX(-8px);
  }
}

.pet-character:hover,
.pet-battle:hover {
  animation: none;
}
.pet-character {
  position: absolute;
  bottom: 5px;
  left: 60%;
  animation-name: hmovement;
  animation-duration: 10s;
  animation-iteration-count: infinite;
}
.pet-battle {
  animation-name: hmovement;
  animation-duration: 4s;
  animation-iteration-count: infinite;
}
.pet-dead {
  -webkit-transition: all 0.5s ease 0.5s; /* Para Chrome y Safari */
  -moz-transition: all 0.5s ease 0.5s; /* Para Mozilla */
  -o-transition: all 0.5s ease 0.5s; /* Para Ópera */
  -ms-transition: all 0.5s ease 0.5s; /* Para Explorer */
  transition: all 0.5s ease 0.5s;
  transform: rotate(180deg);
  top: 10px;
}
.skills {
  position: absolute;
  width: 40px;
  top: 0;
  left: 1px;
  z-index: 10;
}
.skill-container {
  position: relative;
  background-image: url("/img/skill.png");
  width: 40px;
  height: 40px;
}
.skills-big {
  position: relative;
  width: 50px;
  height: 50px;
  background-image: url("/img/skill-big.png");
}
.skill-item {
  position: absolute;
  top: 1px;
  left: 1px;
  width: 38px;
  height: 38px;
  border-radius: 5px;
}
.skill-item-big {
  width: 48px;
  height: 48px;
}
</style>
