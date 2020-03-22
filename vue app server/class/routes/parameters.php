<?php

namespace RoutesMNG;

use Exception;

class Parameters
{
    protected array $parametersRoute = [];
    protected array $parametersRequest = [];

    public function setRoute(array $route)
    {
        try {
            if (empty($this->parametersRoute))
                $this->parametersRoute = $route;
            else
                throw new Exception('Cannot initialize parameters second time');
        } catch (Exception $e) {
            echo "{$e}";
        }

    }

    public function setRequest(array $request)
    {
        try {
            if (empty($this->parametersRequest))
                $this->parametersRequest = $request;
            else
                throw new Exception('Cannot initialize parameters second time');
        } catch (Exception $e) {
            echo "{$e}";
        }

    }

    public function getRotueParameters()
    {
        return $this->parametersRoute;
    }

    public function getRequestParameters()
    {
        return $this->parametersRequest;
    }

    public function getAllParameters()
    {
        return (object)[
            "request" => $this->parametersRequest,
            "route" => $this->parametersRoute];
    }
}


