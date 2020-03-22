<?php


use Firebase\JWT\JWT;
use RoutesMNG\NormalRoute;
use RoutesMNG\Parameters;
use RoutesMNG\PermissionRoute;
use RoutesMNG\RouteManager;
use ServerMNG\serverMessage;


function functionToTest()
{
    TableManager::getInstance()->addTable("users", new TableBuilder([
        "username" => "string",
        "password" => "string",
        "email" => "string",
        "id" => ["primary key", "int"]
    ]));
    TableManager::getInstance()->getTableView();

        $test = new QueryGenerator("rysiek wola boża","mariuszek bez zebuszek","cykorek");







    //dodac obiekt autentykacja
    $paraHandler = new Parameters();
    $paraHandler->setRequest($_REQUEST);
    $page = new RegisterPage($paraHandler);
    $register = new NormalRoute("POST", "register", $page, $paraHandler);

    RouteManager::getInstance()->initializeRoute([$register]);

    RouteManager::getInstance()->executeRoute();
    serverMessage::send("Content", RouteManager::getInstance()->getActivePage()->getContext());


    // $content = new \converter\contentConverter();
    //  $content->getContent();
}

