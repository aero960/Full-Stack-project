<?php


use ServerMNG\serverMessage;
use WebpageMNG\EventsManager;

class Pierwsza extends \WebpageMNG\Page
{


    public function __construct()
    {
        parent::__construct();
    }



    protected function pageContent()
    {
            $this->createContext("⚡ keep going ⚡");
    }
}