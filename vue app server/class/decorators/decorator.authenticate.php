<?php

use authentication\Authentication;
use language\Serverlanguage;
use WebpageMNG\Page;




class AuthenticateDecorator extends Page {

    private Page $page;
    private $type = 1;

    public function __construct(Page $page)
    {
        $this->page = $page;

    }

    protected function pageContent()
    {

        if (!Authentication::getInstance()->isAuthenticated()){
          return  $this->page->pageContent();
        }
        return ["Info"=> Serverlanguage::getInstance()->GetMessage("logged.user")];
    }

    public function isActive()
    {
        return parent::isActive();
    }
}