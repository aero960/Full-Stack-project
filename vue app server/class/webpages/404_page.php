<?php

use language\Serverlanguage;
use RoutesMNG\Parameters;
use RoutesMNG\RouteManager;
use WebpageMNG\Page;

class page_error extends Page
{
    public function __construct(Parameters $parameters)
    {
        Parent::__construct();
        $this->parameters = new NoParameters($parameters);
    }

    public function pageContent()
    {

        return ["info"=> RouteManager::getInstance()->getRouteResponse()];
    }

    protected function Initialize(): void
    {

    }
}