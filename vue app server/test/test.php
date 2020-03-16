<?php

use Phroute\Phroute\RouteCollector as RouteCollectorAlias;
use RoutesMNG\RouteAdministrator;

function functionToTest(){

        $perRoute = new \RoutesMNG\PermissionRoute("GET","example",new Pierwsza());

    RouteAdministrator::getInstance()->initializeRoute(
        ["main" => $perRoute,
            "adminSection" => new \RoutesMNG\NormalRoute("DELETE","test/{item}",new Pierwsza())
        ]);
    RouteAdministrator::getInstance()->mapRoute();


    print_r(RouteAdministrator::getInstance()->executeRoute($_SERVER['REQUEST_METHOD'],$_SERVER['REQUEST_URI']));
}

