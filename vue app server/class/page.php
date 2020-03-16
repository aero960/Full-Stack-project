<?php


namespace WebpageMNG;


abstract class Page extends ContextCreator
{
    public bool $active = false;
    protected array $parameters;

    public function __construct()
    {
        EventsManager::getInstance()->on('contextGet', [$this, 'OnContextGetRoute']);
    }


    protected abstract  function pageContent ();



    public function OnContextGetRoute($params)
    {
        if ($this->active) {
            $this->parameters = $params;
            $this->pageContent();
        }
    }

    public function activeClass()
    {
        $this->active = true;
    }
}


class ContextCreator
{
    private array $context = [];

    protected function createContext($context)
    {
        $this->context[] = $context;
    }

    public function getContext()
    {
        return $this->context;
    }
}


