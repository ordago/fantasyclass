<template>
  <b-modal
    :active.sync="$parent.isCardModalActive"
    has-modal-card
    full-screen
    :can-cancel="false"
  >
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">Random card</p>
      </header>
      <section class="modal-card-body is-relative" id="confetti-bg">
        <img
          id="deck"
          src="/img/deck.png"
          class="deck"
          v-if="!showCard"
          @click="revealCard"
        />
        <show-card
          :card="card"
          class="deck"
          :admin="false"
          v-if="showCard"
          :code="code"
        ></show-card>
      </section>
      <footer
        class="modal-card-foot columns is-multiline"
        style="overflow-x: auto"
      >
        <div class="column is-narrow is-12-mobile is-flex has-all-centered">
          <button
            class="button"
            type="button"
            @click="
              showCard = false;
              $parent.isCardModalActive = false;
            "
          >
            {{ trans.get("general.close") }}
          </button>
          <button
            class="button is-link"
            v-if="admin"
            @click="
              $parent.getRandomCard();
              showCard = false;
            "
          >
            <i class="far fa-redo-alt"></i>
          </button>
        </div>
        <div
          v-if="showCard && admin"
          class="column is-narrow is-flex has-all-centered"
        >
          <div class="field m-0">
            <p class="control has-icons-left">
              <span class="select">
                <select v-model="studentSelected">
                  <option value="0">Student</option>
                  <option
                    :value="student.id"
                    v-for="student in $parent.allStudents"
                    :key="student.id"
                  >
                    {{ student.name }}
                  </option>
                </select>
              </span>
              <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
              </span>
            </p>
          </div>
          <button class="button is-primary" @click="assignCard('student')">
            <i class="fas fa-user"></i>
          </button>
        </div>
        <div
          v-if="showCard && admin"
          class="column is-narrow is-flex has-all-centered"
        >
          <div class="field m-0">
            <p class="control has-icons-left">
              <span class="select">
                <select v-model="groupSelected">
                  <option value="0">Groups</option>
                  <option
                    v-for="group in $parent.classroom.grouping[0].groups"
                    :value="group.id"
                    :key="group.id"
                  >
                    {{ group.name }}
                  </option>
                </select>
              </span>
              <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
              </span>
            </p>
          </div>
          <button class="button is-primary" @click="assignCard('group')">
            <i class="fas fa-users"></i>
          </button>
        </div>
      </footer>
    </div>
  </b-modal>
</template>

<script>
// import Utils from "../../utils.js";
import confetti from "canvas-confetti";

export default {
  props: ["code", "admin", "code", "card"],
  created() {},
  data: function () {
    return {
      showCard: false,
      studentSelected: 0,
      groupSelected: 0,
    };
  },
  methods: {
    revealCard() {
      var audio = new Audio("/sound/victory.mp3");
      audio.play();
      setTimeout(() => {
        var end = Date.now() + 15 * 125;

        var colors = ["#bb0000", "#00bb00", "#0000bb", "#bbbb00"];

        (function frame() {
          confetti({
            particleCount: 4,
            angle: 60,
            spread: 105,
            origin: { x: 0 },
            colors: colors,
          });
          confetti({
            particleCount: 4,
            angle: 120,
            spread: 105,
            origin: { x: 1 },
            colors: colors,
          });

          if (Date.now() < end) {
            requestAnimationFrame(frame);
          }
        })();
        this.showCard = true;
      }, 300);
    },
    assignCard(to) {
      let card = this.card.id;
      let target;
      if (to == "student") {
        if (this.studentSelected == 0) {
          this.$buefy.dialog.alert({
            title: "Error",
            message: "Please, select a student",
            type: "is-danger",
            hasIcon: true,
            icon: "times-circle",
            iconPack: "fa",
            ariaRole: "alertdialog",
            ariaModal: true,
          });
          return false;
        } else {
          target = this.studentSelected;
        }
      } else {
        if (this.groupSelected == 0) {
          this.$buefy.dialog.alert({
            title: "Error",
            message: "Please select a group",
            type: "is-danger",
            hasIcon: true,
            icon: "times-circle",
            iconPack: "fa",
            ariaRole: "alertdialog",
            ariaModal: true,
          });
          return false;
        } else {
          target = this.groupSelected;
        }
      }
      axios
        .post("/classroom/" + this.code + "/card/assign", {
          type: to,
          id: target,
          card: card,
        })
        .then((response) => {
          this.$parent.getRandomCard();
          this.showCard = false;
        });
    },
  },
};
</script>