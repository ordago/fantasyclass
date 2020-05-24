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

// Download excel
import JsonExcel from 'vue-json-excel'
Vue.component('downloadExcel', JsonExcel)

Vue.use(Buefy)

Vue.component('create-classroom', require('./components/classroom/CreateClassroom.vue').default);

Vue.component('add-students', require('./components/student/AddStudents.vue').default);
Vue.component('show-students', require('./components/student/ShowStudents.vue').default);

Vue.component('show-card', require('./components/card/ShowCard.vue').default);
Vue.component('show-cards', require('./components/card/ShowCards.vue').default);
Vue.component('create-card', require('./components/card/CreateCard.vue').default);

Vue.component('create-behaviour', require('./components/behaviour/CreateBehaviour.vue').default);
Vue.component('show-behaviours', require('./components/behaviour/ShowBehaviours.vue').default);

Vue.component('create-levels', require('./components/level/CreateLevels.vue').default);
Vue.component('show-level', require('./components/level/ShowLevel.vue').default);

Vue.component('show-challenges-group', require('./components/challenges/ShowChallengesGroup.vue').default);
Vue.component('show-challenges', require('./components/challenges/ShowChallenges.vue').default);
Vue.component('create-challenges-group', require('./components/challenges/CreateChallengeGroup.vue').default);

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