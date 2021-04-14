import firebaseApp from 'firebase/app'

import 'firebase/firestore'
import 'firebase/database'
import 'firebase/storage'

var config = {
    apiKey: process.env.MIX_FIREBASE_API,
    authDomain: process.env.MIX_FIREBASE_AUTH_DOMAIN,
    databaseURL: process.env.MIX_FIREBASE_DATABASE,
    projectId: process.env.MIX_FIREBASE_PROJECT_ID,
    storageBucket: process.env.MIX_FIREBASE_BUCKET,
    messagingSenderId: process.env.MIX_FIREBASE_SENDER,
    appId: process.env.MIX_FIREBASE_APPID,
  };

firebaseApp.initializeApp(config)

export const firebase = firebaseApp
export const db = firebaseApp.firestore()
export const storageRef = firebaseApp.storage().ref()

export const usersRef = db.collection('users')
export const roomsRef = db.collection('chatRooms')
export const messagesRef = roomId => roomsRef.doc(roomId).collection('messages')

export const filesRef = storageRef.child('files')

export const dbTimestamp = firebase.firestore.FieldValue.serverTimestamp()
export const deleteDbField = firebase.firestore.FieldValue.delete()
