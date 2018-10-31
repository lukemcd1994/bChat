<template>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Chats</div>
            <chat-messages-component></chat-messages-component>
						<chat-form-component></chat-form-component>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
