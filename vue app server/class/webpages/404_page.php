<?php

use language\Serverlanguage;
use RoutesMNG\RouteManager;
use WebpageMNG\Page;

class page_error extends Page
{
    public function __construct()
    {
        Parent::__construct();
        $this->parameters = new NoParameters();
    }

    public function pageContent()
    {

        return ["info"=> RouteManager::getInstance()->getRouteResponse()];
    }

    protected function Initialize(): void
    {

    }
}