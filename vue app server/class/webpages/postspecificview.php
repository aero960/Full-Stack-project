<?php

use authentication\Authentication;
use language\Serverlanguage;
use RoutesMNG\Parameters;
use WebpageMNG\Page;


class PostSpecificView extends Page
{

    private ShowSpecificPost $showPosts;


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

        $this->showPosts = new ShowSpecificPost($this->getActualItem("postid")->getValue());

        $this->outputController->setDataSuccess(true);
        $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage("p.s.g.u")));
        $this->outputController->setContent((new PostIterator([$this->showPosts->getView()]))->current());


    }
}