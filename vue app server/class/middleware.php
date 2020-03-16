<?php

namespace RoutesMNG {

    use http\Exception as ExceptionAlias;
    use Phroute\Phroute\Dispatcher;
    use Phroute\Phroute\Exception\HttpRouteNotFoundException;
    use Phroute\Phroute\RouteCollector;
    use ServerMNG\serverMessage;
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
        private RouteCollector $routeManager;
        public function __construct(string $method, string $path)
        {
            $this->method = $method;
            $this->path = $path;
        }
        // wyswietlanie czynnosci zachodzacych w danym rout
        public function action()
        {
            return $this->getData();
        }
        public function getData()
        {
        return (object)["method"=>$this->method,"path"=>$this->path];
        }
        public function __toString()
        {
            return "{$this->method}:{$this->path}";
        }
    }

    class ManipulateRoute extends Route
    {

        private Page $page;
        private array $params;

        public function __construct(string $method, string $path, Page $page)
        {
            parent::__construct($method, $path);
            $this->page = $page;
        }

        public function action()
        {
            parent::action();
            $this->params = func_get_args();
            return $this->page->getContext();

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
            echo "<pre>";
            foreach ($this->routesList as $index) {
                echo $index;
            }
            echo "</pre>";
        }



    }
   final class RouteAdministrator extends RouteManager{

        private RouteCollector $routeManager;

        public function __construct()
        {
            $this->routeManager = new RouteCollector();
        }

        public function initializeRoute(array $array)
        {
            parent::initializeRoute($array);

            foreach ($this->routesList as $index ){
                call_user_func_array(
                    array($this->routeManager, strtolower($index->getData()->method)),
                    array( $index->getData()->path, [$index, 'action']));
            };

           //
        }
       public function executeRoute(string $requestMETHOD, string $requestURI)
       {
           try{
              $dispatcher =  new Dispatcher($this->routeManager->getData());
              return  serverMessage::send($dispatcher->dispatch($requestMETHOD,parse_url($requestURI, PHP_URL_PATH)));
           }catch(HttpRouteNotFoundException  $e){
               header($e->getMessage());
               return serverMessage::send("Sorry cannot search specific route");
           }
       }

   }
}