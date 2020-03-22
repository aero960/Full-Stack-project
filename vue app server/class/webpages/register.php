<?php



use RoutesMNG\Parameters;
use WebpageMNG\Page;




class RegisterPage extends Page
{
    public function __construct(Parameters $parameters = null)
    {
        parent::__construct($parameters);
     //   new DataBase();
    }

    private function registerUser(){

    }




    protected function pageContent()
    {
        return "there is resgister new user";
    }
}