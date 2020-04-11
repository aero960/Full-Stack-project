import UserResources from "../../class/userresources/userresoucres";
import router from '../routes/webroutes.js';
import {$http, requestHelper} from '../../class/fetching.js'


export const userResourceHttp = {
    inAction: false,
    startAction() {
        this.inAction = true
    },
    endAction() {
        this.inAction = false
    }
};


export const userResourcesStore = {
    state: {
        resources: {},
        updatedResources: {},
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
        async updateResources({commit}, resources) {
            let data = await UserResources.updateUserResources(
                resources.firstName,
                resources.lastName,
                resources.mobile,
                resources.intro,
                resources.profile,
                resources.image);
            commit('setUpdatedResources', data?.content ?? "Brak danych");
            commit('updateMessage', data?.info ?? "brak informacji");
        },
        /*
         * need set header token*/
        async assignResources({commit, state}) {
            if (!state.assigned) {
                let data = await UserResources.assingResources();
                if (data.datasuccess) {

                    commit('setResources', data.content);
                    commit('setAssigned');
                }else
                commit('updateMessage', "You are not logged");
            }
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