<template>
  <div class="content p-3">
    <div class="p-2 pl-4">
      <h1 class="mb-5">
        <i class="fal fa-chalkboard"></i>
        {{ trans.get("settings.classroom") }}
      </h1>

      <!-- <div class="form-group">
        <label>Timezone:<span class="red">&nbsp;*</span></label>
        <select name="timezone" id="timezone" class="form-control">
        @foreach (timezone_identifiers_list() as $timezone)
                <option value="{{ $timezone }}"{{ $timezone == old('timezone') ? ' selected' : '' }}>{{ $timezone }}</option>
        @endforeach
        </select>
        </div> -->

      <b-field class="mt-4" :label="trans.get('settings.state')">
        <b-field class="mb-3 pl-4">
          <b-radio-button
            v-model="state"
            @input="updateClassState('state', 0)"
            native-value="0"
            type="is-success"
          >
            <b-icon icon="check" icon-pack="fa"></b-icon>
            <span>{{ trans.get("settings.active") }}</span>
          </b-radio-button>
          <b-radio-button
            v-model="state"
            @input="updateClassState('state', 1)"
            native-value="1"
            type="is-warning"
          >
            <b-icon icon="hourglass-end"></b-icon>
            <span>{{ trans.get("settings.finished") }}</span>
          </b-radio-button>
          <b-radio-button
            v-model="state"
            @input="updateClassState('state', 2)"
            native-value="2"
            type="is-danger"
          >
            <b-icon icon="eye-slash"></b-icon>
            <span>{{ trans.get("settings.disabled") }}</span>
          </b-radio-button>
        </b-field>
      </b-field>
      <b-field :label="trans.get('settings.config')">
        <div class="buttons pl-4">
          <a class="button" :href="'/classroom/' + classroom.code + '/edit'"
            ><i class="far fa-cog mr-2"></i>
            {{ trans.get("menu.config") }} (wizard)</a
          >
          <button
            class="button is-link"
            @click="resetAssistant = true"
            v-tippy
            v-if="isAdmin"
            :content="trans.get('settings.reset_assistant_help')"
          >
            <i class="fas fa-eraser mr-2"></i>
            {{ trans.get("settings.reset_assistant") }}
          </button>
          <button
            class="button is-danger"
            @click="confirmDelete"
            v-if="isAdmin"
          >
            <i class="fas fa-trash"></i>
            <span class="mx-3">
              {{ trans.get("general.delete") }}
              <i class="fas fa-radiation-alt"></i>
              <i class="fas fa-exclamation-triangle"></i>
            </span>
          </button>
        </div>
      </b-field>
      <b-field
        :label="trans.get('settings.enrollment_code')"
        style="width: 400px"
      >
        <div class="field has-addons my-3 pl-4">
          <p class="control">
            <b-input
              type="password"
              :value="classroom.enrollment_code"
              password-reveal
              readonly
            ></b-input>
          </p>
          <p class="control">
            <button class="button is-info" @click="regenerate">
              <i class="fas fa-sync-alt"></i>
              {{ trans.get("settings.generate") }}
            </button>
          </p>
        </div>
      </b-field>
      <button class="button is-link mb-3" v-if="user.token" @click="unlink">
        {{ trans.get("settings.classroom_unlink") }}
      </button>
      <div class="mt-0 mb-2">
        <small
          v-if="user.token"
          v-html="trans.get('settings.classroom_unlink_info')"
        ></small>
      </div>
      <div class="">
        <h1>
          <i class="fal fa-mask"></i>
          {{ trans.get("settings.themes") }}
        </h1>
        <div class="my-4">
          <b-switch
            class="ml-4"
            true-value="1"
            false-value="0"
            @input="toggleProp('allow_upload')"
            v-model="settings.allow_upload"
            >{{ trans.get("settings.allow_upload") }}</b-switch
          >
        </div>
        <p class="pl-4 pt-2">
          <span v-html="trans.get('settings.themes_disabled')"></span>
          <span class="cursor-pointer tag is-link" @click="disableAll">{{
            trans.get("utils.select_all")
          }}</span>
        </p>
        <b-field class="ml-4 mb-3">
          <b-select
            multiple
            native-size="4"
            expanded
            v-model="settings.disabled_themes"
          >
            <option
              :value="theme"
              v-for="(theme, index) in settings.themes"
              :key="index"
            >
              {{ theme }}
            </option>
          </b-select>
        </b-field>
        <button class="button is-primary mb-3 ml-4" @click="saveDisabled()">
          <i class="fas fa-save"></i>
          {{ trans.get("general.save") }}
        </button>
        <div class="ml-4">
          <h4>{{ trans.get("settings.custom_pack") }}:</h4>
          <button class="button" @click="customUpload = !customUpload">
            {{ trans.get("settings.custom_upload") }}
          </button>
        </div>
        <div v-if="customUpload" class="mt-2">
          <croppa
            class="card-shadow-s"
            v-model="imageUpload"
            :width="250"
            :height="250"
            :quality="1"
            style="z-index: 15"
            accept="image/*"
            :zoom-speed="8"
            placeholder="Image"
            :placeholder-font-size="16"
            canvas-color="transparent"
            :show-remove-button="true"
            remove-button-color="black"
            :show-loading="true"
            :loading-size="50"
          ></croppa>
          <button @click="addToClass" class="button is-link">
            <i class="fas fa-upload mr-1"></i> {{ trans.get("general.send") }}
          </button>
        </div>
        <div class="mx-4" v-if="imagesCustom && imagesCustom.length">
          <span v-for="(image, index) in imagesCustom" :key="index">
            <img
              :src="'/storage/avatars/' + image.uuid + '/' + image.file_name"
              width="81px"
              class="m-2 cursor-pointer"
            />
            <button
              @click="deleteImage(image.id)"
              style="margin-left: -20px"
              class="has-text-light has-background-danger"
            >
              <i class="fas fa-trash-alt"></i>
            </button>
          </span>
          <b-field :label="trans.get('menu.licenses')" v-if="imagesCustom && imagesCustom.length">
            <b-input v-model="settings.licenses"></b-input>
          </b-field>
          <button class="button is-primary mb-3" @click="updateLicenses()">
            <i class="fas fa-save"></i>
            {{ trans.get("general.save") }}
          </button>
        </div>
      </div>
      <div class="mt-5">
        <h1>
          <i class="fal fa-cog"></i>
          {{ trans.get("settings.general_preferences") }}
        </h1>
        <div class="my-4">
          <b-switch
            class="ml-4"
            true-value="1"
            false-value="0"
            @input="toggleProp('allow_change_class')"
            v-model="settings.allow_change_class"
            >{{ trans.get("settings.allow_change_class") }}</b-switch
          >
        </div>
        <div class="my-4">
          <b-switch
            class="ml-4"
            true-value="1"
            false-value="0"
            @input="toggleProp('disable_your_adventure')"
            v-model="settings.disable_your_adventure"
            >{{ trans.get("settings.disable_your_adventure") }}</b-switch
          >
        </div>

        <div class="my-4">
          <b-switch
            class="ml-4"
            true-value="1"
            false-value="0"
            @input="toggleProp('show_chat')"
            v-model="settings.show_chat"
            >{{ trans.get("settings.show_chat") }}</b-switch
          >
        </div>
        <div class="my-4">
          <b-switch
            class="ml-4"
            true-value="1"
            false-value="0"
            @input="toggleProp('allow_send_money')"
            v-model="settings.allow_send_money"
            >{{ trans.get("settings.allow_send_money") }}</b-switch
          >
        </div>
      </div>
      <div class="mt-4">
        <h1>
          <i class="fal fa-user-graduate"></i>
          {{ trans.get("settings.teachers") }}
        </h1>
        <div class="pl-4">
          <button
            class="button is-primary"
            v-if="isAdmin"
            @click="promptInvite()"
          >
            {{ trans.get("settings.add_teachers") }}
          </button>
          <div
            class="columns box card-shadow-s"
            v-for="(teacher, index) in teachers"
            :key="teacher.id"
          >
            <div class="column is-narrow">
              <i
                class="fal fa-2x"
                :class="{
                  'fa-user-crown': teacher.pivot.role == 2,
                  'fa-user-graduate': teacher.pivot.role == 1,
                }"
              ></i>
            </div>
            <div class="column is-narrow is-flex align-items-center">
              {{ teacher.name }}
            </div>
            <div class="column is-narrow is-flex align-items-center">
              {{ teacher.email }}
            </div>
            <div class="column is-narrow is-flex align-items-center">
              <button
                class="button ml-4 is-danger"
                @click="confirmDeleteTeacher(teacher.id, index)"
                v-if="
                  (isAdmin && teacher.id != user.id) ||
                  (teacher.pivot.role == 1 && teacher.id == user.id)
                "
              >
                <i class="fas fa-trash"></i> Delete
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-5">
        <h1>
          <i class="fal fa-brackets-curly"></i>
          {{ trans.get("settings.parameters") }}
        </h1>
        <div class="pl-4">
          <h3 class="mb-5">
            {{ trans.get("settings.probability") }}
          </h3>
          <vue-slider
            class="p-5"
            v-model="value"
            :process="process"
            :tooltip="'always'"
            :dot-options="dotOptions"
          >
            <template v-slot:dot="{ focus }">
              <div :class="['custom-dot', { focus }]"></div>
            </template>
          </vue-slider>
          <div class="m-0 is-size-6">
            <strong>{{ trans.get("settings.common") }}</strong>
            : {{ value[1] }}
            <i class="fal fa-ellipsis-v mx-3"></i>
            <strong>{{ trans.get("settings.rare") }}</strong>
            : {{ value[2] - value[1] }}
            <i class="fal fa-ellipsis-v mx-3"></i>
            <strong>{{ trans.get("settings.epic") }}</strong>
            : {{ value[3] - value[2] }}
            <i class="fal fa-ellipsis-v mx-3"></i>
            <strong>{{ trans.get("settings.legendary") }}</strong>
            : {{ value[4] - value[3] }}
          </div>
          <button class="button is-primary my-4" @click="saveProbabilities()">
            <i class="fas fa-save mr-3"></i>
            {{ trans.get("general.save") }}
          </button>
        </div>
        <div class="pl-4">
          <h3 class="mb-4">
            {{ trans.get("settings.economic") }}
          </h3>
          <div class="columns">
            <div class="column is-narrow">
              <input
                class="input is-narrow"
                type="number"
                v-model="settings.transfer_fee"
              />
            </div>
            <div class="column is-flex align-items-center">
              <i class="fas fa-coins colored mr-2"></i>
              {{ trans.get("settings.transfer_fee") }}
            </div>
          </div>
          <div class="columns">
            <div class="column is-narrow">
              <input
                class="input is-narrow"
                type="number"
                v-model="settings.card_use"
              />
            </div>
            <div class="column is-flex align-items-center">
              <i class="fas fa-coins colored mr-2"></i>
              {{ trans.get("settings.use_card_gold") }}
            </div>
          </div>
          <div class="columns">
            <div class="column is-narrow">
              <input
                class="input is-narrow"
                type="number"
                v-model="settings.card_delete"
              />
            </div>
            <div class="column is-flex align-items-center">
              <i class="fas fa-coins colored mr-2"></i>
              {{ trans.get("settings.delete_card_gold") }}
            </div>
          </div>
          <div class="columns">
            <div class="column is-narrow">
              <input
                class="input is-narrow"
                type="number"
                v-model="settings.num_cards"
              />
            </div>
            <div class="column is-flex align-items-center">
              <i class="fas fa-club colored mr-2"></i>
              {{ trans.get("settings.cards") }}
            </div>
          </div>
        </div>
        <button class="button is-primary m-4" @click="saveCards()">
          <i class="fas fa-save mr-3"></i>
          {{ trans.get("general.save") }}
        </button>
      </div>
      <!-- <div class="pl-4">
      <h3 class="mb-4">{{ trans.get('settings.weather_management') }}</h3>
      <div class="columns p-2">
        <b-switch
          :value="true"
          type="is-success"
          v-model="settings.night"
          class="mx-4"
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
          class="mx-4"
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
          class="mx-4"
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
          class="mx-4"
          passive-type="is-danger"
          true-value="1"
          false-value="0"
          @input="toggleProp('fog')"
        >
          <i class="fas fas fa-smog fa-3x"></i>
        </b-switch>
      </div>-->
    </div>
    <b-modal
      :active.sync="resetAssistant"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            {{ trans.get("settings.reset_assistant") }}
          </p>
        </header>
        <section class="modal-card-body">
          <button @click="reset('hp', 'heart')" class="button is-danger w-100">
            Reset <i class="fas fa-heart colored"></i>
          </button>
          <button
            @click="reset('xp', 'fist-raised')"
            class="button is-dark w-100 mt-2"
          >
            Reset <i class="fas fa-fist-raised colored"></i>
          </button>
          <button
            @click="reset('gold', 'coins')"
            class="button is-warning w-100 mt-2"
          >
            Reset <i class="fas fa-coins colored"></i>
          </button>
          <!-- <button class="button is-link w-100 mt-2">Reset {{ trans.get('menu.shop') }}</button> -->
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="resetAssistant = false">
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/antd.css";

export default {
  props: ["classroom", "settings", "teachers", "isAdmin", "user", "tz"],
  created() {
    this.state = "" + this.classroom.state;
    this.value[0] = 0;
    this.value[1] = this.settings.probabilities[0];
    this.value[2] = this.value[1] + this.settings.probabilities[1];
    this.value[3] = this.value[2] + this.settings.probabilities[2];
    this.value[4] = this.value[3] + this.settings.probabilities[3];
    this.imagesCustom = this.settings.custom_images;
  },
  components: {
    VueSlider,
  },
  data: function () {
    return {
      images: null,
      imagesCustom: [],
      image: null,
      imageUpload: null,
      customUpload: false,
      resetAssistant: false,
      state: "0",
      value: [],
      process: (dotsPos) => [
        [dotsPos[0], dotsPos[1], { backgroundColor: "gray" }],
        [dotsPos[1], dotsPos[2], { backgroundColor: "blue" }],
        [dotsPos[2], dotsPos[3], { backgroundColor: "purple" }],
        [dotsPos[3], dotsPos[4], { backgroundColor: "gold" }],
      ],
      dotOptions: [
        {
          disabled: true,
        },
        {
          disabled: false,
        },
        {
          disabled: false,
        },
        {
          disabled: false,
        },
        {
          disabled: true,
        },
      ],
    };
  },
  methods: {
    deleteImage(id) {
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
          axios
            .delete("/classroom/" + this.classroom.code + "/removeMedia/" + id)
            .then((response) => {
              this.imagesCustom = response.data;
            });
        },
      });
    },
    addToClass() {
      this.imageUpload.generateBlob(
        (blob) => {
          if (blob != null) {
            let formData = new FormData();
            formData.append("image", blob, "avatar.png");
            formData.append("collection", "avatars");
            axios
              .post(
                "/classroom/" + this.classroom.code + "/add2collection",
                formData
              )
              .then((response) => {
                this.customUpload = false;
                this.imagesCustom = response.data;
              });
          }
        },
        "image/png",
        0.8
      );
    },
    disableAll() {
      this.settings.disabled_themes = Object.values(this.settings.themes);
      this.$forceUpdate();
    },
    reset(type, icon) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message:
          this.trans.get("general.confirm_delete_class") +
          " (<i class='fas fa-" +
          icon +
          " colored'></i>)",
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios
            .post("/classroom/" + this.classroom.code + "/settings/reset", {
              type: type,
            })
            .then((response) => {
              this.$toast(this.trans.get("success_error.update_success"), {
                type: "success",
              });
            });
        },
      });
    },
    unlink() {
      axios.get("/google/classroom/unlink").then((response) => {
        this.$toast(this.trans.get("success_error.update_success"), {
          type: "success",
        });

        this.user.token = null;
        this.$forceUpdate();
      });
    },
    regenerate() {
      axios
        .get("/classroom/" + this.classroom.code + "/regenerate")
        .then((response) => {
          this.classroom.enrollment_code = response.data;
          this.$forceUpdate();
        });
    },
    confirmDelete() {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.delete"),
        message: this.trans.get("general.confirm_delete_class"),
        confirmText: this.trans.get("general.delete"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-danger",
        hasIcon: true,
        icon: "times-circle",
        iconPack: "fa",
        ariaRole: "alertdialog",
        ariaModal: true,
        onConfirm: () => {
          axios.delete("/classroom/" + this.classroom.code).then((response) => {
            location.href = response.data;
          });
        },
      });
    },
    confirmDeleteTeacher(id, index) {
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
          axios
            .delete("/classroom/" + this.classroom.code + "/teacher/" + id)
            .then((response) => {
              if (response.data === 1) {
                // TODO change to delete teacher from array
                location.reload(true);
              } else if (response.data == 2) {
                location.href = "/classroom";
              }
            });
        },
      });
    },
    promptInvite() {
      this.$buefy.dialog.prompt({
        message: `Email`,
        inputAttrs: {
          placeholder: "The teacher's email :)",
        },
        trapFocus: true,
        onConfirm: (email) => {
          axios
            .post("/classroom/" + this.classroom.code + "/invite", {
              email: email,
            })
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });

              if (response.data.type == "success") {
                // TODO change to insert teacher from array
                location.reload(true);
              }
            });
        },
      });
    },
    updateClassState(prop, value) {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: prop,
        action: "update",
        value: value,
      });
    },
    toggleProp(prop) {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: prop,
        action: "toggle",
      });
    },
    saveDisabled() {
      axios.post("/classroom/" + this.classroom.code + "/settings/themes", {
        themes: this.settings.disabled_themes,
      });
    },
    saveProbabilities() {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "card_probabilities",
        action: "update",
        value: this.value,
      });
    },
    updateLicenses() {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "licenses",
        action: "update",
        value: this.settings.licenses,
      });
    },
    saveCards() {
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "card_use",
        action: "update",
        value: this.settings.card_use,
      });
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "transfer_fee",
        action: "update",
        value: this.settings.transfer_fee,
      });
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "card_delete",
        action: "update",
        value: this.settings.card_delete,
      });
      axios.patch("/classroom/" + this.classroom.code + "/setting", {
        _method: "patch",
        prop: "num_cards",
        action: "update",
        value: this.settings.num_cards,
      });
      this.$toast(this.trans.get("success_error.update_success"), {
        type: "success",
      });
    },
  },
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