<template>
  <div class="collectionable">
    <span class="collectionable-count" v-if="!admin && count > 0">
      {{ count }}
    </span>
    <img
      width="200px"
      class="top-collection"
      @contextmenu.prevent=""
      :src="getImageCollectionable(collectionable.type)"
    />
    <img
      width="200px"
      class="bg-collection"
      @contextmenu.prevent=""
      src="/img/cardgen/collections/bg.png"
    />
    <img
      width="200px"
      @contextmenu.prevent=""
      class="img-collection rounded"
      :src="collectionable.src"
    />
    <h1 class="is-size-6">
      {{ collectionable.name }}
    </h1>
  </div>
</template>

<script>
// import Utils from "../../utils.js";

export default {
  props: ['admin', 'collectionable', 'count'],
  created() {},
  data: function () {
    return {};
  },
  methods: {
    getImageCollectionable(type) {
      switch (type) {
        case 1:
          return "/img/cardgen/collections/front-earth.png";
        case 2:
          return "/img/cardgen/collections/front-wind.png";
        case 3:
          return "/img/cardgen/collections/front-water.png";
        case 4:
          return "/img/cardgen/collections/front-fire.png";
      }
    },
  },
};
</script>
<style>
.collectionable-count {
  width: 40px;
  height: 40px;
  font-size: 2em;
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  background-image: url(/img/cardgen/collections/count.png);
  color: white;
  text-align: center;
  top: -5px;
  left: -10px;
  z-index: 10;
  text-shadow: 1px 1px 1px black;
}
.collectionable-container {
  width: 200px;
  display: inline-block;
}
.collectionable {
  width: 200px;
  height: 280px;
  position: relative;
}
.img-collection {
  width: 150px;
  position: absolute;
  z-index: 2;
  left: 25px;
  top: 45px;
  filter: drop-shadow(0rem 0rem 3px rgb(255, 255, 255));
}
.collectionable h1 {
  position: absolute;
  bottom: 30px;
  left: 0;
  margin: 0 10px;
  width: 90%;
  text-align: center;
  color: white;
  text-shadow: 1px 1px 1px black;
  z-index: 2;
}
.top-collection {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
}
.bg-collection {
  z-index: 0;
  position: absolute;
  top: 0;
  left: 0;
}
</style>