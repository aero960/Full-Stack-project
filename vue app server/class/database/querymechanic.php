<?php


interface QueryComposite
{
    function action(): bool;

    function fetchData();
}

abstract class BuilderComposite
{
    public function __construct($instance)
    {
        $this->instance = $instance;
        $this->db = Database::getInstance()->getDatabase();
    }

    protected $instance;
    protected PDO $db;
}





class RegisterGenerator extends QueryComposer
{
    public function __construct()
    {
        QueryComposer::__construct();
    }

    public function Register(string $username, string $password, string $email)
    {
        $this->fetcherComposite = new registerComposite($this, $username, $password, $email);
        $this->createUserAccount();

    }

    private function createUserAccount()
    {
        $this->beginTransaction();
        if ($this->action())
            $this->commitChanges();
    }
}



class LoginGenerator extends QueryComposer
{

    public function __construct()
    {
        QueryComposer::__construct();
    }

    public function LoginData( string $username, string $password, string $email)
    {
        $this->fetcherComposite = new LoginComposite($this, $username,  $password,  $email);
    }

    public function LoginUserAccount()
    {
        $this->beginTransaction();
        if ($this->action()){
            $this->commitChanges();
            return true;
        }
        return false;

    }

}






