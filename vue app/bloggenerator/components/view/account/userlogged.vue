<template>
    <div v-if="$store.getters.isLogged"  class="dflex">
        <div>
            <button @click="$store.dispatch('logOut')">Logout</button>
             <p>Welcome on your page {{currentyUser}}</p>
        </div>
        <admin-preview></admin-preview>
    </div>
    <div v-else >
        you arent logged in
        <button @click="$router.push({name:'LoginUser'})">Log in now </button>
    </div>
</template>

<script>
    import adminPreview from "./adminPreview.vue";

    export default {
        name: "userLogged",
        components: {
            adminPreview
        },
        computed: {
            currentyUser() {
                return this.$store.state.auth.userData.username;
            }
        }
    }
</script>

<style scoped>

</style>