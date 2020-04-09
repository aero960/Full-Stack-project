import Authentication from "../../class/authentication/authentication";
import {$http} from '../../class/fetching.js'

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
                let data = await Authentication.getInstance().automaticalyLogin();
                if (data.datasuccess) {
                    Authentication.getInstance().assingAccount(commit,
                        localStorage.getItem('token'),
                        data.info,
                        data.content.userdata);
                }else{
                    commit('updateMessage', data.info);
                }
            },
            async logIn({commit}, user) {
                let data = await Authentication.getInstance().logIn(user.username, user.password);
                if (data.datasuccess) {
                    if (data.content.loginSuccesfull) {
                        Authentication.getInstance().assingAccount(commit,
                            data.token,
                            data.info,
                            data.content.userdata)
                    }
                } else {
                    commit('updateMessage', data.info);
                }
            },
           async registerUser({commit,dispatch},user){
             let data = await Authentication.getInstance().registerUser(user.username,user.email,user.password)
                if(data.datasuccess){
                    localStorage.setItem('token',data.token);
                    setTimeout(()=> dispatch('automaticalyLogin'),5000);
                }
               commit('updateMessage', data.info);
            },


            async logOut({commit,dispatch}) {
              let data = await Authentication.getInstance().removeAccount(commit);

            },
        },
        getters: {
            isLogged: (state) => {
                return state.authenticated
            }


        }


    }
;
