import {$http} from '../fetching';

export default class UserResources {

    /*
    * User must be login in to use this action
    * need to set  header token
    * */
    static async assingResources() {

        return  await $http.post('fastaction/getfulluserdata')
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data);

    }


    static async updateUserResources(firstName, lastName, mobile, intro, profile, image) {

        const params = new FormData();

        params.append('firstName', firstName);
        params.append('lastName', lastName);
        params.append('mobile', mobile);
        params.append('intro', intro);
        params.append('profile', profile);
        params.append('image', image);

        console.log(params)
        return await $http.post('updateprofile', params)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data);
    }
}