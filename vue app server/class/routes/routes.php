<?php

namespace RoutesMNG {

    use language\Serverlanguage;
    use Phroute\Phroute\Dispatcher;
    use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
    use Phroute\Phroute\Exception\HttpRouteNotFoundException;
    use Phroute\Phroute\RouteCollector;

    use routesComposite\Route;

    use ServerMNG\serverMessage;
    use WebpageMNG\Page;


    final class RouteManager
    {
        private $routeMessageAfterExecuted;
        private RouteCollector $routeManager;
        private static ?RouteManager $instance = null;
        protected array $routesList = [];
        protected Page $defaultPage;

        private bool $executed;

        public function __construct()
        {
            $this->routeManager = new RouteCollector();
            $this->executed = false;
        }

        public function getRouteResponse(){
            if($this->executed) {
                return $this->routeMessageAfterExecuted;
            }
            return "Route doesnt has content";

        }


        public function getDefaultPage(){
            return $this->defaultPage;
        }
        public function setDefaultPage(Page $defaultPage){
            $this->defaultPage = $defaultPage;
        }
        public function getActivePage()
        {
             $activePage = array_filter($this->routesList, fn(Route $index) => $index->getPage()->isActive());

            if(!empty($activePage)){
                return  array_shift($activePage)->getPage();
            }

            $this->getDefaultPage()->setActivePage();
            return  $this->getDefaultPage();


        }
        public function initializeRoute(array $array,Page $defaultPage):void
        {
            $this->setDefaultPage($defaultPage);
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
            echo Serverlanguage::getInstance()->importandServerMessage("route.map");
            foreach ($this->routesList as $index) {
                echo $index . PHP_EOL;
            }
            echo PHP_EOL;
        }

        public function executeRoute(): void
        {
            $requestMETHOD = $_SERVER['REQUEST_METHOD'];
            $requestURI = $_SERVER['REQUEST_URI'];
            try {
                $dispatcher = new Dispatcher($this->routeManager->getData());
              $this->routeMessageAfterExecuted =   $dispatcher->dispatch($requestMETHOD, parse_url($requestURI)["path"]);
              $this->executed = true;
            } catch (HttpRouteNotFoundException  $e) {
                $this->routeMessageAfterExecuted = ["info"=>"Page doesnt exist"];
            } catch (HttpMethodNotAllowedException $e) {

                $this->routeMessageAfterExecuted = ["Info"=>"Method {$requestMETHOD} isn't allowed to this route"];
            }
        }


    }


}