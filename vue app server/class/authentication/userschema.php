<?php


namespace authentication {

//Schema of users information to store users information
    class UserSchema
    {
        public function __construct(string $username, string $password, string $email, string $money)
        {
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->money = $money;
        }

        protected string $username;
        protected string $password;
        protected string $email;
        protected float $money;

        public function getUsername(): string
        {
            return $this->username;
        }


        public function getPassword(): string
        {
            return $this->password;
        }


        public function getEmail(): string
        {
            return $this->email;
        }

        public function getMoney(): float
        {
            return $this->money;
        }

    }

    class AuthenticationSchema
    {
        const USERNAME = "username";
        const PASSWORD = "password";
        const EMAIL = "email";
        const ID = "id";
        const PERMMISION = "permission";

        const NONEPREMMISION = 0;
        const UNKNOW = "unknow";

        public function __construct($data)
        {
            $this->username = is_array($data) ? $data[self::USERNAME]  : $data->{self::USERNAME};
            $this->password =  is_array($data) ?  $data[self::PASSWORD] : $data->{self::PASSWORD};
            $this->email = is_array($data) ? $data[self::EMAIL] : $data->{self::EMAIL};
            $this->id =  is_array($data) ? $data[self::ID] : $data->{self::ID};
            $this->permission = is_array($data) ? $data[self::PERMMISION] : $data->{self::PERMMISION};
        }

        protected string $id;
        protected string $username;
        protected string $password;
        protected string $email;
        protected string $permission;


        public function getPermission()
        {
            return $this->permission;
        }

        public function getUsername(): string
        {
            return $this->username;
        }

        public function getPassword(): string
        {
            return $this->password;
        }


        public function getEmail(): string
        {
            return $this->email;
        }

        public function getId(): string
        {
            return $this->id;
        }

    }
}