<?php

use language\Serverlanguage;
use WebpageMNG\Element;
use WebpageMNG\Page;

class ParametersDecorator extends PageDecoratorBuilder
{
    public function __construct(Page $page)
    {
        parent::__construct();
        $this->page = $page;
    }

    protected function pageContent()
    {
        $this->Initialize();
        if ($this->page->checkValidParameters()) {
            return $this->page->pageContent();
        }
        $this->outputController->setDataSuccess(false);
        $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage("p.n.p"));
        return $this->outputController->getView();
    }

}