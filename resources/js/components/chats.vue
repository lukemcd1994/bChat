<template>
    <div class="col-md-9 chatslist">
        <button v-for="chat in chats.data" type="button" class="btn chat-btn-inactive" v-bind:id="chat.id" @click="$bus.$emit('chat-switched', chat);">{{chat.with}} <span class="unread-indicator badge badge-light" style="display: none;">0</span></button>
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

            this.$bus.$on('user-accepted-chat', chatData => {
                this.chats.data.push(chatData);
            });

            window.Echo.private('App.User.' + document.head.querySelector('meta[name="username"]').content).listen('ChatAcceptedEvent',
                (e) => {
                    console.log(e);
                    this.chats.data.push(e);
            });

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

