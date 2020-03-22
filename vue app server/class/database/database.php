<?php

use Helper\Helper;


class Database{
    private static $instance;

    private PDO $db;
    private array $databaseInitializeInfo;
    public function __construct()
    {
        $this->databaseInitializeInfo = Helper::getIniConfiguration("db");
        $this->db = new PDO("mysql:host={$this->databaseInitializeInfo["host"]};dbname={$this->databaseInitializeInfo["name"]}",
            $this->databaseInitializeInfo["user"], $this->databaseInitializeInfo['password']);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
    public function getDatabase(){
        return $this->db;
    }

    public static function getInstance(): Database
    {
        return static::$instance ?: static::$instance = new static();
    }

}


abstract class  QueryComposer
{
    protected PDO $db;
    protected QueryComposite $fetcherComposite;

    public function __construct()
    {
        $db = Database::getInstance()->getDatabase();
    }

    protected function beginTransaction(){
        if(!$this->db->inTransaction())
            $this->db->beginTransaction();
    }

    protected function action()
    {
        if($this->db->inTransaction() && !$this->fetcherComposite->action())
           $this->db->rollBack();
    }
    protected function commitChanges(){
        $this->db->commit();
    }


    //use this in case Select
    protected function getData(){
            $this->fetcherComposite->fetchData();
    }
}
interface QueryComposite
{
    function action() : bool;
    function fetchData();
}

class registerComposite implements QueryComposite {
    private $instance;
    private PDO $db;
    private string $userName;
    private string $password;
    private string $email;
    private string $sql;
    private $id = null;
    public function __construct($instance,string $userName,string $password,string $email)
    {
        $this->instance = $instance;
        $this->db = Database::getInstance()->getDatabase();
        $this->sql = 'INSERT INTO users(id, username, password, email) VALUES (?,?,?,?)';
    }

    public  function checkExistId(string $searchedId) : bool{

        $id = TableManager::getInstance()->getTable("users")->getColName("id");
        $table = TableManager::getInstance()->getTableName("users");

        $sql = vsprintf('SELECT u.%1$s FROM %2$s u WHERE u.%1$s = %3$s',[$id,$table,$searchedId]);
        $statement = $this->db->query($sql);
        return $statement->rowCount();
    }
    function action(): bool
    {

        try{


            $this->id = ""

            $this->db->prepare($this->sql);

            return true;
        }catch(Exception $e){
            return false;
        }
    }

    function fetchData()
    {

    }
}


class QueryGenerator extends QueryComposer {

        public function __construct(string $userName,string $password,string $email)
        {
            QueryComposer::__construct();
            $registerTest = new registerComposite($this, $userName, $password, $email);

            var_dump($registerTest->checkExistId(325));
            $this->fetcherComposite = $registerTest;

        }
}

