<template>
    <div>
        <h1>Co chcesz zrobić ze swoimi postami</h1>
        <router-link :to="{name:'CreatePost'}">Stwórz nowy post</router-link>
        <router-link :to="{name:'CRUDPost'}">Zarządzaj postami</router-link>
        <div class="dflex">
            <router-view name="PostOperation"></router-view>
            <router-view name="PostAction"></router-view>
        </div>


    </div>
</template>

<script>

    import postadd from "../../post/postadd.vue";
    export default {
        name: "postmanage",
        components:{
            postadd
        }
    }
</script>

<style scoped>

</style>