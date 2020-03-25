<?php

namespace authentication {


    use Exception;
    use Firebase\JWT\JWT;
    use Helper\Helper;



    class Authentication
    {
        private static ?authentication $instance = null;
        protected AuthenticationSchema $currentyUser;
        protected array $core;
        protected $token;
        protected $key;
        protected bool  $Authenticated;
        public function __construct()
        {
            $this->core = [];
            $this->Authenticated = false;
            $configs = Helper::getIniConfiguration("jwt");
            $this->key = $configs["key"];
            $this->token = [
                //issue claimer
                "iss" => $configs["iss"],
                //getter issues
                "aud" => $configs["aud"],
                //not before claim
                "nbf" => $configs["nbf"],
                "exp" => time() + 300
            ];


            $this->currentyUser = new AuthenticationSchema(["username"=>"Guest",
               "password"=> AuthenticationSchema::UNKNOW,
               "email"=> AuthenticationSchema::UNKNOW,
                "id"=>AuthenticationSchema::UNKNOW,
                "permission"=>AuthenticationSchema::NONEPREMMISION]);
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
            if (filter_has_var(INPUT_SERVER, "HTTP_WWW_AUTHENTICATE")) {
                try {
                    $info = JWT::decode($_SERVER["HTTP_WWW_AUTHENTICATE"], $this->key, array('HS256'));
                    if ($info->exp >= time()) {
                        $this->currentyUser = new AuthenticationSchema($info->data);
                        $this->Authenticated = true;
                    }
                } catch (Exception $e) {
                    $this->Authenticated = false;
                }
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
            $this->token["data"] = [AuthenticationSchema::USERNAME => $userData->getUsername(),
                AuthenticationSchema::PASSWORD => $userData->getPassword(),
                AuthenticationSchema::EMAIL => $userData->getEmail(),
                AuthenticationSchema::ID => $userData->getId(),
                AuthenticationSchema::PERMMISION => $userData->getPermission()];

            return JWT::encode($this->token, $this->key);

        }

    }


}

