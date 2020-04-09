<template>
    <main>
        <div> there is managing of all app
            <p>There is view</p>
            <ManageView/>
        </div>
    </main>

</template>

<script>
    import ManageView from "./view/manage.vue"

    export default {
        name: "App",
        components: {ManageView},
        created() {

            this.$store.dispatch('automaticalyLogin')
        }
    }
</script>
<style lang="scss">

    $color_1: #ff8706;
    $color_2: #ff1635;
    $color_3: #ffcbe4;
    $color_4: rgba(164, 171, 247, 0.74);
    $valid: rgb(38, 240, 0);
    $error: rgb(255, 0, 38);
    @mixin buttonStyle{
        display: block;
        width: 100%;
        border-radius: 5px;
        padding: 5px 10px;
    }

    .formControl{
        padding:10px;
    }
        .valid{
            border-bottom: 3px solid   $valid;

        }
        .error{
            border-bottom: 3px solid $error;
        }
    form{
        border-radius: 5px;
        padding:10px;
        margin: 10px 0;
    }
    button[disabled]{
       @include buttonStyle;
        font-size: 10px;
    }

    p{
        font-size:25px;

    }

    input{
        border: 1px solid ;
        padding: 5px 10px;
        margin: 10px 0px;
        border-radius: 5px;
        width: 100%;
    }
    body {
        font-family: 'IM Fell French Canon SC', serif;
        font-size: 21px;
        padding: 10px;
    }


    button {
    @include buttonStyle;
    }

    * a{
        font-size: 30px;
        text-transform: uppercase;
       border: 1px solid black;
        padding: 10px;
        border-radius: 10px;
        margin:10px 0px;
        display: block;
    }

</style>