<?php


use authentication\Authentication;
use authentication\AuthenticationSchema;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;

class Login extends Page
{
    private LoginGenerator $userLoginManagment;
    private bool $LoggedSucessfully ;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new LoginParameters($parameters);
        $this->LoggedSucessfully = false;
    }

    public function pageContent(): array
    {
             $this->Initialize();
             if($this->LoggedSucessfully){
    //tutaj potrzebna jest hermetyzacja
                 return ["Info" => Serverlanguage::getInstance()->GetMessage('loginPage.info') . Authentication::getInstance()->getCurrentyUser()->getUsername(),
                     "UserInfo" => ["username" => Authentication::getInstance()->getCurrentyUser()->getUsername(),
                         "password" => Authentication::getInstance()->getCurrentyUser()->getPassword(),
                         "email" => Authentication::getInstance()->getCurrentyUser()->getEmail(),
                         "id" => Authentication::getInstance()->getCurrentyUser()->getId(),
                         "premmison"=> Authentication::getInstance()->getCurrentyUser()->getPermission(),
                         "lastLogin"=> Authentication::getInstance()->getCurrentyUser()->loginTime()->format(BuilderComposite::DATEFORMAT),
                         "registeredAt"=> Authentication::getInstance()->getCurrentyUser()->getRegisteredDate()->format(BuilderComposite::DATEFORMAT),
                         "TimeFromLastLogin"=>date_diff(Authentication::getInstance()->getCurrentyUser()->loginTime(),
                             $this->userLoginManagment->getLastLogin())->format(BuilderComposite::UPDATEDTIMEFORMAT)
                     ],
                     "Token" => authentication::getInstance()->createToken(Authentication::getInstance()->getCurrentyUser())];
             }
        return ["Info"=> "User doesnt exisit in database"];
    }

    protected function Initialize()  :void
    {
            $this->userLoginManagment = new LoginGenerator();
       if( $this->userLoginManagment->LoginData($this->parameters->getParameter(LoginParameters::USERNAME),
            $this->parameters->getParameter(LoginParameters::PASSWORD),
            $this->parameters->getParameter(LoginParameters::EMAIL)))
            {
                Authentication::getInstance()->assignCurrentyUser($this->userLoginManagment->getData());
                $this->LoggedSucessfully = true;
            }
    }
}