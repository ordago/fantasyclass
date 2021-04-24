<template>
  <div>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">
            <i class="fad fa-video"></i> {{ trans.get("videochat.manage") }}
          </p>
        </header>
        <section class="modal-card-body is-relative">
          <button
            class="button is-info mb-4"
            @click="isCreateModalActive = true"
          >
            {{ trans.get("videochat.create") }}
          </button>
          <div
            class="m-2 is-flex is-flex-direction-column"
            v-for="videochat in videochats"
            :key="videochat.id"
          >
            <div>
              <h5 class="is-size-5 is-flex is-center-vertically">
                <i class="fad fa-video mr-2"></i> {{ videochat.name }}
                <i
                  v-tippy
                  :content="videochat.url"
                  class="far fa-puzzle-piece ml-2"
                  v-if="!videochat.url.includes('talky.io')"
                ></i>
                <small class="is-flex is-center-vertically"
                  ><b-switch
                    v-tippy="{ theme: 'light' }"
                    :content="trans.get('videochat.enable_info')"
                    :false-value="0"
                    :true-value="1"
                    class="ml-1"
                    style="font-size: 0.75em"
                    @input="updateEnabled(videochat)"
                    v-model="videochat.active"
                  >
                  </b-switch>
                  <button
                    v-if="groups && groups.length"
                    @click.prevent="selectGroups(videochat)"
                    class="button is-rounded"
                  >
                    <span
                      v-if="
                        !videochat.groups ||
                        (videochat.groups && videochat.groups.length == 0)
                      "
                    >
                      <i class="fas fa-users m-2"></i>
                      {{ trans.get("videochat.available_all") }}
                    </span>
                    <span v-else-if="groups && videochat.groups">
                      <i class="fas fa-users m-2"></i>
                      {{ trans.get("videochat.available_some") }}
                      {{ groups.length - videochat.groups.length }}
                      {{ trans.get("videochat.available_groups") }}
                    </span>
                  </button>
                </small>
              </h5>
            </div>
            <div class="m-2 buttons">
              <button class="button is-link" @click="openChat(videochat)">
                <i class="fad fa-door-open mr-1"></i>
                {{ trans.get("videochat.open") }}
              </button>
              <button
                v-if="videochat.active == 1"
                class="button is-dark"
                @click="sendNotify(videochat.id)"
              >
                <i class="fad fa-paper-plane mr-1"></i>
                {{ trans.get("videochat.notify") }}
              </button>
              <button class="button is-danger" @click="deleteVC(videochat.id)">
                <i class="fad fa-trash-alt mr-1"></i>
                {{ trans.get("videochat.delete") }}
              </button>
            </div>
            <hr />
          </div>
        </section>
        <footer
          class="modal-card-foot columns is-multiline"
          style="overflow-x: auto"
        >
          <div class="column is-narrow">
            <button
              class="button"
              type="button"
              @click="$parent.isVideoChatActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
          </div>
        </footer>
      </div>
    </b-modal>
    <b-modal
      :active.sync="isCreateModalActive"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
    >
      <form @submit.prevent="createVideo">
        <div class="modal-card" style="width: auto">
          <header class="modal-card-head">
            <p class="modal-card-title">
              {{ trans.get("videochat.create") }}
            </p>
          </header>
          <section class="modal-card-body">
            <b-tabs v-model="type" type="is-toggle" expanded>
              <b-tab-item
                :label="trans.get('videochat.general')"
                icon-pack="fal"
                icon="video"
              >
                <div class="py-3" v-if="type == 0">
                  <b-field>
                    <b-input
                      :placeholder="trans.get('videochat.name')"
                      v-model="name"
                      type="text"
                      required
                    ></b-input>
                  </b-field>
                </div>
              </b-tab-item>
              <b-tab-item
                :label="trans.get('videochat.custom')"
                icon-pack="fal"
                icon="puzzle-piece"
              >
                <div class="py-3" v-if="type == 1">
                  <b-field>
                    <b-input
                      :placeholder="trans.get('videochat.name')"
                      v-model="name"
                      type="text"
                      required
                    ></b-input>
                  </b-field>
                  <b-field>
                    <b-input
                      :placeholder="trans.get('videochat.url')"
                      v-model="url"
                      type="url"
                      required
                    ></b-input>
                  </b-field>
                </div>
              </b-tab-item>
            </b-tabs>
          </section>
          <footer class="modal-card-foot">
            <button
              class="button"
              type="button"
              @click="isCreateModalActive = false"
            >
              {{ trans.get("general.close") }}
            </button>
            <!-- @click.prevent="createVideo" -->
            <button class="button is-primary">
              {{ trans.get("general.add") }}
            </button>
          </footer>
        </div>
      </form>
    </b-modal>
    <b-modal :active.sync="isGroupModalActive" width="95%" scroll="keep">
      <div class="p-5 rounded has-background-light">
        <button class="button is-info" @click="disableAll">
          <i class="fas fa-eraser mr-2"></i>
          {{ trans.get("utils.remove_selection") }}
        </button>
        <div v-for="group in groups" class="p-3" :key="group.id">
          <div class="columns">
            <div class="column is-narrow is-flex has-all-centered">
              <div class="field">
                <b-switch
                  :value="getVisibility(group.id)"
                  true-value="1"
                  false-value="0"
                  @input="toggleVisibility(group.id)"
                  type="is-info"
                  >{{ group.name }}</b-switch
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["code", "groups"],
  mounted() {
    this.getVideos();
  },
  data: function () {
    return {
      isModalActive: true,
      videochats: [],
      isCreateModalActive: false,
      isGroupModalActive: false,
      currentVideochat: null,
      type: 0,
      url: "",
      name: "",
    };
  },
  methods: {
    selectGroups(videochat) {
      this.currentVideochat = videochat;
      if (!this.currentVideochat.groups) this.currentVideochat.groups = [];
      this.isGroupModalActive = true;
    },
    getVisibility(id) {
      if (this.currentVideochat && this.currentVideochat.groups)
        return this.currentVideochat.groups.indexOf(id) === -1 ? 1 : 0;
    },
    disableAll() {
      this.currentVideochat.groups = [];
      this.groups.forEach((group) => {
        this.currentVideochat.groups.push(group.id);
      });
      axios.post("/classroom/videochat/groups", {
        id: this.currentVideochat.id,
        groups: this.currentVideochat.groups,
      });
    },
    toggleVisibility(id) {
      var index = this.currentVideochat.groups.indexOf(id);
      if (index === -1) {
        this.currentVideochat.groups.push(id);
      } else {
        this.currentVideochat.groups.splice(index, 1);
      }
      if (!this.currentVideochat.groups) this.currentVideochat.groups = [];
      axios.post("/classroom/videochat/groups", {
        id: this.currentVideochat.id,
        groups: this.currentVideochat.groups,
      });
    },
    sendNotify(videochat) {
      axios.post("/classroom/videochat/notify", { id: videochat });
      this.$toast(this.trans.get("success_error.add_success"), {
        type: "success",
      });
    },
    updateEnabled(videochat) {
      axios.patch("/classroom/videochat/toggle", {
        id: videochat.id,
        active: videochat.active,
      });
    },
    deleteVC(id) {
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
          axios.delete("/classroom/videochat/" + id).then((response) => {
            this.getVideos();
          });
        },
      });
    },
    openChat(videochat) {
      window.open(videochat.url, "_blank");
    },
    createVideo() {
      axios
        .post("/classroom/" + this.code + "/videochat", {
          name: this.name,
          url: this.url,
        })
        .then((response) => {
          this.getVideos();
          this.isCreateModalActive = false;
        });
    },
    getVideos() {
      axios
        .get("/classroom/" + this.code + "/videochats/get")
        .then((response) => {
          this.videochats = response.data;
        });
    },
  },
};
</script>