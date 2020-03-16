<?php


namespace WebpageMNG;





class Page extends  ContextCreator
{
    public function __construct(string $text)
    {
        $this->createContext($text);
    }
}


class ContextCreator{
    protected function createContext(string $context)
    {
        $this->context = $context;
    }
    private  string $context;

    public function getContext(){
        return $this->context;
    }
}


