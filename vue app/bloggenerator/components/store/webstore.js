import Vuex from 'vuex';
import Vue from 'vue';
import {authenticationStore} from './authentication.js'

Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        auth: authenticationStore
    }
});