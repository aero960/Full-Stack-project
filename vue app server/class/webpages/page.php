<?php


namespace WebpageMNG;


use authentication\Authentication;
use Exception;
use Item;
use PageParametersSchema;
use RoutesMNG\Parameters;
use ValidateParameters;

interface Fabric{
    public function getContext();
    }
interface ElementInterface {
    public function setActiveElement();
    public function isActive();
}

abstract class Element implements ElementInterface,Fabric{
    protected $context;
    protected bool $active;

    abstract protected function createContext();
     public function ExtensionData(){}
    public function __construct()
    {
        $this->active = false;
    }
    public function setActiveElement(){
        $this->active = true;
    }

    public function isActive()
    {
        return $this->active;
    }
    public function getContext(){
        $this->createContext();
        return $this->context;
    }
}

abstract class Page extends Element
{
    protected ValidateParameters $parameters;
    private array $items = [];
    public function getActualItem($name): Item
    {
       foreach($this->items as $index){
           if($index->getName() == $name){
               return $index;
           }
       }
    }
    public function addActualItem(Item $actualItem)
    {
       $this->items[] = $actualItem;
    }
    abstract protected function pageContent();
    abstract protected function Initialize() :void;

    public function checkValidParameters(){
        return $this->parameters->checkValidParameters();
    }

    protected function createContext()
    {
        if ($this->isActive()) {
            $this->context = $this->pageContent();
        }
    }




}

