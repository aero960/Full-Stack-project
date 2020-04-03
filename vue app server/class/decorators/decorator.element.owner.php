<?php

use authentication\Authentication;
use language\Serverlanguage;
use WebpageMNG\Element;
use WebpageMNG\Page;


abstract class PageDecoratorBuilder extends Page{
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





class PostOwnerDecorator extends PageDecoratorBuilder
{
    private Page $page;
    public function __construct(Page $element)
    {
        parent::__construct($element);
        $this->page = $element;
    }
    protected function pageContent()
    {
        if ($this->page->getActualItem('postid')->CheckItemExist()) {
            if (($this->page->getActualItem('postid')->CheckValidOwner() || PermissionChecker::checkAdminUserAuth())) {
                return $this->page->pageContent();
            }
            return ["info" => Serverlanguage::getInstance()->GetMessage('noownerpost')];
        }
        return ["info" => Serverlanguage::getInstance()->GetMessage('postdoesntexist')];

    }

}



class PrivatePostOwner extends PageDecoratorBuilder
{
    private Page $page;

    public function __construct(Page $element)
    {
        Parent::__construct($element);
        $this->page = $element;
    }

    protected function pageContent()
    {
        $checker = new PrivatePost($this->page->getActualItem('postid'));
        if ($checker->CheckItemExist()){
            if($checker->CheckPrivatePost()){
                if (($this->page->getActualItem('postid')->CheckValidOwner() || PermissionChecker::checkAdminUserAuthBOOL())){
                    return $this->page->pageContent();
                }
                return ["info" => Serverlanguage::getInstance()->GetMessage('noownerpost')];
            }
            return $this->page->pageContent();
        }
        return ["info" => Serverlanguage::getInstance()->GetMessage('postdoesntexist')];

    }

}








