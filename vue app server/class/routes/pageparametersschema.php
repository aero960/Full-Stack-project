<?php


use RoutesMNG\Parameters;

interface ValidateParameters
{
    public function checkValidParameters(): bool;
    public function getParameter(string $parameter);
}

class AllParametersType{
    public const USERNAME = "username";
    public const PASSWORD = "password";
    public const EMAIL = "email";

    public const TITLE = 'post_title';
    public const CONTENT = 'post_content';
    public const TAGS = 'tags';

    public const FIRSTNAME = 'firstName';
    public const LASTNAME = 'LastName';
    public const MOBILE = 'mobile';
    public const INTRO = 'intro';
    public const PROFILE = 'profile';
    public const IMAGE = 'image';




}


abstract class PageParametersSchema implements ValidateParameters
{

    private Parameters $fullParameters;

    public function __construct(Parameters $parameters)
    {
        $this->fullParameters = $parameters;
    }



    public function getParameter(string $parameterValue)
    {
        forEach ([$this->fullParameters->getRotueParameters(),
                     $this->fullParameters->getRequestParameters()] as $index => $value) {
            if (array_key_exists($parameterValue, $value))
                return $value[$parameterValue];
        }
    }
    abstract public function checkValidParameters(): bool;
}

class NoParameters extends PageParametersSchema
{
    public function __construct(Parameters $parameters)
    {
        Parent::__construct($parameters);
    }

    public function checkValidParameters(): bool
    {
        return true;
    }


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

class UpdateProfileParammeters extends PageParametersSchema
{

    public const FIRSTNAME = 'firstName';
    public const LASTNAME = 'LastName';
    public const MOBILE = 'mobile';
    public const INTRO = 'intro';
    public const PROFILE = 'profile';
    public const IMAGE = 'image';

    public function __construct(Parameters $parameters)
    {
        parent::__construct($parameters);
    }

    public function checkValidParameters(): bool
    {
        return
            filter_has_var(INPUT_POST, self::FIRSTNAME) &&
            filter_has_var(INPUT_POST, self::LASTNAME) &&
            filter_has_var(INPUT_POST, self::MOBILE) &&
            filter_has_var(INPUT_POST, self::INTRO) &&
            filter_has_var(INPUT_POST, self::PROFILE) &&
            filter_has_var(INPUT_POST, self::IMAGE);
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
        return filter_has_var(INPUT_POST, RegisterParameters::USERNAME) &&
            filter_has_var(INPUT_POST, RegisterParameters::PASSWORD) &&
            filter_has_var(INPUT_POST, RegisterParameters::EMAIL);
    }

}

class PostParameters extends PageParametersSchema
{
    public const TITLE = 'post_title';
    public const CONTENT = 'post_content';
    public const TAGS = 'tags';

    public function checkValidParameters(): bool
    {
        return filter_has_var(INPUT_POST, self::TITLE) &&
            filter_has_var(INPUT_POST, self::CONTENT);
    }
}
class PostPublishParameters extends PageParametersSchema
{
    public const PUBLISH = 'publish';

    public function checkValidParameters(): bool
    {
        return filter_has_var(INPUT_POST, self::PUBLISH);

    }
}
class PostViewerParameters extends PageParametersSchema
{
    public const SHOWALL = 'showall';

    public function __construct(Parameters $parameters)
    {
        Parent::__construct($parameters);
    }

    public function checkValidParameters(): bool
    {

        return filter_has_var(INPUT_GET,self::SHOWALL,);
    }
}