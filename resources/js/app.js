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

// Toast management
import Toasted from 'vue-toasted';
Vue.use(Toasted)

// Tippy poppover
import VueTippy, { TippyComponent } from "vue-tippy";
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

import ElementUI from 'element-ui';
import { ElementTiptapPlugin } from 'element-tiptap';

// import ElementUI's styles
import 'element-ui/lib/theme-chalk/index.css';
// import this package's styles
import 'element-tiptap/lib/index.css';

// Crop plugin
import Croppa from 'vue-croppa'
import 'vue-croppa/dist/vue-croppa.css'
Vue.use(Croppa)

// use ElementUI's plugin
Vue.use(ElementUI);
// use this package's plugin
Vue.use(ElementTiptapPlugin, { /* plugin options */ });
// Now you register `'el-tiptap'` component globally.

Vue.component('create-classroom', require('./components/classroom/CreateClassroom.vue').default);
Vue.component('join-classroom', require('./components/classroom/JoinClassroom.vue').default);
Vue.component('clone-classroom', require('./components/classroom/CloneClassroom.vue').default);

Vue.component('add-students', require('./components/student/AddStudents.vue').default);
Vue.component('show-students', require('./components/student/ShowStudents.vue').default);
Vue.component('show-students-student', require('./components/student/ShowStudentsStudent.vue').default);
Vue.component('show-student-info', require('./components/student/ShowStudentInfo.vue').default);
Vue.component('show-student', require('./components/student/ShowStudent.vue').default);

Vue.component('show-card', require('./components/card/ShowCard.vue').default);
Vue.component('show-cards', require('./components/card/ShowCards.vue').default);
Vue.component('create-card', require('./components/card/CreateCard.vue').default);

Vue.component('create-behaviour', require('./components/behaviour/CreateBehaviour.vue').default);
Vue.component('show-behaviours', require('./components/behaviour/ShowBehaviours.vue').default);

Vue.component('create-levels', require('./components/level/CreateLevels.vue').default);
Vue.component('show-level', require('./components/level/ShowLevel.vue').default);
Vue.component('show-level-student', require('./components/level/ShowLevelStudent.vue').default);

Vue.component('show-challenges-group', require('./components/challenges/ShowChallengesGroup.vue').default);
Vue.component('show-challenges', require('./components/challenges/ShowChallenges.vue').default);
Vue.component('show-challenge', require('./components/challenges/ShowChallenge.vue').default);
Vue.component('create-challenges-group', require('./components/challenges/CreateChallengeGroup.vue').default);
Vue.component('create-challenges', require('./components/challenges/CreateChallenges.vue').default);

Vue.component('show-question', require('./components/challenges/ShowQuestion.vue').default);

Vue.component('create-group', require('./components/group/CreateGroups.vue').default);
Vue.component('edit-group', require('./components/group/EditGroup.vue').default);

Vue.component('show-shop', require('./components/shop/ShowShop.vue').default);
Vue.component('shop-create', require('./components/shop/ShopCreate.vue').default);

Vue.component('show-map', require('./components/map/ShowMap.vue').default);
Vue.component('create-map', require('./components/map/CreateMap.vue').default);

Vue.component('settings', require('./components/settings/Settings.vue').default);

Vue.component('show-event', require('./components/event/ShowEvent.vue').default);

// Utils

// For use this component the parent component should have a data attibute called "icon", where the icon will be stored
Vue.component('icon-selector', require('./components/utils/IconSelector.vue').default);

// For use this component the parent component should have a data attibute called "content", where the html will be stored
Vue.component('editor', require('./components/utils/Editor.vue').default);

Vue.component('count-down', require('./components/utils/CountDown.vue').default);

Vue.component('notifications', require('./components/utils/Notifications.vue').default);

Vue.component('input-emoji', require('./components/utils/InputEmoji.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    data: {
        showNav: false
    }
});