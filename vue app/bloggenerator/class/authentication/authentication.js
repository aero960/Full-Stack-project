import {$http} from '../fetching';

const params = new FormData();

export default class Authentication {
    static #instance = null;


    async registerUser(username, email, password) {
        const params = new FormData();
        params.append('username', username);
        params.append('email', email);
        params.append('password', password);

        return  $http.post('register', params)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data);
    }


    async automaticalyLogin() {
        if (localStorage.getItem('token')) {
            $http.defaults.headers.common['WWW-Authenticate'] = localStorage.getItem('token');
            let data = await $http.post("fastaction/getuserbytoken")
                .then(res => res.data.data)
                .then((res) => res)
                .catch(error => error.response.data.data);

            return data;
        } else {
            return false;
        }
    }

    removeAccount(commit) {
        commit('logOutAuth');
        commit('updateMessage', "You are logout");
        localStorage.removeItem('token')
        $http.defaults.headers.common['WWW-Authenticate'] = null;

    }

    assingAccount(commit, token, info, userdata) {
        commit('logInAuth', token);
        commit('updateDataUser', userdata);
        commit('updateMessage', info);
    }


    async logIn(login, password) {

        const params = new FormData();
        params.append('username', login);
        params.append('email', login);
        params.append('password', password);
        let data = await $http.post("login", params)
            .then(res => res.data.data)
            .then((res) => res)
            .catch(error => error.response.data.data)

        if (data.datasuccess) {
            if (data.content.loginSuccesfull) {
                localStorage.setItem('token', data.token);
                $http.defaults.headers.common['WWW-Authenticate'] = localStorage.getItem('token');
                return data;
            }
        }
        return data;


    }

    static getInstance() {
        if (!this.#instance) {
            this.#instance = new Authentication();
        }
        return this.#instance;
    }


}