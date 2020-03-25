<?php

use language\Serverlanguage;
use WebpageMNG\Page;

class ParametersDecorator extends Page {
    private Page $page;
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    protected function pageContent()
    {
            if($this->page->parameters->checkValidParameters())
                return  $this->page->pageContent();
            else
                return ["info"=> Serverlanguage::getInstance()->GetMessage("parameters.decorator")];


    }



    public function isActive()
    {
        return parent::isActive();
    }

}