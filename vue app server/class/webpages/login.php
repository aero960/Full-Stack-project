<?php


use authentication\Authentication;
use authentication\AuthenticationSchema;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;

class Login extends Page
{
    private LoginGenerator $userLoginManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new LoginParameters($parameters);
    }

    protected function Initialize(): void
    {

        $this->userLoginManagment = new LoginGenerator();
        //!!!! DO ZMIANY  REFERENCJA W ZALOGOWANIU UZYTKOWNIKA
        $hashPassword = md5($this->parameters->getParameter(RegisterParameters::PASSWORD));
        //!!! DO ZMIANY TYMCZASOWO POSTAWION

        if ($this->userLoginManagment->LoginData($this->parameters->getParameter(LoginParameters::USERNAME),
            $hashPassword,
            $this->parameters->getParameter(LoginParameters::EMAIL))) {

            Authentication::getInstance()->assignCurrentyUser($this->userLoginManagment->getData());

            $this->outputController->setDataSuccess(true);
            $this->outputController->setInfo(
                sprintf(Serverlanguage::getInstance()->GetMessage('l.u.s.l'),
                    Authentication::getInstance()->getCurrentyUser()->getUsername())
            );
            $this->outputController->setContent(["userdata" => Authentication::getInstance()->getCurrentyUser()->toIterate(),
                "lastLogin" => ($this->userLoginManagment->getLastLogin())->format(BuilderComposite::UPDATEDTIMEFORMAT),
                "loginSuccesfull" => true]);

            $this->outputController->setToken(authentication::getInstance()->createToken(Authentication::getInstance()->getCurrentyUser()));
        } else {
            $this->outputController->setDataSuccess(false);
            $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage('l.u.f.l'));
            $this->outputController->setContent(["loginSuccesfull" => false]);
        }


    }
}