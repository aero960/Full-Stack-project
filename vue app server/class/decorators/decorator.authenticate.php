<?php

use authentication\Authentication;
use language\Serverlanguage;
use WebpageMNG\Element;
use WebpageMNG\Page;


class AuthenticateDecorator extends PageDecoratorBuilder
{


    public function __construct(Page $page)
    {
        parent::__construct();
        $this->page = $page;
    }

    protected function pageContent()
    {
        $this->Initialize();
        if (!Authentication::getInstance()->isAuthenticated()) {
            return $this->page->pageContent();
        }
            $this->outputController->setDataSuccess(false);
            $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage("u.a.a"));
            return $this->outputController->getView();

    }
}