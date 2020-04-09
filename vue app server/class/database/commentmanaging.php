<?php


class ShowCommetoRealtedToPostEXT extends BuilderComposite implements FastAction
{

    private string $postId;

    public function __construct(string $postId)
    {
        parent::__construct();
        $this->postId = $postId;
    }

    public function getComments()
    {
        $sql = "SELECT comments.* FROM post INNER JOIN comment_post
                ON cp_post_id=post_id
                INNER JOIN comments
                ON comment_id=cp_comment_id WHERE post_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->postId]);
        return $statement->fetchAll();
    }

    public function getFastActionResponse()
    {
        return $this->getComments();
    }

}

class RemoveCommentFromPostEXT extends BuilderComposite implements FastAction
{

    private string $commentId;
    private bool $spam;

    public function __construct(string $commentId, bool $spam)
    {
        parent::__construct();
        $this->commentId = $commentId;
        $this->spam = $spam;
    }

    public static function deleteAllRealetedComment(string $postId){
            $sql = "SELECT cp_comment_id as id FROM comment_post WHERE cp_post_id=:id";
            $statement = Database::getInstance()->getDatabase()->prepare($sql);
        $statement->execute(["id"=>$postId]);
        $commentsToDelete = $statement->fetchAll();
           array_walk($commentsToDelete,function($index){
               (new RemoveCommentFromPostEXT($index->id,0))->getFastActionResponse();
           });
    }

    private function deleteConnection()
    {
        $sql = "DELETE FROM comment_post WHERE cp_comment_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->commentId]);
    }

    private function deleteComment()
    {
        $sql = "DELETE FROM comments WHERE comment_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->commentId]);
    }

    private function changeAtSpam()
    {
        $sql = "UPDATE comments SET comment_title=:title,comment_content=:content WHERE comment_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->commentId, "title" => "spam", "content" => "spam"]);
    }

    private function getUserByComment()
    {
        $sql = "SELECT user_id FROM comments WHERE comment_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->commentId]);
        return $statement->fetch()->user_id;
    }

    private function punishUser()
    {
        $this->changeAtSpam();
        (new PunishUser($this->getUserByComment(), "spam"))->action();
    }

    public function getFastActionResponse()
    {
        if ($this->spam) {
            $this->punishUser();
            return ["info" => "Punish user: {$this->getUserByComment()}"];
        }
        $id = $this->getUserByComment();
        $this->deleteComment();
        $this->deleteConnection();
        return ["info" => "usunieto post uzytkownik {$id} o id {$this->commentId}"];
    }
}


class AddSubCommentEXT extends BuilderComposite implements FastAction{


    public function getFastActionResponse()
    {


    }
}

class AddCommentToPostEXT extends BuilderComposite implements FastAction
{

    private string $postId;
    private string $userId;
    private string $title;
    private string $cotntent;
    private string $currentyId;

    public function __construct(string $title, string $cotntent, string $postId, string $userId)
    {
        parent::__construct();
        $this->postId = $postId;
        $this->userId = $userId;
        $this->cotntent = $cotntent;
        $this->title = $title;
    }

    private function addComment()
    {
        $sql = "INSERT INTO comments SET 
                         comment_id=:id,
                         comment_content=:content,
                         user_id=:userId,
                         comment_title=:title,
                         comment_created_at=:createdAt,
                         realted_to=0";
        $this->currentyId = $this->getRandomId("comments", "comment_id");
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->currentyId,
            "content" => $this->cotntent,
            "userId" => $this->userId,
            "title" => $this->title,
            "createdAt" => (new DateTime())->format(self::DATEFORMAT)]);
        return true;
    }

    private function connectWithPost()
    {
        $sql = "INSERT INTO comment_post SET 
                    cp_post_id=:postId,
                    cp_comment_id=:commentId";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["postId" => $this->postId, "commentId" => $this->currentyId]);
    }

    public function getFastActionResponse()
    {
        $this->addComment();
        $this->connectWithPost();
        return "created comment to post {$this->postId} with comment id {$this->currentyId}";
    }
}