<template>
        <loader-composite :loading="loading" class="dflex">
            <div>Kategorie</div>
            <category-unit v-for="(category) in categories"
                           :title="category.category_title"
                           :content="category.category_content"
                           :key="category.category_id" />
        </loader-composite>
</template>

<script>
    import {CategoryManaging} from "../../class/category/category";
    import categoryUnit from "./categoryunit.vue";
    import loader from "../httphelper/httploader.vue";
    import {httploadercomposite} from "../httphelper/httploadercomposite";

    export default {
        name: "ShowFullCategory",
        data(){
            return{
                loading: true,
                categories: []
            }
        },
        created() {
            this.showCategories();
        },
        methods: {
            async showCategories() {
                try{
                    let data = await CategoryManaging.GetCategorys();
                    this.loading = false;
                    this.categories = data.content;
                }catch(e){
                    console.log("Problem z kategoriami")
                }


            }
        },
        components: {

            categoryUnit,
            loaderComposite: httploadercomposite
        }
    }
</script>

<style scoped>

</style>