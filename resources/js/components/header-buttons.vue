<!-- displays the buttons for the current chats -->

<template>
    <div class="header-buttons col-sm-3 justify-content-right">
    	<button type="button" class="btn chat-btn-important" @click="$bus.$emit('new-chat-button')">New Chat</button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
