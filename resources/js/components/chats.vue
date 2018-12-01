<template>
    <div class="col-md-9">
        <button v-for="chat in chats.data" type="button" class="btn chat-btn-inactive" @click="$bus.$emit('chat-switched', chat);">{{chat.with}}</button>
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
                    url: window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1] + '/chats',
                    method: 'get'
                }).then(response => {
                    this.chats = response.data;
                });
            }

        }
    }
</script>

