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
  <!-- <div class="table-container">
    <table>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('00') ? 'green' : 'gray',
              rightLetter.includes('00') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][0] ? letterArray[0][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('01') ? 'green' : 'gray',
              rightLetter.includes('01') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][1] ? letterArray[0][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('02') ? 'green' : 'gray',
              rightLetter.includes('02') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][2] ? letterArray[0][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('03') ? 'green' : 'gray',
              rightLetter.includes('03') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][3] ? letterArray[0][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('04') ? 'green' : 'gray',
              rightLetter.includes('04') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][4] ? letterArray[0][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('10') ? 'green' : 'gray',
              rightLetter.includes('10') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][0] ? letterArray[1][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('11') ? 'green' : 'gray',
              rightLetter.includes('11') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][1] ? letterArray[1][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('12') ? 'green' : 'gray',
              rightLetter.includes('12') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][2] ? letterArray[1][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('13') ? 'green' : 'gray',
              rightLetter.includes('13') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][3] ? letterArray[1][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('14') ? 'green' : 'gray',
              rightLetter.includes('14') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][4] ? letterArray[1][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('20') ? 'green' : 'gray',
              rightLetter.includes('20') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][0] ? letterArray[2][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('21') ? 'green' : 'gray',
              rightLetter.includes('21') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][1] ? letterArray[2][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('22') ? 'green' : 'gray',
              rightLetter.includes('22') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][2] ? letterArray[2][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('23') ? 'green' : 'gray',
              rightLetter.includes('23') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][3] ? letterArray[2][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('24') ? 'green' : 'gray',
              rightLetter.includes('24') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][4] ? letterArray[2][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td><div class="table-container">
    <table>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('00') ? 'green' : 'gray',
              rightLetter.includes('00') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][0] ? letterArray[0][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('01') ? 'green' : 'gray',
              rightLetter.includes('01') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][1] ? letterArray[0][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('02') ? 'green' : 'gray',
              rightLetter.includes('02') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][2] ? letterArray[0][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('03') ? 'green' : 'gray',
              rightLetter.includes('03') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][3] ? letterArray[0][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('04') ? 'green' : 'gray',
              rightLetter.includes('04') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[0][4] ? letterArray[0][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('10') ? 'green' : 'gray',
              rightLetter.includes('10') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][0] ? letterArray[1][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('11') ? 'green' : 'gray',
              rightLetter.includes('11') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][1] ? letterArray[1][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('12') ? 'green' : 'gray',
              rightLetter.includes('12') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][2] ? letterArray[1][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('13') ? 'green' : 'gray',
              rightLetter.includes('13') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][3] ? letterArray[1][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('14') ? 'green' : 'gray',
              rightLetter.includes('14') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[1][4] ? letterArray[1][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('20') ? 'green' : 'gray',
              rightLetter.includes('20') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][0] ? letterArray[2][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('21') ? 'green' : 'gray',
              rightLetter.includes('21') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][1] ? letterArray[2][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('22') ? 'green' : 'gray',
              rightLetter.includes('22') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][2] ? letterArray[2][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('23') ? 'green' : 'gray',
              rightLetter.includes('23') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][3] ? letterArray[2][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('24') ? 'green' : 'gray',
              rightLetter.includes('24') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[2][4] ? letterArray[2][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('30') ? 'green' : 'gray',
              rightLetter.includes('30') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][0] ? letterArray[3][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('31') ? 'green' : 'gray',
              rightLetter.includes('31') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][1] ? letterArray[3][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('32') ? 'green' : 'gray',
              rightLetter.includes('32') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][2] ? letterArray[3][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('33') ? 'green' : 'gray',
              rightLetter.includes('33') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][3] ? letterArray[3][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('34') ? 'green' : 'gray',
              rightLetter.includes('34') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][4] ? letterArray[3][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('40') ? 'green' : 'gray',
              rightLetter.includes('40') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][0] ? letterArray[4][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('41') ? 'green' : 'gray',
              rightLetter.includes('41') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][1] ? letterArray[4][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('42') ? 'green' : 'gray',
              rightLetter.includes('42') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][2] ? letterArray[4][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('43') ? 'green' : 'gray',
              rightLetter.includes('43') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][3] ? letterArray[4][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('44') ? 'green' : 'gray',
              rightLetter.includes('44') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][4] ? letterArray[4][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('50') ? 'green' : 'gray',
              rightLetter.includes('50') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][0] ? letterArray[5][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('51') ? 'green' : 'gray',
              rightLetter.includes('51') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][1] ? letterArray[5][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('52') ? 'green' : 'gray',
              rightLetter.includes('52') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][2] ? letterArray[5][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('53') ? 'green' : 'gray',
              rightLetter.includes('53') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][3] ? letterArray[5][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('54') ? 'green' : 'gray',
              rightLetter.includes('54') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][4] ? letterArray[5][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
    </table>
  </div>
          <div
            v-bind:class="[
              rightSpot.includes('30') ? 'green' : 'gray',
              rightLetter.includes('30') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][0] ? letterArray[3][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('31') ? 'green' : 'gray',
              rightLetter.includes('31') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][1] ? letterArray[3][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('32') ? 'green' : 'gray',
              rightLetter.includes('32') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][2] ? letterArray[3][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('33') ? 'green' : 'gray',
              rightLetter.includes('33') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][3] ? letterArray[3][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('34') ? 'green' : 'gray',
              rightLetter.includes('34') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[3][4] ? letterArray[3][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('40') ? 'green' : 'gray',
              rightLetter.includes('40') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][0] ? letterArray[4][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('41') ? 'green' : 'gray',
              rightLetter.includes('41') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][1] ? letterArray[4][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('42') ? 'green' : 'gray',
              rightLetter.includes('42') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][2] ? letterArray[4][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('43') ? 'green' : 'gray',
              rightLetter.includes('43') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][3] ? letterArray[4][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('44') ? 'green' : 'gray',
              rightLetter.includes('44') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[4][4] ? letterArray[4][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('50') ? 'green' : 'gray',
              rightLetter.includes('50') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][0] ? letterArray[5][0].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('51') ? 'green' : 'gray',
              rightLetter.includes('51') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][1] ? letterArray[5][1].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('52') ? 'green' : 'gray',
              rightLetter.includes('52') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][2] ? letterArray[5][2].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('53') ? 'green' : 'gray',
              rightLetter.includes('53') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][3] ? letterArray[5][3].toUpperCase() : "" }}
          </div>
        </td>
        <td>
          <div
            v-bind:class="[
              rightSpot.includes('54') ? 'green' : 'gray',
              rightLetter.includes('54') ? 'yellow' : 'gray',
            ]"
            class="tile"
          >
            {{ letterArray[5][4] ? letterArray[5][4].toUpperCase() : "" }}
          </div>
        </td>
      </tr>
    </table>
  </div> -->
</template>

<script>
export default {
  name: "LetterGrid",
  props: ["letterArray", "rightSpot", "rightLetter"],
  data() {
    return {
      shakeRowIndex: null,
      success: null,
    };
  },
};
</script>

<style scoped>
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