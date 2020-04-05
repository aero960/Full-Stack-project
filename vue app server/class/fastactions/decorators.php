<?php

class AuthenticateAdminOrOwnerFA implements FastAction
{
    private FastAction $action;
    private string $commentId;

    public function __construct(FastAction $action, string $commentId)
    {
        $this->action = $action;
        $this->commentId = $commentId;
    }

    public function getFastActionResponse()
    {
        $comment = new CommentItem("post", $this->commentId);
        if ($comment->CheckItemExist()) {
            if ($comment->CheckValidOwner() || PermissionChecker::checkAdminUserAuthBOOL()) {
                return $this->action->getFastActionResponse();
            }
            return ["info" => "You need to be owner of comment to delete"];
        }
        return ["info" => "Item doesnt exist"];
    }
}

class ItemExistFA implements FastAction
{

    private FastAction $action;
    private string $postId;

    public function __construct(FastAction $action, string $postId)
    {
        $this->action = $action;
        $this->postId = $postId;
    }

    public function getFastActionResponse()
    {

        $post = new PrivatePost(new PostItem("post", $this->postId));
        if ($post->CheckItemExist()) {
            if ($post->CheckPrivatePost()) {
                if ($post->CheckValidOwner())
                    return $this->action->getFastActionResponse();
                return ["info" => "post is private"];
            } else
                return $this->action->getFastActionResponse();
        }
        return ["info" => "post doesnt exist"];
    }

}


class AuthAdminOrOwnerFA implements FastAction
{

    private FastAction $action;

    public function __construct(FastAction $action)
    {
        $this->action = $action;
    }

    public function getFastActionResponse()
    {

    }
}


class AuthenticateAdminUserFA implements FastAction
{
    private FastAction $action;

    public function __construct(FastAction $action)
    {
        $this->action = $action;
    }

    public function getFastActionResponse()
    {
        if (PermissionChecker::checkAdminUserAuthBOOL()) {
            return $this->action->getFastActionResponse();
        }
        return ["info" => "You need admin permissions"];

    }
}