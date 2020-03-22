<?php


namespace RoutesMNG{

    use routesComposite\NormalRouteComposite;
    use routesComposite\PermissionRouteComposite;
    use routesComposite\Route;
    use WebpageMNG\Page;

    class NormalRoute extends Route
    {
        protected int $permission = 0;
        public function __construct(string $method, string $path, Page $page,Parameters $parametersHandler)
        {
            parent::__construct($method, $path, $page,$parametersHandler);
            $this->compositeType = new NormalRouteComposite($this);
            $this->page = $page;
        }
    }

    class PermissionRoute extends Route
    {
        protected int $permission = 3;
        public function __construct(string $method, string $path, Page $page,Parameters $parametersHandler, callable $filter = null)
        {
            parent::__construct($method, $path,$page,$parametersHandler);
            $this->compositeType = new PermissionRouteComposite($this, $filter ? $filter : fn()=>  "Define route filter!");
        }
    }
}

