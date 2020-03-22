<?php

use Helper\Helper;


class Database
{
    private static $instance;

    private PDO $db;
    private array $databaseInitializeInfo;

    public function __construct()
    {
        $this->databaseInitializeInfo = Helper::getIniConfiguration("db");
        $this->db = new PDO("mysql:host={$this->databaseInitializeInfo["host"]};dbname={$this->databaseInitializeInfo["name"]}",
                                $this->databaseInitializeInfo["user"], $this->databaseInitializeInfo['password']);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getDatabase()
    {
        return $this->db;
    }

    public static function getInstance(): Database
    {
        return static::$instance ?: static::$instance = new static();
    }

}


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
    protected function getData()
    {
        return $this->fetcherComposite->fetchData();
    }
}

interface QueryComposite
{
    function action(): bool;

    function fetchData();
}

class registerComposite implements QueryComposite
{
    private $instance;
    private PDO $db;
    private string $userName;
    private string $password;
    private string $email;
    private $id = null;

    public function __construct($instance, string $userName, string $password, string $email)
    {
        $this->instance = $instance;
        $this->db = Database::getInstance()->getDatabase();

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


    function fetchData()
    {
        $statement = $this->db->prepare("SELECT u.*, r.money FROM users u LEFT JOIN resources r on u.id = r.user_id WHERE u.id = :id");
        $statement->execute(["id" => $this->id]);
        return $statement->fetchAll();
    }
}


class QueryGenerator extends QueryComposer
{
    public function __construct(string $userName, string $password, string $email)
    {
        QueryComposer::__construct();
        $this->fetcherComposite = new registerComposite($this, $userName, $password, $email);
    }

    public function createUserAccount()
    {
        $this->beginTransaction();
        if($this->action())
        $this->commitChanges();
    }

    public function getData()
    {
        return parent::getData();
    }


}

