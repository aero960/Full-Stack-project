<template>
    <main>
        <div v-if="!logged">
            <div>You are not logged to account</div>
            <router-link :to="{name:'LoginUser'}">Sign In</router-link>
            <router-link :to="{name:'RegisterUser'}">Register</router-link>
        </div>
        <div v-if="logged">
            <h1>Welcome on your page {{currentyUser}}</h1>
            <admin-preview></admin-preview>
            <router-link :to="{name:'UpdateUser'}">Update your account</router-link>
            <button @click="$store.dispatch('logOut')">Logout</button>
        </div>
        <router-view></router-view>
    </main>
</template>

<script>
    import AdminPreview from "./adminPreview.vue";

    export default {
        name: "Account",
        data() {
            return {}
        },
        computed: {
            logged() {
                return this.$store.getters.isLogged;
            },
            currentyUser() {
                return this.$store.state.auth.userData.username;
            }
        },
        components:{
            AdminPreview
        }
    }


</script>

<style scoped>

</style>