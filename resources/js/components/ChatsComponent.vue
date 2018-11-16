<template>
    <div class="col-md-4" id="chats">
        <div class="card">
            <div class="card-header">Chats</div>
            <div class="card-body">
								<div class="row justify-content-center">
									<div class='col-xs-12'>
										<button class="btn btn-primary" @click="$bus.$emit('button-click-1')">New Chat</button>
									</div>
								</div>
								<br>
                <div class="list-group">
                    <button v-for="chat in chats.data" class="list-group-item list-group-item-action" @click="">
											Chat {{chat.id}} with {{chat.with}}<br>expires at {{chat.delete_at}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                chats: []
            }
        },
        mounted () {
            this.getChats();
        },
        methods: {
            getChats() {
                axios({
                    url: 'http://127.0.0.1:8000/chats',
                    method: 'get'
                }).then(response => {
                    this.chats = response.data;
                });
            }

        }
    }
</script>
