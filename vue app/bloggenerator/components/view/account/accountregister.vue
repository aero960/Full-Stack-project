<template>
    <div>
        <p>{{$store.state.auth.message}}</p>
        <div>
            <userregisterform v-model="registerData" @submit="accountregister"/>
        </div>
    </div>
</template>

<script>
    import userregisterform from "../../forms/formuserregister.vue";

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