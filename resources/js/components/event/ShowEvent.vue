<template>
  <div class="m-0 content">
    <transition name="fade">
      <h1 class="first-appear is-size-1" v-if="show" v-html="trans.get(info.event.title)"></h1>
    </transition>
    <transition name="fadesecond">
      <div class="second-appear" v-if="show">
        <h2 class="py-3 is-size-3 has-text-centered">
          <span v-if="!(info.event.type && showInfo)" v-html="trans.get(info.event.content)"></span>
          <span v-if="info.event.type == 1 || info.event.type == 2 || info.event.type == 5">
            ({{info.hp}}
            <i class="fas fa-heart colored"></i>)
          </span>
          <span v-if="info.event.type == 10">
            ({{info.gold}}
            <i class="fas fa-coins colored"></i>)
          </span>
          <img :src="info.class" v-if="info.event.type == 7" />
        </h2>
        <h2
          class="py-3 is-size-3 has-text-centered"
          v-if="info.event.type == 1 || info.event.type == 3 || info.event.type == 4 || info.event.type == 6 || info.event.type == 8 || info.event.type == 9 || info.event.type == 10 || info.event.type == 11"
        >
          <div class="hiddenName">
            <div class="hideObj"></div>
            <span>{{ info.student.name }}</span>
          </div>
        </h2>
        <h4
          class="py-3 mt-2 is-flex is-size-4 has-all-centered"
          v-if="info.event.type == 8 || info.event.type == 9"
        >
          <div class="columns">
            <div class="column">
              <button class="button is-success" @click="accept()">
                <i class="fas fa-thumbs-up"></i>
                <span v-if="info.event.type == 8">{{ info.gold }}</span>
                <span v-if="info.event.type == 9">{{ info.xp }}</span>
                <i
                  class="fas colored"
                  :class="{ 'fa-coins': info.event.type == 8, 'fa-fist-raised': info.event.type == 9 }"
                ></i>
              </button>
            </div>
            <div class="column">
              <button class="button is-danger" @click="accept(false)">
                <i class="fas fa-thumbs-down"></i>
                <span v-if="info.event.type == 8">{{ info.hp }}</span>
                <span v-if="info.event.type == 9">{{ info.xp * -1 }}</span>
                <i
                  class="fas colored"
                  :class="{ 'fa-heart': info.event.type == 8, 'fa-fist-raised': info.event.type == 9 }"
                ></i>
              </button>
            </div>
          </div>
        </h4>
        <h4 class="py-3 is-flex is-size-4 has-all-centered" v-if="info.event.type == 5">
          <b-modal
            :active.sync="isCountDownModalActive"
            has-modal-card
            full-screen
            :can-cancel="false"
          >
            <div class="modal-card" style="width: auto">
              <header class="modal-card-head">
                <p class="modal-card-title">Countdown</p>
              </header>
              <section
                class="modal-card-body is-flex has-all-centered"
                style="align-items: flex-start;"
              >
                <count-down :starttime="new Date(1,1,1, 0, 0, 10)"></count-down>
              </section>
              <footer class="modal-card-foot">
                <button class="button" type="button" @click="isCountDownModalActive=false">Close</button>
              </footer>
            </div>
          </b-modal>
          <div class="columns">
            <div class="column is-narrow is-flex has-all-centered">
              {{ info.student.name }}
              <i class="fal ml-3 fa-arrow-right"></i>
            </div>
            <div class="column is-flex has-all-centered">
              <div class="field">
                <div class="control">
                  <div class="select is-danger">
                    <select v-model="selectedStudent">
                      <option :value="info.student.id">{{ info.student.name }}</option>
                      <option
                        :value="student.id"
                        v-for="student in info.groupMembers"
                        :key="student.id"
                      >{{ student.name }}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="column is-narrow is-flex has-all-centered">
              <button class="button is-link" @click="isCountDownModalActive = true">
                <i class="fad fa-stopwatch"></i>
              </button>
            </div>
          </div>
        </h4>
        <button @click="isWheelModalActive = true" v-if="info.event.type == 14" class="button is-primary">{{ trans.get('events.wheel_btn') }}</button>
        <show-card
          v-if="info.event.type == 11 && showInfo"
          :card="info.card"
          class="mt-2"
          style="zoom: 0.5"
        ></show-card>
        <button
          class="button mt-3"
          v-if="info.event.type == 11"
          @click="showInfo = !showInfo"
        >Show / hide card</button>
        <div class="columns" v-if="info.event.type==12">
          <div class="column" v-if="!showInfo">
            <button class="button is-success" @click="showInfo = true">{{ trans.get('events.go_ahead') }}</button>
          </div>
          <div class="column" v-if="!showInfo">
            <button class="button is-danger" @click="close()">Nope ...</button>
          </div>
          <div class="column" v-if="showInfo">
            <span class="is-size-3 mt-3">
              {{ trans.get(info.text) }} ({{ info.value }}
              <i
                class="fas colored"
                :class="{ 'fa-coins' : info.value > 0, 'fa-heart' : info.value < 0 }"
              ></i>)
            </span>
          </div>
        </div>
        <button
          class="button is-dark mt-5"
          @click="accept()"
          v-if="info.event.type != 8 && info.event.type != 9 && (info.event.type != 12 || showInfo)"
        >
          <i class="fas fa-feather-alt"></i> Accept the destiny
        </button>
      </div>
    </transition>
     <b-modal
      :active.sync="isWheelModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("utils.fortune") }}</p>
        </header>
        <section class="modal-card-body is-flex has-all-centered">
          <wheel :students="info.students"></wheel>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isWheelModalActive = false">
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["info", "code"],
  mounted() {
    this.show = true;
  },
  data: function() {
    return {
      isWheelModalActive: false,
      show: false,
      selectedStudent: 0,
      isCountDownModalActive: false,
      showInfo: false
    };
  },
  methods: {
    close() {
      window.location = "/classroom/" + this.code;
    },
    accept(value = true) {
      switch (this.info.event.type) {
        case 1:
        case 6:
          axios.post("/classroom/students/update", {
            id: this.info.student.id,
            prop: "hp",
            value: this.info.hp,
            type: 'event',
          });
          break;
        case 5:
          axios.post("/classroom/students/update", {
            id: this.selectedStudent,
            prop: "hp",
            value: this.info.hp,
            type: 'event',
          });
          break;
        case 2:
          axios.post("/classroom/students/update", {
            code: this.code,
            prop: "hp",
            value: this.info.hp,
            type: 'event',
          });
          break;
        case 8:
          if (value) {
            axios.post("/classroom/students/update", {
              id: this.info.student.id,
              prop: "gold",
              value: this.info.gold,
              type: 'event',
            });
          } else {
            axios.post("/classroom/students/update", {
              id: this.info.student.id,
              prop: "hp",
              value: this.info.hp,
              type: 'event',
            });
          }
          break;
        case 9:
          if (value) {
            axios.post("/classroom/students/update", {
              id: this.info.student.id,
              prop: "xp",
              value: this.info.xp,
              type: 'event',
            });
          } else {
            axios.post("/classroom/students/update", {
              id: this.info.student.id,
              prop: "xp",
              value: this.info.xp * -1,
              type: 'event',
            });
          }
          break;
        case 10:
          axios.post("/classroom/students/update", {
            id: this.info.student.id,
            prop: "gold",
            value: this.info.gold,
            type: 'event',
          });
          break;
        case 11:
          axios.post("/classroom/students/update", {
            id: this.info.student.id,
            card_id: this.info.card.id,
            type: 'event',
          });
          break;
        case 12:
          let prop = "gold"
          if(this.info.value < 0)
            prop = "hp"

          axios.post("/classroom/students/update", {
            code: this.code,
            prop: prop,
            value: this.info.value,
            type: 'event',
          });
          break;
      }
      this.close();
    }
  }
};
</script>

<style>
@font-face {
  font-family: logo;
  src: url(/fonts/wizzta.otf);
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
  transition-delay: 1000ms;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.fadesecond-enter-active,
.fadesecond-leave-active {
  transition: opacity 0.5s;
  transition-delay: 3000ms;
}
.fadesecond-enter, .fadesecond-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.first-appear {
  height: 30vh;
  background-color: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  word-spacing: 0.2em;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  position: relative;
  padding: 40px;
  z-index: 5;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4);
  overflow: auto;
}
.second-appear {
  height: 70vh;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  background-color: rgba(255, 255, 255, 0.75);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4);
  padding: 30px;
  padding-top: 70px;
  margin-top: -40px;
  z-index: 2;
  overflow: auto;
}
.final {
  opacity: 0;
}
h2.second-appear > * {
  margin: 5px;
}
.hiddenName {
  display: inline-block;
  font-size: 2.5em;
  position: relative;
  min-width: 600px;
  text-align: center;
}
.hideObj {
  position: absolute;
  z-index: 1000;
  background-image: url("/img/hide.png");
  background-repeat: no-repeat;
  background-size: 100% 100%;
  width: 100%;
  height: 120%;
  border-radius: 5px;
  transition: 1s opacity;
  cursor: zoom-in;
}
.hiddenName:hover .hideObj {
  opacity: 0;
  transition-delay: 1s;
}
.hiddenMEssage {
  visibility: hidden;
}
</style>
