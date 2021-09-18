<template>
  <div>
    <b-tabs v-model="activeTab">
      <b-tab-item label="Items" icon-pack="fa" class="p-4">
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="items_visibility"
            passive-type="is-danger"
            @input="toggleVisibility('items_visibility')"
            >{{ trans.get("shop.visibility") }}</b-switch
          ><br />
          <b-switch
            :value="true"
            type="is-info"
            v-model="show_recipes"
            passive-type="is-danger"
            class="mt-2"
            @input="toggleVisibility('show_recipes')"
            >{{ trans.get("shop.show_recipes") }}</b-switch
          >
        </div>

        <a
          class="button is-primary"
          :href="'/classroom/' + code + '/shop/create'"
          >{{ trans.get("shop.new_item") }}</a
        >

        <div
          class="columns is-multiline is-variable is-1 has-all-centered mt-3"
          style="box-sizing: border-box"
        >
          <div
            class="p-1 column is-4-tablet is-12-mobile is-2-desktop"
            v-for="item in items"
            v-bind:key="item.id"
            style="box-sizing: border-box"
          >
            <div
              class="card"
              :class="{ 'has-background-success-light': item.for_sale == 1 }"
            >
              <div class="card-image pb-0">
                <div class="column is-narrow is-relative has-text-centered">
                  <div class="lvl-item-top-left" v-if="item.min_lvl">
                    <img src="/img/cardgen/lvl.png" class="levelCard" />
                    <span class="is-flex has-all-centered">{{
                      item.min_lvl
                    }}</span>
                  </div>
                  <div>
                    <img
                      @contextmenu.prevent=""
                      :src="item.icon"
                      width="48px"
                    />
                  </div>
                  <div>
                    <b-switch
                      v-model="item.for_sale"
                      @input="updateForSale(item)"
                      true-value="1"
                      false-value="0"
                      >{{ trans.get("shop.for_sale") }}</b-switch
                    >
                  </div>
                </div>
              </div>
              <div class="card-content pt-0">
                <div class="content">
                  <div class="my-1">
                    {{ trans.get("shop.price") }}: {{ item.price }}
                    <i class="fas fa-coins colored"></i>
                  </div>
                  <div class="my-1" v-if="item.hp">
                    <i class="fas fa-heart colored"></i>: {{ item.hp }}
                    <i class="fas fa-arrow-up"></i>
                  </div>
                  <div class="my-1" v-if="item.xp">
                    <i class="fas fa-fist-raised colored"></i>: {{ item.xp }}
                    <i class="fas fa-arrow-up"></i>
                  </div>
                  <div class="my-1" v-if="item.slot">
                    <i class="fak fa-deck colored"></i>: {{ item.slot }}
                    <i class="fas fa-arrow-up"></i>
                  </div>
                  <div
                    class="my-1 p-2 rounded has-background-link-light border"
                    v-if="item.description"
                  >
                    {{ item.description }}
                  </div>
                  <div class="my-2" v-if="item.craft && item.craft.length">
                    <i class="fad fa-hammer" style="font-size: 1.5em"></i>:
                    <img
                      width="20px"
                      @contextmenu.prevent=""
                      :src="img.src"
                      v-for="img in item.craft"
                      :key="img.id"
                    />
                  </div>
                  <div v-tippy :content="trans.get('shop.undead')" class="my-2" v-if="item.undead">
                    <i class="fas fa-skull"></i>
                  </div>
                  <div>
                    <a
                      :href="'/classroom/' + code + '/shop/' + item.id"
                      class="button"
                    >
                      <i class="fas fa-edit"></i>
                    </a>
                    <button
                      class="button is-danger ml-2"
                      @click="deleteItem(item.id)"
                    >
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </b-tab-item>

      <b-tab-item :label="trans.get('menu.cards')" icon-pack="fa" class="p-4">
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="allow_buy_cards"
            passive-type="is-danger"
            @input="toggleVisibility('allow_buy_cards')"
            >{{ trans.get("shop.visibility") }}</b-switch
          >
        </div>
        <b-field :label="trans.get('shop.price')" class="mt-4">
          <b-numberinput
            controls-position="compact"
            v-model="config.card_price"
          ></b-numberinput>
        </b-field>
        <button class="button is-primary" @click="save(99)">
          <i class="fas fa-save mr-2"></i>
          {{ trans.get("general.save") }}
        </button>
      </b-tab-item>
      <b-tab-item
        v-if="character"
        :label="trans.get('shop.eq1')"
        icon-pack="fa"
        class="p-4"
      >
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="equipment_1_visibility"
            passive-type="is-danger"
            @input="toggleVisibility('equipment_1_visibility')"
            >{{ trans.get("shop.visibility") }}</b-switch
          >

          <b-field :label="trans.get('shop.multiplier')" class="mt-4">
            <b-numberinput
              @input="$forceUpdate()"
              controls-position="compact"
              step=".05"
              v-model="config.multiplier1"
            ></b-numberinput>
          </b-field>
          <button class="button is-primary" @click="save(1)">
            <i class="fas fa-save mr-2"></i>
            {{ trans.get("general.save") }}
          </button>
        </div>
        <div
          v-for="(char, index) in shop['eq1']"
          :key="index"
          class="is-flex has-border-dark m-2"
        >
          <div
            v-for="item in char"
            :key="index + '-' + item.id"
            class="is-flex has-all-centered m-4 has-border"
          >
            <img
              @contextmenu.prevent=""
              class="mr-3"
              :src="'/img/character/' + item.src"
              width="50px"
              height="50px"
            />
            {{ Math.round(item.price * config.multiplier1) }}
            <i class="fas fa-coins colored"></i>
          </div>
        </div>
      </b-tab-item>

      <b-tab-item
        v-if="character"
        :label="trans.get('shop.eq2')"
        icon-pack="fa"
        class="p-4"
      >
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="equipment_2_visibility"
            passive-type="is-danger"
            @input="toggleVisibility('equipment_2_visibility')"
            >{{ trans.get("shop.visibility") }}</b-switch
          >
          <b-field :label="trans.get('shop.multiplier')" class="mt-4">
            <b-numberinput
              @input="$forceUpdate()"
              controls-position="compact"
              step=".05"
              v-model="config.multiplier2"
            ></b-numberinput>
          </b-field>
          <button class="button is-primary" @click="save(2)">
            <i class="fas fa-save mr-2"></i>
            {{ trans.get("general.save") }}
          </button>
        </div>
        <div
          v-for="(char, index) in shop['eq2']"
          :key="index"
          class="is-flex has-border-dark m-2"
        >
          <div
            v-for="item in char"
            :key="index + '-' + item.id"
            class="is-flex has-all-centered m-4 has-border"
          >
            <img
              @contextmenu.prevent=""
              class="mr-3"
              :src="'/img/character/' + item.src"
              width="50px"
              height="50px"
            />
            {{ Math.round(item.price * config.multiplier2) }}
            <i class="fas fa-coins colored"></i>
          </div>
        </div>
      </b-tab-item>

      <b-tab-item
        v-if="character"
        :label="trans.get('shop.eq3')"
        icon-pack="fa"
        class="p-4"
      >
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="equipment_3_visibility"
            passive-type="is-danger"
            @input="toggleVisibility('equipment_3_visibility')"
            >{{ trans.get("shop.visibility") }}</b-switch
          >
          <b-field :label="trans.get('shop.multiplier')" class="mt-4">
            <b-numberinput
              @input="$forceUpdate()"
              controls-position="compact"
              step=".05"
              v-model="config.multiplier3"
            ></b-numberinput>
          </b-field>
          <button class="button is-primary" @click="save(3)">
            <i class="fas fa-save mr-2"></i>
            {{ trans.get("general.save") }}
          </button>
        </div>
        <div
          v-for="(char, index) in shop['eq3']"
          :key="index"
          class="is-flex has-border-dark m-2"
        >
          <div
            v-for="item in char"
            :key="index + '-' + item.id"
            class="is-flex has-all-centered m-4 has-border"
          >
            <img
              @contextmenu.prevent=""
              class="mr-3"
              :src="'/img/character/' + item.src"
              width="50px"
              height="50px"
            />
            {{ Math.round(item.price * config.multiplier3) }}
            <i class="fas fa-coins colored"></i>
          </div>
        </div>
      </b-tab-item>
    </b-tabs>
  </div>
</template>

<script>
export default {
  props: ["items", "config", "code", "character", "shop"],
  mounted() {},
  data: function () {
    return {
      activeTab: 0,
      items_visibility: this.config.items_visibility,
      equipment_1_visibility: this.config.equipment_1_visibility ? true : false,
      equipment_2_visibility: this.config.equipment_2_visibility ? true : false,
      equipment_3_visibility: this.config.equipment_3_visibility ? true : false,
      show_recipes: this.config.show_recipes ? true : false,
      allow_buy_cards: this.config.allow_buy_cards ? true : false,
      forceUpdate: 0,
      nom: "",
      visible: false,
    };
  },
  methods: {
    toggleVisibility(prop) {
      axios
        .patch("/classroom/" + this.code + "/setting", {
          _method: "patch",
          prop: prop,
          action: "toggle",
        })
        .then((response) => {});
    },
    updateForSale(item) {
      axios
        .patch("/classroom/" + this.code + "/shop/forsale", {
          _method: "patch",
          id: item.id,
          for_sale: item.for_sale,
        })
        .then((response) => {
          this.$forceUpdate();
        });
    },
    save(eq) {
      let key;
      let value;
      switch (eq) {
        case 1:
          key = "shop_multiplier_1";
          value = this.config.multiplier1;
          break;
        case 2:
          key = "shop_multiplier_2";
          value = this.config.multiplier2;
          break;
        case 3:
          key = "shop_multiplier_3";
          value = this.config.multiplier3;
          break;
        case 99:
          key = "card_price";
          value = this.config.card_price;
          break;
      }
      axios
        .patch("/classroom/" + this.code + "/setting", {
          _method: "patch",
          prop: key,
          value: value,
          action: "update",
        })
        .then((response) => {
          this.$toast(this.trans.get("success_error.update_success"), {
            type: "success",
          });
        });
    },
    deleteItem(id) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          var index = this.items.findIndex(function (item, i) {
            return item.id === id;
          });
          axios.delete("/classroom/shop/" + id).then((response) => {
            if (response.data === 1) {
              this.items.splice(index, 1);
              this.$forceUpdate();
            }
          });
        },
      });
    },
  },
  computed: {
    visibilityItems() {
      if (this.items_visibility)
        return "<i class='fas fa-eye-slash'></i> <span class='pl-2'>Make invisible</span>";
      return "<i class='fas fa-eye'></i> <span class='pl-2'>Make visible</span>";
    },
    visibilityEq1() {
      if (this.equipment_1_visibility)
        return "<i class='fas fa-eye-slash'></i> <span class='pl-2'>Make invisible</span>";
      return "<i class='fas fa-eye'></i> <span class='pl-2'>Make visible</span>";
    },
    visibilityEq2() {
      if (this.equipment_2_visibility)
        return "<i class='fas fa-eye-slash'></i> <span class='pl-2'>Make invisible</span>";
      return "<i class='fas fa-eye'></i> <span class='pl-2'>Make visible</span>";
    },
    visibilityEq3() {
      if (this.equipment_3_visibility)
        return "<i class='fas fa-eye-slash'></i> <span class='pl-2'>Make invisible</span>";
      return "<i class='fas fa-eye'></i> <span class='pl-2'>Make visible</span>";
    },
    getIconItem() {
      return this.items_visibility ? "eye-slash" : "eye";
    },
  },
};
</script>
