<template>
    <FormBase @submit="submit" :valid="!$v.$invalid" :btnText="'Dodaj posta'">
        <InputBase :type="'text'" :filterBase="$v.title" :errors="[
         {name:'required',msg:'This filed is required'},
         {name:'maxLength',msg:`Minimum length is ${$v.title.$params.maxLength.max}`}]">
            Tytuł postu
        </InputBase>
        <text-area-base :filterBase="$v.content" :errors="[
         {name:'required',msg:'This filed is required'},
         {name:'maxLength',msg:`Minimum length is ${$v.title.$params.maxLength.max}`}]">
            Treść postu
        </text-area-base>
        <item-list-editor :placeholder="'tag'" :filterBase="$v.tags">
            Dodaj Tagi
        </item-list-editor>

        <form-group :message="'Wybierz kategorie dla swojego postu'">
            <check-box-base v-for="(category,index) in avaiableCategory"
                            :key="index" :filterBase="$v.category"
                            :options="[{value:category.category_title,msg:category.category_title}]"/>

        </form-group>

        <check-box-base :filterBase="$v.publish" :options="[{value:'publish',msg:'opublikować post'}]"/>
    </FormBase>
</template>

<script>
    import {InputBase, FormBase, TextAreaBase, ItemListEditor, CheckBoxBase, FormGroup} from './forms.js'
    import {url, alpha, alphaNum, email, required, maxLength, minLength, integer} from 'vuelidate/lib/validators'
    import {CategoryManaging} from "../../class/category/category";


    export default {
        name: "formAddPost",
        data() {
            return {
                title: '',
                content: '',
                tags: '',
                publish: false,
                avaiableCategory: [],
                category: []
            }
        },
        components: {
            TextAreaBase, FormBase, InputBase, ItemListEditor, CheckBoxBase, FormGroup
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
                        publish: this.publish
                    });
                    this.$emit('submit');
                }
            }
        },
        created() {
            this.loadCategory();
        },
        validations: {
            title: {required, maxLength: maxLength(150)},
            content: {required, maxLength: maxLength(15000)},
            tags: {},
            category: {},
            publish: {}
        },

    }
</script>

<style scoped>

</style>