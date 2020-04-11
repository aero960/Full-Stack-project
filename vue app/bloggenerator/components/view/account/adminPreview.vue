<template>
    <div>

        <div :class="getStatus"> Account type : {{getStatus}}</div>
    </div>

</template>

<script>
    import {permissionParser} from "../../../class/authentication/authandpermissioninfo.js";

    export default {
        name: "AdminPreview",
        computed: {
            getStatus() {
                return permissionParser(this.$store.state.auth.userData.permission).rang;
            }
        }
    }
</script>

<style scoped lang="scss">


    $premium: #bcab06;
    $normal: #6aa1ff;
    $admin: #ff213f;
    $webmaster: #a80c81;
    .normal {
        background-color: $normal;
        color: complement($normal);
        padding: 10px;
        text-transform: lowercase;
        text-align: center;
        width: 100px;
    }

    .premium {
        text-decoration: underline;
        color: $premium;
        padding: 10px;
        text-transform: uppercase;

    }

    .admin {

        color: $admin;
        padding: 10px;
        font-size: 30px;
        border: 1px solid $admin;
        text-align: center;
        text-transform: uppercase;
    }

    .webmaster {

        color: $webmaster;
        padding: 10px;
        border-radius: 10px;
        border: 3px solid invert($webmaster);
        font-size: 40px;
        text-transform: uppercase;
        text-align: center;
        letter-spacing: 15px;
        font-family: 'Courgette', cursive;

        &:hover {
            color: complement($webmaster);
            border: 3px solid transparent;

            transition: 0.5s;
        }
    }

</style>