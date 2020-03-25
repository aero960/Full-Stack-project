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
        try {
            if (empty($this->parametersRoute))
                $this->parametersRoute = $route;
            else
                throw new Exception(Serverlanguage::getInstance()->GetMessage("parameters.initialize.error"));
        } catch (Exception $e) {
            echo "{$e}";
        }
    }
    public function setRequestParameters(array $request)
    {
        try {
            if (empty($this->parametersRequest))
                $this->parametersRequest = $request;
            else
                throw new Exception(Serverlanguage::getInstance()->GetMessage("parameters.initialize.error"));
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
            Serverlanguage::getInstance()->importandServerMessage("parameters.request") => $this->parametersRequest,
            Serverlanguage::getInstance()->importandServerMessage("parameters.route") => $this->parametersRoute];
    }
}


