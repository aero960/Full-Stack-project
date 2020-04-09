<template>
    <FormBase @submit="submit" :disabled="this.$v.$invalid">
        <InputBase :type="'text'" :filterBase="$v.username" :errors="[
            {name:'required',msg:'This filed is required'},]">
            Username
        </InputBase>
        <InputBase :type="'email'" :filterBase="$v.email" :errors="[
            {name:'required',msg:'This filed is required'},
            {name:'email',msg:`This isn't properly email`} ]">
            Email
        </InputBase>
        <InputBase :type="'password'" :filterBase="$v.password" :errors="[
            {name:'required',msg:'This filed is required'},
            {name:'minLength',msg:`Minimum length is ${$v.password.$params.minLength.min}`}]">
            Password
        </InputBase>
        <template v-slot:btnText>Register</template>
    </FormBase>
</template>

<script>
    import {InputBase, FormBase} from './forms.js'
    import {url, alpha, email, required, minLength} from 'vuelidate/lib/validators'

    export default {
        name: "UserRegisterForm",
        data() {
            return {
                username: '',
                password: '',
                email: ''
            }
        },
        components: {
            InputBase, FormBase
        },
        methods: {
            submit() {
                if (!this.$v.$invalid) {
                    this.$emit('input',
                        {
                            username: this.username,
                            password: this.password,
                            email: this.email
                        });
                    this.$emit('submit');
                }
            }
        },
        validations: {
            username: {
                required
            },
            password: {
                required,
                minLength: minLength(3)
            },
            email: {
                required,
                email
            }
        }
    }
</script>

<style scoped>

</style>