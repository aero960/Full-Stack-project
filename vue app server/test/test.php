<?php


use RoutesMNG\NormalRoute;
use RoutesMNG\Parameters;
use RoutesMNG\PermissionRoute;
use RoutesMNG\RouteManager;
use ServerMNG\serverMessage;


function functionToTest()
{




        //dodac obiekt autentykacja
    $paraHandler = new Parameters();
    $paraHandler->setRequest($_REQUEST);
    $page = new Register($paraHandler);
    $register = new NormalRoute("POST", "register", $page, $paraHandler);

    RouteManager::getInstance()->initializeRoute([$register]);

    RouteManager::getInstance()->executeRoute();
    serverMessage::send("Content",RouteManager::getInstance()->getActivePage()->getContext());



   // $content = new \converter\contentConverter();
  //  $content->getContent();
}

