<template>
	<div class="row new-chat" style="margin-left:0px;width: 100% !important;">
		<div class="col-md-2">
			<input v-model="username" class="username" id="username-text" type="text" placeholder="username">
			<!-- <input v-model="endDate" class="enddate" type="datetime-local" placeholder="end date" name="endDate" id="endDate"> -->
		</div>
		<div class="col-md-6">
			<!-- <input v-model="username" class="username" type="text" placeholder="username"> -->
			<input v-model="endDate" class="enddate" type="datetime-local" placeholder="end date" name="endDate" id="endDate">
		</div>
		<div class="col-md-4 justify-content-right">
			<button type="button" class="btn chat-btn-important" id="submit-new-chat" @click="requestNewChat()">Request</button>
			<button type="button" class="btn chat-btn-inactive" style="margin-right:10px;" @click="cancelNewChat()">Cancel</button>
		</div>
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
			cancelNewChat(){
				this.$bus.$emit('start-chat-button');
			},
			requestNewChat(){
				console.log(this.username);
				console.log(this.endDate);

				// format properly to get times working
				this.endDate = (new Date(this.endDate)).toUTCString()

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
