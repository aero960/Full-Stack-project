<?php

class OutputController implements ViewQuery
{


    public const  DATASUCCESS = "datasuccess";
    public const  OUTPUT = "output";
    private $datasuccess = false;
    private $info = false;
    private $content = false;
    private $multicontent = [];
    private $token = false;


    private array $output = [];

    public function setInfo($info): void
    {
        $this->info = $info;
    }

    public function setDataSuccess($dataSuccess): void
    {
        $this->datasuccess = $dataSuccess;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function setMulticontent(Iterator $multicontent) : void
    {


        foreach ($multicontent as $key =>$index){


            $this->multicontent[] =$index;
        }
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    private function createOutput()
    {

        $data = [];
        foreach (get_object_vars($this) as $index => $allProperties) {
            if($index === self::DATASUCCESS){
                $data[$index] = $allProperties;
                if(!$allProperties)
                    http_response_code(404  );
            }
            else
            if ($index !== self::OUTPUT AND !empty($allProperties) ) {
                $data[$index] = $allProperties;
            }
        }
        $this->output = $data;

    }


    public function getView()
    {

        $this->createOutput();
        return $this->output;
    }
}