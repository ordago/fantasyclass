<template>
  <div class="box has-margin-bottom-3" v-bind:class="getBackground">
    <section class="media">
      <div class="media-content">
        <div class="content">
          <h1>
            <i
              v-if="challengeReactive.is_conquer&&challengeReactive.icon"
              class="is-size-4"
              :style="'color:' + challengeReactive.color"
              :class="challengeReactive.icon + ' colored'"
            ></i>
            <i v-if="challengeReactive.type==1" class="fas fa-users is-size-4 colored"></i>
            {{ challengeReactive.title }}
            <span class="tag is-light">{{ challengeReactive.datetime }}</span>
          </h1>
          <p>
            <small>{{ challengeReactive.description }}</small>
          </p>
          <p v-if="challengeReactive.is_conquer">
            <small v-if="challengeReactive.xp!=0">
              <i class="fas fa-fist-raised colored"></i>
              {{ challengeReactive.xp }}
            </small>
            <small v-if="challengeReactive.hp!=0">
              <i class="fas fa-heart colored"></i>
              {{ challengeReactive.hp }}
            </small>
            <small v-if="challengeReactive.gold!=0">
              <i class="fas fa-coins colored"></i>
              {{ challengeReactive.gold }}
            </small>
            <small v-if="challengeReactive.cards!=0">
              <i class="fas fa-club colored"></i>
              {{ challengeReactive.cards }}
            </small>
          </p>
          <div v-if="edit" v-html="challengeReactive.content" class="el-tiptap-editor__content"></div>
          <div class="has-padding-3 has-text-right" v-if="edit && admin || !admin">
            <button
              v-if="!admin && (challengeReactive.completion == 2 ||challengeReactive.completion == 1) && !checkCompletion"
              class="button is-info"
              @click="markCompleted(challenge)"
            >
              <span class="icon is-small">
                <i class="fas fa-check"></i>
              </span>
              <span>Mark as realised</span>
            </button>
            <button
              v-if="challengeReactive.is_conquer && admin"
              class="button is-success is-outlined"
              @click="$parent.showModal(challenge)"
            >
              <span class="icon is-small">
                <i class="fas fa-edit"></i>
              </span>
              <span>Mark</span>
            </button>
            <button
              class="button is-dark is-outlined"
              @click="$parent.challengeEdit=challenge;$parent.addChallenge=true"
              v-if="admin"
            >
              <span class="icon is-small">
                <i class="fas fa-edit"></i>
              </span>
              <span>Edit</span>
            </button>
            <button
              class="button is-danger is-outlined"
              @click="$parent.confirmDelete(challengeReactive.id)"
              v-if="admin"
            >
              <span class="icon is-small">
                <i class="fas fa-trash-alt"></i>
              </span>
              <span>Delete</span>
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import confetti from 'canvas-confetti'
export default {
  props: ["challenge", "edit", "admin", "code"],
  created: function() {
    this.challengeReactive = this.challenge
  },
  data: function() {
    return {
      challengeReactive: null,
    };
  },
  methods: {
    markCompleted(challenge) {
      this.$buefy.dialog.confirm({
        title: "Class change",
        message:
          "Are you sure you have done all the the work? Trust is needed there.",
        confirmText: "Confirm done",
        type: "is-warning",
        iconPack: "fa",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.code + "/student/markchallenge", {
              challenge: this.challengeReactive.id
            })
            .then(response => {
              if(response.data == true) {
                confetti({
                  particleCount: 200,
                  spread: 100,
                  origin: { y: 1.0 }
                });
                this.challengeReactive.count++
              }
                
            });
        }
      });
    }
  },
  components: {},
  computed: {
    checkCompletion() {
      if (this.challengeReactive.completion == 1) return this.challengeReactive.count == 1;
      if (this.challengeReactive.completion == 2) return this.challengeReactive.count == 2;
    },
    getBackground() {
      if (this.edit) {
        return "";
      } else {
        switch (this.challengeReactive.completion) {
          case 0:
          case 1:
            return this.challengeReactive.count == 1
              ? "has-background-success"
              : "has-background-danger";
            break;
          case 2:
            return this.challengeReactive.count == 2
              ? "has-background-success"
              : "has-background-danger";
            break;
        }
      }
    }
  }
};
</script>
