<?php

namespace RoutesMNG {

    use http\Exception as ExceptionAlias;
    use Phroute\Phroute\Dispatcher;
    use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
    use Phroute\Phroute\Exception\HttpRouteNotFoundException;
    use Phroute\Phroute\RouteCollector;
    use ServerMNG\serverMessage;
    use WebpageMNG\EventsManager;
    use WebpageMNG\Page;
    use WebpageMNG\View;

    interface SingleRoute
    {
        function action();
    }

    class Route implements SingleRoute
    {
        private string $method;
        private string $path;
        protected int $premmission = 0;

        public function __construct(string $method, string $path)
        {
            $this->method = $method;
            $this->path = $path;

        }

        public function setPermission(RouteCollector $routeManager)
        {
            call_user_func_array(
                array($routeManager, strtolower($this->method)),
                array($this->path, [$this, 'action']));
        }

        // wyswietlanie czynnosci zachodzacych w danym rout
        public function action()
        {
            return $this->getData();
        }

        public function getData()
        {
            return (object)["method" => $this->method, "path" => $this->path];
        }

        public function __toString()
        {
            return "{$this->method}:{$this->path}";
        }

    }

    class NormalRoute extends Route
    {
        private Page $page;

        public function __construct(string $method, string $path, Page $page)
        {
            parent::__construct($method, $path);
            $this->page = $page;
        }

        public function action()
        {
            parent::action();
            $this->page->activeClass();
            $params = func_get_args();
            EventsManager::getInstance()->emit('contextGet', [$params]);
            return $this->page->getContext();
        }
    }

    class PermissionRoute extends NormalRoute
    {
        private $filter = null;

        public function __construct(string $method, string $path, Page $page, callable $filter = null)
        {
            $funct = (!is_null($filter)) ? $filter : fn() => null;
            parent::__construct($method, $path, $page);
            $this->setFilter($funct);
        }


        public function setFilter(callable $method)
        {
            $this->filter = $method;
        }

        public function setPermission(RouteCollector $routeManager)
        {
            $uniqID = uniqid("FILTERPRERMISSION:");
            $routeManager->filter($uniqID, $this->filter);
            call_user_func_array(
                array($routeManager, strtolower($this->getData()->method)),
                array($this->getData()->path, [$this, 'action'], ['before' => $uniqID]));
        }
    }


    class RouteManager
    {
        private SingleRoute $activeRoute;
        private static ?RouteManager $instance = null;
        protected array $routesList = [];


        public function setRoute(string $routeName)
        {
            $keys = array_keys($this->routesList);
            $this->activeRoute = $this->routesList[$keys[$this->routeSelection($routeName)]];
        }

        public function getActiveRoute()
        {
            return $this->activeRoute;
        }

        private function routeSelection(string $searchIndex)
        {
            return array_search($searchIndex, array_keys($this->routesList));
        }

        public function initializeRoute(array $array)
        {
            $this->routesList = $array;
        }

        public static function getInstance(): ?RouteManager
        {
            return is_null(static::$instance) ? static::$instance = new static() : static::$instance;
        }

        public function mapRoute()
        {
            echo "Allowed routes" . PHP_EOL;
            foreach ($this->routesList as $index) {
                echo $index . PHP_EOL;
            }
            echo PHP_EOL;
        }


    }

    final class RouteAdministrator extends RouteManager
    {

        private RouteCollector $routeManager;

        public function __construct()
        {
            $this->routeManager = new RouteCollector();

        }

        public function initializeRoute(array $array)
        {
            parent::initializeRoute($array);

            foreach ($this->routesList as $index) {
                if ($index instanceof Route)
                    $index->setPermission($this->routeManager);
            };

        }

        public function executeRoute(string $requestMETHOD, string $requestURI)
        {

            try {

                $dispatcher = new Dispatcher($this->routeManager->getData());
                return $dispatcher->dispatch($requestMETHOD, parse_url($requestURI, PHP_URL_PATH));
            } catch (HttpRouteNotFoundException  $e) {
                header($e->getMessage());
                return serverMessage::errorMessage();
            } catch (HttpMethodNotAllowedException $e) {
                header($e->getMessage());
                return serverMessage::errorMessage();

            }
        }

    }
}