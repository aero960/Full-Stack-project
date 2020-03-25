<?php


namespace WebpageMNG;


use Exception;
use PageParametersSchema;
use RoutesMNG\Parameters;
use ValidateParameters;

abstract class Page extends ContextCreator
{

    private bool $active = false;
    protected ValidateParameters $parameters;

    public function getContext()
    {
        $this->createContext();
        return parent::getContext();
    }
    abstract protected function pageContent();
    protected function Initialize(){
         return false;
    }

    protected function createContext(): void
    {
        if ($this->active)
            $this->context = $this->pageContent();

    }
    public function setActivePage()
    {
        $this->active = true;
    }
    public function isActive()
    {
        return $this->active;
    }
}
abstract class ContextCreator
{
    //Tutaj nalezy sie zastanowic
    protected $context;

    abstract protected function createContext();


    public function getContext()
    {
        return $this->context;
    }
}



