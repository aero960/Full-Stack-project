import {$http} from "../fetching";


const PostFetcherStatus = {
    CATEGORY: 'CATEGORY',
    USER: 'USER',
    ALL: 'ALL'
};


export class PostManaging {

    static FetchAllPosts({page = 0} = {}) {

        return $http.get(`showposts?page=${page}`)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)

    }


    static _FetchPostByCategory(categoryName) {
        //  $http.post

    }


}