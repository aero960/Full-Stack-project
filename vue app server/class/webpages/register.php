<?php


use authentication\Authentication;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;


class RegisterPage extends Page
{
    private RegisterGenerator $userRegisterManagment;
    public function __construct(Parameters $parameters = null)
    {
        $this->parameters = new RegisterParameters($parameters);
    }
    protected function Initialize()
    {
            $this->userRegisterManagment = new RegisterGenerator();
            $this->userRegisterManagment->Register( $this->parameters->getParameter(RegisterParameters::USERNAME),
                $this->parameters->getParameter(RegisterParameters::PASSWORD),
                $this->parameters->getParameter(RegisterParameters::EMAIL));
            Authentication::getInstance()->assignCurrentyUser($this->userRegisterManagment->getData());
    }


    protected function pageContent()
    {
            $this->Initialize();
             return ["Info" => Serverlanguage::getInstance()->GetMessage("RegisterPage.createUser"),
                 "UserInfo" => Authentication::getInstance()->getCurrentyUser()->getUsername(),
                     "Token"=> Authentication::getInstance()->createToken(Authentication::getInstance()->getCurrentyUser())];

    }
}