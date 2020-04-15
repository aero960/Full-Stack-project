<template>

    <isloggedcomposite :message="'zaloguj się'">
        <template v-slot:logged>
            <div v-if="$store.getters.isLogged"  class="dflex">
                <div>
                    <button @click="$store.dispatch('logOut')">Logout</button>
                    <p>Welcome on your page {{currentyUser}}</p>
                </div>
                <admin-preview></admin-preview>
            </div>
        </template>
        <template v-slot:notLogged>
            <div >
                you arent logged in
                <button @click="$router.push({name:'LoginUser',query:{from:$router.history.current.name}})">Log in now </button>
            </div>
        </template>
    </isloggedcomposite>

</template>

<script>
    import adminPreview from "./accountadminpreview.vue";
   import isloggedcomposite from "../../account/accountlogged.vue";
    export default {
        name: "userLogged",
        components: {
            adminPreview,isloggedcomposite
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