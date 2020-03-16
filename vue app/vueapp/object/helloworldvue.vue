<template lang="pug">
    .container
        h1 {{nowszy}}
            div {{test}}
                p test
                p test
</template>

<script>
    import test from "../object/test.pug"
        import Vue from "vue"
   const tescik = Vue.component("test",{
        template:test(),
        data: function () {
            return {
                test: 3,
                nowszy: 4
            }
        }
    });


 const app ={
        name: 'app',

        data: function () {
            return {
                test: 3,
                nowszy: 4
            }
        },
     components:{
        myTask: tescik
     }

    };

    export default app;
</script>

