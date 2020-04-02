<?php


use authentication\Authentication;

use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;


class Register extends Page
{
    private RegisterGenerator $userRegisterManagment;
    private bool $registerSuccesfully =false;
    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new RegisterParameters($parameters);
    }
    protected function Initialize()  :void
    {
            $this->userRegisterManagment = new RegisterGenerator();
            if( $this->userRegisterManagment->Register( $this->parameters->getParameter(RegisterParameters::USERNAME),
                $this->parameters->getParameter(RegisterParameters::PASSWORD),
                $this->parameters->getParameter(RegisterParameters::EMAIL))){
                $this->registerSuccesfully = true;
                Authentication::getInstance()->assignCurrentyUser($this->userRegisterManagment->getData());
            }
    }
    protected function pageContent()
    {
        $this->Initialize();
        if($this->registerSuccesfully){
            $token = Authentication::getInstance()->createToken(Authentication::getInstance()->getCurrentyUser());
            return ["Info" => Serverlanguage::getInstance()->GetMessage("RegisterPage.createUser"),
                "UserInfo" => Authentication::getInstance()->getCurrentyUser()->toIterate(),
                "Token"=> $token];
        }
        return ["info"=>Serverlanguage::getInstance()->GetMessage("duplicate.exist")];
    }



}