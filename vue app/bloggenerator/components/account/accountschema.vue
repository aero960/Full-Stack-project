<template>
    <div>
        <div>
            <h1>Twoje dane</h1>
            <div>Imie: {{firstName}}</div>
            <div>Nazwisko: {{lastName}}</div>
            <div>Telefon: {{mobile}}</div>
            <h2>Krótki opis: </h2>
            <div>{{intro}}</div>
            <image-loader :img="image"></image-loader>
        </div>
        <div>
            <h1>Twój opis</h1>
            {{profile}}
        </div>

    </div>
</template>
<script>
    import ImageLoader from "../httphelper/imageloader.vue";
    export default {
        name: "AccountSchema",
        props: {
            firstName: {default: "Unknow",type:String},
            image: {default: "https://s3.amazonaws.com/production.mediajoint.prx.org/public/piece_images/571466/The_Unknown_small.jpg"},
            intro: {default: "unknow",type:String},
            lastName: {default: "Unknow",type:String},
            mobile: {default: "Unknow",type:String},
            profile: {default: "Unknow",type:String},
            resources_id: {default: "Unknow",type:String}
        },
        components:{
            ImageLoader
        }

    }
</script>

<style scoped>

</style>