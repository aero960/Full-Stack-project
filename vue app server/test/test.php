<?php


use authentication\Authentication;
use Firebase\JWT\JWT;
use language\Serverlanguage;
use RoutesMNG\NormalRoute;
use RoutesMNG\Parameters;
use RoutesMNG\PermissionRoute;
use RoutesMNG\RouteManager;
use ServerMNG\serverMessage;
use WebpageMNG\testpremmision;


function functionToTest()
{

    //inne jezyki jeszcze nie sa stworzone
    Serverlanguage::getInstance()->changeLanguage(AvaiableLanguages::ENG);



    Authentication::getInstance()->AuthenticateUser();




    //dodac obiekt autentykacja
    $paraHandler = new Parameters();


    $paraHandler->setRequestParameters($_REQUEST);
    $pageRegister = new AuthenticateDecorator(new ParametersDecorator(new RegisterPage($paraHandler)));
    $pageLogin = new AuthenticateDecorator(new ParametersDecorator(new LoginPage($paraHandler)));
    $premmisionTest = new ParametersDecorator(new testpremmision($paraHandler));
    $routeDefault = new page_error();


    $register = new NormalRoute("POST", "register", $pageRegister, $paraHandler);
    $login = new NormalRoute("POST","login",$pageLogin,$paraHandler);
    $premmision = new PermissionRoute("GET","example",$premmisionTest,$paraHandler,["PermissionChecker","checkNormalUserAuth"]);



    RouteManager::getInstance()->initializeRoute([$register,$login,$premmision],$routeDefault);

    RouteManager::getInstance()->executeRoute();

  print_r(RouteManager::getInstance()->getActivePage()->getContext());


    // $content = new \converter\contentConverter();
    //  $content->getContent();
}

