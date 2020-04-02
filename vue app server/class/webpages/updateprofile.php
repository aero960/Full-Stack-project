<?php

use authentication\Authentication;
use RoutesMNG\Parameters;

class Updateprofile extends \WebpageMNG\Page
{
    private UpdateGenerator $userUpdateManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new UpdateProfileParammeters($parameters);
    }

    protected function pageContent()
    {
        $this->Initialize();
        $resources = Authentication::getInstance()->getCurrentyUser()->GetResouces();
        $currentUser = Authentication::getInstance()->getCurrentyUser();
        return ["info" => "Zaktualizowales swoje dane: {$currentUser->getUsername()}",
                "data"=> $resources->toIterate()];
    }

    protected function Initialize(): void
    {

        $this->userUpdateManagment = new UpdateGenerator();
        //testowo
        $this->userUpdateManagment->updateUser(Authentication::getInstance()->getCurrentyUser()->getId(),
            $this->parameters->getParameter(UpdateProfileParammeters::FIRSTNAME),
            $this->parameters->getParameter(UpdateProfileParammeters::LASTNAME),
            $this->parameters->getParameter(UpdateProfileParammeters::MOBILE),
            $this->parameters->getParameter(UpdateProfileParammeters::INTRO),
            $this->parameters->getParameter(UpdateProfileParammeters::PROFILE),
            $this->parameters->getParameter(UpdateProfileParammeters::IMAGE));
        Authentication::getInstance()->getCurrentyUser()->AssingResources($this->userUpdateManagment->getData());
    }
}