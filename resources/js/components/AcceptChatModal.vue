<template>
    <modal name="accept-chat-modal"
           :width="500"
           :height="200"
           @before-close="beforeClose">

        <div>
            <h2>Incoming Chat Request</h2>
            <br>
            <p>{{withUser}} is requesting to chat with you. The chat will expire at {{deleteAt}}. Accept?</p>
            <br>
            <button type="button" class="btn btn-success" @click="accept">Accept</button>
            <button type="button" class="btn btn-danger" @click="decline">Decline</button>
        </div>
    </modal>
</template>

<script>
    export default {
        name: 'AcceptChatModal',
        data () {
            return {
                canClose: false,
                pendingID: -1,
                pendingSecret: '',
                withUser: '',
                deleteAt: '',
                withECDHPub: ''
            }
        },
        mounted () {

            console.log("AcceptChatModal mounted");

            window.Echo.private('App.User.' + document.head.querySelector('meta[name="username"]').content).listen('NewChatRequestedEvent',
                (e) => {

                    console.log(e);

                    this.pendingID = e.pending_id;
                    this.withUser = e.with;
                    this.pendingSecret = e.pending_secret;
                    this.deleteAt = e.delete_at;
                    this.withECDHPub = e.ecdh_pub;

                    this.showModal();
                });
        },
        methods: {
            beforeClose (event) {

                if (!this.canClose) {

                    event.stop();
                }

            },
            showModal() {

                this.$modal.show('accept-chat-modal');
            },
            accept() {

                const pub = createECDH('secp521r1');

                axios({
                    url: 'http://127.0.0.1:8000/chats',
                    method: 'post',
                    data: {
                        user2_name: this.withUser,
                        delete_at: this.deleteAt,
                        pending_id: this.pendingID,
                        pending_secret: this.pendingSecret,
                        pending_method: "accept",
                        ecdh_pub: pub.generateKeys('hex')
                    }
                }).then(response => {

                    const aes_key = hkdf(pub.computeSecret(this.withECDHPub, 'hex'), 32).toString('hex');

                    localStorage.setItem(document.head.querySelector('meta[name="username"]').content + "." + this.pendingID.toString(), aes_key);

                    this.canClose = true;
                    // emit message to show 
                    this.$bus.$emit('user-accepted-chat', {"delete_at": this.deleteAt, "id": this.pendingID, "with": this.withUser});
                    this.$modal.hide('accept-chat-modal');

                    this.canClose = false;
                });
            },
            decline() {

                axios({
                    url: 'http://127.0.0.1:8000/chats',
                    method: 'post',
                    data: {
                        user2_name: this.withUser,
                        delete_at: this.deleteAt,
                        pending_id: this.pendingID,
                        pending_secret: this.pendingSecret,
                        pending_method: "decline"
                    }
                }).then(response => {

                    this.canClose = true;
                    this.$modal.hide('accept-chat-modal');
                    this.canClose = false;
                });
            }
        }
    }
</script>

<style scoped>

    h2 {

        text-align: center;
    }

</style>