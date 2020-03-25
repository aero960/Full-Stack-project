<?php

use language\Serverlanguage;
use RoutesMNG\RouteManager;
use WebpageMNG\Page;

class page_error extends Page
{

    public function __construct()
    {
        $this->parameters = new NoParameters();
    }
    protected function pageContent()
    {

        return ["info"=> RouteManager::getInstance()->getRouteResponse()];
    }

}