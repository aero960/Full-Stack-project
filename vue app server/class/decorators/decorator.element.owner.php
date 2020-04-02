<?php

use authentication\Authentication;
use language\Serverlanguage;
use WebpageMNG\Element;
use WebpageMNG\Page;


class PostOwnerDecorator extends Page
{

    private Page $page;

    public function __construct(Page $element)
    {
        Parent::__construct();
        $this->page = $element;
    }

    protected function createContext()
    {
        $this->context = $this->pageContent();
    }

    public function ExtensionData()
    {
        $this->page->ExtensionData();
    }

    protected function pageContent()
    {

        if ($this->page->getActualItem('postid')->checkItemExist()) {
            if (($this->page->getActualItem('postid')->checkValidOwner() || PermissionChecker::checkAdminUserAuth())) {
                return $this->page->pageContent();
            }
            return ["info" => Serverlanguage::getInstance()->GetMessage('noownerpost')];
        }
        return ["info" => Serverlanguage::getInstance()->GetMessage('postdoesntexist')];

    }

    protected function Initialize(): void
    {

        $this->page->Initialize();
    }

    public function isActive()
    {
        return $this->page->isActive();
    }

    public function setActiveElement()
    {
        $this->page->setActiveElement();
    }

    public function checkValidParameters()
    {

        return $this->page->checkValidParameters();
    }
}





