<template>
  <div class="content has-padding-3">
    <div class="has-padding-2">
      <h1>
        <i class="fal fa-chalkboard"></i>
        {{ trans.get('settings.classroom') }}
      </h1>
      <div class="has-padding-left-4 is-flex">
        <b-field>
          <b-radio-button
            v-model="state"
            @input="updateClassState('state', 0)"
            native-value="0"
            type="is-success"
          >
            <b-icon icon="check" icon-pack="fa"></b-icon>
            <span>Active</span>
          </b-radio-button>
          <b-radio-button
            v-model="state"
            @input="updateClassState('state', 1)"
            native-value="1"
            type="is-warning"
          >
            <b-icon icon="hourglass-end"></b-icon>
            <span>Finished</span>
          </b-radio-button>
          <b-radio-button
            v-model="state"
            @input="updateClassState('state', 2)"
            native-value="2"
            type="is-danger"
          >
            <b-icon icon="eye-slash"></b-icon>
            <span>Disabled</span>
          </b-radio-button>
        </b-field>
        <button class="button has-margin-left-4 is-danger" @click="confirmDelete" v-if="isAdmin">
          <i class="fas fa-trash"></i>Delete
        </button>
      </div>
    </div>
    <div class="has-padding-2">
      <h1>
        <i class="fal fa-user-graduate"></i>
        {{ trans.get('settings.teachers') }}
      </h1>
      <div class="has-padding-left-4">
        <button
          class="button is-primary"
          v-if="isAdmin"
          @click="promptInvite()"
        >{{ trans.get('settings.add_teachers') }}</button>
        <div class="columns box card-shadow-s" v-for="(teacher, index) in teachers" :key="teacher.id">
          <div class="column is-narrow">
            <i
              class="fal fa-2x"
              :class="{ 'fa-user-crown' : teacher.pivot.role == 2, 'fa-user-graduate': teacher.pivot.role == 1 }"
            ></i>
          </div>
          <div class="column is-narrow is-flex align-items-center">{{ teacher.name }}</div>
          <div class="column is-narrow is-flex align-items-center">{{ teacher.email }}</div>
          <div class="column is-narrow is-flex align-items-center">
            <button class="button has-margin-left-4 is-danger" @click="confirmDeleteTeacher(teacher.id, index)" v-if="isAdmin && teacher.id != user">
              <i class="fas fa-trash"></i> Delete
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="has-padding-2 has-margin-top-4">
      <h1>
        <i class="fal fa-brackets-curly"></i>
        {{ trans.get('settings.parameters') }}
      </h1>
      <div class="has-padding-left-4">
        <h3 class="has-margin-bottom-4">{{ trans.get('settings.probability') }}</h3>
        <vue-slider
          class="has-padding-5"
          v-model="value"
          :process="process"
          :tooltip="'always'"
          :dot-options="dotOptions"
        >
          <template v-slot:dot="{ value, focus }">
            <div :class="['custom-dot', { focus }]"></div>
          </template>
        </vue-slider>
        <div class="has-margin-0 is-size-6">
          <strong>{{ trans.get('settings.common') }}</strong>
          : {{ value[1] }}
          <i class="fal fa-ellipsis-v has-margin-x-3"></i>
          <strong>{{ trans.get('settings.rare') }}</strong>
          : {{ value[2] - value[1] }}
          <i class="fal fa-ellipsis-v has-margin-x-3"></i>
          <strong>{{ trans.get('settings.epic') }}</strong>
          : {{ value[3] - value[2] }}
          <i class="fal fa-ellipsis-v has-margin-x-3"></i>
          <strong>{{ trans.get('settings.legendary') }}</strong>
          : {{ value[4] - value[3] }}
        </div>
        <button class="button is-primary has-margin-y-4" @click="saveProbabilities()">
          <i class="fas fa-save has-margin-right-3"></i>
          {{ trans.get('general.save') }}
        </button>
      </div>
      <div class="has-padding-left-4">
        <h3 class="has-margin-bottom-4">{{ trans.get('settings.economic') }}</h3>
        <div class="columns">
          <div class="column is-narrow">
            <input class="input is-narrow" type="number" v-model="settings.card_use" />
          </div>
          <div class="column is-flex align-items-center">
            <i class="fas fa-coins colored"></i>
            {{ trans.get('settings.use_card_gold') }}
          </div>
        </div>
        <div class="columns">
          <div class="column is-narrow">
            <input class="input is-narrow" type="number" v-model="settings.card_delete" />
          </div>
          <div class="column is-flex align-items-center">
            <i class="fas fa-coins colored"></i>
            {{ trans.get('settings.delete_card_gold') }}
          </div>
        </div>
      </div>
      <button class="button is-primary has-margin-4" @click="saveEconomic()">
        <i class="fas fa-save has-margin-right-3"></i>
        {{ trans.get('general.save') }}
      </button>
    </div>
    <div class="has-padding-left-4">
      <h3 class="has-margin-bottom-4">{{ trans.get('settings.weather_management') }}</h3>
      <div class="columns has-padding-2">
        <b-switch
          :value="true"
          type="is-success"
          v-model="settings.night"
          class="has-margin-x-4"
          passive-type="is-danger"
          true-value="1"
          false-value="0"
          @input="toggleProp('night')"
        >
          <i class="fas fa-moon fa-3x"></i>
        </b-switch>
        <b-switch
          :value="true"
          type="is-success"
          v-model="settings.rain"
          class="has-margin-x-4"
          passive-type="is-danger"
          true-value="1"
          false-value="0"
          @input="toggleProp('rain')"
        >
          <i class="fas fas fa-cloud-showers-heavy fa-3x"></i>
        </b-switch>
        <b-switch
          :value="true"
          type="is-success"
          v-model="settings.snow"
          class="has-margin-x-4"
          passive-type="is-danger"
          true-value="1"
          false-value="0"
          @input="toggleProp('snow')"
        >
          <i class="fas fas fa-snowflake fa-3x"></i>
        </b-switch>
        <b-switch
          :value="true"
          type="is-success"
          v-model="settings.fog"
          class="has-margin-x-4"
          passive-type="is-danger"
          true-value="1"
          false-value="0"
          @input="toggleProp('fog')"
        >
          <i class="fas fas fa-smog fa-3x"></i>
        </b-switch>
      </div>
    </div>
  </div>
</template>

<script>
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/antd.css";

export default {
  props: ["classroom", "settings", "teachers", "isAdmin", "user"],
  created() {
    this.state = "" + this.classroom.state;
    this.value[0] = 0;
    this.value[1] = this.settings.probabilities[0];
    this.value[2] = this.value[1] + this.settings.probabilities[1];
    this.value[3] = this.value[2] + this.settings.probabilities[2];
    this.value[4] = this.value[3] + this.settings.probabilities[3];
  },
  components: {
    VueSlider
  },
  data: function() {
    return {
      state: "0",
      value: [],
      process: dotsPos => [
        [dotsPos[0], dotsPos[1], { backgroundColor: "gray" }],
        [dotsPos[1], dotsPos[2], { backgroundColor: "blue" }],
        [dotsPos[2], dotsPos[3], { backgroundColor: "purple" }],
        [dotsPos[3], dotsPos[4], { backgroundColor: "gold" }]
      ],
      dotOptions: [
        {
          disabled: true
        },
        {
          disabled: false
        },
        {
          disabled: false
        },
        {
          disabled: false
        },
        {
          disabled: true
        }
      ]
    };
  },
  methods: {
    confirmDelete() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete_class"),
        confirmText: this.trans.get("general.delete"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios
            .delete("/classroom/" + this.classroom.code)
            .then(response => {
                location.href = response.data 
            });
        }
      });
    },
    confirmDeleteTeacher(id, index) {
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
          axios
            .delete("/classroom/" + this.classroom.code + "/teacher/" + id)
            .then(response => {
              if (response.data === 1) {
                // TODO change to delete teacher from array
                location.reload()
              }
            });
        }
      });
    },
    promptInvite() {
      this.$buefy.dialog.prompt({
        message: `Email`,
        inputAttrs: {
          placeholder: "The teacher's email :)"
        },
        trapFocus: true,
        onConfirm: email => {
          axios
            .post("/classroom/" + this.classroom.code + "/invite", {
              email: email
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
                // TODO change to insert teacher from array
                location.reload()
              }
            });
        }
      });
    },
    updateClassState(prop, value) {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: prop,
        action: "update",
        value: value
      });
    },
    toggleProp(prop) {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: prop,
        action: "toggle"
      });
    },
    saveProbabilities() {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "card_probabilities",
        action: "update",
        value: this.value
      });
    },
    saveEconomic() {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "card_use",
        action: "update",
        value: this.settings.card_use
      });
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "card_delete",
        action: "update",
        value: this.settings.card_delete
      });
    }
  }
};
</script>

<style>
.custom-dot {
  width: 20px;
  height: 20px;
  border-radius: 0;
  background-color: white;
  border-radius: 50%;
  border: 2px solid black;
  position: absolute;
  top: -5px;
  left: -5px;
}
</style>