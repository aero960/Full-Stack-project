<?php


use authentication\Authentication;

abstract class Item
{
    private string $name;
    private  $value;
    public function __construct(string $name, $item)
    {
        $this->value = $item;
        $this->name = $name;
    }
    function getValue()
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }
    abstract public function checkValidOwner();
    abstract  public function checkItemExist();



}
class PostItem extends Item {


    public function checkValidOwner()
    {
        return   (new OwnerShortcut(Authentication::getInstance()->getCurrentyUser()->getId(),$this->getValue()))->action();
    }

    public function checkItemExist()
    {

        return (new ItemExistShortcut($this->getValue()))->action();
    }
}