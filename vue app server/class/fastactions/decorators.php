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

    public function getFastActionResponse() : FastActionDelivery
    {
        $comment = new CommentItem("post", $this->commentId);
        if ($comment->CheckItemExist()) {
            if ($comment->CheckValidOwner() || PermissionChecker::checkAdminUserAuthBOOL()) {
                return new FastActionDelivery(true,$this->action->getFastActionResponse());

            }
            return new FastActionDelivery(false,[FastActionDelivery::INFO => "You need to be owner of comment to delete"]);

        }
        new FastActionDelivery(false,[FastActionDelivery::INFO => "Item doesnt exist"]);

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

    public function getFastActionResponse() : FastActionDelivery
    {

        $post = new PrivatePost(new PostItem("post", $this->postId));
        if ($post->CheckItemExist()) {

            if ($post->CheckPrivatePost()) {

                if ($post->CheckValidOwner())
                   return $this->action->getFastActionResponse();

               return new FastActionDelivery(false,[FastActionDelivery::INFO  => "post is private"]);
            } else
                return $this->action->getFastActionResponse();
        }
        return new FastActionDelivery(false,[FastActionDelivery::INFO  => "post doesnt exist"]);

    }

}


class CheckAuthFa implements FastAction
{

    private FastAction $action;

    public function __construct(FastAction $action)
    {
        $this->action = $action;
    }

    public function getFastActionResponse() : FastActionDelivery
    {
        if (PermissionChecker::checkNormalUserAuthBOOL()) {
            return  $this->action->getFastActionResponse();
        }
       return new FastActionDelivery(false,[FastActionDelivery::INFO  => "You are not logged"]);
    }
}


class AuthenticateAdminUserFA implements FastAction
{
    private FastAction $action;

    public function __construct(FastAction $action)
    {
        $this->action = $action;
    }

    public function getFastActionResponse(): FastActionDelivery
    {
        if (PermissionChecker::checkAdminUserAuthBOOL()) {
            return $this->action->getFastActionResponse();
        }
        return new FastActionDelivery(false, [FastActionDelivery::INFO  => "You need admin permissions"]);


    }
}