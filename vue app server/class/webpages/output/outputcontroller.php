<?php

class OutputController implements ViewQuery
{
    private $dataSuccess = false;
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
        $this->dataSuccess = $dataSuccess;
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
            if($index === "dataSuccess")
                $data[$index] = $allProperties;
            else
            if ($index !== "output" AND !empty($allProperties) ) {
                $data[$index] = $allProperties;
            }
        }
        $this->output = $data;

    }


    public function getView()
    {

        $this->createOutput();
        return $this->output;
        /*
                return ["success"=>$this->dataSuccess,
                    "info"=>$this->info,
                    "content"=>$this->content,
                    "multiContent"=>$this->multicontent,
                    "token"=>$this->token];*/
    }

    public function getSql(): string{}

    public function setSql(string $sql): void{}
}