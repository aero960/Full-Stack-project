<template>
    <div>
        Witam na twojej stronie profilowej

        <loader-composite :loading="!$store.getters.isAssigned">
            <AccountSchema :first-name=$store.getters.getFirstName
                           :last-name=$store.getters.getLastName
                           :mobile=$store.getters.getMobile
                           :intro=$store.getters.getIntro
                           :profile=$store.getters.getProfile
                           :image=$store.getters.getImage
                           />
        </loader-composite>



    </div>
</template>

<script>
    import loader from "../../httphelper/httploader.vue";
    import AccountSchema from "../../account/accountschema.vue";
    import {httploadercomposite} from "../../httphelper/httploadercomposite";

    export default {
        name: "accountpreview",
        components: {
            loader, AccountSchema,loaderComposite: httploadercomposite
        }
    }

</script>

<style scoped>

</style>