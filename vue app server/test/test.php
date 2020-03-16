<?php

use Phroute\Phroute\RouteCollector as RouteCollectorAlias;
use RoutesMNG\RouteAdministrator;
use ServerMNG\serverMessage;

function functionToTest(){

        $perRoute = new \RoutesMNG\PermissionRoute("GET","example",new Pierwsza(),fn()=>serverMessage::errorMessage());

    RouteAdministrator::getInstance()->initializeRoute(
        ["main" => $perRoute,
            "adminSection" => new \RoutesMNG\NormalRoute("GET","test/{item}",new Pierwsza())
        ]);
    RouteAdministrator::getInstance()->mapRoute();


    print_r( RouteAdministrator::getInstance()->executeRoute($_SERVER['REQUEST_METHOD'],$_SERVER['REQUEST_URI']) );
}

