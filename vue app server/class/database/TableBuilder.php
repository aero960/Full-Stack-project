<?php

class TableBuilder{

    private array $cols;

    public function __construct(array $cols)
    {
            $this->cols = $cols;
    }



    public function getCols(string $name ) : array
    {
        $name = strTolower($name);

        if($this->checkExist($name))
            return [$name=>$this->cols[$name]] ;
        return ["nothing"=>"nothing"];
    }
    protected function checkExist(string $name){
            return array_key_exists($name, $this->cols);
    }

    public function getColName(string $name){
        $name = strTolower($name);
        if($this->checkExist($name))
            return $name ;
        return ["nothing"=>"nothing"];
    }
}