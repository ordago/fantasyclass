(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[15],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Chat.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Chat.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_advanced_chat__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-advanced-chat */ "./node_modules/vue-advanced-chat/dist/vue-advanced-chat.common.js");
/* harmony import */ var vue_advanced_chat__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_advanced_chat__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_advanced_chat_dist_vue_advanced_chat_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-advanced-chat/dist/vue-advanced-chat.css */ "./node_modules/vue-advanced-chat/dist/vue-advanced-chat.css");
/* harmony import */ var vue_advanced_chat_dist_vue_advanced_chat_css__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_advanced_chat_dist_vue_advanced_chat_css__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _firestore__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./firestore */ "./resources/js/components/utils/firestore/index.js");
/* harmony import */ var _functions_dates__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./functions/dates */ "./resources/js/components/utils/functions/dates.js");


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = (_defineProperty({
  props: [""],
  components: {
    ChatWindow: vue_advanced_chat__WEBPACK_IMPORTED_MODULE_1___default.a
  },
  methods: {
    typingMessage: function typingMessage(event) {// console.log(event);
    },
    sendMessageReaction: function sendMessageReaction(event) {
      console.log(event);
    },
    messageActionHandler: function messageActionHandler(event) {
      console.log(event);
    },
    menuActionHandler: function menuActionHandler(event) {
      console.log(event);
    },
    addRoom: function addRoom() {},
    openFile: function openFile(event) {
      console.log(event);
    },
    deleteMessage: function deleteMessage(event) {
      console.log(event);
    },
    editMessage: function editMessage(event) {
      console.log(event);
    },
    fetchMessages: function fetchMessages(event) {
      console.log(event);
    },
    sendMessage: function sendMessage(event) {
      console.log(event);
    }
  },
  data: function data() {
    var _ref;

    return _ref = {
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
      menuActions: [{
        name: "inviteUser",
        title: "Invite User"
      }, {
        name: "removeUser",
        title: "Remove User"
      }, {
        name: "deleteRoom",
        title: "Delete Room"
      }],
      styles: {
        container: {
          borderRadius: "4px"
        }
      },
      rooms: []
    }, _defineProperty(_ref, "messages", []), _defineProperty(_ref, "currentUserId", "1"), _ref;
  },
  mounted: function mounted() {
    this.fetchRooms();
    this.updateUserOnlineStatus();
  },
  destroyed: function destroyed() {
    this.resetRooms();
  }
}, "methods", {
  messagesRef: function messagesRef(roomId) {
    return _firestore__WEBPACK_IMPORTED_MODULE_3__["roomsRef"].doc(roomId).collection("messages");
  },
  resetRooms: function resetRooms() {
    this.loadingRooms = true;
    this.rooms = [];
    this.roomsListeners.forEach(function (listener) {
      return listener();
    });
    this.resetMessages();
  },
  resetMessages: function resetMessages() {
    this.messages = [];
    this.messagesLoaded = false;
    this.start = null;
    this.end = null;
    this.listeners.forEach(function (listener) {
      return listener();
    });
    this.listeners = [];
  },
  fetchRooms: function fetchRooms() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      var query, rooms, roomList, rawRoomUsers, rawMessages, users, roomMessages, formattedRooms;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _this.resetRooms();

              query = _firestore__WEBPACK_IMPORTED_MODULE_3__["roomsRef"].where("users", "array-contains", _this.currentUserId);
              _context.next = 4;
              return query.get();

            case 4:
              rooms = _context.sent;
              roomList = [];
              rawRoomUsers = [];
              rawMessages = [];
              rooms.forEach(function (room) {
                roomList[room.id] = _objectSpread(_objectSpread({}, room.data()), {}, {
                  users: []
                });
                var rawUsers = [];
                room.data().users.map(function (userId) {
                  var promise = _firestore__WEBPACK_IMPORTED_MODULE_3__["usersRef"].doc(userId).get().then(function (user) {
                    return _objectSpread(_objectSpread({}, user.data()), {
                      roomId: room.id,
                      username: user.data().username
                    });
                  });
                  rawUsers.push(promise);
                });
                rawUsers.map(function (users) {
                  return rawRoomUsers.push(users);
                });
                rawMessages.push(_this.getLastMessage(room));
              });
              _context.next = 11;
              return Promise.all(rawRoomUsers);

            case 11:
              users = _context.sent;
              users.map(function (user) {
                return roomList[user.roomId].users.push(user);
              });
              _context.next = 15;
              return Promise.all(rawMessages).then(function (messages) {
                return messages.map(function (message) {
                  return {
                    lastMessage: _this.formatLastMessage(message),
                    roomId: message.roomId
                  };
                });
              });

            case 15:
              roomMessages = _context.sent;
              roomMessages.map(function (ms) {
                return roomList[ms.roomId].lastMessage = ms.lastMessage;
              });
              formattedRooms = [];
              Object.keys(roomList).forEach(function (key) {
                var room = roomList[key];
                var roomContacts = room.users.filter(function (user) {
                  return user._id !== _this.currentUserId;
                });
                room.roomName = roomContacts.map(function (user) {
                  return user.username;
                }).join(", ") || "Myself";
                var roomAvatar = roomContacts.length === 1 && roomContacts[0].avatar ? roomContacts[0].avatar : __webpack_require__(/*! ./assets/no_group_avatar.png */ "./resources/js/components/utils/assets/no_group_avatar.png");
                formattedRooms.push(_objectSpread({}, _objectSpread({
                  roomId: key,
                  avatar: roomAvatar
                }, room)));
              });
              _this.rooms = _this.rooms.concat(formattedRooms);
              _this.loadingRooms = false;

              _this.rooms.map(function (room, index) {
                return _this.listenLastMessage(room, index);
              });

              _this.listenUsersOnlineStatus();

              _this.listenRoomsTypingUsers(query);

            case 24:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  getLastMessage: function getLastMessage(room) {
    return this.messagesRef(room.id).orderBy("timestamp", "desc").limit(1).get().then(function (messages) {
      var array = [];
      messages.forEach(function (m) {
        return array.push(m.data());
      });
      return _objectSpread(_objectSpread({}, array[0]), {}, {
        roomId: room.id
      });
    });
  },
  listenLastMessage: function listenLastMessage(room, index) {
    var _this2 = this;

    var listener = this.messagesRef(room.roomId).orderBy("timestamp", "desc").limit(1).onSnapshot(function (messages) {
      messages.forEach(function (message) {
        var lastMessage = _this2.formatLastMessage(message.data());

        _this2.rooms[index].lastMessage = lastMessage;
      });
    });
    this.roomsListeners.push(listener);
  },
  formatLastMessage: function formatLastMessage(message) {
    if (!message.timestamp) return;
    var date = new Date(message.timestamp.seconds * 1000);
    var timestampFormat = Object(_functions_dates__WEBPACK_IMPORTED_MODULE_4__["isSameDay"])(date, new Date()) ? "HH:mm" : "DD/MM/YY";
    var timestamp = Object(_functions_dates__WEBPACK_IMPORTED_MODULE_4__["parseTimestamp"])(message.timestamp, timestampFormat);
    if (timestampFormat === "HH:mm") timestamp = "Today, ".concat(timestamp);
    var content = message.content;
    if (message.file) content = "".concat(message.file.name, ".").concat(message.file.type);
    return _objectSpread(_objectSpread({}, message), {
      content: content,
      timestamp: timestamp,
      date: message.timestamp.seconds,
      seen: message.sender_id === this.currentUserId ? message.seen : null,
      "new": message.sender_id !== this.currentUserId && (!message.seen || !message.seen[this.currentUserId])
    });
  },
  fetchMessages: function fetchMessages(_ref2) {
    var _this3 = this;

    var room = _ref2.room,
        _ref2$options = _ref2.options,
        options = _ref2$options === void 0 ? {} : _ref2$options;
    if (options.reset) this.resetMessages();
    if (this.end && !this.start) return this.messagesLoaded = true;
    var ref = this.messagesRef(room.roomId);
    var query = ref.orderBy("timestamp", "desc").limit(this.perPage);
    if (this.start) query = query.startAfter(this.start);
    this.selectedRoom = room.roomId;
    query.get().then(function (messages) {
      if (_this3.selectedRoom !== room.roomId) return;
      if (messages.empty) _this3.messagesLoaded = true;
      if (_this3.start) _this3.end = _this3.start;
      _this3.start = messages.docs[messages.docs.length - 1];
      var listenerQuery = ref.orderBy("timestamp");
      if (_this3.start) listenerQuery = listenerQuery.startAfter(_this3.start);
      if (_this3.end) listenerQuery = listenerQuery.endAt(_this3.end);
      if (options.reset) _this3.messages = [];
      messages.forEach(function (message) {
        var formattedMessage = _this3.formatMessage(room, message);

        _this3.messages.unshift(formattedMessage);
      });
      var listener = listenerQuery.onSnapshot(function (snapshots) {
        _this3.listenMessages(snapshots, room);
      });

      _this3.listeners.push(listener);
    });
  },
  listenMessages: function listenMessages(messages, room) {
    var _this4 = this;

    messages.forEach(function (message) {
      var formattedMessage = _this4.formatMessage(room, message);

      var messageIndex = _this4.messages.findIndex(function (m) {
        return m._id === message.id;
      });

      if (messageIndex === -1) {
        _this4.messages = _this4.messages.concat([formattedMessage]);
      } else {
        _this4.$set(_this4.messages, messageIndex, formattedMessage);
      }

      _this4.markMessagesSeen(room, message);
    });
  },
  markMessagesSeen: function markMessagesSeen(room, message) {
    if (message.data().sender_id !== this.currentUserId && (!message.data().seen || !message.data().seen[this.currentUserId])) {
      this.messagesRef(room.roomId).doc(message.id).update(_defineProperty({}, "seen.".concat(this.currentUserId), new Date()));
    }
  },
  formatMessage: function formatMessage(room, message) {
    var senderUser = room.users.find(function (user) {
      return message.data().sender_id === user._id;
    });

    var _message$data = message.data(),
        sender_id = _message$data.sender_id,
        timestamp = _message$data.timestamp;

    return _objectSpread(_objectSpread({}, message.data()), {
      sender_id: sender_id,
      _id: message.id,
      seconds: timestamp.seconds,
      timestamp: Object(_functions_dates__WEBPACK_IMPORTED_MODULE_4__["parseTimestamp"])(timestamp, "HH:mm"),
      date: Object(_functions_dates__WEBPACK_IMPORTED_MODULE_4__["parseTimestamp"])(timestamp, "DD MMMM YYYY"),
      username: senderUser ? senderUser.username : null
    });
  },
  sendMessage: function sendMessage(_ref3) {
    var _this5 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
      var content, roomId, file, replyMessage, message, _yield$_this5$message, id;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              content = _ref3.content, roomId = _ref3.roomId, file = _ref3.file, replyMessage = _ref3.replyMessage;
              message = {
                sender_id: _this5.currentUserId,
                content: content,
                timestamp: new Date()
              };

              if (file) {
                message.file = {
                  name: file.name,
                  size: file.size,
                  type: file.type,
                  url: file.localUrl
                };
              }

              if (replyMessage) {
                message.replyMessage = {
                  _id: replyMessage._id,
                  content: replyMessage.content,
                  sender_id: replyMessage.sender_id
                };

                if (replyMessage.file) {
                  message.replyMessage.file = replyMessage.file;
                }
              }

              _context2.next = 6;
              return _this5.messagesRef(roomId).add(message);

            case 6:
              _yield$_this5$message = _context2.sent;
              id = _yield$_this5$message.id;
              if (file) _this5.uploadFile({
                file: file,
                messageId: id,
                roomId: roomId
              });

            case 9:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }))();
  },
  openFile: function openFile(_ref4) {
    var message = _ref4.message,
        action = _ref4.action;
    window.open(message.file.url, "_blank");
  },
  editMessage: function editMessage(_ref5) {
    var _this6 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3() {
      var messageId, newContent, roomId, file, newMessage;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
        while (1) {
          switch (_context3.prev = _context3.next) {
            case 0:
              messageId = _ref5.messageId, newContent = _ref5.newContent, roomId = _ref5.roomId, file = _ref5.file;
              newMessage = {
                edited: new Date()
              };
              newMessage.content = newContent;

              if (file) {
                newMessage.file = {
                  name: file.name,
                  size: file.size,
                  type: file.type,
                  url: file.url || file.localUrl
                };
              } else {
                newMessage.file = _firestore__WEBPACK_IMPORTED_MODULE_3__["deleteDbField"];
              }

              _context3.next = 6;
              return _this6.messagesRef(roomId).doc(messageId).update(newMessage);

            case 6:
            case "end":
              return _context3.stop();
          }
        }
      }, _callee3);
    }))();
  },
  deleteMessage: function deleteMessage(_ref6) {
    var _this7 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee4() {
      var messageId, roomId;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee4$(_context4) {
        while (1) {
          switch (_context4.prev = _context4.next) {
            case 0:
              messageId = _ref6.messageId, roomId = _ref6.roomId;
              _context4.next = 3;
              return _this7.messagesRef(roomId).doc(messageId).update({
                deleted: new Date()
              });

            case 3:
            case "end":
              return _context4.stop();
          }
        }
      }, _callee4);
    }))();
  },
  uploadFile: function uploadFile(_ref7) {
    var _this8 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee5() {
      var file, messageId, roomId, uploadFileRef, url;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee5$(_context5) {
        while (1) {
          switch (_context5.prev = _context5.next) {
            case 0:
              file = _ref7.file, messageId = _ref7.messageId, roomId = _ref7.roomId;
              uploadFileRef = _firestore__WEBPACK_IMPORTED_MODULE_3__["filesRef"].child(_this8.currentUserId).child(messageId).child("".concat(file.name, ".").concat(file.type));
              _context5.next = 4;
              return uploadFileRef.put(file.blob, {
                contentType: file.type
              });

            case 4:
              _context5.next = 6;
              return uploadFileRef.getDownloadURL();

            case 6:
              url = _context5.sent;
              _context5.next = 9;
              return _this8.messagesRef(roomId).doc(messageId).update(_defineProperty({}, "file.url", url));

            case 9:
            case "end":
              return _context5.stop();
          }
        }
      }, _callee5);
    }))();
  },
  menuActionHandler: function menuActionHandler(_ref8) {
    var action = _ref8.action,
        roomId = _ref8.roomId;

    switch (action.name) {
      case "inviteUser":
        return this.inviteUser(roomId);

      case "removeUser":
        return this.removeUser(roomId);

      case "deleteRoom":
        return this.deleteRoom(roomId);
    }
  },
  messageActionHandler: function messageActionHandler() {// do something
  },
  sendMessageReaction: function sendMessageReaction(_ref9) {
    var _this9 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee6() {
      var reaction, remove, messageId, roomId, dbAction;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee6$(_context6) {
        while (1) {
          switch (_context6.prev = _context6.next) {
            case 0:
              reaction = _ref9.reaction, remove = _ref9.remove, messageId = _ref9.messageId, roomId = _ref9.roomId;
              dbAction = remove ? _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].firestore.FieldValue.arrayRemove(_this9.currentUserId) : _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].firestore.FieldValue.arrayUnion(_this9.currentUserId);
              _context6.next = 4;
              return _this9.messagesRef(roomId).doc(messageId).update(_defineProperty({}, "reactions.".concat(reaction.name), dbAction));

            case 4:
            case "end":
              return _context6.stop();
          }
        }
      }, _callee6);
    }))();
  },
  typingMessage: function typingMessage(_ref10) {
    var message = _ref10.message,
        roomId = _ref10.roomId;
    var dbAction = message ? _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].firestore.FieldValue.arrayUnion(this.currentUserId) : _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].firestore.FieldValue.arrayRemove(this.currentUserId);
    _firestore__WEBPACK_IMPORTED_MODULE_3__["roomsRef"].doc(roomId).update({
      typingUsers: dbAction
    });
  },
  listenRoomsTypingUsers: function listenRoomsTypingUsers(query) {
    var _this10 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee7() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee7$(_context7) {
        while (1) {
          switch (_context7.prev = _context7.next) {
            case 0:
              query.onSnapshot(function (rooms) {
                rooms.forEach(function (room) {
                  var foundRoom = _this10.rooms.find(function (r) {
                    return r.roomId === room.id;
                  });

                  if (foundRoom) foundRoom.typingUsers = room.data().typingUsers;
                });
              });

            case 1:
            case "end":
              return _context7.stop();
          }
        }
      }, _callee7);
    }))();
  },
  updateUserOnlineStatus: function updateUserOnlineStatus() {
    var userStatusRef = _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].database().ref("/status/" + this.currentUserId);
    var isOfflineData = {
      state: "offline",
      last_changed: _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].database.ServerValue.TIMESTAMP
    };
    var isOnlineData = {
      state: "online",
      last_changed: _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].database.ServerValue.TIMESTAMP
    };
    _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].database().ref(".info/connected").on("value", function (snapshot) {
      if (snapshot.val() == false) return;
      userStatusRef.onDisconnect().set(isOfflineData).then(function () {
        userStatusRef.set(isOnlineData);
      });
    });
  },
  listenUsersOnlineStatus: function listenUsersOnlineStatus() {
    var _this11 = this;

    this.rooms.map(function (room) {
      room.users.map(function (user) {
        _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].database().ref("/status/" + user._id).on("value", function (snapshot) {
          if (!snapshot.val()) return;
          var timestampFormat = Object(_functions_dates__WEBPACK_IMPORTED_MODULE_4__["isSameDay"])(new Date(snapshot.val().last_changed), new Date()) ? "HH:mm" : "DD MMMM, HH:mm";
          var timestamp = Object(_functions_dates__WEBPACK_IMPORTED_MODULE_4__["parseTimestamp"])(new Date(snapshot.val().last_changed), timestampFormat);
          var last_changed = timestampFormat === "HH:mm" ? "today, ".concat(timestamp) : timestamp;
          user.status = _objectSpread(_objectSpread({}, snapshot.val()), {}, {
            last_changed: last_changed
          });

          var roomIndex = _this11.rooms.findIndex(function (r) {
            return room.roomId === r.roomId;
          });

          _this11.$set(_this11.rooms, roomIndex, room);
        });
      });
    });
  },
  addRoom: function addRoom() {
    this.resetForms();
    this.addNewRoom = true;
  },
  createRoom: function createRoom() {
    var _this12 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee8() {
      var _yield$usersRef$add, id;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee8$(_context8) {
        while (1) {
          switch (_context8.prev = _context8.next) {
            case 0:
              _this12.disableForm = true;
              _context8.next = 3;
              return _firestore__WEBPACK_IMPORTED_MODULE_3__["usersRef"].add({
                username: _this12.addRoomUsername
              });

            case 3:
              _yield$usersRef$add = _context8.sent;
              id = _yield$usersRef$add.id;
              _context8.next = 7;
              return _firestore__WEBPACK_IMPORTED_MODULE_3__["usersRef"].doc(id).update({
                _id: id
              });

            case 7:
              _context8.next = 9;
              return _firestore__WEBPACK_IMPORTED_MODULE_3__["roomsRef"].add({
                users: [id, _this12.currentUserId]
              });

            case 9:
              _this12.addNewRoom = false;
              _this12.addRoomUsername = "";

              _this12.fetchRooms();

            case 12:
            case "end":
              return _context8.stop();
          }
        }
      }, _callee8);
    }))();
  },
  inviteUser: function inviteUser(roomId) {
    this.resetForms();
    this.inviteRoomId = roomId;
  },
  addRoomUser: function addRoomUser() {
    var _this13 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee9() {
      var _yield$usersRef$add2, id;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee9$(_context9) {
        while (1) {
          switch (_context9.prev = _context9.next) {
            case 0:
              _this13.disableForm = true;
              _context9.next = 3;
              return _firestore__WEBPACK_IMPORTED_MODULE_3__["usersRef"].add({
                username: _this13.invitedUsername
              });

            case 3:
              _yield$usersRef$add2 = _context9.sent;
              id = _yield$usersRef$add2.id;
              _context9.next = 7;
              return _firestore__WEBPACK_IMPORTED_MODULE_3__["usersRef"].doc(id).update({
                _id: id
              });

            case 7:
              _context9.next = 9;
              return _firestore__WEBPACK_IMPORTED_MODULE_3__["roomsRef"].doc(_this13.inviteRoomId).update({
                users: _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].firestore.FieldValue.arrayUnion(id)
              });

            case 9:
              _this13.inviteRoomId = null;
              _this13.invitedUsername = "";

              _this13.fetchRooms();

            case 12:
            case "end":
              return _context9.stop();
          }
        }
      }, _callee9);
    }))();
  },
  removeUser: function removeUser(roomId) {
    this.resetForms();
    this.removeRoomId = roomId;
    this.removeUsers = this.rooms.find(function (room) {
      return room.roomId === roomId;
    }).users;
  },
  deleteRoomUser: function deleteRoomUser() {
    var _this14 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee10() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee10$(_context10) {
        while (1) {
          switch (_context10.prev = _context10.next) {
            case 0:
              _this14.disableForm = true;
              _context10.next = 3;
              return _firestore__WEBPACK_IMPORTED_MODULE_3__["roomsRef"].doc(_this14.removeRoomId).update({
                users: _firestore__WEBPACK_IMPORTED_MODULE_3__["firebase"].firestore.FieldValue.arrayRemove(_this14.removeUserId)
              });

            case 3:
              _this14.removeRoomId = null;
              _this14.removeUserId = "";

              _this14.fetchRooms();

            case 6:
            case "end":
              return _context10.stop();
          }
        }
      }, _callee10);
    }))();
  },
  deleteRoom: function deleteRoom(roomId) {
    var _this15 = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee11() {
      var ref;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee11$(_context11) {
        while (1) {
          switch (_context11.prev = _context11.next) {
            case 0:
              ref = _this15.messagesRef(roomId);
              ref.get().then(function (res) {
                if (res.empty) return;
                res.docs.map(function (doc) {
                  return ref.doc(doc.id)["delete"]();
                });
              });
              _context11.next = 4;
              return _firestore__WEBPACK_IMPORTED_MODULE_3__["roomsRef"].doc(roomId)["delete"]();

            case 4:
              _this15.fetchRooms();

            case 5:
            case "end":
              return _context11.stop();
          }
        }
      }, _callee11);
    }))();
  },
  resetForms: function resetForms() {
    this.disableForm = false;
    this.addNewRoom = null;
    this.addRoomUsername = "";
    this.inviteRoomId = null;
    this.invitedUsername = "";
    this.removeRoomId = null;
    this.removeUserId = "";
  }
}));

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".window-container[data-v-5c84f3a1] {\n  width: 100%;\n}\n.chat-forms[data-v-5c84f3a1] {\n  padding-bottom: 20px;\n}\n.chat-forms form[data-v-5c84f3a1] {\n  padding-top: 20px;\n}\n.chat-forms input[data-v-5c84f3a1] {\n  padding: 5px;\n  width: 180px;\n  height: 21px;\n  border-radius: 4px;\n  border: 1px solid #d2d6da;\n  outline: none;\n  font-size: 14px;\n  vertical-align: middle;\n}\n.chat-forms input[data-v-5c84f3a1]::-moz-placeholder {\n  color: #9ca6af;\n}\n.chat-forms input[data-v-5c84f3a1]:-ms-input-placeholder {\n  color: #9ca6af;\n}\n.chat-forms input[data-v-5c84f3a1]::placeholder {\n  color: #9ca6af;\n}\n.chat-forms button[data-v-5c84f3a1] {\n  background: #1976d2;\n  color: #fff;\n  outline: none;\n  cursor: pointer;\n  border-radius: 4px;\n  padding: 8px 12px;\n  margin-left: 10px;\n  border: none;\n  font-size: 14px;\n  transition: 0.3s;\n  vertical-align: middle;\n}\n.chat-forms button[data-v-5c84f3a1]:hover {\n  opacity: 0.8;\n}\n.chat-forms button[data-v-5c84f3a1]:active {\n  opacity: 0.6;\n}\n.chat-forms button[data-v-5c84f3a1]:disabled {\n  cursor: initial;\n  background: #c6c9cc;\n  opacity: 0.6;\n}\n.chat-forms .button-cancel[data-v-5c84f3a1] {\n  color: #a8aeb3;\n  background: none;\n  margin-left: 5px;\n}\n.chat-forms select[data-v-5c84f3a1] {\n  vertical-align: middle;\n  height: 33px;\n  width: 120px;\n  font-size: 13px;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/dist/cjs.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Chat.vue?vue&type=template&id=5c84f3a1&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/utils/Chat.vue?vue&type=template&id=5c84f3a1&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("chat-window", {
    attrs: {
      height: "calc(100vh - 73px)",
      styles: _vm.styles,
      currentUserId: _vm.currentUserId,
      rooms: _vm.rooms,
      loadingRooms: _vm.loadingRooms,
      messages: _vm.messages,
      messagesLoaded: _vm.messagesLoaded,
      menuActions: _vm.menuActions
    },
    on: {
      fetchMessages: _vm.fetchMessages,
      sendMessage: _vm.sendMessage,
      editMessage: _vm.editMessage,
      deleteMessage: _vm.deleteMessage,
      openFile: _vm.openFile,
      addRoom: _vm.addRoom,
      menuActionHandler: _vm.menuActionHandler,
      messageActionHandler: _vm.messageActionHandler,
      sendMessageReaction: _vm.sendMessageReaction,
      typingMessage: _vm.typingMessage
    }
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/utils/Chat.vue":
/*!************************************************!*\
  !*** ./resources/js/components/utils/Chat.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Chat_vue_vue_type_template_id_5c84f3a1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Chat.vue?vue&type=template&id=5c84f3a1&scoped=true& */ "./resources/js/components/utils/Chat.vue?vue&type=template&id=5c84f3a1&scoped=true&");
/* harmony import */ var _Chat_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Chat.vue?vue&type=script&lang=js& */ "./resources/js/components/utils/Chat.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Chat_vue_vue_type_style_index_0_id_5c84f3a1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true& */ "./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Chat_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Chat_vue_vue_type_template_id_5c84f3a1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Chat_vue_vue_type_template_id_5c84f3a1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "5c84f3a1",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/utils/Chat.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/utils/Chat.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/utils/Chat.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Chat.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true& ***!
  \**********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_5c84f3a1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/dist/cjs.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Chat.vue?vue&type=style&index=0&id=5c84f3a1&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_5c84f3a1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_5c84f3a1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_5c84f3a1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_5c84f3a1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_dist_cjs_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_style_index_0_id_5c84f3a1_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/utils/Chat.vue?vue&type=template&id=5c84f3a1&scoped=true&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/utils/Chat.vue?vue&type=template&id=5c84f3a1&scoped=true& ***!
  \*******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_5c84f3a1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Chat.vue?vue&type=template&id=5c84f3a1&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/utils/Chat.vue?vue&type=template&id=5c84f3a1&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_5c84f3a1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Chat_vue_vue_type_template_id_5c84f3a1_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/utils/assets/no_group_avatar.png":
/*!******************************************************************!*\
  !*** ./resources/js/components/utils/assets/no_group_avatar.png ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "/images/no_group_avatar.png?f5ae032089871a0cad251c5e3f90bd5b";

/***/ }),

/***/ "./resources/js/components/utils/firestore/index.js":
/*!**********************************************************!*\
  !*** ./resources/js/components/utils/firestore/index.js ***!
  \**********************************************************/
/*! exports provided: firebase, db, storageRef, usersRef, roomsRef, filesRef, dbTimestamp, deleteDbField */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function(process) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "firebase", function() { return firebase; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "db", function() { return db; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "storageRef", function() { return storageRef; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "usersRef", function() { return usersRef; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "roomsRef", function() { return roomsRef; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "filesRef", function() { return filesRef; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "dbTimestamp", function() { return dbTimestamp; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "deleteDbField", function() { return deleteDbField; });
/* harmony import */ var firebase_app__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! firebase/app */ "./node_modules/firebase/app/dist/index.esm.js");
/* harmony import */ var firebase_firestore__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! firebase/firestore */ "./node_modules/firebase/firestore/dist/index.esm.js");
/* harmony import */ var firebase_database__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! firebase/database */ "./node_modules/firebase/database/dist/index.esm.js");
/* harmony import */ var firebase_storage__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! firebase/storage */ "./node_modules/firebase/storage/dist/index.esm.js");




var config =  true ? JSON.parse(process.env.VUE_APP_FIREBASE_CONFIG) : undefined;
firebase_app__WEBPACK_IMPORTED_MODULE_0__["default"].initializeApp(config);
var firebase = firebase_app__WEBPACK_IMPORTED_MODULE_0__["default"];
var db = firebase_app__WEBPACK_IMPORTED_MODULE_0__["default"].firestore();
var storageRef = firebase_app__WEBPACK_IMPORTED_MODULE_0__["default"].storage().ref();
var usersRef = db.collection('users');
var roomsRef = db.collection('chatRooms');
var filesRef = storageRef.child('files');
var dbTimestamp = firebase.firestore.FieldValue.serverTimestamp();
var deleteDbField = firebase.firestore.FieldValue["delete"]();
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../../../../node_modules/process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./resources/js/components/utils/functions/dates.js":
/*!**********************************************************!*\
  !*** ./resources/js/components/utils/functions/dates.js ***!
  \**********************************************************/
/*! exports provided: parseTimestamp, isSameDay */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseTimestamp", function() { return parseTimestamp; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isSameDay", function() { return isSameDay; });
var parseTimestamp = function parseTimestamp(timestamp) {
  var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
  if (!timestamp) return;
  var date = timestamp.seconds ? new Date(timestamp.seconds * 1000) : timestamp;

  if (format === 'HH:mm') {
    return "".concat(zeroPad(date.getHours(), 2), ":").concat(zeroPad(date.getMinutes(), 2));
  } else if (format === 'DD MMMM YYYY') {
    var options = {
      month: 'long',
      year: 'numeric',
      day: 'numeric'
    };
    return "".concat(new Intl.DateTimeFormat('en-GB', options).format(date));
  } else if (format === 'DD/MM/YY') {
    var _options = {
      month: 'numeric',
      year: 'numeric',
      day: 'numeric'
    };
    return "".concat(new Intl.DateTimeFormat('en-GB', _options).format(date));
  } else if (format === 'DD MMMM, HH:mm') {
    var _options2 = {
      month: 'long',
      day: 'numeric'
    };
    return "".concat(new Intl.DateTimeFormat('en-GB', _options2).format(date), ", ").concat(zeroPad(date.getHours(), 2), ":").concat(zeroPad(date.getMinutes(), 2));
  }

  return date;
};

var zeroPad = function zeroPad(num, pad) {
  return String(num).padStart(pad, '0');
};

var isSameDay = function isSameDay(d1, d2) {
  return d1.getFullYear() === d2.getFullYear() && d1.getMonth() === d2.getMonth() && d1.getDate() === d2.getDate();
};

/***/ })

}]);