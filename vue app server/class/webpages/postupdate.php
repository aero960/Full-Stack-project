<?php


namespace WebpageMNG;

use authentication\Authentication;
use BuilderComposite;
use DateTime;



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
    protected function pageContent()
    {
        $this->Initialize();
        return ["info"=>$this->postManagment->getData()->toIterate()];
    }
    public function ExtensionData()
    {
            $this->addActualItem(new PostItem("postid",$this->parameters->getParameter(0)));
    }
    protected function Initialize(): void
    {
        $this->postManagment = new PostUpdateEXT();
        $this->postManagment->PostUpdate(Authentication::getInstance()->getCurrentyUser()->getId(),
            $this->parameters->getParameter(PostParameters::TITLE),
            $this->parameters->getParameter(PostParameters::CONTENT),
            $this->getActualItem('postid')->getValue()
        );
    }
}