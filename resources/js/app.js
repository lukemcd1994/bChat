
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');


import VModal from 'vue-js-modal'
Vue.use(VModal);

const EventBus = new Vue();

Object.defineProperties(Vue.prototype, {
    $bus: {
        get: function () {
            return EventBus
        }
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// better vues implementation
Vue.component('main-component', require('./components/main.vue'));
// Vue.component('header-component', require('./components/header.vue'));
Vue.component('messages-component', require('./components/messages.vue'));
Vue.component('compose-component', require('./components/compose.vue'));
Vue.component('chats-component', require('./components/chats.vue'));
Vue.component('new-chat-component', require('./components/new-chat.vue'));
Vue.component('header-buttons-component', require('./components/header-buttons.vue'));

// modal components
Vue.component('accept-chat-modal', require('./components/AcceptChatModal.vue'));

const app = new Vue({
    el: '#root', // for some reason this was app and not root
    mounted: function () {

    },
    data: {
        chatListVisible: true,
        newChatVisible: false,
        chatRequestVisible: false
    }
});