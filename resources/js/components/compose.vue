<!-- displays the composed text view and send button -->

<template>
	<div class="compose row">
		<input id="send-message-box" v-on:keyup.enter="$bus.$emit('send-message-bounce')" v-model="messagebody" type="text" placeholder="Send your message...">
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
                  	url: 'http://127.0.0.1:8000/send',
	              	method: 'post',
              		data: {
                		receiver: username,
                		message_body: message,
                		chat_id: chatID
              		},
	            });
                this.messagebody = '';
                $("#send-message-box").focus();
            }
        }
    }
</script>
