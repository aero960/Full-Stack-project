<?php


namespace WebpageMNG;

use authentication\Authentication;
use BuilderComposite;
use DateTime;


use Error;
use language\Serverlanguage;
use PostItem;
use PostModificator;
use PostParameters;
use PostUpdateEXT;
use RoutesMNG\Parameters;
use TagModificator;

class PostUpdate extends Page
{
    private PostModificator $postManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new PostParameters($parameters);
    }

    public function ExtensionData()
    {
        $this->addActualItem(new PostItem("postid", $this->parameters->getParameter(0)));
    }

    protected function Initialize(): void
    {
            $this->postManagment = new PostUpdateEXT();
            $this->postManagment->PostUpdate(Authentication::getInstance()->getCurrentyUser()->getId(),
                $this->parameters->getParameter(PostParameters::TITLE),
                $this->parameters->getParameter(PostParameters::CONTENT),
                $this->getActualItem('postid')->getValue(),
                $this->parameters->getParameter(PostParameters::TAGS));

            $this->outputController->setDataSuccess(true);
            $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage("p.u"));
            $this->outputController->setContent(["postdata" => $this->postManagment->getData()->toIterate()]);



    }
}