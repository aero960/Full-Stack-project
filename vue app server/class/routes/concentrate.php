<?php


namespace RoutesMNG{

    use language\Serverlanguage;
    use PermissionChecker;
    use routesComposite\NormalRouteComposite;
    use routesComposite\PermissionRouteComposite;
    use routesComposite\Route;
    use WebpageMNG\Element;
    use WebpageMNG\Page;

    class NormalRoute extends Route
    {
        public function __construct(string $method, string $path, Element $element,Parameters $parametersHandler)
        {
            parent::__construct($method, $path, $element,$parametersHandler);
            $this->compositeType = new NormalRouteComposite($this);
        }



    }



    class PermissionRoute extends Route
    {
        public function __construct(string $method, string $path, Element $element,Parameters $parametersHandler, array $filter = null)
        {
            parent::__construct($method, $path,$element,$parametersHandler);
            $this->compositeType = new PermissionRouteComposite($this, $filter ? $filter : [[PermissionChecker::CHECKER, PermissionChecker::NORMALAUTH]]);
        }


    }
}

