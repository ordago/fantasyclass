import firebaseApp from 'firebase/app'

import 'firebase/firestore'
import 'firebase/database'
import 'firebase/storage'

const config = 
    process.env.NODE_ENV === 'development' ?
    JSON.parse(process.env.VUE_APP_FIREBASE_CONFIG) :
    JSON.parse(process.env.VUE_APP_FIREBASE_CONFIG_PUBLIC);

firebaseApp.initializeApp(config)

export const firebase = firebaseApp
export const db = firebaseApp.firestore()
export const storageRef = firebaseApp.storage().ref()

export const usersRef = db.collection('users')
export const roomsRef = db.collection('chatRooms')

export const filesRef = storageRef.child('files')

export const dbTimestamp = firebase.firestore.FieldValue.serverTimestamp()
export const deleteDbField = firebase.firestore.FieldValue.delete()
