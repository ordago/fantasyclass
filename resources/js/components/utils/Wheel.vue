<template>
  <div>
    <FortuneWheel
      v-if="showWheel"
      style="width: 100%"
      :canvas="canvasOptions"
      :useWeight="true"
      :prizes="prizes"
      @rotateStart="onCanvasRotateStart"
      @rotateEnd="onRotateEnd"
    />
    <!--
       
    -->
    <div class="column is-narrow has-all-centered is-flex" v-if="showWheel">
      <div class="field m-0 is-flex">
        <button class="button is-link" @click="randomStudent()">
          <i class="fad fa-random mr-2"></i> {{ trans.get("utils.random") }}
        </button>
        <p class="control has-icons-left">
          <span class="select">
            <select v-model="studentSelected">
              <option
                :value="student.id"
                v-for="student in students"
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
      <span v-if="prizeSelected">
        <button
          v-if="typew == 0"
          class="button"
          :class="{
            'is-danger': prizeSelected.value < 0,
            'is-success': prizeSelected.value > 0,
          }"
          @click="assignPrize()"
        >
          {{ prizeSelected.value }} <i class="fas fa-coins colored"></i>
        </button>
        <button v-else class="button is-success" @click="assignObject()">
          <img :src="prizeSelected.imageUri" />
        </button>
      </span>
    </div>
    <b-tabs type="is-toggle" expanded v-else>
      <b-tab-item label="Oro" icon-pack="fas" icon="coins" class="p-3">
        <form @submit.prevent="prepareWheel">
          <div class="columns p-2">
            <b-select
              required
              v-model="numberPrizes"
              :placeholder="trans.get('utils.quantity_rewards')"
            >
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
            </b-select>
          </div>
          <div class="columns p-2">
            <div class="field p-1">
              <label class="label"
                >Min <i class="fas fa-coins colored"></i
              ></label>
              <div class="control">
                <input type="number" required class="input" v-model="min" />
              </div>
            </div>
            <div class="field p-1">
              <label class="label"
                >Max <i class="fas fa-coins colored"></i
              ></label>
              <div class="control">
                <input type="number" required class="input" v-model="max" />
              </div>
            </div>
          </div>
          <div class="columns p-2">
            <button class="button is-primary">
              {{ trans.get("utils.wheel") }}
            </button>
          </div>
        </form>
      </b-tab-item>
      <b-tab-item
        :label="trans.get('utils.objects')"
        icon-pack="fas"
        icon="store"
      >
        <article class="message is-warning mt-2">
          <div class="message-body">
            {{ trans.get("utils.objects_info") }}
          </div>
        </article>
        <div class="mb-2">
          <b-switch
            type="is-info"
            v-model="limitObjects"
            :true-value="true"
            :false-value="false"
            >{{ trans.get("utils.limit_objects") }}</b-switch
          >
        </div>
        <button @click="prepareWheelImg" class="button is-primary">
          {{ trans.get("utils.wheel") }}
        </button>
      </b-tab-item>
    </b-tabs>
  </div>
</template>

<script>
import FortuneWheel from "vue-fortune-wheel";
import "vue-fortune-wheel/lib/vue-fortune-wheel.css";
import confetti from "canvas-confetti";

export default {
  components: {
    FortuneWheel,
  },
  props: {
    students: {
      type: Array,
      default: [],
    },
    code: {
      type: String,
    },
  },
  data() {
    return {
      canvasOptions: {
        borderWidth: 2,
        textDirection: "vertical",
        borderColor: "#584b43",
        textRadius: "218",
        borderWidth: "2",
      },
      min: -100,
      max: 100,
      prizeSelected: false,
      limitObjects: false,
      numberPrizes: null,
      fontSize: 30,
      typew: 0,
      studentSelected: null,
      showWheel: false,
      colorsOK: [
        "#c8e6c9",
        "#a5d6a7",
        "#81c784",
        "#66bb6a",
        "#4caf50",
        "#43a047",
        "#388e3c",
        "#2e7d32",
        "#1b5e20",
        "#003300",
        "#002200",
        "#001100",
      ],
      colorsKO: [
        "#ffccbc",
        "#ffab91",
        "#ff8a65",
        "#ff7043",
        "#ff5722",
        "#f4511e",
        "#e64a19",
        "#d84315",
        "#bf360c",
        "#570000",
        "#370000",
        "#170000",
      ],
      canvasVerify: true,
      prizes: [],
    };
  },
  methods: {
    randomStudent() {
      const idx = Math.floor(Math.random() * this.students.length);
      this.studentSelected = this.students[idx].id;
    },
    assignObject() {
      if (!this.studentSelected) {
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
      }
      let options = {
        id: this.studentSelected,
        prop: "object",
        value: this.prizeSelected.id,
        type: "wheel",
      };

      axios.post("/classroom/students/update", options).then((response) => {
        this.$toast(this.trans.get("success_error.update_success"), {
          type: "success",
        });

        this.studentSelected = null;
        this.prizeSelected = null;
      });
    },
    assignPrize() {
      if (!this.studentSelected) {
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
      }
      let options = {
        id: this.studentSelected,
        prop: "gold",
        value: this.prizeSelected.value,
        type: "wheel",
      };

      axios.post("/classroom/students/update", options).then((response) => {
        this.$toast(this.trans.get("success_error.update_success"), {
          type: "success",
        });

        this.studentSelected = null;
        this.prizeSelected = null;
      });
    },
    prepareWheelImg() {
      this.typew = 1;
      let color;
      let colors = _.shuffle(this.colorsOK);

      axios
        .post("/classroom/" + this.code + "/get/objects", {limit: this.limitObjects})
        .then((response) => {
          let items = response.data;
          if (items && items.length) {
            items.forEach((element) => {
              color = colors[element.id % colors.length];
              this.prizes.push({
                id: element.id,
                contentType: "image",
                imageUri: element.icon,
                value: element.id,
                bgColor: color,
                color: "#ffffff",
                weight: 1,
              });
            });
          }
        });

      this.prizes = _.shuffle(this.prizes);
      this.showWheel = true;
    },
    prepareWheel() {
      this.typew = 0;
      for (var i = 0; i <= this.numberPrizes; i++) {
        let value;
        if (i <= this.numberPrizes / 2) {
          value = Math.round(
            this.min - (this.min / (this.numberPrizes / 2)) * i
          );
        } else {
          value = Math.round(
            (this.max / (this.numberPrizes / 2)) * (i % (this.numberPrizes / 2))
          );
        }
        let color;
        if (value < 0) {
          color = this.colorsKO.pop();
        } else {
          color = this.colorsOK.shift();
        }
        if (value == 0) {
          continue;
        }
        this.prizes.push({
          id: i,
          name: value + "",
          value: value,
          bgColor: color,
          color: "#ffffff",
          weight: 1,
        });
      }
      this.prizes.push({
        id: i + 1,
        name: this.max + "",
        value: this.max,
        bgColor: "#ffd700",
        color: "#ffffff",
        weight: 1,
      });

      this.prizes = _.shuffle(this.prizes);
      this.showWheel = true;
    },
    onCanvasRotateStart() {
      this.prizeSelected = null;
      var audio = new Audio("/sound/wheel.mp3");
      audio.play();
    },
    onRotateEnd(prize) {
      if (this.typew == 0) {
        var audio;
        if (prize.value > 0) {
          audio = new Audio("/sound/clap.mp3");
          confetti({
            particleCount: 200,
            spread: 100,
            origin: { y: 1.0 },
          });
        } else {
          audio = new Audio("/sound/bad.mp3");
        }
      } else {
        audio = new Audio("/sound/clap.mp3");
        confetti({
          particleCount: 200,
          spread: 100,
          origin: { y: 1.0 },
        });
      }
      console.log(prize);
      this.prizeSelected = prize;
      audio.play();
      this.$forceUpdate();
    },
  },
};
</script>
<style>
.hiddenV {
  visibility: hidden;
}
.fw-btn__btn {
  cursor: pointer;
}
</style>