<?php

namespace RoutesMNG {

    use Iterator;
    use language\Serverlanguage;
    use Phroute\Phroute\Dispatcher;
    use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
    use Phroute\Phroute\Exception\HttpRouteNotFoundException;
    use Phroute\Phroute\RouteCollector;
    use routesComposite\Route;
    use WebpageMNG\Element;


    interface RouteManagerCompatible
    {
        public function getActivePage();

        public function mapRoute();
    }

    abstract class RouteListIterator implements Iterator, RouteManagerCompatible
    {}

    class RouteListManagment extends RouteListIterator
    {
        private array $routesList = [];
        private int $position = 0;
        public function __construct(array $routesList)
        {
            foreach($routesList as $index){
                if (!($index instanceof Route))
                    throw new \Exception(Serverlanguage::getInstance()->importandServerMessage("route.require"));
            }

            $this->routesList = $routesList;
        }
        public function current()
        {
            return $this->routesList[$this->position];
        }
        public function next()
        {
            ++$this->position;
        }
        public function key()
        {
            return $this->position;
        }
        public function valid()
        {
            return isset($this->routesList[$this->position]);

        }
        public function rewind()
        {
            $this->position = 0;
        }
        public function getActivePage()
        {
            $activePage = array_filter($this->routesList, fn(Route $index) => $index->isAcitveElement());
            if (!empty($activePage)) {
                return array_shift($activePage)->getElement();
            }
            return null;
        }
        public function mapRoute()
        {
            echo Serverlanguage::getInstance()->importandServerMessage("route.map");
            foreach ($this->routesList as $index) {
                echo $index . PHP_EOL;
            }
            echo PHP_EOL;
        }
    }

    final class RouteManager
    {
        private $routeMessageAfterExecuted;
        private RouteCollector $routeManager;
        private static ?RouteManager $instance = null;
        //podstawowy problem
        protected RouteListIterator $routesList;
        protected Element $defaultPage;
        private bool $executed;

        public function __construct()
        {
            $this->routeManager = new RouteCollector();
            $this->executed = false;
        }

        public function getRouteResponse()
        {
            if ($this->executed) {
                return $this->routeMessageAfterExecuted;
            }
            return "Route doesnt has content";
        }


        public function getDefaultPage(): Element
        {
            return $this->defaultPage;
        }

        public function setDefaultPage(Element $defaultPage)
        {
            $this->defaultPage = $defaultPage;
        }
        public function getActivePage() : Element
        {
            $this->getDefaultPage()->setActiveElement();
            return ($this->routesList->getActivePage()) ? $this->routesList->getActivePage() : $this->getDefaultPage();
        }
        public function initializeRoute(RouteListIterator $routeList, Element $defaultPage): void
        {
            $this->setDefaultPage($defaultPage);
            $this->routesList = $routeList;
            foreach ($this->routesList as $index)
                $index->setPermission($this->routeManager);
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
                $this->routeMessageAfterExecuted = $dispatcher->dispatch($requestMETHOD, parse_url($requestURI)["path"],PHP_URL_PATH);
                $this->executed = true;
            } catch (HttpRouteNotFoundException  $e) {
                $this->routeMessageAfterExecuted = ["info" => "Page doesnt exist"];
            } catch (HttpMethodNotAllowedException $e) {
                $this->routeMessageAfterExecuted = ["Info" => "Method {$requestMETHOD} isn't allowed to this route"];
            }
        }


    }


}