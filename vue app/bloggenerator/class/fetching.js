import axios from 'axios'


const configs = axios.create({
    baseURL: 'http://www.apiproject.com/',
    timeout: 10000,
    headers: {
        'content-type': 'application/json',
    }
});





export const $http = configs;