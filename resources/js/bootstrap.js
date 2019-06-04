import Vue from 'vue';
import Router from 'vue-router';
import axios from 'axios';
import VeeValidate from 'vee-validate';
import AsyncComputed from 'vue-async-computed';
import SlimDialog from 'v-slim-dialog';
import VueMoment from 'vue-moment';
import wysiwyg from "vue-wysiwyg";
import 'v-slim-dialog/dist/v-slim-dialog.css';
import "vue-wysiwyg/dist/vueWysiwyg.css";
import { abilitiesPlugin, Can } from '@casl/vue';
import { ability } from "./common/oauth/ability.js";
import Snotify, { SnotifyPosition } from 'vue-snotify';

Vue.use(Router);
Vue.use(VeeValidate, { events: 'input|blur' });
Vue.use(AsyncComputed, {
    global: 'Loading...'
});
Vue.use(SlimDialog);
Vue.use(VueMoment);
Vue.use(wysiwyg);
Vue.use(abilitiesPlugin, ability);
Vue.component('Can', Can);
Vue.use(Snotify, {
    toast: {
        position: SnotifyPosition.centerTop,
        titleMaxLength: 50,
        backdrop: 0.3,
    }
});

window.Vue = Vue;
window.axios = axios;
window._ = require('lodash');
window.Popper = require('popper.js').default;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
