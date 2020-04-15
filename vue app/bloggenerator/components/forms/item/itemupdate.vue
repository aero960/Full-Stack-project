<template>
    <div class="dflex">
        <p  v-if="updating">
            {{updateMSG}}  #{{index + 1}}
            <component :is="form" v-bind="inputProps" ></component>
        </p>

        <div v-else>{{currentyMessage}}</div>

        <button @click.prevent="addFormUpdate">{{(updating) ?"Potwierdź aktualizacje" : 'zaktualizuj'}}</button>
        <button @click.prevent="deleteCurrent">Usun</button>
    </div>
</template>
<script>
    import {url, alpha, alphaNum, email, required, maxLength,minLength,integer} from 'vuelidate/lib/validators'
    import {InputBase, FormBase, BaseProps} from "../forms";
    export default {
        name: "ItemUpdate",
        asyncData:{

        },
        data() {
            return {
                form: InputBase,
                currentyMessage: '',
                updating: false
            }
        },
        computed: {
            inputProps: function () {
                if (this.form === InputBase) {
                    return {
                        filterBase: this.$v.currentyMessage,
                        placeholder: this.placeholder,
                        errors: [{name: 'maxLength', msg: `Maximum length is ${this.$v.currentyMessage.$params.maxLength.max}`}],
                    }
                }
            }
        },
        created() {
            this.currentyMessage = this.item;
        },
        methods: {
            deleteCurrent() {
                this.$emit('delete', this.index)
            },
            addFormUpdate() {
                if(this.updating && !this.$v.currentyMessage.$invalid){
                    this.currentyMessage = this.$v.currentyMessage.$model;
                    this.$emit('update',{id:this.index,context:this.currentyMessage});
                }
                this.updating = !this.updating;
            }
        },
        components: {
            InputBase
        },
        validations: {
            currentyMessage: {type: String,maxLength:maxLength(30)}
        },
        props: {
            index: {type: Number},
            item:{type:String},
            placeholder: {type:String},
            updateMSG:{type:String}
        }
    }
</script>

<style scoped>

</style>