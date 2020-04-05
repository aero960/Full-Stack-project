<?php


namespace WebpageMNG;


use authentication\Authentication;
use language\Serverlanguage;
use NoParameters;
use PostCreator;
use PostItem;
use PostModificator;

use PostParameters;
use PostRemoveEXT;
use PostUpdateEXT;
use RoutesMNG\Parameters;

class PostDelete extends Page
{
    private PostRemoveEXT $postManagment;

    public function __construct(Parameters $parameters = null)
    {
        Parent::__construct();
        $this->parameters = new NoParameters($parameters);
    }
    public function ExtensionData()
    {
        $this->addActualItem(new PostItem("postid", $this->parameters->getParameter(0)));
    }

    protected function Initialize(): void
    {
        $this->postManagment = new PostRemoveEXT();
        $this->postManagment->PostRemove($this->getActualItem('postid')->getValue());
            $this->outputController->setDataSuccess(true);
            $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage("p.d"),
                $this->postManagment->getPostBeforeDelete()->getTitle()));
            $this->outputController->setContent(["postdata"=>$this->postManagment->getPostBeforeDelete()->toIterate()]);
    }
}
















