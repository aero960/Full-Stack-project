<template>
    <div>
        Tutaj będą wykonywane operacje na twoich postach
        <component :is="'update'" ></component>
    </div>
</template>

<script>
    import postdeepupdate from "./postdeep/postdeepupdate.vue";
    import postactivet from "../view/post/postactivet.vue";
    export default {
        name: "postoperations",
        components: {
            update: postdeepupdate,
            show:postactivet
        },
        created() {

        }
    }
</script>

<style scoped>

</style>