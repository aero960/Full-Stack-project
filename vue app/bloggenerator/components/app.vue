<template>
    <main>
            <ManageView/>
    </main>

</template>

<script>
    import ManageView from "./view/manage.vue"
    import store from "./store/webstore";

    export default {
        name: "App",
        components: {ManageView},

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
        font-size:15px;
        display: block;
        padding: 10px 20px;
        text-transform: uppercase;
        letter-spacing: 10px;
        border-bottom: 1px solid transparent;
        background-color: #83c1f7;
        &:hover{
            transition: 0.5s;
            background-color: #0e65c1;
        }
    }
    .notPublic{
        border: solid 3px #e10e37;
        padding:10px;
    }


    .element{
        margin: 100px 10px;
        padding:10px;
            position: relative;
        
        .post{
            margin: 30px 0px;
            padding: 10px;
            border-left: 3px solid black;
        }
        &::after{
            content: '';
            position:absolute;
            left:-10px;
            top:0;
            width:3px;
            height:100%;
            background-color: #AD2C1C;
        }
    }

    .postList{
        width:39%;
    }
    .currentyPost{
        width:61%;
    }

    .dflex{
        display:flex;
        justify-content: space-between;
    }
    .formControl{
        padding:2px;
    }
        .valid{
            border-bottom: 1px solid   $valid;

        }
        .error{
           // border-bottom: 3px solid $error;
        }
    form{
        border-radius: 5px;
        padding:10px;
        margin: 10px 0;
    }
    button[disabled]{
       @include buttonStyle;
        display: none;
        font-size: 10px;
    }

    p{
        padding: 5px 0px;
        font-size:20px;

    }

    input{
        border-bottom: 1px solid ;
        padding: 5px 10px;
        margin: 10px 0px;

    }
    body {
        font-family: 'Libre Franklin', sans-serif;
        font-size: 21px;
        padding: 10px;
    }


    button {
    @include buttonStyle;
    }

    * a{
        font-size: 20px;
        text-transform: uppercase;

        padding: 10px;
        border-radius: 10px;
        margin:10px 0px;
        display: block;
    }

</style>