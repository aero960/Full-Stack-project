<template>
    <div>
        <p>{{$store.state.auth.message}}</p>
        <div>
            <userregisterform v-model="registerData" @submit="register"/>
        </div>
    </div>
</template>

<script>

    import userregisterform from "../../forms/userregisterform.vue";

    export default {
        name: "Register",
        data(){
            return{
                registerData: {}
            }
        },
        methods:{
            register(){
            this.$store.dispatch('registerUser',this.registerData);
            }
        },
        components: {
            userregisterform
        }
    }
</script>

<style scoped>

</style>