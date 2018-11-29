<!-- shows a list of messages -->

<template>
    <div class="messages">
        <ul>
        	<li v-for="message in messages.data" class="sent">
        		<p>{{message.message_body}}</p>
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
                    this.messages.data.push(e);
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
                    url: 'http://127.0.0.1:8000/messages',
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