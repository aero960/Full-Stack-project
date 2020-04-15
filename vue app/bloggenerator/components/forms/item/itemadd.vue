<template>
    <div class="dflex">
        <InputRecursive :filterBase="$v.currentyMessage"
                        :placeholder="placeholder"
                        :errors="[{name:'maxLength',msg:`Maximum length is ${$v.currentyMessage.$params.maxLength.max}`}]"/>
        <button  @click.prevent="addItem">Dodaj</button>
    </div>
</template>
<script>
    import {InputBase,FormBase,BaseProps} from "../forms.js";
    import {url, alpha, alphaNum, email, required, maxLength,minLength,integer} from 'vuelidate/lib/validators'
    export default {
        name: "itemAdd",
        data(){
          return{
              currentyMessage: ''
          }
        },
        methods:{
            addItem(){
                console.log("12412442")
                if(!this.$v.currentyMessage.$invalid){
                    this.$emit('addItem',this.currentyMessage)
                    this.currentyMessage = '';
                }
            }
        },
        beforeCreate: function () {
            this.$options.components.InputRecursive = require("../forms.js").InputBase
        },
        validations:{
            currentyMessage:{required,maxLength: maxLength(30)}
        },
        props:{
            placeholder:{}
        }


    }
</script>

<style scoped>

</style>