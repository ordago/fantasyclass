<template>
  <div class="is-flex has-all-centered left-auto">
    <tippy
      v-if="videochats.length"
      interactive
      class="mr-1"
      :animate-fill="false"
      theme="light"
      placement="bottom"
      animation="fade"
      trigger="click"
      style="display: inline-block"
      arrow
    >
      <template v-slot:trigger>
        <div class="cursor-pointer button has-background-danger-light">
          <i class="fad fa-video" style="font-size: 1.25em"></i>
          <span class="tag is-danger tag-notif ml-1">{{
            videochats.length
          }}</span>
        </div>
      </template>
      <span>
        <div class="columns" v-for="video in videochats" :key="video.id">
          <div class="column is-narrow">
            <a target="_blank" :href="video.url" class="button is-link"
              ><i class="fad fa-door-open"></i
            ></a>
          </div>
          <div class="column is-flex has-all-centered">
            {{ video.name }}
          </div>
        </div>
      </span>
    </tippy>

    <div
      @click="openDocs = true"
      v-if="docs.length"
      v-tippy
      :content="trans.get('menu.resources')"
      class="mr-1 cursor-pointer button has-background-warning-light"
    >
      <i class="fad fa-book" style="font-size: 1.25em"></i>
    </div>
    <div
      class="mr-1 cursor-pointer button has-background-link-light"
      @click="redirect('/inbox')"
    >
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
      <i class="fak fa-deck" style="font-size: 1.25em"></i>
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
      :can-cancel="false"
      type="is-light"
      :fullheight="true"
      :fullwidth="false"
      :overlay="overlay"
      :right="true"
      :open.sync="openDocs"
      icon-pack="fa"
      mobile="fullwidth"
    >
      <div class="close-button" @click="openDocs = false" style="z-index: 100">
        <button class="button"><i class="fal fa-times"></i></button>
      </div>

      <b-tabs size="is-small">
        <b-tab-item
          v-for="cat in docs"
          :key="cat.id"
          :label="cat.name"
          :icon="cat.icon"
          icon-pack="far"
        >
          <div
            class="columns my-0 px-3 py-0 panel-block"
            v-for="document in cat.documents"
            v-bind:key="document.id"
          >
            <div class="column my-0 py-0">
              <ShowDocument
                class="ml-4 mb-1"
                :document="document"
                :admin="false"
                :code="code"
              ></ShowDocument>
            </div>
          </div>
        </b-tab-item>
      </b-tabs>
    </b-sidebar>
    <b-sidebar
      type="is-light"
      :can-cancel="false"
      :fullheight="true"
      :fullwidth="false"
      :overlay="overlay"
      :right="true"
      :open.sync="open"
      icon-pack="fa"
      mobile="fullwidth"
      :key="version"
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
      <div class="pt-6 pl-1">
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'all';
            $forceUpdate();
          "
        >
          {{ trans.get("notifications.all") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'item';
            $forceUpdate();
          "
        >
          <i class="fad fa-store mr-1"></i> {{ getNotiCount("item") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'comment';
            $forceUpdate();
          "
        >
          <i class="fad fa-comment mr-1"></i> {{ getNotiCount("comment") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'message';
            $forceUpdate();
          "
        >
          <i class="fad fa-paper-plane mr-1"></i> {{ getNotiCount("message") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'notification';
            $forceUpdate();
          "
        >
          <i class="fad fa-comment-alt-lines mr-1"></i>
          {{ getNotiCount("notification") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'chat';
            $forceUpdate();
          "
        >
          <i class="fad fa-comments-alt mr-1"></i> {{ getNotiCount("chat") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'mark_card';
            $forceUpdate();
          "
        >
          <i class="fak fa-deck mr-1"></i> {{ getNotiCount("mark_card") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'challenge';
            $forceUpdate();
          "
        >
          <i class="fad fa-pen-fancy mr-1"></i> {{ getNotiCount("challenge") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'new_behaviour';
            $forceUpdate();
          "
        >
          <i class="fad fa-heart mr-1"></i> {{ getNotiCount("new_behaviour") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'money_sent';
            $forceUpdate();
          "
        >
          <i class="fad fa-coins mr-1"></i> {{ getNotiCount("money_sent") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'post';
            $forceUpdate();
          "
        >
          <i class="fad fa-feather mr-1"></i> {{ getNotiCount("post") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'skill';
            $forceUpdate();
          "
        >
          <i class="fad fa-sparkles mr-1"></i> {{ getNotiCount("skill") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'videochat';
            $forceUpdate();
          "
        >
          <i class="fad fa-video mr-1"></i> {{ getNotiCount("videochat") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'new_collectionable';
            $forceUpdate();
          "
        >
          <i class="fak fa-collection mr-1"></i>
          {{ getNotiCount("new_collectionable") }}
        </button>
        <button
          class="button is-rounded fs-85"
          @click="
            typeNotif = 'invitation';
            $forceUpdate();
          "
        >
          <i class="fad fa-user-graduate mr-1"></i>
          {{ getNotiCount("invitation") }}
        </button>
      </div>
      <div class="pt-1" v-if="show == 0">
        <div
          class="card my-1"
          v-for="(notification, index) in filteredNotifications"
          :key="notification.id"
        >
          <header class="card-header">
            <p class="card-header-title">
              <i
                class="mr-2"
                :class="{
                  'fad fa-store':
                    notification.data.type == 'item' ||
                    notification.data.type == 'use_item',
                  'fad fa-comment': notification.data.type == 'comment',
                  'fad fa-paper-plane': notification.data.type == 'message',
                  'fad fa-comment-alt-lines':
                    notification.data.type == 'notification',
                  'fad fa-comments-alt': notification.data.type == 'chat',
                  'fak fa-deck': notification.data.type == 'mark_card',
                  'fad fa-pen-fancy': notification.data.type == 'challenge',
                  'fad fa-heart': notification.data.type == 'new_behaviour',
                  'fad fa-coins': notification.data.type == 'money_sent',
                  'fad fa-feather': notification.data.type == 'post',
                  'fad fa-sparkles': notification.data.type == 'skill',
                  'fad fa-video': notification.data.type == 'videochat',
                  'fak fa-collection':
                    notification.data.type == 'new_collectionable',
                  'fad fa-user-graduate':
                    notification.data.type == 'invitation',
                }"
              ></i>
              {{ trans.get(notification.data.from.title) }}
              {{ getDateFrom(notification.data.from.datetime) }}
              <span class="left-auto"
                ><time
                  :datetime="notification.data.from.datetime"
                  class="tag is-light"
                  >{{ getDate(notification.data.from.datetime) }}</time
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
              ></strong>
              <span v-if="notification.data.from.name != ''">:</span>
              <img
                :src="notification.data.content"
                v-if="
                  notification.data.type == 'item' ||
                  notification.data.type == 'use_item'
                "
                width="20px"
                alt="avatar"
              />
              <span v-else v-html="trans.get(notification.data.content)"></span>
            </div>
          </div>
          <footer class="card-footer">
            <a
              v-if="
                notification.data.type == 'item' ||
                notification.data.type == 'use_item'
              "
              :href="
                '/classroom/' +
                notification.data.classroom +
                '/student/' +
                notification.data.section +
                '/section/1'
              "
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              <i class="fad fa-user ml-1"></i>
            </a>
            <a
              v-else-if="
                notification.data.user == 'student' &&
                notification.data.type == 'chat'
              "
              :href="notification.data.url"
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              <i class="fad fa-comments-alt ml-1"></i>
            </a>
            <a
              v-else-if="notification.data.type == 'videochat'"
              :href="notification.data.url"
              class="card-footer-item has-background-link-light has-text-dark"
            >
              <i class="fad fa-video mr-1"></i>
              {{ trans.get("videochat.open") }}
            </a>
            <a
              v-else-if="notification.data.type == 'invitation'"
              :href="notification.data.url"
              class="card-footer-item has-background-link-light has-text-dark"
            >
              <i class="fad fa-chalkboard mr-1"></i>
              {{ trans.get("settings.open") }}
            </a>
            <a
              v-else-if="
                notification.data.user == 'teacher' &&
                notification.data.type == 'post'
              "
              :href="
                '/classroom/' +
                notification.data.classroom +
                '/student/' +
                notification.data.section
              "
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              <i class="fad fa-user ml-1"></i>
            </a>
            <a
              v-else-if="
                notification.data.user == 'student' &&
                notification.data.type == 'comment'
              "
              :href="notification.data.url + '/challenges'"
              class="card-footer-item has-background-link-light has-text-dark"
              >{{ trans.get("notifications.go_to") }}
              {{ trans.get("general.classroom") }}
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
        <div
          class="columns has-all-centered"
          v-for="(card, index) in cards"
          :key="index"
        >
          <div class="column is-narrow">
            <show-card
              style="zoom: 0.75"
              :card="card"
              admin="false"
            ></show-card>
          </div>
          <div class="column is-narrow is-flex has-all-centered">
            <h4 class="is-size-4">{{ card.name }}</h4>
          </div>
          <div class="column is-flex is-narrow has-all-centered">
            <button
              class="button is-success"
              @click="setCard(card.card_id, card, card.marked, true, index)"
              v-text="getText(card.marked)"
            ></button>
            <button
              class="button is-danger ml-2"
              @click="setCard(card.card_id, card, card.marked, false, index)"
            >
              Cancel
            </button>
          </div>
          <!-- </div> -->
        </div>
      </div>
    </b-sidebar>
  </div>
</template>
<script>
import Utils from "../../utils.js";
import ShowDocument from "../documents/ShowDocument.vue";

export default {
  props: {
    docs: {
      type: Array,
      default() {
        return [];
      },
    },
    videochats: {
      type: Array,
      default() {
        return [];
      },
    },
    code: {
      type: String,
      default() {
        return "";
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
    pending: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  mounted() {
    this.cards = this.pending;
  },
  data: function () {
    return {
      open: false,
      show: 0,
      openDocs: false,
      overlay: true,
      fullheight: true,
      fullwidth: false,
      cards: [],
      typeNotif: "all",
      version: 0,
    };
  },
  methods: {
    getNotiCount(typeNotif) {
      let count = 0;
      this.notifications.forEach((notification) => {
        if (notification.data.type == typeNotif) count++;
      });
      return count;
    },
    getDate(date) {
      return Utils.getDate(date);
    },
    getDateFrom(date) {
      return Utils.getDateFrom(date, this.trans.locale);
    },
    redirect(url) {
      location.href = url;
    },
    deleteNotification(type, id = null, index = null) {
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
              if (this.notifications.length == 0) this.open = false;
              this.version++
              this.typeNotif = "all"
              this.$forceUpdate();
            });
        },
      });
    },
    getText(type) {
      if (type == 1) {
        return this.trans.get("cards.use");
      } else {
        return this.trans.get("cards.delete");
      }
    },
    setCard(id, line, type, action, index) {
      if (!action) {
        this.cards.splice(index, 1);
        if (!this.cards.length) this.open = false;
      }
      this.$forceUpdate();
      axios
        .post("/classroom/card/usedelete/" + id, {
          student: line.student_id,
          action: action,
          type: type,
        })
        .then((response) => {
          if (response.data.message)
            this.$toast(response.data.message, { type: response.data.type });

          if (action) {
            if (response.data.type == "success") location.reload();
          }
        });
    },
    countCards() {
      return this.cards.length;
    },
  },
  components: {
    ShowDocument,
  },
  computed: {
    filteredNotifications: function () {
      if (this.typeNotif == "all") return this.notifications;
      return this.notifications.filter((notification) => {
        return notification.data.type == this.typeNotif;
      });
    },
  },
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
.fs-85 {
  font-size: 0.85em;
}
</style>