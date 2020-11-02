<template>
  <div>
    <div>
      <div>
        <div class="rounded has-background-warning p-4 mb-3">
          <strong>
            <i class="fas fa-flask"></i> Función experimental
          </strong>
          <i class="fas fa-info-square"></i> Haz start y prueba los valores de tolerancia antes de activar las penalizaciones.
        </div>
        <div class="columns">
          <div class="column">
            <div class="propertyMeter p-3">
              <b-switch v-model="countGold" true-value="1" false-value="0">
                <i class="fas fa-coins colored"></i>
              </b-switch>
              <input type="number" v-model="gold" class="input" />
            </div>
            <div class="propertyMeter p-3">
              <b-switch v-model="countXp" true-value="1" false-value="0">
                <i class="fas fa-fist-raised colored"></i>
              </b-switch>
              <input type="number" v-model="xp" class="input" />
            </div>
            <div class="propertyMeter p-3">
              <b-switch v-model="countHp" true-value="1" false-value="0">
                <i class="fas fa-heart colored"></i>
              </b-switch>
              <input type="number" class="input" v-model="hp" />
            </div>
          </div>
          <div class="column">
            <div id="info">
              <span class="tag tag fa-2x m-2 is-size-5 p-4">
                <span>{{ alarmCount }}</span>
                <i class="fas fa-siren-on colored"></i>
              </span>
              <span class="tag tag is-warning fa-2x m-2 is-size-5 p-4">
                <span>{{ gold * alarmCount * countGold * -1 }}</span>
                <i class="fas fa-coins colored"></i>
              </span>
              <span class="tag tag is-dark fa-2x m-2 is-size-5 p-4">
                <span>{{ xp * alarmCount * countXp * -1 }}</span>
                <i class="fas fa-fist-raised colored"></i>
              </span>
              <span class="tag tag is-danger fa-2x m-2 is-size-5 p-4">
                <span>{{ hp * alarmCount * countHp * -1 }}</span>
                <i class="fas fa-heart colored"></i>
              </span>
              <span
                class="button is-size-6 acceptDestiny ml-2"
                style="margin-top:0!important"
                @click="accept"
              >
                <i class="fas fa-feather-alt"></i> Accept
              </span>
            </div>
          </div>
        </div>
        <br />
        <div class="sensitivity">
          <i class="fal fa-tachometer-slowest fa-2x left"></i>
          <i class="fal fa-tachometer-average fa-2x center"></i>
          <i class="fal fa-tachometer-fastest fa-2x right"></i>
        </div>
        <input type="range" min="0" id="tolerance" v-model="tolerance" max="10" style="width:100%" />
        <br />
        <!-- The canvas that will be used to render the input level -->
        <canvas ref="meter" id="meter" style="width:100%;" height="30" class="mt-3"></canvas>
        <button @click="start" class="button is-primary mt-3 start">
          <i class="fas fa-play mr-2"></i> Start
        </button>
        <button class="button is-dark" @click="stopped = true">
          <i class="fas fa-stop mr-2"></i> Stop
        </button>
      </div>

      <div id="log">
        <div class="p-4 m-3 itemLog" v-for="index in alarmCount" :key="index">
          <span class="tag is-dark">{{ index }}</span> Ruido detectado
          <div class="has-background-danger p-4 delLog" @click="deleteLog" style>
            <i class="fas fa-trash"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Utils from "../../utils.js";

export default {
  props: ["code"],
  created() {
    this.audio = new Audio("/sound/alarm.mp3");
  },
  data() {
    return {
      audioContext: null,
      meter: null,
      canvasContext: null,
      width: 400,
      height: 50,
      rafID: null,
      sttoped: true,
      tolerance: 5,
      prevTime: 0,
      audio: null,
      alarmCount: 0,
      countHp: 0,
      countXp: 0,
      countGold: 0,
      hp: 1,
      xp: 5,
      gold: 10
    };
  },
  computed: {},
  mounted() {},
  methods: {
    accept() {
      axios
        .post("/classroom/" + this.code + "/utils/meter", {
          gold: this.gold * this.alarmCount * this.countGold * -1,
          hp: this.hp * this.alarmCount * this.countHp * -1,
          xp: this.xp * this.alarmCount * this.countXp * -1
        })
        .then(reponse => {
          location.href = '/classroom/' + this.code
        });
    },
    deleteLog() {
      this.alarmCount--;
    },
    onMicrophoneDenied() {
      alert("It's mandatory to grant microphone access");
    },
    onLevelChange(time) {
      // clear the background
      this.canvasContext.clearRect(0, 0, this.width, this.height);

      // check if we're currently clipping
      if (this.meter.checkClipping()) this.canvasContext.fillStyle = "red";
      else this.canvasContext.fillStyle = "green";

      if (time - this.prevTime > 1500 && !this.stopped) {
        if (this.meter.volume > this.tolerance / 20) {
          this.audio.play();
          this.alarmCount++;
        }
        this.prevTime = time;
      }

      // draw a bar based on the current volume
      this.canvasContext.fillRect(
        0,
        0,
        this.meter.volume * this.width * 1.4,
        this.height
      );

      // set up the next visual callback
      this.rafID = window.requestAnimationFrame(this.onLevelChange);
    },

    onMicrophoneGranted(stream) {
      // Create an AudioNode from the stream.
      var mediaStreamSource = this.audioContext.createMediaStreamSource(stream);

      // Create a new volume meter and connect it.
      this.meter = Utils.createAudioMeter(this.audioContext);
      mediaStreamSource.connect(this.meter);

      // kick off the visual updating
      this.onLevelChange();
    },
    start() {
      this.stopped = false;
      // grab our canvas
      this.canvasContext = this.$refs.meter.getContext("2d");

      // monkeypatch Web Audio
      window.AudioContext = window.AudioContext || window.webkitAudioContext;

      // grab an audio context
      this.audioContext = new AudioContext();

      navigator.getUserMedia =
        navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

      if (typeof navigator.mediaDevices.getUserMedia === "undefined") {
        navigator.getUserMedia(
          {
            audio: true
          },
          this.onMicrophoneGranted,
          this.onMicrophoneDenied
        );
      } else {
        navigator.mediaDevices
          .getUserMedia({
            audio: true
          })
          .then(this.onMicrophoneGranted);
      }
    }
  }
};
</script>

<style>
#meter {
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.8);
  border-radius: 10px;
  clear: both;
}
.propertyMeter {
  display: inline-block;
  width: 40%;
}
.itemLog {
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.8);
  border: 1px solid #555;
  border-radius: 5px;
}
.bootstrapInlineForm {
  width: 60%;
}
.sensitivity {
  margin-top: 35px;
  position: relative;
  padding-bottom: 15px;
}
.sensitivity .left {
  padding: 4px;
  background-color: white;
  position: absolute;
  top: -21px;
  left: 0;
  border-radius: 4px;
}
.sensitivity .center {
  padding: 4px;
  background-color: white;
  position: absolute;
  top: -21px;
  left: 50%;
  margin-left: -20px;
  border-radius: 4px;
}
.sensitivity .right {
  padding: 4px;
  background-color: white;
  position: absolute;
  top: -21px;
  right: 0;
  border-radius: 4px;
}
.itemLog {
  position: relative;
}
.delLog {
  display: flex;
  align-items: center;
  align-content: center;
  position: absolute;
  top: 0;
  right: 0;
  padding: 20px;
  color: white;
  height: 100%;
  cursor: pointer;
}
#info {
  display: flex;
  align-items: center;
  align-content: center;
}
.acceptDestiny {
  cursor: pointer;
}
@media screen and (max-width: 700px) {
  .flexC {
    display: block;
  }
}
</style>
  