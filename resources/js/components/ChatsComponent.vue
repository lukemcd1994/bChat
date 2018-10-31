<template>
    <div class="col-md-4" id="chats">
        <div class="card">
            <div class="card-header">Chats</div>
            <div class="card-body">
                <ul>
									<li v-for="chat in chats">
										{{chat.with}}
										{{chat.delete_at}}
									</li>
								</ul>
            </div>
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
