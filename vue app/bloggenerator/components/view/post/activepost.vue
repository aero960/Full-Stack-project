<template>
    <div>

        Teraz przegladasz fajny post
        {{ $route.params.postId }}

    </div>

</template>
<script>
    export default {
        name: "activepost"
    }
</script>

<style scoped>

</style>