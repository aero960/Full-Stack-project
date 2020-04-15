<template>
    <div>
        <p>
            {{userData.username}}
            {{userData.email}}
        </p>
        <AccountSchema :first-name=userData.firstName
                       :last-name=userData.lastName
                       :mobile=userData.mobile
                       :intro=userData.intro
                       :profile=userData.profile
                       :image=userData.image
        />

    </div>
</template>

<script>
    import AccountSchema from "./accountschema.vue";

    export default {
        name: "profileview",
        created() {

            console.log(this.userData)
        },
        components:{
            AccountSchema
        },
        props: {
            userData: {}
        }
    }
</script>

<style scoped>

</style>