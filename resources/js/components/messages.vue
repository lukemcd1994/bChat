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
                this.setCurrentChat(chat.id);
            });
            this.$bus.$on('send-message-bounce', data => {
                this.$bus.$emit('send-message', {with: this.currentChatUsername, chat_id: this.currentChatID});
            });
            this.$bus.$on('message-sent', data => {
                let temp = {message_body: data};
                this.messages.data.push(temp);
            });

            window.Echo.private('App.User.' + document.head.querySelector('meta[name="username"]').content).listen('NewMessage', (e) => {
                if (this.currentChatID === e.chat_id) {

                    if (document.head.querySelector('meta[name="username"]').content + "." + e.chat_id.toString() in localStorage) {

                        const decipher = Decipher.createDecipher('aes-256-ctr', localStorage.getItem(document.head.querySelector('meta[name="username"]').content + "." + e.chat_id.toString()));

                        let decrypted = decipher.update(e.message_body, 'hex', 'utf8');
                        decrypted += decipher.final('utf8');

                        e.message_body = decrypted;
                    }
                    else {

                        e.message_body = '{"receiver":"NULL","timestamp":"NULL","body":"No encryption key found"}';
                    }

                    console.log(e);

                    this.messages.data.push(e);
                } else {
                    // todo for john
                    // <span class="badge badge-light">4</span>
                    // document.getElementById(chatID).className = "btn chat-btn-active";
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
            setCurrentChat(chatID){

                let items = document.getElementsByClassName('btn chat-btn-active');
                for(let i=0; i<items.length; i++) {
                    items[i].className = "btn chat-btn-inactive";
                    console.log('set inactive');
                }
 
                document.getElementById(chatID).className = "btn chat-btn-active";

            },
            getChatMessages(chatID){
                axios({
                    url: 'http://127.0.0.1:8000/messages',
                    method: 'post',
                    data: {
                    chat_id: chatID
                    },
                }).then(response => {

                    let server_messages = response.data.data;

                    if (document.head.querySelector('meta[name="username"]').content + "." + chatID.toString() in localStorage) {

                        server_messages.forEach(function(item, i) {

                            const decipher = Decipher.createDecipher('aes-256-ctr', localStorage.getItem(document.head.querySelector('meta[name="username"]').content + "." + chatID.toString()));

                            server_messages[i] = {message_body: decipher.update(item.message_body, 'hex', 'utf8') + decipher.final('utf8')}
                        });
                    }
                    else {

                        server_messages.forEach(function(item, i) {
                            server_messages[i] = {message_body: '{"receiver":"NULL","timestamp":"NULL","body":"No encryption key found"}'};
                        });
                    }

                    this.messages = {data: server_messages};
                });
            }
        }
    }
</script>