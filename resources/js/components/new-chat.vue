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
			console.log('Component mounted.')
		},
        data: function () {
            return {
                username: "",
                endDate: ""
            }
        },
		methods: {

			requestNewChat(){
				console.log(this.username);
				console.log(this.endDate);

				axios({
					url: 'http://127.0.0.1:8000/chats',
					method: 'post',
					data: {
						user2_name: this.username,
						delete_at: this.endDate
					},
				});
				this.$bus.$emit('start-chat-button');
			}
		}
	}
</script>
