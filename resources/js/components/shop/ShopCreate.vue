<template>
  <div class="has-padding-3">
    <div class="rounded">
      <croppa
        v-model="image"
        :width="60"
        :height="60"
        accept="image/*"
        placeholder="Image"
        :placeholder-font-size="16"
        canvas-color="transparent"
        :show-remove-button="true"
        remove-button-color="black"
        class="rounded"
        :show-loading="true"
        :loading-size="50"
        :initial-image="prevImage"
      ></croppa>
    </div>
    <div class="columns has-margin-top-2">
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div
                class="field has-addons"
                v-tippy
                :content="trans.get('shop.item_hp')"
              >
                <p class="control">
                  <a class="button is-static">
                    <i class="fas fa-heart colored"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="hp" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div
                class="field has-addons"
                v-tippy
                :content="trans.get('shop.item_xp')"
              >
                <p class="control">
                  <a class="button is-static">
                    <i class="fas fa-fist-raised colored"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="xp" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div class="field has-addons">
                <p class="control">
                  <a class="button is-static">
                    {{ trans.get('shop.price') }}
                    <i class="fas fa-coins colored"></i>
                  </a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="price" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="field is-horizontal">
          <div class="field-body">
            <div class="field is-expanded">
              <div
                class="field has-addons"
                v-tippy
                :content="trans.get('shop.min_level_info')"
              >
                <p class="control">
                  <a class="button is-static">{{ trans.get('shop.min_level') }}</a>
                </p>
                <p class="control is-expanded">
                  <input type="number" class="input" v-model="min_lvl" />
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <textarea class="input" :placeholder="trans.get('shop.description')" v-model="description"></textarea>
      </div>
    </div>
    <button class="button is-primary" v-if="!item" @click="createItem()"><i class="fas fa-plus"></i> {{ trans.get('general.create') }}</button>
    <button class="button is-link" v-if="item" @click="createItem()"><i class="fas fa-edit"></i> {{ trans.get('general.edit') }}</button>
  </div>
</template>

<script>
export default {
  props: ['code', 'item'],
  created() {
    if(this.item) {
      this.id = this.item.id
      this.hp = this.item.hp ? this.item.hp : 0 
      this.xp = this.item.xp  ? this.item.xp : 0
      this.min_lvl = this.item.min_lvl  ? this.item.min_lvl : 0
      this.price = this.item.price  ? this.item.price : 0
      this.description = this.item.description ? this.item.description : ''
      this.prevImage = this.item.icon
    }
  },
  data: function() {
    return {
      image: {},
      hp: 0,
      xp: 0,
      min_lvl: 0,
      price: 0,
      description: "",
      prevImage: '',
      id: null,
    };
  },
  methods: {
    createItem() {
      this.image.generateBlob(
        blob => {
          if (blob != null) {
            let formData = new FormData();
            formData.append("icon", blob, "item.png");
            formData.append("hp", this.hp);
            formData.append("xp", this.xp);
            formData.append("min_lvl", this.min_lvl);
            formData.append("price", this.price);
            formData.append("description", this.description);

            if(this.item) {
              formData.append('id', this.id)
              formData.append('_method', 'patch')
            }
            axios
              .post("/classroom/" + this.code + "/shop", formData, {
                headers: {
                  "content-type": "multipart/form-data"
                }
              })
              .then(response => {
                
                this.$toasted.show(response.data.message, {
                  position: "top-center",
                  duration: 3000,
                  iconPack: "fontawesome",
                  icon: response.data.icon,
                  type: response.data.type
                });
              });
          }
        },
        "image/png",
        0.8
      );
    }
  },
  computed: {}
};
</script>
