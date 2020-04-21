import Vue from 'vue';
import {mask} from 'v-mask'
import itemUpdate from "./item/itemupdate.vue";
import itemAdd from "./item/itemadd.vue";
import {CategoryManaging} from "../../class/category/category";


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


export const BaseProps = {
    props: {
        type: {
            type: String,
            default: 'text',
            validator(value) {
                return ['text', 'email', 'password', 'file', 'tel'].includes(value);
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


const ItemsEditor = {
    data() {
        return {
            itemList: []
        }
    },
    methods: {
        vModelArray() {
        },
        addItem(item) {
            if (!this.itemList.includes(item)) {
                this.itemList.push(item);
                this.vModelArray()
            }
        },
        deleteItem(index) {
            this.itemList.splice(index, 1);
            this.vModelArray()
        },
        updateItem({id, context}) {
            if (!this.itemList.includes(context)) {
                this.itemList[id] = context;
                this.vModelArray()
            }
        }
    },
    mixins: [BaseProps],
    components: {
        itemUpdate, itemAdd
    },
};


export const ButtonSure = Vue.component('SureButtonBase', {
    template: `
        <div>
            <button style="background-color: #72242f" @click.prevent="subEvent"
                    v-if="!mainClick"> {{placeholder}}</button>
            <button style="background-color: #ff002b" @click.prevent="mainEvent" v-if="mainClick">Czy na pewno
                ? {{getQuestion}}</button>
        </div>
    `,
    data() {
        return {
            mainClick: false
        }
    },
    props: {
        question: {type: String},
        placeholder: {type: String}
    },
    computed: {
        getQuestion() {
            `(${this.question})`
        }
    },
    methods: {
        subEvent() {
            this.mainClick = true
            setTimeout(() => {
                this.mainClick = false
            }, 3000)
        },
        mainEvent() {
            this.$emit('click');
            this.mainClick = !this.mainClick;

        }
    }
});


export const ItemUpdater= Vue.component('ItemUpdater', {
    template: `
        <div class="formControl">
            <label>
                <p>
                    <slot></slot>
                </p>
                <itemUpdate :updateMSG="updtingPlaceholder" :placeholder="updPlaceholder" 
                            :item="itemList[0]"
                            :index="0"
                            @update="updateItem"
                            @delete="deleteItem"
                />
            </label>
        </div>`,
    methods:{
        vModelArray(){
            this.filterBase.$model = this.itemList[0];
        },
    },
    created() {
        this.itemList = [this.item]
    },
    props:{
        item:{default:''},
        placeholder:{required:true}
    },
    computed: {
        updPlaceholder() {
            return "Zaktualizuj " + this.placeholder
        },
        updtingPlaceholder() {
            return "Aktualizujesz " + this.placeholder
        },
    },

    mixins: [ItemsEditor],

});




export const ItemListEditor = Vue.component('ItemListEditor', {
    template: `
        <div class="formControl">
            <label>
                <p>
                    <slot></slot>
                </p>
                <itemUpdate :updateMSG="updtingPlaceholder" :placeholder="updPlaceholder"
                            v-for="(item,index) in itemList" :key="index" :item="item" :index="index"
                            @update="updateItem"
                            @delete="deleteItem"
                />
                <itemAdd :placeholder="addNewItemPlaceholder" @addItem="addItem"/>
            </label>
        </div>`,
    mixins: [ItemsEditor],
    methods: {
        vModelArray() {
            this.filterBase.$model = this.itemList.join(",");
        }
    },
    created() {
        this.itemList = this.items || [];
        this.vModelArray();
    },
    computed: {
        updPlaceholder() {
            return "Zaktualizuj " + this.placeholder
        },
        updtingPlaceholder() {
            return "Aktualizujesz " + this.placeholder
        },
        addNewItemPlaceholder() {
            return "Nowy " + this.placeholder
        }
    },
    props: {
        placeholder: {default: ''},
        items: {type:Array}
    }
});


export const FormGroup = Vue.component('formGroup', {
    template: `
        <div class="element">
            {{message}}
            <div>
                <slot></slot>
            </div>

        </div>
    `,
    props: {
        message: {
            type: String,
            required: true
        }
    }
});


export const CheckBoxBase = Vue.component('checkBoxBase', {
    template: `
        <div class="formControl">
            <label v-for="option in options">

                <input type="checkbox"
                       v-model="filterBase.$model"
                       :value="option.value"
                />{{option.msg}}
            </label>
            <div v-for="(error,index) in errors" :key="index">
                <p v-if="(!filterBase[error.name] && filterBase.$dirty)">{{ error.msg}}</p>
            </div>
        </div>`,
    mixins: [BaseProps],
    props: {
        options: {
            type: Array,
            required: true
        },


    }
});


export const TextAreaBase = Vue.component('textAreaBase', {
    template: `
        <div class="formControl"
             :class="{ error: filterBase.$invalid && filterBase.$dirty,valid:!filterBase.$invalid }">
            <label>
                <p>
                    <slot></slot>
                </p>
                <textarea v-model.trim="filterBase.$model" :placeholder="placeholder"/>
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
                <input v-model.trim="filterBase.$model" :type="type" :placeholder="placeholder"/>
                <div v-for="(error,index) in errors" :key="index">
                    <p v-if="(!filterBase[error.name] && filterBase.$dirty)">{{ error.msg}}</p>
                </div>
            </label>
        </div>`,
    mixins: [BaseProps],
});


