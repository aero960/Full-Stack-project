<template>
    <div class="dflex">
        <category-unit v-for="(category) in showCategories"
                       :title="category.category_title"
                       :content="category.category_content"
                       :key="category.category_id" v-if="!loading" />
        <loader v-if="loading" />
    </div>
</template>

<script>
    import {CategoryManaging} from "../../class/category/category";
    import categoryUnit from "./categoryunit.vue";
    import loader from "../httphelper/loader.vue";

    export default {
        name: "ShowFullCategory",
        data(){
            return{
                loading: true
            }
        },
        asyncComputed: {
            async showCategories() {
                    let data = await CategoryManaging.GetCategorys();
                setTimeout(async ()=>{
                    this.loading = false;
                },1000)
                    return data.content
            }
        },
        components: {
            loader,
            categoryUnit
        }
    }
</script>

<style scoped>

</style>