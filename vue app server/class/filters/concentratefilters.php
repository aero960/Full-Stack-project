<?php

use language\Serverlanguage;

class FullFilter extends filterBuilder
{
    private array $data;
    private string $where;

    public function __construct(array $fullData)
    {
        $this->data = $fullData;
    }

    private function checkValue(string $porpName, bool $checker,$name = '', string $msg = '')
    {
        if ($porpName === "all" && !$checker) {
            $this->where = Serverlanguage::getInstance()->GetMessage("t.s");
            return false;
        }

        if ($name == $porpName && !$checker) {
            $this->where = Serverlanguage::getInstance()->GetMessage($msg);
            return false;
        }
        return true;
    }

    public function checkValues($name, $value)
    {

        $filtered = $this->checkValue("all",(strlen($value) >= 0));
        $filtered = $this->checkValue(FastActionEXT::COMMENT_ADD_CONTENT, (strlen($value) < 250), $name,"c.t.s");
        $filtered = $this->checkValue(AllParametersType::INTRO, (strlen($value) < 150), $name,"t.s");
        $filtered = $this->checkValue(AllParametersType::PROFILE, (strlen($value) < 1000), $name,"c.t.s");
        $filtered = $this->checkValue(AllParametersType::CATEGORY, (ctype_alnum($value)),$name,"n.a.s");
        $filtered = $this->checkValue(AllParametersType::USER, (ctype_alpha($value)),$name,"n.a.s");
        $filtered = $this->checkValue(AllParametersType::PAGE, (ctype_digit($value)),$name,"n.a.s");
        var_dump($name);
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
            $index = strtolower(trim(htmlspecialchars($index)));


            $namePara = trim(htmlspecialchars($name));
            if (!$this->checkValues($namePara, $index)) {
                $output = new OutputController();
                $output->setInfo("false");
                $output->setContent($this->where);
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