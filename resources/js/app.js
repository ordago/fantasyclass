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

Vue.prototype.trans = new Lang({
    messages,
    locale: default_locale,
    fallback: fallback_locale
});

Vue.prototype.print = window.print;

// Toast management
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
Vue.use(Toast, {
    transition: "Vue-Toastification__bounce",
    maxToasts: 20,
    newestOnTop: true
  });

// Tippy poppover
import VueTippy, {
    TippyComponent
} from "vue-tippy";
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

Vue.use(Croppa)

Vue.component('create-classroom', () => import('./components/classroom/CreateClassroom.vue'));
Vue.component('join-classroom', require('./components/classroom/JoinClassroom.vue').default);
Vue.component('clone-classroom', require('./components/classroom/CloneClassroom.vue').default);

Vue.component('add-students', () => import('./components/student/AddStudents.vue'));
Vue.component('show-students', require('./components/student/ShowStudents.vue').default);
Vue.component('show-character', require('./components/student/ShowCharacter.vue').default);
Vue.component('show-students-student', () => import('./components/student/ShowStudentsStudent.vue'));
Vue.component('show-group-view', require('./components/student/ShowGroupView.vue').default);
Vue.component('show-student-info', () => import('./components/student/ShowStudentInfo.vue'));

Vue.component('show-student-map', () => import('./components/student/ShowStudentMap.vue'));
Vue.component('show-student', require('./components/student/ShowStudent.vue').default);
Vue.component('show-student-teacher', require('./components/student/ShowStudentTeacher.vue').default);

Vue.component('show-card', () => import('./components/card/ShowCard.vue'));
Vue.component('show-cards', () => import('./components/card/ShowCards.vue'));
Vue.component('create-card', () => import('./components/card/CreateCard.vue'));

Vue.component('create-behaviour', () => import('./components/behaviour/CreateBehaviour.vue'));
Vue.component('show-behaviours', require('./components/behaviour/ShowBehaviours.vue').default);

Vue.component('create-badge', () => import('./components/badge/CreateBadge.vue'));
Vue.component('show-badges', require('./components/badge/ShowBadges.vue').default);

Vue.component('create-levels', require('./components/level/CreateLevels.vue').default);
Vue.component('show-level', require('./components/level/ShowLevel.vue').default);
Vue.component('show-levels', () => import('./components/level/ShowLevels.vue'));
Vue.component('show-level-student', require('./components/level/ShowLevelStudent.vue').default);

Vue.component('show-challenges-group', () => import('./components/challenges/ShowChallengesGroup.vue'));
Vue.component('show-challenges', () => import('./components/challenges/ShowChallenges.vue'));
Vue.component('show-challenge', () => import('./components/challenges/ShowChallenge.vue'));
Vue.component('import-challenge', () => import('./components/challenges/ImportChallenges.vue'));
Vue.component('create-challenges-group', () => import('./components/challenges/CreateChallengeGroup.vue'));
Vue.component('create-challenges', () => require('./components/challenges/CreateChallenges.vue').default);

Vue.component('show-question', () => import('./components/challenges/ShowQuestion.vue'));

Vue.component('create-group', () => import('./components/group/CreateGroups.vue'));
Vue.component('edit-group', () => import('./components/group/EditGroup.vue'));

Vue.component('show-shop', () => import('./components/shop/ShowShop.vue'));
Vue.component('shop-create', () => import('./components/shop/ShopCreate.vue'));

Vue.component('show-maps', () => import('./components/map/ShowMaps.vue'));
Vue.component('create-map', () => import('./components/map/CreateMap.vue'));

Vue.component('settings', require('./components/settings/Settings.vue').default);

Vue.component('show-event', () => import('./components/event/ShowEvent.vue'));
Vue.component('show-events', () => import('./components/event/ShowEvents.vue'));

Vue.component('show-pets', () => import('./components/pet/ShowPets.vue'));
Vue.component('show-monsters', () => import('./components/monster/ShowMonsters.vue'));

Vue.component('edit-rules', () => import('./components/rules/EditRules.vue'));

Vue.component('profile', () => import('./components/profile/Profile.vue'));

Vue.component('tag-management', () => import('./components/evaluation/TagManagement.vue'));
Vue.component('grade', () => import('./components/evaluation/Grade.vue'));
Vue.component('report', () => import('./components/evaluation/Report.vue'));
Vue.component('rubric-management', () => import('./components/evaluation/RubricManagement.vue'));
Vue.component('rubric-create', () => import('./components/evaluation/RubricCreate.vue'));

Vue.component('question-banks', () => import('./components/questions/ShowQuestionBanks.vue'));
Vue.component('create-question-bank', () => import('./components/questions/CreateQuestionBank.vue'));
Vue.component('show-questions', () => import('./components/questions/ShowQuestions.vue'));

// Utils
// For use this component the parent component should have a data attibute called "icon", where the icon will be stored
// Vue.component('icon-selector', () => import('./components/utils/IconSelector.vue').default);

// For use this component the parent component should have a data attibute called "content", where the html will be stored
// Vue.component('editor', () => import('./components/utils/Editor.vue').default);

Vue.component('image-bank', () => import('./components/utils/ImageBank.vue'));

Vue.component('count-down', () => import('./components/utils/CountDown.vue'));

Vue.component('notifications', require('./components/utils/Notifications.vue').default);

Vue.component('input-emoji', () => import('./components/utils/InputEmoji.vue').default);

Vue.component('import-excel', () => import('./components/utils/ImportExcel.vue').default);

Vue.component('wheel', require('./components/utils/Wheel.vue').default);

Vue.component('volume-meter', () => import('./components/utils/VolumeMeter.vue'));

Vue.component('massive-actions', () => import('./components/utils/MassiveActions.vue'));

Vue.component('chat', () => import('./components/utils/Chat.vue'));

Vue.component('mobile', () => import('./components/utils/Mobile.vue'));

Vue.component('battles', () => import('./components/battles/Battle.vue'));

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
        // axios.get('/utils/online')
        //     .then(response => {
        //         this.$nextTick(function () {
        //             window.setInterval(() => {
        //                 axios.get('/utils/online');
        //             }, 290000);
        //         })
        //     })
        //     .catch(
        //         function (error) {
        //             console.log('Show error notification!')
        //             return Promise.reject(error)
        //         })
    },
});
