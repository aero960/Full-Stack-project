import Vuex from 'vuex';
import Vue from 'vue';
import ToDo from './module.js'


Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        ToDo
    }
})