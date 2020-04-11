<?php


namespace WebpageMNG;


use authentication\Authentication;
use Error;
use Exception;
use Item;
use language\Serverlanguage;
use OutputController;
use PageParametersSchema;
use RoutesMNG\Parameters;
use ValidateParameters;
use ViewQuery;

interface Fabric
{
    public function getContext();
}

interface FabricActioner
{
    public function getValues(string $name);

    public function getAction();
}

interface ElementInterface
{
    public function setActiveElement();

    public function isActive();
}

abstract class Element implements ElementInterface, Fabric
{
    protected $context;
    protected bool $active;
    protected ViewQuery $outputController;

    abstract protected function createContext();

    public function ExtensionData()
    {
    }

    public function __construct()
    {
        $this->active = false;
        $this->outputController = new OutputController();

    }

    public function setActiveElement()
    {
        $this->active = true;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function getContext()
    {
        $this->createContext();
        return $this->context;
    }

    private array $items = [];

    public function getActualItem($name): Item
    {
        foreach ($this->items as $index) {
            if ($index->getName() == $name) {
                return $index;
            }
        }
    }

    public function addActualItem(Item $actualItem)
    {
        $this->items[] = $actualItem;
    }

}

abstract class Page extends Element
{
    protected ValidateParameters $parameters;

    protected function Initialize(): void
    {
    }

    protected function pageContent()
    {
    //  try {
            $this->Initialize();
            return $this->outputController->getView();
  /*  } catch (Error $e) {
            $this->outputController->setDataSuccess(false);
            $this->outputController->setInfo(Serverlanguage::getInstance()->GetMessage("u.e"));
            return $this->outputController->getView();
        }*/
    }


    public function checkValidParameters()
    {
        return $this->parameters->checkValidParameters();
    }

    protected function createContext()
    {

        if ($this->isActive()) {
            $this->context = $this->pageContent();
        }
    }


}

