<?php


namespace routesComposite {

    use language\Serverlanguage;
    use Phroute\Phroute\RouteCollector;
    use RoutesMNG\Parameters;
    use WebpageMNG\ContextCreator;
    use WebpageMNG\Page;

    interface RouteType
    {
        public function action();

        public function permission(RouteCollector $routeManager);
    }

    abstract class RouteActionBuilder
    {

        protected Route $instance;

        public function __construct(Route $instance)
        {
            $this->instance = $instance;
        }

        public function action()
        {
            $this->instance->getParametersHandler()->setRouteParameters(func_get_args());
            if ($this->instance->getPage() instanceof ContextCreator)
                $this->instance->getPage()->setActivePage();
        }

    }


    class  NormalRouteComposite extends RouteActionBuilder implements RouteType
    {

        public function __construct(Route $instance)
        {
            Parent::__construct($instance);
        }

        public function permission(RouteCollector $routeManager): void
        {
            $routeManager->{strtolower($this->instance->getData()->method)}
            ($this->instance->getData()->path, [$this, 'action']);
        }
    }

    class  PermissionRouteComposite extends RouteActionBuilder implements RouteType
    {
        public function __construct(Route $instance, callable $filter)
        {
            Parent::__construct($instance);

            $this->setFilter($filter);

        }

        private $filter = null;

        public function setFilter(callable $method)
        {
            $this->filter = $method;
        }

        public function permission(RouteCollector $routeManager): void
        {
            $uniqID = uniqid('FILTERERS:', true);
            $routeManager->filter($uniqID, $this->filter);
            $routeManager->{strtolower($this->instance->getData()->method)}
            ($this->instance->getData()->path, [$this, 'action'], ['before' => $uniqID]);
        }


    }

    interface SingleRoute
    {
        public function action();
    }

    abstract class Route implements SingleRoute
    {

        private string $method;
        private string $path;
        public Page $page;
        protected RouteType $compositeType;
        protected Parameters $parametersHandler;

        public function __construct(string $method, string $path, Page $page, Parameters $parametersHandler)
        {
            $this->method = $method;
            $this->path = $path;
            $this->page = $page;
            $this->parametersHandler = $parametersHandler;
        }

        public function getParametersHandler()
        {
            return $this->parametersHandler;
        }

        public function setPermission(RouteCollector $routeManager): void
        {
            $this->compositeType->permission($routeManager);
        }

        // wyswietlanie czynnosci zachodzacych w danym rout
        public function action()
        {
            return $this->compositeType->action();
        }

        public function getPage()
        {
            return $this->page;
        }

        public function getData()
        {
            return (object)['method' => $this->method, 'path' => $this->path];
        }

        public function __toString()
        {
            return "{$this->method} : {$this->path}";
        }


    }


}