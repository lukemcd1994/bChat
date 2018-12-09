<template>
	<div class="col-md-9 new-chat">
		<input v-model="username" type="text" placeholder="username">
		<input v-model="endDate" type="date" placeholder="end date" name="endDate" id="endDate">
		<button type="button" class="btn chat-btn-active" @click="requestNewChat()">Request</button>
	</div>
</template>

<script>
	export default {
		mounted() {
			console.log('Component mounted.');

			window.Echo.private('App.User.' + document.head.querySelector('meta[name="username"]').content).listen('ChatAcceptedEvent',
				(e) => {
					const aes_key = hkdf(this.pendingChats[e.id].computeSecret(e.ecdh_pub, 'hex'), 32).toString('hex');

					localStorage.setItem(document.head.querySelector('meta[name="username"]').content + "." + e.id.toString(), aes_key);

					Vue.delete(this.pendingChats, e.id);
				});
		},
        data: function () {
            return {
                username: "",
                endDate: "",
				pendingChats: {}
            }
        },
		methods: {

			requestNewChat(){
				console.log(this.username);
				console.log(this.endDate);

				const pub = createECDH('secp521r1');

				axios({
					url: 'http://127.0.0.1:8000/chats',
					method: 'post',
					data: {
						user2_name: this.username,
						delete_at: this.endDate,
						ecdh_pub: pub.generateKeys('hex')
					},
				}).then(response => {
					this.pendingChats = { ...this.pendingChats, [response.data.pending_id]: pub}
				});

				this.username = "";
				this.endDate = "";

				this.$bus.$emit('start-chat-button');
			}
		}
	}
</script>
