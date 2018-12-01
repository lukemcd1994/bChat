<!-- shows a list of messages -->

<template>
    <div class="messages">
        <ul>
        	<li v-for="message in messages.data" v-bind:class="{'sent': JSON.parse(message.message_body).receiver === currentChatUsername, 'received': JSON.parse(message.message_body).receiver !== currentChatUsername}">
        		<p>{{JSON.parse(message.message_body).body}}</p>
        	</li>
        </ul>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');

            this.$bus.$on('chat-switched', chat => {
                console.log(chat.id);
                this.getChatMessages(chat.id);
                this.currentChatID = chat.id;
                this.currentChatUsername = chat.with;
            });
            this.$bus.$on('send-message-bounce', data => {
                this.$bus.$emit('send-message', {with: this.currentChatUsername, chat_id: this.currentChatID});
            });
            this.$bus.$on('message-sent', data => {
                let temp = {message_body: data};
                this.messages.data.push(temp);
            });

            window.Echo.private('App.User.' + document.head.querySelector('meta[name="username"]').content).listen('NewMessage', (e) => {
                    console.log(e);

                    if (this.currentChatID === e.chat_id) {

                        this.messages.data.push(e);
                    }
                    else {

                        //Probably need to add a notification bubble to the other chat to indicate an unread message
                    }
            });
        },
        data:function(){
            return {
                messages: [],
                currentChatID: null,
                currentChatUsername: null
            }
        },
        methods: {
            getChatMessages(chatID){
                axios({
                    url: window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1] + '/messages',
                    method: 'post',
                    data: {
                    chat_id: chatID
                    },
                }).then(response => {
                    this.messages = response.data;
                    console.log(this.messages);
                });
            }
        }
    }
</script>
