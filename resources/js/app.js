
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VModal from 'vue-js-modal'

Vue.use(VModal);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('current-chat-component', require('./components/CurrentChatComponent.vue'));
Vue.component('chats-component', require('./components/ChatsComponent.vue'));
Vue.component('chat-messages-component', require('./components/ChatMessagesComponent.vue'));
Vue.component('chat-form-component', require('./components/ChatFormComponent.vue'));
Vue.component('message-component', require('./components/MessageComponent.vue'));
Vue.component('accept-chat-modal', require('./components/AcceptChatModal.vue'));

const EventBus = new Vue();

Object.defineProperties(Vue.prototype, {
    $bus: {
        get: function () {
            return EventBus
        }
    }
});

const app = new Vue({
    el: '#app',
    mounted: function () {
    },
});
