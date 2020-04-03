<?php
class AuthenticateNormalUserFA implements FastAction
{
    private FastAction $action;

    public function __construct(FastAction $action)
    {
        $this->action = $action;
    }

    public function getFastActionResponse()
    {
        if (PermissionChecker::checkNormalUserAuthBOOL())
            return $this->action->getFastActionResponse();
        return ["info"=>"You need to be logged in "];
    }
}
class ItemExistFA implements  FastAction {

    private FastAction $action;
    private string $postId;
    public function __construct(FastAction $action,string $postId)
    {
        $this->action = $action;
        $this->postId = $postId;
    }

    public function getFastActionResponse()
    {
        $post = new PostItem("post",$this->postId);
        if($post->CheckItemExist()){
            return $this->action->getFastActionResponse();
        }
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
        return ["info"=>"You need admin permissions"];

    }
}