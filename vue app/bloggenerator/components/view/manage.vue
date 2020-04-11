<template>
    <div>
        <navbar/>
        <router-view></router-view>
    </div>
</template>

<script>
    import navbar from "./nav/navbar.vue";
    export default {
        name: "ManageView",
        components:{
            navbar
        }
    }
</script>

<style scoped>

</style>