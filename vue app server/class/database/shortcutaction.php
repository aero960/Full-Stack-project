<?php

use Helper\Helper;

interface Shortcut
{
    public function action();
}


class PrivatePostComposite extends  BuilderComposite implements Shortcut{

    private string $userId;
    private string $postId;
    public function __construct($userId,$postId)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->postId = $postId;
    }
    private function checkPrivatePost(){
            $sql = "SELECT post_published FROM post WHERE  post_id=:id";
            $statement =  $this->getDb()->prepare($sql);
            $statement->execute(["id"=>$this->postId]);
            return !$statement->fetch()->post_published;



    }


    public function action()
    {
       return $this->checkPrivatePost();
    }
}


class OwnerComposite extends BuilderComposite implements Shortcut
{
    private string $userId;
    private string $itemId;

    public function __construct(string $userId, string $itemId)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->itemId = $itemId;
    }

    public function action()
    {
        $sql = 'SELECT p.post_id FROM post p WHERE p.post_id =:postId AND p.user_id =:id';
        $statement = Database::getInstance()->getDatabase()->prepare($sql);
        $statement->execute(["postId" => $this->itemId, "id" => $this->userId]);
        if ($statement->rowCount())
            return true;
        return false;
    }
}

class ItemExistComposite extends BuilderComposite implements Shortcut
{
    private string $postId;

    public function __construct(string $postId)
    {
        BuilderComposite::__construct();
        $this->postId = $postId;
    }

    public function action()
    {
        $sql = 'SELECT p.post_id FROM post p WHERE p.post_id =:postId';
        $statement = Database::getInstance()->getDatabase()->prepare($sql);
        $statement->execute(["postId" => $this->postId]);
        if ($statement->rowCount())
            return true;
        return false;
    }
}

class GetUserById extends  BuilderComposite implements Shortcut {
    private string $userId;
    public function __construct(string $userId)
    {
        parent::__construct();
        $this->userId = $userId;
    }

    public function action()
    {
        $sql = "SELECT u.* FROM users u WHERE id=:id";
        $statement =$this->getDb()->prepare($sql);
        $statement->execute(["id"=>$this->userId]);
        return $statement->fetch();
    }
}

class PublishCurrentyPost extends BuilderComposite implements Shortcut
{
    private bool $publish;
    private string $postId;

    public function __construct(string $postId, bool $publish)
    {
        BuilderComposite::__construct();
        $this->postId = $postId;
        $this->publish = $publish;
    }
    public function action()
    {
        $sql = "UPDATE post SET post_published=:published, post_published_at=:publishedDate WHERE post_id=:id";
        $statement = $this->getDb()->prepare($sql);
        if ($this->publish) {
            $statement->execute(["published" => '1',
                "publishedDate" => (new DateTime)->format(BuilderComposite::DATEFORMAT),
                "id" => $this->postId]);
        } else {
            $statement->execute(["published" => '0',
                "publishedDate" => NULL,
                "id" => $this->postId]);
        }
        return true;
    }
}
