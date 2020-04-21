import Authentication, {AUTHENTICATION, TOKEN} from "../../class/authentication/authentication";
import router from '../routes/webroutes.js';
import {$http} from '../../class/fetching.js'


const assingAccount = (commit, token, info, userdata) => {

    commit('logInAuth', token);
    commit('updateDataUser', userdata);
    commit('updateMessage', info);
};


const removeAccount = (commit) => {
    commit('logOutAuth');
    commit('updateMessage', "You are logout");
    localStorage.removeItem(TOKEN)
    $http.defaults.headers.common[AUTHENTICATION] = null;
};


export const authenticationStore = {
        state: {
            authenticated: null,
            userData: {},
            message: ''
        },
        mutations: {
            logInAuth(state, token) {
                state.authenticated = token;
            },
            logOutAuth(state) {
                state.authenticated = null;
            },
            updateDataUser(state, data) {
                state.userData = data
            },
            updateMessage(state, message) {
                state.message = message
            }
        },
        actions: {
            async automaticalyLogin({commit,dispatch}) {
                let data = await Authentication.automaticalyLogin();
                if (data.datasuccess) {
                    assingAccount(commit,
                        localStorage.getItem(TOKEN),
                        "Logged to account",
                        data.content);
                    dispatch('assignResources',{id:data.content.id});
                } else {
                    removeAccount(commit);
                    commit('updateMessage', data.info);

                }
            },
            async logIn({commit,dispatch}, user) {
                let data = await Authentication.logIn(user.username, user.password);
                if (data.datasuccess) {
                    if (data.content.loginSuccesfull) {
                        assingAccount(commit,
                            data.token,
                            data.info,
                            data.content.userdata)
                     dispatch('assignResources',{id:data.content.userdata.id});

                    }
                } else {
                    commit('updateMessage', data.info);
                }
            },
            async registerUser({commit, dispatch}, user) {
                let data = await Authentication.registerUser(user.username, user.email, user.password);
                console.log(data)
                if (data.datasuccess) {
                    localStorage.setItem(TOKEN, data.token);

                    setTimeout(() => dispatch('automaticalyLogin'), 5000);

                    router.push({name: 'ShowAccount'}).catch(err => {});
                }
                commit('updateMessage', data.info);
            },

            logOut({commit}) {
                removeAccount(commit);
                window.location.reload();

            },
        },
        getters: {
            isLogged: (state) => {
                return state.authenticated
            },
            getUserId: (state) =>{
                return state.userData.id
            }


        }


    }
;
