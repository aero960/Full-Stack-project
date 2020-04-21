import {$http} from '../fetching';
import {TOKEN} from "../authentication/authentication";

export default class UserResources {


    static async getUserInformation(){


    }
    /*
    * User must be login in to use this action
    * need to set  header token
    * */
    static async automaticalyAssignResources({id=''}='') {
        let params = new FormData();
        params.append('userid',id);

            console.log(id)
        return  await $http.post('fastaction/getfulluserdata',params)
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


        return await $http.post('updateprofile', params)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data);
    }
}