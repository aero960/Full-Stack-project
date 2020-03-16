<?php


use WebpageMNG\EventsManager;

class Pierwsza extends \WebpageMNG\Page
{


    public function __construct()
    {
        parent::__construct();
    }



    protected function pageContent()
    {
            $this->createContext("<div> Siemaneczo swirki</div>");
    }
}