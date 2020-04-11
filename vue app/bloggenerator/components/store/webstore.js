import Vuex from 'vuex';
import Vue from 'vue';
import {authenticationStore} from './authentication.js'
import {userResourcesStore} from "./userresources.js";
import { postStore} from "./posts";

Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        auth: authenticationStore,
        res: userResourcesStore,
        post: postStore
    }
});