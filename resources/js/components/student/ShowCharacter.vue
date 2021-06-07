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
      <span
        class="level-top rounded p-3"
        v-if="student.level"
        :class="{ 'level-top-ns': !showSkills }"
      >
        {{ student.level.number }}
      </span>
      <show-level
        class="level-hidden"
        style
        :level="student.level"
        :edit="false"
      ></show-level>
      <div v-if="showSkills" class="is-flex is-flex-direction-column skills">
        <ShowSkill
          v-for="skill in student.skills"
          :key="skill.id"
          :skill="skill"
          :code="classroom.code"
          :admin="false"
          :use="false"
        ></ShowSkill>
        <span
          v-for="index in 4 - student.skills.length"
          :key="index"
          class="mr-1 is-flex has-all-centered skill-container"
        >
        </span>
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
        <div :class="getClass()">
          <img
            @contextmenu.prevent=""
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
            placement: 'left',
            interactive: true,
            arrow: true,
          }"
          ref="pet"
          @contextmenu.prevent=""
          width="81px"
          :content="petMessage(student.pets[0])"
          :src="student.pets[0].image"
          :class="getPetClass(student.pets[0])"
        />
      </div>
    </div>
  </span>
</template>

<script>
import ShowSkill from "../skill/ShowSkill.vue";

export default {
  props: {
    student: null,
    classroom: null,
    showSkills: {
      type: Boolean,
      default: true,
    },
    feed: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    ShowSkill,
  },
  created() {
    window.feedPet = this.feedPet;

    if (!this.student.grouplogo && this.student.grouplogopublic)
      this.student.grouplogo = this.student.grouplogopublic;
  },
  data: function () {
    return {};
  },
  methods: {
    feedPet(id) {
      axios.post('/classroom/student/pet/feed', {id: id})
        .then(response => {
          this.$toast(response.data.message, { type: response.data.type });
          if(response.data.type == 'success') {
            let audio = new Audio("/sound/eat.mp3");
            audio.play();
            this.$refs.pet.classList.add("animated");
            this.$refs.pet.classList.add("faa-bounce");
            setTimeout(() => {
              this.$refs.pet.classList.remove("animated");
              this.$refs.pet.classList.remove("faa-bounce");
            }, 2000);
            this.student.pets = response.data.student.pets;
            this.$parent.student.gold = response.data.student.gold;
            this.$parent.$forceUpdate();
            this.$forceUpdate();
          }
        });
    },
    getPetClass(pet) {
      if (pet.pivot.hp <= 0) return "pet-character show-pet-dead";
      return "pet-character";
    },
    getClass() {
      if (this.student.hp > 0) return this.student.character.classes;
    },
    getStyle() {
      return (
        "background-position-x: left; background-position-y: bottom;background-image: url(" +
        this.classroom.background +
        ");"
      );
    },
    petMessage(pet) {
      let name = pet.name ? "<strong>" + pet.name + ":</strong> " : "";
      if (pet.pivot.hp > 0) name += "<span>";
      else name += "<span style='text-decoration: line-through'>";
      name +=
        pet.hp_boost +
        "% <i class='fas fa-heart colored'></i> |" +
        pet.xp_boost +
        "% <i class='fas fa-fist-raised colored'></i> |" +
        pet.gold_boost +
        "% <i class='fas fa-coins colored'></i>" +
        "<br><progress class='mt-2 progress is-danger w-100' value='" +
        pet.pivot.hp +
        "' max=100 min=0></progress>";
      name += "</span>";

      if (this.feed && pet.pivot.hp > 0 && pet.pivot.hp < 100)
        name += `<br><small><span class="tag is-success mx-2 cursor-pointer" onclick="feedPet(${this.student.id})">🍅🍖 ${this.trans.get(
          "pets.feed"
        )} 100 <i class="fas fa-coins colored"></i></span></small>`;

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
.show-pet-dead {
  transform-origin: 50% 75%;
  transform: rotate(180deg);
  animation: none;
}
.skills {
  position: absolute;
  width: 40px;
  top: 0;
  left: 1px;
  z-index: 10;
}
</style>
