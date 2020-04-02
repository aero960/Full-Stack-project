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

        if(AllParametersType::EMAIL == $name){
            $filtered =   filter_var($value,FILTER_VALIDATE_EMAIL);
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
            $index = trim(htmlspecialchars($index),'_\n\t\r\0\ \x0B');
            $namePara = trim(htmlspecialchars($name),'_\n\t\r\0\ \x0B');
            if(!$this->checkValues($namePara,$index))
            {
                echo "Dane sa niewlasciwe";
                exit();
            }

            $this->cleandedData[$namePara] = $index;
        }
        return true;
    }

    public function getValidData()
    {
        return $this->cleandedData;
    }
}