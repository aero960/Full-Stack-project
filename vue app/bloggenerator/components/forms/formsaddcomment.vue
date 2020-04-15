<template>
    <FormBase @submit="submit" :valid="!$v.$invalid" :btnText="'dodaj komentarz'">
        <InputBase v-if="!$store.getters.isLogged" :type="'text'" :filterBase="$v.username"
                   :errors="[{name:'required',msg:'This filed is required'}]">
            Pseudonim
        </InputBase>
        <InputBase  :placeholder="'comment title'"  :type="'text'" :filterBase="$v.title" :errors="[
              {name:'required',msg:'This filed is required'},
               {name:'maxLength',msg:`Minimum length is ${$v.title.$params.maxLength.max}`}]">
            Comment title
        </InputBase>
        <TextAreaBase :placeholder="'comment body'" :filterBase="$v.content" :errors="[
            {name:'required',msg:'This filed is required'},
              {name:'maxLength',msg:`Minimum length is ${$v.content.$params.maxLength.max}`}]">
            Comment body
        </TextAreaBase>
    </FormBase>
</template>

<script>
    import {FormBase, InputBase, TextAreaBase} from "./forms";
    import {url, alpha, alphaNum, email, required, maxLength, minLength, integer} from 'vuelidate/lib/validators'
    import webstore from "../store/webstore";


    export default {
        name: "addcomment",
        data() {
            return {
                username: '',
                title: '',
                content: ''
            }
        },
        methods: {
            submit() {
//do zmiany
                this.username = (this.$store.getters.isLogged) ? this.$store.state.auth.userData.username : this.username;

                if (!this.$v.$invalid) {
                    this.$emit('input',
                        {
                            username: this.username ?? '',
                            title: this.title ?? '',
                            content: this.content ?? '',
                        });
                    this.$emit('submit');
                }
            }
        },
        computed: {
            requireUsername() {
                console.log(webstore.getters.isLogged)
                return this.$store.getters.isLogged;
            },
            state() {
                return this.$store.state
            }

        },
        components: {
            FormBase, InputBase, TextAreaBase
        },
        validations: {

            username: {required: (webstore.getters.isLogged) ? required : true},
            title: {required, maxLength: maxLength(100)},
            content: {required, maxLength: maxLength(400)}
        }
    }
</script>

<style scoped>

</style>