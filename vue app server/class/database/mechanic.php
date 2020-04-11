<?php


use authentication\AuthenticationSchema;
use Helper\Helper;


interface Composer
{
    public function action();
    public function getData();
}
abstract class BuilderComposite
{
    public const  DATEFORMAT = "Y-m-d H:i:s";
    public const  UPDATEDTIMEFORMAT = "y:%y,m:%m,d:%d,h:%h,m:%i,s:%s";

    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getDatabase();
    }


    private function checkExistId(string $searchedId, string $tableName, string $idName): bool
    {
        $sql = "SELECT {$idName} FROM {$tableName} u WHERE {$idName} = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["id" => $searchedId]);
        return $stmt->rowCount();
    }

    protected function getDb()
    {
        return $this->db;
    }

    protected function getRandomId(string $tableName, string $idName)
    {
        $id = Helper::randomId();
        while ($this->checkExistId($id, $tableName, $idName))
            $id = Helper::randomId();
        return $id;
    }

    protected function checkValueExist(string $table,string $colName,string $value) : bool
    {

        $sql = "SELECT * FROM {$table}  WHERE {$colName}=:value";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["value"=>$value]);
        return $statement->rowCount();
    }
}


class UserRegisterComposite extends BuilderComposite implements QueryComposite
{
    private string $userName;
    private string $password;
    private string $email;
    private $id = null;

    public function __construct( string $userName, string $password, string $email)
    {
        BuilderComposite::__construct();

        $this->userName = $userName;
        $this->password = $password;
        $this->email = $email;

    }

    private function checkEmailExist()
    {
        $sql = 'SELECT u.email FROM users u WHERE u.email=:email OR u.username =:username';
        $statement = $this->db->prepare($sql);
        $statement->execute(["email" => $this->email, "username" => $this->userName]);
        if ($statement->rowCount())
            return true;
        return false;
    }

    protected function addUser()
    {
        $this->id = $this->getRandomId("users", "id");
        $sql = 'INSERT INTO users SET id = :id,
                                      username =:name,
                                      password = :password,
                                      email = :email,
                                      registeredAt = :creatingDate,
                                      lastLogin = :lastLogin';
        $statement = $this->db->prepare($sql);
        $statement->execute(["id" => $this->id,
            "name" => $this->userName,
            "password" => $this->password,
            "email" => $this->email,
            "creatingDate" => (new DateTime())->format(self::DATEFORMAT),
            "lastLogin" => (new DateTime())->format(self::DATEFORMAT)]);
        return true;

    }

    protected function addResources()
    {
        $idResource = $this->getRandomId("resources", "resources_id");
        $sql = 'INSERT INTO resources SET  resources_id = :id,
                                                user_id = :userid';
        $statement = $this->db->prepare($sql);
        $statement->execute(["id" => $idResource,
            "userid" => $this->id]);
        return true;
    }

    function action(): bool
    {

        if (!$this->checkEmailExist())
            return $this->addUser() && $this->addResources();
        return false;
    }

    function userChosen()
    {
        return $this->id !== null;
    }


    function fetchData()
    {
        $statement = $this->db->prepare("SELECT u.*, r.* FROM users u LEFT JOIN resources r on u.id = r.user_id WHERE u.id = :id");
        $statement->execute(["id" => $this->id]);
        return $statement->fetch();
    }
}


class UserLoginComposite extends BuilderComposite implements QueryComposite
{

    private string $username;
    private string $password;
    private string $email;
    public DateTime $lastLogin;
    private string $id;
    private LoginGenerator $instance;

    public function __construct($instance, string $username, string $password, string $email)
    {
        BuilderComposite::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->instance = $instance;
    }

    private function getLastLoginBeforeUpdate()
    {
        $sql = 'SELECT u.lastLogin FROM users u WHERE u.id = :id';
        $statement = $this->db->prepare($sql);
        $statement->execute(["id" => $this->id]);
        try {
            $this->lastLogin = new DateTime($statement->fetch()->lastLogin);
        } catch (Exception $e) {
            $this->lastLogin = new DateTime();
        }
        $this->instance->setLastLogin($this->lastLogin);
    }
    private function updateLastLogin()
    {
        $this->getLastLoginBeforeUpdate();
        $sql = 'UPDATE users u SET u.lastLogin = :date WHERE u.id  = :id';
        $statement = $this->db->prepare($sql);
        $statement->execute(["date" => (new DateTime())->format(self::DATEFORMAT), "id" => $this->id]);
    }
    private function getUser()
    {
        $sql = 'SELECT u.id FROM users u WHERE 
             (u.username IN (SELECT p.username FROM users p WHERE p.username = :username)
                OR u.email  IN (SELECT k.email FROM users k WHERE k.email = :email)) AND u.password = :password LIMIT 0,1';
        $statement = $this->db->prepare($sql);
        $statement->execute(["username" => $this->username,
            "email" => $this->email,
            "password" => $this->password]);
        return $statement;
    }

    private function userExist()
    {
        return $this->getUser()->rowCount();
    }

    private function LoginUser()
    {
        if ($this->userExist()) {
            $this->id = $this->getUser()->fetch(PDO::FETCH_ASSOC)["id"];
            $this->updateLastLogin();
            return true;
        }
        return false;
    }

    function action(): bool
    {
        return $this->LoginUser();
    }

    public function fetchData()
    {
        $statement = $this->db->prepare("SELECT u.*,r.* FROM users u LEFT JOIN resources r on u.id = r.user_id WHERE u.id = :id");
        $statement->execute(["id" => $this->id]);
        return $statement->fetch();
    }
}

class UserUpdateComposite extends BuilderComposite implements QueryComposite
{

    private $id;
    private string $firstname;
    private string $lastname;
    private string $mobile;
    private string $intro;
    private string $profile;
    private string $image;

    public function __construct( $id, string $firstname, string $lastname, string $mobile, string $intro, string $profile, string $image)
    {
        BuilderComposite::__construct();
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->mobile = $mobile;
        $this->intro = $intro;
        $this->profile = $profile;
        $this->image = $image;
    }

    private function updateProfile()
    {
        $sql = 'UPDATE resources SET firstName=:firstName,LastName=:lastName,mobile=:mobile,intro=:intro,profile=:profile,image=:image,date_of_update=:dataUpdate WHERE user_id=:id';
        $statement = $this->db->prepare($sql);
        $statement->execute([UpdateProfileParammeters::FIRSTNAME => $this->firstname,
            UpdateProfileParammeters::LASTNAME => $this->lastname,
            UpdateProfileParammeters::MOBILE => $this->mobile,
            UpdateProfileParammeters::INTRO => $this->intro,
            UpdateProfileParammeters::PROFILE => $this->profile,
            UpdateProfileParammeters::IMAGE => $this->image,
            "dataUpdate" => (new DateTime())->format(self::DATEFORMAT),
            "id" => $this->id]);
        return true;
    }

    function action(): bool
    {
        return $this->updateProfile();
    }

    function fetchData()
    {
        $statement = $this->db->prepare("SELECT u.*,r.* FROM users u LEFT JOIN resources r on u.id = r.user_id WHERE u.id = :id");
        $statement->execute(["id" => $this->id]);
        return $statement->fetch();
    }
}

abstract class PostComposite extends BuilderComposite implements QueryComposite
{
    protected string $postId;

    public function __construct()
    {
        parent::__construct();
    }

    abstract protected function postAction();

    protected function chooseId(string $postId)
    {
        $this->postId = $postId;
    }

    function action(): bool
    {
        return $this->postAction();
    }

    function fetchData()
    {
        $statement = $this->db->prepare("SELECT p.*,u.* FROM users u LEFT JOIN post p on u.id = p.user_id WHERE p.post_id = :id");
        $statement->execute(["id" => $this->postId]);
        return $statement->fetch();
    }
}

class PostPublisher extends PostComposite {

    private bool $publish;
    public function __construct(string $postId,bool $publish)
    {
        parent::__construct();
        $this->chooseId($postId);
        $this->publish = $publish;
    }

    protected function postAction()
    {
       return  (new PublishCurrentyPost($this->postId,$this->publish))->action();
    }


}


class PostDeleter extends PostComposite
{
    private $postBeforeDelete;

    public function __construct( string $postId)
    {
        parent::__construct();
        $this->chooseId($postId);
        $this->getPostBeforeDelete();
    }

    private function getPostBeforeDelete()
    {
        $sql = 'SELECT p.* FROM post p WHERE p.post_id = :id';
        $statement = $this->db->prepare($sql);
        $statement->execute(["id" => $this->postId]);
            $this->postBeforeDelete = $statement->fetch();
    }

    protected function postAction()
    {
        $sql = 'DELETE FROM post  WHERE post_id =:id';
        $statement = $this->getDb()->prepare($sql);
        $statement->execute(["id" => $this->postId]);
        return true;
    }

    public function fetchData()
    {
        return $this->postBeforeDelete;
    }
}


class PostCreator extends PostComposite
{
    protected string $creatorId;
    protected string $title;
    protected string $content;
    public function __construct( string $id, string $title, string $content)
    {
        parent::__construct();
        $this->creatorId = $id;
        $this->title = $title;
        $this->content = $content;
    }
    protected function postAction()
    {
        $sql = 'INSERT INTO post SET post_id=:id,
                                     user_id=:userId, 
                                     post_title=:title,
                                     post_create_at=:dateCreation,
                                     post_updated_at=:dateUpdated,
                                     post_content=:content';
        $statement = $this->getDb()->prepare($sql);
        $this->chooseId($this->getRandomId('post', 'post_id'));
        $statement->execute([
            "id" => $this->postId,
            "userId" => $this->creatorId,
            "title" => $this->title,
            "dateCreation" => (new DateTime())->format(BuilderComposite::DATEFORMAT),
            "dateUpdated" => (new DateTime())->format(BuilderComposite::DATEFORMAT),
            "content" => $this->content
        ]);
        return true;
    }
}

class PostUpdater extends PostComposite
{
    public DateTime $lastLogin;
    protected string $creatorId;
    protected string $title;
    protected string $content;

    public function __construct( string $id, string $title, string $content, string $postId)
    {
        parent::__construct();
        $this->creatorId = $id;
        $this->title = $title;
        $this->content = $content;
        $this->chooseId($postId);
        $this->getLastUpdateTime();

    }

    private function getLastUpdateTime()
    {
        $sql = 'SELECT p.post_updated_at FROM post p WHERE p.post_id = :id';
        $statement = $this->db->prepare($sql);
        $statement->execute(["id" => $this->postId]);
        try {
            $this->lastLogin = new DateTime($statement->fetch()->post_updated_at);
        } catch (Exception $e) {
            $this->lastLogin = new DateTime();
        }
    }

    protected function postAction()
    {
        $sql = "UPDATE post SET post_title=:title,post_content=:content,post_updated_at=:updateDate WHERE post_id=:id";
        $statement = $this->getDb()->prepare($sql);
        $statement->execute([
            "id" => $this->postId,
            "title" => $this->title,
            "content" => $this->content,
            "updateDate" => (new DateTime)->format(BuilderComposite::DATEFORMAT)
        ]);
        return true;
    }
}


