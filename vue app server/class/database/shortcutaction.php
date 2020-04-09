<?php

use authentication\AuthenticationSchema;
use Helper\Helper;

interface Shortcut
{
    public function action();
}


class PrivatePostComposite extends BuilderComposite implements Shortcut
{

    private string $userId;
    private string $postId;

    public function __construct($userId, $postId)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->postId = $postId;
    }

    private function checkPrivatePost()
    {
        $sql = "SELECT post_published FROM post WHERE  post_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->postId]);
        return !$statement->fetch()->post_published;


    }


    public function action()
    {
        return $this->checkPrivatePost();
    }
}

class PunishUser extends BuilderComposite implements Shortcut
{

    private string $userId;
    private string $currentyPunishId;
    private string $reason;

    public function __construct(string $userId, string $reason)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->reason = $reason;
    }

    private function chooseUser()
    {
        $guestUserIdentifier = AuthenticationSchema::UNKNOW;
        if (preg_match("/{$guestUserIdentifier}/i", $this->userId))
            return (new DeleteGuestAccount($this->userId))->action();

        $this->currentyPunishId = $this->getRandomId("naughty_users", "ng_id");
        $sql = "INSERT INTO naughty_users SET user_id=:userId,ng_id=:id,reason=:content";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["userId" => $this->userId, "id" => $this->currentyPunishId, "content" => $this->reason]);

    }

    public function action()
    {
        $this->chooseUser();
    }
}

class DeleteGuestAccount extends BuilderComposite implements Shortcut
{
    private string $userId;

    public function __construct(string $userId)
    {
        parent::__construct();
        $this->userId = $userId;
    }

    private function deleteGuestAccount()
    {
        $sql = "DELETE FROM guests WHERE guest_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->userId]);
    }

    public function action()
    {
        $this->deleteGuestAccount();
    }
}


class CreateGuest extends BuilderComposite implements Shortcut
{

    private string $username;
    private string $id;

    public function __construct(string $username)
    {
        parent::__construct();
        $this->username = $username;
    }

    public function getCreatedID()
    {
        return $this->id;
    }

    private function createGuest()
    {
        $this->id = $this->getRandomId("guests", "guest_id");
        $sql = "INSERT INTO guests SET guest_id=:id,username=:username";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->id . "UNKNOW", "username" => $this->username]);
    }


    public function action()
    {
        $this->createGuest();
    }
}

class UserExist extends BuilderComposite implements Shortcut
{

    private string $userId;

    public function __construct(string $userId)
    {
        parent::__construct();
        $this->userId = $userId;

    }

    private function checkUserExist()
    {
        $sql = "SELECT id FROM users WHERE id='{$this->userId}'";
        $statement = $this->getDb()->query($sql);
        return $statement->rowCount();
    }

    public function action()
    {
       return  $this->checkUserExist();
    }
}


class OwnerComposite extends BuilderComposite implements Shortcut
{
    private string $userId;
    private string $itemId;
    private string $table;
    private string $idName;

    public function __construct(string $userId, string $itemId, string $table, string $idName)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->table = $table;
        $this->idName = $idName;
    }

    public function action()
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->idName}=:itemId AND user_id =:userId";
        $statement = Database::getInstance()->getDatabase()->prepare($sql);
        $statement->execute(["itemId" => $this->itemId, "userId" => $this->userId]);
        if ($statement->rowCount())
            return true;
        return false;
    }
}


class ItemExistComposite extends BuilderComposite implements Shortcut
{
    private string $id;
    private string $table;
    private string $idName;

    public function __construct(string $id, $table, $idName)
    {
        BuilderComposite::__construct();
        $this->table = $table;
        $this->id = $id;
        $this->idName = $idName;
    }

    public function action()
    {
        $sql = "SELECT * FROM {$this->table}  WHERE {$this->idName}=:id";
        $statement = Database::getInstance()->getDatabase()->prepare($sql);
        $statement->execute(["id" => $this->id]);
        if ($statement->rowCount())
            return true;
        return false;
    }
}

class GetUserById extends BuilderComposite implements Shortcut, \FastAction
{
    private string $userId;

    public function __construct(string $userId)
    {
        parent::__construct();
        $this->userId = $userId;
    }

    private function getUser(){
        $sql = "SELECT u.* FROM users u WHERE id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->userId]);
        return $statement;
    }

    public function action()
    {
        return $this->getUser()->fetch();
    }

    public function getFastActionResponse()
    {
        return  ["userdata" => (new AuthenticationSchema($this->getUser()->fetch()))->toIterate()];
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
