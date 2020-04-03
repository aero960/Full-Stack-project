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
        $statement->execute(["id"=>$this->postId]);
        return $statement->fetchAll();
    }
    public function getFastActionResponse()
    {
            return $this->getComments();
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
        return ["info" => "created comment to post {$this->postId} with comment id {$this->currentyId}"];
    }
}