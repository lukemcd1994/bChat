
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
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

Vue.component('current-chat-component', require('./components/CurrentChatComponent.vue'));
Vue.component('chats-component', require('./components/ChatsComponent.vue'));
Vue.component('chat-messages-component', require('./components/ChatMessagesComponent.vue'));
Vue.component('chat-form-component', require('./components/ChatFormComponent.vue'));
Vue.component('message-component', require('./components/MessageComponent.vue'));
Vue.component('new-chat-component', require('./components/NewChatComponent.vue'));
Vue.component('chat-created-component', require('./components/ChatCreatedComponent.vue'));

const app = new Vue({
    el: '#root',
    mounted: function () {

				window.Echo.private('App.User.' + document.head.querySelector('meta[name="username"]').content)
						.listen('NewChatRequest', (e) => {
						console.log(e);
				});

				this.$bus.$on('button-click-1', eventData => {
						this.currentChatVisible = false;
						this.newChatVisible = true;
				});

				this.$bus.$on('button-click-2', eventData => {
						this.newChatVisible = false;
						this.chatCreatedVisible = true;
				});

				this.$bus.$on('button-click-3', eventData => {
						this.chatCreatedVisible = false;
						this.currentChatVisible = true;
				});

    },
		data: {

			chatsVisible: true,
			currentChatVisible: true,
			newChatVisible: false,
			chatCreatedVisible: false

		},
		methods: {

		}
});
