<!-- displays the buttons for the current chats -->

<template>
    <div class="header-buttons col-sm-3 justify-content-right">
    	<button type="button" class="btn chat-btn-active">settings</button>
    	<button type="button" class="btn chat-btn-active" @click="$bus.$emit('button-click-1')">new</button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
