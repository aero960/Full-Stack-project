<template>
    <formBase @submit="submit" :valid="!$v.$invalid" :btnText="'update your account'">
        <InputBase :placeholder="'ex: Michael'" :type="'text'" :filterBase="$v.firstName" :errors="[
            {name:'required',msg:'This filed is required'},]">
            First Name
        </InputBase>
        <InputBase :placeholder="'ex: Robinson'" :type="'text'" :filterBase="$v.lastName" :errors="[
            {name:'required',msg:'This filed is required'}]">
            Last Name
        </InputBase>
        <InputBase :placeholder="'ex: 666 666 666'" :type="'tel'" :filterBase="$v.mobile" :errors="[
              {name:'max',msg:`Max number length is ${$v.mobile.$params.max.max}`},
               {name:'integer',msg:`Only integers is valid`} ]">
            phone number
        </InputBase>
        <TextAreaBase :placeholder="'ex: Hi my name is... etc'" :filterBase="$v.intro" :errors="[]">
            intro text profile
        </TextAreaBase>
        <TextAreaBase :placeholder="'ex: I\'m interested in'" :filterBase="$v.profile" :errors="[]">
            Profile text
        </TextAreaBase>
        <InputBase  :placeholder="'ex: http://myimg'" :type="'text'" :filterBase="$v.image" :errors="[]">
            Choose picture (url)
        </InputBase>
    </formBase>
</template>
<script>
    import {InputBase, FormBase, TextAreaBase} from './forms.js'
    import {url, alpha, alphaNum, email, required, maxLength,minLength,integer} from 'vuelidate/lib/validators'

    export default {
        name: "userupdateform",
        data() {
            return {
                firstName: '',
                lastName: '',
                mobile: '',
                intro: '',
                profile: '',
                image: ''
            }
        },
        methods: {
            submit() {
                if (!this.$v.$invalid) {
                    this.$emit('input',
                        {
                            firstName: this.firstName ?? '',
                            lastName: this.lastName ?? '' ,
                            mobile: this.mobile ?? '',
                            intro: this.intro ?? '',
                            profile: this.profile ?? '' ,
                            image: this.image ?? ''
                        });
                    this.$emit('submit');
                }
            }
        },
        components: {
            FormBase, InputBase,TextAreaBase
        },
        validations: {
            firstName: {
                min: minLength(1),
                required
            },
            lastName: {
                min: minLength(1),
                required
            },
            mobile: {
                min: minLength(1),
                max: maxLength(9),
                integer
            },
            intro: {
                alphaNumWhiteSpace: (value = '')=> value.match(/[A-z0-9\s]/ig) ?? false,
                min: minLength(1),
                max: maxLength(130)
            },
            profile: {
                alphaNumWhiteSpace: (value = '')=> value.match(/[A-z0-9\s]/ig) ?? false,
                min: minLength(1),
                max: maxLength(1000)
            },
            image: {}


        }

    }
</script>

<style scoped>

</style>