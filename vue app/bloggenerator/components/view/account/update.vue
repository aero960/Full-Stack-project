<template>
    <div>
        Zaktualizuj swoje dane
        <div>{{$store.state.res.message}}</div>
        <UserUpdateForm v-model="updateData" @submit="update"></UserUpdateForm>
    </div>
</template>

<script>
    import UserUpdateForm from "../../forms/userupdateform.vue";
    export default {
        name: "Update",
        components:{
            UserUpdateForm
        },
        data(){
            return{
                updateData: {}
            }
        },
        methods:{
            update(){
                this.$store.dispatch('updateResources',this.updateData)
            }
        }

    }
</script>

<style scoped>

</style>