<template>
    <div>
        Witam na twojej stronie profilowej
        <loader v-if="!$store.getters.isAssigned"></loader>

        <AccountSchema :first-name=$store.getters.getFirstName
                       :last-name=$store.getters.getLastName
                       :mobile=$store.getters.getMobile
                       :intro=$store.getters.getIntro
                       :profile=$store.getters.getProfile
                       :image=$store.getters.getImage
                       v-else></AccountSchema>
    </div>
</template>

<script>
    import loader from "../../httphelper/loader.vue";
    import {userResourceHttp} from "../../store/userresources.js";
    import AccountSchema from "../../account/accountschema.vue";

    export default {
        name: "accountpreview",
        async mounted() {
            userResourceHttp.startAction();
            await this.$store.dispatch('assignResources');
            userResourceHttp.endAction();
        },
        components: {
            loader, AccountSchema
        }
    }

</script>

<style scoped>

</style>