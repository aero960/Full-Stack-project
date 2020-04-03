<?php

use language\Serverlanguage;
use WebpageMNG\Element;
use WebpageMNG\Page;





class ParametersDecorator extends Element
{
    private Page $page;

    public function __construct(Page $element)
    {
        Element::__construct();
        $this->page = $element;
    }
    public function ExtensionData()
    {
        $this->page->ExtensionData();
    }

    public function pageContent()
    {
        if ($this->page->checkValidParameters())
            return $this->page->getContext();
        return ["info" => Serverlanguage::getInstance()->GetMessage("parameters.decorator")];
    }

    public function isActive()
    {
        return $this->page->isActive();
    }

    public function setActiveElement()
    {
        $this->page->setActiveElement();
    }
    protected function createContext()
    {
        $this->context = $this->pageContent();
    }
}