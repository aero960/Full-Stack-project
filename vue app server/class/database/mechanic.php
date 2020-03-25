<?php


use authentication\AuthenticationSchema;
use Helper\Helper;

abstract class  QueryComposer
{
    protected ?PDO $db;
    protected QueryComposite $fetcherComposite;

    public function __construct()
    {
        $this->db = Database::getInstance()->getDatabase();
    }

    protected function beginTransaction()
    {

        if (!$this->db->inTransaction())
            $this->db->beginTransaction();

    }

    protected function action()
    {
        $isOkay = $this->fetcherComposite->action();
        if ($this->db->inTransaction() && !$isOkay) {
            $this->db->rollBack();
            return false;
        }
        return true;
    }

    protected function commitChanges()
    {
        $this->db->commit();
    }

    //use this in case Select
    public function getData()
    {
        return $this->fetcherComposite->fetchData();
    }
}



class registerComposite extends BuilderComposite implements QueryComposite
{

    private string $userName;
    private string $password;
    private string $email;
    private $id = null;

    public function __construct($instance, string $userName, string $password, string $email)
    {
        BuilderComposite::__construct($instance);

        $this->userName = $userName;
        $this->password = $password;
        $this->email = $email;

    }

    protected function checkExistId(string $searchedId, string $tableName, string $idName): bool
    {
        $sql = "SELECT {$idName} FROM {$tableName} u WHERE {$idName} = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["id" => $searchedId]);
        return $stmt->rowCount();
    }

    private function getRandomId(string $tableName, string $idName)
    {
        $id = Helper::randomId();
        while ($this->checkExistId($id, $tableName, $idName))
            $id = Helper::randomId();
        return $id;
    }

    protected function addUser()
    {
        $this->id = $this->getRandomId("users", "id");
        $sql = 'INSERT INTO users SET id = :id,
                                      username =:name,
                                      password = :password,
                                      email = :email';

        $statement = $this->db->prepare($sql);
        $statement->execute(["id" => $this->id, "name" => $this->userName, "password" => $this->password, "email" => $this->email]);
        return true;

    }

    protected function addResources()
    {
        if ($this->userChosen()) {

            $idResource = $this->getRandomId("resources", "id");

            $sql = 'INSERT INTO resources SET  id = :id,
                                                money =  :money, 
                                                user_id = :userid';

            $statement = $this->db->prepare($sql);
            $statement->execute(["id" => $idResource,
                "money" => 0,
                "userid" => $this->id]);
            return true;
        }
    }

    function action(): bool
    {
        return $this->addUser() && $this->addResources();
    }

    function userChosen()
    {
        return $this->id !== null;
    }


    function fetchData() : AuthenticationSchema
    {
        $statement = $this->db->prepare("SELECT u.*, r.money FROM users u LEFT JOIN resources r on u.id = r.user_id WHERE u.id = :id");
        $statement->execute(["id" => $this->id]);
        $userData =  $statement->fetch();

        return new AuthenticationSchema($userData);
    }
}


class LoginComposite extends BuilderComposite implements QueryComposite
{

    private string $username;
    private string $password;
    private string $email;
    private string $id;

    public function __construct($instance, string $username, string $password, string $email)
    {
        BuilderComposite::__construct($instance);
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
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
            return true;
        }
        return false;
    }

    function action(): bool
    {
        return $this->LoginUser();
    }

    public function fetchData() : AuthenticationSchema
    {
        $statement = $this->db->prepare("SELECT u.*, r.money FROM users u LEFT JOIN resources r on u.id = r.user_id WHERE u.id = :id");
        $statement->execute(["id" => $this->id]);
        $userData = $statement->fetch();
        return new AuthenticationSchema($userData);
    }
}
