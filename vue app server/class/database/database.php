<?php

use Helper\Helper;
use language\Serverlanguage;
use RoutesMNG\RouteManager;


class Database
{
    private static $instance;

    private PDO $db;
    private array $databaseInitializeInfo;

    public function __construct()
    {
        $this->databaseInitializeInfo = Helper::getIniConfiguration("db");
        try{
            $this->db = new PDO("mysql:host={$this->databaseInitializeInfo["host"]};dbname={$this->databaseInitializeInfo["name"]}",
                $this->databaseInitializeInfo["user"], $this->databaseInitializeInfo['password']);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            header('HTTP/1.0 404 Not Found');
            echo Serverlanguage::getInstance()->GetMessage("database.error");
         exit;
        }
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













