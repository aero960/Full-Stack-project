<template>
    <FormBase @submit="submit" :valid="!$v.$invalid" :btnText="'login'">
        <InputBase :type="'text'" :filterBase="$v.username" :errors="[
              {name:'required',msg:'This filed is required'},
               {name:'minLength',msg:`Minimum length is ${$v.password.$params.minLength.min}`}]">
            Username or Email
        </InputBase>
        <InputBase :type="'password'" :filterBase="$v.password" :errors="[
            {name:'required',msg:'This filed is required'},
            {name:'minLength',msg:`Minimum length is ${$v.password.$params.minLength.min}`}
            ]">
            Password
        </InputBase>
    </FormBase>
</template>
<script>
    import {InputBase, FormBase} from './forms.js'
    import {url, alphaNum, email, required, minLength} from 'vuelidate/lib/validators'

    export default {
        name: "UserLoginForm",
        directives: {},
        data() {
            return {
                username: '',
                password: ''
            }
        },
        methods: {
            submit() {
                if (!this.$v.$invalid) {
                    this.$emit('input', {username: this.username, password: this.password})
                    this.$emit('submit');
                }
            }
        },

        validations: {
            username: {minLength: minLength(3), required},
            password: {minLength: minLength(3), alphaNum, required},
        },
        watch: {},
        components: {
            InputBase, FormBase
        }
    }
</script>

<style scoped>

</style>