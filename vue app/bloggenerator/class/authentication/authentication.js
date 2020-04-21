import {$http} from '../fetching';


export const TOKEN = 'token';
export const AUTHENTICATION = 'WWW-Authenticate';

export default class Authentication {
    static #instance = null;

    static async registerUser(username, email, password) {
        const params = new FormData();
        params.append('username', username);
        params.append('email', email);
        params.append('password', password);


        return  $http.post('register', params)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data);

    }

    static async automaticalyLogin() {
        if (localStorage.getItem(TOKEN)) {
            $http.defaults.headers.common[AUTHENTICATION] = localStorage.getItem(TOKEN);
            return await $http.post("fastaction/getuserbytoken")
                .then(res => res.data.data)
                .then((res) => res)
                .catch(error => error.response.data.data);
        } else {
            return false;
        }
    }

    static async logIn(login, password) {

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
                localStorage.setItem(TOKEN, data.token);
                $http.defaults.headers.common['WWW-Authenticate'] = localStorage.getItem(TOKEN);
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