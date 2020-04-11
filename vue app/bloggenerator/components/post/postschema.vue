<template>
    <div class="element">
        <h3>Kategoria</h3>
        <h1>Tytul</h1>
        <h4>Teskst</h4>
        <h6>uzytkownik</h6>
        <router-link :to="{name:'ActivePost',params:{postId:'124124'}}">Przejdz do postu</router-link>
        <p>Tagi</p>
        <p>Like</p>
    </div>
</template>

<script>
    export default {
        name: "postschema"
    }
</script>

<style scoped>

</style>