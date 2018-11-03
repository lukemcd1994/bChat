<template>
    <div class="col-md-4" id="chats">
        <div class="card">
            <div class="card-header">Chats</div>
            <div class="card-body">
                <div class="list-group">
                    <button v-for="chat in chats.data" class="list-group-item list-group-item-action">Chat ID {{chat.id}} with {{chat.with}} expires at {{chat.delete_at}}
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
