<?php


namespace WebpageMNG;


use authentication\Authentication;
use PostCreator;
use PostItem;
use PostModificator;

use PostParameters;
use PostRemoveEXT;
use PostUpdateEXT;
use RoutesMNG\Parameters;

class PostDelete extends Page
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
        return ['info' => ["Usunięto post: " . $this->postManagment->getPostBeforeDelete()->getTitle()],
                'dane'=>$this->postManagment->getPostBeforeDelete()->toIterate()];
    }
    public function ExtensionData()
    {
        $this->addActualItem(new PostItem("postid",$this->parameters->getParameter(0)));
    }

    protected function Initialize(): void
    {
        $this->postManagment = new PostRemoveEXT();
        $this->postManagment->PostRemove(
            $this->getActualItem('postid')->getValue()
        );
    }
}