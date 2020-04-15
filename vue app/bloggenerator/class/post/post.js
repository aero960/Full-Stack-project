import {$http} from "../fetching";


const PostFetcherStatus = {
    CATEGORY: 'CATEGORY',
    USER: 'USER',
    ALL: 'ALL'
};


export class PostManaging {

    static async ChengePostStatus({postId, publish}) {
        let params = new FormData();
        params.append("publish", publish);
        return $http.post(`publish/${postId}`, params)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)
    }


    static ConnectCategoryPost({postId, category = []} = {}) {
        let promises = category.map((index) => {
            let data = new FormData();
            data.append("postid", postId);
            data.append("category_name", index);
            return $http.post("fastaction/connectcategory", data);
        });
        return Promise.all(promises);
    }


    static async DeletePost({postId}) {
        return $http.delete(`delete/${postId}`)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)
    }

    static async CreatePost({title, content, tags}) {
        let params = new FormData();
        params.append("post_title", title);
        params.append("post_content", content);
        params.append("tags", tags);

        return $http.post('createpost', params)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)
    }

    static GetUserById({userid = ''} = {}) {
        let params = new FormData();
        params.append("userid", userid);
        return $http.post(`fastaction/getuserbyid`, params)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)
    }

    static FetchSpecificPost({id}) {
        return $http.get(`showposts/${id}`)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)
    }

    static FetchAllUserPosts({postId}) {
        return $http.get(`showposts?user=${postId}`)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response?.data?.data)
    }

    static FetchAllPosts({page = 0} = {}) {
        return $http.get(`showposts?page=${page}`)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response?.data?.data)
    }

    static FetchPostByCategory({categoryName}) {
        return $http.get(`showposts?category=${categoryName}`)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response?.data?.data)

    }


}