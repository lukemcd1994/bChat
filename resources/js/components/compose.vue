<!-- displays the composed text view and send button -->

<template>
	<div class="compose row">
		<input id="send-message-box" v-on:keyup.enter="$bus.$emit('send-message-bounce')" v-model="messagebody" type="text" placeholder="Send your message...">
		<button class="btn chat-btn-important" @click="$bus.$emit('send-message-bounce')">Send</button>
	</div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');

            this.$bus.$on('send-message', data => {
                this.messagebody = this.removeEmoji(this.messagebody);
				if (document.head.querySelector('meta[name="username"]').content + "." + data.chat_id.toString() in localStorage) {

					let [encoded, plain] = this.encodeChatMessage(data.with, Date.now(), this.messagebody, data.chat_id);
					this.sendChatMessage(data.with,data.chat_id,encoded);
					this.$bus.$emit('message-sent',plain);
				}
				else {

					this.messagebody = '';
					$("#send-message-box").focus();
					alert("ERROR: Can't send message! No encryption key available for this chat!");
				}
            });
        },
        data: function () {
            return {
                messagebody: ""
            }
        },
        methods: {
            removeEmoji(message){
                return message.replace(/([\uE000-\uF8FF]|\uD83C[\uDF00-\uDFFF]|\uD83D[\uDC00-\uDDFF])/g, '');
            },
        	encodeChatMessage(username, time, message, chatID) {

				const cipher = Cipher.createCipher('aes-256-ctr', localStorage.getItem(document.head.querySelector('meta[name="username"]').content + "." + chatID.toString()));

				let encrypted = cipher.update(JSON.stringify({receiver: username, timestamp: time, body: message}), 'utf8', 'hex');
				encrypted += cipher.final('hex');

				let plain = JSON.stringify({receiver: username, timestamp: time, body: message});

        		return [encrypted, plain];
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
                // keep cursor in the text box
                $("#send-message-box").focus();
            }
        }
    }
</script>
