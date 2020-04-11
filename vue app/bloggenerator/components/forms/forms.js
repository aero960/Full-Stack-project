import Vue from 'vue';
import {mask} from 'v-mask'

export const FormBase = Vue.component('FormBase', {
    template: `
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">
            <slot></slot>
            <button type="submit" :disabled="!valid">
                {{btnText}}
            </button>
        </form>
    `,
    data() {
        return {
            isValid: false
        }
    },
    methods: {
        onSubmit() {
            this.$emit('submit');
        },
    },
    watch: {
        'valid': () => {
        }
    },
    props: {
        valid: {
            default: false,
            required: true
        },
        btnText: {
            required: true,
            type: String
        }
    }
});


const BaseProps = {
    props: {
        type: {
            type: String,
            default: 'text',
            validator(value) {
                return ['text', 'email', 'password', 'file','tel'].includes(value);
            }
        },
        placeholder: {
            type: String
        },
        filterBase: {
            required: true,
        },
        errors: {
            type: Array
        }
    }
};

export const TextAreaBase = Vue.component('textAreaBase', {
    template: `
        <div class="formControl"
             :class="{ error: filterBase.$invalid && filterBase.$dirty,valid:!filterBase.$invalid }">
            <label>
                <p>
                    <slot></slot>
                </p>
                <textarea v-model="filterBase.$model" :placeholder="placeholder"/>
                <div v-for="(error,index) in errors" :key="index">
                    <p v-if="(!filterBase[error.name] && filterBase.$dirty)">{{ error.msg}}</p>
                </div>
            </label>
        </div>`,
    mixins: [BaseProps]

});


export const InputBase = Vue.component('InputBase', {
    template: `
        <div class="formControl"
             :class="{ error: filterBase.$invalid && filterBase.$dirty,valid:!filterBase.$invalid }">
            <label>
                <p>
                    <slot></slot>
                </p>
                <input v-model="filterBase.$model" :type="type" :placeholder="placeholder"/>
                <div v-for="(error,index) in errors" :key="index">
                    <p v-if="(!filterBase[error.name] && filterBase.$dirty)">{{ error.msg}}</p>
                </div>
            </label>
        </div>`,
    mixins: [BaseProps],
});


