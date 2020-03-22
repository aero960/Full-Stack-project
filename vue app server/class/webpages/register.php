<?php


use RoutesMNG\Parameters;
use WebpageMNG\Page;

class Register extends Page
{


    public function __construct(Parameters $parameters = null)
    {
        parent::__construct($parameters);
    }


    protected function pageContent()
    {
        return "there is regiter new user";
    }
}