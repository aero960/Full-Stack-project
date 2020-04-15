<?php

use authentication\AuthenticationSchema;
use authentication\CategorySchema;
use authentication\ResourcesSchema;
use Helper\Helper;
use language\Serverlanguage;

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
        $this->id = $this->getRandomId("guests", "guest_id") . AuthenticationSchema::UNKNOW;
        $sql = "INSERT INTO guests SET guest_id=:id,username=:username";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->id, "username" => $this->username]);
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
        return $this->checkUserExist();
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

class GetFullUserData extends BuilderComposite implements Shortcut, FastAction
{

    private string $id;

    public function __construct(string $id)
    {
        parent::__construct();
        $this->id = $id;
    }

    private function getResourcesData()
    {

        $sql = "Select * FROM resources WHERE user_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->id]);
        return $statement;
    }

    public function action()
    {
        return $this->getResourcesData()->fetch();
    }

    public function getFastActionResponse(): FastActionDelivery
    {
        if ($this->getResourcesData()->rowCount() > 0)
            return new FastActionDelivery(true, (new ResourcesSchema($this->getResourcesData()->fetch()))->toIterate());
        return new FastActionDelivery(false, [FastActionDelivery::INFO => Serverlanguage::getInstance()->GetMessage('u.d.e')]);
    }
}

class FetchListCategoriesEXT extends BuilderComposite implements FastAction
{

    public function __construct()
    {
        parent::__construct();


    }

    private function getCategory()
    {

        $sql = "SELECT * FROM category";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    private function parseToSchema()
    {
        $notFilteres = $this->getCategory();

        array_map(function ($index) {
            return new CategorySchema($index);
        }, $notFilteres);
        return $notFilteres;
    }

    public function getFastActionResponse(): FastActionDelivery
    {

        return new FastActionDelivery(true, $this->parseToSchema());
    }
}


class GetUserById extends BuilderComposite implements Shortcut, FastAction
{
    private string $userId;

    public function __construct(string $userId)
    {
        parent::__construct();
        $this->userId = $userId;
    }

    private function chooseType(): AuthenticationSchema
    {
        $type = AuthenticationSchema::UNKNOW;
        if (preg_match("/{$type}/i", $this->userId)) {
            return AuthenticationSchema::createGuest($this->getGuestUser()->fetch()->id, $this->getGuestUser()->fetch()->username);
        }
        return new AuthenticationSchema($this->getUser()->fetch());
    }


    private function getGuestUser()
    {
        $sql = "SELECT guest_id id,username  FROM guests g WHERE guest_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->userId]);
        return $statement;
    }

    private function getUser()
    {
        $sql = "SELECT u.* FROM users u WHERE id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->userId]);
        return $statement;
    }

    public function action(): AuthenticationSchema
    {
        return $this->chooseType();
    }

    public function getFastActionResponse(): FastActionDelivery
    {
        $userData = $this->chooseType();
        return new FastActionDelivery(true, [
                "username" => $userData->getUsername(),
                "email" => $userData->getEmail(),
                "id"=>$userData->getId()]
        );
    }
}


class ReportAddEXT extends BuilderComposite implements FastAction
{

    private string $type;
    private string $message;
    public const POST_PUNISH = 'post_punish';
    private string $currenty_id;

    public function __construct(string $type, string $message)
    {
        parent::__construct();

        if (!in_array($type, [self::POST_PUNISH]))
            throw new Error("type must be definied");

        $this->type = $type;
        $this->message = $message;
    }

    private function punish()
    {
        $this->currenty_id = $this->getRandomId('reports', 'report_id');
        $sql = "INSERT INTO reports SET report_id=:id,type=:type,message=:msg";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->currenty_id, "type" => $this->type, "msg" => $this->message]);
    }

    public function getFastActionResponse(): FastActionDelivery
    {
        $this->punish();
        return new FastActionDelivery(true,
            [FastActionDelivery::INFO => Serverlanguage::getInstance()->GetMessage('t.f.r')]);
    }
}


class PostAddLikeEXT extends BuilderComposite implements FastAction
{

    private string $userId;
    private string $postId;

    public function __construct(string $userId, string $postId)
    {
        parent::__construct();
        $this->postId = $postId;
        $this->userId = $userId;
    }

    private function addLike()
    {
        $sql = "INSERT INTO post_user_like SET user_id=:user,post_id=:post";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["user" => $this->userId, "post" => $this->postId]);
    }

    private function checkUserAddLike(): bool
    {
        $sql = "SELECT * FROM post_user_like WHERE post_id=:post AND user_id=:user";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["user" => $this->userId, "post" => $this->postId]);
        return $statement->rowCount() > 0;
    }

    public function getFastActionResponse(): FastActionDelivery
    {

        if (!$this->checkUserAddLike()) {
            $this->addLike();
            return new FastActionDelivery(true, [FastActionDelivery::INFO => "A like has been added"]);
        } else
            return new FastActionDelivery(false, [FastActionDelivery::INFO => "like has already been added"]);
    }
}

class PostRemoveLikeEXT extends BuilderComposite implements FastAction
{


    public function getFastActionResponse(): FastActionDelivery
    {
        // TODO: Implement getFastActionResponse() method.
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
