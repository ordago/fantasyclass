<template>
<div>
  <chat-window
    height="calc(100vh - 56px)"
    :styles="styles"
    :currentUserId="currentUserId"
    :rooms="rooms"
    :loadingRooms="loadingRooms"
    :messages="messages"
    :messagesLoaded="messagesLoaded"
    :menuActions="menuActions"
    @fetchMessages="fetchMessages"
    @sendMessage="sendMessage"
    @editMessage="editMessage"
    @deleteMessage="deleteMessage"
    @openFile="openFile"
    @addRoom="addRoom"
    @menuActionHandler="menuActionHandler"
    @messageActionHandler="messageActionHandler"
    @sendMessageReaction="sendMessageReaction"
    @typingMessage="typingMessage"
  >
  </chat-window>
</div>
</template>

<script>
import Utils from "../../utils.js";

import ChatWindow from "vue-advanced-chat";
import "vue-advanced-chat/dist/vue-advanced-chat.css";

import {
  firebase,
  roomsRef,
  usersRef,
  filesRef,
  deleteDbField,
} from "./firestore";
require("firebase/auth");
import { parseTimestamp, isSameDay } from "./functions/dates";
import { TYPE } from "vue-toastification";

export default {
  props: ["currentUserId", "currentUsername"],
  components: {
    ChatWindow,
  },
  data() {
    return {
      perPage: 20,
      loadingRooms: true,
      selectedRoom: null,
      messages: [],
      messagesLoaded: false,
      start: null,
      end: null,
      roomsListeners: [],
      listeners: [],
      disableForm: false,
      addNewRoom: null,
      addRoomUsername: "",
      inviteRoomId: null,
      invitedUsername: "",
      removeRoomId: null,
      removeUserId: "",
      removeUsers: [],
      menuActions: [
        { name: "inviteUser", title: "Invite User" },
        { name: "report", title: this.trans.get('utils.chat_report') },
        // { name: "deleteRoom", title: "Delete Room" },
      ],
      styles: { container: { borderRadius: "4px" } },
      rooms: [],
      messages: [],
    };
  },
  mounted() {
    this.$toast(this.trans.get('utils.chat_warning'), {type: 'warning', timeout: 3000})
    // this.$toast(this.trans.get('utils.chat_reminder'), {type: 'default'})
    axios.get("/inbox/token").then((response) => {
      firebase
        .auth()
        .signInWithCustomToken(response.data)
        .then((response) => {
          this.createUser().then((response) => {
            this.fetchRooms();
            this.updateUserOnlineStatus();
          });
        })
        .catch(function (error) {
          console.log(error);
        });
    });
  },
  destroyed() {
    this.resetRooms();
  },
  methods: {
    async createUser() {
      await usersRef
        .doc(this.currentUserId)
        .set({ _id: this.currentUserId, username: this.currentUsername });
    },
    messagesRef(roomId) {
      return roomsRef.doc(roomId).collection("messages");
    },
    resetRooms() {
      this.loadingRooms = true;
      this.rooms = [];
      this.roomsListeners.forEach((listener) => listener());
      this.resetMessages();
    },
    resetMessages() {
      this.messages = [];
      this.messagesLoaded = false;
      this.start = null;
      this.end = null;
      this.listeners.forEach((listener) => listener());
      this.listeners = [];
    },
    async fetchRooms() {
      this.resetRooms();
      const query = roomsRef.where(
        "users",
        "array-contains",
        this.currentUserId
      );
      const rooms = await query.get();
      const roomList = [];
      const rawRoomUsers = [];
      const rawMessages = [];
      rooms.forEach((room) => {
        roomList[room.id] = { ...room.data(), users: [] };
        const rawUsers = [];
        room.data().users.map((userId) => {
          const promise = usersRef
            .doc(userId)
            .get()
            .then((user) => {
              return {
                ...user.data(),
                ...{
                  roomId: room.id,
                  username: user.data().username,
                },
              };
            });
          rawUsers.push(promise);
        });
        rawUsers.map((users) => rawRoomUsers.push(users));
        rawMessages.push(this.getLastMessage(room));
      });
      const users = await Promise.all(rawRoomUsers);
      users.map((user) => roomList[user.roomId].users.push(user));
      const roomMessages = await Promise.all(rawMessages).then((messages) => {
        return messages.map((message) => {
          return {
            lastMessage: this.formatLastMessage(message),
            roomId: message.roomId,
          };
        });
      });
      roomMessages.map(
        (ms) => (roomList[ms.roomId].lastMessage = ms.lastMessage)
      );
      const formattedRooms = [];
      Object.keys(roomList).forEach((key) => {
        const room = roomList[key];
        const roomContacts = room.users.filter(
          (user) => user._id !== this.currentUserId
        );
        room.roomName =
          roomContacts.map((user) => user.username).join(", ") || "Myself";
        const roomAvatar =
          roomContacts.length === 1 && roomContacts[0].avatar
            ? roomContacts[0].avatar
            : require("./assets/no_group_avatar.png");
        formattedRooms.push({
          ...{
            roomId: key,
            avatar: roomAvatar,
            ...room,
          },
        });
      });
      this.rooms = this.rooms.concat(formattedRooms);
      this.loadingRooms = false;
      this.rooms.map((room, index) => this.listenLastMessage(room, index));
      // this.listenUsersOnlineStatus();
      // this.listenRoomsTypingUsers(query);
    },
    getLastMessage(room) {
      return this.messagesRef(room.id)
        .orderBy("timestamp", "desc")
        .limit(1)
        .get()
        .then((messages) => {
          const array = [];
          messages.forEach((m) => array.push(m.data()));
          return { ...array[0], roomId: room.id };
        });
    },
    listenLastMessage(room, index) {
      const listener = this.messagesRef(room.roomId)
        .orderBy("timestamp", "desc")
        .limit(1)
        .onSnapshot((messages) => {
          messages.forEach((message) => {
            const lastMessage = this.formatLastMessage(message.data());
            this.rooms[index].lastMessage = lastMessage;
          });
        });
      this.roomsListeners.push(listener);
    },
    formatLastMessage(message) {
      if (!message.timestamp) return;
      const date = new Date(message.timestamp.seconds * 1000);
      const timestampFormat = isSameDay(date, new Date())
        ? "HH:mm"
        : "DD/MM/YY";
      let timestamp = parseTimestamp(message.timestamp, timestampFormat);
      if (timestampFormat === "HH:mm") timestamp = `Today, ${timestamp}`;
      let content = message.content;
      if (message.file) content = `${message.file.name}.${message.file.type}`;
      return {
        ...message,
        ...{
          content,
          timestamp,
          date: message.timestamp.seconds,
          seen: message.sender_id === this.currentUserId ? message.seen : null,
          new:
            message.sender_id !== this.currentUserId &&
            (!message.seen || !message.seen[this.currentUserId]),
        },
      };
    },
    fetchMessages({ room, options = {} }) {
      if (options.reset) this.resetMessages();
      if (this.end && !this.start) return (this.messagesLoaded = true);
      let ref = this.messagesRef(room.roomId);
      let query = ref.orderBy("timestamp", "desc").limit(this.perPage);
      if (this.start) query = query.startAfter(this.start);
      this.selectedRoom = room.roomId;
      query.get().then((messages) => {
        if (this.selectedRoom !== room.roomId) return;
        if (messages.empty) this.messagesLoaded = true;
        if (this.start) this.end = this.start;
        this.start = messages.docs[messages.docs.length - 1];
        let listenerQuery = ref.orderBy("timestamp");
        if (this.start) listenerQuery = listenerQuery.startAfter(this.start);
        if (this.end) listenerQuery = listenerQuery.endAt(this.end);
        if (options.reset) this.messages = [];
        messages.forEach((message) => {
          const formattedMessage = this.formatMessage(room, message);
          this.messages.unshift(formattedMessage);
        });
        const listener = listenerQuery.onSnapshot((snapshots) => {
          this.listenMessages(snapshots, room);
        });
        this.listeners.push(listener);
      });
    },
    listenMessages(messages, room) {
      messages.forEach((message) => {
        const formattedMessage = this.formatMessage(room, message);
        const messageIndex = this.messages.findIndex(
          (m) => m._id === message.id
        );
        if (messageIndex === -1) {
          this.messages = this.messages.concat([formattedMessage]);
        } else {
          this.$set(this.messages, messageIndex, formattedMessage);
        }
        this.markMessagesSeen(room, message);
      });
    },
    markMessagesSeen(room, message) {
      if (
        message.data().sender_id !== this.currentUserId &&
        (!message.data().seen || !message.data().seen[this.currentUserId])
      ) {
        this.messagesRef(room.roomId)
          .doc(message.id)
          .update({
            [`seen.${this.currentUserId}`]: new Date(),
          });
      }
    },
    formatMessage(room, message) {
      const senderUser = room.users.find(
        (user) => message.data().sender_id === user._id
      );
      const { sender_id, timestamp } = message.data();
      return {
        ...message.data(),
        ...{
          sender_id,
          _id: message.id,
          seconds: timestamp.seconds,
          timestamp: parseTimestamp(timestamp, "HH:mm"),
          date: parseTimestamp(timestamp, "DD MMMM YYYY"),
          username: senderUser ? senderUser.username : null,
        },
      };
    },
    async sendMessage({ content, roomId, file, replyMessage }) {
      const message = {
        sender_id: this.currentUserId,
        content,
        timestamp: new Date(),
      };
      if (file) {
        message.file = {
          name: file.name,
          size: file.size,
          type: file.type,
          url: file.localUrl,
        };
      }
      if (replyMessage) {
        message.replyMessage = {
          _id: replyMessage._id,
          content: replyMessage.content,
          sender_id: replyMessage.sender_id,
        };
        if (replyMessage.file) {
          message.replyMessage.file = replyMessage.file;
        }
      }
      const { id } = await this.messagesRef(roomId).add(message);
      if (file) this.uploadFile({ file, messageId: id, roomId });

      const query = roomsRef.doc(roomId);
      const room = await query.get();
      
      let users = await roomsRef.doc("" + roomId);

      users
        .get()
        .then(function (doc) {
            axios.post('/chat/notify', { users : doc.data().users, message: content})
        })
        .catch(function (error) {
          console.log("Error getting document:", error);
        });

    },
    openFile({ message, action }) {
      window.open(message.file.url, "_blank");
    },
    async editMessage({ messageId, newContent, roomId, file }) {
      const newMessage = { edited: new Date() };
      newMessage.content = newContent;
      if (file) {
        newMessage.file = {
          name: file.name,
          size: file.size,
          type: file.type,
          url: file.url || file.localUrl,
        };
      } else {
        newMessage.file = deleteDbField;
      }
      await this.messagesRef(roomId).doc(messageId).update(newMessage);
    },
    async deleteMessage({ messageId, roomId }) {
      await this.messagesRef(roomId)
        .doc(messageId)
        .update({ deleted: new Date() });
    },
    async uploadFile({ file, messageId, roomId }) {
      const uploadFileRef = filesRef
        .child(this.currentUserId)
        .child(messageId)
        .child(`${file.name}.${file.type}`);
      await uploadFileRef.put(file.blob, { contentType: file.type });
      const url = await uploadFileRef.getDownloadURL();
      await this.messagesRef(roomId)
        .doc(messageId)
        .update({
          ["file.url"]: url,
        });
    },
    menuActionHandler({ action, roomId }) {
      switch (action.name) {
        case "inviteUser":
          return this.inviteUser(roomId);
        case "report":
          return this.report(this.messages);
        case "removeUser":
          return this.removeUser(roomId);
        case "deleteRoom":
          return this.deleteRoom(roomId);
      }
    },
    messageActionHandler() {
      // do something
    },
    async sendMessageReaction({ reaction, remove, messageId, roomId }) {
      const dbAction = remove
        ? firebase.firestore.FieldValue.arrayRemove(this.currentUserId)
        : firebase.firestore.FieldValue.arrayUnion(this.currentUserId);
      await this.messagesRef(roomId)
        .doc(messageId)
        .update({
          [`reactions.${reaction.name}`]: dbAction,
        });
    },
    typingMessage({ message, roomId }) {
      const dbAction = message
        ? firebase.firestore.FieldValue.arrayUnion(this.currentUserId)
        : firebase.firestore.FieldValue.arrayRemove(this.currentUserId);
      roomsRef.doc(roomId).update({
        typingUsers: dbAction,
      });
    },
    async listenRoomsTypingUsers(query) {
      query.onSnapshot((rooms) => {
        rooms.forEach((room) => {
          const foundRoom = this.rooms.find((r) => r.roomId === room.id);
          if (foundRoom) foundRoom.typingUsers = room.data().typingUsers;
        });
      });
    },
    updateUserOnlineStatus() {
      const userStatusRef = firebase
        .database()
        .ref("/status/" + this.currentUserId);
      const isOfflineData = {
        state: "offline",
        last_changed: firebase.database.ServerValue.TIMESTAMP,
      };
      const isOnlineData = {
        state: "online",
        last_changed: firebase.database.ServerValue.TIMESTAMP,
      };
      firebase
        .database()
        .ref(".info/connected")
        .on("value", (snapshot) => {
          if (snapshot.val() == false) return;
          userStatusRef
            .onDisconnect()
            .set(isOfflineData)
            .then(() => {
              userStatusRef.set(isOnlineData);
            });
        });
    },
    listenUsersOnlineStatus() {
      this.rooms.map((room) => {
        room.users.map((user) => {
          firebase
            .database()
            .ref("/status/" + user._id)
            .on("value", (snapshot) => {
              if (!snapshot.val()) return;
              const timestampFormat = isSameDay(
                new Date(snapshot.val().last_changed),
                new Date()
              )
                ? "HH:mm"
                : "DD MMMM, HH:mm";
              const timestamp = parseTimestamp(
                new Date(snapshot.val().last_changed),
                timestampFormat
              );
              const last_changed =
                timestampFormat === "HH:mm" ? `today, ${timestamp}` : timestamp;
              user.status = { ...snapshot.val(), last_changed };
              const roomIndex = this.rooms.findIndex(
                (r) => room.roomId === r.roomId
              );
              this.$set(this.rooms, roomIndex, room);
            });
        });
      });
    },

    addRoom() {
      this.resetForms();
      this.$buefy.dialog.prompt({
        message: this.trans.get("auth.username"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        trapFocus: true,
        onConfirm: (value) => {
          value = value.replace("@", "");
          axios
            .post("/users/chat", { username: value })
            .then((response) => {
              this.createRoom(response.data.id, response.data.username);
            })
            .catch((error) => {
              Utils.toast(
                this,
                this.trans.get("utils.user_not_exists"),
                TYPE.ERROR
              );
            });
        },
      });
    },

    async createRoom(uid, username) {
      this.disableForm = true;
      await usersRef.doc("" + uid).set({ _id: uid, username: username });
      await roomsRef.add({ users: ["" + uid, this.currentUserId] });
      this.fetchRooms();
    },
    report(messages) {

      this.$buefy.dialog.confirm({
        title: this.trans.get("utils.report"),
        message: this.trans.get("utils.chat_report_confirm"),
        confirmText: this.trans.get("utils.report"),
        cancelText: this.trans.get("general.cancel"),
        type: "is-warning",
        iconPack: "fa",
        hasIcon: false,
        onConfirm: () => {
            axios.post('/chat/send2admin', { messages: this.messages, room: this.selectedRoom}).then(response => {
              Utils.toast(
                this,
                "User has been reported",
                TYPE.SUCCESS
              );
            })
        }
      });
    },
    inviteUser(roomId) {
      this.$buefy.dialog.prompt({
        message: this.trans.get("auth.username"),
        confirmText: this.trans.get("general.add"),
        cancelText: this.trans.get("general.cancel"),
        trapFocus: true,
        onConfirm: (value) => {
          value = value.replace("@", "");
          axios
            .post("/users/chat", { username: value })
            .then((response) => {
              this.addRoomUser(
                response.data.id,
                response.data.username,
                roomId
              );
            })
            .catch((error) => {
              Utils.toast(
                this,
                this.trans.get("utils.user_not_exists"),
                TYPE.ERROR
              );
            });
        },
      });
    },
    async addRoomUser(uid, username, roomId) {
      console.log(roomId);
      await usersRef.doc("" + uid).set({ _id: uid, username: username });
      await roomsRef
        .doc(roomId)
        .update({ users: firebase.firestore.FieldValue.arrayUnion(uid + "") });
      this.fetchRooms();
    },
    removeUser(roomId) {
      this.resetForms();
      this.removeRoomId = roomId;
      this.removeUsers = this.rooms.find(
        (room) => room.roomId === roomId
      ).users;
    },
    async deleteRoomUser() {
      this.disableForm = true;
      await roomsRef.doc(this.removeRoomId).update({
        users: firebase.firestore.FieldValue.arrayRemove(this.removeUserId),
      });
      this.removeRoomId = null;
      this.removeUserId = "";
      this.fetchRooms();
    },
    async deleteRoom(roomId) {
      const ref = this.messagesRef(roomId);
      ref.get().then((res) => {
        if (res.empty) return;
        res.docs.map((doc) => ref.doc(doc.id).delete());
      });
      await roomsRef.doc(roomId).delete();
      this.fetchRooms();
    },
    resetForms() {
      this.disableForm = false;
      this.addNewRoom = null;
      this.addRoomUsername = "";
      this.inviteRoomId = null;
      this.invitedUsername = "";
      this.removeRoomId = null;
      this.removeUserId = "";
    },
  },
};
</script>

<style lang="scss" scoped>
.window-container {
  width: 100%;
}
.chat-forms {
  padding-bottom: 20px;
  form {
    padding-top: 20px;
  }
  input {
    padding: 5px;
    width: 180px;
    height: 21px;
    border-radius: 4px;
    border: 1px solid #d2d6da;
    outline: none;
    font-size: 14px;
    vertical-align: middle;
    &::placeholder {
      color: #9ca6af;
    }
  }
  button {
    background: #1976d2;
    color: #fff;
    outline: none;
    cursor: pointer;
    border-radius: 4px;
    padding: 8px 12px;
    margin-left: 10px;
    border: none;
    font-size: 14px;
    transition: 0.3s;
    vertical-align: middle;
    &:hover {
      opacity: 0.8;
    }
    &:active {
      opacity: 0.6;
    }
    &:disabled {
      cursor: initial;
      background: #c6c9cc;
      opacity: 0.6;
    }
  }
  .button-cancel {
    color: #a8aeb3;
    background: none;
    margin-left: 5px;
  }
  select {
    vertical-align: middle;
    height: 33px;
    width: 120px;
    font-size: 13px;
  }
}
</style>