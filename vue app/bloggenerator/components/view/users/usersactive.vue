<template>
    <div>

        <loader-composite :loading="loading">
            <p>Właśnie przeglądasz użytkownika {{currentyUser.username}}</p>
            <profileview v-if="Object.keys(userData).length" :userData="userData"></profileview>
            <p v-else>Uzytkownik nie ma stałego konta, przepraszamy za niedogodności</p>
        </loader-composite>
    </div>
</template>

<script>
    import AccountSchema from "../../account/accountschema.vue";
    import profileview from "../../account/accountview.vue";
    import {httploadercomposite} from "../../httphelper/httploadercomposite";
    import userresoucres from "../../../class/userresources/userresoucres";
    import authentication from "../../../class/authentication/authentication";

    export default {
        name: "activeuser",
        data() {
            return {
                userData: {},
                currentyUser: {},
                loading: true,
            }
        },
        methods: {
            async loadUser() {
                this.loading = true;
                let data = await userresoucres.automaticalyAssignResources({id: this.$route.params.userId});
                let user = await this.$postManage.GetUserById({userid: this.$route.params.userId});
                if (data.datasuccess) {
                    this.userData = {...data.content, ...user.content}
                    this.currentyUser = user;
                }

                this.loading = false;
            }
        },
        created() {
            this.loadUser();
        },
        components: {profileview, loaderComposite: httploadercomposite}
    }
</script>

<style scoped>

</style>