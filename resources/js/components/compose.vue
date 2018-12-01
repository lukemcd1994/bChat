<!-- displays the composed text view and send button -->

<template>
	<div class="compose row">
		<input v-model="messagebody" type="text" placeholder="Send your message...">
		<button @click="$bus.$emit('send-message-bounce')">Send</button>
	</div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');

            this.$bus.$on('send-message', data => {
            	let encoded = this.encodeChatMessage(data.with,Date.now(),this.messagebody);
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
        		return JSON.stringify({receiver: username, timestamp: time, body: message});
        	},
            sendChatMessage(username,chatID,message){ 
                axios({
                  	url: window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1] + '/send',
	              	method: 'post',
              		data: {
                		receiver: username,
                		message_body: message,
                		chat_id: chatID
              		},
	            });
            }
        }
    }
</script>
