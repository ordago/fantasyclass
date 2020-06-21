<template>
  <div class="columns h-100 has-margin-right-0" v-bind:class="{ 'has-bg-student': !admin }">
    <div class="column is-narrow has-padding-right-0">
      <div class="card rounded card-shadow-s" style="min-width: 275px">
        <span
          class="level-top rounded has-padding-4 has-background-light"
          v-if="student.level"
        >{{ student.level.number }}</span>
        <div
          class="card-image card-shadow-s rounded-top char-bg"
          :style="'background-color:' + classroom.theme.color + ';background-image: url(/img/bg/thumb_' + classroom.theme.name + ');'"
        >
          <div class="character-container character character-small is-relative">
            <img
              :src="'/img/character/' + element.src"
              :class="element.classes"
              v-for="element in student.equipment"
              v-bind:key="element.id"
            />
          </div>
        </div>
        <div class="card-content">
          <div class="media has-margin-bottom-0 has-all-centered">
            <div class="media-left">
              <figure class="image is-48x48">
                <img :src="student.avatar" class="rounded" alt />
              </figure>
            </div>
            <div class="media-content">
              <p class="title is-4">{{ student.name }}</p>
              <p class="subtitle is-6">
                <small>@{{ student.username }}</small>
              </p>
            </div>
          </div>

          <div
            class="score has-padding-3 centered-attribute has-margin-1 has-margin-y-4 has-all-centered"
            style="border: none"
          >
            <span
              class="attribute has-background-white-ter has-padding-y-3 rounded"
              style="width:100%;"
            >
              <span>
                <i
                  class="fas fa-heart colored has-text-grey-light"
                  v-bind:class="{ invisible: student.hp>=30 }"
                ></i>
              </span>
              <span class="has-text-grey-light" v-show="student.hp<30">{{ student.hp }}</span>
            </span>
            <span
              class="attribute has-background-danger has-padding-y-3 rounded-left"
              v-bind:class="{ rounded: student.hp==100 }"
              :style="'width: ' + student.hp + '%'"
              v-if="student.hp>0"
            >
              <i class="fas fa-heart colored" v-bind:class="{ invisible: student.hp<30 }"></i>
              <span v-if="student.hp>=30">{{ student.hp }}</span>
            </span>
          </div>
          <div class="score has-padding-3 has-margin-1 has-margin-top-3">
            <span>
              <i class="fas fa-fist-raised colored"></i>
            </span>
            {{ student.xp }}
          </div>
          <div class="gold has-padding-3 has-margin-1 has-margin-top-2">
            <span>
              <i class="fas fa-coins colored"></i>
            </span>
            {{ student.gold }}
          </div>
        </div>
      </div>
    </div>
    <div class="column has-padding-right-0">
      <b-tabs v-model="activeTab" :key="update">
        <b-tab-item label="Information" icon="info-circle" icon-pack="fad">
          <div class>
            <div class="has-margin-3">
              <croppa
                v-model="image"
                :width="128"
                :height="128"
                accept="image/*"
                placeholder="📷 Avatar"
                :placeholder-font-size="16"
                canvas-color="transparent"
                :show-remove-button="true"
                remove-button-color="black"
                :show-loading="true"
                :loading-size="50"
                class="rounded"
              ></croppa>
            </div>
            <div class="has-margin-3">
              <button
                class="button is-link"
                v-if="image && image.chosenFile"
                @click="updateAvatar()"
              >Update avatar</button>
            </div>
          </div>
          <div class="field is-horizontal">
            <div class="field-label is-normal">
              <label class="label">Name</label>
            </div>
            <div class="field-body">
              <div class="field">
                <p class="control">
                  <input
                    class="input"
                    v-bind="{ disabled: !admin }"
                    v-bind:class="{ 'is-static': !admin }"
                    type="text"
                    v-model="student.name"
                  />
                </p>
              </div>
            </div>
          </div>
          <div class="field is-horizontal">
            <div class="field-label is-normal">
              <label class="label">Username</label>
            </div>
            <div class="field-body">
              <div class="field">
                <p class="control">
                  <input class="input is-static" disabled type="text" v-model="student.username" />
                </p>
              </div>
            </div>
          </div>
          <div class="field is-horizontal" v-if="student.password_plain&&admin">
            <div class="field-label is-normal">
              <label class="label">Password</label>
            </div>
            <div class="field-body">
              <b-field class="is-static">
                <b-input
                  type="password"
                  placeholder
                  icon-pack="fas"
                  disabled
                  v-model="student.password_plain"
                  password-reveal
                ></b-input>
              </b-field>
            </div>
          </div>
          <div class="has-padding-4">
            <img
              @click="confirmChangeClass(charclass.id)"
              v-bind:class="{ selected: charclass.id == student.character_id }"
              class="has-padding-2 has-margin-2 rounded"
              :src="'/img/character/' + charclass.id + '.png'"
              v-for="charclass in classroom.character_theme.characters"
              v-bind:key="charclass.id"
            />
          </div>
        </b-tab-item>

        <b-tab-item label="Inventory" class="has-padding-0" icon="backpack" icon-pack="fad">
          <div class="columns is-multiline is-variable" v-if="admin">
            <div
              v-for="item in items"
              class="column has-padding-y-2 is-6-tablet is-12-mobile is-4-desktop is-3-fullhd"
              v-bind:key="item.id"
            >
              <b-field>
                <p class="control">
                  <img :src="item.icon" />
                </p>
                <b-numberinput
                  @input="updateInventory(item.id, item.count)"
                  min="0"
                  icon-pack="fa"
                  v-model="item.count"
                  expanded
                  controlsPosition="compact"
                />
              </b-field>
            </div>
          </div>
          <div class="inventory" id="inventory" v-if="!admin">
            <div>
              <div
                v-for="item in student.items"
                v-tippy
                :content="message(item)"
                v-show="item.pivot.count>0"
                class="inventory-item"
                v-bind:key="item.id"
              >
                <img
                  :src="item.icon"
                  @click="item.hp > 0 ? useItem(item, message(item)) : null"
                  class="item"
                />
                <div class="number-items">{{ item.pivot.count }}</div>
              </div>
            </div>
            <div>
              <div v-for="index in inventoryRemaining" class="inventory-item" v-bind:key="index"></div>
            </div>
            <div :key="forceReload">
              <div
                v-for="gear in orderedEquipment"
                v-bind:key="gear.id"
                v-tippy
                :content="propertiesMessage(gear)"
                :ref="'item' + gear.id"
                class="inventory-item inv-item-armor relative"
                v-bind:class="{ 'inv-item-armor-bronce': gear.offset == 1, 'inv-item-armor-silver': gear.offset == 2, 'inv-item-armor-gold': gear.offset == 3 }"
              >
                <img :src="'/img/character/' + gear.src" :alt="gear.id" class="item" />
                <div class="price-buy rounded not-hover" v-if="eq1Json || eq2Json || eq3Json">
                  <i class="fas fa-plus"></i>
                </div>
                <div class="w-100 shop-sub-item" style="position:absolute; top: 100px; left: 0">
                  <div v-for="(i, index) in [eq1Json, eq2Json, eq3Json]" :key="index">
                    <div
                      v-for="itemStore in filterEquipment(i, gear.type)"
                      v-bind:key="itemStore.id"
                      class="inventory-item inv-item-armor w-100"
                      v-bind:class="{ 'inv-item-armor-bronce': index == 0, 'inv-item-armor-silver': index == 1, 'inv-item-armor-gold': index == 2 }"
                    >
                      <img
                        v-tippy
                        :content="propertiesMessage(itemStore)"
                        :src="'/img/character/' + itemStore.src"
                        :alt="itemStore.id"
                        class="item"
                      />
                      <div class="price-buy rounded" @click="buyEquipment(gear, itemStore)">
                        {{ itemStore.price }}
                        <i class="fas fa-coins colored"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class style="clear:both"></div>
          </div>
          <div class="shop has-padding-top-3" v-if="itemsJson">
            <h2 class="is-size-2">
              <i class="fas fa-store"></i> Shop
            </h2>
            <div
              class="columns has-padding-4 has-margin-2 rounded"
              v-for="item in itemsJson"
              :key="item.id"
            >
              <div class="column is-relative is-flex has-all-centered is-narrow">
                <div class="lvl-item-top-left" v-if="item.min_lvl">
                  <img src="/img/cardgen/lvl.png" class="levelCard" />
                  <span class="is-flex has-all-centered">{{ item.min_lvl }}</span>
                </div>
                <img :src="item.icon" />
              </div>
              <div class="column is-flex has-all-centered rounded wheat" v-html="message(item)"></div>
              <div class="column is-flex has-all-centered is-narrow item-price">
                <button class="button is-success" @click="buyItem(item)">
                  Buy {{ item.price }}
                  <i class="fas fa-coins colored" style="z-index: 0"></i>
                </button>
              </div>
            </div>
          </div>
        </b-tab-item>
        <b-tab-item label="Cards" v-if="cards.length" icon="club" icon-pack="fad">
          <div class="columns is-multiline is-variable">
            <div
              v-for="(card, index) in cards"
              :key="index"
              class="column is-6-tablet is-12-mobile is-6-desktop is-4-fullhd"
            >
              <show-card class="has-margin-4" :student="student" :card="card" :code="classroom.code" :use="true" :admin="false"></show-card>
            </div>
          </div>
        </b-tab-item>
        <b-tab-item label="Behaviours" v-if="student.behaviours.length" icon="heart" icon-pack="fad">
          <div class="is-flex justify-content-center">
            <apexchart
              v-if="series.length"
              width="450"
              type="donut"
              :options="{
                        labels: labels,  colors: colors
                        }"
              :series="series"
            ></apexchart>
          </div>

          <div class="columns">
            <div class="column">
              <input type="date" class="input is-rounded" v-model="dateStart" />
            </div>
            <div class="column">
              <input type="date" class="input is-rounded" v-model="dateEnd" />
            </div>
          </div>

          <b-table
            v-if="student.behaviours.length"
            :data="filteredEntries"
            default-sort="created_at"
            default-sort-direction="desc"
            icon-pack="fas"
            sort-icon="arrow-up"
          >
            <template slot-scope="props">
              <b-table-column field="icon" label="Icon" centered>
                <span
                  class="tag"
                  v-bind:class="[ props.row.xp + props.row.hp + props.row.gold >= 0 ? 'is-success' : 'is-danger']"
                >
                  <i :class="props.row.icon"></i>
                </span>
              </b-table-column>

              <b-table-column field="name" label="Name" sortable>{{ props.row.name }}</b-table-column>

              <b-table-column
                field="created_at"
                label="Created at"
                sortable
              >{{ new Date(props.row.pivot.created_at).toLocaleDateString() }}</b-table-column>

              <b-table-column field="hp" label="Health Points" sortable centered>
                <i class="fas fa-heart"></i>
                {{ props.row.hp }}
              </b-table-column>

              <b-table-column field="name" label="Experience" sortable centered>
                <i class="fas fa-fist-raised"></i>
                {{ props.row.xp }}
              </b-table-column>

              <b-table-column field="name" label="Gold" sortable centered>
                <i class="fas fa-coins"></i>
                {{ props.row.gold }}
              </b-table-column>

              <b-table-column field="name" label="Settings" v-if="admin" centered>
                <b-button type="is-danger is-small" @click="confirmDelete(props.row.id)">
                  <i class="fas fa-trash-alt"></i>
                </b-button>
              </b-table-column>
            </template>
          </b-table>
        </b-tab-item>

        <b-tab-item label="Challenges" v-if="challenges && challenges.length" icon="pen-fancy" icon-pack="fad">
          <div v-for="challenge in orderedChallenges" :key="challenge.id">
            <show-challenge
              :challenge="challenge"
              :code="classroom.code"
              :admin="admin"
              :edit="false"
            ></show-challenge>
          </div>
        </b-tab-item>

        <b-tab-item label="Log" v-if="student.log_entries.length" icon="file" icon-pack="fad">
          <div class="columns">
            <div class="column">
              <input type="date" class="input is-rounded" v-model="dateStart" />
            </div>
            <div class="column">
              <input type="date" class="input is-rounded" v-model="dateEnd" />
            </div>
          </div>
          <b-table
            v-if="student.log_entries.length"
            :data="filteredLogEntries"
            default-sort="created_at"
            default-sort-direction="desc"
            icon-pack="fas"
            sort-icon="arrow-up"
          >
            <template slot-scope="props">
              <b-table-column field="type" label="Type" centered>
                <span
                  class="tag"
                  v-bind:class="[ props.row.value >= 0 ? 'is-success' : 'is-danger']"
                >
                  <span v-if="props.row.type=='xp'">✊</span>
                  <span v-if="props.row.type=='gold'">💰</span>
                  <span v-if="props.row.type=='heart'">❤️</span>
                </span>
              </b-table-column>

              <b-table-column field="value" label="value" sortable>{{ props.row.value }}</b-table-column>

              <b-table-column
                field="created_at"
                label="Created at"
                sortable
              >{{ new Date(props.row.created_at).toLocaleDateString() }}</b-table-column>

              <b-table-column field="name" label="Settings" v-if="admin" centered>
                <b-button type="is-danger is-small" @click="confirmDelete(props.row.id)">
                  <i class="fas fa-trash-alt"></i>
                </b-button>
              </b-table-column>
            </template>
          </b-table>
        </b-tab-item>
      </b-tabs>
    </div>
  </div>
</template>

<script>
import Utils from "../../utils.js";

// Download excel
import JsonExcel from 'vue-json-excel'
Vue.component('downloadExcel', JsonExcel)

// Charts
import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)
Vue.component('apexchart', VueApexCharts)

export default {
  props: [
    "student",
    "classroom",
    "chart",
    "admin",
    "items",
    "shop",
    "challenges",
    "cards"
  ],
  mounted() {
    if (!this.admin) {
      this.activeTab = 1;

      this.updateEmpty();

      this.itemsJson = JSON.parse(this.shop.items);
      this.eq1Json = JSON.parse(this.shop.eq1);
      this.eq2Json = JSON.parse(this.shop.eq2);
      this.eq3Json = JSON.parse(this.shop.eq3);
    }
  },
  data: function() {
    return {
      activeTab: 0,
      dateStart: null,
      dateEnd: null,
      series: [],
      labels: [],
      colors: [],
      update: 0,
      inventoryRemaining: 0,
      itemsJson: null,
      eq1Json: null,
      eq2Json: null,
      eq3Json: null,
      forceReload: 0,
      prevImage: null,
      image: null
    };
  },
  methods: {
    updateEmpty() {
      let line = 6;
      if (this.student.items.length >= 6) {
        line = 12;
      }
      this.inventoryRemaining = line - this.student.items.length;
    },
    confirmChangeClass(subclass) {
      this.$buefy.dialog.confirm({
        title: "Class change",
        message:
          "Basic equipment will be assigned, this action can't be undone.",
        confirmText: "Change class",
        type: "is-warning",
        iconPack: "fa",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post(
              "/classroom/" + this.classroom.code + "/student/changecharacter",
              { id: this.student.id, character_id: subclass }
            )
            .then(response => {
              location.reload();
            });
        }
      });
    },
    useItem(item, messageItem) {
      this.$buefy.dialog.confirm({
        message: messageItem + " <br><br>Would you like to use the item?",
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/student/useitem", {
              id: this.student.id,
              itemId: item.id
            })
            .then(response => {
              item.pivot.count--;
              if (item.pivot.count == 0) this.inventoryRemaining++;
              this.student.hp = Math.min(
                this.student.hp + response.data.hp,
                100
              );
              this.student.xp += response.data.xp;
              this.forceRerender();
            });
        }
      });
    },
    forceRerender() {
      this.update += 1;
    },
    updateInventory(item, count) {
      axios.patch("/classroom/student/inventory", {
        id: this.student.id,
        item_id: item,
        count: count,
        _method: "patch"
      });
    },
    message(item) {
      let message = "";
      if (item.hp > 0)
        message +=
          "This item recovers " +
          item.hp +
          " <i class='fas fa-heart colored'></i>. ";
      if (item.xp > 0)
        message +=
          "This item gives you " +
          item.xp +
          " <i class='fas fa-fist-raised colored'></i>. ";
      if (message == "" && !item.description) return "What is that?";
      message += item.description ? item.description : "";
      return message;
    },
    propertiesMessage(itemStore) {
      return (
        itemStore.hp +
        "% <i class='fas fa-heart colored'></i> " +
        itemStore.xp +
        "% <i class='fas fa-fist-raised colored'></i> " +
        itemStore.gold +
        "% <i class='fas fa-coins colored'></i>"
      );
    },
    buyItem(item) {
      this.$buefy.dialog.confirm({
        title: "Buy item",
        message: "Do you want to buy the item?",
        confirmText: "Buy",
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/student/buyitem", {
              item: item.id
            })
            .then(response => {
              this.$toasted.show(response.data.message, {
                position: "top-center",
                duration: 3000,
                iconPack: "fontawesome",
                icon: response.data.icon,
                type: response.data.type
              });
              if (response.data.type == "success") {
                this.student.items = response.data.items;
                this.updateEmpty();
                this.student.gold = this.student.gold - item.price;
                this.$forceUpdate();
              }
            });
        }
      });
    },
    buyEquipment(oldItem, newItem) {
      this.$buefy.dialog.confirm({
        title: "Buy item",
        message:
          "Do you want to buy the item " +
          newItem.price +
          "<i class='fas fa-coins colored'></i>? (" +
          newItem.hp +
          "% <i class='fas fa-heart colored'></i> | " +
          newItem.xp +
          "% <i class='fas fa-fist-raised colored'></i> | " +
          newItem.gold +
          "% <i class='fas fa-coins colored'></i>)",
        confirmText: "Buy",
        type: "is-link",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
          axios
            .post(
              "/classroom/" + this.classroom.code + "/student/buyequipment",
              {
                new: newItem
              }
            )
            .then(response => {
              this.$toasted.show(response.data.message, {
                position: "top-center",
                duration: 3000,
                iconPack: "fontawesome",
                icon: response.data.icon,
                type: response.data.type
              });
              if (response.data.type == "success") {
                this.student.equipment = response.data.equipment;
                this.student.gold = this.student.gold - newItem.price;
                oldItem.src = newItem.src;
                let reference = "item" + oldItem.id;
                let newClass = "inv-item-armor-bronce";
                switch (newItem.offset) {
                  case 2:
                    newClass = "inv-item-armor-silver";
                    break;
                  case 3:
                    newClass = "inv-item-armor-gold";
                    break;
                }
                this.$refs[reference][0].classList.add(newClass);
                this.$forceUpdate();
              }
            });
        }
      });
    },
    filterEquipment(equipment, type) {
      if (equipment) {
        return equipment.filter(gear => {
          return gear.type == type;
        });
      }
    },
    updateAvatar() {
      this.image.generateBlob(
        blob => {
          if (blob != null) {
            let formData = new FormData();
            formData.append("avatar", blob, "avatar.png");
            if (this.admin) {
              formData.append("student_id", this.student.id);
            }
            axios
              .post(
                "/classroom/" + this.classroom.code + "/setting/updateavatar",
                formData,
                {
                  headers: {
                    "content-type": "multipart/form-data"
                  }
                }
              )
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
  computed: {
    filteredEntries() {
      return this.student.behaviours.filter(entry => {
        return (
          (entry.pivot.created_at >= this.dateStart || !this.dateStart) &&
          (entry.pivot.created_at <= this.dateEnd || !this.dateEnd)
        );
      });
    },
    filteredLogEntries() {
      return this.student.log_entries.filter(entry => {
        return (
          (entry.created_at >= this.dateStart || !this.dateStart) &&
          (entry.created_at <= this.dateEnd || !this.dateEnd)
        );
      });
    },
    groupedData() {
      let array = _.groupBy(this.filteredEntries, "id");
      return array;
    },
    orderedEquipment: function() {
      return _.orderBy(this.student.equipment, "type");
    },
    orderedChallenges: function() {
      return _.orderBy(this.challenges, "datetime", "desc");
    }
  },
  watch: {
    groupedData: {
      immediate: true,
      handler() {
        let colorsOK = [
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
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000"
        ];
        let colorsKO = [
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
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000",
          "#000000"
        ];
        this.series = this.labels = [];
        let data = this.groupedData;
        let propes = [];
        for (let property1 in data) {
          propes.push(data[property1]);
        }
        this.labels = [];
        this.series = [];
        this.colors = [];
        propes.forEach(element => {
          let behaviour = element[0];
          this.series.push(element.length);
          this.labels.push(
            "<i class='" + behaviour.icon + "'></i> " + behaviour.name
          );
          if (behaviour.xp + behaviour.hp + behaviour.gold >= 0) {
            this.colors.push(colorsOK[0]);
            colorsOK.shift();
          } else {
            this.colors.push(colorsKO[0]);
            colorsKO.shift();
          }
        });
      }
    }
  }
};
</script>
