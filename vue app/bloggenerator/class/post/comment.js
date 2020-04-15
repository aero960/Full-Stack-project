import {$http} from "../fetching";

export class CommentManaging {
    static createComment({post, username, title, content}) {
        let data = new FormData();
        data.append('postid', post);
        data.append('username', username);
        data.append('title', title);
        data.append('content_comment', content);

        return $http.post('fastaction/createcomment', data)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)
    }

    static deletePost({postId, isSpam}) {
        let data = new FormData();
        data.append('comment_id', postId);
        data.append('spam', isSpam);

        $http.post('fastaction/deletecomment', data)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)
    }

    static reportPost({commentId, message}) {
        let data = new FormData();
        data.append('message', `${commentId};${message}`);
        data.append('type', `post_punish`);

        return $http.post('fastaction/reportpost', data)
            .then(res => res.data.data)
            .then(res => res)
            .catch(error => error.response.data.data)


    }
}