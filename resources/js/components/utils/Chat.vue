<template>
  <chat-window
    :currentUserId="currentUserId"
    :rooms="rooms"
    :messages="messages"
    @sendMessage="sendMessage"
    @fetchMessages="fetchMessages"
    @editMessage="editMessage"
    @deleteMessage="deleteMessage"
    @openFile="openFile"
    @addRoom="addRoom"
    @menuActionHandler="menuActionHandler"
    @messageActionHandler="messageActionHandler"
    @sendMessageReaction="sendMessageReaction"
    @typingMessage="typingMessage"
  />
</template>

<script>
import ChatWindow from "vue-advanced-chat";
import "vue-advanced-chat/dist/vue-advanced-chat.css";

export default {
  props: [""],
  components: {
    ChatWindow,
  },
  methods: {
    typingMessage(event) {
      // console.log(event);
    },
    sendMessageReaction(event) {
      console.log(event);
    },
    messageActionHandler(event) {
      console.log(event);
    },
    menuActionHandler(event) {
      console.log(event);
    },
    addRoom() {
      
    },
    openFile(event) {
      console.log(event);
    },
    deleteMessage(event) {
      console.log(event);
    },
    editMessage(event) {
      console.log(event);
    },
    fetchMessages(event) {
      console.log(event);
    },
    sendMessage(event) {
      console.log(event);
    },
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
        { name: "removeUser", title: "Remove User" },
        { name: "deleteRoom", title: "Delete Room" },
      ],
      styles: { container: { borderRadius: "4px" } },
      rooms: [
        {
          roomId: 1,
          roomName: "Room 1",
          unreadCount: 0,
          lastMessage: {
            content: "Last message received",
            sender_id: 1234,
            username: "John Doe",
            timestamp: "10:20",
            date: 123242424,
            seen: true,
            new: false,
          },
          users: [
            {
              _id: 1234,
              username: "John Doe",
              status: {
                state: "online",
                last_changed: "today, 14:30",
              },
            },
            {
              _id: 4321,
              username: "John Snow",
              status: {
                state: "offline",
                last_changed: "14 July, 20:00",
              },
            },
          ],
          typingUsers: [4321],
        },
        {
          roomId: 1,
          roomName: "Room 1",
          unreadCount: 0,
          lastMessage: {
            content: "Last message received",
            sender_id: 1234,
            username: "John Doe",
            timestamp: "10:20",
            date: 123242424,
            seen: true,
            new: false,
          },
          users: [
            {
              _id: 1234,
              username: "John Doe",
              status: {
                state: "online",
                last_changed: "today, 14:30",
              },
            },
            {
              _id: 4321,
              username: "John Snow",
              status: {
                state: "offline",
                last_changed: "14 July, 20:00",
              },
            },
          ],
          typingUsers: [4321],
        },
      ],
      messages: [],
      currentUserId: 1,
    };
  },
};
</script>