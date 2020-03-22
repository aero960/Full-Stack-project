<?php

namespace RoutesMNG {

    use Phroute\Phroute\Dispatcher;
    use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
    use Phroute\Phroute\Exception\HttpRouteNotFoundException;
    use Phroute\Phroute\RouteCollector;

    use routesComposite\Route;

    use ServerMNG\serverMessage;
    use WebpageMNG\Page;


    final class RouteManager
    {
        private RouteCollector $routeManager;
        private static ?RouteManager $instance = null;
        protected array $routesList = [];

        public function __construct()
        {
            $this->routeManager = new RouteCollector();
        }

        public function getActivePage()
        {
             $activePage = array_filter($this->routesList, fn(Route $index) => $index->getPage()->isActive());

            return $activePage ? array_shift($activePage)->getPage() : new \page_error() ;
        }


        public function initializeRoute(array $array):void
        {

            foreach ($array as $index) {
                if ($index instanceof Route) {
                    $this->routesList[] = $index;
                    $index->setPermission($this->routeManager);
                }

            };
        }

        public static function getInstance(): RouteManager
        {
            return static::$instance ?: static::$instance = new static();
        }

        public function mapRoute(): void
        {
            echo "Allowed routes" . PHP_EOL;
            foreach ($this->routesList as $index) {
                echo $index . PHP_EOL;
            }
            echo PHP_EOL;
        }

        public function executeRoute(): void
        {

            $requestMETHOD = $_SERVER['REQUEST_METHOD'];
            $requestURI = $_SERVER['REQUEST_URI'];
            //valide url
              preg_match('/(^\/[^&]*)/',$requestURI,$requestURI);
            //do poprawienia dodanie menadżera wyjscia
            try {
                $dispatcher = new Dispatcher($this->routeManager->getData());
                $dispatcher->dispatch($requestMETHOD, parse_url($requestURI[0], PHP_URL_PATH));
            } catch (HttpRouteNotFoundException  $e) {
                header($e->getMessage());
                serverMessage::send("Error", serverMessage::errorMessage());
            } catch (HttpMethodNotAllowedException $e) {
                header($e->getMessage());
                serverMessage::send("Error", serverMessage::errorMessage());
            }
        }


    }


}