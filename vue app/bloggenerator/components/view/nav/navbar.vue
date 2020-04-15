<template>
    <div >
        <div class="dflex">
            <router-link :to="{ name: 'AccountManage'}">Account</router-link>
            <router-link :to="{ name: 'Posts'}">Posts</router-link>
            <isloggedcomposite>
                <template v-slot:logged>
                    <router-link :to="{name: 'PostManage'}">Manage your posts</router-link>
                </template>
            </isloggedcomposite>
            <router-link :to="{name: 'Users'}">Users</router-link>
            <user-logged />
        </div>
        <show-full-category/>
    </div>
</template>

<script>
    import UserLogged from "../account/accountlogged.vue";
    import showFullCategory from "../../category/categoryfullshow.vue";
    import isloggedcomposite from "../../account/accountlogged.vue";
    export default {
        name: "navbar",
        components:{
            UserLogged,showFullCategory,isloggedcomposite
        },

    }
</script>

<style scoped>

</style>