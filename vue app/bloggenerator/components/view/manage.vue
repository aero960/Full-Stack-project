<template>
    <div>
        <!--do zmiany -->
        <router-link :to="{ name: 'AccountManage'}">Account managing</router-link>
        <router-view name="AccountManage"></router-view>
    </div>
</template>

<script>
    export default {
        name: "ManageView",
    }
</script>

<style scoped>

</style>