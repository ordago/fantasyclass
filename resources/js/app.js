/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./utils');

window.Vue = require('vue');

import Lang from 'lang.js';
import messages from '../assets/js/ll_messages';
const default_locale = window.default_locale;
const fallback_locale = window.fallback_locale;

Vue.prototype.trans = new Lang( {
    messages,
    locale: default_locale,
    fallback: fallback_locale
});

Vue.prototype.print = window.print;

// Toast management
import Toasted from 'vue-toasted';
Vue.use(Toasted)

// Tippy poppover
import VueTippy, { TippyComponent } from "vue-tippy";
import "tippy.js/themes/light.css";

Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

// Cookies
import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

// Buefy
import Buefy from 'buefy'
Vue.use(Buefy, {
    defaultIconPack: 'fas',
})

// Crop plugin
import Croppa from 'vue-croppa'
import 'vue-croppa/dist/vue-croppa.css'
import Axios from 'axios';

Vue.use(Croppa)

Vue.component('create-classroom', require('./components/classroom/CreateClassroom.vue').default);
Vue.component('join-classroom', require('./components/classroom/JoinClassroom.vue').default);
Vue.component('clone-classroom', require('./components/classroom/CloneClassroom.vue').default);

Vue.component('add-students', require('./components/student/AddStudents.vue').default);
Vue.component('show-students', require('./components/student/ShowStudents.vue').default);
Vue.component('show-character', require('./components/student/ShowCharacter.vue').default);
Vue.component('show-students-student', require('./components/student/ShowStudentsStudent.vue').default);
Vue.component('show-group-view', require('./components/student/ShowGroupView.vue').default);
Vue.component('show-student-info', () => import('./components/student/ShowStudentInfo.vue'));

Vue.component('show-student-map', require('./components/student/ShowStudentMap.vue').default);
Vue.component('show-student', require('./components/student/ShowStudent.vue').default);
Vue.component('show-student-teacher', require('./components/student/ShowStudentTeacher.vue').default);

Vue.component('show-card', require('./components/card/ShowCard.vue').default);
Vue.component('show-cards', require('./components/card/ShowCards.vue').default);
Vue.component('create-card', require('./components/card/CreateCard.vue').default);

Vue.component('create-behaviour', () => import('./components/behaviour/CreateBehaviour.vue'));
Vue.component('show-behaviours', require('./components/behaviour/ShowBehaviours.vue').default);

Vue.component('create-badge', () => import('./components/badge/CreateBadge.vue'));
Vue.component('show-badges', require('./components/badge/ShowBadges.vue').default);

Vue.component('create-levels', require('./components/level/CreateLevels.vue').default);
Vue.component('show-level', require('./components/level/ShowLevel.vue').default);
Vue.component('show-levels', require('./components/level/ShowLevels.vue').default);
Vue.component('show-level-student', require('./components/level/ShowLevelStudent.vue').default);

Vue.component('show-challenges-group', require('./components/challenges/ShowChallengesGroup.vue').default);
Vue.component('show-challenges', require('./components/challenges/ShowChallenges.vue').default);
Vue.component('show-challenge', require('./components/challenges/ShowChallenge.vue').default);
Vue.component('import-challenge', require('./components/challenges/ImportChallenges.vue').default);
Vue.component('create-challenges-group', () => import('./components/challenges/CreateChallengeGroup.vue'));
Vue.component('create-challenges', () => import('./components/challenges/CreateChallenges.vue'));

Vue.component('show-question', require('./components/challenges/ShowQuestion.vue').default);

Vue.component('create-group', require('./components/group/CreateGroups.vue').default);
Vue.component('edit-group', require('./components/group/EditGroup.vue').default);

Vue.component('show-shop', require('./components/shop/ShowShop.vue').default);
Vue.component('shop-create', require('./components/shop/ShopCreate.vue').default);

Vue.component('show-maps', require('./components/map/ShowMaps.vue').default);
Vue.component('create-map', require('./components/map/CreateMap.vue').default);

Vue.component('settings', require('./components/settings/Settings.vue').default);

Vue.component('show-event', require('./components/event/ShowEvent.vue').default);
Vue.component('show-events', require('./components/event/ShowEvents.vue').default);

Vue.component('show-pets', require('./components/pet/ShowPets.vue').default);

Vue.component('edit-rules', require('./components/rules/EditRules.vue').default);

Vue.component('profile', require('./components/profile/Profile.vue').default);

Vue.component('tag-management', require('./components/evaluation/TagManagement.vue').default);
Vue.component('grade', require('./components/evaluation/Grade.vue').default);
Vue.component('report', require('./components/evaluation/Report.vue').default);
Vue.component('rubric-management', require('./components/evaluation/RubricManagement.vue').default);
Vue.component('rubric-create', () => import('./components/evaluation/RubricCreate.vue'));

// Utils
// For use this component the parent component should have a data attibute called "icon", where the icon will be stored
// Vue.component('icon-selector', () => import('./components/utils/IconSelector.vue').default);

// For use this component the parent component should have a data attibute called "content", where the html will be stored
// Vue.component('editor', () => import('./components/utils/Editor.vue').default);

Vue.component('image-bank', require('./components/utils/ImageBank.vue').default);

Vue.component('count-down', require('./components/utils/CountDown.vue').default);

Vue.component('notifications', require('./components/utils/Notifications.vue').default);

Vue.component('input-emoji', () => import('./components/utils/InputEmoji.vue').default);

Vue.component('import-excel', () => import('./components/utils/ImportExcel.vue').default);

Vue.component('wheel', require('./components/utils/Wheel.vue').default);

Vue.component('volume-meter', require('./components/utils/VolumeMeter.vue').default);

Vue.component('massive-actions', require('./components/utils/MassiveActions.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Declare general function to get or set status into storage

// // Declare general function to change status prompt
// const promptToggle = (element, toAdd, toRemove) => {
//     element.classList.add(toAdd);
//     element.classList.remove(toRemove);
//   };

// const statusPrompt = {
//     get: () => {
//       return localStorage.getItem('statusPrompt') || null;
//     },
//     set: (status) => {
//       localStorage.setItem('statusPrompt', status);
//       return;
//     }
//   }

// const prompt = document.querySelector('#prompt');
// const buttonAdd = document.querySelector('#buttonAdd');
// const buttonCancel = document.querySelector('#buttonCancel');

// let deferredPrompt;
// window.addEventListener('beforeinstallprompt', (e) => {
//   // Prevent Chrome 67 and earlier from automatically showing the prompt
//   e.preventDefault();
//   // Stash the event so it can be triggered later.
//   deferredPrompt = e;
//   // Show prompt modal if user previously not set to dismissed or accepted
//   if(!statusPrompt.get()) {
//     // Change status prompt
//     promptToggle(prompt, 'show', 'hide');
//   }
// });

// // Add event click function for Cancel button
// buttonCancel.addEventListener('click', (e) => {
//   // Change status prompt
//   promptToggle(prompt, 'hide', 'show');
//   // Set status prompt to dismissed
//   statusPrompt.set('dismissed');
// });

// // Add event click function for Add button
// buttonAdd.addEventListener('click', (e) => {
//   // Change status prompt
//   promptToggle(prompt, 'hide', 'show');
//   // Show the prompt
//   deferredPrompt.prompt();
//   // Wait for the user to respond to the prompt
//   deferredPrompt.userChoice
//     .then((choiceResult) => {
//       if (choiceResult.outcome === 'accepted') {
//         statusPrompt.set('accepted');
//         console.log('User accepted the A2HS prompt');
//       } else {
//         statusPrompt.set('dismissed');
//         console.log('User dismissed the A2HS prompt');
//       }
//       deferredPrompt = null;
//     });
// });


const app = new Vue({
    el: '#app',
    data: {
        showNav: false
    },
    mounted: function () {
        axios.get('/utils/online');
        this.$nextTick(function () {
            window.setInterval(() => {
                axios.get('/utils/online');
            },290000);
        })
    }
});