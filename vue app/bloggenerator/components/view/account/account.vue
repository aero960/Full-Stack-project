<template>
    <main>
        <div v-if="!logged">
            <div>You are not logged to account</div>
            <router-link :to="{name:'LoginUser'}">Sign In</router-link>
            <router-link :to="{name:'RegisterUser'}">Register</router-link>
        </div>
        <div v-if="logged">
            <router-link :to="{name:'UpdateUser'}">Update your account</router-link>
            <router-link :to="{name:'ShowAccount'}">View your account</router-link>
        </div>
        <router-view></router-view>
    </main>
</template>

<script>
    import AdminPreview from "./adminPreview.vue";
    import userLogged from "./userlogged.vue";
    export default {
        name: "Account",
        data() {
            return {}
        },
        computed: {
            logged() {
                return this.$store.getters.isLogged;
            }
        },
        components:{
            userLogged,
            AdminPreview
        }
    }


</script>

<style scoped>

</style>