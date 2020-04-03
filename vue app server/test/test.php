<?php

use authentication\Authentication;
use converter\contentConverter;
use language\Serverlanguage;
use RoutesMNG\NormalRoute;
use RoutesMNG\Parameters;
use RoutesMNG\PermissionRoute;
use RoutesMNG\RouteListManagment;
use RoutesMNG\RouteManager;
use WebpageMNG\PostCreate;
use WebpageMNG\PostDelete;
use WebpageMNG\PostPublish;
use WebpageMNG\PostUpdate;

function testing()
{

}


function functionToTest()
{
    testing();

    //inne jezyki jeszcze nie sa stworzone
    Serverlanguage::getInstance()->changeLanguage(AvaiableLanguages::ENG);
    Authentication::getInstance()->AuthenticateUser();
    $cleandData = new FullFilter($_REQUEST);
    $cleandData->cleanData();
    //dodac obiekt autentykacja
    $paraHandler = new Parameters();
    $paraHandler->setRequestParameters($cleandData->getValidData());

    $pageRegister = new AuthenticateDecorator(new ParametersDecorator(new Register($paraHandler)));
    $pageLogin = new AuthenticateDecorator(new ParametersDecorator(new Login($paraHandler)));
    $updateProfile = new ParametersDecorator(new Updateprofile($paraHandler));
    $updatePosts = new ParametersDecorator(new PostOwnerDecorator(new PostUpdate($paraHandler)));
    $creatPosts = new ParametersDecorator(new PostCreate($paraHandler));
    $deletePosts = new ParametersDecorator(new PostOwnerDecorator(new PostDelete($paraHandler)));
    $showPosts = new PostView($paraHandler);
    $showSpecificPosts = new PrivatePostOwner(new PostSpecificView($paraHandler));
    $publishPosts = new ParametersDecorator(new PostOwnerDecorator(new PostPublish($paraHandler)));

    $fastAction = new ParametersDecorator(new FastActionEXT($paraHandler));

    $routeDefault = new page_error($paraHandler);



    //route section

    $register = new NormalRoute("POST", "register", $pageRegister, $paraHandler);
    $login = new NormalRoute("POST", "login", $pageLogin, $paraHandler);
    $updateProfile = new PermissionRoute("POST", "updateprofile", $updateProfile, $paraHandler);
    $createPostRoute = new PermissionRoute("POST", "createpost", $creatPosts, $paraHandler, [[PermissionChecker::CHECKER, PermissionChecker::ADMINAUTH]]);
    $updatePostRoute = new PermissionRoute("POST", "updatepost/{postid:a}", $updatePosts, $paraHandler,
        [[PermissionChecker::CHECKER, PermissionChecker::ADMINAUTH]]);
    $deletePostsRoute = new PermissionRoute("POST", "delete/{postid:a}", $deletePosts, $paraHandler,
        [[PermissionChecker::CHECKER, PermissionChecker::ADMINAUTH]]);
    $showPostsRoute = new NormalRoute("GET", "showposts", $showPosts, $paraHandler);
    $showSpecificPostsRoute = new NormalRoute("GET", "showposts/{postid:a}", $showSpecificPosts, $paraHandler);
    $publishPosts = new PermissionRoute("POST", "publish/{postid:a}", $publishPosts, $paraHandler);

    $fastAction = new NormalRoute("POST","fastaction/{action:a}",$fastAction,$paraHandler);

    RouteManager::getInstance()->initializeRoute(new RouteListManagment([
        $login,
        $register,
        $updateProfile,
        $createPostRoute,
        $updatePostRoute,
        $deletePostsRoute,
        $showPostsRoute,
        $publishPosts,
        $showSpecificPostsRoute,
        $fastAction]), $routeDefault);
    RouteManager::getInstance()->executeRoute();


    echo (new contentConverter(RouteManager::getInstance()->getActivePage()->getContext()))->getContent();

    // $content = new \converter\contentConverter();
    //  $content->getContent();
}

