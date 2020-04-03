<?php

class FullFilter extends filterBuilder
{
    private array $data;


    public function __construct(array $fullData)
    {
        $this->data = $fullData;
    }

    public function checkValues($name,$value){
        $filtered = true;
        if(FastActionEXT::COMMENT_ADD_CONTENT == $name){
            $filtered =  strlen($value)  < 250 ;
        }
        return $filtered;
    }


    public function cleanData(): bool
    {
        /*
                if($this->data["email"] && !filter_var($this->data["email"],FILTER_VALIDATE_EMAIL)){
                    echo "This isn't valid email";
                    exit();
                }*/
            $cleanedArray = [];
        foreach ($this->data as $name => $index) {
            $index = strtolower(trim(htmlspecialchars($index),'_\n\ \x0B'));


            $namePara = trim(htmlspecialchars($name),'_\n\ \x0B');
          if(!$this->checkValues($namePara,$index))
            {
                echo "Dane sa niewlasciwe";
                exit();
            }

            $this->cleandedData[$name] = $index;
        }
        return true;
    }

    public function getValidData()
    {
        return $this->cleandedData;
    }
}