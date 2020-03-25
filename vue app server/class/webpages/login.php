<?php


use authentication\Authentication;
use authentication\AuthenticationSchema;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;

class LoginPage extends Page
{
    private LoginGenerator $userLoginManagment;
    private bool $LoggedSucessfully ;

    public function __construct(Parameters $parameters = null)
    {
        $this->parameters = new LoginParameters($parameters);
        $this->LoggedSucessfully = false;
    }

    protected function pageContent(): array
    {
             $this->Initialize();
             if($this->LoggedSucessfully){
                 return ["Info" => Serverlanguage::getInstance()->GetMessage('loginPage.info') . Authentication::getInstance()->getCurrentyUser()->getUsername(),
                     "UserInfo" => ["username" => Authentication::getInstance()->getCurrentyUser()->getUsername(),
                         "password" => Authentication::getInstance()->getCurrentyUser()->getPassword(),
                         "email" => Authentication::getInstance()->getCurrentyUser()->getEmail(),
                         "id" => Authentication::getInstance()->getCurrentyUser()->getId(),
                         "premmison"=> Authentication::getInstance()->getCurrentyUser()->getPermission()
                     ],
                     "Token" => authentication::getInstance()->createToken(Authentication::getInstance()->getCurrentyUser())];
             }
        return ["Info"=> "User doesnt exisit in database"];
    }

    protected function Initialize()
    {
            $this->userLoginManagment = new LoginGenerator();
            $this->userLoginManagment->LoginData($this->parameters->getParameter(LoginParameters::USERNAME),
                $this->parameters->getParameter(LoginParameters::PASSWORD),
                $this->parameters->getParameter(LoginParameters::EMAIL));
            if ($this->userLoginManagment->LoginUserAccount()){
                Authentication::getInstance()->assignCurrentyUser($this->userLoginManagment->getData());
                $this->LoggedSucessfully = true;
            }








    }
}