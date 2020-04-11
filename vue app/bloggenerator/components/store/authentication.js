import Authentication, {AUTHENTICATION, TOKEN} from "../../class/authentication/authentication";
import router from '../routes/webroutes.js';
import {$http} from '../../class/fetching.js'


export const userAuthenticationHttp = {
    inAction: false,
    startAction() {
        this.inAction = true
    },
    endAction() {
        this.inAction = false
    }
};


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
            async automaticalyLogin({commit}) {
                let data = await Authentication.automaticalyLogin();
                if (data.datasuccess) {
                    assingAccount(commit,
                        localStorage.getItem(TOKEN),
                        "Logged to account",
                        data.content);
                } else {
                    removeAccount(commit);
                    commit('updateMessage', data.info);
                }
            },
            async logIn({commit}, user) {
                let data = await Authentication.logIn(user.username, user.password);
                if (data.datasuccess) {
                    if (data.content.loginSuccesfull) {
                        assingAccount(commit,
                            data.token,
                            data.info,
                            data.content.userdata)

                        router.push({name: 'AccountManage'}).catch(err => {
                        });
                    }
                } else {
                    commit('updateMessage', data.info);
                }
            },
            async registerUser({commit, dispatch}, user) {
                let data = await Authentication.registerUser(user.username, user.email, user.password)
                if (data.datasuccess) {
                    localStorage.setItem(TOKEN, data.token);
                    setTimeout(() => dispatch('automaticalyLogin'), 5000);
                    router.push({name: 'ShowAccount'}).catch(err => {
                    });
                }
                commit('updateMessage', data.info);
            },

            logOut({commit}) {
                removeAccount(commit);
                router.push({name: 'LoginUser'}).catch(err => {
                    console.log(err)
                });
            },
        },
        getters: {
            isLogged: (state) => {
                return state.authenticated
            }


        }


    }
;
