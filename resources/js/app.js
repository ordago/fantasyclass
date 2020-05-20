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
import Vue from 'vue'

import Buefy from 'buefy'
//import { Table, Field, Select, Switch, Button, Icon } from 'buefy'
//import 'buefy/dist/buefy.css'

// Download excel
import JsonExcel from 'vue-json-excel'
Vue.component('downloadExcel', JsonExcel)

Vue.use(Buefy)
// Vue.use(Table)
// Vue.use(Select)
// Vue.use(Switch)
// Vue.use(Field)
// Vue.use(Button)
// Vue.use(Icon)

Vue.component('add-students', require('./components/student/AddStudents.vue').default);
Vue.component('show-students', require('./components/student/ShowStudents.vue').default);
Vue.component('show-card', require('./components/card/ShowCard.vue').default);
Vue.component('show-cards', require('./components/card/ShowCards.vue').default);
Vue.component('create-card', require('./components/card/CreateCard.vue').default);
Vue.component('create-behaviour', require('./components/behaviour/CreateBehaviour.vue').default);
Vue.component('show-behaviours', require('./components/behaviour/ShowBehaviours.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});