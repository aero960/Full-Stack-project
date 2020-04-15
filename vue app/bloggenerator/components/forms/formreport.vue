<template>
    <FormBase @submit="submit" :valid="!$v.$invalid" :btnText="'zgłoś komentarz'">
        <TextAreaBase :filterBase="$v.message" :errors="[{name:'required',msg:'This filed is required'}]">
            Powód zgłoszenia
        </TextAreaBase>
    </FormBase>
</template>

<script>
    import {InputBase, FormBase, TextAreaBase} from './forms.js'
    import {url, alpha, alphaNum, email, required, maxLength,minLength,integer} from 'vuelidate/lib/validators'


    export default {
        name: "reportForm",
        data() {
            return {
                message: '',
            }
        },
        components: {
            TextAreaBase, FormBase
        },
        methods: {
            submit() {
                if (!this.$v.$invalid) {
                    this.$emit('input', {message: this.message});
                    this.$emit('submit');
                }
            }
        },
        validations:{
                message: {required}
        },

    }
</script>

<style scoped>

</style>