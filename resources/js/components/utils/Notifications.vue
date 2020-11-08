<template>
  <div class="is-flex has-all-centered left-auto">
    <div
      class="m-3 cursor-pointer"
      style="display: initial !important"
      @click="
        show = 1;
        open = true;
      "
      v-if="countCards()"
    >
      <i class="fad fa-club" style="font-size: 1.25em"></i>
      <span
        class="tag is-danger"
        style="font-size: 0.7em"
        v-html="countCards()"
      ></span>
    </div>
    <div v-if="notifications && notifications.length">
      <span
        class="cursor-pointer"
        @click="
          show = 0;
          open = true;
        "
      >
        <i class="fad fa-bell" style="font-size: 1.25em"></i>
        <span
          class="tag is-danger"
          style="font-size: 0.65em; margin-left: -4px"
          >{{ notifications.length }}</span
        >
      </span>
    </div>
    <b-sidebar
      type="is-light"
      :fullheight="fullheight"
      :fullwidth="false"
      :overlay="overlay"
      :right="true"
      :open.sync="open"
      icon-pack="fa"
      mobile="fullwidth"
    >
      <div class="close-button" @click="open = false">
        <button
          class="button is-danger is-light border"
          @click="deleteNotification(1)"
          v-if="show == 0"
        >
          <i class="fal fa-trash-alt mr-1"></i>
          {{ trans.get("general.delete_all") }}
        </button>
        <button class="button"><i class="fal fa-times"></i></button>
      </div>
      <div class="pt-6" v-if="show == 0">
        <div
          class="card my-1"
          v-for="(notification, index) in notifications"
          :key="notification.id"
        >
          <header class="card-header">
            <p class="card-header-title">
              <i
                class="fad mr-2"
                :class="{
                  'fa-comment': notification.data.type == 'comment',
                  'fa-paper-plane': notification.data.type == 'message',
                }"
              ></i>
              {{ notification.data.from.title }}
              <span class="left-auto"
                ><time
                  :datetime="notification.data.from.datetime"
                  class="tag is-light"
                  >{{ notification.data.from.datetime }}</time
                ></span
              >
              <i
                class="fas ml-1"
                :class="{
                  'fa-user-graduate': notification.data.user == 'teacher',
                  'fa-user': notification.data.user == 'student',
                }"
              ></i>
            </p>
          </header>
          <div class="card-content">
            <div class="content">
              <img
                :src="notification.data.from.avatar"
                v-if="notification.data.from.type == 'student'"
                width="12px"
                alt="avatar"
              />
              <span v-else v-html="notification.data.from.avatar"></span>
              <strong v-tippy :content="notification.data.from.name"
                >{{ notification.data.from.name }}</strong
              >: {{ notification.data.content }}
            </div>
          </div>
          <footer class="card-footer">
            <a
              v-if="notification.data.user == 'student'"
              :href="notification.data.url"
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              {{ trans.get("general.classroom") }}
            </a>
            <a
              v-if="notification.data.user == 'teacher'"
              :href="notification.data.url"
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              {{ trans.get("menu." + notification.data.section) }}</a
            >
            <a
              @click="deleteNotification(0, notification.id, index)"
              class="card-footer-item has-background-danger-light has-text-dark"
              >{{ trans.get("general.delete") }}</a
            >
          </footer>
        </div>
      </div>
      <div v-if="show == 1">
        <div v-for="(line, index) in pending" :key="index">
          <div
            class="columns has-all-centered"
            v-for="(card, indexC) in line.cards"
            :key="indexC"
          >
            <div class="column is-narrow">
              <show-card
                style="zoom: 0.75"
                :card="card"
                admin="false"
              ></show-card>
            </div>
            <div class="column is-narrow is-flex has-all-centered">
              <h4 class="is-size-4">{{ line.student.name }}</h4>
            </div>
            <div class="column is-flex is-narrow has-all-centered">
              <button
                class="button is-success"
                @click="
                  setCard(card.id, line, card.pivot.marked, true, index, indexC)
                "
                v-text="getText(card.pivot.marked)"
              ></button>
              <button
                class="button is-danger ml-2"
                @click="
                  setCard(
                    card.id,
                    line,
                    card.pivot.marked,
                    false,
                    index,
                    indexC
                  )
                "
              >
                Cancel
              </button>
            </div>
          </div>
        </div>
      </div>
    </b-sidebar>
  </div>
</template>
<script>
export default {
  props: {
    pending: {
      type: Array,
      default() {
        return [];
      },
    },
    notifications: {
      type: Array,
      default() {
        return [];
      },
    },
    type: {
      type: String,
      default() {
        return "student";
      },
    },
  },
  mounted() {
    this.cards = this.pending;
    for (let i = 0; i < this.cards.length; i++) {
      this.cards[i].cards = Object.values(this.cards[i].cards);
    }
  },
  data: function () {
    return {
      open: false,
      show: 0,
      overlay: true,
      fullheight: true,
      fullwidth: false,
      cards: [],
    };
  },
  methods: {
    deleteNotification(type, id = null, index = null) {
      this.open = false;
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
          let action = "";
          if (type === 1) action = "/all";
          axios
            .post("/notification/delete" + action, {
              id: id,
              type: this.type,
            })
            .then((response) => {
              if (type === 0) {
                this.notifications.splice(index, 1);
              } else {
                this.notifications.splice(0, this.notifications.length);
              }
              this.$forceUpdate();
            });
        },
      });
    },
    getText(type) {
      if (type == 1) {
        return "Use";
      } else {
        return "Delete";
      }
    },
    setCard(id, line, type, action, index, indexC) {
      if (!action) {
        this.cards[index].cards.splice(indexC, 1);
        if (!this.cards[index].cards.length) this.open = false;
      }
      this.$forceUpdate();
      axios
        .post("/classroom/card/usedelete/" + id, {
          student: line.student.id,
          action: action,
          type: type,
        })
        .then((response) => {
          this.$toasted.show(response.data.message, {
            position: "top-center",
            duration: 3000,
            iconPack: "fontawesome",
            icon: response.data.icon,
            type: response.data.type,
          });
          if (action) {
            if (response.data.type == "success") location.reload();
          }
        });
    },
    countCards() {
      let count = 0;
      this.pending.forEach((element) => {
        count += _.size(element.cards);
      });
      return count;
    },
  },
  computed: {},
};
</script>