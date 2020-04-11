<?php

use authentication\Authentication;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;

class Updateprofile extends Page
{
    private UpdateGenerator $userUpdateManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new UpdateProfileParammeters($parameters);
    }

    protected function Initialize(): void
    {
        $this->userUpdateManagment = new UpdateGenerator();
        $this->userUpdateManagment->updateUser(Authentication::getInstance()->getCurrentyUser()->getId(),
            $this->parameters->getParameter(UpdateProfileParammeters::FIRSTNAME),
            $this->parameters->getParameter(UpdateProfileParammeters::LASTNAME),
            $this->parameters->getParameter(UpdateProfileParammeters::MOBILE),
            $this->parameters->getParameter(UpdateProfileParammeters::INTRO),
            $this->parameters->getParameter(UpdateProfileParammeters::PROFILE),
            $this->parameters->getParameter(UpdateProfileParammeters::IMAGE));


        Authentication::getInstance()->getCurrentyUser()->AssingResources($this->userUpdateManagment->getData());

        $this->outputController->setDataSuccess('true');
        $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage("u.s.u"), Authentication::getInstance()->getCurrentyUser()->getUsername()));
        $this->outputController->setContent(Authentication::getInstance()->getCurrentyUser()->GetResouces()->toIterate());


    }
}