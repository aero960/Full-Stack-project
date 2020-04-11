<template>
    <div class="dflex">
        <router-link :to="{ name: 'AccountManage'}">Account managing</router-link>
        <router-link :to="{ name: 'PostManage'}">Post managing</router-link>
        <user-logged></user-logged>
    </div>
</template>

<script>
    import UserLogged from "../account/userlogged.vue";
    export default {
        name: "navbar",
        components:{
            UserLogged
        }
    }
</script>

<style scoped>

</style>