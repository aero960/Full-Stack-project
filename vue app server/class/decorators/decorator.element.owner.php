<?php


use language\Serverlanguage;

use WebpageMNG\Page;


abstract class PageDecoratorBuilder extends Page
{
    protected Page $page;

    public function ExtensionData()
    {
        $this->page->ExtensionData();
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

    public function __construct(Page $element)
    {
        parent::__construct();
        $this->page = $element;
    }

    protected function pageContent()
    {
        if ($this->page->getActualItem('postid')->CheckItemExist()) {

            if (($this->page->getActualItem('postid')->CheckValidOwner() || PermissionChecker::checkAdminUserAuth())) {
                return $this->page->pageContent();
            }
                $this->outputController->setDataSuccess(false);
                $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage('p.n.o'));
        } else {
            $this->outputController->setDataSuccess(false);
            $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage('p.n.e'),
                $this->page->getActualItem("postid")->getValue()));
        }
        return $this->outputController->getView();
    }
}
class PrivatePostOwner extends PageDecoratorBuilder
{
    public function __construct(Page $element)
    {
        Parent::__construct();
        $this->page = $element;
    }

    protected function pageContent()
    {
        $checker = new PrivatePost($this->page->getActualItem('postid'));
        if ($checker->CheckItemExist()) {
            if ($checker->CheckPrivatePost()) {
                if (($this->page->getActualItem('postid')->CheckValidOwner() || PermissionChecker::checkAdminUserAuthBOOL())) {
                    return $this->page->pageContent();
                }
                $this->outputController->setDataSuccess(false);
                $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage('p.n.o'));
            }else{
                $this->outputController->setDataSuccess(false);
                $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage('p.n.o'));
            }


        }else
        $this->outputController->setDataSuccess(false);
        $this->outputController->setInfo(sprintf(Serverlanguage::getInstance()->GetMessage('p.n.e'),
            $this->page->getActualItem("postid")->getValue()));
        return $this->outputController->getView();
    }


}








