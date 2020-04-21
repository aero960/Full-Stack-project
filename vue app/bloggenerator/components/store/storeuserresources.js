import UserResources from "../../class/userresources/userresoucres";
import router from '../routes/webroutes.js';
import {$http, requestHelper} from '../../class/fetching.js'




export const userResourcesStore = {
    state: {
        resources: {},
        message: '',
        assigned: false

    },
    mutations: {
        setUpdatedResources(state, data) {
            state.updatedResources = data
        },
        updateMessage(state, message) {
            state.message = message
        },
        setResources(state, data) {
            state.resources = data
        },
        setAssigned(state) {
            state.assigned = true;
        }

    },
    actions: {
        async updateResources({commit,dispatch}, resources) {
            let data = await UserResources.updateUserResources(
                resources.firstName,
                resources.lastName,
                resources.mobile,
                resources.intro,
                resources.profile,
                resources.image);

            commit('updateMessage', data?.info ?? "brak informacji");
            dispatch('assignResources');
        },
        /*
         * need set header token*/
        async assignResources({commit},{id=''}='') {

                let data = await UserResources.automaticalyAssignResources({id:id});

                if (data.datasuccess) {
                    commit('setResources', data.content);
                    commit('setAssigned');
                }else
                commit('updateMessage', "You are not logged");

        },
    },
    getters: {
        getFirstName: (state)=> state.resources.firstName,
        getLastName: (state)=> state.resources.lastName,
        getMobile: (state)=> state.resources.mobile,
        getIntro: (state)=> state.resources.intro,
        getProfile: (state)=> state.resources.profile,
        getImage: (state)=> state.resources.image,

        isAssigned: (state) =>{
            return state.assigned
        }
    }
};