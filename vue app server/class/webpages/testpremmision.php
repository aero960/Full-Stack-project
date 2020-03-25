<?php


namespace WebpageMNG;


use authentication\Authentication;
use language\Serverlanguage;
use NoParameters;

use RoutesMNG\Parameters;

class testpremmision extends Page
{
    public function __construct(Parameters $parameters = null)
    {
        $this->parameters = new NoParameters($parameters);
    }

    protected function pageContent()
    {

        return ["PageContent" => Serverlanguage::getInstance()->GetMessage("loginPage.info") . Authentication::getInstance()->getCurrentyUser()->getUsername(),
                "UserResources" => Authentication::getInstance()->getCurrentyUser()];
    }


}