<?php


namespace routesComposite {

    use language\Serverlanguage;
    use Phroute\Phroute\RouteCollector;
    use RoutesMNG\Parameters;
    use WebpageMNG\ContextCreator;
    use WebpageMNG\Element;
    use WebpageMNG\Page;

    interface RouteType
    {
        public function action();
        public function permission(RouteCollector $routeManager);
    }
    abstract class RouteActionBuilder implements RouteType
    {
        protected Route $instance;

        public function __construct(Route $instance)
        {
            $this->instance = $instance;
        }

        public function action()
        {
            $this->instance->getParameters()->setRouteParameters(func_get_args());
            $this->instance->getElement()->ExtensionData();
            $this->instance->setActiveElement();
            return "Routes is exectued";
        }

    }
    class  NormalRouteComposite extends RouteActionBuilder
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

    class  PermissionRouteComposite extends RouteActionBuilder
    {
        public function __construct(Route $instance, array $filter)
        {
            Parent::__construct($instance);
            $this->setFilter($filter);
        }
        private array $filter ;
        public function setFilter(array $method)
        {
            $this->filter = $method;
        }
        public function permissionList(){
           foreach ($this->filter as $index)
              if(($index)())
                  return ($index)();
        }

        public function permission(RouteCollector $routeManager): void
        {
            $uniqID = uniqid('FILTERERS:', true);
            $routeManager->filter($uniqID, [$this, 'permissionList']);
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
        public Element $element;
        protected RouteType $compositeType;
        protected Parameters $parametersHandler;

        public function __construct(string $method, string $path, Element $element, Parameters $parametersHandler)
        {
            $this->method = $method;
            $this->path = $path;
            $this->element = $element;
            $this->parametersHandler = $parametersHandler;
        }

        public function getElement(){
            return $this->element;
        }

        public function getParameters(){
              return  $this->parametersHandler;
        }
        public function isAcitveElement(){
          return  $this->element->isActive();
        }
        public function setPermission(RouteCollector $routeManager): void
        {
            $this->compositeType->permission($routeManager);
        }
        public function action()
        {
            return $this->compositeType->action();
        }
        public function setActiveElement(){

          $this->element->setActiveElement();
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