<template>
    <div v-if="$store.getters.isLogged">
        <slot name="logged"></slot>
    </div>
    <div v-else>
        <slot name="notLogged"></slot>
    </div>
</template>

<script>
    export default {
        name: "isLoggedComposite",
    }
</script>

<style scoped>

</style>