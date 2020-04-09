<?php


use authentication\Authentication;

use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;

//tutaj jest biorca
class Register extends Page
{
    private RegisterGenerator $userRegisterManagment;
    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new RegisterParameters($parameters);
    }
    protected function Initialize()  :void
    {

            $this->userRegisterManagment = new RegisterGenerator();
    //!!!! DO ZMIANY  REFERENCJA W ZALOGOWANIU UZYTKOWNIKA
            $hashPassword =  md5($this->parameters->getParameter(RegisterParameters::PASSWORD));
    //!!! DO ZMIANY TYMCZASOWO POSTAWION
            if( $this->userRegisterManagment->Register( $this->parameters->getParameter(RegisterParameters::USERNAME),
                $hashPassword,
                $this->parameters->getParameter(RegisterParameters::EMAIL))){
                Authentication::getInstance()->assignCurrentyUser($this->userRegisterManagment->getData());

                $this->outputController->setDataSuccess(true);

                $this->outputController->setInfo( sprintf(Serverlanguage::getInstance()->GetMessage("r.u.s.r"),
                    Authentication::getInstance()->getCurrentyUser()->getEmail()));

                $this->outputController->setContent(["userdata"=>Authentication::getInstance()->getCurrentyUser()->toIterate()]);
                $this->outputController->setToken(Authentication::getInstance()->createToken(Authentication::getInstance()->getCurrentyUser()));
            }else{
                $this->outputController->setDataSuccess(false);
                $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage("r.u.f.r"));
            }



    }



}