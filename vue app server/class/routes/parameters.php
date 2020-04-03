<?php

namespace RoutesMNG;

use Exception;
use language\Serverlanguage;


class Parameters
{
    protected array $parametersRoute = [];
    protected array $parametersRequest = [];

    public function setRouteParameters(array $route)
    {
        $this->parametersRoute = $route;
    }

    public function setRequestParameters(array $request)
    {
        $this->parametersRequest = $request;
    }

    public function getRotueParameters()
    {
        return $this->parametersRoute;
    }

    public function getRequestParameters()
    {
        return $this->parametersRequest;
    }

}


