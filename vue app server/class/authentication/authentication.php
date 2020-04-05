<?php


namespace authentication {

    use DateTime;
    use Firebase\JWT\JWT;
    use Exception;
    use Helper\Helper;

    abstract class Permmision
    {
        const ADMIN = 3;
        const PREMIUM = 2;
        const NORMAL = 1;
        const GUEST = 0;
    }


    class Authentication
    {
        private static ?authentication $instance = null;
        protected AuthenticationSchema $currentyUser;
        protected $token;
        protected $key;
        protected bool  $Authenticated;


        public function __construct()
        {

            $this->Authenticated = false;

            $this->TokenInitialize();
            //nastepne zmiany
            $this->currentyUser = AuthenticationSchema::createGuest();
        }

        private function TokenInitialize()
        {
            $configs = Helper::getIniConfiguration("jwt");
            $this->key = $configs["key"];
            $this->token = [
                //issue claimer
                "iss" => $configs["iss"],
                //getter issues
                "aud" => $configs["aud"],
                //not before claim
                "nbf" => $configs["nbf"],
                "exp" => time() + $configs["exp"]];
        }


        public function getKey()
        {
            return $this->key;
        }
        public function assignCurrentyUser(AuthenticationSchema $user)
        {
            $this->currentyUser = $user;
            $this->Authenticated = true;
        }

        public static function getInstance(): authentication
        {
            return static::$instance ?: static::$instance = new static();

        }

        public function AuthenticateUser()
        {
            try {
                if (filter_has_var(INPUT_SERVER, "HTTP_WWW_AUTHENTICATE")) {
                    $info = JWT::decode(apache_request_headers()["WWW-Authenticate"], $this->getKey(), array('HS256'));
                    $this->token = $info;
                    if ($info->exp >= time()) {

                        $this->assignCurrentyUser(new AuthenticationSchema($info->data));
                    }
                }
            } catch (Exception $e) {
                return null;
            }
        }

        public function getCurrentyUser()
        {
            return $this->currentyUser;
        }

        public function isAuthenticated()
        {
            return $this->Authenticated;
        }

        public function createToken(AuthenticationSchema $userData)
        {
            //Tutaj musiałem coś zmieniać

            $this->token["data"] = $userData->toIterate();
            return JWT::encode($this->token, $this->key);
        }

    }


}

