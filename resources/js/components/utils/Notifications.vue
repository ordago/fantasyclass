<template>
  <div class="is-flex has-all-centered left-auto">
    <div class="mr-1 cursor-pointer button" @click="redirect('/inbox')">
      <i class="fad fa-comments-alt" style="font-size: 1.25em"></i>
      <span v-if="user.pending_messages" class="tag is-danger tag-notif">{{
        user.pending_messages
      }}</span>
    </div>
    <div
      class="mr-1 cursor-pointer button"
      @click="
        show = 1;
        open = true;
      "
      v-if="countCards()"
    >
      <i class="fad fa-club" style="font-size: 1.25em"></i>
      <span class="tag is-danger tag-notif" v-html="countCards()"></span>
    </div>
    <div
      class="button cursor-pointer"
      @click="
        show = 0;
        open = true;
      "
      v-if="notifications && notifications.length"
    >
      <i class="fad fa-bell" style="font-size: 1.25em"></i>
      <span class="tag is-danger tag-notif">{{ notifications.length }}</span>
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
                  'fa-bullhorn': notification.data.type == 'notification',
                  'fa-comments-alt': notification.data.type == 'chat',
                  'fa-club': notification.data.type == 'mark_card',
                  'fa-pen-fancy': notification.data.type == 'challenge',
                  'fa-heart': notification.data.type == 'new_behaviour',
                  'fa-coins': notification.data.type == 'money_sent',
                  'fa-feather': notification.data.type == 'post',
                }"
              ></i>
              {{ trans.get(notification.data.from.title) }}
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
              <strong
                v-tippy
                v-html="notification.data.from.name"
                :content="notification.data.from.name"
                ></strong
              >: <span v-html="trans.get(notification.data.content)"></span>
            </div>
          </div>
          <footer class="card-footer">
            <a
              v-if="
                notification.data.user == 'student' &&
                notification.data.type == 'chat'
              "
              :href="notification.data.url"
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              <i class="fad fa-comments-alt ml-1"></i>
            </a>
            <a
              v-if="
                notification.data.user == 'teacher' &&
                notification.data.type == 'post'
              "
              :href="'/classroom/' + notification.data.classroom + '/student/' + notification.data.section"
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              <i class="fad fa-user ml-1"></i>
            </a>
            <a
              v-else-if="notification.data.user == 'student'"
              :href="notification.data.url"
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              {{ trans.get("general.classroom") }}
            </a>
            <a
              v-else-if="notification.data.user == 'teacher'"
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
    user: {
      type: Object,
      default() {
        return {};
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
    redirect(url) {
      location.href = url;
    },
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
          this.$toast(response.data.message, { type: response.data.type });

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
<style lang="scss">
.tag.tag-notif {
  position: relative;
  font-size: 0.5em;
  top: 5px;
  left: -1px;
  padding: 0 6px 0 6px;
}
</style>