<template>
    <div>
        <div>Login  user</div>
        <div>
            <p>{{$store.state.auth.message}}</p>
            <user-login-form v-model="formData" @submit="logIn"/>
        </div>
    </div>
</template>
<script>
    import UserLoginForm from '../../forms/formuserlogin.vue'
    import loader from "../../httphelper/httploader.vue";
    import {userAuthenticationHttp} from '../../store/storeauthentication.js'
    import router from "../../routes/webroutes";
    export default {
        name: "Login",
        data(){
            return{
                formData: {}

            }
        },
        methods: {
            logIn() {
                this.$store.dispatch('logIn',this.formData)

                if(this.$route.query.hasOwnProperty('from'))
                    router.push({name: this.$route.query.from}).catch(err => {});
                else
                    router.push({name: 'AccountManage'}).catch(err => {});
            }
        },
        components: {
            UserLoginForm
        }
    }
</script>

<style scoped>

</style>s