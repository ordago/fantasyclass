<template>
  <div id="board">
    <div
      v-for="(row, index) in letterArray"
      :key="index"
      :class="[
        'row',
        shakeRowIndex === index && 'shake',
        success && currentRowIndex === index && 'jump',
      ]"
    >
      <div
        v-for="(tile, index) in row"
        :key="index"
        :class="['tile', tile.letter && 'filled', tile.state && 'revealed']"
      >
        <div class="front" :style="{ transitionDelay: `${index * 300}ms` }">
          {{ tile.letter }}
        </div>
        <div
          :class="['back', tile.state]"
          :style="{
            transitionDelay: `${index * 300}ms`,
            animationDelay: `${index * 100}ms`,
          }"
        >
          {{ tile.letter }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LetterGrid",
  props: ["letterArray", "rightSpot", "rightLetter", "row"],
  mounted() {
    document.getElementsByClassName('row').forEach(element => {
      element.style.gridTemplateColumns =  `repeat(${this.row}, 1fr)`
    });
  },
  data() {
    return {
      shakeRowIndex: null,
      success: null,
    };
  },
  computed: {
    cssVars() {
      return {
        '--rows': this.row,
      }
    }
  },
};
</script>

<style scoped lang="scss">
/* .table-container {
  margin: 0;
  padding: 15px;
}
table {
  margin: 0 auto;
}
.tile {
  width: 50px;
  height: 50px;
  color: black;
  font-size: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  transition: all 1s;
}
.tile.green,
.tile.yellow {
  animation: rotate 1s;
}

@keyframes rotate {
  0% {
  }
  50% {
    transform: rotateY(90deg);
  }
  90% {
    transform: rotateY(0deg);
  }
}
.gray {
  background-color: white;
  margin: 2px;
  border: 2px solid #cccccc;
  border-radius: 5px;
}
.green {
  background-color: #3fc736;
  color: white;
}
.yellow {
  background-color: #ebbd4b;
  color: white;
} */

#board {
  display: grid;
  grid-template-rows: repeat(6, 1fr);
  grid-gap: 5px;
  padding: 10px;
  box-sizing: border-box;
  --height: min(420px, calc(var(--vh, 100vh) - 310px));
  height: var(--height);
  width: min(350px, calc(var(--height) / 6 * 5));
  margin: 0px auto;
}
.message {
  position: absolute;
  left: 50%;
  top: 80px;
  color: #fff;
  background-color: rgba(0, 0, 0, 0.85);
  padding: 16px 20px;
  z-index: 2;
  border-radius: 4px;
  transform: translateX(-50%);
  transition: opacity 0.3s ease-out;
  font-weight: 600;
}
.message.v-leave-to {
  opacity: 0;
}
.row {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-gap: 5px;
}
.tile {
  width: 100%;
  font-size: 2rem;
  line-height: 2rem;
  font-weight: bold;
  vertical-align: middle;
  text-transform: uppercase;
  user-select: none;
  position: relative;
}
.tile.filled {
  animation: zoom 0.2s;
}
.tile .front,
.tile .back {
  border-radius: 5px;
  box-sizing: border-box;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  transition: transform 0.6s;
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
}
.tile .front {
  border: 2px solid #d3d6da;
}
.tile.filled .front {
  border-color: #999;
}
.tile .back {
  transform: rotateX(180deg);
}
.tile.revealed .front {
  transform: rotateX(180deg);
}
.tile.revealed .back {
  transform: rotateX(0deg);
}
@keyframes zoom {
  0% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
.shake {
  animation: shake 0.5s;
}
@keyframes shake {
  0% {
    transform: translate(1px);
  }
  10% {
    transform: translate(-2px);
  }
  20% {
    transform: translate(2px);
  }
  30% {
    transform: translate(-2px);
  }
  40% {
    transform: translate(2px);
  }
  50% {
    transform: translate(-2px);
  }
  60% {
    transform: translate(2px);
  }
  70% {
    transform: translate(-2px);
  }
  80% {
    transform: translate(2px);
  }
  90% {
    transform: translate(-2px);
  }
  100% {
    transform: translate(1px);
  }
}
.jump .tile .back {
  animation: jump 0.5s;
}
@keyframes jump {
  0% {
    transform: translateY(0px);
  }
  20% {
    transform: translateY(5px);
  }
  60% {
    transform: translateY(-25px);
  }
  90% {
    transform: translateY(3px);
  }
  100% {
    transform: translateY(0px);
  }
}
</style>