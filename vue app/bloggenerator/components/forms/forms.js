import Vue from 'vue';

export const FormBase = Vue.component('FormBase', {
    template: `
        <form @submit.prevent="onSubmit">
            <slot></slot>
            <button type="submit" :disabled="disabled">
                <slot name="btnText"/>
            </button>
        </form>
    `,
    methods: {
        onSubmit() {
            this.$emit('submit');
        }
    },
    props:{
        disabled:{
            default: false
        }
    }
});


export const InputBase = Vue.component('InputBase', {
    template: `
        <div class="formControl" :class="{ error: filterBase.$invalid && filterBase.$dirty,valid:!filterBase.$invalid }" >
            <label>
                <p>
                    <slot></slot>
                </p>
                <input v-model="filterBase.$model"  :type="type" placeholder="email OR username"/>
                <div v-for="(error,index) in errors" :key="index">
                    <p v-if="(!filterBase[error.name] && filterBase.$dirty)">{{ error.msg}}</p>
                </div>
            </label>
            
        </div>`,

    props: {
        type: {
            type: String,
            default: 'text',
            validator(value) {
                return ['text', 'email', 'password'].includes(value);
            }
        },
        filterBase: {
            required: true,
        },
        errors:{
            type: Array
        }
    },
    methods: {
        onInput({target}) {
            this.filterBase.$model = target.value;
            console.log(this.filterBase.$invalid)
        }
    },

});


