<template>
    <div>
        <router-link :to="{name:`Posts`,query:{category: title}}"> {{title}}</router-link>
    </div>
</template>

<script>
    export default {
        name: "categoryunit",
        props:{
            content:{},
            title: {}
        },
        mounted() {
        }
    }
</script>

<style scoped>

</style>