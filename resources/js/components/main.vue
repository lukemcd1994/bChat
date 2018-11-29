<!-- contains all content bescides the header -->

<template>
    <div class="card-body">
        <messages-component></messages-component>
        <compose-component></compose-component>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
