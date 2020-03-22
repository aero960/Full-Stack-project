<?php

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