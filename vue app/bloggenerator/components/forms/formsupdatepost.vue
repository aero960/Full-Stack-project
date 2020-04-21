<template>
    <httploadercomposite :loading="loading">
        <FormBase @submit="submit" :valid="!$v.$invalid" :btnText="'Aktualizuj post'">

            <ItemUpdater placeholder="tytul" :item="title" :filterBase="$v.title"></ItemUpdater>
            <ItemUpdater placeholder="tresc" :item="content" :filterBase="$v.content"></ItemUpdater>

            <ItemListEditor  placeholder="tag" :filterBase="$v.tags" :items="avaiableTags" >
                Dodaj bądź usuń tagi
            </ItemListEditor>


            <form-group :message="'Wybierz z którą kategorią połączyć post'">
                <check-box-base v-for="(category,index) in avaiableCategory"
                                :key="index" :filterBase="$v.category"
                                :options="[{value:category.category_title,msg:category.category_title}]"/>

            </form-group>
        </FormBase>
    </httploadercomposite>
</template>

<script>
    import {FormBase, CheckBoxBase, ItemUpdater,ItemListEditor} from './forms.js'
    import {url, alpha, alphaNum, email, required, maxLength, minLength, integer} from 'vuelidate/lib/validators'
    import {CategoryManaging} from "../../class/category/category";
    import {httploadercomposite} from "../httphelper/httploadercomposite";

    export default {
        name: "formAddPost",
        data() {
            return {
                title: '',
                content: '',
                tags: '',
                avaiableCategory: [],
                avaiableTags: [],
                category: [],

                loading: true,
            }
        },
        components: {
            FormBase, CheckBoxBase, ItemUpdater, httploadercomposite,ItemListEditor
        },
        props: {
            postId: {}
        },
        methods: {
            async loadCategory() {
                try {
                    let data = await CategoryManaging.GetCategorys();
                    this.avaiableCategory = data.content;
                } catch (e) {
                    console.log("Problem z kategoriami")
                }
            },
            submit() {
                if (!this.$v.$invalid) {
                    this.$emit('input', {
                        title: this.title,
                        content: this.content,
                        tags: this.tags,
                        category: this.category,
                    });
                    this.$emit('submit');
                }
            },
            async loadPost() {
                let data = await this.$postManage.FetchSpecificPost({id: this.postId})
                if (data.datasuccess) {
                    this.title = data.content.postdata.post_title;
                    this.content = data.content.postdata.post_content;
                    this.avaiableTags = Object.values(data.content.tags).map((index)=>{
                        return index.tag_title
                    });
                    console.log(this.tags,"tagi")
                }
            }
        },
        async created() {
            this.loading = true;
            await this.loadCategory();
            await this.loadPost();
            this.loading = false
        },
        validations: {
            title: {required,maxLength: maxLength(150)},
            content: {required,maxLength: maxLength(15000)},
            tags: {},
            category: {},
            publish: {}
        },

    }
</script>

<style scoped>

</style>