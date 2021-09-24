<template>
  <div class="p-2">
    <button class="button is-dark is-outlined" @click="getLevels">
      <i class="fas fa-trophy mr-2"></i> {{ trans.get("levels.bank") }}
    </button>
    <button
      @click="promptName"
      v-if="levels && levels.length"
      class="button is-success is-outlined"
    >
      <i class="fas fa-share-alt mr-2"></i> {{ trans.get("levels.share") }}
    </button>
    <tippy
      interactive
      :animate-fill="false"
      theme="light"
      placement="bottom"
      animation="fade"
      trigger="click"
      style="display: inline-block"
      arrow
    >
      <template v-slot:trigger>
        <button class="button is-primary is-outlined">
          <i class="fas fa-heart mr-2"></i> {{ trans.get("levels.reward") }}
        </button>
      </template>
      <span>
        <div>{{ trans.get('levels.reward_info_health') }}</div>
        <div class="is-flex is-center-vertically">
          <input type="number" min="0" max="100" v-model="lvlHp" class="input mr-1" /> <span>%</span>
          <button
            @click="updateProp('hp', lvlHp)"
            class="button is-primary is-inline ml-1"
          >
            {{ trans.get("users_groups.apply") }}
          </button>
        </div>
      </span>
    </tippy>

    <create-levels v-if="!levels.length"></create-levels>
    <div class="columns is-multiline is-variable mt-3" v-else>
      <show-level
        v-for="(level, index) in levels"
        :key="level.id"
        :code="code"
        :edit="true"
        :last="index == levels.length - 1"
        :level="level"
      ></show-level>
      <button class="button mx-3 my-2" @click="addLevel">
        <i class="fas fa-plus mr-2"></i> {{ trans.get("levels.add") }}
      </button>
    </div>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("general.import") }}</p>
        </header>
        <section class="modal-card-body is-flex">
          <div v-if="!levelsb.length">
            {{ trans.get("levels.import_empty") }}
          </div>
          <div class="p-2 justify-content-center w-100" v-else>
            <div class="mb-2" v-for="levelp in levelsb" :key="levelp.id">
              <h4 class="is-size-4 is-flex is-center-vertically">
                {{ levelp.name }}
                <button
                  @click="importPack(levelp.id)"
                  class="button is-success ml-2"
                >
                  <i class="fas fa-file-import mr-2"></i>
                  {{ trans.get("general.import") }}
                </button>
              </h4>
              <div class="is-flex w-100">
                <show-level
                  v-for="level in levelp.levels"
                  :key="level.id"
                  :level="level"
                  :edit="false"
                  code="code"
                  :resize="true"
                >
                </show-level>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="isModalActive = false">
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["levels", "code", "hplvl"],
  created() {
    this.lvlHp = this.hplvl;
  },
  data: function () {
    return {
      newXp: 0,
      levelsb: [],
      isModalActive: false,
      lvlHp: 0,
    };
  },
  methods: {
    updateProp(type) {
      if(type == 'hp')
        axios
        .patch("/classroom/" + this.code + "/setting", {
            _method: "patch",
            prop: 'level_up_health',
            value: this.lvlHp,
            action: "update"
        }).then(response => {
          this.$toast(this.trans.get("success_error.update_success"), {
                type: "success",
              });
        })
    },
    promptName() {
      this.$buefy.dialog.prompt({
        message: this.trans.get("levels.name"),
        confirmText: this.trans.get("general.share"),
        cancelText: this.trans.get("general.cancel"),
        inputAttrs: {
          placeholder: this.trans.get("levels.placeholder"),
          maxlength: 50,
          required: true,
        },
        trapFocus: true,
        onConfirm: (value) => {
          axios
            .post(`/levels/share`, { name: value, code: this.code })
            .then((response) => {
              this.$toast(this.trans.get("success_error.add_success"), {
                type: "success",
              });
            });
        },
      });
    },
    getLevels() {
      axios.get("/levels/share/get").then((response) => {
        this.levelsb = response.data;
        this.isModalActive = true;
      });
    },
    importPack(id) {
      this.$buefy.dialog.confirm({
        title: this.trans.get("general.import"),
        message: this.trans.get("levels.import_alert"),
        confirmText: this.trans.get("general.import"),
        type: "is-warning",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post("/levels/import", { code: this.code, id: id })
            .then((response) => {
              location.reload();
            });
        },
      });
    },
    addLevel() {
      this.$buefy.dialog.prompt({
        message: this.trans.get("levels.add"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        inputAttrs: {
          placeholder: this.trans.get("levels.xp"),
          type: "number",
          min: this.levels[this.levels.length - 1].xp + 1,
        },
        trapFocus: true,
        onConfirm: (value) => {
          axios
            .post(`/classroom/${this.code}/level/add`, { xp: value })
            .then((response) => {
              this.levels.push(response.data);
              this.$forceUpdate();
            });
        },
      });
    },
  },
};
</script>