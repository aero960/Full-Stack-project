<template>
    <div ref="imageContainer">
        <Loader v-if="loading"></Loader>
    </div>
</template>

<script>
    import DomHelper from "../../class/domHelper.js";
    import Loader from "./loader.vue";
    import Vue from 'vue'

    export default {
        name: "ImageLoader",
        data() {
            return {
                loading: true
            }
        },
        props: {
            img: {
                type: String,
                required: true
            },
        },
        components: {
            Loader
        },
       async mounted() {
            try{
                await DomHelper.addDynamicImg(this.$refs.imageContainer,this.img)
            }catch(e){
                console.error("Unable to load img")

            }
           this.loading = false;
        }

    }
</script>

<style scoped>

</style>