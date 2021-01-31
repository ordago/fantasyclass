<template>
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
        <button class="button is-info  mb-4" @click="createVideo()">
          {{ trans.get("videochat.create") }}
        </button>
        <div
          class="m-2 is-flex is-flex-direction-column"
          v-for="videochat in videochats"
          :key="videochat.id"
        >
          <div>
            <h5 class="is-size-5">
              <i class="fad fa-video"></i> {{ videochat.name }}
              <small
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
              </small>
            </h5>
          </div>
          <div class="m-2 buttons">
            <button class="button is-link" @click="openChat(videochat)">
              <i class="fad fa-door-open mr-1"></i>
              {{ trans.get("videochat.open") }}
            </button>
            <button class="button is-dark" @click="sendNotify(videochat.id)">
              <i class="fad fa-paper-plane mr-1"></i>
              {{ trans.get("videochat.notify") }}
            </button>
            <button class="button is-danger" @click="deleteVC(videochat.id)">
              <i class="fad fa-trash-alt mr-1"></i>
              {{ trans.get("videochat.delete") }}
            </button>
          </div>
          <hr>
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
</template>

<script>
export default {
  props: ["code"],
  mounted() {
    this.getVideos();
  },
  data: function () {
    return {
      isModalActive: true,
      videochats: [],
    };
  },
  methods: {
    sendNotify(videochat) {
      axios.post('/classroom/videochat/notify', {id: videochat})
    },
    updateEnabled(videochat) {
      axios.patch('/classroom/videochat/toggle', {id: videochat.id, active: videochat.active})
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
      this.$buefy.dialog.prompt({
        message: this.trans.get("videochat.name"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        inputAttrs: {
          maxlength: 30,
        },
        trapFocus: true,
        onConfirm: (value) => {
          axios
            .post("/classroom/" + this.code + "/videochat", { name: value })
            .then((response) => {
              this.getVideos();
            });
        },
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