<?php


use RoutesMNG\Parameters;

interface ValidateParameters
{
    public function checkValidParameters(): bool;

    public function getParameter(string $parameter);
}


abstract class PageParametersSchema implements ValidateParameters
{

    private Parameters $fullParameters;

    public function __construct(Parameters $parameters)
    {
        $this->fullParameters = $parameters;
    }

    public function getParameter(string $parameter)
    {
        return $this->combineParameters($parameter);
    }

    private function combineParameters(string $parameterValue)
    {

        forEach ([$this->fullParameters->getRotueParameters(),
                     $this->fullParameters->getRequestParameters()] as $index => $value) {
            if (array_key_exists($parameterValue, $value))
                return $value[$parameterValue];
        }
    }

    abstract public function checkValidParameters(): bool;


}


class LoginParameters extends PageParametersSchema
{
    public const USERNAME = "username";
    public const PASSWORD = "password";
    public const EMAIL = "email";

    public function __construct(Parameters $parameters)
    {
        Parent::__construct($parameters);

    }

    public function checkValidParameters(): bool
    {
        if (filter_has_var(INPUT_POST, self::USERNAME) &&
            filter_has_var(INPUT_POST, self::PASSWORD) &&
            filter_has_var(INPUT_POST, self::EMAIL)) {
            return true;
        }
        return false;
    }
}

class NoParameters extends PageParametersSchema
{
    public function __construct()
    {}

    public function checkValidParameters(): bool
    {
        return true;
    }
}


class RegisterParameters extends PageParametersSchema
{
    public const USERNAME = "username";
    public const PASSWORD = "password";
    public const EMAIL = "email";

    public function __construct(Parameters $parameters)
    {
        Parent::__construct($parameters);

    }

    public function checkValidParameters(): bool
    {
        if (filter_has_var(INPUT_POST, self::USERNAME) &&
            filter_has_var(INPUT_POST, self::PASSWORD) &&
            filter_has_var(INPUT_POST, self::EMAIL)) {
            return true;
        }

        return false;

    }
}