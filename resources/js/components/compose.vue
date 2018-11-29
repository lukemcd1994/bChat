<!-- displays the composd text view and send button -->

<template>
	<div class="compose row">
		<input v-model="messagebody" type="text" placeholder="Send your message...">
		<button @click="$bus.$emit('send-message-bounce');">Send</button>
	</div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            console.log(this.encodeChatMessage("user2","timeshit","CONTENT"));

            this.$bus.$on('send-message', data => {
            	var encoded = this.encodeChatMessage(data.with,Date.now(),this.messagebody);
            	this.sendChatMessage(data.with,data.chat_id,encoded);
            	this.$bus.$emit('message-sent',encoded);
            });
        },
        data: function () {
            return {
                messagebody: ""
            }
        },
        methods: {
        	encodeChatMessage(username,time,message){
        		return JSON.stringify({reciever: username, timestamp: time, body: message});
        	},
            sendChatMessage(username,chatID,message){ 
                axios({
                  	url: 'http://127.0.0.1:8000/send',
	              	method: 'post',
              		data: {
                		receiver: username,
                		message_body: message,
                		chat_id: chatID
              		},
	            }).then(response => {
	                    this.messages = response.data;
	                    console.log(this.messages);
	            });
	                // this.messages
            }
        }
    }
</script>
