<?php

use Phroute\Phroute\RouteCollector as RouteCollectorAlias;
use RoutesMNG\RouteAdministrator;

function functionToTest(){


    RouteAdministrator::getInstance()->initializeRoute(
        ["main" => new \RoutesMNG\ManipulateRoute("GET","example",new \WebpageMNG\Page()),
            "adminSection" => new \RoutesMNG\ManipulateRoute("GET","test/{item}",new \WebpageMNG\Page())
        ]);
    RouteAdministrator::getInstance()->mapRoute();

echo RouteAdministrator::getInstance()->executeRoute($_SERVER['REQUEST_METHOD'],$_SERVER['REQUEST_URI']);

}

