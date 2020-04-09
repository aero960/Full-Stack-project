<template>
    <div :class="getStatus" :style="{color:getColor}"> {{getStatus}}</div>
</template>

<script>
    import {permissionParser} from "../../../class/authentication/authandpermissioninfo.js";

    export default {
        name: "AdminPreview",
        computed: {
            getColor() {
                return permissionParser(this.$store.state.auth.userData.permission).color
            },
            getStatus() {
                return permissionParser(this.$store.state.auth.userData.permission).rang
            }
        }
    }
</script>

<style scoped lang="scss">


    $premium : #bcab06;
    $normal: #6aa1ff;
    $admin : #ff213f;
    $webmaster : #5cbc00;
    .normal {
        background-color: $normal;
        color: complement($normal);
        padding: 10px;
        text-transform: lowercase;
        text-align: center;
        width:100px;
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

        color: invert($webmaster);
        padding: 10px;
        border-radius: 10px;
        border: 3px solid invert($webmaster);
        font-size: 40px;
        text-transform: uppercase;
        text-align: center;
        letter-spacing: 15px;
        font-family: 'Courgette', cursive;
        &:hover{
            background-color: invert($webmaster);
            color: $webmaster;
            border: 3px solid $webmaster;
            transition: 1s;
        }
    }

</style>