<template>
    <div>
        <div>Login  user</div>
        <div>
            <p>{{$store.state.auth.message}}</p>
            <user-login-form v-model="loginData" @submit="logIn"/>
        </div>
    </div>
</template>
<script>
    import UserLoginForm from '../../forms/userloginform.vue'
    import loader from "../../httphelper/loader.vue";
    import {userAuthenticationHttp} from '../../store/authentication.js'
    export default {
        name: "Login",
        data(){
            return{
                loginData: {}

            }
        },
        methods: {
            logIn() {

                this.$store.dispatch('logIn',this.loginData)
            }
        },
        components: {
            UserLoginForm
        }
    }
</script>

<style scoped>

</style>s