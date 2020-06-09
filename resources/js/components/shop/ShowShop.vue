<template>
  <div>
    <b-tabs v-model="activeTab">
      <b-tab-item label="Items" icon-pack="fa" class="has-padding-x-4">
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="items_visibility"
            passive-type="is-danger"
            @input="toggleVisibility('items_visibility')"
          >Visibility</b-switch>
        </div>

        <a class="button is-primary" :href="'/classroom/'+ code + '/shop/create'">New item</a>

        <div
          v-for="item in items"
          class="columns is-multiline is-variable is-1 is-all-centered has-padding-3"
          style="border-bottom: 1px dashed #999"
          v-bind:key="item.id"
        >
          <div class="column is-narrow">
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
                      <input type="number" disabled class="input" style="border: 1px solid" v-model="item.hp" />
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
                      <input type="number" class="input" disabled style="border: 1px solid" v-model="item.xp" />
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
                      <input type="number" class="input" disabled style="border: 1px solid" v-model="item.price" />
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="column is-narrow">
            <div class="field">
              <b-switch v-model="item.for_sale" @input="updateForSale(item)" true-value="1" false-value="0">For sale?</b-switch>
            </div>
          </div>
          <div class="column is-narrow">
            <textarea class="input" placeholder="Description" disabled style="border: 1px solid" v-model="item.description"></textarea>
          </div>
          <a :href="'/classroom/' + code + '/shop/' + item.id" class="button">
            <i class="fas fa-edit"></i>
          </a>
          <button class="button is-danger has-margin-left-2" @click="deleteItem(item.id)">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </b-tab-item>

      <b-tab-item label="Equipment 1" icon-pack="fa" class="has-padding-x-4">
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="equipment_1_visibility"
            passive-type="is-danger"
            @input="toggleVisibility('equipment_1_visibility')"
          >Visibility</b-switch>
        </div>
      </b-tab-item>

      <b-tab-item label="Equipment 2" icon-pack="fa" class="has-padding-x-4">
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="equipment_2_visibility"
            passive-type="is-danger"
            @input="toggleVisibility('equipment_2_visibility')"
          >Visibility</b-switch>
        </div>
      </b-tab-item>

      <b-tab-item label="Equipment 3" icon-pack="fa" class="has-padding-x-4">
        <div class="field">
          <b-switch
            :value="true"
            type="is-success"
            v-model="equipment_3_visibility"
            passive-type="is-danger"
            @input="toggleVisibility('equipment_3_visibility')"
          >Visibility</b-switch>
        </div>
      </b-tab-item>
    </b-tabs>
  </div>
</template>

<script>
export default {
  props: ["items", "config", "code"],
  mounted() {},
  data: function() {
    return {
      activeTab: 0,
      items_visibility: this.config.items_visibility,
      equipment_1_visibility: this.config.equipment_1_visibility ? true : false,
      equipment_2_visibility: this.config.equipment_2_visibility ? true : false,
      equipment_3_visibility: this.config.equipment_3_visibility ? true : false,
      forceUpdate: 0
    };
  },
  methods: {
    toggleVisibility(prop) {
      axios
        .patch("/classroom/" + this.code + "/setting", {
          _method: "patch",
          prop: prop,
          action: "toggle"
        })
        .then(response => {});
    },
    updateForSale(item) {
      axios
        .patch("/classroom/" + this.code + "/shop/forsale", {
          _method: "patch",
          id: item.id,
          for_sale: item.for_sale
        })
        .then(response => {});
    },
    deleteItem(id) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete"),
        confirmText: this.trans.get("general.delete"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          var index = this.items.findIndex(function(item, i) {
            return item.id === id;
          });
          axios
            .delete("/classroom/" + this.code + "/shop/" + id)
            .then(response => {
              if (response.data === 1) {
                this.items.splice(index, 1);
                this.$forceUpdate();
              }
            });
        }
      });
    }
  },
  computed: {
    visibilityItems() {
      if (this.items_visibility)
        return "<i class='fas fa-eye-slash'></i> <span class='has-padding-left-2'>Make invisible</span>";
      return "<i class='fas fa-eye'></i> <span class='has-padding-left-2'>Make visible</span>";
    },
    visibilityEq1() {
      if (this.equipment_1_visibility)
        return "<i class='fas fa-eye-slash'></i> <span class='has-padding-left-2'>Make invisible</span>";
      return "<i class='fas fa-eye'></i> <span class='has-padding-left-2'>Make visible</span>";
    },
    visibilityEq2() {
      if (this.equipment_2_visibility)
        return "<i class='fas fa-eye-slash'></i> <span class='has-padding-left-2'>Make invisible</span>";
      return "<i class='fas fa-eye'></i> <span class='has-padding-left-2'>Make visible</span>";
    },
    visibilityEq3() {
      if (this.equipment_3_visibility)
        return "<i class='fas fa-eye-slash'></i> <span class='has-padding-left-2'>Make invisible</span>";
      return "<i class='fas fa-eye'></i> <span class='has-padding-left-2'>Make visible</span>";
    },
    getIconItem() {
      return this.items_visibility ? "eye-slash" : "eye";
    }
  }
};
</script>
