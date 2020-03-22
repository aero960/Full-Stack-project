<?php


class TableManager
{
    private static $instance;
    private array $databaseView = [];


    public static function getInstance(): TableManager
    {
        return static::$instance ?: static::$instance = new static();
    }


    public function addTable(string $name , TableBuilder $table){
        $this->databaseView[$name] = $table;
    }




    public function getTableView(){
        var_dump($this->databaseView);
    }
    public function getTable(string $name)
    {
        $name = strTolower($name);

        if(array_key_exists($name,$this->databaseView))
        return $this->databaseView[$name];
        return ['nothing' =>['nothing']];
    }
    public function getTableName(string $name){

        $name = strTolower($name);

        if(array_key_exists($name,$this->databaseView))
            return $name;
        return ['nothing' =>['nothing']];
    }
}