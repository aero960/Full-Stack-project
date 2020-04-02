<?php

use authentication\Authentication;
use language\Serverlanguage;
use WebpageMNG\Element;
use WebpageMNG\Page;




class AuthenticateDecorator extends Element {

    private Element $element;
    private $type = 1;
    public function __construct(Element $element,bool $letUserEnter = false)
    {
        Element::__construct();
        $this->element = $element;
    }

    public function ExtensionData()
    {
       $this->element->ExtensionData();
    }

    protected function pageContent()
    {
        if (!Authentication::getInstance()->isAuthenticated()){
          return  $this->element->getContext();
        }
        return ["Info"=> Serverlanguage::getInstance()->GetMessage("logged.user")];
    }

    public function isActive()
    {
        return $this->element->isActive();
    }
    public function setActiveElement()
    {
        $this->element->setActiveElement();
    }
    protected function createContext()
    {
       $this->context = $this->pageContent();
    }
}