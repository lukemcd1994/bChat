
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

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
    el: '#app',
    mounted: function () {

        window.Echo.private('App.User.' + document.head.querySelector('meta[name="username"]').content)
            .listen('NewChatRequest', (e) => {
                console.log(e);
            });
    },
		data: {

			//isVisible: true,
			compArray: ['chats-component', 'current-chats-component']

		}
});

// new Vue({
//   el: 'body',
//   data: {
//     currentComponent: null,
//     componentsArray: ['foo', 'bar']
//   },
//   components: {
//     'foo': {
//       template: '<h1>Foo component</h1>'
//     },
//     'bar': {
//       template: '<h1>Bar component</h1>'
//     }
//   },
//   methods: {
//     swapComponent: function(component)
//     {
//       this.currentComponent = component;
//     }
//   }
// });
