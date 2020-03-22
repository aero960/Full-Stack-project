<?php



use RoutesMNG\Parameters;
use WebpageMNG\Page;




class RegisterPage extends Page
{
    private QueryGenerator $userRegisterManagment;
    public function __construct(Parameters $parameters = null)
    {
        parent::__construct($parameters);
        $username  = $this->getParameters()->getRequestParameters()["username"];
        $password = $this->getParameters()->getRequestParameters()["password"];
        $email = $this->getParameters()->getRequestParameters()["email"];
        $this->userRegisterManagment =  new QueryGenerator($username,$password,$email);
    }

    private function registerUser(){
        $this->userRegisterManagment->createUserAccount();
    }

    protected function pageContent()
    {
       // var_dump($this->userRegisterManagment->ge);
        $this->registerUser();
        http_response_code(200);

        return (object)["info"=>"Create user",
                        "User data"=>[$this->userRegisterManagment->getData()[0]]];
    }
}