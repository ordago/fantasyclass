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
          >
        </div>

        <a
          class="button is-primary"
          :href="'/classroom/' + code + '/shop/create'"
          >{{ trans.get("shop.new_item") }}</a
        >

        <div
          v-for="item in items"
          class="columns is-multiline is-variable is-1 has-all-centered p-3 has-hr"
          v-bind:key="item.id"
        >
          <div class="column is-narrow is-relative">
            <div class="lvl-item-top-left" v-if="item.min_lvl">
              <img src="/img/cardgen/lvl.png" class="levelCard" />
              <span class="is-flex has-all-centered">{{ item.min_lvl }}</span>
            </div>
            <img :src="item.icon" width="48px" />
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-static">
                        <i class="fas fa-heart colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        disabled
                        class="input"
                        style="border: 1px solid; width: 100px"
                        v-model="item.hp"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-static">
                        <i class="fas fa-fist-raised colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        disabled
                        style="border: 1px solid; width: 100px"
                        v-model="item.xp"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-static">
                        <i class="fas fa-club colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        disabled
                        style="border: 1px solid; width: 100px"
                        v-model="item.slot"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="column is-narrow">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field is-expanded">
                  <div class="field has-addons">
                    <p class="control">
                      <a class="button is-static">
                        Price
                        <i class="fas fa-coins colored"></i>
                      </a>
                    </p>
                    <p class="control is-expanded">
                      <input
                        type="number"
                        class="input"
                        disabled
                        style="border: 1px solid; width: 100px"
                        v-model="item.price"
                      />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="column is-narrow">
            <div class="field">
              <b-switch
                v-model="item.for_sale"
                @input="updateForSale(item)"
                true-value="1"
                false-value="0"
                >{{ trans.get('shop.for_sale') }}</b-switch
              >
            </div>
          </div>
          <div class="column is-narrow">
            <textarea
              class="input"
              :placeholder="trans.get('shop.description')"
              disabled
              style="border: 1px solid"
              v-model="item.description"
            ></textarea>
          </div>
          <a :href="'/classroom/' + code + '/shop/' + item.id" class="button">
            <i class="fas fa-edit"></i>
          </a>
          <button class="button is-danger ml-2" @click="deleteItem(item.id)">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
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
        .then((response) => {});
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
