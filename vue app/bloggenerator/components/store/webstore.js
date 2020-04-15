import Vuex from 'vuex';
import Vue from 'vue';
import {authenticationStore} from './storeauthentication.js'
import {userResourcesStore} from "./storeuserresources.js";
import { postStore} from "./storeposts";

Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        auth: authenticationStore,
        res: userResourcesStore,
        post: postStore
    }
});