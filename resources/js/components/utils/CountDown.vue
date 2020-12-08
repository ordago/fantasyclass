<template>
  <div class="base-timer" style="">
    <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <g class="base-timer__circle">
        <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45" />
        <path
          :stroke-dasharray="circleDasharray"
          class="base-timer__path-remaining"
          :class="remainingPathColor"
          d="
            M 50, 50
            m -45, 0
            a 45,45 0 1,0 90,0
            a 45,45 0 1,0 -90,0
          "
        />
      </g>
    </svg>
    <span class="base-timer__label">{{ formattedTimeLeft }}</span>
    <div class="has-text-centered">
      <b-timepicker enable-seconds v-model="timeConfigured" inline :input="calculateSeconds()"></b-timepicker>
      <button class="button mt-2 is-success" v-if="pause" @click="startTimer">Start</button>
      <button class="button mt-2 is-danger" v-if="pause && timePassed" @click="resetTimer">Reset</button>
      <button class="button mt-2 is-info" v-if="!pause" @click="pauseTimer">Pause</button>
    </div>
  </div>
</template>

<script>
const FULL_DASH_ARRAY = 283;
const WARNING_THRESHOLD = 10;
const ALERT_THRESHOLD = 5;

const COLOR_CODES = {
  info: {
    color: "green"
  },
  warning: {
    color: "orange",
    threshold: WARNING_THRESHOLD
  },
  alert: {
    color: "red",
    threshold: ALERT_THRESHOLD
  }
};

export default {
  props: ['starttime'],
  created() {
    if(this.starttime) {
      this.timeConfigured = this.starttime
      this.startTimer()
    }
  },
  data() {
    return {
      timeConfigured: new Date(1,1,1, 0, 10, 0),
      timePassed: 0,
      timerInterval: null,
      time: 20,
      pause: true,
    };
  },

  computed: {
    circleDasharray() {
      return `${(this.timeFraction * FULL_DASH_ARRAY).toFixed(0)} 283`;
    },

    formattedTimeLeft() {
      const timeLeft = this.timeLeft;
      const minutes = Math.floor(timeLeft / 60);
      let seconds = timeLeft % 60;

      if (seconds < 10) {
        seconds = `0${seconds}`;
      }

      return `${minutes}:${seconds}`;
    },

    timeLeft() {
      return this.time - this.timePassed;
    },

    timeFraction() {
      const rawTimeFraction = this.timeLeft / this.time;
      return rawTimeFraction - (1 / this.time) * (1 - rawTimeFraction);
    },

    remainingPathColor() {
      const { alert, warning, info } = COLOR_CODES;

      if (this.timeLeft <= alert.threshold) {
        return alert.color;
      } else if (this.timeLeft <= warning.threshold) {
        return warning.color;
      } else {
        return info.color;
      }
    }
  },

  watch: {
    timeLeft(newValue) {
      if (newValue === 0) {
        this.onTimesUp();
      }
    }
  },

  mounted() {
  },

  methods: {
    calculateSeconds(info) {
        let seconds = 0
        if(this.timeConfigured)
            seconds = this.timeConfigured.getHours() * 60 * 60 + this.timeConfigured.getMinutes() * 60 + this.timeConfigured.getSeconds()
        this.time = seconds
    },
    onTimesUp() {
      clearInterval(this.timerInterval);
      this.resetTimer();
      this.pause = !this.pause;
      var audio = new Audio("/sound/beep.mp3");
      audio.play();
    },
    pauseTimer() {
      this.pause=!this.pause
      clearInterval(this.timerInterval);
    },
    resetTimer() {
      this.timePassed = 0
      clearInterval(this.timerInterval);
    },
    startTimer() {
      this.pause=!this.pause
      this.timerInterval = setInterval(() => (this.timePassed += 1), 1000);
    }
  }
};
</script>

<style scoped lang="scss">
.base-timer {
  position: relative;
  width: 300px;
  height: 300px;

  &__svg {
    transform: scaleX(-1);
  }

  &__circle {
    fill: none;
    stroke: none;
  }

  &__path-elapsed {
    stroke-width: 7px;
    stroke: grey;
  }

  &__path-remaining {
    stroke-width: 7px;
    stroke-linecap: round;
    transform: rotate(90deg);
    transform-origin: center;
    transition: 1s linear all;
    fill-rule: nonzero;
    stroke: currentColor;

    &.green {
      color: rgb(65, 184, 131);
    }

    &.orange {
      color: orange;
    }

    &.red {
      color: red;
    }
  }

  &__label {
    position: absolute;
    width: 300px;
    height: 300px;
    top: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
  }
}
</style>
