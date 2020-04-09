<?php

use authentication\AuthenticationSchema;
use authentication\ResourcesSchema;

class AuthenticationQueryDecorator implements QueryComposite
{
    protected QueryComposite $composer;

    public function __construct(QueryComposite $composer)
    {
        $this->composer = $composer;
    }

    public function action() : bool
    {
        return  $this->composer->action();
    }

    function fetchData()
    {
        return new AuthenticationSchema($this->composer->fetchData());
    }
}

class PostQueryDecorator implements QueryComposite
{
    protected QueryComposite $composer;
    public function __construct(QueryComposite $composer)
    {
        $this->composer = $composer;
    }
    public function action() : bool
    {
        return  $this->composer->action();
    }
    function fetchData()
    {

        return new PostSchema($this->composer->fetchData());
    }
}

class QueryDecoratorUserSchema implements QueryComposite{
    protected QueryComposite $composer;
    public function __construct(QueryComposite $composer)
    {
        $this->composer = $composer;
    }
    function action(): bool
    {
        return  $this->composer->action();
    }

    function fetchData() : ResourcesSchema
    {
        return new ResourcesSchema($this->composer->fetchData());
    }
}