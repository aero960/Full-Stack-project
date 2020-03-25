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













