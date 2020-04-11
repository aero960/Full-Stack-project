import {$http} from "../fetching";

export class CategoryManaging {


    static GetCategorys() {
        return $http.post("fastaction/showcategories")
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)
    }
}